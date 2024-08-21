<?php


function wppcp_add_query_string($link, $query_str) {

    $build_url = $link;

    $query_comp = explode('&', $query_str);

    foreach ($query_comp as $param) {
        $params = explode('=', $param);
        $key = isset($params[0]) ? sanitize_text_field($params[0]) : '';
        $value = isset($params[1]) ? sanitize_text_field($params[1]) : '';
        $build_url = esc_url_raw(add_query_arg($key, $value, $build_url));
    }

    return $build_url;
}


function wppcp_display_pro_block(){
    $display = '<div class="wppcp_donation_box">
                <div style="    float: left;
    width: 80%;
    line-height: 25px;">This feature is only available in PRO version. You can check more about these features at <a style="color:#FFF;" href="https://www.wpexpertdeveloper.com/wp-private-content-pro/">'.__('WPExpert Developer','wppcp').'</a></div>
                
                
                <div style="clear:both"></div>
                </div>';
    return $display;
}


function wppcp_current_page_url() {
  $url  = @( $_SERVER["HTTPS"] != 'on' ) ? sanitize_url('http://'.$_SERVER["SERVER_NAME"]) :  sanitize_url('https://'.$_SERVER["SERVER_NAME"]);
  $url .= sanitize_url( $_SERVER["REQUEST_URI"] );
  return $url;
}




function wppcp_display_pro_info_box($message,$location,$settings_path) {

    $locations = array('post_meta_boxes' => 'httpa://www.wpexpertdeveloper.com/wp-private-content-pro/#post_meta_box','post_meta_boxes_large' => 'https://www.wpexpertdeveloper.com/wp-private-content-pro/#post_meta_box');
    $style = '';
    if($location == 'post_meta_boxes_large'){
        $style = 'height:120px !important;padding: 25px 20px !important;';
    }

    $settings_path = admin_url( 'admin.php?page=wppcp-settings&tab=wppcp_section_information#' ) . $settings_path;
    $display = '<div class="wppcp-pro-info-box">
                    <div class="wppcp-pro-info-box-col1" >
                        <img src="'.WPPCP_PLUGIN_URL.'images/icon-128x128.png" /></div>
                    <div class="wppcp-pro-info-box-col2">'.$message.'</div>
                    <div class="wppcp-pro-info-box-col3" style="'.$style.'">
                        <a href="'. esc_url($locations[$location]) .'" class="wppcp-pro-info-notice button-primary" target="_blank">
                        '. __('Go PRO License','wppcp') .'</a>
                        <a href="'.esc_url($settings_path).'" style="margin-top:10px;" class="wppcp-pro-info-notice button-primary">
                        '. __('Hide Info','wppcp') .'</a>
                    </div>
                    <div class="wppcp-clear"></div>
                </div>';
    return $display;
}


function wppcp_display_pro_sidebar_info_box() {

    $tick_url = WPPCP_PLUGIN_URL. 'images/tick.png';

    $display = '<div id="wppcp-pro-version-sidebar-panel">
                    <div id="wppcp-pro-version-sidebar-header">
                        '. __('Why Go PRO License?','wppcp').'
                    </div>
                    <div id="wppcp-pro-version-sidebar-features">
                        <ul>
                            <li><img src="'.esc_url($tick_url).'" /><span>'. __('Membership Level Management','wppcp').'</span></li>
                            <li><img src="'.esc_url($tick_url).'" /><span>'. __('Sell Memberships with Woocommerce','wppcp').'</span></li>
                            <li><img src="'.esc_url($tick_url).'" /><span>'. __('Private Page Discussions','wppcp').'</span></li>
                            <li><img src="'.esc_url($tick_url).'" /><span>'. __('Private Page File Sharing','wppcp').'</span></li>
                            <li><img src="'.esc_url($tick_url).'" /><span>'. __('Mailchimp Content Locker','wppcp').'</span></li>
                            <li><img src="'.esc_url($tick_url).'" /><span>'. __('Awesome Frontend User Groups','wppcp').'</span></li>
                            <li><img src="'.esc_url($tick_url).'" /><span>'. __('Woocommerce Product Protection','wppcp').'</span></li>
                            <li><img src="'.esc_url($tick_url).'" /><span>'. __('bbPress Forums and Topics Protection','wppcp').'</span></li>
                            <li><img src="'.esc_url($tick_url).'" /><span>'. __('Advanced Search Restrictions','wppcp').'</span></li>
                            <li><img src="'.esc_url($tick_url).'" /><span>'. __('Complete Protection for Post Attachments','wppcp').'</span></li>
                        </ul>
                    </div>
                    <div id="wppcp-pro-version-sidebar-buy">
                        <a class="wppcp-upgrading-pro-button" style="margin:10px auto" href="https://www.wpexpertdeveloper.com/wp-private-content-pro/#post_meta_box">'. __('Upgrade to PRO License','wppcp').'</a>
                    </div>
                </div>';
    return $display;
}




function wppcp_addons_feed() {
    global $wppcp,$wppcp_addon_template_data;

    $wppcp_addon_template_data['active_plugins'] = get_option('active_plugins');
    
        $addons = '{"featured":[{"title":"WPPCP Frontend Login","desc":"<div style=\'height:60px !important;\'><p>Add elegant frontend login form to let users login to your site and get access to restricted content and private page.</p></div>","image":"'.WPPCP_PLUGIN_URL. 'images/docs/frontend-login.png","type":"Premium","name":"wppcp-frontend-login/wppcp-frontend-login.php","download":"https://www.wpexpertdeveloper.com/wppcp-frontend-login-addon"},{"title":"WPPCP Taxonomy Restrictions","desc":"<div style=\'height:60px !important;\'><p>Restrict posts/custom post types from specific custom taxonomy to guests/ members/ user roles.</p></div>","image":"'.WPPCP_PLUGIN_URL . 'images/docs/taxonomy-restrictions.png","type":"Premium","name":"wppcp-taxonomy-restrictions/wppcp-taxonomy-restrictions.php","download":"https://www.wpexpertdeveloper.com/wppcp-taxonomy-restrictions-addon/"},{"title":"WPPCP Tag Restrictions","desc":"<div style=\'height:60px !important;\'><p>Restrict posts/custom post types from specific post tags to guests/ members/ user roles</p></div>","image":"'.WPPCP_PLUGIN_URL.'images/docs/tag-restrictions.png","type":"Premium","name":"wppcp-tag-restrictions/wppcp-tag-restrictions.php","download":"https://www.wpexpertdeveloper.com/wppcp-tag-restrictions-addon/"},{"title":"WPPCP Category Restrictions","desc":"<div style=\'height:60px !important;\'><p>Restrict posts/custom post types from specific categories to guests/ members/ user roles.</p></div>","image":"'.WPPCP_PLUGIN_URL.'images/docs/category-restrictions-1.png","type":"Premium","name":"wppcp-category-restrictions/wppcp-category-restrictions.php","download":"https://www.wpexpertdeveloper.com/wppcp-category-restrictions-addon/"}]}';

        $addons = json_decode( $addons );
        $addons = $addons->featured;            

    
    $wppcp_addon_template_data['addons'] = $addons;
    
    $wppcp->template_loader->get_template_part('addons','feed');

}



function wppcp_info_button_labels(){
    $labels = array();
    $labels['help'] = apply_filters('wppcp_info_button_label_help', __('Help', 'wppcp'));
    $labels['docs'] = apply_filters('wppcp_info_button_label_docs', __('Documentation', 'wppcp'));

    $labels['help_link'] = apply_filters('wppcp_info_button_help_link', "https://www.wpexpertdeveloper.com/support/");

    
    return $labels;
}



function wppcp_display_info_buttons($url,$type){

    ob_start();
    $info_button_data = wppcp_info_button_labels();
?>

    <div class="wppcp-post-meta-info-buttons">
        <a target="_blank" href="<?php echo esc_attr($info_button_data['help_link']); ?>?ref=<?php echo esc_attr($type); ?>">
            <div class="wppcp-post-meta-info-button wppcp-post-meta-info-help">
                <span class="dashicons dashicons-editor-help"></span>
                <?php echo wp_kses_post($info_button_data['help']); ?></div>
        </a>
        <a target="_blank" href="<?php echo esc_url($url); ?>?ref=<?php echo esc_attr($type); ?>" >
            <div class="wppcp-post-meta-info-button wppcp-post-meta-info-docs">
            <span class="dashicons  dashicons-book-alt"></span>
            <?php echo wp_kses_post($info_button_data['docs']); ?></div>
        </a>
    </div>
    <div class="wppcp-clear"></div>

<?php 
    $display = ob_get_clean();
    return wp_kses_post($display);
}



function wppcp_get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function wppcp_admin_templates_allowed_html(){
    $allowed_html = array(
            'div' => array( 'class' => array(), 'id' => array(), 'style' => array(), 'type' => array() ),
            'h2' => array( 'class' => array() ),
            'p' => array( 'class' => array()),
            'strong' => array( ),
            'br' => array( ),
            'a' => array( 'class' => array(),'href' => array() ),
            'span' => array( 'class' => array() ),
            'img' => array( 'src' => array(), 'class' => array() , 'style' => array() ),
            'select' => array( 'data-group-id' => array(), 'class' => array(), 'style' => array(), 'placeholder' => array(), 'name' => array(),            'id' => array(), 'selected' => array(),'multiple' => array(),
            ),
            'input' => array( 'type' => array(), 'name' => array(), 'value' => array(),'id' => array(),'class' => array(), 'checked' => array() ),
            'form' => array( 'method' => array(), 'action' => array(), 'class' => array() ),
            'table' => array( 'class' => array() ),
            'th' => array( 'class' => array(),'style' => array(),'colspan' => array() ),
            'td' => array( 'class' => array(),'style' => array() ),
            'tr' => array( 'class' => array(),'style' => array() ),
            'label' => array(),'ul' => array( 'id' =>  array() , 'class' =>  array()),'li' => array( 'id' =>  array() , 'class' =>  array(), 'data-role' =>  array() ),
            'textarea' => array( 'name' => array() , 'class' => array() ),    
            'option' => array( 'value' => array() , 'selected' => array() ),          
        );

    return $allowed_html;
}

