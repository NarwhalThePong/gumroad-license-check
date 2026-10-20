<?php
/**
 * Settings storage and defaults.
 *
 * @package LicenseGateForGumroad
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Reads and sanitizes the plugin options.
 */
class LGFG_Settings {

	const OPTION = 'lgfg_settings';

	/**
	 * Default option values.
	 *
	 * @return array
	 */
	public static function defaults() {
		return array(
			'default_product_id' => '',
			'cache_minutes'      => 60,
			'unlock_days'        => 30,
			'increment_uses'     => 0,
			'revoke_on_cancel'   => 0,
			'max_attempts'       => 10,
			'msg_locked'         => __( 'This content is for customers. Enter the license key from your Gumroad receipt to unlock it.', 'license-gate-for-gumroad' ),
			'msg_invalid'        => __( 'That license key is not valid for this product. Please check it and try again.', 'license-gate-for-gumroad' ),
			'msg_revoked'        => __( 'This license is no longer active (refunded, charged back, disputed, or the subscription ended).', 'license-gate-for-gumroad' ),
			'msg_error'          => __( 'We could not reach Gumroad to check your key. Please try again in a minute.', 'license-gate-for-gumroad' ),
			'msg_rate_limited'   => __( 'Too many attempts. Please wait a few minutes and try again.', 'license-gate-for-gumroad' ),
			'button_text'        => __( 'Unlock', 'license-gate-for-gumroad' ),
		);
	}

	/**
	 * All settings merged with defaults.
	 *
	 * @return array
	 */
	public static function all() {
		$saved = get_option( self::OPTION, array() );
		if ( ! is_array( $saved ) ) {
			$saved = array();
		}
		$merged = wp_parse_args( $saved, self::defaults() );
		foreach ( self::defaults() as $key => $default ) {
			if ( is_string( $default ) && '' === $merged[ $key ] && 'default_product_id' !== $key ) {
				$merged[ $key ] = $default;
			}
		}
		return $merged;
	}

	/**
	 * One setting.
	 *
	 * @param string $key Setting key.
	 * @return mixed
	 */
	public static function get( $key ) {
		$all = self::all();
		return isset( $all[ $key ] ) ? $all[ $key ] : null;
	}

	/**
	 * Sanitize callback for register_setting().
	 *
	 * @param mixed $input Raw input.
	 * @return array
	 */
	public static function sanitize( $input ) {
		$input = is_array( $input ) ? $input : array();
		$out   = array();

		$out['default_product_id'] = isset( $input['default_product_id'] ) ? self::sanitize_product_id( $input['default_product_id'] ) : '';
		$out['cache_minutes']      = isset( $input['cache_minutes'] ) ? min( 10080, absint( $input['cache_minutes'] ) ) : 60;
		$out['unlock_days']        = isset( $input['unlock_days'] ) ? max( 1, min( 365, absint( $input['unlock_days'] ) ) ) : 30;
		$out['max_attempts']       = isset( $input['max_attempts'] ) ? max( 1, min( 100, absint( $input['max_attempts'] ) ) ) : 10;
		$out['increment_uses']     = empty( $input['increment_uses'] ) ? 0 : 1;
		$out['revoke_on_cancel']   = empty( $input['revoke_on_cancel'] ) ? 0 : 1;

		foreach ( array( 'msg_locked', 'msg_invalid', 'msg_revoked', 'msg_error', 'msg_rate_limited' ) as $key ) {
			$out[ $key ] = isset( $input[ $key ] ) ? wp_kses_post( $input[ $key ] ) : '';
		}
		$out['button_text'] = isset( $input['button_text'] ) ? sanitize_text_field( $input['button_text'] ) : '';

		return $out;
	}

	/**
	 * Gumroad product IDs are short alphanumeric strings (base64-like, may contain = - _).
	 *
	 * @param mixed $value Raw value.
	 * @return string
	 */
	public static function sanitize_product_id( $value ) {
		$value = is_scalar( $value ) ? (string) $value : '';
		return substr( preg_replace( '/[^A-Za-z0-9=_\-]/', '', $value ), 0, 64 );
	}

	/**
	 * License keys look like XXXXXXXX-XXXXXXXX-XXXXXXXX-XXXXXXXX.
	 *
	 * @param mixed $value Raw value.
	 * @return string
	 */
	public static function sanitize_license_key( $value ) {
		$value = is_scalar( $value ) ? (string) $value : '';
		return substr( preg_replace( '/[^A-Za-z0-9\-]/', '', $value ), 0, 64 );
	}
}
