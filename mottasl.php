<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://mottasl.com/
 * @since             0.1.0
 * @package           WooCommerce\Admin
 *
 * @wordpress-plugin
 * Plugin Name:       Mottasl Bot
 * Plugin URI:        https://github.com/Twerlo/mottasl-bot-woocommerce
 * Description:       Integrate your Woocommerce Store to send WhatsApp order status updates and abandoned cart recovery campaigns to your Customers.
 * Version:           0.1.0
 * Author:            Twerlo
 * Author URI:        https://mottasl.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mottasl-bot-woocommerce
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 0.1.0 and use SemVer - https://semver.org
 */
define('MOTTASL_BOT_WOOCOMMERCE_VERSION', '0.1.0');


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mottasl-bot-woocommerce-activator.php
 */
function activate_mottasl_bot_woocommerce()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-mottasl-bot-woocommerce-activator.php';
	Mottasl_Bot_Woocommerce_Activator::activate();
}
/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mottasl-bot-woocommerce-deactivator.php
 */
function deactivate_mottasl_bot_woocommerce()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-mottasl-bot-woocommerce-deactivator.php';
	Mottasl_Bot_Woocommerce_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_mottasl_bot_woocommerce');
register_deactivation_hook(__FILE__, 'deactivate_mottasl_bot_woocommerce');

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.1.0
 */
function run_mottasl_bot_woocommerce()
{
	/**
	 * The core plugin class that is used to define internationalization,
	 * admin-specific hooks, and public-facing site hooks.
	 */
	require plugin_dir_path(__FILE__) . 'includes/class-mottasl-bot-woocommerce.php';
	$plugin = new Mottasl_Bot_Woocommerce();
	$plugin->run();
}
run_mottasl_bot_woocommerce();
