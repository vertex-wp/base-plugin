<?php
/**
 * Integration tests for the starter plugin.
 *
 * @package ExamplePlugin
 */

use ExamplePlugin\Plugin;

/**
 * Tests the plugin's WordPress bootstrap integration.
 */
class Test_Plugin_Integration extends WP_UnitTestCase {

	/**
	 * The plugin bootstrap exposes its lifecycle singleton and registers init.
	 *
	 * @return void
	 */
	public function test_plugin_bootstrap_registers_lifecycle_instance() {
		$plugin = Plugin::get_instance();

		$this->assertInstanceOf( Plugin::class, $plugin );
		$this->assertSame( $plugin, Plugin::get_instance() );
		$this->assertNotFalse( has_action( 'init', array( $plugin, 'init' ) ) );
	}
}
