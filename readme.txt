=== Server Info for Debugging ===
Contributors: wpctaplugin, blendmedia, rcwpexpert
Tags: server stats, php info, server info, system info, debug
Requires at least: 5.0
Tested up to: 6.6
Stable tag: 1.1.4
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Plugin URI: https://blendmedia.ca/wordpress-server-info-for-debugging-plugin
Author: Blend Media
Author URI: https://blendmedia.ca/wordpress-server-info-for-debugging-plugin

Displays server stats and WordPress system information for debugging purposes.

== Description ==

**Server Info for Debugging** is a lightweight plugin that displays server stats and WordPress environment information on an admin page, helping with troubleshooting server-related issues. It provides:

- Operating system information
- PHP version and memory limits
- Database version and user details
- WordPress debug mode status
- SSL/TLS status
- Write permissions

For detailed server and WordPress setup, see below:

**Server Details**
- **Operating System**
- **Software**
- **MySQL Version**
- **PHP Version**
- **PHP Memory Limit**
- **PHP Max Input Vars**
- **PHP Max Post Size**
- **GD Installed**
- **ZIP Installed**
- **Write Permissions**
- **PHP Execution Time**
- **File Uploads Enabled**

**WordPress Environment Details**
- **WordPress Version**
- **Site URL**
- **Home URL**
- **WP Multisite**
- **Max Upload Size**
- **Memory Limit**
- **Max Memory Limit**
- **Permalink Structure**
- **Language**
- **Timezone**
- **Admin Email**
- **Debug Mode**
- **Database Host**
- **Database Name**
- **Database User**
- **Database Charset**
- **SSL/TLS Status**

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/server-info-for-debugging` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Go to 'Server Stats' in the WordPress admin menu to view your server and system information.

== Frequently Asked Questions ==

= What does this plugin do? =
This plugin displays detailed information about the server environment and WordPress setup, which can help in debugging and troubleshooting.

= Is this plugin useful for multisite? =
Yes, the plugin supports multisite installations and displays whether the site is part of a WordPress multisite network.

= Do I need to configure anything? =
No configuration is required. Just activate the plugin, and the server stats will be accessible from the WordPress admin menu.

== Screenshots ==

1. **Server Stats Page** - Displays server and WordPress environment information.

== Changelog ==

= 1.0 =
* Initial release.

= 1.1 =
* Improved error handling and compatibility with PHP versions.
* Added detailed SSL/TLS status checking.

== Upgrade Notice ==

= 1.1 =
This version includes important updates for better error handling and SSL/TLS status reporting.

== License ==

This plugin is licensed under the GPL v2.0 or later. For more details, see [GNU GPL](http://www.gnu.org/licenses/gpl-2.0.html).