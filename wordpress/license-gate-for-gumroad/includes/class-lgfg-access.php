<?php
/**
 * Remembers which products a visitor has unlocked. Raw license keys are never stored.
 *
 * @package LicenseGateForGumroad
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Unlock state: user meta for logged-in users, a signed cookie for guests.
 */
class LGFG_Access {

	const META_KEY      = 'lgfg_unlocks';
	const COOKIE_PREFIX = 'lgfg_unlock_';

	/**
	 * Short hash used to name the cookie / meta entry for a product.
	 *
	 * @param string $product_id Product ID.
	 * @return string
	 */
	private static function product_hash( $product_id ) {
		return substr( hash( 'sha256', 'lgfg|' . $product_id ), 0, 16 );
	}

	/**
	 * HMAC signature bound to the product, the expiry and the hashed key.
	 *
	 * @param string $product_id Product ID.
	 * @param int    $expires    Unix time.
	 * @param string $key_hash   Hashed license key.
	 * @return string
	 */
	private static function sign( $product_id, $expires, $key_hash ) {
		return hash_hmac( 'sha256', $product_id . '|' . $expires . '|' . $key_hash, wp_salt( 'auth' ) );
	}

	/**
	 * One-way hash of a license key (keyed with the site salt).
	 *
	 * @param string $license_key License key.
	 * @return string
	 */
	public static function key_hash( $license_key ) {
		return substr( hash_hmac( 'sha256', $license_key, wp_salt( 'secure_auth' ) ), 0, 32 );
	}

	/**
	 * Whether the current visitor has unlocked a product.
	 *
	 * @param string $product_id Product ID.
	 * @return bool
	 */
	public static function is_unlocked( $product_id ) {
		if ( '' === $product_id ) {
			return false;
		}
		$ph  = self::product_hash( $product_id );
		$now = time();

		$unlocked = false;
		if ( is_user_logged_in() ) {
			$unlocks = get_user_meta( get_current_user_id(), self::META_KEY, true );
			if ( is_array( $unlocks ) && isset( $unlocks[ $ph ]['expires'] ) && (int) $unlocks[ $ph ]['expires'] > $now ) {
				$unlocked = true;
			}
		}

		if ( ! $unlocked && isset( $_COOKIE[ self::COOKIE_PREFIX . $ph ] ) ) {
			$raw   = sanitize_text_field( wp_unslash( $_COOKIE[ self::COOKIE_PREFIX . $ph ] ) );
			$parts = explode( '.', $raw );
			if ( 3 === count( $parts ) ) {
				list( $expires, $key_hash, $sig ) = $parts;
				$expires = (int) $expires;
				if ( $expires > $now && hash_equals( self::sign( $product_id, $expires, $key_hash ), $sig ) ) {
					$unlocked = true;
				}
			}
		}

		/**
		 * Filters whether the current visitor can see gated content for a product.
		 *
		 * @param bool   $unlocked   Unlock state.
		 * @param string $product_id Product ID.
		 */
		return (bool) apply_filters( 'lgfg_is_unlocked', $unlocked, $product_id );
	}

	/**
	 * Store the unlock for the current visitor.
	 *
	 * @param string $product_id  Product ID.
	 * @param string $license_key License key (only its keyed hash is stored).
	 */
	public static function grant( $product_id, $license_key ) {
		$days     = max( 1, (int) LGFG_Settings::get( 'unlock_days' ) );
		$expires  = time() + $days * DAY_IN_SECONDS;
		$ph       = self::product_hash( $product_id );
		$key_hash = self::key_hash( $license_key );

		if ( is_user_logged_in() ) {
			$user_id = get_current_user_id();
			$unlocks = get_user_meta( $user_id, self::META_KEY, true );
			$unlocks = is_array( $unlocks ) ? $unlocks : array();
			// Drop expired entries while we are here.
			foreach ( $unlocks as $k => $entry ) {
				if ( ! isset( $entry['expires'] ) || (int) $entry['expires'] <= time() ) {
					unset( $unlocks[ $k ] );
				}
			}
			$unlocks[ $ph ] = array(
				'expires'  => $expires,
				'key_hash' => $key_hash,
			);
			update_user_meta( $user_id, self::META_KEY, $unlocks );
			return;
		}

		$value = $expires . '.' . $key_hash . '.' . self::sign( $product_id, $expires, $key_hash );
		if ( ! headers_sent() ) {
			setcookie(
				self::COOKIE_PREFIX . $ph,
				$value,
				array(
					'expires'  => $expires,
					'path'     => COOKIEPATH ? COOKIEPATH : '/',
					'domain'   => COOKIE_DOMAIN ? COOKIE_DOMAIN : '',
					'secure'   => is_ssl(),
					'httponly' => true,
					'samesite' => 'Lax',
				)
			);
		}
		$_COOKIE[ self::COOKIE_PREFIX . $ph ] = $value;
	}
}
