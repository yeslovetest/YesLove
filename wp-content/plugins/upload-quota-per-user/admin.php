<?php
add_action('admin_menu', 'upload_quota_per_user_menus');
function upload_quota_per_user_menus()
{
    add_media_page('Upload Quota per User Settings', 'Upload Quota', 'manage_options', 'upload-quota-per-user', 'upload_quota_per_user_settings');
}

/** Step 3. */
function upload_quota_per_user_settings()
{
    if (!current_user_can('manage_options'))
        wp_die(__('You do not have sufficient permissions to access this page.'));
?>

<div class="wrap">
	<?php
    screen_icon();
?>
	<h2><?php
    _e('Upload Quota per User Settings', 'upload-quota-per-user');
?></h2>
	<?php
    if ($_GET['settings-updated'] == 'true') {
?> <div id="setting-error-settings_updated" class="updated settings-error"><p><strong><?php
        _e('Settings saved.');
?></strong></p></div><?php
    }
?>
	<form method="post" action="options.php">
		<?php
    settings_fields('uqpu-settings-group');
?>
		<?php
    do_settings_fields('uqpu-settings-group', "");
?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php
    _e('Restriction Settings', 'upload-quota-per-user');
?></th>
				<td>
					<fieldset>
						<label for="uqpu_disk_space">
							<input type="text" name="uqpu_disk_space" value="<?php
    echo get_option('uqpu_disk_space');
?>"/>
							<?php
    _e('Disk Space Limit', 'upload-quota-per-user');
    echo ' (MB)';
?>
						</label>
					</fieldset>
					<fieldset>
						<label for="uqpu_single_file_size">
							<input type="text" name="uqpu_single_file_size" value="<?php
    echo get_option('uqpu_single_file_size');
?>"/>
							<?php
    _e('Single File Size Limit', 'upload-quota-per-user');
    echo ' (MB)';
?>
						</label>
					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php
    _e('Users not affected by restriction', 'upload-quota-per-user');
?></th>
				<td>
					<fieldset>
						<label for="uqpu_roles">
				<?php

    global $wp_roles;
    $roles = $wp_roles->get_names();

?>
							<select name="uqpu_roles[]" multiple>
							<?php
    global $wp_roles;
    $roles = $wp_roles->get_names();

    foreach ($roles as $slug => $role) {
        $rec = get_option('uqpu_roles');
        if ($rec) {
            if (array_filter(get_option('uqpu_roles'))) {
                if (in_array($slug, get_option('uqpu_roles')))
                    $selected = 'selected';
                else
                    $selected = '';
            }
        }
        echo '<option value="' . $slug . '" ' . $selected . '>' . $role . '</option>';


    }
?>
							</select>
							<?php
    _e('User Roles (CTRL+Click for multiple selection)', 'upload-quota-per-user');
?>
						</label>
					</fieldset>
					<fieldset>
						<label for="uqpu_capabilities">
							<input type="text" name="uqpu_capabilities" value="<?php
    echo get_option('uqpu_capabilities');
?>"/>
							<?php
    _e('Custom Capabilities separated by comma (",")', 'upload-quota-per-user');
?>
						</label>
					</fieldset>
				</td>
			</tr>
		</table>
		<?php
    submit_button();
?>
	</form>
</div>




<?php
}
?>
