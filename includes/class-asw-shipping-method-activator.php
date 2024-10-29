<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.idomit.com/
 * @since      1.0.0
 *
 * @package    Advanced_Easy_Shipping_For_WooCommerce
 * @subpackage Advanced_Easy_Shipping_For_WooCommerce/includes
 */
/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Advanced_Easy_Shipping_For_WooCommerce
 * @subpackage Advanced_Easy_Shipping_For_WooCommerce/includes
 * @author     idomit <info@idomit.com>
 */
class ASW_Shipping_Method_Activator
{
    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate()
    {
        set_transient( 'asw-admin-notice', true );
        set_transient( 'asw_redirect_transist', true, 30 );
        add_option( 'asw_version', ASW_PLUGIN_VERSION );
        
        if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {
            update_option( 'chk_enable_logging', 'on' );
        } else {
            wp_die( "<strong>Advanced Easy Shipping For WooCommerce</strong> plugin requires <strong>WooCommerce</strong>. Return to <a href='" . esc_url( get_admin_url( null, 'plugins.php' ) ) . "'>Plugins page</a>." );
            exit;
        }
        
        if ( is_plugin_active( 'advance-easy-shipping-for-woocommerce/advanced-easy-shipping-for-woocommerce.php' ) ) {
            deactivate_plugins( plugin_basename( 'advance-easy-shipping-for-woocommerce/advanced-easy-shipping-for-woocommerce.php' ) );
        }
    }

}