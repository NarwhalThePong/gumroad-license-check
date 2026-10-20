<?php
/**
 * Plugin Name:       License Gate for Gumroad
 * Description:       Hide posts, pages, or downloads behind a Gumroad license key. Visitors unlock the content by entering the license key from their Gumroad purchase.
 * Version:           1.0.0
 * Requires at least: 6.3
 * Tested up to:      7.1
 * Requires PHP:      7.4
 * Author:            Pau Drudis
 * Author URI:        https://paudrudis.gumroad.com/
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       license-gate-for-gumroad
 *
 * @package LicenseGateForGumroad
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'LGFG_VERSION', '1.0.0' );
define( 'LGFG_FILE', __FILE__ );
define( 'LGFG_DIR', plugin_dir_path( __FILE__ ) );
define( 'LGFG_URL', plugin_dir_url( __FILE__ ) );

require_once LGFG_DIR . 'includes/class-lgfg-settings.php';
require_once LGFG_DIR . 'includes/class-lgfg-verifier.php';
require_once LGFG_DIR . 'includes/class-lgfg-access.php';
require_once LGFG_DIR . 'includes/class-lgfg-gate.php';
require_once LGFG_DIR . 'includes/class-lgfg-admin.php';

LGFG_Gate::init();
if ( is_admin() ) {
	LGFG_Admin::init();
}

/**
 * Adds a Settings link on the Plugins screen.
 *
 * @param array $links Existing action links.
 * @return array
 */
function lgfg_action_links( $links ) {
	$url = admin_url( 'options-general.php?page=license-gate-for-gumroad' );
	array_unshift( $links, '<a href="' . esc_url( $url ) . '">' . esc_html__( 'Settings', 'license-gate-for-gumroad' ) . '</a>' );
	return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'lgfg_action_links' );
