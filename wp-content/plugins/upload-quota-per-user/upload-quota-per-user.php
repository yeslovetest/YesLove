<?php
/*
Plugin Name: Upload Quota per User
Description: Limits the total space a user can use uploading files and changes single file upload size.
Version: 1.3
Author: Cristian Dinu-Tănase, Daniyal Ahmed
Author URI: http://www.cristiandt.ro
*/

$uqpu_version='1.1';

define('UQPU_FOLDER', basename(dirname(__FILE__)));
define('UQPU_ABSPATH', trailingslashit(str_replace('\\', '/', WP_PLUGIN_DIR.'/'.UQPU_FOLDER)));
define('UQPU_URLPATH', trailingslashit(plugins_url(UQPU_FOLDER)));

require_once(ABSPATH . "wp-includes/pluggable.php");
require_once(UQPU_ABSPATH."/admin.php");

add_action('admin_init', 'uqpu_admin_settings');
function uqpu_admin_settings(){
	register_setting('uqpu-settings-group', 'uqpu_version');
	register_setting('uqpu-settings-group', 'uqpu_disk_space');
	register_setting('uqpu-settings-group', 'uqpu_single_file_size');
	register_setting('uqpu-settings-group', 'uqpu_roles');
	register_setting('uqpu-settings-group', 'uqpu_capabilities');
}

load_plugin_textdomain('upload-quota-per-user', "", UQPU_FOLDER.'/lang');
register_activation_hook(UQPU_ABSPATH.'upload-quota-per-user.php', 'uqpu_activate');
register_deactivation_hook(UQPU_ABSPATH.'upload-quota-per-user.php', 'uqpu_deactivate');
if ($uqpu_version != get_option('uqpu_version')) {
	update_option('uqpu_version', $uqpu_version);
	add_option('uqpu_single_file_size', 10);
}

function uqpu_activate() {
	populate_database();
	add_option('uqpu_version', $uqpu_version);
	add_option('uqpu_disk_space', 50);
	add_option('uqpu_single_file_size', 10);
	add_option('uqpu_roles', '');
	add_option('uqpu_capabilities', '');
}
function uqpu_deactivate() {
	empty_database();
	delete_option('uqpu_version');
	delete_option('uqpu_disk_space');
	delete_option('uqpu_single_file_size');
	delete_option('uqpu_roles');
	delete_option('uqpu_capabilities');
}

function populate_database() {
    global $wpdb;
    
    $users = $wpdb->get_results("SELECT DISTINCT post_author FROM {$wpdb->posts} WHERE post_type = 'attachment'");
    
    foreach ($users as $user) {
        $user_id = $user->post_author;
        $attachments = $wpdb->get_results($wpdb->prepare("SELECT ID, post_mime_type, guid, post_parent FROM {$wpdb->posts} WHERE post_type = 'attachment' AND post_author = %d", $user_id));

        $total_space = 0;
        foreach ($attachments as $attachment) {
            $file_path = get_attached_file($attachment->ID);
            $file_size = filesize($file_path);

            $total_space += $file_size;
        }

        update_user_meta($user_id, 'uqpu_upload_space', $total_space);
    }
}

function empty_database() {
	$attachments = get_posts(array('post_type' => 'attachment', 'posts_per_page' => -1, 'post_status' => 'any', 'post_parent' => null));
	foreach ($attachments as $attachment) delete_user_meta( $attachment->post_author, 'uqpu_upload_space' );
}

$sizeLimit = 1024*1024*get_option('uqpu_disk_space');
$passCapab=FALSE;
$uqpu_roles = get_option('uqpu_roles');
if ($uqpu_roles && is_array($uqpu_roles)) {
    foreach ($uqpu_roles as $role) {
        if (current_user_can($role)) {
            $passCapab = TRUE;
            break;
        }
    }
}

if (get_option('uqpu_capabilities')) {
	$capabilities = explode(',', get_option('uqpu_capabilities'));
	foreach ($capabilities as $capab) if(current_user_can($capab)) $passCapab=TRUE;
}

add_filter( 'upload_size_limit', 'uqpu_max_upload_size' );
function uqpu_max_upload_size($size) { if(get_option('uqpu_single_file_size')) return 1024*1024*get_option('uqpu_single_file_size'); else return 1024*1024*64; }

function human_filesize($size,$unit="") {
  if( (!$unit && $size >= 1<<30) || $unit == "GB") return number_format($size/(1<<30),2)." GB";
  if( (!$unit && $size >= 1<<20) || $unit == "MB") return number_format($size/(1<<20),2)." MB";
  if( (!$unit && $size >= 1<<10) || $unit == "KB") return number_format($size/(1<<10),2)." KB";
  return number_format($size)." bytes";
}

if(!$passCapab) {
//------ Before Uploading  ------//
	add_filter( 'wp_handle_upload_prefilter', 'uqpu_before_uploading' );
	function uqpu_before_uploading( $file ) {
		global $sizeLimit;

		$user_id = get_current_user_id();
		$uqpu_upload_space = get_user_meta( $user_id, 'uqpu_upload_space', $single = true );
		$filesize = $file['size'];

		if (($filesize+$uqpu_upload_space)>$sizeLimit) $uqpu_upload_space_limit_reached = true;
		else $uqpu_upload_space_limit_reached = false;

		if ( $uqpu_upload_space_limit_reached )	$file['error'] = __('You reached the limit of', 'upload-quota-per-user').' '.human_filesize($sizeLimit);

		return $file;
	}
}

//------ After Uploading, modified database  ------//
add_filter( 'wp_handle_upload', 'uqpu_after_uploading' );
function uqpu_after_uploading( $args ) {
	$user_id = get_current_user_id();
	$size = filesize( $args['file'] );
	$uqpu_upload_space = get_user_meta( $user_id, 'uqpu_upload_space', $single = true );

	if ($uqpu_upload_space) update_user_meta( $user_id, 'uqpu_upload_space', $uqpu_upload_space + $size );
	return $args;
}

//------ At Attachment delete  ------//
add_action('delete_attachment', 'uqpu_at_delete');
function uqpu_at_delete($id) {
	$user_id = get_post($id, ARRAY_A);
	$user_id = $user_id['post_author'];
	$size = filesize( get_attached_file($id) );
	$uqpu_upload_space = get_user_meta( $user_id, 'uqpu_upload_space', $single = true );
	$updateSize = $uqpu_upload_space - $size;
	if($updateSize<=0) $updateSize = 0;

	if ($uqpu_upload_space) update_user_meta( $user_id, 'uqpu_upload_space', $updateSize );
}

//------ Show used space in Media Library  ------//
add_filter( 'views_upload', 'uqpu_media_show_quota', 10, 1 );
function uqpu_media_show_quota( $views ) {
	global $sizeLimit;
	global $passCapab;
	$spatiuFolosit = get_user_meta( get_current_user_id(), 'uqpu_upload_space', $single = true );
	if (!$spatiuFolosit) $spatiuFolosit = 0;
	$procent = $spatiuFolosit/$sizeLimit*100;
	if($passCapab) $sizeLimit='&infin;'; else $sizeLimit = human_filesize($sizeLimit);
	if($passCapab) $procent = ''; else $procent = ' ('.number_format((float)$procent, 2, '.', '').'%)';
	$views['separator'] = __('Used Space:', 'upload-quota-per-user').' <strong>'.human_filesize($spatiuFolosit).' / '.$sizeLimit.'</strong>'.$procent;
	return $views;
}

?>
