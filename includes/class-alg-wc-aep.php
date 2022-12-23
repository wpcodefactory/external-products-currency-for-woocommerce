<?php
/**
 * Advanced External Products for WooCommerce - Main Class
 *
 * @version 2.2.0
 * @since   1.0.0
 *
 * @author  Algoritmika Ltd.
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Alg_WC_AEP' ) ) :

final class Alg_WC_AEP {

	/**
	 * Plugin version.
	 *
	 * @var   string
	 * @since 1.0.0
	 */
	public $version = ALG_WC_AEP_VERSION;

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
	 *
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
	 * @version 2.2.0
	 * @since   1.0.0
	 *
	 * @access  public
	 */
	function __construct() {

		// Check for active WooCommerce plugin
		if ( ! function_exists( 'WC' ) ) {
			return;
		}

		// Set up localisation
		add_action( 'init', array( $this, 'localize' ) );

		// Pro
		if ( 'external-products-currency-for-woocommerce-pro.php' === basename( ALG_WC_AEP_FILE ) ) {
			require_once( 'pro/class-alg-wc-aep-pro.php' );
		}

		// Include required files
		$this->includes();

		// Admin
		if ( is_admin() ) {
			$this->admin();
		}

	}

	/**
	 * localize.
	 *
	 * @version 2.2.0
	 * @since   2.2.0
	 */
	function localize() {
		load_plugin_textdomain( 'external-products-currency-for-woocommerce', false, dirname( plugin_basename( ALG_WC_AEP_FILE ) ) . '/langs/' );
	}

	/**
	 * Include required core files used in admin and on the frontend.
	 *
	 * @version 2.2.0
	 * @since   1.0.0
	 */
	function includes() {
		// Core
		$this->core = require_once( 'class-alg-wc-aep-core.php' );
	}

	/**
	 * admin.
	 *
	 * @version 2.2.0
	 * @since   2.0.0
	 */
	function admin() {
		// Action links
		add_filter( 'plugin_action_links_' . plugin_basename( ALG_WC_AEP_FILE ), array( $this, 'action_links' ) );
		// Settings
		add_filter( 'woocommerce_get_settings_pages', array( $this, 'add_woocommerce_settings_tab' ) );
		// Version update
		if ( get_option( 'alg_wc_advanced_external_products_version', '' ) !== $this->version ) {
			add_action( 'admin_init', array( $this, 'version_updated' ) );
		}
	}

	/**
	 * Show action links on the plugin screen.
	 *
	 * @version 2.2.0
	 * @since   1.0.0
	 *
	 * @param   mixed $links
	 * @return  array
	 */
	function action_links( $links ) {
		$custom_links = array();
		$custom_links[] = '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=alg_wc_advanced_external_products' ) . '">' . __( 'Settings', 'woocommerce' ) . '</a>';
		if ( 'external-products-currency-for-woocommerce.php' === basename( ALG_WC_AEP_FILE ) ) {
			$custom_links[] = '<a target="_blank" style="font-weight: bold; color: green;" href="https://wpfactory.com/item/advanced-external-products-for-woocommerce/">' .
				__( 'Go Pro', 'external-products-currency-for-woocommerce' ) . '</a>';
		}
		return array_merge( $custom_links, $links );
	}

	/**
	 * Add Advanced External Products settings tab to WooCommerce settings.
	 *
	 * @version 2.2.0
	 * @since   1.0.0
	 */
	function add_woocommerce_settings_tab( $settings ) {
		$settings[] = require_once( 'settings/class-alg-wc-settings-aep.php' );
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
	 * @version 2.2.0
	 * @since   1.0.0
	 *
	 * @return  string
	 */
	function plugin_url() {
		return untrailingslashit( plugin_dir_url( ALG_WC_AEP_FILE ) );
	}

	/**
	 * Get the plugin path.
	 *
	 * @version 2.2.0
	 * @since   1.0.0
	 *
	 * @return  string
	 */
	function plugin_path() {
		return untrailingslashit( plugin_dir_path( ALG_WC_AEP_FILE ) );
	}

}

endif;
