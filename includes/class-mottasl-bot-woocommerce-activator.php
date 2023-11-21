<?php

/**
 * Fired during plugin activation
 *
 * @link       https://mottasl.com/
 * @since      0.1.0
 *
 * @package    Mottasl_Bot_Woocommerce
 * @subpackage Mottasl_Bot_Woocommerce/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      0.1.0
 * @package    Mottasl_Bot_Woocommerce
 * @subpackage Mottasl_Bot_Woocommerce/includes
 * @author     Twerlo <support@twerlo.com>
 */
class Mottasl_Bot_Woocommerce_Activator
{

	/**
	 * Install merchant in mottasl backend and register events webhooks in woo
	 *
	 * @since    0.1.0
	 */
	public static function activate()
	{
		Mottasl_Bot_Woocommerce_Activator::install_merchant();
		Mottasl_Bot_Woocommerce_Activator::register_webhooks();
	}

	// if not there request new merchant install from mottasls
	private static function install_merchant()
	{
		$store_data = array(
			'integration_id' => get_option('mottasl_integration_id', ''), // try to get mottasl integration id from settings
			'store_name' => get_bloginfo('name'),
			'store_phone' => get_option('woocommerce_store_phone', ""),
			'store_email' => get_option('admin_email'),
			'store_url' => get_bloginfo('url')
		);

		// Set up the request arguments
		$args = array(
			'body'        => json_encode($store_data),
			'headers'     => array(
				'Content-Type' => 'application/json',
			),
			'timeout'     => 15,
		);

		$request_url = 'https://mesh.twerlo.com/woo/install';
		$response = wp_remote_post($request_url, $args);

		// Check for errors
		if (is_wp_error($response)) {
			echo 'Error: ' . $response->get_error_message();
		} else {
			// Success, save integration_id
			$body = wp_remote_retrieve_body($response);
			echo 'Response: ' . $body;
			error_log($body);

			$responseArray = json_decode($body, true);
			$integration_id = $responseArray['merchantDetails']['_id'];
			if ($integration_id) {
				update_option('mottasl_integration_id', $integration_id);
			}
		}
	}

	private static function register_webhooks()
	{
		$webhooks_topics_to_register = [
			'order.created',
			'order.updated',
			'customer.created',
		];

		// not required though, it is just for webhook secret
		$consumer_key = 'YOUR_CONSUMER_KEY';
		$consumer_secret = 'YOUR_CONSUMER_SECRET';

		// Set the webhook status to 'active'
		$webhook_status = 'active';

		// Set the webhook endpoint URL
		$webhook_url = 'https://mesh.twerlo.com/woo/events' . '?itegration_id=' . get_option('mottasl_integration_id');

		foreach ($webhooks_topics_to_register as $webhook_topic) {
			// Create the webhook data
			$webhook_data = array(
				'name' => 'Mottasl Event: ' . $webhook_topic,
				'topic' => $webhook_topic,
				'delivery_url' => $webhook_url,
				'status' => $webhook_status,
				'api_version' => 'v3',
				'secret' => wc_api_hash($consumer_key . $consumer_secret),
				'user_id' => get_current_user_id(),
			);

			// Create a new WC_Webhook instance
			$webhook = new WC_Webhook();

			// Set the webhook data
			$webhook->set_props($webhook_data);

			// Save the webhook
			$webhook->save();
		}
	}
}
