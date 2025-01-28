<?php
/**
 * Advanced External Products for WooCommerce - Links Section Settings
 *
 * @version 2.5.0
 * @since   2.3.0
 *
 * @author  Algoritmika Ltd.
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Alg_WC_AEP_Settings_Links' ) ) :

class Alg_WC_AEP_Settings_Links extends Alg_WC_AEP_Settings_Section {

	/**
	 * Constructor.
	 *
	 * @version 2.5.0
	 * @since   2.3.0
	 */
	function __construct() {
		$this->id   = 'links';
		$this->desc = __( 'Links', 'external-products-currency-for-woocommerce' );
		parent::__construct();
	}

	/**
	 * get_settings.
	 *
	 * @version 2.5.0
	 * @since   2.3.0
	 */
	function get_settings() {
		return array(
			array(
				'title'    => __( 'Links', 'external-products-currency-for-woocommerce' ),
				'desc'     => __( 'Make external/affiliate products links open in a new tab.', 'external-products-currency-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'alg_wc_external_products_link_options',
			),
			array(
				'title'    => __( 'Links', 'external-products-currency-for-woocommerce' ),
				'desc'     => '<strong>' . __( 'Enable section', 'external-products-currency-for-woocommerce' ) . '</strong>',
				'id'       => 'alg_wc_external_products_links_enabled',
				'default'  => 'yes',
				'type'     => 'checkbox',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_external_products_link_options',
			),
			array(
				'title'    => __( 'All Products', 'external-products-currency-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'alg_wc_external_products_links_all_products_options',
			),
			array(
				'title'    => __( 'Single', 'external-products-currency-for-woocommerce' ),
				'desc_tip' => __( 'Open link in a new tab for <strong>all</strong> external <strong>products</strong> on <strong>single product pages</strong>.', 'external-products-currency-for-woocommerce' ),
				'desc'     => __( 'Enable', 'external-products-currency-for-woocommerce' ),
				'id'       => 'alg_wc_external_products_link_new_tab_single_enabled',
				'default'  => 'no',
				'type'     => 'checkbox',
			),
			array(
				'title'    => __( 'Archives', 'external-products-currency-for-woocommerce' ),
				'desc_tip' => __( 'Open link in a new tab for <strong>all</strong> external <strong>products</strong> on <strong>archives</strong>.', 'external-products-currency-for-woocommerce' ),
				'desc'     => __( 'Enable', 'external-products-currency-for-woocommerce' ),
				'id'       => 'alg_wc_external_products_link_new_tab_loop_enabled',
				'default'  => 'no',
				'type'     => 'checkbox',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_external_products_links_all_products_options',
			),
			array(
				'title'             => __( 'Per Product', 'external-products-currency-for-woocommerce' ),
				'type'              => 'title',
				'id'                => 'alg_wc_external_products_links_per_product_options',
			),
			array(
				'title'             => __( 'Single', 'external-products-currency-for-woocommerce' ),
				'desc_tip'          => (
					__( 'Open link in a new tab for external products on a <strong>per-product</strong> basis on <strong>single product pages</strong>.', 'external-products-currency-for-woocommerce' ) . ' ' .
					__( 'This will add "Link in a new tab" input field to each product\'s edit page.', 'external-products-currency-for-woocommerce' ) . ' ' .
					apply_filters(
						'alg_wc_advanced_external_products_settings',
						sprintf(
							'<br>To enable link on a <strong>per-product basis</strong>, please get <a target="_blank" href="%s">Multiple External Products URLs & Currencies for WooCommerce Pro</a> plugin.',
							'https://wpfactory.com/item/advanced-external-products-for-woocommerce/'
						)
					)
				),
				'desc'              => __( 'Enable', 'external-products-currency-for-woocommerce' ),
				'id'                => 'alg_wc_external_products_link_per_product_single_enabled',
				'default'           => 'no',
				'type'              => 'checkbox',
				'custom_attributes' => apply_filters(
					'alg_wc_advanced_external_products_settings',
					array( 'disabled' => 'disabled' )
				),
			),
			array(
				'title'             => __( 'Archives', 'external-products-currency-for-woocommerce' ),
				'desc_tip'          => (
					__( 'Open link in a new tab for external products on a <strong>per-product</strong> basis on <strong>archives</strong>.', 'external-products-currency-for-woocommerce' ) . ' ' .
					__( 'This will add "Link in a new tab on archives" input field to each product\'s edit page.', 'external-products-currency-for-woocommerce' ) . ' ' .
					apply_filters(
						'alg_wc_advanced_external_products_settings',
						sprintf(
							'<br>To enable link on a <strong>per-product basis</strong>, please get <a target="_blank" href="%s">Multiple External Products URLs & Currencies for WooCommerce Pro</a> plugin.',
							'https://wpfactory.com/item/advanced-external-products-for-woocommerce/'
						)
					)
				),
				'desc'              => __( 'Enable', 'external-products-currency-for-woocommerce' ),
				'id'                => 'alg_wc_external_products_link_per_product_loop_enabled',
				'default'           => 'no',
				'type'              => 'checkbox',
				'custom_attributes' => apply_filters(
					'alg_wc_advanced_external_products_settings',
					array( 'disabled' => 'disabled' )
				),
			),
			array(
				'type'              => 'sectionend',
				'id'                => 'alg_wc_external_products_links_per_product_options',
			),
		);
	}

}

endif;

return new Alg_WC_AEP_Settings_Links();
