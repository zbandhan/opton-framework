<?php
/**
 * Plugin Name: Opton Framework
 * Plugin URI: https://github.com/zbandhan/opton-framework
 * Description: Opton lightweight metabox & setting framework.
 * Version: 1.0.0
 * Author: Giganteck
 * Author URI: https://github.com/zbandhan
 * Requires at least: 6.0
 * Tested up to: 6.8
 * Requires PHP: 7.4
 * License: GPLv3
 * Text Domain: opton-framework
 */
defined('ABSPATH') || exit;

// Composer autoload
require_once __DIR__ . '/vendor/autoload.php';

use Giganteck\Opton\My_Metabox;
use Giganteck\Opton\My_Settings;
use Giganteck\Opton\Assets;

/** Version constant for Opton Framework */
if( ! defined( 'OPTON_FRAMEWORK_VERSION' ) ) {
    define( 'OPTON_FRAMEWORK_VERSION', '2.1.0' );
}

/** Name constant for Opton Framework */
if( ! defined( 'OPTON_FRAMEWORK_NAME' ) ) {
    define( 'OPTON_FRAMEWORK_NAME', 'Opton Framework' );
}

/** PATH constant for Opton Framework */
if( ! defined( 'OPTON_FRAMEWORK_PATH' ) ) {
    define( 'OPTON_FRAMEWORK_PATH', __FILE__ );
}

/** DIR constant for Opton Framework */
if( ! defined( 'OPTON_FRAMEWORK_DIR' ) ) {
    define( 'OPTON_FRAMEWORK_DIR', __DIR__ );
}

/** Base constant */
if( ! defined( 'OPTON_FRAMEWORK_BASE' ) ) {
    define( 'OPTON_FRAMEWORK_BASE', plugin_basename( OPTON_FRAMEWORK_PATH ) );
}

/** URI constant for Opton Framework */
if( ! defined( 'OPTON_FRAMEWORK_URL' ) ) {
    define( 'OPTON_FRAMEWORK_URL', plugins_url( '', __FILE__ ) );
}

// Init assets
add_action('plugins_loaded', function() {
    (new Assets())->register();
});
