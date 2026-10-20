<?php
/**
 * Talks to the Gumroad license API.
 *
 * @package LicenseGateForGumroad
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Verifies a license key against Gumroad and caches the result.
 */
class LGFG_Verifier {

	const API_URL = 'https://api.gumroad.com/v2/licenses/verify';

	/**
	 * Verify a key. Returns an array with 'status' (valid, invalid, revoked, error) and 'reason'.
	 *
	 * @param string $product_id  Gumroad product ID.
	 * @param string $license_key License key entered by the visitor.
	 * @return array
	 */
	public static function verify( $product_id, $license_key ) {
		$product_id  = LGFG_Settings::sanitize_product_id( $product_id );
		$license_key = LGFG_Settings::sanitize_license_key( $license_key );

		if ( '' === $product_id || '' === $license_key ) {
			return array(
				'status' => 'invalid',
				'reason' => 'missing',
			);
		}

		$cache_key     = 'lgfg_v_' . hash( 'sha256', $product_id . '|' . $license_key );
		$cache_minutes = (int) LGFG_Settings::get( 'cache_minutes' );
		if ( $cache_minutes > 0 ) {
			$cached = get_transient( $cache_key );
			if ( is_array( $cached ) && isset( $cached['status'] ) ) {
				$cached['cached'] = true;
				return $cached;
			}
		}

		$response = wp_remote_post(
			self::API_URL,
			array(
				'timeout' => 15,
				'body'    => array(
					'product_id'           => $product_id,
					'license_key'          => $license_key,
					'increment_uses_count' => LGFG_Settings::get( 'increment_uses' ) ? 'true' : 'false',
				),
			)
		);

		if ( is_wp_error( $response ) ) {
			return array(
				'status' => 'error',
				'reason' => 'http_error',
			);
		}

		$code = (int) wp_remote_retrieve_response_code( $response );
		$data = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( $code >= 500 || ! is_array( $data ) ) {
			return array(
				'status' => 'error',
				'reason' => 'bad_response',
			);
		}

		if ( empty( $data['success'] ) || empty( $data['purchase'] ) || ! is_array( $data['purchase'] ) ) {
			$result = array(
				'status' => 'invalid',
				'reason' => 'not_found',
			);
		} else {
			$result = self::evaluate_purchase( $data['purchase'] );
		}

		/**
		 * Filters the verification result before it is cached.
		 *
		 * @param array  $result     Result with 'status' and 'reason'.
		 * @param array  $data       Decoded Gumroad response.
		 * @param string $product_id Product ID.
		 */
		$result = apply_filters( 'lgfg_verify_result', $result, $data, $product_id );

		if ( $cache_minutes > 0 ) {
			set_transient( $cache_key, $result, $cache_minutes * MINUTE_IN_SECONDS );
		}
		return $result;
	}

	/**
	 * Gumroad returns success=true for refunded and charged-back purchases, so check the flags.
	 *
	 * @param array $p Purchase object from Gumroad.
	 * @return array
	 */
	public static function evaluate_purchase( array $p ) {
		$revoked = array(
			'status' => 'revoked',
			'reason' => '',
		);
		if ( ! empty( $p['refunded'] ) ) {
			$revoked['reason'] = 'refunded';
			return $revoked;
		}
		if ( ! empty( $p['chargebacked'] ) ) {
			$revoked['reason'] = 'chargebacked';
			return $revoked;
		}
		if ( ! empty( $p['disputed'] ) && empty( $p['dispute_won'] ) ) {
			$revoked['reason'] = 'disputed';
			return $revoked;
		}
		foreach ( array( 'subscription_ended_at', 'subscription_failed_at' ) as $field ) {
			if ( ! empty( $p[ $field ] ) ) {
				$revoked['reason'] = str_replace( '_at', '', $field );
				return $revoked;
			}
		}
		// A cancelled subscription keeps access until it ends (Gumroad then sets subscription_ended_at),
		// unless the site owner chose to revoke access as soon as the buyer cancels.
		if ( ! empty( $p['subscription_cancelled_at'] ) && LGFG_Settings::get( 'revoke_on_cancel' ) ) {
			$revoked['reason'] = 'subscription_cancelled';
			return $revoked;
		}
		return array(
			'status' => 'valid',
			'reason' => 'ok',
		);
	}
}
