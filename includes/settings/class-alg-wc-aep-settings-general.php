<?php
/**
 * Advanced External Products for WooCommerce - General Section Settings
 *
 * @version 2.1.0
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_AEP_Settings_General' ) ) :

class Alg_WC_AEP_Settings_General extends Alg_WC_AEP_Settings_Section {

	/**
	 * Constructor.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function __construct() {
		$this->id   = '';
		$this->desc = __( 'General', 'external-products-currency-for-woocommerce' );
		parent::__construct();
	}

	/**
	 * get_settings.
	 *
	 * @version 2.1.0
	 * @since   1.0.0
	 */
	function get_settings() {

		$main_settings = array(
			array(
				'title'    => __( 'Advanced External Products Options', 'external-products-currency-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'alg_wc_external_products_plugin_options',
			),
			array(
				'title'    => __( 'Advanced External Products', 'external-products-currency-for-woocommerce' ),
				'desc'     => '<strong>' . __( 'Enable plugin', 'external-products-currency-for-woocommerce' ) . '</strong>',
				'id'       => 'alg_wc_external_products_plugin_enabled',
				'default'  => 'yes',
				'type'     => 'checkbox',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_external_products_plugin_options',
			),
		);

		$currency_settings = array(
			array(
				'title'    => __( 'Currency Options', 'external-products-currency-for-woocommerce' ),
				'desc'     => __( 'Set different currency for external/affiliate products.', 'external-products-currency-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'alg_wc_external_products_currency_options',
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
					__( 'This will add new meta box to each product\'s edit page.', 'external-products-currency-for-woocommerce' ) . ' ' .
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

		$link_settings = array(
			array(
				'title'    => __( 'Link Options', 'external-products-currency-for-woocommerce' ),
				'desc'     => __( 'Make external/affiliate products links open in a new tab.', 'external-products-currency-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'alg_wc_external_products_link_options',
			),
			array(
				'title'    => __( 'All products', 'external-products-currency-for-woocommerce' ) . ' / ' .
					__( 'Single', 'external-products-currency-for-woocommerce' ),
				'desc_tip' => __( 'Open link in a new tab for <strong>all</strong> external <strong>products</strong> on <strong>single product pages</strong>.', 'external-products-currency-for-woocommerce' ),
				'desc'     => __( 'Enable', 'external-products-currency-for-woocommerce' ),
				'id'       => 'alg_wc_external_products_link_new_tab_single_enabled',
				'default'  => 'no',
				'type'     => 'checkbox',
			),
			array(
				'title'    => __( 'All products', 'external-products-currency-for-woocommerce' ) . ' / ' .
					__( 'Archives', 'external-products-currency-for-woocommerce' ),
				'desc_tip' => __( 'Open link in a new tab for <strong>all</strong> external <strong>products</strong> on <strong>archives</strong>.', 'external-products-currency-for-woocommerce' ),
				'desc'     => __( 'Enable', 'external-products-currency-for-woocommerce' ),
				'id'       => 'alg_wc_external_products_link_new_tab_loop_enabled',
				'default'  => 'no',
				'type'     => 'checkbox',
			),
			array(
				'title'    => __( 'Per product', 'external-products-currency-for-woocommerce' ) . ' / ' .
					__( 'Single', 'external-products-currency-for-woocommerce' ),
				'desc_tip' => __( 'Open link in a new tab for external products on <strong>per product</strong> basis on <strong>single product pages</strong>.', 'external-products-currency-for-woocommerce' ) . ' ' .
					__( 'This will add new meta box to each product\'s edit page.', 'external-products-currency-for-woocommerce' ) . ' ' .
					apply_filters( 'alg_wc_advanced_external_products_settings', sprintf(
						'<br>To enable link on <strong>per product basis</strong>, please get <a target="_blank" href="%s">Advanced External Products for WooCommerce Pro</a> plugin.',
						'https://wpfactory.com/item/advanced-external-products-for-woocommerce/' ) ),
				'desc'     => __( 'Enable', 'external-products-currency-for-woocommerce' ),
				'id'       => 'alg_wc_external_products_link_per_product_single_enabled',
				'default'  => 'no',
				'type'     => 'checkbox',
				'custom_attributes' => apply_filters( 'alg_wc_advanced_external_products_settings', array( 'disabled' => 'disabled' ) ),
			),
			array(
				'title'    => __( 'Per product', 'external-products-currency-for-woocommerce' ) . ' / ' .
					__( 'Archives', 'external-products-currency-for-woocommerce' ),
				'desc_tip' => __( 'Open link in a new tab for external products on <strong>per product</strong> basis on <strong>archives</strong>.', 'external-products-currency-for-woocommerce' ) . ' ' .
					__( 'This will add new meta box to each product\'s edit page.', 'external-products-currency-for-woocommerce' ) . ' ' .
					apply_filters( 'alg_wc_advanced_external_products_settings', sprintf(
						'<br>To enable link on <strong>per product basis</strong>, please get <a target="_blank" href="%s">Advanced External Products for WooCommerce Pro</a> plugin.',
						'https://wpfactory.com/item/advanced-external-products-for-woocommerce/' ) ),
				'desc'     => __( 'Enable', 'external-products-currency-for-woocommerce' ),
				'id'       => 'alg_wc_external_products_link_per_product_loop_enabled',
				'default'  => 'no',
				'type'     => 'checkbox',
				'custom_attributes' => apply_filters( 'alg_wc_advanced_external_products_settings', array( 'disabled' => 'disabled' ) ),
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_external_products_link_options',
			),
		);

		return array_merge( $main_settings, $currency_settings, $link_settings );
	}

}

endif;

return new Alg_WC_AEP_Settings_General();
