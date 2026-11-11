<?php
/**
 * Bootstrap the WordPress test environment.
 *
 * @package ExamplePlugin
 */

$_tests_dir = getenv( 'WP_TESTS_DIR' );

if ( ! $_tests_dir ) {
	$_tests_dir = rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';
}

if ( ! file_exists( $_tests_dir . '/includes/functions.php' ) ) {
	throw new RuntimeException( 'The WordPress test suite could not be found.' );
}

require_once $_tests_dir . '/includes/functions.php';

/**
 * Load the plugin before WordPress completes its test bootstrap.
 */
tests_add_filter(
	'muplugins_loaded',
	static function () {
		require dirname( __DIR__ ) . '/index.php';
	}
);

require $_tests_dir . '/includes/bootstrap.php';
