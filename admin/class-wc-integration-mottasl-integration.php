<?php

/**
 * Integration Mottasl Integration.
 *
 * @package  WC_Integration_Mottasl_Integration
 * @category Integration
 * @author   Patrick Rauland
 */
if (!class_exists('WC_Integration_Mottasl_Integration')) :
	/**
	 * Mottasl Integration class.
	 */
	class WC_Integration_Mottasl_Integration extends WC_Integration
	{
		public $mottasl_integration_id = "";
		public $mottasl_integration_url = "";

		/**
		 * Init and hook in the integration.
		 */
		public function __construct()
		{
			global $woocommerce;

			$this->id                 = 'integration-mottasl';
			$this->method_title       = __('Integration Mottasl', 'mottasl-bot-woocommerce');
			$this->method_description = __('An integration mottasl to show you how easy it is to send WA notifications using mottasl.', 'mottasl-bot-woocommerce');

			$this->mottasl_integration_id = get_option('mottasl_integration_id');
			$this->mottasl_integration_url = "https://ecom.mottasl.com?integration_id=" . get_option('mottasl_integration_id');

			// Load the settings.
			$this->init_form_fields();
			$this->init_settings();

			// Define user set variables.
			$this->mottasl_integration_id = $this->get_option('mottasl_integration_id');

			// Actions.
			add_action('woocommerce_update_options_integration_' .  $this->id, array($this, 'process_admin_options'));
		}

		/**
		 * Initialize integration settings form fields.
		 */
		public function init_form_fields()
		{
			$this->form_fields = array(
				'mottasl_integration_id' => array(
					'title'       => __('Integration ID', 'mottasl-bot-woocommerce'),
					'type'        => 'text',
					'description' => __('Use this ID in Mottasl Portal to control notification templates. <a href="' . $this->mottasl_integration_url . '" target="_blank">Mottasl Portal</a>.', 'mottasl-bot-woocommerce'),
					'desc_tip'    => false,
					'default'     => $this->mottasl_integration_id,
					'custom_attributes' => array('readonly' => 'readonly')
				),
			);
		}
	}
endif;
