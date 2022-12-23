<?php
/**
 * Advanced External Products for WooCommerce - Functions
 *
 * @version 2.0.0
 * @since   2.0.0
 *
 * @author  Algoritmika Ltd.
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'alg_wc_aep_is_external_product' ) ) {
	/**
	 * alg_wc_aep_is_external_product.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 *
	 * @todo    [dev] (maybe) use `global $product;` instead of `wc_get_product()`
	 */
	function alg_wc_aep_is_external_product( $product = false ) {
		if ( ! $product ) {
			$product = wc_get_product();
		}
		return ( $product && is_object( $product ) && is_a( $product, 'WC_Product' ) && method_exists( $product, 'is_type' ) && $product->is_type( 'external' ) );
	}
}
