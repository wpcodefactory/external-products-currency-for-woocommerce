<?php
/**
 * Advanced External Products for WooCommerce - Multiple URLs Class
 *
 * @version 2.3.0
 * @since   2.3.0
 *
 * @author  Algoritmika Ltd.
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Alg_WC_AEP_Multiple_URLs' ) ) :

class Alg_WC_AEP_Multiple_URLs {

	/**
	 * Constructor.
	 *
	 * @version 2.3.0
	 * @since   2.3.0
	 *
	 * @todo    [next] (feature) multiple URLs by IP (country), user role, etc; e.g.: `https://example.com|Buy at example.com|administrator`?
	 */
	function __construct() {

		// Props
		$this->url = false;
		$this->txt = false;

		// Single and Loop
		add_action( 'woocommerce_after_add_to_cart_form', array( $this, 'single' ) );
		add_action( 'woocommerce_after_shop_loop_item',   array( $this, 'loop' ) );

		// URL and Text
		add_action( 'woocommerce_product_add_to_cart_url',         array( $this, 'set_url' ), 10, 2 );
		add_action( 'woocommerce_product_add_to_cart_text',        array( $this, 'set_txt' ), 10, 2 );
		add_action( 'woocommerce_product_single_add_to_cart_text', array( $this, 'set_txt' ), 10, 2 );

		// Admin
		add_action( 'woocommerce_product_options_external', array( $this, 'add_admin_field' ) );
		add_action( 'save_post_product',                    array( $this, 'save_admin_field' ), PHP_INT_MAX, 2 );

		// Module loaded action
		do_action( 'alg_wc_aep_multiple_urls_module_loaded', $this );

	}

	/**
	 * save_admin_field.
	 *
	 * @version 2.3.0
	 * @since   2.3.0
	 */
	function save_admin_field( $post_id, $post ) {
		if ( isset( $_REQUEST['_alg_wc_aep_product_urls'] ) && ( $product = wc_get_product( $post_id ) ) ) {
			$product->add_meta_data( '_alg_wc_aep_product_urls', sanitize_textarea_field( $_REQUEST['_alg_wc_aep_product_urls'] ), true );
			$product->save();
		}
	}

	/**
	 * add_admin_field.
	 *
	 * @version 2.3.0
	 * @since   2.3.0
	 *
	 * @todo    [next] (desc) better description
	 */
	function add_admin_field() {
		if ( ! alg_wc_aep_is_external_product() ) {
			return;
		}
		woocommerce_wp_textarea_input(
			array(
				'id'          => '_alg_wc_aep_product_urls',
				'label'       => __( 'Extra product URLs', 'woocommerce' ),
				'placeholder' => '',
				'desc_tip'    => true,
				'description' => sprintf( __( 'Additional URLs. One URL per line. Accepted formats: %s or %s.', 'external-products-currency-for-woocommerce' ),
					'<code>url</code>', '<code>url|button_text</code>' ),
				'style'       => 'height:100px;',
			)
		);
	}

	/**
	 * get_urls.
	 *
	 * @version 2.3.0
	 * @since   2.3.0
	 */
	function get_urls( $product = false ) {
		if ( ! ( $product = alg_wc_aep_get_current_product() ) ) {
			return array();
		}
		$data = $product->get_meta( '_alg_wc_aep_product_urls' );
		$data = array_map( 'trim', explode( PHP_EOL, $data ) );
		$res  = array();
		foreach ( $data as $url ) {
			$url = array_map( 'trim', explode( '|', $url ) );
			$res[] = array(
				'url' => $url[0],
				'txt' => ( isset( $url[1] ) ? $url[1] : false ),
			);
		}
		return $res;
	}

	/**
	 * set_data.
	 *
	 * @version 2.3.0
	 * @since   2.3.0
	 */
	function set_data( $data ) {
		$this->url = $data['url'];
		$this->txt = $data['txt'];
	}

	/**
	 * clear_data.
	 *
	 * @version 2.3.0
	 * @since   2.3.0
	 */
	function clear_data() {
		$this->url = false;
		$this->txt = false;
	}

	/**
	 * set_url.
	 *
	 * @version 2.3.0
	 * @since   2.3.0
	 */
	function set_url( $url, $product ) {
		return ( false !== $this->url ? $this->url : $url );
	}

	/**
	 * set_txt.
	 *
	 * @version 2.3.0
	 * @since   2.3.0
	 */
	function set_txt( $txt, $product ) {
		return ( false !== $this->txt ? $this->txt : $txt );
	}

	/**
	 * loop.
	 *
	 * @version 2.3.0
	 * @since   2.3.0
	 */
	function loop() {
		if ( ( 'yes' === get_option( 'alg_wc_external_products_multiple_urls_loop_enabled', 'no' ) ) && alg_wc_aep_is_external_product() ) {
			foreach ( $this->get_urls() as $data ) {
				$this->set_data( $data );
				woocommerce_template_loop_add_to_cart();
				$this->clear_data();
			}
		}
	}

	/**
	 * single.
	 *
	 * @version 2.3.0
	 * @since   2.3.0
	 */
	function single() {
		if ( ( 'yes' === get_option( 'alg_wc_external_products_multiple_urls_single_enabled', 'no' ) ) && alg_wc_aep_is_external_product() ) {
			remove_action( 'woocommerce_after_add_to_cart_form', array( $this, 'single' ) );
			foreach ( $this->get_urls() as $data ) {
				$this->set_data( $data );
				woocommerce_external_add_to_cart();
				$this->clear_data();
			}
			add_action( 'woocommerce_after_add_to_cart_form', array( $this, 'single' ) );
		}
	}

}

endif;

return new Alg_WC_AEP_Multiple_URLs();
