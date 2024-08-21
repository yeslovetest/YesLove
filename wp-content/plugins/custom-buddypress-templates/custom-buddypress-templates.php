<?php

/*
Plugin Name: Custom BuddyPress Templates
Description: Overrides BuddyPress and template-parts templates
Version: 1.0.1
Author: Robert June
Author URI: https://lancedesk.com
*/

// No direct access to this file

if (!defined('ABSPATH')) {
    exit;
}

// Load custom BuddyPress and template-parts templates

function custom_templates_load($template) {

    // Check if BuddyPress is active
    if (class_exists('BuddyPress')) {
        $buddypress_dir = plugin_dir_path(__FILE__) . 'buddypress/';

    // Override BuddyPress templates

        add_filter('bp_get_template_stack', function ($templates) use ($buddypress_dir) {
            array_unshift($templates, $buddypress_dir);
            return $templates;
        });

    }
    return $template;
}

add_filter('template_include', 'custom_templates_load');


//Display professional fields on user profile
function display_custom_profile_fields() {
    if ( bp_is_user() ) {
        $user_id = bp_displayed_user_id();
        
        // Retrieve profile field values
        $field_values = array();
        $group_id = 6;
        $field_ids = array(40, 41, 42, 64, 85);
        
        foreach ( $field_ids as $field_id ) {
            $field_value = xprofile_get_field_data( $field_id, $user_id );
            
            if ( ! empty( $field_value ) ) {
                if ( is_array( $field_value ) ) {
                    $field_value = implode( ', ', $field_value );
                }
                
                $field_values[ $field_id ] = $field_value;
            }
        }
        
        // Display profile field values
        if ( ! empty( $field_values ) ) {
            echo '<div class="profile-field-values">';
            
            foreach ( $field_values as $field_id => $field_value ) {
                echo '<p><strong>' . xprofile_get_field( $field_id )->name . ':</strong> ' . $field_value . '</p>';
            }
            
            echo '</div>';
        }
        
        do_action( 'bp_member_profile-message' );
    }
}
add_action( 'bp_member_profile-sidebar', 'display_custom_profile_fields' );

// Display message widget on user profile
function display_get_in_touch_button() {
    if ( is_user_logged_in() && !bp_is_my_profile()) {
        $recipient_username = bp_core_get_username( bp_displayed_user_id() );
        $current_username = bp_core_get_username( get_current_user_id() );
        $current_user_id = bp_loggedin_user_id();

        $button_label = 'Get in touch';

        if ( bp_is_active( 'messages' ) ) {           
            $button_url = bp_core_get_user_domain( $current_username ) . $current_username . '/messages/compose/?r=' . $recipient_username;
            
        } else {
            $button_url = '';
        }

        if ( ! empty( $button_url ) ) {
            echo '<a class="get-in-touch-button" href="' . esc_url( $button_url ) . '">' . esc_html( $button_label ) . '</a>';
        }
    } else if ( bp_is_active( 'messages' ) && ! is_user_logged_in() ) {
        $login_url = 'https://yeslove.co.uk/login';
        $recipient_name = ucfirst( bp_get_displayed_user_fullname() );
        echo 'Please <a href="' . esc_url( $login_url ) . '">login</a> to message ' . esc_html( $recipient_name );
    }
}
add_action( 'bp_member_profile-message', 'display_get_in_touch_button' );

// Add select dropdown of BuddyPress member types to registration form
function add_member_type_field() {
    $member_types = bp_get_member_types(array(), 'objects');

    if (!empty($member_types)) {
        ?>
        <div class="form-group">
            <select name="user_member_type" id="user_member_type" class="select2-search" required>
                <option value=""><?php esc_html_e('Select member type', 'text-domain'); ?></option>
                <?php foreach ($member_types as $key => $member_type) : ?>
                    <option value="<?php echo esc_attr($key); ?>"><?php echo esc_html($member_type->labels['singular_name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php
    }
}
add_action('bp_account_details_fields', 'add_member_type_field');

// Submit the member type to database on registration
add_action('user_register', 'set_member_type_on_registration', 10, 1);

function set_member_type_on_registration($user_id) {
    // Get the selected member type from the registration form
    $selected_member_type = isset($_POST['user_member_type']) ? sanitize_text_field($_POST['user_member_type']) : '';

    // Set the member type for the registered user
    if (!empty($selected_member_type)) {
        bp_set_member_type($user_id, $selected_member_type);
    }
}

// Submit the user full name to database on registration
add_action('user_register', 'save_full_name_on_registration', 10, 1);

function save_full_name_on_registration($user_id) {
    // Get the full name from the registration form
    $full_name = isset($_POST['user_fullname']) ? sanitize_text_field($_POST['user_fullname']) : '';

    // Separate the full name into first name and last name
    $name_parts = explode(' ', $full_name);
    $first_name = isset($name_parts[0]) ? $name_parts[0] : '';
    $last_name = isset($name_parts[1]) ? $name_parts[1] : '';

    // Update the user's first name, last name, and display name
    $user_data = array(
        'ID'           => $user_id,
        'first_name'   => $first_name,
        'last_name'    => $last_name,
        'display_name' => $full_name,
    );
    wp_update_user($user_data);
}

// Add sub-menu under Settings
function add_buddypress_templates_submenu()
{
    add_submenu_page(
        'options-general.php', // Parent menu slug
        'BuddyPress Templates', // Page title
        'BuddyPress Templates', // Menu title
        'manage_options', // Capability
        'buddypress-templates', // Menu slug
        'buddypress_templates_page' // Callback function
    );
}
add_action('admin_menu', 'add_buddypress_templates_submenu');

// Callback function for BuddyPress Templates page
function buddypress_templates_page()
{
    if (!current_user_can('manage_options')) {
        return;
    }

    if (isset($_POST['buddypress_templates_listing_option'])) {
        update_option('buddypress_templates_listing_option', $_POST['buddypress_templates_listing_option']);
    }
    ?>
    <div class="wrap">
        <h1>BuddyPress Templates</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('buddypress_templates_options');
            do_settings_sections('buddypress_templates_options');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register settings and fields
function buddypress_templates_register_settings()
{
    // Register a settings group
    register_setting(
        'buddypress_templates_options', // Option group
        'buddypress_templates_listing_option', // Option name
        array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default' => 'all_members',
        )
    );

    // Add a section for the listing options
    add_settings_section(
        'buddypress_templates_listing_section', // Section ID
        'Member Listing Options', // Section title
        'buddypress_templates_listing_section_callback', // Callback function
        'buddypress_templates_options' // Page slug
    );

    // Add fields for listing options
    add_settings_field(
        'buddypress_templates_listing_option', // Field ID
        'Listing Option', // Field title
        'buddypress_templates_listing_option_callback', // Callback function
        'buddypress_templates_options', // Page slug
        'buddypress_templates_listing_section', // Section ID
        array(
            'label_for' => 'buddypress_templates_listing_option',
        )
    );
}
add_action('admin_init', 'buddypress_templates_register_settings');

// Callback function for listing section
function buddypress_templates_listing_section_callback()
{
    echo '<p>Select the member listing option:</p>';
}

// Callback function for listing option field
function buddypress_templates_listing_option_callback($args)
{
    $option_value = get_option('buddypress_templates_listing_option', 'all_members');
    ?>
    <select name="<?php echo esc_attr($args['label_for']); ?>" id="<?php echo esc_attr($args['label_for']); ?>">
        <option value="all_members" <?php selected($option_value, 'all_members'); ?>>All Members</option>
        <option value="professionals_only" <?php selected($option_value, 'professionals_only'); ?>>All Professionals</option>
        <option value="verified_professionals" <?php selected($option_value, 'verified_professionals'); ?>>Verified Professionals</option>
    </select>
    <?php
}