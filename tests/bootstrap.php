<?php
/**
 * Bootstrap the WordPress test environment.
 *
 * @package ExamplePlugin
 */

$example_plugin_tests_dir = getenv( 'WP_TESTS_DIR' );

$example_plugin_polyfills_path = getenv( 'WP_TESTS_PHPUNIT_POLYFILLS_PATH' );

if ( $example_plugin_polyfills_path && ! defined( 'WP_TESTS_PHPUNIT_POLYFILLS_PATH' ) ) {
	define( 'WP_TESTS_PHPUNIT_POLYFILLS_PATH', $example_plugin_polyfills_path );
}

if ( ! $example_plugin_tests_dir ) {
	$example_plugin_tests_dir = rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';
}

if ( ! file_exists( $example_plugin_tests_dir . '/includes/functions.php' ) ) {
	throw new RuntimeException( 'The WordPress test suite could not be found.' );
}

require_once $example_plugin_tests_dir . '/includes/functions.php';

/**
 * Load the plugin before WordPress completes its test bootstrap.
 */
tests_add_filter(
	'muplugins_loaded',
	static function () {
		require dirname( __DIR__ ) . '/index.php';
	}
);

require $example_plugin_tests_dir . '/includes/bootstrap.php';
