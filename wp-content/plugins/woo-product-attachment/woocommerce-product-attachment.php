<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.multidots.com/
 * @since             1.0.0
 * @package           Woocommerce_Product_Attachment
 *
 * @wordpress-plugin
 * Plugin Name: WooCommerce Product Attachment
 * Plugin URI:        https://www.thedotstore.com/
 * Description:       WooCommerce Product Attachment Plugin will help you to attach/ upload any kind of files for a customer orders.You can attach any type of file like Images, documents, videos and many more..
 * Version:           2.1.5
 * Author:            theDotstore
 * Author URI:        https://profiles.wordpress.org/dots
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woocommerce-product-attachment
 * Domain Path:       /languages
 * WC tested up to:   6.8.2
 */
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
    die;
}

if ( function_exists( 'wpap_fs' ) ) {
    wpap_fs()->set_basename( false, __FILE__ );
    return;
}

add_action( 'plugins_loaded', 'wcpoa_initialize_plugin' );
$wc_active = in_array( 'woocommerce/woocommerce.php', get_option( 'active_plugins' ), true );

if ( true === $wc_active ) {
    
    if ( !function_exists( 'wpap_fs' ) ) {
        // Create a helper function for easy SDK access.
        function wpap_fs()
        {
            global  $wpap_fs ;
            
            if ( !isset( $wpap_fs ) ) {
                // Include Freemius SDK.
                require_once dirname( __FILE__ ) . '/freemius/start.php';
                $wpap_fs = fs_dynamic_init( array(
                    'id'              => '3473',
                    'slug'            => 'woo-product-attachment',
                    'type'            => 'plugin',
                    'public_key'      => 'pk_eac499ce039e8334a8d30870fd1fd',
                    'is_premium'      => false,
                    'premium_suffix'  => 'Premium',
                    'has_addons'      => false,
                    'has_paid_plans'  => true,
                    'has_affiliation' => 'selected',
                    'trial'           => array(
                    'days'               => 14,
                    'is_require_payment' => true,
                ),
                    'menu'            => array(
                    'slug'       => 'woocommerce_product_attachment',
                    'first-path' => 'admin.php?page=woocommerce_product_attachment&tab=wcpoa-plugin-getting-started',
                    'contact'    => false,
                    'support'    => false,
                ),
                    'is_live'         => true,
                ) );
            }
            
            return $wpap_fs;
        }
        
        // Init Freemius.
        wpap_fs();
        // Signal that SDK was initiated.
        do_action( 'wpap_fs_loaded' );
        wpap_fs()->get_upgrade_url();
        wpap_fs()->add_action( 'after_uninstall', 'wpap_fs_uninstall_cleanup' );
    }
    
    if ( !defined( 'WCPOA_PLUGIN_URL' ) ) {
        define( 'WCPOA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
    }
    if ( !defined( 'WCPOA_PLUGIN_VERSION' ) ) {
        define( 'WCPOA_PLUGIN_VERSION', '2.1.5' );
    }
    if ( !defined( 'WCPOA_PLUGIN_BASENAME' ) ) {
        define( 'WCPOA_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
    }
    
    if ( function_exists( 'activate_woocommerce_product_attachment' ) ) {
        /** If the free version actitivated then first deactivate it */
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-product-attachment-deactivator.php';
        Woocommerce_Product_Attachment_Deactivator::deactivate();
    } else {
        /**
         * The code that runs during plugin activation.
         * This action is documented in includes/class-woocommerce-product-attachment-activator.php
         */
        function activate_woocommerce_product_attachment()
        {
            require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-product-attachment-activator.php';
            Woocommerce_Product_Attachment_Activator::activate();
        }
        
        /**
         * Check that ACF plugin is activate or not and set flag.
         *
         * @since    2.1.4
         */
        if ( !function_exists( 'wcpoa_set_acf_plugin_active_flag' ) ) {
            function wcpoa_set_acf_plugin_active_flag()
            {
                $acf_pro_active = in_array( 'advanced-custom-fields-pro/acf.php', get_option( 'active_plugins' ), true );
                $acf_active = in_array( 'advanced-custom-fields/acf.php', get_option( 'active_plugins' ), true );
                $acf_flag = get_option( 'wcpoa_acf_plugin_active_flag' );
                
                if ( $acf_pro_active === true || $acf_active === true ) {
                    
                    if ( $acf_flag === false ) {
                        add_option( 'wcpoa_acf_plugin_active_flag', '1' );
                    } else {
                        update_option( 'wcpoa_acf_plugin_active_flag', '1' );
                    }
                
                } else {
                    
                    if ( $acf_flag === false ) {
                        add_option( 'wcpoa_acf_plugin_active_flag', '0' );
                    } else {
                        update_option( 'wcpoa_acf_plugin_active_flag', '0' );
                    }
                
                }
            
            }
        
        }
        wcpoa_set_acf_plugin_active_flag();
        /**
         * The code that runs during plugin deactivation.
         * This action is documented in includes/class-woocommerce-product-attachment-deactivator.php
         */
        function deactivate_woocommerce_product_attachment()
        {
            require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-product-attachment-deactivator.php';
            Woocommerce_Product_Attachment_Deactivator::deactivate();
            // delete acf flag option on plugin deactivation
            delete_option( 'wcpoa_acf_plugin_active_flag' );
        }
        
        register_activation_hook( __FILE__, 'activate_woocommerce_product_attachment' );
        register_deactivation_hook( __FILE__, 'deactivate_woocommerce_product_attachment' );
        /**
         * The core plugin class that is used to define internationalization,
         * admin-specific hooks, and public-facing site hooks.
         */
        require plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-product-attachment.php';
        /**
         * Define all constants
         */
        require plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-product-attachment-constants.php';
        /**
         * User feedback class inclded
         */
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-product-attachment-user-feedback.php';
        /**
         * Begins execution of the plugin.
         *
         * Since everything within the plugin is registered via hooks,
         * then kicking off the plugin from this point in the file does
         * not affect the page life cycle.
         *
         * @since    1.0.0
         */
        function convert_array_to_int( $arr )
        {
            foreach ( $arr as $key => $value ) {
                $arr[$key] = (int) $value;
            }
            return $arr;
        }
        
        function run_woocommerce_product_attachment()
        {
            $plugin = new Woocommerce_Product_Attachment();
            $plugin->run();
        }
        
        run_woocommerce_product_attachment();
        add_action(
            'upgrader_process_complete',
            function ( $upgrader_object, $options ) {
            if ( !get_option( 'wcpoa_product_tab_name' ) ) {
                add_option( 'wcpoa_product_tab_name', 'Attachment' );
            }
            if ( !get_option( 'wcpoa_order_tab_name' ) ) {
                add_option( 'wcpoa_order_tab_name', 'Attachment' );
            }
            if ( !get_option( 'wcpoa_admin_order_tab_name' ) ) {
                add_option( 'wcpoa_admin_order_tab_name', 'Attachment' );
            }
            if ( !get_option( 'wcpoa_att_btn_in_order_list' ) ) {
                add_option( 'wcpoa_att_btn_in_order_list', 'wcpoa_att_btn_in_order_list_enable' );
            }
            if ( !get_option( 'wcpoa_attachments_show_in_email' ) ) {
                add_option( 'wcpoa_attachments_show_in_email', 'yes' );
            }
            if ( !get_option( 'wcpoa_att_btn_position' ) ) {
                add_option( 'wcpoa_att_btn_position', 'wcpoa_att_btn_position_after' );
            }
            if ( !get_option( 'wcpoa_att_in_my_acc' ) ) {
                add_option( 'wcpoa_att_in_my_acc', 'wcpoa_att_in_my_acc_enable' );
            }
            if ( !get_option( 'wcpoa_att_in_thankyou' ) ) {
                add_option( 'wcpoa_att_in_thankyou', 'wcpoa_att_in_thankyou_enable' );
            }
            if ( !get_option( 'wcpoa_attachments_action_on_click' ) ) {
                add_option( 'wcpoa_attachments_action_on_click', 'download' );
            }
            if ( !get_option( 'wcpoa_att_download_btn' ) ) {
                add_option( 'wcpoa_att_download_btn', 'wcpoa_att_btn' );
            }
            if ( !get_option( 'wcpoa_att_btn_in_order_down_tab' ) ) {
                add_option( 'wcpoa_att_btn_in_order_down_tab', 'wcpoa_att_btn_in_order_down_tab_enable' );
            }
            if ( !get_option( 'wcpoa_expired_date_label' ) ) {
                add_option( 'wcpoa_expired_date_label', 'yes' );
            }
            if ( !get_option( 'wcpoa_product_download_type' ) ) {
                add_option( 'wcpoa_product_download_type', 'download_by_btn' );
            }
        },
            10,
            2
        );
    }

}

/**
 * Check Initialize plugin in case of WooCommerce plugin is missing.
 *
 * @since    1.0.0
 */
if ( !function_exists( 'wcpoa_initialize_plugin' ) ) {
    function wcpoa_initialize_plugin()
    {
        $wc_active = in_array( 'woocommerce/woocommerce.php', get_option( 'active_plugins' ), true );
        if ( current_user_can( 'activate_plugins' ) && $wc_active !== true || $wc_active !== true ) {
            add_action( 'admin_notices', 'wcpoa_plugin_admin_notice' );
        }
        load_plugin_textdomain( 'woocommerce-product-attachment', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

}
/**
 * Show admin notice in case of WooCommerce plugin is missing.
 *
 * @since    1.0.0
 */
if ( !function_exists( 'wcpoa_plugin_admin_notice' ) ) {
    function wcpoa_plugin_admin_notice()
    {
        $vpe_plugin = esc_html__( 'WooCommerce Product Attachment', 'woocommerce-product-attachment' );
        $wc_plugin = esc_html__( 'WooCommerce', 'woocommerce-product-attachment' );
        ?>
        <div class="error">
            <p>
                <?php 
        echo  sprintf( esc_html__( '%1$s requires %2$s to be installed & activated!', 'woocommerce-product-attachment' ), '<strong>' . esc_html( $vpe_plugin ) . '</strong>', '<a href="' . esc_url( 'https://wordpress.org/plugins/woocommerce/' ) . '" target="_blank"><strong>' . esc_html( $wc_plugin ) . '</strong></a>' ) ;
        ?>
            </p>
        </div>
        <?php 
    }

}