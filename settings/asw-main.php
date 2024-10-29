<?php
/**
 * Plugins main file.
 *
 * @package    Advanced_Easy_Shipping_For_WooCommerce
 * @subpackage Advanced_Easy_Shipping_For_WooCommerce/settings
 */
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$current_tab = ASW_Admin::idm_asw_current_tab();

if ( has_filter( 'idm_asw_ie_admin_page_ft' ) ) {
	/**
	 * Apply filters for admin page.
	 */
	apply_filters( 'idm_asw_ie_admin_page_ft', $current_tab );
	/**
	 * Apply filters for getting page.
	 */
	apply_filters( 'idm_asw_getting_page', $current_tab );
} else {
	/**
	 * Apply filters for getting page.
	 */
	apply_filters( 'idm_asw_getting_page', $current_tab );
}
?>
