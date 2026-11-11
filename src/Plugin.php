<?php
/**
 * Main plugin lifecycle class.
 *
 * @package ExamplePlugin
 */

namespace ExamplePlugin;

use Vertex\App;

defined( 'ABSPATH' ) || exit;

/**
 * Handles plugin initialization and lifecycle events.
 */
final class Plugin {

	/**
	 * The single instance of this class.
	 *
	 * @var Plugin|null
	 */
	private static $instance = null;

	/**
	 * Retrieve the singleton instance.
	 *
	 * @return Plugin
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Prevent direct construction.
	 */
	private function __construct() {}

	/**
	 * Initialize the plugin.
	 *
	 * @return void
	 */
	public function init() {
		// Register this plugin with Vertex.
		App::getInstance()->registerPlugin( dirname( EXAMPLE_PLUGIN_FILE ) );


		load_plugin_textdomain(
			'example-plugin',
			false,
			dirname( plugin_basename( EXAMPLE_PLUGIN_FILE ) ) . '/languages'
		);
	}

	/**
	 * Run activation routines.
	 *
	 * @return void
	 */
	public function activate() {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		// Add activation tasks here when needed.
	}

	/**
	 * Run uninstall routines.
	 *
	 * @return void
	 */
	public static function uninstall() {
		// Add permanent cleanup here when needed.
	}

	/**
	 * Run deactivation routines.
	 *
	 * @return void
	 */
	public function deactivate() {
		// Add temporary cleanup here when needed.
	}
}
