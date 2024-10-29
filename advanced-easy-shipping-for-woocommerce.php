<?php

/**
 * Plugin Name: Advanced Easy Shipping For WooCommerce (c)
 * Plugin URI:          https://woocommerce.com/products/advanced-easy-shipping-for-woocommerce/
 * Description:         Advanced Easy Shipping For WooCommerce Plugins allows you to easy configure advanced shipping conditions with conditional logic!
 * Version:             3.0.9
 * Author:              idomit
 * Author URI:          https://idomit.com/
 * License:             GPL-2.0+
 * License URI:         http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:         advanced-easy-shipping-for-woocommerce
 * Domain Path:         /languages
 *
 * Woo: 6415189:1ab5a53bdfc03186997f97252c8bc9e9
 * WC requires at least: 3.0
 * WC tested up to: 7.1.0
 *
 * @package Advanced_Easy_Shipping_For_WooCommerce
 */
// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !function_exists( 'aesfw_fs' ) ) {
    // Create a helper function for easy SDK access.
    function aesfw_fs()
    {
        global  $aesfw_fs ;
        
        if ( !isset( $aesfw_fs ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            $aesfw_fs = fs_dynamic_init( array(
                'id'             => '8790',
                'slug'           => 'advanced-easy-shipping-for-wc-lite',
                'premium_slug'   => 'advance-easy-shipping-for-woocommerce',
                'type'           => 'plugin',
                'public_key'     => 'pk_2a55465e285686f167dda32ce0750',
                'is_premium'     => false,
                'premium_suffix' => '(c)',
                'has_addons'     => false,
                'has_paid_plans' => true,
                'menu'           => array(
                'slug'       => 'asw-main',
                'first-path' => 'admin.php?page=asw-main',
                'support'    => false,
                'parent'     => array(
                'slug' => 'woocommerce',
            ),
            ),
                'is_live'        => true,
            ) );
        }
        
        return $aesfw_fs;
    }
    
    // Init Freemius.
    aesfw_fs();
    // Signal that SDK was initiated.
    do_action( 'aesfw_fs_loaded' );
}

if ( !defined( 'ASW_PLUGIN_URL' ) ) {
    define( 'ASW_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}
if ( !defined( 'ASW_PLUGIN_DIR' ) ) {
    define( 'ASW_PLUGIN_DIR', dirname( __FILE__ ) );
}
if ( !defined( 'ASW_PLUGIN_DIR_PATH' ) ) {
    define( 'ASW_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
}
if ( !defined( 'ASW_PLUGIN_BASENAME' ) ) {
    define( 'ASW_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
}
require_once plugin_dir_path( __FILE__ ) . 'settings/asw-constant.php';
/**
 * The code that runs during plugin activation.
 */
function asw_activate()
{
    if ( is_plugin_active( 'advance-easy-shipping-for-woocommerce/advanced-easy-shipping-for-woocommerce.php' ) ) {
        deactivate_plugins( plugin_basename( 'advance-easy-shipping-for-woocommerce/advanced-easy-shipping-for-woocommerce.php' ) );
    }
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woocommerce-advanced-extra-fees-activator.php
 */
function activate_asw_shipping_method()
{
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-asw-shipping-method-activator.php';
    ASW_Shipping_Method_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woocommerce-advanced-extra-fees-deactivator.php
 */
function deactivate_asw_shipping_method()
{
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-asw-shipping-method-deactivator.php';
    ASW_Shipping_Method_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_asw_shipping_method' );
register_deactivation_hook( __FILE__, 'deactivate_asw_shipping_method' );
$prefix = ( is_network_admin() ? 'network_admin_' : '' );
add_filter( "{$prefix}plugin_action_links_" . ASW_PLUGIN_BASENAME, 'asw_plugin_action_links', 10 );
add_action( 'admin_init', 'idm_asw_check_plugin_status' );
/**
 * Deactivate plugin when woocommerce is not active.
 *
 * @since 1.2
 */
function idm_asw_check_plugin_status()
{
    $plugin = plugin_basename( __FILE__ );
    if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {
        deactivate_plugins( $plugin );
    }
}

/**
 * Add menu in plugins section.
 *
 * @param array $actions associative array of action names to anchor tags.
 *
 * @return array associative array of plugin action links
 *
 * @since 1.0.0
 */
function asw_plugin_action_links( $actions )
{
    $custom_actions = array(
        'configure' => sprintf( '<a href="%s">%s</a>', esc_url( add_query_arg( array(
        'page' => 'asw-main',
        'tab'  => 'general_section',
    ), admin_url( 'admin.php' ) ) ), esc_html__( 'Settings', 'advanced-easy-shipping-for-woocommerce' ) ),
        'help'      => sprintf( '<a href="%s" target="_blank">%s</a>', esc_url( 'https://idomit.com/contact-us' ), esc_html__( 'Help', 'advanced-easy-shipping-for-woocommerce' ) ),
    );
    return array_merge( $custom_actions, $actions );
}

add_action( 'plugins_loaded', 'asw_load_plugin_text_domain' );
/**
 * Load language file for plugin.
 *
 * @since 1.2
 */
function asw_load_plugin_text_domain()
{
    load_plugin_textdomain( 'advanced-easy-shipping-for-woocommerce', false, basename( dirname( __FILE__ ) ) . '/languages/' );
}


if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {
    require_once plugin_dir_path( __FILE__ ) . 'settings/asw-common-function.php';
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-asw-admin.php';
    if ( !is_admin() ) {
        require_once plugin_dir_path( __FILE__ ) . 'public/class-asw-shipping-method-public.php';
    }
}
