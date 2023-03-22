<?php
/**
 * Advanced External Products for WooCommerce - Core Class
 *
 * @version 2.3.0
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
	 * @version 2.3.0
	 * @since   1.0.0
	 *
	 * @todo    [next] (dev) remove this class?
	 */
	function __construct() {

		// Functions
		require_once( 'alg-wc-aep-functions.php' );

		// Currency
		if ( 'yes' === get_option( 'alg_wc_external_products_currency_enabled', 'yes' ) ) {
			require_once( 'class-alg-wc-aep-currency.php' );
		}

		// Links
		if ( 'yes' === get_option( 'alg_wc_external_products_links_enabled', 'yes' ) ) {
			require_once( 'class-alg-wc-aep-links.php' );
		}

		// Multiple product URLs
		if ( 'yes' === get_option( 'alg_wc_external_products_multiple_urls_enabled', 'yes' ) ) {
			require_once( 'class-alg-wc-aep-multiple-urls.php' );
		}

		// Core loaded action
		do_action( 'alg_wc_advanced_external_products_core_loaded', $this );

	}

}

endif;

return new Alg_WC_AEP_Core();
