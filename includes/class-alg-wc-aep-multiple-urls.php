<?php
/**
 * Advanced External Products for WooCommerce - Multiple URLs Class
 *
 * @version 2.6.0
 * @since   2.3.0
 *
 * @author WPFactory
 *
 * @package WPFactory\WC_Advanced_External_Products
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Alg_WC_AEP_Multiple_URLs' ) ) :

	/**
	 * Alg_WC_AEP_Multiple_URLs class.
	 *
	 * @version 2.6.0
	 * @since   2.3.0
	 */
	class Alg_WC_AEP_Multiple_URLs {

		/**
		 * URL.
		 *
		 * @version 2.4.3
		 * @since   2.4.3
		 *
		 * @var string|false
		 */
		public $url;

		/**
		 * Button text.
		 *
		 * @version 2.4.3
		 * @since   2.4.3
		 *
		 * @var string|false
		 */
		public $txt;

		/**
		 * Constructor.
		 *
		 * @version 2.6.0
		 * @since   2.3.0
		 *
		 * @todo (feature) Multiple URLs by IP (country), user role, etc; e.g.: `https://example.com|Buy at example.com|administrator`?
		 */
		public function __construct() {
			// Props.
			$this->url = false;
			$this->txt = false;

			// Single and Loop.
			add_action( 'woocommerce_after_add_to_cart_form', array( $this, 'single' ) );
			add_action( 'woocommerce_after_shop_loop_item', array( $this, 'loop' ) );

			// URL and Text.
			add_action( 'woocommerce_product_add_to_cart_url', array( $this, 'set_url' ) );
			add_action( 'woocommerce_product_add_to_cart_text', array( $this, 'set_txt' ) );
			add_action( 'woocommerce_product_single_add_to_cart_text', array( $this, 'set_txt' ) );

			// Admin.
			add_action( 'woocommerce_product_options_external', array( $this, 'add_admin_field' ) );
			add_action( 'save_post_product', array( $this, 'save_admin_field' ), PHP_INT_MAX );

			// Module loaded action.
			do_action( 'alg_wc_aep_multiple_urls_module_loaded', $this );
		}

		/**
		 * Save admin field.
		 *
		 * @version 2.6.0
		 * @since   2.3.0
		 *
		 * @param int $post_id The ID of the post being saved.
		 */
		public function save_admin_field( $post_id ) {
			if ( ! isset( $_REQUEST['_alg_wc_aep_product_urls'] ) ) {
				return;
			}

			$product = wc_get_product( $post_id );
			if ( ! $product ) {
				return;
			}

			if (
				! isset( $_POST['_alg_wc_aep_product_urls_nonce'] ) ||
				! wp_verify_nonce(
					sanitize_text_field( wp_unslash( $_POST['_alg_wc_aep_product_urls_nonce'] ) ),
					'alg_wc_aep_product_urls'
				)
			) {
				return;
			}

			$product->add_meta_data(
				'_alg_wc_aep_product_urls',
				sanitize_textarea_field( wp_unslash( $_REQUEST['_alg_wc_aep_product_urls'] ) ),
				true
			);
			$product->save();
		}

		/**
		 * Add admin field.
		 *
		 * @version 2.5.0
		 * @since   2.3.0
		 */
		public function add_admin_field() {
			if ( ! alg_wc_aep_is_external_product() ) {
				return;
			}

			$this->woocommerce_wp_textarea_input(
				array(
					'id'          => '_alg_wc_aep_product_urls',
					'label'       => __( 'Extra product URLs', 'external-products-currency-for-woocommerce' ),
					'placeholder' => '',
					'desc_tip'    => (
						__( 'Additional URLs. One URL per line.', 'external-products-currency-for-woocommerce' ) . ' ' .
						__( 'Please note that the main/default "Product URL" option must also be set.', 'external-products-currency-for-woocommerce' )
					),
					'description' => sprintf(
						/* Translators: %1$s: First format, %2$s: Second format, %3$s: Third format. */
						__( 'Accepted formats: %1$s, %2$s or %3$s.', 'external-products-currency-for-woocommerce' ),
						'<code>url</code>',
						'<code>url|button_text</code>',
						'<code>url|button_text|option_label</code>'
					),
					'style'       => 'height:100px;',
				)
			);
			wp_nonce_field(
				'alg_wc_aep_product_urls',
				'_alg_wc_aep_product_urls_nonce'
			);
		}

		/**
		 * WooCommerce WP textarea input.
		 *
		 * `description` and `desc_tip` modifications.
		 *
		 * @version 2.6.0
		 * @since   2.4.2
		 *
		 * @param array        $field Field settings.
		 * @param WC_Data|null $data  The WooCommerce data object (optional).
		 *
		 * @see https://github.com/woocommerce/woocommerce/blob/8.0.1/plugins/woocommerce/includes/admin/wc-meta-box-functions.php#L105
		 */
		public function woocommerce_wp_textarea_input( $field, ?WC_Data $data = null ) {
			global $post;

			$field['placeholder']   = $field['placeholder'] ?? '';
			$field['class']         = $field['class'] ?? 'short';
			$field['style']         = $field['style'] ?? '';
			$field['wrapper_class'] = $field['wrapper_class'] ?? '';
			$field['value']         = (
				$field['value'] ??
				Automattic\WooCommerce\Utilities\OrderUtil::get_post_or_object_meta( $post, $data, $field['id'], true )
			);
			$field['name']          = $field['name'] ?? $field['id'];
			$field['rows']          = $field['rows'] ?? 2;
			$field['cols']          = $field['cols'] ?? 20;

			// Custom attribute handling.
			$custom_attributes = array();

			if (
				! empty( $field['custom_attributes'] ) &&
				is_array( $field['custom_attributes'] )
			) {
				foreach ( $field['custom_attributes'] as $attribute => $value ) {
					$custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $value ) . '"';
				}
			}

			echo '<p class="form-field ' . esc_attr( $field['id'] ) . '_field ' . esc_attr( $field['wrapper_class'] ) . '">
				<label for="' . esc_attr( $field['id'] ) . '">' .
					wp_kses_post( $field['label'] ) .
				'</label>';

			if ( ! empty( $field['desc_tip'] ) ) {
				echo wc_help_tip( $field['desc_tip'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			echo '<textarea' .
				' class="' . esc_attr( $field['class'] ) . '"' .
				' style="' . esc_attr( $field['style'] ) . '"' .
				' name="' . esc_attr( $field['name'] ) . '"' .
				' id="' . esc_attr( $field['id'] ) . '"' .
				' placeholder="' . esc_attr( $field['placeholder'] ) . '"' .
				' rows="' . esc_attr( $field['rows'] ) . '"' .
				' cols="' . esc_attr( $field['cols'] ) . '"' .
				' ' . implode( ' ', $custom_attributes ) . // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			'>' .
				esc_textarea( $field['value'] ) .
			'</textarea> ';

			if ( ! empty( $field['description'] ) ) {
				echo '<span class="description" style="display: block; clear: both; margin-left: 0;">' .
					wp_kses_post( $field['description'] ) .
				'</span>';
			}

			echo '</p>';
		}

		/**
		 * Get URLs.
		 *
		 * @version 2.6.0
		 * @since   2.3.0
		 *
		 * @param WC_Product|false $product Product object or false.
		 *
		 * @return array
		 */
		public function get_urls( $product = false ) {
			$product = alg_wc_aep_get_current_product();
			if ( ! $product ) {
				return array();
			}
			$data = $product->get_meta( '_alg_wc_aep_product_urls' );
			if ( '' === $data ) {
				return array();
			}

			$data = array_map( 'trim', explode( PHP_EOL, $data ) );
			$res  = array();
			foreach ( $data as $url ) {
				$url   = array_map( 'trim', explode( '|', $url ) );
				$res[] = array(
					'url'   => $url[0],
					'txt'   => ( $url[1] ?? false ),
					'label' => ( $url[2] ?? false ),
				);
			}
			return $res;
		}

		/**
		 * Set data.
		 *
		 * @version 2.3.0
		 * @since   2.3.0
		 *
		 * @param array $data Data.
		 */
		public function set_data( $data ) {
			$this->url = $data['url'];
			$this->txt = $data['txt'];
		}

		/**
		 * Clear data.
		 *
		 * @version 2.3.0
		 * @since   2.3.0
		 */
		public function clear_data() {
			$this->url = false;
			$this->txt = false;
		}

		/**
		 * Set URL.
		 *
		 * @version 2.6.0
		 * @since   2.3.0
		 *
		 * @param string $url URL to set.
		 */
		public function set_url( $url ) {
			return ( false !== $this->url ? $this->url : $url );
		}

		/**
		 * Set text.
		 *
		 * @version 2.6.0
		 * @since   2.3.0
		 *
		 * @param string $txt Text to set.
		 */
		public function set_txt( $txt ) {
			return ( false !== $this->txt ? $this->txt : $txt );
		}

		/**
		 * Loop.
		 *
		 * @version 2.4.0
		 * @since   2.3.0
		 */
		public function loop() {
			if (
				apply_filters( 'alg_wc_aep_multiple_urls_loop', true ) &&
				'yes' === get_option( 'alg_wc_external_products_multiple_urls_loop_enabled', 'no' ) &&
				alg_wc_aep_is_external_product()
			) {
				foreach ( $this->get_urls() as $data ) {
					$this->set_data( $data );
					woocommerce_template_loop_add_to_cart();
					$this->clear_data();
				}
			}
		}

		/**
		 * Single.
		 *
		 * @version 2.4.0
		 * @since   2.3.0
		 */
		public function single() {
			if (
				apply_filters( 'alg_wc_aep_multiple_urls_single', true ) &&
				'yes' === get_option( 'alg_wc_external_products_multiple_urls_single_enabled', 'no' ) &&
				alg_wc_aep_is_external_product()
			) {
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
