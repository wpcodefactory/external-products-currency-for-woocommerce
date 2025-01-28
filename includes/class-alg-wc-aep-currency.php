<?php
/**
 * Advanced External Products for WooCommerce - Currency Class
 *
 * @version 2.3.0
 * @since   2.3.0
 *
 * @author  Algoritmika Ltd.
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Alg_WC_AEP_Currency' ) ) :

class Alg_WC_AEP_Currency {

	/**
	 * Constructor.
	 *
	 * @version 2.3.0
	 * @since   2.3.0
	 *
	 * @todo    (feature) customizable currency symbol: per product?
	 * @todo    (feature) customizable price format (all products and per product)?
	 * @todo    (feature) option to set custom currency directly (e.g., virtual currency)?
	 */
	function __construct() {

		// Hooks
		add_filter( 'woocommerce_currency',        array( $this, 'change_currency_code' ), PHP_INT_MAX );
		add_filter( 'woocommerce_currency_symbol', array( $this, 'change_currency_symbol' ), PHP_INT_MAX, 2 );

		// Module loaded action
		do_action( 'alg_wc_aep_currency_module_loaded', $this );

	}

	/**
	 * change_currency_code.
	 *
	 * @version 2.3.0
	 * @since   1.0.0
	 *
	 * @todo    (dev) use `alg_wc_aep_get_current_product()`?
	 */
	function change_currency_code( $currency ) {
		if (
			( $product_id = get_the_ID() ) &&
			( $product = wc_get_product( $product_id ) ) &&
			alg_wc_aep_is_external_product( $product )
		) {
			if ( false !== ( $external_currency = apply_filters( 'alg_wc_advanced_external_products_currency', false, $product ) ) ) {
				return $external_currency;
			} elseif ( 'yes' === get_option( 'alg_wc_external_products_currency_all_products_enabled', 'no' ) ) {
				return get_option( 'alg_wc_external_products_currency_all_products', get_option( 'woocommerce_currency' ) );
			}
		}
		return $currency;
	}

	/**
	 * change_currency_symbol.
	 *
	 * @version 2.3.0
	 * @since   2.1.0
	 *
	 * @todo    (dev) use `alg_wc_aep_get_current_product()`?
	 */
	function change_currency_symbol( $currency_symbol, $currency ) {
		if (
			( 'yes' === get_option( 'alg_wc_external_products_currency_symbol_enabled', 'no' ) ) &&
			( $product_id = get_the_ID() ) &&
			( $product = wc_get_product( $product_id ) ) &&
			alg_wc_aep_is_external_product( $product )
		) {
			return str_replace(
				array( '%currency_symbol%', '%currency_code%' ),
				array( $currency_symbol, $currency ),
				get_option( 'alg_wc_external_products_currency_symbol', '%currency_symbol%' )
			);
		}
		return $currency_symbol;
	}

}

endif;

return new Alg_WC_AEP_Currency();
