<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://www.idomit.com/
 * @since      1.0.0
 *
 * @package    Advanced_Easy_Shipping_For_WooCommerce
 * @subpackage Advanced_Easy_Shipping_For_WooCommerce/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Advanced_Easy_Shipping_For_WooCommerce
 * @subpackage Advanced_Easy_Shipping_For_WooCommerce/includes
 * @author     idomit <info@idomit.com>
 */
class ASW_Shipping_Method_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		if ( get_transient( 'asw-admin-notice' ) ) {
			delete_transient( 'asw-admin-notice' );
		}
	}

}
