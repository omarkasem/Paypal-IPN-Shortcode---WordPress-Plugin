<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://www.elnooronline.com
 * @since      1.0.0
 *
 * @package    Paypal_Ipn_Shortcode
 * @subpackage Paypal_Ipn_Shortcode/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Paypal_Ipn_Shortcode
 * @subpackage Paypal_Ipn_Shortcode/includes
 * @author     Omar Kasem <omar.kasem207@gmail.com>
 */
class Paypal_Ipn_Shortcode_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'paypal-ipn-shortcode',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
