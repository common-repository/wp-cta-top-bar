<?php
/**
 * Plugin Name: WP CTA Top Bar
 * Description: Add call to action top bar in your wordpress website.
 * Version: 0.4.1
 * Author: Alipio Gabriel
 * Author URI: http://alipiogabriel.com
 * Requires at least: 4.4
 * Tested up to: 4.9.1
 *
 * Text Domain: wpctatb
 * Domain Path: /i18n/languages/
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define PLUGIN_FILE.
//__FILE__ dir of the main setup plugin. {plugin_name}.php
if ( ! defined( 'WPCTATB_PLUGIN_FILE' ) ) {
	define( 'WPCTATB_FILE', __FILE__ );
}

// Include the main WooCommerce class.
if ( ! class_exists( 'WPCTATopBar' ) ) {
	include_once dirname( WPCTATB_FILE ) . '/includes/class-wpctatb.php';
}

/**
 * Main instance of Plugin.
 *
 * Returns the main instance of biyp to prevent the need to use globals.
 *
 * @since  0.1
 * @return Widget
 */

function wpctatopbar() {
	return WPCTATopBar::instance();
}

// Global for backwards compatibility.
$GLOBALS['wpctatopbar'] = wpctatopbar();

