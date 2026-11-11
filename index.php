<?php
/**
 * Plugin Name:       Ephpicman Plugin Starter
 * Plugin URI:        https://github.com/vertex-wp/base-plugin
 * Description:       A lightweight foundation for Ephpicman WordPress plugins.
 * Version:           1.0.0
 * Requires at least: 6.3
 * Requires PHP:      8.0
 * Author:            Ephpicman
 * Author URI:        https://github.com/ephpicman
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain:       ephpicman-plugin
 * Domain Path:       /languages
 *
 * @package ExamplePlugin
 */

defined( 'ABSPATH' ) || exit;

define( 'EXAMPLE_PLUGIN_FILE', __FILE__ );

require_once __DIR__ . '/vertex/bootstrap.php';
require_once __DIR__ . '/src/Plugin.php';

VertexLoader::register(
	__DIR__,
	'ExamplePlugin\\',
	'1.4.0'
);

$plugin = ExamplePlugin\Plugin::get_instance();

register_activation_hook( __FILE__, array( $plugin, 'activate' ) );
register_deactivation_hook( __FILE__, array( $plugin, 'deactivate' ) );
register_uninstall_hook( __FILE__, array( 'ExamplePlugin\\Plugin', 'uninstall' ) );

add_action( 'init', array( $plugin, 'init' ) );
