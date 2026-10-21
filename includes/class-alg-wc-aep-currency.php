<?php
/**
 * Advanced External Products for WooCommerce - Currency Class
 *
 * @version 2.6.0
 * @since   2.3.0
 *
 * @author WPFactory
 *
 * @package WPFactory\WC_Advanced_External_Products
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Alg_WC_AEP_Currency' ) ) :

	/**
	 * Alg_WC_AEP_Currency class.
	 *
	 * @version 2.6.0
	 * @since   2.3.0
	 */
	class Alg_WC_AEP_Currency {

		/**
		 * Constructor.
		 *
		 * @version 2.3.0
		 * @since   2.3.0
		 *
		 * @todo (feature) Customizable currency symbol: per product?
		 * @todo (feature) Customizable price format (all products and per product)?
		 * @todo (feature) Option to set custom currency directly (e.g., virtual currency)?
		 */
		public function __construct() {
			// Hooks.
			add_filter( 'woocommerce_currency', array( $this, 'change_currency_code' ), PHP_INT_MAX );
			add_filter( 'woocommerce_currency_symbol', array( $this, 'change_currency_symbol' ), PHP_INT_MAX, 2 );

			// Module loaded action.
			do_action( 'alg_wc_aep_currency_module_loaded', $this );
		}

		/**
		 * Change currency code.
		 *
		 * @version 2.6.0
		 * @since   1.0.0
		 *
		 * @param string $currency The current currency code.
		 *
		 * @return string The modified currency code.
		 *
		 * @todo (dev) Use `alg_wc_aep_get_current_product()`?
		 */
		public function change_currency_code( $currency ) {
			$product_id = get_the_ID();
			if ( ! $product_id ) {
				return $currency;
			}
			$product = wc_get_product( $product_id );
			if ( ! $product ) {
				return $currency;
			}
			if ( ! alg_wc_aep_is_external_product( $product ) ) {
				return $currency;
			}

			$external_currency = apply_filters( 'alg_wc_advanced_external_products_currency', false, $product );
			if ( false !== $external_currency ) {
				return $external_currency;
			} elseif ( 'yes' === get_option( 'alg_wc_external_products_currency_all_products_enabled', 'no' ) ) {
				return get_option( 'alg_wc_external_products_currency_all_products', get_option( 'woocommerce_currency' ) );
			}

			return $currency;
		}

		/**
		 * Change currency symbol.
		 *
		 * @version 2.6.0
		 * @since   2.1.0
		 *
		 * @param string $currency_symbol The current currency symbol.
		 * @param string $currency The current currency code.
		 *
		 * @return string The modified currency symbol.
		 *
		 * @todo (dev) Use `alg_wc_aep_get_current_product()`?
		 */
		public function change_currency_symbol( $currency_symbol, $currency ) {
			if ( 'yes' !== get_option( 'alg_wc_external_products_currency_symbol_enabled', 'no' ) ) {
				return $currency_symbol;
			}
			$product_id = get_the_ID();
			if ( ! $product_id ) {
				return $currency_symbol;
			}
			$product = wc_get_product( $product_id );
			if ( ! $product ) {
				return $currency_symbol;
			}
			if ( ! alg_wc_aep_is_external_product( $product ) ) {
				return $currency_symbol;
			}

			return str_replace(
				array( '%currency_symbol%', '%currency_code%' ),
				array( $currency_symbol, $currency ),
				get_option( 'alg_wc_external_products_currency_symbol', '%currency_symbol%' )
			);
		}
	}

endif;

return new Alg_WC_AEP_Currency();
