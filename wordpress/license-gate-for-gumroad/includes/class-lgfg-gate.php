<?php
/**
 * Front end: shortcode, block, unlock form handling.
 *
 * @package LicenseGateForGumroad
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The content gate.
 */
class LGFG_Gate {

	/**
	 * Result of an unlock attempt in this request, keyed by product ID.
	 *
	 * @var array
	 */
	private static $results = array();

	/**
	 * Hook everything up.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register' ) );
		add_action( 'template_redirect', array( __CLASS__, 'handle_submission' ), 5 );
		add_action( 'template_redirect', array( __CLASS__, 'maybe_disable_page_cache' ), 6 );
	}

	/**
	 * Register the shortcode, style and block.
	 */
	public static function register() {
		add_shortcode( 'license_gate', array( __CLASS__, 'shortcode' ) );
		wp_register_style( 'lgfg-gate', LGFG_URL . 'assets/css/gate.css', array(), LGFG_VERSION );
		if ( function_exists( 'register_block_type' ) ) {
			register_block_type(
				LGFG_DIR . 'blocks/gate',
				array(
					'render_callback' => array( __CLASS__, 'render_block' ),
				)
			);
		}
	}

	/**
	 * [license_gate product_id="..."]Hidden content[/license_gate]
	 *
	 * @param array|string $atts    Attributes.
	 * @param string|null  $content Enclosed content.
	 * @return string
	 */
	public static function shortcode( $atts, $content = null ) {
		$atts = shortcode_atts(
			array(
				'product_id' => '',
				'message'    => '',
			),
			$atts,
			'license_gate'
		);
		return self::render( $atts['product_id'], do_shortcode( (string) $content ), $atts['message'] );
	}

	/**
	 * Dynamic block render callback.
	 *
	 * @param array  $attributes Block attributes.
	 * @param string $content    Inner blocks HTML.
	 * @return string
	 */
	public static function render_block( $attributes, $content ) {
		$product_id = isset( $attributes['productId'] ) ? $attributes['productId'] : '';
		$message    = isset( $attributes['message'] ) ? $attributes['message'] : '';
		return self::render( $product_id, $content, $message );
	}

	/**
	 * Show the content or the unlock form.
	 *
	 * @param string $product_id Product ID (falls back to the default from Settings).
	 * @param string $content    Gated HTML.
	 * @param string $message    Optional custom locked message.
	 * @return string
	 */
	public static function render( $product_id, $content, $message = '' ) {
		$product_id = LGFG_Settings::sanitize_product_id( $product_id );
		if ( '' === $product_id ) {
			$product_id = LGFG_Settings::get( 'default_product_id' );
		}

		if ( '' === $product_id ) {
			if ( current_user_can( 'edit_posts' ) ) {
				return '<p class="lgfg-notice">' . esc_html__( 'License Gate: set a Gumroad product ID on the gate or in Settings > License Gate.', 'license-gate-for-gumroad' ) . '</p>';
			}
			return '';
		}

		if ( LGFG_Access::is_unlocked( $product_id ) ) {
			return '<div class="lgfg-unlocked">' . $content . '</div>';
		}

		wp_enqueue_style( 'lgfg-gate' );
		return self::form( $product_id, $message );
	}

	/**
	 * Unlock form markup.
	 *
	 * @param string $product_id Product ID.
	 * @param string $message    Optional custom locked message.
	 * @return string
	 */
	private static function form( $product_id, $message ) {
		static $count = 0;
		++$count;
		$field_id = 'lgfg-key-' . $count;

		$locked_message = '' !== $message ? $message : LGFG_Settings::get( 'msg_locked' );
		$feedback       = '';
		if ( isset( self::$results[ $product_id ] ) ) {
			$feedback = self::status_message( self::$results[ $product_id ] );
		}

		ob_start();
		?>
		<div class="lgfg-gate">
			<div class="lgfg-message"><?php echo wp_kses_post( wpautop( $locked_message ) ); ?></div>
			<?php if ( '' !== $feedback ) : ?>
				<div class="lgfg-feedback" role="alert"><?php echo wp_kses_post( $feedback ); ?></div>
			<?php endif; ?>
			<form class="lgfg-form" method="post">
				<?php wp_nonce_field( 'lgfg_unlock', 'lgfg_nonce' ); ?>
				<input type="hidden" name="lgfg_product" value="<?php echo esc_attr( $product_id ); ?>" />
				<label for="<?php echo esc_attr( $field_id ); ?>"><?php esc_html_e( 'License key', 'license-gate-for-gumroad' ); ?></label>
				<input type="text" id="<?php echo esc_attr( $field_id ); ?>" name="lgfg_license_key" autocomplete="off" spellcheck="false" required placeholder="XXXXXXXX-XXXXXXXX-XXXXXXXX-XXXXXXXX" />
				<button type="submit"><?php echo esc_html( LGFG_Settings::get( 'button_text' ) ); ?></button>
			</form>
		</div>
		<?php
		return (string) ob_get_clean();
	}

	/**
	 * Message for a failed verification.
	 *
	 * @param array $result Verification result.
	 * @return string
	 */
	private static function status_message( $result ) {
		switch ( $result['status'] ) {
			case 'revoked':
				return LGFG_Settings::get( 'msg_revoked' );
			case 'error':
				return LGFG_Settings::get( 'msg_error' );
			case 'rate_limited':
				return LGFG_Settings::get( 'msg_rate_limited' );
			case 'valid':
				return '';
			default:
				return LGFG_Settings::get( 'msg_invalid' );
		}
	}

	/**
	 * Process an unlock form post.
	 */
	public static function handle_submission() {
		if ( ! isset( $_SERVER['REQUEST_METHOD'] ) || 'POST' !== $_SERVER['REQUEST_METHOD'] || ! isset( $_POST['lgfg_nonce'], $_POST['lgfg_product'] ) ) {
			return;
		}
		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['lgfg_nonce'] ) ), 'lgfg_unlock' ) ) {
			return;
		}

		$product_id  = LGFG_Settings::sanitize_product_id( sanitize_text_field( wp_unslash( $_POST['lgfg_product'] ) ) );
		$license_key = isset( $_POST['lgfg_license_key'] ) ? LGFG_Settings::sanitize_license_key( sanitize_text_field( wp_unslash( $_POST['lgfg_license_key'] ) ) ) : '';
		if ( '' === $product_id ) {
			return;
		}

		if ( self::rate_limited() ) {
			self::$results[ $product_id ] = array(
				'status' => 'rate_limited',
				'reason' => 'too_many_attempts',
			);
			return;
		}

		$result                       = LGFG_Verifier::verify( $product_id, $license_key );
		self::$results[ $product_id ] = $result;

		if ( 'valid' === $result['status'] ) {
			LGFG_Access::grant( $product_id, $license_key );
			/**
			 * Fires after a visitor unlocks a product with a valid license.
			 *
			 * @param string $product_id Product ID.
			 * @param array  $result     Verification result.
			 */
			do_action( 'lgfg_unlocked', $product_id, $result );

			// Post/Redirect/Get back to the same page. wp_get_referer() returns false when the
			// referer equals the current URL, so validate the raw referer instead.
			$redirect = wp_validate_redirect( (string) wp_get_raw_referer(), '' );
			if ( '' !== $redirect && wp_safe_redirect( $redirect, 303 ) ) {
				exit;
			}
		}
	}

	/**
	 * Simple per-IP throttle against key guessing.
	 *
	 * @return bool True when the visitor is over the limit.
	 */
	private static function rate_limited() {
		$ip  = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'unknown';
		$key = 'lgfg_rl_' . substr( hash_hmac( 'sha256', $ip, wp_salt( 'nonce' ) ), 0, 32 );
		$max = (int) LGFG_Settings::get( 'max_attempts' );

		$attempts = (int) get_transient( $key );
		if ( $attempts >= $max ) {
			return true;
		}
		set_transient( $key, $attempts + 1, 10 * MINUTE_IN_SECONDS );
		return false;
	}

	/**
	 * Gated pages differ per visitor, so ask page caches not to store them.
	 */
	public static function maybe_disable_page_cache() {
		if ( ! is_singular() ) {
			return;
		}
		$post = get_post();
		if ( ! $post ) {
			return;
		}
		if ( has_shortcode( $post->post_content, 'license_gate' ) || has_block( 'license-gate-for-gumroad/gate', $post ) ) {
			if ( ! defined( 'DONOTCACHEPAGE' ) ) {
				define( 'DONOTCACHEPAGE', true ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedConstantFound -- Standard constant read by caching plugins.
			}
			nocache_headers();
		}
	}
}
