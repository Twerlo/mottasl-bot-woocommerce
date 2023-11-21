<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://mottasl.com/
 * @since      0.1.0
 *
 * @package    Mottasl_Bot_Woocommerce
 * @subpackage Mottasl_Bot_Woocommerce/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      0.1.0
 * @package    Mottasl_Bot_Woocommerce
 * @subpackage Mottasl_Bot_Woocommerce/includes
 * @author     Twerlo <support@twerlo.com>
 */
class Mottasl_Bot_Woocommerce_Deactivator
{

	/**
	 * Turn merchant installation status to uninstalled in mottasl backend and unregister events webhooks from woo
	 *
	 * @since    0.1.0
	 */
	public static function deactivate()
	{
		Mottasl_Bot_Woocommerce_Deactivator::unregister_webhooks();
		Mottasl_Bot_Woocommerce_Deactivator::uninstall_merchant();
	}

	private static function uninstall_merchant()
	{
		// try to get mottasl integration id from settings
		$mottasl_integration_id = get_option('mottasl_integration_id', '');


		$store_data = array(
			"platfrom_id" => $mottasl_integration_id,
		);

		// Set up the request arguments
		$args = array(
			'body'        => json_encode($store_data),
			'headers'     => array(
				'Content-Type' => 'application/json',
			),
			'timeout'     => 15,
		);

		$request_url = 'https://mesh.twerlo.com/woo/uninstall';
		$response = wp_remote_post($request_url, $args);

		// Check for errors
		if (is_wp_error($response)) {
			echo 'Error: ' . $response->get_error_message();
		} else {
			// Success, delete integration_id
			update_option('mottasl_integration_id', '');
		}
	}

	private static function unregister_webhooks()
	{
		$delivery_url_to_delete = 'https://mesh.twerlo.com/woo/events' . '?itegration_id=' . get_option('mottasl_integration_id');

		$data_store = \WC_Data_Store::load('webhook');
		$webhooks   = $data_store->search_webhooks(['delivery_url' => $delivery_url_to_delete, 'paginate' => false]);


		if ($webhooks && is_array($webhooks)) {
			foreach ($webhooks as $webhook_id) {
				// Delete the webhook
				$webhook = new WC_Webhook();
				$webhook->set_id($webhook_id);
				$webhook->delete();
			}
			echo 'Webhooks deleted successfully.';
		} else {
			echo 'No webhooks found.';
		}
	}
}
