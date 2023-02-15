<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://mpress.cc
 * @since             1.0.0
 * @package           Odoo_Woo_Order_Sync
 *
 * @wordpress-plugin
 * Plugin Name:       Odoo order synchronization
 * Plugin URI:        https://mpress.cc
 * Description:       Send completed order to the Odoo. Requires installed Metabox for settings page.
 * Version:           1.0.2
 * Author:            Mateusz Zadorożny
 * Author URI:        https://mpress.cc
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       odoo-woo-order-sync
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
define( 'ODOO_WOO_ORDER_SYNC_VERSION', '1.0.2' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-odoo-woo-order-sync-activator.php
 */
function activate_odoo_woo_order_sync() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-odoo-woo-order-sync-activator.php';
	Odoo_Woo_Order_Sync_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-odoo-woo-order-sync-deactivator.php
 */
function deactivate_odoo_woo_order_sync() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-odoo-woo-order-sync-deactivator.php';
	Odoo_Woo_Order_Sync_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_odoo_woo_order_sync' );
register_deactivation_hook( __FILE__, 'deactivate_odoo_woo_order_sync' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-odoo-woo-order-sync.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_odoo_woo_order_sync() {

	$plugin = new Odoo_Woo_Order_Sync();
	$plugin->run();

    include_once(plugin_dir_path(__FILE__) . 'admin/settings-page.php');
	include_once(plugin_dir_path(__FILE__) . 'admin/synchronization-request.php');

}
run_odoo_woo_order_sync();
