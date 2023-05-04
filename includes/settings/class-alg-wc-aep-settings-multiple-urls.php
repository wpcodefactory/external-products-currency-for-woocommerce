<?php
/**
 * Advanced External Products for WooCommerce - Multiple URLs Section Settings
 *
 * @version 2.4.0
 * @since   2.3.0
 *
 * @author  Algoritmika Ltd.
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Alg_WC_AEP_Settings_Multiple_URLs' ) ) :

class Alg_WC_AEP_Settings_Multiple_URLs extends Alg_WC_AEP_Settings_Section {

	/**
	 * Constructor.
	 *
	 * @version 2.3.0
	 * @since   2.3.0
	 */
	function __construct() {
		$this->id   = 'multiple-urls';
		$this->desc = __( 'Multiple URLs', 'external-products-currency-for-woocommerce' );
		parent::__construct();
	}

	/**
	 * get_settings.
	 *
	 * @version 2.4.0
	 * @since   2.3.0
	 *
	 * @todo    [next] (desc) `alg_wc_external_products_multiple_urls_enabled`: better desc?
	 */
	function get_settings() {
		return array(
			array(
				'title'    => __( 'Multiple Product URLs', 'external-products-currency-for-woocommerce' ),
				'desc'     => __( 'Set multiple URLs per product.', 'external-products-currency-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'alg_wc_external_products_multiple_urls_options',
			),
			array(
				'title'    => __( 'Multiple product URLs', 'external-products-currency-for-woocommerce' ),
				'desc_tip' => __( 'This will add "Extra product URLs" input field to each product\'s edit page.', 'external-products-currency-for-woocommerce' ),
				'desc'     => '<strong>' . __( 'Enable section', 'external-products-currency-for-woocommerce' ) . '</strong>',
				'id'       => 'alg_wc_external_products_multiple_urls_enabled',
				'default'  => 'yes',
				'type'     => 'checkbox',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_external_products_multiple_urls_options',
			),
			array(
				'title'    => __( 'Single', 'external-products-currency-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'alg_wc_external_products_multiple_urls_single_options',
			),
			array(
				'title'    => __( 'Single', 'external-products-currency-for-woocommerce' ),
				'desc_tip' => __( 'Show multiple "add to cart" buttons for external products on <strong>single product pages</strong>.', 'external-products-currency-for-woocommerce' ),
				'desc'     => __( 'Enable', 'external-products-currency-for-woocommerce' ),
				'id'       => 'alg_wc_external_products_multiple_urls_single_enabled',
				'default'  => 'no',
				'type'     => 'checkbox',
			),
			array(
				'title'    => __( 'Template', 'external-products-currency-for-woocommerce' ),
				'desc'     => apply_filters( 'alg_wc_advanced_external_products_settings', sprintf(
					'To select a template, please get the <a target="_blank" href="%s">Advanced External Products for WooCommerce Pro</a> plugin.',
					'https://wpfactory.com/item/advanced-external-products-for-woocommerce/' ) ),
				'id'       => 'alg_wc_external_products_multiple_urls_single_template',
				'default'  => 'buttons',
				'type'     => 'radio',
				'options'  => array(
					'buttons' => __( 'Buttons', 'external-products-currency-for-woocommerce' ),
					'select'  => __( 'Dropdown', 'external-products-currency-for-woocommerce' ),
				),
				'custom_attributes' => apply_filters( 'alg_wc_advanced_external_products_settings', array( 'disabled' => 'disabled' ) ),
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_external_products_multiple_urls_single_options',
			),
			array(
				'title'    => __( 'Archives', 'external-products-currency-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'alg_wc_external_products_multiple_urls_loop_options',
			),
			array(
				'title'    => __( 'Archives', 'external-products-currency-for-woocommerce' ),
				'desc_tip' => __( 'Show multiple "add to cart" buttons for external products on <strong>archives</strong>.', 'external-products-currency-for-woocommerce' ),
				'desc'     => __( 'Enable', 'external-products-currency-for-woocommerce' ),
				'id'       => 'alg_wc_external_products_multiple_urls_loop_enabled',
				'default'  => 'no',
				'type'     => 'checkbox',
			),
			array(
				'title'    => __( 'Template', 'external-products-currency-for-woocommerce' ),
				'desc'     => apply_filters( 'alg_wc_advanced_external_products_settings', sprintf(
					'To select a template, please get the <a target="_blank" href="%s">Advanced External Products for WooCommerce Pro</a> plugin.',
					'https://wpfactory.com/item/advanced-external-products-for-woocommerce/' ) ),
				'id'       => 'alg_wc_external_products_multiple_urls_loop_template',
				'default'  => 'buttons',
				'type'     => 'radio',
				'options'  => array(
					'buttons' => __( 'Buttons', 'external-products-currency-for-woocommerce' ),
					'select'  => __( 'Dropdown', 'external-products-currency-for-woocommerce' ),
				),
				'custom_attributes' => apply_filters( 'alg_wc_advanced_external_products_settings', array( 'disabled' => 'disabled' ) ),
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_external_products_multiple_urls_loop_options',
			),
		);
	}

}

endif;

return new Alg_WC_AEP_Settings_Multiple_URLs();
