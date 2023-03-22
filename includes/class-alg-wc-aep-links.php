<?php
/**
 * Advanced External Products for WooCommerce - Links Class
 *
 * @version 2.3.0
 * @since   2.3.0
 *
 * @author  Algoritmika Ltd.
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Alg_WC_AEP_Links' ) ) :

class Alg_WC_AEP_Links {

	/**
	 * Constructor.
	 *
	 * @version 2.3.0
	 * @since   2.3.0
	 *
	 * @todo    [maybe] (dev) alternative way for opening link in new tab (e.g., replace whole `external.php` template)
	 */
	function __construct() {

		// Hooks
		add_action( 'woocommerce_before_add_to_cart_form', array( $this, 'add_to_cart_single_start' ) );
		add_action( 'woocommerce_after_add_to_cart_form',  array( $this, 'add_to_cart_single_end' ) );
		add_filter( 'woocommerce_loop_add_to_cart_link',   array( $this, 'add_to_cart_loop' ), PHP_INT_MAX, 3 );

		// Module loaded action
		do_action( 'alg_wc_aep_links_module_loaded', $this );

	}

	/**
	 * add_to_cart_loop.
	 *
	 * @version 2.3.0
	 * @since   2.0.0
	 */
	function add_to_cart_loop( $link, $product, $args ) {
		if ( alg_wc_aep_is_external_product( $product ) ) {
			if (
				'no' === get_option( 'alg_wc_external_products_link_new_tab_loop_enabled', 'no' ) &&
				! apply_filters( 'alg_wc_advanced_external_products_link_loop', false, $product )
			) {
				return $link;
			}
			return str_replace( '<a', '<a target="_blank"', $link );
		}
		return $link;
	}

	/**
	 * add_to_cart_single_start.
	 *
	 * @version 2.3.0
	 * @since   2.0.0
	 */
	function add_to_cart_single_start() {
		if ( alg_wc_aep_is_external_product() ) {
			if (
				'no' === get_option( 'alg_wc_external_products_link_new_tab_single_enabled', 'no' ) &&
				! apply_filters( 'alg_wc_advanced_external_products_link_single', false )
			) {
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

}

endif;

return new Alg_WC_AEP_Links();
