<?php
define('VENDOR_DIRECTORY', dirname(__DIR__) . '/vendor');
define('TEST_INCLUDES_DIR', dirname(__FILE__) . '/includes');

if (! file_exists( dirname(__DIR__) . '/build' ) ) {
	mkdir(dirname(__DIR__) . '/build');
}

require_once getenv( 'WP_TESTS_DIR' ) . '/tests/phpunit/includes/functions.php';
require getenv( 'WP_TESTS_DIR' ) . '/tests/phpunit/includes/bootstrap.php';

require 'includes/testCase.php';

require VENDOR_DIRECTORY . '/autoload.php';

if ( ! function_exists( 'wplib_define' ) ) {
	require( VENDOR_DIRECTORY . '/wplib/wplib/defines.php' );
	wplib_define( 'WPLib_Runmode', 'PRODUCTION' );
	wplib_define( 'WPLib_Stability', 'EXPERIMENTAL' );
}

require VENDOR_DIRECTORY . '/wplib/wplib/wplib.php';
WPLib::initialize();

require dirname( __DIR__ ) . '/component-juicer.php';
require dirname( __DIR__ ) . '/includes/class-feed.php';
require dirname( __DIR__ ) . '/includes/class-feed-model.php';
require dirname( __DIR__ ) . '/includes/class-feed-view.php';
require dirname( __DIR__ ) . '/includes/class-post.php';
require dirname( __DIR__ ) . '/includes/class-post-model.php';
require dirname( __DIR__ ) . '/includes/class-post-view.php';
require dirname( __DIR__ ) . '/includes/class-source.php';
require dirname( __DIR__ ) . '/includes/class-source-model.php';
require dirname( __DIR__ ) . '/includes/class-source-view.php';