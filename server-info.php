<?php
/**
 * Plugin Name: Server Info for Debugging
 * Description: Displays server stats and system information for debugging.
 * Author URI: https://blendmedia.ca/wordpress-server-info-for-debugging-plugin
 * Version: 1.1.4
 * Author: Blend Media
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Hook into the admin menu to create a new menu item
add_action('admin_menu', 'ezsi_add_menu');

function ezsi_add_menu() {
    add_menu_page(
        'Server Stats',
        'Server Stats',
        'manage_options',
        'ezsi_server_stats',
        'ezsi_display_server_info',
        'dashicons-admin-generic',
        100
    );
}

function ezsi_display_server_info() {
    global $wpdb;

    // Fetch server and WordPress environment information
    $server_info = [
        'Operating System' => php_uname('s'),
        'Software' => isset($_SERVER['SERVER_SOFTWARE']) ? sanitize_text_field(wp_unslash($_SERVER['SERVER_SOFTWARE'])) : 'Not Available',
        'MySQL Version' => $wpdb->db_version(),
        'PHP Version' => phpversion(),
        'PHP Memory Limit' => ini_get('memory_limit'),
        'PHP Max Input Vars' => ini_get('max_input_vars'),
        'PHP Max Post Size' => ini_get('post_max_size'),
        'GD Installed' => extension_loaded('gd') ? 'Yes' : 'No',
        'ZIP Installed' => extension_loaded('zip') ? 'Yes' : 'No',
        'Write Permissions' => ezsi_check_write_permissions() ? 'All right' : 'Check permissions',
        'PHP Execution Time' => ini_get('max_execution_time'),
        'File Uploads Enabled' => ini_get('file_uploads'),

        // New fields for more information
        'Disk Free Space' => function_exists('disk_free_space') ? size_format(disk_free_space(ABSPATH)) : 'Not Available',
        'Disk Total Space' => function_exists('disk_total_space') ? size_format(disk_total_space(ABSPATH)) : 'Not Available',
        'cURL Installed' => extension_loaded('curl') ? 'Yes' : 'No',
        'MBString Installed' => extension_loaded('mbstring') ? 'Yes' : 'No',
        'PHP Error Log' => ini_get('error_log'),
        'Max File Upload Size' => ini_get('upload_max_filesize'),
    ];

    $wp_info = [
        'Version' => get_bloginfo('version'),
        'Site URL' => get_site_url(),
        'Home URL' => get_home_url(),
        'WP Multisite' => is_multisite() ? 'Yes' : 'No',
        'Max Upload Size' => size_format(wp_max_upload_size()),
        'Memory Limit' => WP_MEMORY_LIMIT,
        'Max Memory Limit' => WP_MAX_MEMORY_LIMIT,
        'Permalink Structure' => get_option('permalink_structure'),
        'Language' => get_locale(),
        'Timezone' => get_option('timezone_string') ?: 'Not Set',
        'Admin Email' => sanitize_email(get_option('admin_email')),
        'Debug Mode' => (defined('WP_DEBUG') && WP_DEBUG) ? 'Active' : 'Inactive',
        'Database Host' => DB_HOST,
        'Database Name' => DB_NAME,
        'Database User' => DB_USER,
        'Database Charset' => DB_CHARSET,
        'SSL/TLS Status' => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'Enabled' : 'Not Enabled'
    ];

    // Display the information in tables
    echo '<div class="wrap"><h1>Server Stats and System Information</h1>';

    echo '<h2>Server Environment</h2>';
    echo '<table class="widefat fixed" cellspacing="0"><tbody>';
    foreach ($server_info as $key => $value) {
        echo '<tr><th>' . esc_html($key) . '</th><td>' . esc_html($value) . '</td></tr>';
    }
    echo '</tbody></table>';

    echo '<h2>WordPress Environment</h2>';
    echo '<table class="widefat fixed" cellspacing="0"><tbody>';
    foreach ($wp_info as $key => $value) {
        echo '<tr><th>' . esc_html($key) . '</th><td>' . esc_html($value) . '</td></tr>';
    }
    echo '</tbody></table>';

    echo '</div>';
}

/**
 * Check write permissions using WordPress filesystem functions
 */
function ezsi_check_write_permissions() {
    global $wp_filesystem;

    if (empty($wp_filesystem)) {
        require_once ABSPATH . 'wp-admin/includes/file.php';
        WP_Filesystem();
    }

    // Check if the directory is writable
    return $wp_filesystem->is_writable(ABSPATH);
}

// Activation hook
register_activation_hook(__FILE__, 'ezsi_activate');

function ezsi_activate() {
    // Set a transient to show the activation notice
    set_transient('ezsi_activation_notice', true, 5 * MINUTE_IN_SECONDS);
}

// Deactivation hook
register_deactivation_hook(__FILE__, 'ezsi_deactivate');

function ezsi_deactivate() {
    // Optionally, you can set a transient or handle deactivation here
}

// Show an admin notice when the plugin is activated
add_action('admin_notices', 'ezsi_activation_notice');

function ezsi_activation_notice() {
    // Check if the transient is set and the user has the required capability
    if (get_transient('ezsi_activation_notice') && current_user_can('manage_options')) {
        // Display the notice
        echo '<div class="notice notice-success is-dismissible">';
        echo '<p>Plugin activated. <a href="' . esc_url(admin_url('admin.php?page=ezsi_server_stats')) . '">View System Info</a>.</p>';
        echo '</div>';

        // Delete the transient after displaying the notice
        delete_transient('ezsi_activation_notice');
    }
}

// Hook into the plugin_action_links filter
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'ezsi_plugin_settings_link');

/**
 * Add dynamic Settings link to plugin action links
 */
function ezsi_plugin_settings_link($links) {
    // Generate the dynamic URL for the custom admin page
    $settings_link = '<a href="' . esc_url(admin_url('admin.php?page=ezsi_server_stats')) . '">Server Info</a>';

    // Add the link to the existing array of action links
    array_push($links, $settings_link);

    return $links;
}
