<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://mpress.cc
 * @since      1.0.0
 *
 * @package    Odoo_Woo_Order_Sync
 * @subpackage Odoo_Woo_Order_Sync/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Odoo_Woo_Order_Sync
 * @subpackage Odoo_Woo_Order_Sync/includes
 * @author     Mateusz Zadorożny <mateusz@zadorozny.rocks>
 */
class Odoo_Woo_Order_Sync_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'odoo-woo-order-sync',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
