<?php

/**
 * Admin section.
 *
 * @package    Advanced_Easy_Shipping_For_WooCommerce
 * @subpackage Advanced_Easy_Shipping_For_WooCommerce/includes
 */
// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * ASW_Admin class.
 */
if ( !class_exists( 'ASW_Admin' ) ) {
    /**
     * ASW_Admin class.
     */
    class ASW_Admin
    {
        /**
         * The name of this plugin.
         *
         * @since    1.0.0
         * @var      string $plugin_name The ID of this plugin.
         */
        private  $plugin_name ;
        /**
         * The version of this plugin.
         *
         * @since    1.0.0
         * @var      string $version The current version of this plugin.
         */
        private  $version ;
        /**
         * Default language.
         *
         * @since 1.2
         * @var      string $default_language The default language of site.
         */
        private  $default_language ;
        /**
         * Check woocommerce subscription is active.
         *
         * @since 3.0
         * @var      string $default_language The default language of site.
         */
        private  $wcs ;
        /**
         * Check woocommerce product_bundle is active.
         *
         * @since 3.0
         * @var      string $default_language The default language of site.
         */
        private  $wpb ;
        /**
         * Define the plugins name and versions and also call admin section.
         *
         * @since    1.0.0
         */
        public function __construct()
        {
            $this->plugin_name = 'Advance Easy Shipping';
            $this->version = ASW_PLUGIN_VERSION;
            $this->default_language = idm_asw_get_default_language();
            $this->option_group = 'advanced-easy-shipping-for-woocommerce';
            // Apply filter to check active plugin.
            if ( in_array( 'woocommerce-subscriptions/woocommerce-subscriptions.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {
                $this->wcs = true;
            }
            // Apply filter to check active plugin.
            if ( in_array( 'woocommerce-product-bundles/woocommerce-product-bundles.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {
                $this->wpb = true;
            }
            $this->idm_asw_init();
        }
        
        /**
         * Register actions and filters.
         *
         * @since    1.0.0
         */
        public function idm_asw_init()
        {
            $prefix = ( is_network_admin() ? 'network_admin_' : '' );
            add_action( 'admin_menu', array( $this, 'idm_asw_menu' ) );
            add_action( 'init', array( $this, 'idm_asw_post_type' ) );
            add_action( 'admin_enqueue_scripts', array( $this, 'idm_enqueue_scripts' ) );
            add_filter( 'idm_asw_getting_page', array( $this, 'idm_asw_getting_page_fn' ), 10 );
            add_action( 'wp_ajax_aws_get_value_based_on_products', array( $this, 'aws_get_value_based_on_products' ) );
            add_action( 'wp_ajax_aws_get_value_based_on_data', array( $this, 'aws_get_value_based_on_data' ) );
            add_action( 'wp_ajax_aws_get_value_based_on_categorys', array( $this, 'aws_get_value_based_on_categorys' ) );
            add_action( 'wp_ajax_aws_get_value_based_on_tags', array( $this, 'aws_get_value_based_on_tags' ) );
            add_action( 'wp_ajax_aws_get_value_based_on_skus', array( $this, 'aws_get_value_based_on_skus' ) );
            add_action( 'wp_ajax_aws_get_value_based_on_variables', array( $this, 'aws_get_value_based_on_variables' ) );
            add_action( 'wp_ajax_aws_get_value_based_on_prd_spec', array( $this, 'aws_get_value_based_on_prd_spec' ) );
            add_action( 'wp_ajax_aws_get_value_based_on_cat_spec', array( $this, 'aws_get_value_based_on_cat_spec' ) );
            add_action( 'wp_ajax_aws_get_value_based_on_var_prd_spec', array( $this, 'aws_get_value_based_on_var_prd_spec' ) );
            add_action( 'idm_asw_admin_action_current_tab', array( $this, 'idm_asw_admin_action_tab_fn' ) );
            add_filter( 'idm_asw_admin_tab_ft', array( $this, 'idm_asw_admin_tab' ), 10 );
            add_filter( "{$prefix}plugin_action_links_" . plugin_basename( __FILE__ ), array( $this, 'asw_plugin_action_links' ), 10 );
            add_filter( 'idm_get_product_type', array( $this, 'idm_compatible_product_type' ), 10 );
        }
        
        /**
         * Register Post type.
         *
         * @since 1.2
         */
        public function idm_asw_post_type()
        {
            register_post_type( ASW_POST_TYPE, array(
                'labels' => array(
                'name'          => esc_html__( 'Easy Shipping Method', 'advanced-easy-shipping-for-woocommerce' ),
                'singular_name' => esc_html__( 'Easy Shipping Method', 'advanced-easy-shipping-for-woocommerce' ),
            ),
            ) );
        }
        
        /**
         * Using tab array.
         *
         * @return array $tab_array
         *
         * @since 1.0.0
         */
        public static function idm_asw_admin_action_tab_fn()
        {
            $current_tab_array = array(
                'dashboard_section' => esc_html__( 'Dashboard', 'advanced-easy-shipping-for-woocommerce' ),
                'general_section'   => esc_html__( 'Shipping Setting', 'advanced-easy-shipping-for-woocommerce' ),
                'shipping_section'  => esc_html__( 'Shipping Listing', 'advanced-easy-shipping-for-woocommerce' ),
                'free_pro_section'  => esc_html__( 'Free vs Premium', 'advanced-easy-shipping-for-woocommerce' ),
            );
            return $current_tab_array;
        }
        
        /**
         * Getting Tab array.
         *
         * @param array $aon_tab_array Checking array tab.
         *
         * @return array $tab_array Checking array tab.
         *
         * @since 1.0.0
         */
        public function idm_asw_admin_tab( $aon_tab_array )
        {
            $current_tab_array = $this->idm_asw_admin_action_tab_fn();
            
            if ( !empty($aon_tab_array) ) {
                $tab_array = array_merge( $current_tab_array, $aon_tab_array );
            } else {
                $tab_array = $current_tab_array;
            }
            
            return $tab_array;
        }
        
        /**
         * Add menu in woocommerce main menu.
         *
         * @since 1.0.0
         */
        public function idm_asw_menu()
        {
            add_submenu_page(
                'woocommerce',
                'Easy Shipping',
                'Easy Shipping',
                'manage_options',
                'asw-main',
                array( $this, 'idm_asw_main' )
            );
        }
        
        /**
         * Enqueue plugins css and js for admin purpose.
         *
         * @param string $hook using this var we can get current page name.
         *
         * @since 1.0.0
         */
        public function idm_enqueue_scripts( $hook )
        {
            
            if ( false !== strpos( $hook, 'asw-main' ) ) {
                $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min' );
                wp_enqueue_style(
                    'idm-aws-admin-css',
                    plugin_dir_url( __DIR__ ) . 'assets/css/asw-admin' . $suffix . '.css',
                    array(),
                    'all'
                );
                wp_enqueue_style(
                    'select2-min-css',
                    plugin_dir_url( __DIR__ ) . 'assets/css/select2.min.css',
                    array(),
                    'all'
                );
                // Apply filter to check active plugin.
                if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {
                    wp_enqueue_style(
                        'woocommerce_admin_styles',
                        WC()->plugin_url() . '/assets/css/admin.css',
                        array(),
                        'all'
                    );
                }
                wp_enqueue_script(
                    'select2-min-js',
                    plugin_dir_url( __DIR__ ) . 'assets/js/select2.full.min.js',
                    array( 'jquery' ),
                    $this->version,
                    true
                );
                wp_enqueue_script( 'jquery-ui-datepicker' );
                wp_enqueue_script(
                    'jquery-ui-timepicker-js',
                    plugin_dir_url( __DIR__ ) . 'assets/js/jquery-ui-timepicker.js',
                    array( 'jquery-ui-datepicker' ),
                    $this->version,
                    true
                );
                wp_enqueue_style(
                    'jquery-ui-timepicker-css',
                    plugin_dir_url( __DIR__ ) . 'assets/css/jquery-ui-timepicker.css',
                    array(),
                    'all'
                );
                wp_enqueue_style(
                    'jquery-ui-css',
                    plugin_dir_url( __DIR__ ) . 'assets/css/jquery-ui.min.css',
                    '',
                    '1.0.0'
                );
                wp_enqueue_script(
                    'idm-aws-admin-js',
                    plugin_dir_url( __DIR__ ) . 'assets/js/asw-admin' . $suffix . '.js',
                    array( 'jquery', 'jquery-tiptip' ),
                    $this->version,
                    true
                );
                $aws_localize_var = array(
                    'ajaxurl'              => admin_url( 'admin-ajax.php' ),
                    'country_obj'          => asw_get_country_list(),
                    'state_obj'            => asw_get_state_list(),
                    'zone_obj'             => asw_get_zone_list(),
                    'cart_option'          => asw_get_based_on_cart_options(),
                    'location_option'      => asw_get_based_on_locations_options(),
                    'cart_specific_option' => asw_get_based_on_cart_specific_options(),
                    'user_option'          => asw_get_based_on_user_specific_options(),
                    'user_obj'             => asw_user_list(),
                    'conditional_op_more'  => asw_conditional_operator(),
                    'type_of_field'        => asw_array_type_of_fields(),
                    'product_option'       => asw_get_based_on_product_specific_options(),
                    'per_unit_option'      => asw_per_unit_options( 'cc_tc_spec' ),
                    'currency_symbol'      => get_woocommerce_currency_symbol(),
                    'weight_unit'          => get_option( 'woocommerce_weight_unit' ),
                    'dimension_unit'       => get_option( 'woocommerce_dimension_unit' ),
                    'placeholder_arr'      => asw_placeholder_for_fields(),
                );
                wp_localize_script( 'idm-aws-admin-js', 'aws_var', $aws_localize_var );
            }
        
        }
        
        /**
         * Shipping List Page
         *
         * @since    1.0.0
         */
        public function idm_asw_main()
        {
            ?>
			<div class="aes-settings aes-settings--<?php 
            echo  esc_attr( $this->option_group ) ;
            ?>">
				<?php 
            $this->settings_header();
            ?>
				<div class="aes-settings__content">
					<?php 
            $this->settings();
            ?>
				</div>
			</div>
			<?php 
            //require_once ASW_PLUGIN_DIR . '/settings/asw-main.php';
        }
        
        /**
         * Settings aes Header.
         */
        public function settings_header()
        {
            $license_text = asw_get_freemius_details();
            ?>
			<div class="aes-settings__header">
				<h2><?php 
            echo  esc_html( $this->plugin_name ) ;
            ?></h2>
				<span style="margin: 0 0 0 auto; background: #f0f0f1; display: inline-block; padding: 0 10px; border-radius: 13px; height: 26px; line-height: 26px; white-space: nowrap; box-sizing: border-box; color: #656565;">
					<span style="background: green;color: #fff;padding: 2px;border-radius: 2px;" class="freemium">
						<?php 
            echo  esc_html( $license_text ) ;
            ?></span> v<?php 
            echo  $this->version ;
            ?>
				</span>
			</div>
			<?php 
        }
        
        /**
         * Output the settings form
         */
        public function settings()
        {
            do_action( 'aes_before_settings_' . $this->option_group );
            $get_page = self::idm_asw_current_page();
            $current_tab = self::idm_asw_current_tab();
            ?>
			<h2 class="nav-tab-wrapper">
				<?php 
            /**
             * Fires before current tab in admin side.
             */
            $current_tab_array = do_action( 'idm_asw_admin_action_current_tab' );
            
            if ( has_filter( 'idm_asw_ie_admin_tab_ft' ) ) {
                /**
                 * Apply filters for admin tab.
                 */
                $tabing_array = apply_filters( 'idm_asw_ie_admin_tab_ft', $current_tab_array );
            } else {
                /**
                 * Apply filters for admin tab.
                 */
                $tabing_array = apply_filters( 'idm_asw_admin_tab_ft', '' );
            }
            
            foreach ( $tabing_array as $name => $label ) {
                $idm_url = ASW_Admin::idm_dynamic_url( $get_page, $name );
                $active_class = ( $name === $current_tab ? ' nav-tab-active' : '' );
                echo  '<a href="' . esc_url( $idm_url ) . '" class="nav-tab ' . $active_class . '">' . esc_html( $label ) . '</a>' ;
            }
            ?>
			</h2>
			<div class="idomit-plugin-sidebar">
				<div class="iconic-settings-sidebar__widget iconic-settings-sidebar__widget--works-well">
					<h3>
						<?php 
            _e( 'Try Our WordPress Products', 'advanced-easy-shipping-for-woocommerce' );
            ?>
					</h3>
					<div class="iconic-product">
						<div class="iconic-product__image">
							<img src="<?php 
            echo  esc_url( ASW_PLUGIN_URL . 'assets/img/icon-128x128.png' ) ;
            ?>" class="attachment-full size-full" alt="<?php 
            echo  __( 'WooCommerce Advanced Extra Fees', 'advanced-easy-shipping-for-woocommerce' ) ;
            ?>" loading="lazy">
						</div>
						<div class="iconic-product__content">
							<h4 class="iconic-product__title">
								<a target="_blank" href="https://store.idomit.com/product/woocommerce-advanced-extra-fees/?utm_source=Idomit-plugin&amp;utm_medium=Plugin&amp;utm_campaign=idomit-extrafees&amp;utm_content=cross-sell">
									<?php 
            _e( 'WooCommerce Advanced Extra Fees', 'advanced-easy-shipping-for-woocommerce' );
            ?>
								</a>
							</h4>
							<p class="iconic-product__description">
								<?php 
            _e( 'WooCommerce Advanced Extra Fees is the fastest and easiest WooCommerce extra fees plugin with breakthrough performance. Everything works on a fast and easy. Feel no delay – because your time is precious!', 'advanced-easy-shipping-for-woocommerce' );
            ?>
							</p>
							<div class="iconic-product__buttons">
								<p>
									<a href="https://checkout.freemius.com/mode/dialog/plugin/8791/plan/17078/" class="button idomit-buy-now idomit-button idomit-button--small" data-plugin-id="8791" data-plan-id="17078" data-public-key="pk_9e2cdb2a2dcc0324313c11e5c598d" data-type="premium">
										<?php 
            _e( 'Buy Premium', 'advanced-easy-shipping-for-woocommerce' );
            ?>
									</a>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<form method="post" enctype="multipart/form-data">
				<?php 
            $this->generate_aes_fees_table_html_view();
            ?>
			</form>
			<?php 
            do_action( 'aes_after_settings_' . $this->option_group );
        }
        
        /**
         * Settings tab table.
         *
         * Load and render the table on the Advanced Fees settings tab.
         *
         * @since 1.0.0
         *
         * @return string
         */
        public function generate_aes_fees_table_html_view()
        {
            require_once ASW_PLUGIN_DIR . '/settings/asw-main.php';
        }
        
        /**
         * Getting dynamic url.
         *
         * @param string $page_name Getting page name.
         *
         * @param string $tab_name  Getting tab name.
         *
         * @param string $action    Getting action.
         *
         * @param string $post_id   Getting current post id.
         *
         * @param string $nonce     Checking nonce if available in url.
         *
         * @param string $message   Checking if any dynamic messages pass in url.
         *
         * @return mixed $idm_url return url.
         *
         * @since 1.0.0
         */
        public function idm_dynamic_url(
            $page_name,
            $tab_name,
            $action = '',
            $post_id = '',
            $nonce = '',
            $message = ''
        )
        {
            $url_param = array();
            if ( !empty($page_name) ) {
                $url_param['page'] = $page_name;
            }
            if ( !empty($tab_name) ) {
                $url_param['tab'] = $tab_name;
            }
            if ( !empty($action) ) {
                $url_param['action'] = $action;
            }
            if ( !empty($post_id) ) {
                $url_param['post'] = $post_id;
            }
            if ( !empty($nonce) ) {
                $url_param['_wpnonce'] = $nonce;
            }
            if ( !empty($message) ) {
                $url_param['message'] = $message;
            }
            $idm_url = add_query_arg( $url_param, admin_url( 'admin.php' ) );
            return $idm_url;
        }
        
        /**
         * Getting Page.
         *
         * @param string $current_tab Getting current tab name.
         *
         * @since 1.0.0
         */
        public function idm_asw_getting_page_fn( $current_tab )
        {
            
            if ( 'shipping_section' === $current_tab ) {
                require_once ASW_PLUGIN_DIR . '/includes/class-asw-shipping-method-setting.php';
                $asw_sms = new ASW_Shipping_Method_Setting();
                $asw_sms->asw_sms_output();
            } elseif ( 'general_section' === $current_tab ) {
                require_once ASW_PLUGIN_DIR . '/settings/asw-common-setting.php';
            } elseif ( 'dashboard_section' === $current_tab ) {
                include_once ASW_PLUGIN_DIR . '/settings/asw-dashboard.php';
            } elseif ( 'free_pro_section' === $current_tab ) {
                include_once ASW_PLUGIN_DIR . '/settings/asw-free-pro-section.php';
            }
        
        }
        
        /**
         * Get current page.
         *
         * @return string $current_page Getting current page name.
         *
         * @since 1.0.0
         */
        public function idm_asw_current_page()
        {
            $current_page = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRING );
            return $current_page;
        }
        
        /**
         * Get current tab.
         *
         * @return string $current_tab Getting current tab name.
         *
         * @since 1.0.0
         */
        public function idm_asw_current_tab()
        {
            $current_tab = filter_input( INPUT_GET, 'tab', FILTER_SANITIZE_STRING );
            if ( !isset( $current_tab ) ) {
                $current_tab = 'general_section';
            }
            return $current_tab;
        }
        
        /**
         * Validate message for plugins form.
         *
         * @param string $message        Custom Validate message for plugins form.
         *
         * @param string $tab            Get current tab for current page.
         *
         * @param string $validation_msg Display validation error.
         *
         * @return bool
         *
         * @since 1.0.0
         */
        public function idm_asw_updated_message( $message, $tab, $validation_msg )
        {
            if ( empty($message) ) {
                return false;
            }
            
            if ( 'shipping_section' === $tab ) {
                
                if ( 'created' === $message ) {
                    $updated_message = esc_html__( 'Shipping method successfully created.', 'advanced-easy-shipping-for-woocommerce' );
                } elseif ( 'saved' === $message ) {
                    $updated_message = esc_html__( 'Shipping method successfully updated.', 'advanced-easy-shipping-for-woocommerce' );
                } elseif ( 'deleted' === $message ) {
                    $updated_message = esc_html__( 'Shipping method deleted.', 'advanced-easy-shipping-for-woocommerce' );
                } elseif ( 'duplicated' === $message ) {
                    $updated_message = esc_html__( 'Shipping method duplicated.', 'advanced-easy-shipping-for-woocommerce' );
                } elseif ( 'disabled' === $message ) {
                    $updated_message = esc_html__( 'Shipping method disabled.', 'advanced-easy-shipping-for-woocommerce' );
                } elseif ( 'enabled' === $message ) {
                    $updated_message = esc_html__( 'Shipping method enabled.', 'advanced-easy-shipping-for-woocommerce' );
                }
                
                
                if ( 'failed' === $message ) {
                    $failed_messsage = esc_html__( 'There was an error with saving data.', 'advanced-easy-shipping-for-woocommerce' );
                } elseif ( 'nonce_check' === $message ) {
                    $failed_messsage = esc_html__( 'There was an error with security check.', 'advanced-easy-shipping-for-woocommerce' );
                }
                
                if ( 'validated' === $message ) {
                    $validated_messsage = esc_html( $validation_msg );
                }
            } else {
                if ( 'saved' === $message ) {
                    $updated_message = esc_html__( 'Settings save successfully', 'advanced-easy-shipping-for-woocommerce' );
                }
                if ( 'nonce_check' === $message ) {
                    $failed_messsage = esc_html__( 'There was an error with security check.', 'advanced-easy-shipping-for-woocommerce' );
                }
                if ( 'validated' === $message ) {
                    $validated_messsage = esc_html( $validation_msg );
                }
            }
            
            
            if ( !empty($updated_message) ) {
                echo  sprintf( '<div id="message" class="notice notice-success is-dismissible"><p>%s</p></div>', esc_html( $updated_message ) ) ;
                return false;
            }
            
            
            if ( !empty($failed_messsage) ) {
                echo  sprintf( '<div id="message" class="notice notice-error is-dismissible"><p>%s</p></div>', esc_html( $failed_messsage ) ) ;
                return false;
            }
            
            
            if ( !empty($validated_messsage) ) {
                echo  sprintf( '<div id="message" class="notice notice-error is-dismissible"><p>%s</p></div>', esc_html( $validated_messsage ) ) ;
                return false;
            }
        
        }
        
        /**
         * Get Product list based on search value.
         *
         * @param string $search_value Getting search value based on enter in admin forms.
         *
         * @return string
         *
         * @since 1.0.0
         */
        public function idm_get_product_list( $search_value )
        {
            $product_args = array(
                'post_type'      => 'product',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'orderby'        => 'title',
                'order'          => 'ASC',
            );
            
            if ( isset( $search_value ) ) {
                $product_args['search_pro_title'] = $search_value;
                add_filter(
                    'posts_where',
                    array( $this, 'idm_asw_posts_where' ),
                    10,
                    2
                );
                $get_wp_query = new WP_Query( $product_args );
                remove_filter(
                    'posts_where',
                    array( $this, 'idm_asw_posts_where' ),
                    10,
                    2
                );
            } else {
                $get_wp_query = new WP_Query( $product_args );
            }
            
            
            if ( $get_wp_query->have_posts() ) {
                $fetch_all_products = $get_wp_query->posts;
            } else {
                $fetch_all_products = '';
            }
            
            // Apply filter to fetch all products.
            return apply_filters( 'idm_get_product_list', $fetch_all_products );
        }
        
        /**
         * Where condition for post title.
         *
         * @param string $where    searching search value.
         *
         * @param string $wp_query Find search title using $wp_query.
         *
         * @return string $where return search title.
         *
         * @since 1.0.0
         */
        public function idm_asw_posts_where( $where, $wp_query )
        {
            global  $wpdb ;
            $search_term = $wp_query->get( 'search_pro_title' );
            
            if ( !empty($search_term) ) {
                $search_term_like = $wpdb->esc_like( $search_term );
                $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $search_term_like ) . '%\'';
            }
            
            return $where;
        }
        
        /**
         * Get product data based on diff condition.
         *
         * @param array  $post_value      Get Post Value.
         *
         * @param string $request_main_cd Get condition id.
         *
         * @return array
         */
        public function idm_get_product_product_data( $post_value, $request_main_cd )
        {
            $request_main_cd = str_replace( 'cc_', '', $request_main_cd );
            $get_post_type = asw_get_post_type( $request_main_cd );
            $get_prd_type = asw_get_prd_type( $request_main_cd );
            $data_array = array();
            
            if ( 'products' === $request_main_cd ) {
                $product_ids = array();
                $fetch_all_products = $this->idm_get_product_list( $post_value );
                if ( isset( $fetch_all_products ) && !empty($fetch_all_products) ) {
                    foreach ( $fetch_all_products as $fetch_all_product ) {
                        $_product = wc_get_product( $fetch_all_product->ID );
                        
                        if ( $get_prd_type ) {
                            if ( $_product->is_type( $get_prd_type ) ) {
                                $product_ids[] = $fetch_all_product->ID;
                            }
                        } else {
                            $product_ids[] = $fetch_all_product->ID;
                        }
                    
                    }
                }
                if ( isset( $product_ids ) && !empty($product_ids) ) {
                    foreach ( $product_ids as $get_product_id ) {
                        $get_product_id = asw_get_id_based_on_lan( $get_product_id, $this->default_language, $get_post_type );
                        $get_prd_title = get_the_title( $get_product_id );
                        $data_array[] = array( $get_product_id, $get_prd_title );
                    }
                }
            } elseif ( 'categorys' === $request_main_cd || 'tags' === $request_main_cd ) {
                $args = array(
                    'taxonomy'     => $get_post_type,
                    'orderby'      => 'name',
                    'order'        => 'ASC',
                    'hide_empty'   => false,
                    'hierarchical' => true,
                    'fields'       => 'all',
                    'name__like'   => $post_value,
                );
                $get_all_categories = get_terms( $args );
                if ( isset( $get_all_categories ) && !empty($get_all_categories) ) {
                    foreach ( $get_all_categories as $get_all_category ) {
                        $get_lang_tag = asw_get_tid_based_on_lan( $get_all_category->term_id, $this->default_language, $get_post_type );
                        $data_array[] = array( $get_lang_tag->term_id, $get_lang_tag->name );
                    }
                }
            }
            
            return $data_array;
        }
        
        /**
         * Display value based on products.
         *
         * @since 1.0.0
         */
        public function aws_get_value_based_on_data()
        {
            $request_main_cd = filter_input( INPUT_GET, 'main_cd', FILTER_SANITIZE_STRING );
            $request_value = filter_input( INPUT_GET, 'value', FILTER_SANITIZE_STRING );
            $post_value = ( isset( $request_value ) ? sanitize_text_field( $request_value ) : '' );
            $fetch_all_products = $this->idm_get_product_product_data( $post_value, $request_main_cd );
            echo  wp_json_encode( $fetch_all_products ) ;
            wp_die();
        }
    
    }
}
$asw_admin = new ASW_Admin();