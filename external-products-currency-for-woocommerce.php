<?php
/*
Plugin Name: Advanced External Products for WooCommerce
Plugin URI: https://wpfactory.com/item/advanced-external-products-for-woocommerce/
Description: Adds more control over external/affiliate products in WooCommerce.
Version: 2.4.4
Author: WPFactory
Author URI: https://wpfactory.com
Text Domain: external-products-currency-for-woocommerce
Domain Path: /langs
WC tested up to: 8.1
*/

defined( 'ABSPATH' ) || exit;

if ( 'external-products-currency-for-woocommerce.php' === basename( __FILE__ ) ) {
	/**
	 * Check if Pro plugin version is activated.
	 *
	 * @version 2.4.3
	 * @since   2.2.0
	 */
	$plugin = 'external-products-currency-for-woocommerce-pro/external-products-currency-for-woocommerce-pro.php';
	if (
		in_array( $plugin, (array) get_option( 'active_plugins', array() ), true ) ||
		( is_multisite() && array_key_exists( $plugin, (array) get_site_option( 'active_sitewide_plugins', array() ) ) )
	) {
		defined( 'ALG_WC_AEP_FILE_FREE' ) || define( 'ALG_WC_AEP_FILE_FREE', __FILE__ );
		return;
	}
}

defined( 'ALG_WC_AEP_VERSION' ) || define( 'ALG_WC_AEP_VERSION', '2.4.4' );

defined( 'ALG_WC_AEP_FILE' ) || define( 'ALG_WC_AEP_FILE', __FILE__ );

require_once( 'includes/class-alg-wc-aep.php' );

if ( ! function_exists( 'alg_wc_advanced_external_products' ) ) {
	/**
	 * Returns the main instance of Alg_WC_AEP to prevent the need to use globals.
	 *
	 * @version 2.0.0
	 * @since   1.0.0
	 */
	function alg_wc_advanced_external_products() {
		return Alg_WC_AEP::instance();
	}
}

add_action( 'plugins_loaded', 'alg_wc_advanced_external_products' );
