<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://mottasl.com/
 * @since      0.1.0
 *
 * @package    Mottasl_Bot_Woocommerce
 * @subpackage Mottasl_Bot_Woocommerce/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      0.1.0
 * @package    Mottasl_Bot_Woocommerce
 * @subpackage Mottasl_Bot_Woocommerce/includes
 * @author     Twerlo <support@twerlo.com>
 */
class Mottasl_Bot_Woocommerce_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    0.1.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'mottasl-bot-woocommerce',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
