<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.elnooronline.com
 * @since             1.0.0
 * @package           Paypal_Ipn_Shortcode
 *
 * @wordpress-plugin
 * Plugin Name:       Paypal IPN Shortcode
 * Plugin URI:        paypal-ipn-shortcode
 * Description:       Insert Paypal Payment Button in page and posts with a simple customizable shortcode and verify the payment with PaypalIPN.
 * Version:           1.0.0
 * Author:            Omar Kasem
 * Author URI:        http://www.elnooronline.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       paypal-ipn-shortcode
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PAYPAL_IPN_SHORTCODE_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-paypal-ipn-shortcode-activator.php
 */
function activate_paypal_ipn_shortcode() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-paypal-ipn-shortcode-activator.php';
	Paypal_Ipn_Shortcode_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-paypal-ipn-shortcode-deactivator.php
 */
function deactivate_paypal_ipn_shortcode() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-paypal-ipn-shortcode-deactivator.php';
	Paypal_Ipn_Shortcode_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_paypal_ipn_shortcode' );
register_deactivation_hook( __FILE__, 'deactivate_paypal_ipn_shortcode' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-paypal-ipn-shortcode.php';
if(!class_exists('PaypalIPN')){
	require plugin_dir_path( __FILE__ ) . 'includes/libs/PaypalIPN.php';
}
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_paypal_ipn_shortcode() {

	$plugin = new Paypal_Ipn_Shortcode();
	$plugin->run();

}
run_paypal_ipn_shortcode();
