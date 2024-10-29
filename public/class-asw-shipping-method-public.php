<?php

/**
 * The front-specific functionality of the plugin.
 *
 * @package    Advanced_Easy_Shipping_For_WooCommerce
 * @subpackage Advanced_Easy_Shipping_For_WooCommerce/public
 */
// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * ASW_Shipping_Method_Public class.
 */
if ( !class_exists( 'ASW_Shipping_Method_Public' ) ) {
    /**
     * ASW_Shipping_Method_Public class.
     */
    class ASW_Shipping_Method_Public
    {
        /**
         * Constructor.
         *
         * @since 1.0.0
         */
        public function __construct()
        {
            $this->init();
        }
        
        /**
         * Call actions and filters.
         *
         * @since 1.0.0
         */
        public function init()
        {
            add_action(
                'wp_enqueue_scripts',
                array( $this, 'idm_asw_enqueue_scripts' ),
                10,
                2
            );
            add_filter( 'woocommerce_shipping_methods', array( $this, 'asw_add_shipping_method' ) );
            add_action( 'woocommerce_shipping_init', array( $this, 'asw_start_shipping_section' ) );
            add_action(
                'woocommerce_after_shipping_rate',
                array( $this, 'asw_display_option_description' ),
                10,
                2
            );
            add_filter(
                'woocommerce_cart_shipping_method_full_label',
                array( $this, 'asw_cart_shipping_method_edt_dt' ),
                10,
                2
            );
        }
        
        /**
         * Enqueue front side css.
         *
         * @since 1.0.0
         */
        public function idm_asw_enqueue_scripts()
        {
            $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min' );
            wp_enqueue_style(
                'idm-aws-public-css',
                plugin_dir_url( __DIR__ ) . 'assets/css/asw-public' . $suffix . '.css',
                array(),
                'all'
            );
            wp_enqueue_script(
                'idm-aws-public-js',
                plugin_dir_url( __DIR__ ) . 'assets/js/asw-public' . $suffix . '.js',
                array( 'jquery' ),
                ASW_PLUGIN_VERSION,
                false
            );
        }
        
        /**
         * Register plugins shipping method.
         *
         * @param array $methods Setting plugins shipping method.
         *
         * @return array  $methods Setting plugins shipping method.
         *
         * @since 1.0.0
         */
        public function asw_add_shipping_method( $methods )
        {
            $methods[] = 'ASW_Shipping_Method';
            return $methods;
        }
        
        /**
         * Front side shipping section.
         *
         * @since 1.0.0
         */
        public function asw_start_shipping_section()
        {
            require_once plugin_dir_path( __DIR__ ) . 'public/class-asw-shipping-method.php';
        }
        
        /**
         * Display description in cart.
         *
         * @param mixed $method get shipping method.
         *
         * @param int   $index  Getting index for method.
         *
         * @since  1.0
         */
        public function asw_display_option_description( $method, $index )
        {
            $meta_data = $method->get_meta_data();
            
            if ( isset( $meta_data['tooltip_description'] ) && !empty($meta_data['tooltip_description']) ) {
                echo  '<div class="tooltip asw_tooltip">
    					<span class="dashicons dashicons-editor-help"></span>
                        <div class="tooltiptext">' ;
                
                if ( 'idm_combine_shipping' === $method->id ) {
                    
                    if ( false !== strpos( $meta_data['tooltip_description'], ',' ) ) {
                        $explode_data = explode( ',', $meta_data['tooltip_description'] );
                    } else {
                        $explode_data = array( $meta_data['tooltip_description'] );
                    }
                    
                    if ( !empty($explode_data) ) {
                        foreach ( $explode_data as $key => $explode_value ) {
                            $key++;
                            if ( !empty($explode_value) ) {
                                echo  '<span>' . wp_kses_post( $key ) . ' - ' . wp_kses_post( stripslashes( $explode_value ) ) . '</span>' ;
                            }
                        }
                    }
                } else {
                    if ( !empty($meta_data['tooltip_description']) ) {
                        echo  '<span>' . wp_kses_post( stripslashes( $meta_data['tooltip_description'] ) ) . '</span>' ;
                    }
                }
                
                echo  '</div>
                       </div>' ;
            }
        
        }
        
        /**
         * Function will add estimation time for shipping.
         *
         * @param string $label  Shipping label.
         * @param object $method Shipping data.
         *
         * @since 3.0.9
         *
         * @return mixed|void
         */
        public function asw_cart_shipping_method_edt_dt( $label, $method )
        {
            $shipping_id = $method->get_id();
            if ( empty($shipping_id) ) {
                return $label;
            }
            $est_label = $label;
            $estimation_time = get_post_meta( $shipping_id, 'asw_est_delivery_time', true );
            if ( !empty($estimation_time) ) {
                $est_label .= '<br /><small class="shipping-estimation">' . $estimation_time . '</small>';
            }
            return apply_filters(
                'asw_cart_shipping_method_edt_dt',
                $est_label,
                $label,
                $method
            );
        }
    
    }
}
$asw_shipping_method_public = new ASW_Shipping_Method_Public();