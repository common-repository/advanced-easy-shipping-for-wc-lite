<?php

/**
 * Common functions for plugins.
 *
 * @since      1.0.0
 * @package    Advanced_Easy_Shipping_For_WooCommerce
 * @subpackage Advanced_Easy_Shipping_For_WooCommerce/settings
 */
// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Get country list.
 *
 * @return false|string
 */
function asw_get_country_list()
{
    $countries = WC()->countries->get_allowed_countries() + WC()->countries->get_shipping_countries();
    $country_array = array();
    foreach ( $countries as $country_key => $country_val ) {
        $country_array[$country_key] = $country_val;
    }
    return wp_json_encode( $countries );
}

/**
 * Get state list.
 *
 * @return false|string
 */
function asw_get_state_list()
{
    $state_obj = WC()->countries->states;
    $country_states = array();
    if ( !empty($state_obj) ) {
        foreach ( $state_obj as $country_key => $country_state_val ) {
            foreach ( $country_state_val as $state_key => $state_val ) {
                $country_states[WC()->countries->countries[$country_key]][$country_key . '_' . $state_key] = $state_val;
            }
        }
    }
    return wp_json_encode( $country_states );
}

/**
 * Get zone list.
 *
 * @return false|string
 */
function asw_get_zone_list()
{
    $get_zone_arr = array();
    $zones_array = WC_Shipping_Zones::get_zones();
    foreach ( (array) $zones_array as $the_zone ) {
        $get_zone_arr[$the_zone['id']] = $the_zone['zone_name'];
    }
    return wp_json_encode( $get_zone_arr );
}

/**
 * Get options for based on cart.
 *
 * @return false|string
 */
function asw_get_based_on_cart_options()
{
    $gbocopt = array();
    $gbocopt['cc_products'] = esc_html__( 'Contains Simple Product', 'advanced-easy-shipping-for-woocommerce' );
    $gbocopt['cc_categorys'] = esc_html__( 'Contains Category', 'advanced-easy-shipping-for-woocommerce' );
    $gbocopt['cc_tags'] = esc_html__( 'Contains Tags', 'advanced-easy-shipping-for-woocommerce' );
    $gbocopt['cc_skus'] = esc_html__( 'Contains SKUs', 'advanced-easy-shipping-for-woocommerce' );
    $gbocopt['cc_variables'] = esc_html__( 'Contains Variable Product', 'advanced-easy-shipping-for-woocommerce' );
    return wp_json_encode(
        /**
         * Apply filter for cart options.
         */
        apply_filters( 'asw_get_based_on_cart_options', $gbocopt )
    );
}

/**
 * Get options for based on locations.
 *
 * @return false|string
 */
function asw_get_based_on_locations_options()
{
    $gbolopt = array();
    $gbolopt['cc_country'] = esc_html__( 'Contains Country', 'advanced-easy-shipping-for-woocommerce' );
    $gbolopt['cc_state'] = esc_html__( 'Contains State', 'advanced-easy-shipping-for-woocommerce' );
    $gbolopt['cc_zone'] = esc_html__( 'Contains Zone', 'advanced-easy-shipping-for-woocommerce' );
    $gbolopt['cc_city'] = esc_html__( 'Contains City', 'advanced-easy-shipping-for-woocommerce' );
    $gbolopt['cc_postcode'] = esc_html__( 'Contains Postcode', 'advanced-easy-shipping-for-woocommerce' );
    return wp_json_encode(
        /**
         * Apply filter for locations options.
         */
        apply_filters( 'asw_get_based_on_locations_options', $gbolopt )
    );
}

/**
 * Get options for based on cart specific options.
 *
 * @return false|string
 */
function asw_get_based_on_cart_specific_options()
{
    $gbocsopt = array();
    $gbocsopt['cc_total_qty'] = esc_html__( 'Total Cart Qty', 'advanced-easy-shipping-for-woocommerce' );
    $gbocsopt['cc_subtotal_af_disc'] = esc_html__( 'Cart Subtotal(After Coupon Discount)', 'advanced-easy-shipping-for-woocommerce' );
    $gbocsopt['cc_total_weight'] = esc_html__( 'Total Cart Weight', 'advanced-easy-shipping-for-woocommerce' );
    $gbocsopt['cc_total_width'] = esc_html__( 'Total Cart Width', 'advanced-easy-shipping-for-woocommerce' );
    $gbocsopt['cc_total_height'] = esc_html__( 'Total Cart Height', 'advanced-easy-shipping-for-woocommerce' );
    $gbocsopt['cc_total_length'] = esc_html__( 'Total Cart Length', 'advanced-easy-shipping-for-woocommerce' );
    $gbocsopt['cc_subtotal_ex_tax'] = esc_html__( 'Cart Subtotal With Ex. Tax', 'advanced-easy-shipping-for-woocommerce' );
    $gbocsopt['cc_subtotal_inc_tax'] = esc_html__( 'Cart Subtotal With Inc. Tax', 'advanced-easy-shipping-for-woocommerce' );
    $gbocsopt['cc_coupon'] = esc_html__( 'Coupon', 'advanced-easy-shipping-for-woocommerce' );
    $gbocsopt['cc_shipping_class'] = esc_html__( 'Contains Shipping Class', 'advanced-easy-shipping-for-woocommerce' );
    return wp_json_encode(
        /**
         * Apply filter for cart specific options.
         */
        apply_filters( 'asw_get_based_on_cart_specific_options', $gbocsopt )
    );
}

/**
 * Get options for based on cart specific options.
 *
 * @return false|string
 */
function asw_get_based_on_checkout_specific_options()
{
    $gbochsopt = array();
    $gbochsopt['cc_payment_method'] = esc_html__( 'Payment Method', 'advanced-easy-shipping-for-woocommerce' );
    return wp_json_encode(
        /**
         * Apply filter for checkout specific options.
         */
        apply_filters( 'asw_get_based_on_checkout_specific_options', $gbochsopt )
    );
}

/**
 * Get options for based on user specific options.
 *
 * @return false|string
 */
function asw_get_based_on_user_specific_options()
{
    $gbousopt = array();
    $gbousopt['cc_username'] = esc_html__( 'User', 'advanced-easy-shipping-for-woocommerce' );
    $gbousopt['cc_user_role'] = esc_html__( 'User Role', 'advanced-easy-shipping-for-woocommerce' );
    return wp_json_encode(
        /**
         * Apply filter for user specific options.
         */
        apply_filters( 'asw_get_based_on_user_specific_options', $gbousopt )
    );
}

/**
 * Get options for based on product specific options.
 *
 * @return false|string
 */
function asw_get_based_on_product_specific_options()
{
    $gbopsopt = array();
    $gbopsopt['cc_tc_spec'] = esc_html__( 'Contain Total Cart', 'advanced-easy-shipping-for-woocommerce' );
    $gbopsopt['cc_prd_spec'] = esc_html__( 'Contain Simple Products', 'advanced-easy-shipping-for-woocommerce' );
    $gbopsopt['cc_var_prd_spec'] = esc_html__( 'Contain Variable Products', 'advanced-easy-shipping-for-woocommerce' );
    $gbopsopt['cc_cat_spec'] = esc_html__( 'Contain Category', 'advanced-easy-shipping-for-woocommerce' );
    $gbopsopt['cc_shpc_spec'] = esc_html__( 'Contain Shipping Class', 'advanced-easy-shipping-for-woocommerce' );
    return wp_json_encode(
        /**
         * Apply filter for product specific options.
         */
        apply_filters( 'asw_get_based_on_product_specific_options', $gbopsopt )
    );
}

/**
 * Get all fields type.
 *
 * @return false|string
 */
function asw_array_type_of_fields()
{
    $type_of_arr = array();
    $type_of_arr['cc_products'] = 'select';
    $type_of_arr['cc_categorys'] = 'select';
    $type_of_arr['cc_tags'] = 'select';
    $type_of_arr['cc_country'] = 'select';
    $type_of_arr['cc_state'] = 'select';
    $type_of_arr['cc_zone'] = 'select';
    $type_of_arr['cc_subtotal_af_disc'] = 'input';
    $type_of_arr['cc_total_qty'] = 'input';
    $type_of_arr['cc_tc_spec'] = 'label';
    $type_of_arr['cc_username'] = 'select';
    return wp_json_encode(
        /**
         * Apply filter for type of fields.
         */
        apply_filters( 'asw_array_type_of_fields', $type_of_arr )
    );
}

/**
 * Get conditional operators.
 *
 * @param string $check_condition will work based on condition.
 *
 * @return false|string
 */
function asw_conditional_operator( $check_condition = '' )
{
    $array_type_of_field = json_decode( asw_array_type_of_fields(), true );
    $get_type_of_field = '';
    
    if ( !empty($check_condition) ) {
        
        if ( isset( $check_condition ) && ('cc_products' !== $check_condition && 'cc_categorys' !== $check_condition && 'cc_tags' !== $check_condition && 'cc_country' !== $check_condition && 'cc_state' !== $check_condition && 'cc_zone' !== $check_condition && 'cc_subtotal_af_disc' !== $check_condition && 'cc_total_qty' !== $check_condition && 'cc_username' !== $check_condition && 'cc_tc_spec' !== $check_condition) ) {
            $check_condition = $check_condition . '__premium_only';
        } else {
            $check_condition = $check_condition;
        }
        
        $get_type_of_field = $array_type_of_field[$check_condition];
    }
    
    $cop = array();
    $cop['equal_to'] = esc_html__( 'Equal to', 'advanced-easy-shipping-for-woocommerce' );
    $cop['not_equal_to'] = esc_html__( 'Not equal to', 'advanced-easy-shipping-for-woocommerce' );
    
    if ( '' !== $check_condition ) {
        
        if ( 'input' === $get_type_of_field && !empty($get_type_of_field) ) {
            $cop['less_then'] = esc_html__( 'Less Then', 'advanced-easy-shipping-for-woocommerce' );
            $cop['less_equal_to'] = esc_html__( 'Less Then Equal To', 'advanced-easy-shipping-for-woocommerce' );
            $cop['greater_then'] = esc_html__( 'Greater Then', 'advanced-easy-shipping-for-woocommerce' );
            $cop['greater_equal_to'] = esc_html__( 'Greater Then Equal to', 'advanced-easy-shipping-for-woocommerce' );
        }
    
    } else {
        $cop['less_then'] = esc_html__( 'Less Then', 'advanced-easy-shipping-for-woocommerce' );
        $cop['less_equal_to'] = esc_html__( 'Less Then Equal To', 'advanced-easy-shipping-for-woocommerce' );
        $cop['greater_then'] = esc_html__( 'Greater Then', 'advanced-easy-shipping-for-woocommerce' );
        $cop['greater_equal_to'] = esc_html__( 'Greater Then Equal to', 'advanced-easy-shipping-for-woocommerce' );
    }
    
    return wp_json_encode( $cop );
}

/**
 * Get apply per unit options.
 *
 * @param string $condition will work based on condition.
 *
 * @return false|string
 */
function asw_per_unit_options( $condition )
{
    $gpuo = array();
    $gpuo['qty'] = esc_html__( 'QTY', 'advanced-easy-shipping-for-woocommerce' );
    
    if ( 'cc_tc_spec' === $condition ) {
        $cart_unit_data_fn = asw_per_unit_cart_options();
        $cart_unit_data = json_decode( $cart_unit_data_fn, true );
        $gpuo = array_merge( $gpuo, $cart_unit_data );
    } else {
        $item_unit_data_fn = asw_per_unit_item_options();
        $item_unit_data = json_decode( $item_unit_data_fn, true );
        $gpuo = array_merge( $gpuo, $item_unit_data );
    }
    
    $gpuo['weight'] = esc_html__( 'Weight', 'advanced-easy-shipping-for-woocommerce' );
    $gpuo['width'] = esc_html__( 'Width', 'advanced-easy-shipping-for-woocommerce' );
    $gpuo['height'] = esc_html__( 'Height', 'advanced-easy-shipping-for-woocommerce' );
    $gpuo['length'] = esc_html__( 'Length', 'advanced-easy-shipping-for-woocommerce' );
    return wp_json_encode(
        /**
         * Apply filter for unit options.
         */
        apply_filters( 'asw_per_unit_options', $gpuo, $condition )
    );
}

/**
 * Apply per unit items options.
 *
 * @return false|string
 */
function asw_per_unit_item_options()
{
    $gpuo = array();
    $gpuo['item_total_with_tax'] = esc_html__( 'Items total with tax', 'advanced-easy-shipping-for-woocommerce' );
    $gpuo['item_total_without_tax'] = esc_html__( 'Items total without tax', 'advanced-easy-shipping-for-woocommerce' );
    return wp_json_encode(
        /**
         * Apply filter for unit item options.
         */
        apply_filters( 'asw_per_unit_item_options', $gpuo )
    );
}

/**
 * Apply per unit cart options.
 *
 * @return false|string
 */
function asw_per_unit_cart_options()
{
    $gpuo = array();
    $gpuo['st_with_tax'] = esc_html__( 'Subtotal with tax', 'advanced-easy-shipping-for-woocommerce' );
    $gpuo['st_with_disc'] = esc_html__( 'Subtotal with discount', 'advanced-easy-shipping-for-woocommerce' );
    $gpuo['st_without_tax_disc'] = esc_html__( 'Subtotal without tax and discount', 'advanced-easy-shipping-for-woocommerce' );
    $gpuo['st_with_tax_disc'] = esc_html__( 'Subtotal with tax and discount', 'advanced-easy-shipping-for-woocommerce' );
    return wp_json_encode(
        /**
         * Apply filter for unit cart options.
         */
        apply_filters( 'asw_per_unit_cart_options', $gpuo )
    );
}

/**
 * Get user list.
 *
 * @return false|string
 */
function asw_user_list()
{
    $get_user_list_arr = get_users();
    $user_detail_arr = array();
    if ( isset( $get_user_list_arr ) && !empty($get_user_list_arr) ) {
        foreach ( $get_user_list_arr as $get_user_detail ) {
            $user_detail_arr[$get_user_detail->data->ID] = $get_user_detail->data->user_login;
        }
    }
    return wp_json_encode( $user_detail_arr );
}

/**
 * Check array key exists or not.
 *
 * @param string $key   arrays key will work here.
 *
 * @param array  $array arrays.
 *
 * @return string
 */
function asw_check_array_key_exists( $key, $array )
{
    $var_name = '';
    if ( !empty($array) ) {
        if ( array_key_exists( $key, $array ) ) {
            $var_name = $array[$key];
        }
    }
    return $var_name;
}

/**
 * Placeholder message for fields
 *
 * @return string
 */
function asw_placeholder_for_fields()
{
    $asw_placeholder_arr = array();
    $asw_placeholder_arr['country'] = esc_html__( 'Select Countries', 'advanced-easy-shipping-for-woocommerce' );
    $asw_placeholder_arr['state'] = esc_html__( 'Select States', 'advanced-easy-shipping-for-woocommerce' );
    $asw_placeholder_arr['zone'] = esc_html__( 'Select Zones', 'advanced-easy-shipping-for-woocommerce' );
    $asw_placeholder_arr['products'] = esc_html__( 'Select Products', 'advanced-easy-shipping-for-woocommerce' );
    $asw_placeholder_arr['prd_spec'] = esc_html__( 'Select Products', 'advanced-easy-shipping-for-woocommerce' );
    $asw_placeholder_arr['categorys'] = esc_html__( 'Select Categories', 'advanced-easy-shipping-for-woocommerce' );
    $asw_placeholder_arr['cat_spec'] = esc_html__( 'Select Categories', 'advanced-easy-shipping-for-woocommerce' );
    $asw_placeholder_arr['tags'] = esc_html__( 'Select Tags', 'advanced-easy-shipping-for-woocommerce' );
    $asw_placeholder_arr['skus'] = esc_html__( 'Select SKUs', 'advanced-easy-shipping-for-woocommerce' );
    $asw_placeholder_arr['variables'] = esc_html__( 'Select Variable Products', 'advanced-easy-shipping-for-woocommerce' );
    $asw_placeholder_arr['var_prd_spec'] = esc_html__( 'Select Variable Products', 'advanced-easy-shipping-for-woocommerce' );
    $asw_placeholder_arr['coupon'] = esc_html__( 'Select Coupons', 'advanced-easy-shipping-for-woocommerce' );
    $asw_placeholder_arr['shipping_class'] = esc_html__( 'Select Shipping Classes', 'advanced-easy-shipping-for-woocommerce' );
    $asw_placeholder_arr['shpc_spec'] = esc_html__( 'Select Shipping Classes', 'advanced-easy-shipping-for-woocommerce' );
    $asw_placeholder_arr['username'] = esc_html__( 'Select Users By Username', 'advanced-easy-shipping-for-woocommerce' );
    $asw_placeholder_arr['user_role'] = esc_html__( 'Select User Role', 'advanced-easy-shipping-for-woocommerce' );
    $asw_placeholder_arr['total_weight'] = esc_html__( 'Enter Total Cart Weight', 'advanced-easy-shipping-for-woocommerce' );
    $asw_placeholder_arr['total_width'] = esc_html__( 'Enter Total Cart Width', 'advanced-easy-shipping-for-woocommerce' );
    $asw_placeholder_arr['total_qty'] = esc_html__( 'Enter Total Cart Quantity', 'advanced-easy-shipping-for-woocommerce' );
    $asw_placeholder_arr['total_height'] = esc_html__( 'Enter Total Cart Height', 'advanced-easy-shipping-for-woocommerce' );
    $asw_placeholder_arr['total_length'] = esc_html__( 'Enter Total Cart Length', 'advanced-easy-shipping-for-woocommerce' );
    $asw_placeholder_arr['subtotal_ex_tax'] = esc_html__( 'Enter Subtotal With Exclude Tax', 'advanced-easy-shipping-for-woocommerce' );
    $asw_placeholder_arr['subtotal_inc_tax'] = esc_html__( 'Enter Subtotal With Include Tax', 'advanced-easy-shipping-for-woocommerce' );
    $asw_placeholder_arr['subtotal_af_disc'] = esc_html__( 'Enter Subtotal After Discount', 'advanced-easy-shipping-for-woocommerce' );
    $asw_placeholder_arr['city'] = esc_html__( 'Enter City Name With Comma Separate', 'advanced-easy-shipping-for-woocommerce' );
    $asw_placeholder_arr['postcode'] = esc_html__( 'Enter Postcode With Comma Separate', 'advanced-easy-shipping-for-woocommerce' );
    $asw_placeholder_arr['payment_method'] = esc_html__( 'Select Payment Method', 'advanced-easy-shipping-for-woocommerce' );
    return wp_json_encode(
        /**
         * Apply filter for fields placeholder.
         */
        apply_filters( 'asw_placeholder_for_fields', $asw_placeholder_arr )
    );
}

/**
 * Get current site language.
 *
 * @return string $default_lang It will return default language for site.
 *
 * @since 1.2
 */
function idm_asw_current_site_language()
{
    $get_site_language = get_bloginfo( 'language' );
    
    if ( false !== strpos( $get_site_language, '-' ) ) {
        $get_site_language_explode = explode( '-', $get_site_language );
        $default_lang = $get_site_language_explode[0];
    } else {
        $default_lang = $get_site_language;
    }
    
    return $default_lang;
}

/**
 * Get default language.
 *
 * @return string $default_lang It will return default language for site.
 *
 * @since 1.2
 */
function idm_asw_get_default_language()
{
    global  $sitepress ;
    
    if ( !empty($sitepress) ) {
        $default_lang = $sitepress->get_current_language();
    } else {
        $default_lang = idm_asw_current_site_language();
    }
    
    return $default_lang;
}

/**
 * Get id based on language.
 *
 * @param int    $get_id      Get id.
 *
 * @param string $default_lan Get default language.
 *
 * @param string $post_type   Post type get.
 *
 * @return int $get_method_id_bol It will return id based on language.
 *
 * @since 1.2
 */
function asw_get_id_based_on_lan( $get_id, $default_lan, $post_type )
{
    global  $sitepress ;
    
    if ( !empty($sitepress) ) {
        /**
         * Apply filter for post id based on wpml language.
         */
        $get_method_id_bol = apply_filters(
            'wpml_object_id',
            $get_id,
            $post_type,
            true,
            $default_lan
        );
    } else {
        $get_method_id_bol = $get_id;
    }
    
    return $get_method_id_bol;
}

/**
 * Get term id based on language.
 *
 * @param int    $category_id Get id.
 *
 * @param string $default_lan Get default language.
 *
 * @param string $post_type   Post type get.
 *
 * @return array $get_lang_tag It will return array based on language.
 *
 * @since 1.2
 */
function asw_get_tid_based_on_lan( $category_id, $default_lan, $post_type )
{
    global  $sitepress ;
    
    if ( !empty($sitepress) ) {
        $get_term_id = asw_get_id_based_on_lan( $category_id, $default_lan, $post_type );
    } else {
        $get_term_id = $category_id;
    }
    
    $get_lang_tag = get_term_by( 'id', $get_term_id, $post_type );
    return $get_lang_tag;
}

/**
 * Get post type based on select condition name.
 *
 * @param string $get_asw_cn_key Select condition name.
 *
 * @return string
 *
 * @since 3.0
 */
function asw_get_post_type( $get_asw_cn_key )
{
    $post_type = 'product';
    if ( 'categorys' === $get_asw_cn_key ) {
        $post_type = 'product_cat';
    }
    if ( 'tags' === $get_asw_cn_key ) {
        $post_type = 'product_tag';
    }
    /**
     * Apply filter for get post type.
     */
    return apply_filters( 'asw_get_post_type', $post_type );
}

/**
 * Get product type.
 *
 * @param string $request_main_cd Select condition name.
 *
 * @return string
 *
 * @since 3.0
 */
function asw_get_prd_type( $request_main_cd )
{
    $prd_type = 'simple';
    /**
     * Apply filter for get product type.
     */
    return apply_filters( 'asw_get_prd_type', $prd_type );
}

/**
 * Function will get freemius details.
 */
function asw_get_freemius_details()
{
    $fs = freemius( 8790 );
    $has_paid_plan = $fs->apply_filters( 'has_paid_plan_account', $fs->has_paid_plan() );
    $license = $fs->_get_license();
    $is_premium = $fs->is_premium();
    $license_text = __( 'Free', 'advanced-easy-shipping-for-woocommerce' );
    
    if ( $license && $has_paid_plan ) {
        
        if ( $fs->has_premium_version() ) {
            
            if ( $is_premium ) {
                $license_text = __( 'Premium', 'advanced-easy-shipping-for-woocommerce' );
            } elseif ( $fs->can_use_premium_code() ) {
                $license_text = __( 'Free', 'advanced-easy-shipping-for-woocommerce' );
            }
        
        } else {
            $license_text = __( 'Free', 'advanced-easy-shipping-for-woocommerce' );
        }
    
    } else {
        $license_text = __( 'Free', 'advanced-easy-shipping-for-woocommerce' );
    }
    
    return $license_text;
}
