<?php
/**
 * Removes plugin data when the plugin is deleted.
 *
 * @package LicenseGateForGumroad
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'lgfg_settings' );
delete_metadata( 'user', 0, 'lgfg_unlocks', '', true );
delete_metadata( 'user', 0, 'lgfg_kits_notice_dismissed', '', true );

global $wpdb;
// Cached Gumroad answers and rate-limit counters are transients named lgfg_v_* and lgfg_rl_*.
// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
$wpdb->query(
	$wpdb->prepare(
		"DELETE FROM {$wpdb->options} WHERE option_name LIKE %s OR option_name LIKE %s",
		$wpdb->esc_like( '_transient_lgfg_' ) . '%',
		$wpdb->esc_like( '_transient_timeout_lgfg_' ) . '%'
	)
);
