<?php
/**
 * Advanced External Products for WooCommerce - Currency Section Settings
 *
 * @version 2.3.0
 * @since   1.0.0
 *
 * @author  Algoritmika Ltd.
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Alg_WC_AEP_Settings_Currency' ) ) :

class Alg_WC_AEP_Settings_Currency extends Alg_WC_AEP_Settings_Section {

	/**
	 * Constructor.
	 *
	 * @version 2.3.0
	 * @since   1.0.0
	 */
	function __construct() {
		$this->id   = '';
		$this->desc = __( 'Currency', 'external-products-currency-for-woocommerce' );
		parent::__construct();
	}

	/**
	 * get_settings.
	 *
	 * @version 2.3.0
	 * @since   1.0.0
	 */
	function get_settings() {
		return array(
			array(
				'title'    => __( 'Currency', 'external-products-currency-for-woocommerce' ),
				'desc'     => __( 'Set different currency for external/affiliate products.', 'external-products-currency-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'alg_wc_external_products_currency_options',
			),
			array(
				'title'    => __( 'Currency', 'external-products-currency-for-woocommerce' ),
				'desc'     => '<strong>' . __( 'Enable section', 'external-products-currency-for-woocommerce' ) . '</strong>',
				'id'       => 'alg_wc_external_products_currency_enabled',
				'default'  => 'yes',
				'type'     => 'checkbox',
			),
			array(
				'title'    => __( 'All products', 'external-products-currency-for-woocommerce' ),
				'desc_tip' => __( 'Currency for <strong>all</strong> external <strong>products</strong>.', 'external-products-currency-for-woocommerce' ),
				'desc'     => __( 'Enable', 'external-products-currency-for-woocommerce' ),
				'id'       => 'alg_wc_external_products_currency_all_products_enabled',
				'default'  => 'no',
				'type'     => 'checkbox',
			),
			array(
				'id'       => 'alg_wc_external_products_currency_all_products',
				'default'  => get_option( 'woocommerce_currency' ),
				'type'     => 'select',
				'class'    => 'chosen_select',
				'options'  => get_woocommerce_currencies(),
			),
			array(
				'title'    => __( 'Per product', 'external-products-currency-for-woocommerce' ),
				'desc_tip' => __( 'Currency for external products on <strong>per product</strong> basis.', 'external-products-currency-for-woocommerce' ) . ' ' .
					__( 'This will add "Currency" input field to each product\'s edit page.', 'external-products-currency-for-woocommerce' ) . ' ' .
					apply_filters( 'alg_wc_advanced_external_products_settings', sprintf(
						'<br>To enable currency on <strong>per product basis</strong>, please get <a target="_blank" href="%s">Advanced External Products for WooCommerce Pro</a> plugin.',
						'https://wpfactory.com/item/advanced-external-products-for-woocommerce/' ) ),
				'desc'     => __( 'Enable', 'external-products-currency-for-woocommerce' ),
				'id'       => 'alg_wc_external_products_currency_per_product_enabled',
				'default'  => 'no',
				'type'     => 'checkbox',
				'custom_attributes' => apply_filters( 'alg_wc_advanced_external_products_settings', array( 'disabled' => 'disabled' ) ),
			),
			array(
				'title'    => __( 'Currency symbol', 'external-products-currency-for-woocommerce' ),
				'desc_tip' => __( 'Custom currency symbol template for all external products.', 'external-products-currency-for-woocommerce' ),
				'desc'     => __( 'Enable', 'external-products-currency-for-woocommerce' ),
				'id'       => 'alg_wc_external_products_currency_symbol_enabled',
				'default'  => 'no',
				'type'     => 'checkbox',
			),
			array(
				'desc'     => sprintf( __( 'Available placeholders: %s.', 'external-products-currency-for-woocommerce' ),
					'<code>' . implode( '</code>, <code>', array( '%currency_symbol%', '%currency_code%' ) ) . '</code>' ),
				'id'       => 'alg_wc_external_products_currency_symbol',
				'default'  => '%currency_symbol%',
				'type'     => 'text',
				'alg_wc_aep_raw' => true,
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_external_products_currency_options',
			),
		);
	}

}

endif;

return new Alg_WC_AEP_Settings_Currency();
