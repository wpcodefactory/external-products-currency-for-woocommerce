<?php
/**
 * Advanced External Products for WooCommerce - Links Class
 *
 * @version 2.6.0
 * @since   2.3.0
 *
 * @author WPFactory
 *
 * @package WPFactory\WC_Advanced_External_Products
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Alg_WC_AEP_Links' ) ) :

	/**
	 * Alg_WC_AEP_Links class.
	 *
	 * @version 2.6.0
	 * @since   2.3.0
	 */
	class Alg_WC_AEP_Links {

		/**
		 * Add-to-cart form started.
		 *
		 * @version 2.5.0
		 * @since   2.5.0
		 *
		 * @var bool
		 */
		public $add_to_cart_form_started;

		/**
		 * Constructor.
		 *
		 * @version 2.6.0
		 * @since   2.3.0
		 *
		 * @todo (dev) Alternative way for opening link in new tab (e.g., replace whole `external.php` template)?
		 */
		public function __construct() {
			// Hooks.
			add_action( 'woocommerce_before_add_to_cart_form', array( $this, 'add_to_cart_single_start' ) );
			add_action( 'woocommerce_after_add_to_cart_form', array( $this, 'add_to_cart_single_end' ) );
			add_filter( 'woocommerce_loop_add_to_cart_link', array( $this, 'add_to_cart_loop' ), PHP_INT_MAX, 2 );

			// Module loaded action.
			do_action( 'alg_wc_aep_links_module_loaded', $this );
		}

		/**
		 * Add-to-cart loop.
		 *
		 * @version 2.6.0
		 * @since   2.0.0
		 *
		 * @param string     $link    The add-to-cart link HTML.
		 * @param WC_Product $product The product object.
		 *
		 * @return string Modified add-to-cart link HTML.
		 */
		public function add_to_cart_loop( $link, $product ) {
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
		 * Add-to-cart single start.
		 *
		 * @version 2.3.0
		 * @since   2.0.0
		 */
		public function add_to_cart_single_start() {
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
		 * Add-to-cart single end.
		 *
		 * @version 2.0.0
		 * @since   2.0.0
		 */
		public function add_to_cart_single_end() {
			if (
				alg_wc_aep_is_external_product() &&
				! empty( $this->add_to_cart_form_started )
			) {
				$output = ob_get_clean();
				$output = str_replace( '<form', '<form target="_blank"', $output );
				echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				$this->add_to_cart_form_started = false;
			}
		}
	}

endif;

return new Alg_WC_AEP_Links();
