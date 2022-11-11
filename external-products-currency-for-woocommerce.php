<?php
/*
Plugin Name: Advanced External Products for WooCommerce
Plugin URI: https://wpfactory.com/item/advanced-external-products-for-woocommerce/
Description: Get more control over external/affiliate products in WooCommerce.
Version: 2.1.0
Author: Algoritmika Ltd
Author URI: https://algoritmika.com
Text Domain: external-products-currency-for-woocommerce
Domain Path: /langs
Copyright: © 2020 Algoritmika Ltd.
WC tested up to: 4.3
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_AEP' ) ) :

/**
 * Main Alg_WC_AEP Class
 *
 * @class   Alg_WC_AEP
 * @version 2.1.0
 * @since   1.0.0
 */
final class Alg_WC_AEP {

	/**
	 * Plugin version.
	 *
	 * @var   string
	 * @since 1.0.0
	 */
	public $version = '2.1.0';

	/**
	 * @var   Alg_WC_AEP The single instance of the class
	 * @since 1.0.0
	 */
	protected static $_instance = null;

	/**
	 * Main Alg_WC_AEP Instance
	 *
	 * Ensures only one instance of Alg_WC_AEP is loaded or can be loaded.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @static
	 * @return  Alg_WC_AEP - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Alg_WC_AEP Constructor.
	 *
	 * @version 2.0.0
	 * @since   1.0.0
	 * @access  public
	 */
	function __construct() {

		// Check for active plugins
		if (
			! $this->is_plugin_active( 'woocommerce/woocommerce.php' ) ||
			( 'external-products-currency-for-woocommerce.php' === basename( __FILE__ ) && $this->is_plugin_active( 'external-products-currency-for-woocommerce-pro/external-products-currency-for-woocommerce-pro.php' ) )
		) {
			return;
		}

		// Set up localisation
		load_plugin_textdomain( 'external-products-currency-for-woocommerce', false, dirname( plugin_basename( __FILE__ ) ) . '/langs/' );

		// Pro
		if ( 'external-products-currency-for-woocommerce-pro.php' === basename( __FILE__ ) ) {
			require_once( 'includes/pro/class-alg-wc-aep-pro.php' );
		}

		// Include required files
		$this->includes();

		// Admin
		if ( is_admin() ) {
			$this->admin();
		}
	}

	/**
	 * is_plugin_active.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	function is_plugin_active( $plugin ) {
		return ( function_exists( 'is_plugin_active' ) ? is_plugin_active( $plugin ) :
			(
				in_array( $plugin, apply_filters( 'active_plugins', ( array ) get_option( 'active_plugins', array() ) ) ) ||
				( is_multisite() && array_key_exists( $plugin, ( array ) get_site_option( 'active_sitewide_plugins', array() ) ) )
			)
		);
	}

	/**
	 * Include required core files used in admin and on the frontend.
	 *
	 * @version 2.0.0
	 * @since   1.0.0
	 */
	function includes() {
		// Functions
		require_once( 'includes/alg-wc-aep-functions.php' );
		// Core
		$this->core = require_once( 'includes/class-alg-wc-aep-core.php' );
	}

	/**
	 * admin.
	 *
	 * @version 2.1.0
	 * @since   2.0.0
	 */
	function admin() {
		// Action links
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'action_links' ) );
		// Settings
		add_filter( 'woocommerce_get_settings_pages', array( $this, 'add_woocommerce_settings_tab' ) );
		require_once( 'includes/settings/class-alg-wc-aep-settings-section.php' );
		// Version update
		if ( get_option( 'alg_wc_advanced_external_products_version', '' ) !== $this->version ) {
			add_action( 'admin_init', array( $this, 'version_updated' ) );
		}
	}

	/**
	 * Show action links on the plugin screen.
	 *
	 * @version 2.1.0
	 * @since   1.0.0
	 * @param   mixed $links
	 * @return  array
	 */
	function action_links( $links ) {
		$custom_links = array();
		$custom_links[] = '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=alg_wc_advanced_external_products' ) . '">' . __( 'Settings', 'woocommerce' ) . '</a>';
		if ( 'external-products-currency-for-woocommerce.php' === basename( __FILE__ ) ) {
			$custom_links[] = '<a target="_blank" style="font-weight: bold; color: green;" href="https://wpfactory.com/item/advanced-external-products-for-woocommerce/">' .
				__( 'Go Pro', 'external-products-currency-for-woocommerce' ) . '</a>';
		}
		return array_merge( $custom_links, $links );
	}

	/**
	 * Add Advanced External Products settings tab to WooCommerce settings.
	 *
	 * @version 2.0.0
	 * @since   1.0.0
	 */
	function add_woocommerce_settings_tab( $settings ) {
		$settings[] = require_once( 'includes/settings/class-alg-wc-settings-aep.php' );
		return $settings;
	}

	/**
	 * version_updated.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	function version_updated() {
		update_option( 'alg_wc_advanced_external_products_version', $this->version );
	}

	/**
	 * Get the plugin url.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @return  string
	 */
	function plugin_url() {
		return untrailingslashit( plugin_dir_url( __FILE__ ) );
	}

	/**
	 * Get the plugin path.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @return  string
	 */
	function plugin_path() {
		return untrailingslashit( plugin_dir_path( __FILE__ ) );
	}

}

endif;

if ( ! function_exists( 'alg_wc_advanced_external_products' ) ) {
	/**
	 * Returns the main instance of Alg_WC_AEP to prevent the need to use globals.
	 *
	 * @version 2.0.0
	 * @since   1.0.0
	 * @return  Alg_WC_AEP
	 */
	function alg_wc_advanced_external_products() {
		return Alg_WC_AEP::instance();
	}
}

alg_wc_advanced_external_products();
