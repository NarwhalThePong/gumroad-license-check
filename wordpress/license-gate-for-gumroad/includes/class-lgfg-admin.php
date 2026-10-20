<?php
/**
 * Settings page.
 *
 * @package LicenseGateForGumroad
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Settings > License Gate.
 */
class LGFG_Admin {

	const PAGE           = 'license-gate-for-gumroad';
	const DISMISS_META   = 'lgfg_kits_notice_dismissed';
	const DISMISS_ACTION = 'lgfg_dismiss_kits_notice';

	/**
	 * Hook everything up.
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'menu' ) );
		add_action( 'admin_init', array( __CLASS__, 'register_settings' ) );
		add_action( 'admin_post_' . self::DISMISS_ACTION, array( __CLASS__, 'dismiss_notice' ) );
	}

	/**
	 * Add the page under Settings.
	 */
	public static function menu() {
		add_options_page(
			__( 'License Gate for Gumroad', 'license-gate-for-gumroad' ),
			__( 'License Gate', 'license-gate-for-gumroad' ),
			'manage_options',
			self::PAGE,
			array( __CLASS__, 'render_page' )
		);
	}

	/**
	 * Settings API registration.
	 */
	public static function register_settings() {
		register_setting(
			'lgfg_settings_group',
			LGFG_Settings::OPTION,
			array(
				'type'              => 'array',
				'sanitize_callback' => array( 'LGFG_Settings', 'sanitize' ),
				'default'           => LGFG_Settings::defaults(),
			)
		);

		add_settings_section( 'lgfg_general', __( 'Gumroad', 'license-gate-for-gumroad' ), '__return_false', self::PAGE );
		add_settings_section( 'lgfg_messages', __( 'Messages', 'license-gate-for-gumroad' ), '__return_false', self::PAGE );

		$fields = array(
			'default_product_id' => array( 'lgfg_general', __( 'Default product ID', 'license-gate-for-gumroad' ), 'text', __( 'Used when a gate has no product_id. Find it in Gumroad: edit the product, open the License key section and copy the product_id.', 'license-gate-for-gumroad' ) ),
			'cache_minutes'      => array( 'lgfg_general', __( 'Cache results (minutes)', 'license-gate-for-gumroad' ), 'number', __( 'How long a Gumroad answer is reused for the same key. 0 turns caching off.', 'license-gate-for-gumroad' ) ),
			'unlock_days'        => array( 'lgfg_general', __( 'Keep content unlocked (days)', 'license-gate-for-gumroad' ), 'number', __( 'After a valid key, the visitor stays unlocked this long (cookie for guests, user setting for logged-in users).', 'license-gate-for-gumroad' ) ),
			'max_attempts'       => array( 'lgfg_general', __( 'Max attempts per 10 minutes', 'license-gate-for-gumroad' ), 'number', __( 'Per visitor IP, to slow down key guessing.', 'license-gate-for-gumroad' ) ),
			'increment_uses'     => array( 'lgfg_general', __( 'Count uses in Gumroad', 'license-gate-for-gumroad' ), 'checkbox', __( 'Increase the license "uses" counter in Gumroad on each new check.', 'license-gate-for-gumroad' ) ),
			'revoke_on_cancel'   => array( 'lgfg_general', __( 'Lock on cancellation', 'license-gate-for-gumroad' ), 'checkbox', __( 'Treat a cancelled subscription as inactive right away instead of at the end of the paid period.', 'license-gate-for-gumroad' ) ),
			'msg_locked'         => array( 'lgfg_messages', __( 'Locked message', 'license-gate-for-gumroad' ), 'textarea', '' ),
			'msg_invalid'        => array( 'lgfg_messages', __( 'Invalid key', 'license-gate-for-gumroad' ), 'textarea', '' ),
			'msg_revoked'        => array( 'lgfg_messages', __( 'Refunded or inactive license', 'license-gate-for-gumroad' ), 'textarea', '' ),
			'msg_error'          => array( 'lgfg_messages', __( 'Gumroad unreachable', 'license-gate-for-gumroad' ), 'textarea', '' ),
			'msg_rate_limited'   => array( 'lgfg_messages', __( 'Too many attempts', 'license-gate-for-gumroad' ), 'textarea', '' ),
			'button_text'        => array( 'lgfg_messages', __( 'Button text', 'license-gate-for-gumroad' ), 'text', '' ),
		);

		foreach ( $fields as $key => $field ) {
			add_settings_field(
				'lgfg_' . $key,
				$field[1],
				array( __CLASS__, 'render_field' ),
				self::PAGE,
				$field[0],
				array(
					'key'       => $key,
					'type'      => $field[2],
					'help'      => $field[3],
					'label_for' => 'lgfg_' . $key,
				)
			);
		}
	}

	/**
	 * Render one field.
	 *
	 * @param array $args Field args.
	 */
	public static function render_field( $args ) {
		$key   = $args['key'];
		$value = LGFG_Settings::get( $key );
		$name  = LGFG_Settings::OPTION . '[' . $key . ']';
		$id    = 'lgfg_' . $key;

		switch ( $args['type'] ) {
			case 'checkbox':
				printf(
					'<input type="checkbox" id="%1$s" name="%2$s" value="1" %3$s />',
					esc_attr( $id ),
					esc_attr( $name ),
					checked( 1, (int) $value, false )
				);
				break;
			case 'number':
				printf(
					'<input type="number" min="0" class="small-text" id="%1$s" name="%2$s" value="%3$s" />',
					esc_attr( $id ),
					esc_attr( $name ),
					esc_attr( (string) $value )
				);
				break;
			case 'textarea':
				printf(
					'<textarea class="large-text" rows="2" id="%1$s" name="%2$s">%3$s</textarea>',
					esc_attr( $id ),
					esc_attr( $name ),
					esc_textarea( (string) $value )
				);
				break;
			default:
				printf(
					'<input type="text" class="regular-text" id="%1$s" name="%2$s" value="%3$s" />',
					esc_attr( $id ),
					esc_attr( $name ),
					esc_attr( (string) $value )
				);
		}

		if ( '' !== $args['help'] ) {
			echo '<p class="description">' . esc_html( $args['help'] ) . '</p>';
		}
	}

	/**
	 * Settings page.
	 */
	public static function render_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<?php self::kits_notice(); ?>
			<p>
				<?php
				echo wp_kses(
					sprintf(
						/* translators: 1: shortcode example */
						esc_html__( 'Wrap content in %1$s or add the "License Gate" block. Visitors see a form and unlock the content with the license key from their Gumroad purchase.', 'license-gate-for-gumroad' ),
						'<code>[license_gate product_id="YOUR_PRODUCT_ID"]...[/license_gate]</code>'
					),
					array( 'code' => array() )
				);
				?>
			</p>
			<form action="options.php" method="post">
				<?php
				settings_fields( 'lgfg_settings_group' );
				do_settings_sections( self::PAGE );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Small, dismissible pointer to the companion kits. Shown only on this page.
	 */
	private static function kits_notice() {
		if ( get_user_meta( get_current_user_id(), self::DISMISS_META, true ) ) {
			return;
		}
		$dismiss_url = wp_nonce_url( admin_url( 'admin-post.php?action=' . self::DISMISS_ACTION ), self::DISMISS_ACTION );
		?>
		<div class="notice notice-info inline">
			<p>
				<?php esc_html_e( 'Need the same refund-aware license checks inside your own Python, Node, or Electron app?', 'license-gate-for-gumroad' ); ?>
				<a href="<?php echo esc_url( 'https://paudrudis.gumroad.com/l/dufcs' ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'See the Gumroad License Kit', 'license-gate-for-gumroad' ); ?></a>
				&middot;
				<a href="<?php echo esc_url( $dismiss_url ); ?>"><?php esc_html_e( 'Dismiss', 'license-gate-for-gumroad' ); ?></a>
			</p>
		</div>
		<?php
	}

	/**
	 * Remember the dismissal for this user.
	 */
	public static function dismiss_notice() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Sorry, you are not allowed to do that.', 'license-gate-for-gumroad' ) );
		}
		check_admin_referer( self::DISMISS_ACTION );
		update_user_meta( get_current_user_id(), self::DISMISS_META, 1 );
		wp_safe_redirect( admin_url( 'options-general.php?page=' . self::PAGE ) );
		exit;
	}
}
