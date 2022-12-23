<?php
/**
 * Advanced External Products for WooCommerce - Core Class
 *
 * @version 2.2.0
 * @since   1.0.0
 *
 * @author  Algoritmika Ltd.
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Alg_WC_AEP_Core' ) ) :

class Alg_WC_AEP_Core {

	/**
	 * Constructor.
	 *
	 * @version 2.2.0
	 * @since   1.0.0
	 *
	 * @todo    [maybe] (dev) link: alternative way for opening link in new tab (e.g. replace whole `external.php` template)
	 * @todo    [next] (feature) multiple links (i.e. multiple "Product URL" e.g. by IP (country) / user role)
	 * @todo    [maybe] (feature) currency: customizable currency symbol: per product
	 * @todo    [maybe] (feature) currency: customizable price format (all products and per product)
	 * @todo    [maybe] (feature) currency: option to set custom currency directly (e.g. virtual currency)
	 */
	function __construct() {

		// Functions
		require_once( 'alg-wc-aep-functions.php' );

		// Core
		if ( 'yes' === get_option( 'alg_wc_external_products_plugin_enabled', 'yes' ) ) {
			$this->init_options();
			$this->add_hooks();
		}

		// Action: Core loaded
		do_action( 'alg_wc_advanced_external_products_core_loaded', $this );

	}

	/**
	 * init_options.
	 *
	 * @version 2.1.0
	 * @since   2.0.0
	 */
	function init_options() {

		// Currency
		$this->enabled_all_products     = ( 'yes' === get_option( 'alg_wc_external_products_currency_all_products_enabled', 'no' ) );
		$this->currency_all_products    = get_option( 'alg_wc_external_products_currency_all_products', get_option( 'woocommerce_currency' ) );
		$this->enabled_custom_symbol    = ( 'yes' === get_option( 'alg_wc_external_products_currency_symbol_enabled', 'no' ) );
		$this->template_custom_symbol   = get_option( 'alg_wc_external_products_currency_symbol', '%currency_symbol%' );

		// Link
		$this->link_all_products_single = ( 'yes' === get_option( 'alg_wc_external_products_link_new_tab_single_enabled', 'no' ) );
		$this->link_all_products_loop   = ( 'yes' === get_option( 'alg_wc_external_products_link_new_tab_loop_enabled',   'no' ) );

	}

	/**
	 * add_hooks.
	 *
	 * @version 2.1.0
	 * @since   2.0.0
	 */
	function add_hooks() {

		// Currency
		add_filter( 'woocommerce_currency',                array( $this, 'change_currency_code' ), PHP_INT_MAX );
		add_filter( 'woocommerce_currency_symbol',         array( $this, 'change_currency_symbol' ), PHP_INT_MAX, 2 );

		// Link
		add_action( 'woocommerce_before_add_to_cart_form', array( $this, 'add_to_cart_single_start' ) );
		add_action( 'woocommerce_after_add_to_cart_form',  array( $this, 'add_to_cart_single_end' ) );
		add_filter( 'woocommerce_loop_add_to_cart_link',   array( $this, 'add_to_cart_loop' ), PHP_INT_MAX, 3 );

	}

	/**
	 * add_to_cart_loop.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	function add_to_cart_loop( $link, $product, $args ) {
		if ( alg_wc_aep_is_external_product( $product ) ) {
			if ( ! $this->link_all_products_loop && ! apply_filters( 'alg_wc_advanced_external_products_link_loop', false, $product ) ) {
				return $link;
			}
			return str_replace( '<a', '<a target="_blank"', $link );
		}
		return $link;
	}

	/**
	 * add_to_cart_single_start.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	function add_to_cart_single_start() {
		if ( alg_wc_aep_is_external_product() ) {
			if ( ! $this->link_all_products_single && ! apply_filters( 'alg_wc_advanced_external_products_link_single', false ) ) {
				return;
			}
			$this->add_to_cart_form_started = true;
			ob_start();
		}
	}

	/**
	 * add_to_cart_single_end.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	function add_to_cart_single_end() {
		if ( alg_wc_aep_is_external_product() && ! empty( $this->add_to_cart_form_started ) ) {
			$output = ob_get_clean();
			$output = str_replace( '<form', '<form target="_blank"', $output );
			echo $output;
			$this->add_to_cart_form_started = false;
		}
	}

	/**
	 * change_currency_code.
	 *
	 * @version 2.1.0
	 * @since   1.0.0
	 */
	function change_currency_code( $currency ) {
		if ( ( $product_id = get_the_ID() ) && ( $product = wc_get_product( $product_id ) ) && alg_wc_aep_is_external_product( $product ) ) {
			if ( false !== ( $external_currency = apply_filters( 'alg_wc_advanced_external_products_currency', false, $product ) ) ) {
				return $external_currency;
			} elseif ( $this->enabled_all_products ) {
				return $this->currency_all_products;
			}
		}
		return $currency;
	}

	/**
	 * change_currency_symbol.
	 *
	 * @version 2.1.0
	 * @since   2.1.0
	 */
	function change_currency_symbol( $currency_symbol, $currency ) {
		if ( $this->enabled_custom_symbol && ( $product_id = get_the_ID() ) && ( $product = wc_get_product( $product_id ) ) && alg_wc_aep_is_external_product( $product ) ) {
			return str_replace( array( '%currency_symbol%', '%currency_code%' ), array( $currency_symbol, $currency ), $this->template_custom_symbol );
		}
		return $currency_symbol;
	}

}

endif;

return new Alg_WC_AEP_Core();
