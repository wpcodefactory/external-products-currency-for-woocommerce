<?php
/**
 * Advanced External Products for WooCommerce - Functions
 *
 * @version 2.3.0
 * @since   2.0.0
 *
 * @author  Algoritmika Ltd.
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'alg_wc_aep_get_current_product' ) ) {
	/**
	 * alg_wc_aep_get_current_product.
	 *
	 * @version 2.3.0
	 * @since   2.3.0
	 */
	function alg_wc_aep_get_current_product( $the_product = false ) {

		$product = wc_get_product( $the_product );

		if ( ! $product || ! is_object( $product ) || ! is_a( $product, 'WC_Product' ) ) {
			global $product;
		}

		if ( ! $product || ! is_object( $product ) || ! is_a( $product, 'WC_Product' ) ) {
			return false;
		}

		return $product;

	}
}

if ( ! function_exists( 'alg_wc_aep_is_external_product' ) ) {
	/**
	 * alg_wc_aep_is_external_product.
	 *
	 * @version 2.3.0
	 * @since   2.0.0
	 */
	function alg_wc_aep_is_external_product( $product = false ) {

		if ( ! $product || ! is_object( $product ) || ! is_a( $product, 'WC_Product' ) ) {
			$product = alg_wc_aep_get_current_product( $product );
		}

		return (
			$product &&
			method_exists( $product, 'is_type' ) &&
			$product->is_type( 'external' )
		);

	}
}
