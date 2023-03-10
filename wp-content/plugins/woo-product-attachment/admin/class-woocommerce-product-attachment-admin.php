<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.multidots.com/
 * @since      1.0.0
 *
 * @package    Woocommerce_Product_Attachment
 * @subpackage Woocommerce_Product_Attachment/admin
 */
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woocommerce_Product_Attachment
 * @subpackage Woocommerce_Product_Attachment/admin
 * @author     Multidots <inquiry@multidots.in>
 */
class Woocommerce_Product_Attachment_Admin
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private  $plugin_name ;
    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private  $version ;
    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct( $plugin_name, $version )
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }
    
    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Woocommerce_Product_Attachment_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Woocommerce_Product_Attachment_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        $current_screen = get_current_screen();
        $post_type = $current_screen->post_type;
        $menu_page = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_SPECIAL_CHARS );
        
        if ( isset( $menu_page ) && !empty($menu_page) && ($menu_page === "woocommerce_product_attachment" || $menu_page === "wcpoa_bulk_attachment") || !empty($post_type) && ($post_type === 'product' || $post_type === 'shop_order') ) {
            wp_enqueue_style( 'thickbox' );
            wp_enqueue_style(
                $this->plugin_name . '-wcpoa-main-style',
                plugin_dir_url( __FILE__ ) . 'css/style.css',
                array(),
                $this->version,
                'all'
            );
            wp_enqueue_style(
                $this->plugin_name,
                plugin_dir_url( __FILE__ ) . 'css/woocommerce-product-attachment-admin.css',
                array(),
                $this->version,
                'all'
            );
            // wp_enqueue_style($this->plugin_name . '-wcpoa-main-style', plugin_dir_url(__FILE__) . 'css/style.css', array(), $this->version, 'all');
            wp_enqueue_style(
                $this->plugin_name . '-font-awesome',
                plugin_dir_url( __FILE__ ) . 'css/font-awesome.min.css',
                array(),
                $this->version,
                'all'
            );
            wp_enqueue_style(
                $this->plugin_name . '-jquery-ui',
                plugin_dir_url( __FILE__ ) . 'css/jquery-ui.min.css',
                array(),
                $this->version,
                'all'
            );
            wp_enqueue_style(
                $this->plugin_name . '-main-jquery-ui',
                plugin_dir_url( __FILE__ ) . 'css/jquery-ui.css',
                array(),
                $this->version,
                'all'
            );
            wp_enqueue_style(
                $this->plugin_name . '-select2.min',
                plugin_dir_url( __FILE__ ) . 'css/select2.min.css',
                array(),
                $this->version,
                'all'
            );
        }
    
    }
    
    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Woocommerce_Product_Attachment_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Woocommerce_Product_Attachment_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        $current_screen = get_current_screen();
        $post_type = $current_screen->post_type;
        $menu_page = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_SPECIAL_CHARS );
        
        if ( isset( $menu_page ) && !empty($menu_page) && ($menu_page === "woocommerce_product_attachment" || $menu_page === "wcpoa_bulk_attachment") || !empty($post_type) && $post_type === 'product' ) {
            wp_enqueue_script( 'postbox' );
            wp_enqueue_script( 'jquery' );
            wp_enqueue_script( 'media-upload' );
            wp_enqueue_script( 'thickbox' );
            wp_enqueue_script( 'jquery-ui-core' );
            wp_enqueue_script( 'jquery-ui-datepicker' );
            wp_enqueue_media();
            wp_enqueue_script(
                $this->plugin_name,
                plugin_dir_url( __FILE__ ) . 'js/woocommerce-product-attachment-admin.js',
                array( 'jquery' ),
                $this->version,
                false
            );
            wp_enqueue_script(
                $this->plugin_name . '-select2_js',
                plugin_dir_url( __FILE__ ) . 'js/select2.full.min.js?ver=4.0.3',
                array( 'jquery' ),
                '4.0.3',
                false
            );
            wp_enqueue_script(
                $this->plugin_name . '-pro',
                plugin_dir_url( __FILE__ ) . 'js/pro-wcpoa-input.js',
                array( 'jquery' ),
                $this->version,
                false
            );
            wp_enqueue_script(
                $this->plugin_name . '-datepicker',
                plugin_dir_url( __FILE__ ) . 'js/datepicker.min.js',
                array( 'jquery' ),
                $this->version,
                false
            );
            // wp_enqueue_script($this->plugin_name . '-validation', plugin_dir_url(__FILE__) . 'js/jquery.validation.js', array('jquery'), $this->version, false);
            wp_localize_script( $this->plugin_name, 'wcpoa_vars', array(
                'ajaxurl'        => admin_url( 'admin-ajax.php' ),
                'wcpoa_nonce'    => wp_create_nonce( 'ajax_verification' ),
                'validation_msg' => __( 'Please fill required fields in the WooCommerce Product Attachment section below.', 'woocommerce-product-attachment' ),
            ) );
        }
        
        if ( !empty($post_type) && $post_type === 'shop_order' ) {
        }
        if ( isset( $menu_page ) && !empty($menu_page) && $menu_page === "wcpoa_bulk_attachment" ) {
            wp_dequeue_script( 'wp-auth-check' );
        }
    }
    
    public function welcome_wcpoa_plugin_screen_do_activation_redirect()
    {
        // if no activation redirect
        if ( !get_transient( '_welcome_screen_activation_redirect_data' ) ) {
            return;
        }
        // Delete the redirect transient
        delete_transient( '_welcome_screen_activation_redirect_data' );
        // if activating from network, or bulk
        $activate_multi = filter_input( INPUT_GET, 'activate-multi', FILTER_SANITIZE_SPECIAL_CHARS );
        if ( is_network_admin() || isset( $activate_multi ) ) {
            return;
        }
        // Redirect to extra cost welcome  page
        wp_safe_redirect( add_query_arg( array(
            'page' => 'woocommerce_product_attachment&tab=wcpoa-plugin-getting-started',
        ), admin_url( 'admin.php' ) ) );
        exit;
    }
    
    /**
     *
     * dotsstore menu add
     */
    public function dot_store_menu()
    {
        global  $GLOBALS ;
        if ( empty($GLOBALS['admin_page_hooks']['dots_store']) ) {
            add_menu_page(
                'DotStore Plugins',
                'DotStore Plugins',
                'null',
                'dots_store',
                array( $this, 'dot_store_menu_page' ),
                plugin_dir_url( __FILE__ ) . 'images/menu-icon.png',
                25
            );
        }
    }
    
    /**
     *
     * WooCommerce Product Attachment menu add
     */
    public function wcpoa_plugin_menu()
    {
        add_submenu_page(
            "dots_store",
            "WooCommerce Product Attachment",
            "WooCommerce Product Attachment",
            "manage_options",
            "woocommerce_product_attachment",
            array( $this, "wcpoa_options_page" )
        );
        add_submenu_page(
            "dots_store",
            'WooCommerce Product Bulk Attachment',
            'WooCommerce Product Bulk Attachment',
            'edit_posts',
            'wcpoa_bulk_attachment',
            array( $this, "wcpoa_bulk_attachment" )
        );
    }
    
    /*
     * Active Menu
     */
    public function wcpoa_free_active_menu()
    {
        $screen = get_current_screen();
        //DotStore Menu Submenu based conditions
        if ( !empty($screen) && ($screen->id === '' || $screen->id === 'dotstore-plugins_page_wcpoa_bulk_attachment') ) {
            ?>
<script type="text/javascript">
jQuery(document).ready(function($) {
    $('a[href="admin.php?page=woocommerce_product_attachment"]').parent().addClass('current');
    $('a[href="admin.php?page=woocommerce_product_attachment"]').addClass('current');
});
</script>
<?php 
        }
    }
    
    /*
     * Remove Menu.
     */
    public function wcpoa_remove_admin_menus()
    {
        remove_submenu_page( 'dots_store', 'wcpoa_bulk_attachment' );
    }
    
    /**
     * WooCommerce Product Attachment Option Page HTML
     *
     */
    public function wcpoa_options_page()
    {
        require_once plugin_dir_path( __FILE__ ) . 'partials/header/plugin-header.php';
        $menu_tab = filter_input( INPUT_GET, 'tab', FILTER_SANITIZE_SPECIAL_CHARS );
        $wcpoa_attachment_tab = ( isset( $menu_tab ) && !empty($menu_tab) ? $menu_tab : '' );
        
        if ( !empty($wcpoa_attachment_tab) ) {
            if ( $wcpoa_attachment_tab === "wcpoa_plugin_setting_page" ) {
                self::wcpoa_setting_page();
            }
            if ( $wcpoa_attachment_tab === "wcpoa-plugin-getting-started" ) {
                self::wcpoa_plugin_get_started();
            }
            if ( $wcpoa_attachment_tab === "wcpoa-plugin-quick-info" ) {
                self::wcpoa_plugin_quick_info();
            }
        } else {
            self::wcpoa_setting_page();
        }
        
        require_once plugin_dir_path( __FILE__ ) . 'partials/header/plugin-sidebar.php';
    }
    
    public function wcpoa_setting_page()
    {
        global  $sitepress ;
        $wcpoa_product_tab_name = filter_input( INPUT_POST, 'wcpoa_product_tab_name', FILTER_SANITIZE_STRING );
        $wcpoa_order_tab_name = filter_input( INPUT_POST, 'wcpoa_order_tab_name', FILTER_SANITIZE_STRING );
        $wcpoa_admin_order_tab_name = filter_input( INPUT_POST, 'wcpoa_admin_order_tab_name', FILTER_SANITIZE_STRING );
        $wcpoa_expired_date_label = filter_input( INPUT_POST, 'wcpoa_expired_date_label', FILTER_SANITIZE_STRING );
        $wcpoa_default_tab_selected_flag = filter_input( INPUT_POST, 'wcpoa_default_tab_selected_flag', FILTER_SANITIZE_STRING );
        $wcpoa_show_attachment_size_flag = filter_input( INPUT_POST, 'wcpoa_show_attachment_size_flag', FILTER_SANITIZE_STRING );
        $wcpoa_att_download_restrict = filter_input(
            INPUT_POST,
            'wcpoa_att_download_restrict',
            FILTER_SANITIZE_STRING,
            FILTER_REQUIRE_ARRAY
        );
        $wcpoa_att_btn_in_order_list = filter_input( INPUT_POST, 'wcpoa_att_btn_in_order_list', FILTER_SANITIZE_STRING );
        $wcpoa_attachments_show_in_email = filter_input( INPUT_POST, 'wcpoa_attachments_show_in_email', FILTER_SANITIZE_SPECIAL_CHARS );
        $wcpoa_att_in_my_acc = filter_input( INPUT_POST, 'wcpoa_att_in_my_acc', FILTER_SANITIZE_STRING );
        $wcpoa_att_in_thankyou = filter_input( INPUT_POST, 'wcpoa_att_in_thankyou', FILTER_SANITIZE_STRING );
        $attachment_custom_style = filter_input( INPUT_POST, 'attachment_custom_style', FILTER_SANITIZE_STRING );
        $wcpoa_product_download_type = filter_input( INPUT_POST, 'wcpoa_product_download_type', FILTER_SANITIZE_STRING );
        $wcpoa_is_viewable = filter_input( INPUT_POST, 'wcpoa_is_viewable', FILTER_SANITIZE_STRING );
        $wcpoa_product_tab = ( isset( $wcpoa_product_tab_name ) && !empty($wcpoa_product_tab_name) ? $wcpoa_product_tab_name : 'Attachment' );
        $wcpoa_order_tab = ( isset( $wcpoa_order_tab_name ) && !empty($wcpoa_order_tab_name) ? $wcpoa_order_tab_name : 'Attachment' );
        $wcpoa_admin_order_tab = ( isset( $wcpoa_admin_order_tab_name ) && !empty($wcpoa_admin_order_tab_name) ? $wcpoa_admin_order_tab_name : 'Attachment' );
        $wcpoa_expired_date_label = ( isset( $wcpoa_expired_date_label ) && !empty($wcpoa_expired_date_label) ? $wcpoa_expired_date_label : '' );
        $wcpoa_default_tab_selected_flag = ( isset( $wcpoa_default_tab_selected_flag ) && !empty($wcpoa_default_tab_selected_flag) ? $wcpoa_default_tab_selected_flag : '' );
        $wcpoa_show_attachment_size_flag = ( isset( $wcpoa_show_attachment_size_flag ) && !empty($wcpoa_show_attachment_size_flag) ? $wcpoa_show_attachment_size_flag : '' );
        $wcpoa_att_download_restrict_val = ( isset( $wcpoa_att_download_restrict ) && !empty($wcpoa_att_download_restrict) ? $wcpoa_att_download_restrict : '' );
        $wcpoa_att_btn_in_order_list_val = ( isset( $wcpoa_att_btn_in_order_list ) && !empty($wcpoa_att_btn_in_order_list) ? $wcpoa_att_btn_in_order_list : '' );
        $wcpoa_attachments_show_in_email = ( isset( $wcpoa_attachments_show_in_email ) && !empty($wcpoa_attachments_show_in_email) ? $wcpoa_attachments_show_in_email : '' );
        $wcpoa_att_in_my_acc_val = ( isset( $wcpoa_att_in_my_acc ) && !empty($wcpoa_att_in_my_acc) ? $wcpoa_att_in_my_acc : '' );
        $wcpoa_att_in_thankyou_val = ( isset( $wcpoa_att_in_thankyou ) && !empty($wcpoa_att_in_thankyou) ? $wcpoa_att_in_thankyou : '' );
        $attachment_custom_style_val = ( isset( $attachment_custom_style ) && !empty($attachment_custom_style) ? $attachment_custom_style : '' );
        $wcpoa_product_download_type_val = ( isset( $wcpoa_product_download_type ) && !empty($wcpoa_product_download_type) ? $wcpoa_product_download_type : 'download_by_btn' );
        $wcpoa_is_viewable_val = ( isset( $wcpoa_is_viewable ) && !empty($wcpoa_is_viewable) ? $wcpoa_is_viewable : '' );
        //save on database two tab value
        $menu_page = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_SPECIAL_CHARS );
        $attachment_submit = filter_input( INPUT_POST, 'submit', FILTER_SANITIZE_SPECIAL_CHARS );
        
        if ( isset( $attachment_submit ) && isset( $menu_page ) && $menu_page === 'woocommerce_product_attachment' ) {
            update_option( 'wcpoa_product_tab_name', $wcpoa_product_tab );
            update_option( 'wcpoa_order_tab_name', $wcpoa_order_tab );
            update_option( 'wcpoa_admin_order_tab_name', $wcpoa_admin_order_tab );
            
            if ( !empty($sitepress) ) {
                do_action(
                    'wpml_register_single_string',
                    WCPOA_PLUGIN_TEXT_DOMAIN,
                    sanitize_text_field( $wcpoa_product_tab ),
                    sanitize_text_field( $wcpoa_product_tab )
                );
                do_action(
                    'wpml_register_single_string',
                    WCPOA_PLUGIN_TEXT_DOMAIN,
                    sanitize_text_field( $wcpoa_order_tab ),
                    sanitize_text_field( $wcpoa_order_tab )
                );
                do_action(
                    'wpml_register_single_string',
                    WCPOA_PLUGIN_TEXT_DOMAIN,
                    sanitize_text_field( $wcpoa_admin_order_tab ),
                    sanitize_text_field( $wcpoa_admin_order_tab )
                );
            }
            
            update_option( 'wcpoa_expired_date_label', $wcpoa_expired_date_label );
            update_option( 'wcpoa_default_tab_selected_flag', $wcpoa_default_tab_selected_flag );
            update_option( 'wcpoa_show_attachment_size_flag', $wcpoa_show_attachment_size_flag );
            update_option( 'wcpoa_attachments_show_in_email', $wcpoa_attachments_show_in_email );
            update_option( 'wcpoa_att_download_restrict', $wcpoa_att_download_restrict_val );
            update_option( 'wcpoa_att_btn_in_order_list', $wcpoa_att_btn_in_order_list_val );
            update_option( 'wcpoa_att_in_my_acc', $wcpoa_att_in_my_acc_val );
            update_option( 'wcpoa_att_in_thankyou', $wcpoa_att_in_thankyou_val );
            update_option( 'attachment_custom_style', $attachment_custom_style_val );
            update_option( 'wcpoa_product_download_type', $wcpoa_product_download_type_val );
            update_option( 'wcpoa_is_viewable', $wcpoa_is_viewable_val );
            ?>
<div id="message" class="updated wcpoa-notice notice notice-success is-dismissible">
    <p><?php 
            esc_html_e( 'Attachment setting updated.', 'woocommerce-product-attachment' );
            ?></p>
    <button type="button" class="notice-dismiss">
        <span class="screen-reader-text"><?php 
            esc_html_e( 'Dismiss this notice.', 'woocommerce-product-attachment' );
            ?></span>
    </button>
</div>
<?php 
        }
        
        //store value in variable
        $wcpoa_product_tname = get_option( 'wcpoa_product_tab_name' );
        $wcpoa_order_tname = get_option( 'wcpoa_order_tab_name' );
        $wcpoa_admin_order_tname = get_option( 'wcpoa_admin_order_tab_name' );
        $wcpoa_product_download_type = get_option( 'wcpoa_product_download_type' );
        $wcpoa_is_viewable = get_option( 'wcpoa_is_viewable' );
        $wcpoa_expired_date_tlabel = get_option( 'wcpoa_expired_date_label' );
        $wcpoa_default_tab_selected_flag = get_option( 'wcpoa_default_tab_selected_flag' );
        $wcpoa_show_attachment_size_flag = get_option( 'wcpoa_show_attachment_size_flag' );
        $wcpoa_att_download_restrict = get_option( 'wcpoa_att_download_restrict' );
        $wcpoa_att_btn_in_order_list = get_option( 'wcpoa_att_btn_in_order_list' );
        $wcpoa_attachments_show_in_email = get_option( 'wcpoa_attachments_show_in_email' );
        $wcpoa_att_in_my_acc = get_option( 'wcpoa_att_in_my_acc' );
        $wcpoa_att_in_thankyou = get_option( 'wcpoa_att_in_thankyou' );
        $attachment_custom_style = get_option( 'attachment_custom_style' );
        ?>
<div class="wcpoa-table-main">
    <form method="post" action="#" enctype="multipart/form-data">
        <div class="wcpoa-general-content">
            <div class="wcpoa-general-front-end-product">
                <div class="wcpoa-general-content-heading">
                    <h3><?php 
        esc_html_e( 'FRONTEND: Product Page', 'woocommerce-product-attachment' );
        ?></h3>
                </div>
                <div class="wcpoa-general-input text-title">
                    <label
                        class="wcpoa-general-input-title"><?php 
        esc_html_e( 'Frontend Product Page Tab Title', 'woocommerce-product-attachment' );
        ?></label>
                    <div class="wcpoa-general-input-value">
                        <input type="text" name="wcpoa_product_tab_name"
                            value="<?php 
        echo  esc_attr( $wcpoa_product_tname ) ;
        ?>">
                        <span class="wcpoa-description-tooltip-icon"></span>
                        <p class="wcpoa-description">
                            <?php 
        esc_html_e( 'Add the name of the Product Page tab title. It will be displayed on the front end. All attachment showcase under this tab name. Default tab name: Attachment', 'woocommerce-product-attachment' );
        ?>
                        </p>
                        <div class="product_attachment_help">
                            <span class="dashicons dashicons-info-outline"></span>
                            <a href="<?php 
        echo  esc_url( 'https://docs.thedotstore.com/article/369-how-to-add-frontend-product-page-tab-title-and-why-is-it-for' ) ;
        ?>"
                                target="_blank"><?php 
        esc_html_e( 'View Documentation', 'woocommerce-product-attachment' );
        ?></a>
                        </div>
                    </div>
                </div>
                <div class="wcpoa-general-input">
                    <label
                        class="wcpoa-general-input-title"><?php 
        esc_html_e( 'User Role Based Display Attachment', 'woocommerce-product-attachment' );
        ?></label>
                    <div class="wcpoa-general-input-value">
                        <p class="description">
                            <?php 
        esc_html_e( 'Select user role, which you want to display an attachment. Leave unselected then apply to all.', 'woocommerce-product-attachment' );
        ?>
                        </p>
                        <div class="wcpoa-name-chxbox wcpoa-user-role-base-attach">
                            <ul class="wcpoa-checkbox-list">
                                <li>
                                    <label for="wcpoa_wc_order_pending">
                                        <input name="wcpoa_att_download_restrict[]" class=""
                                            value="wcpoa_att_download_guest" type="checkbox"
                                            <?php 
        if ( empty($wcpoa_att_download_restrict) ) {
            $wcpoa_att_download_restrict = array();
        }
        if ( !is_null( $wcpoa_att_download_restrict ) && in_array( 'wcpoa_att_download_guest', $wcpoa_att_download_restrict, true ) ) {
            echo  'checked="checked"' ;
        }
        ?>><?php 
        esc_html_e( 'Guest / Not logged In', 'woocommerce-product-attachment' );
        ?></label>
                                </li>
                                <?php 
        global  $wp_roles ;
        foreach ( $wp_roles->roles as $key => $value ) {
            if ( empty($wcpoa_att_download_restrict) ) {
                $wcpoa_att_download_restrict = array();
            }
            $wcpoa_att_download_restric_key = "wcpoa_att_download_" . $key;
            ?>
                                <li>
                                    <label for="wcpoa_wc_order_pending">
                                        <input name="wcpoa_att_download_restrict[]" class=""
                                            value="wcpoa_att_download_<?php 
            echo  esc_attr( $key ) ;
            ?>" type="checkbox"
                                            <?php 
            if ( !is_null( $wcpoa_att_download_restrict ) && in_array( $wcpoa_att_download_restric_key, $wcpoa_att_download_restrict, true ) ) {
                echo  'checked="checked"' ;
            }
            ?>><?php 
            esc_html_e( $value['name'], 'woocommerce-product-attachment' );
            ?></label>
                                </li>
                                <?php 
        }
        ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wcpoa-general-order-attachment">
                <div class="wcpoa-general-content-heading">
                    <h3><?php 
        esc_html_e( 'Order Attachment Setting', 'woocommerce-product-attachment' );
        ?></h3>
                </div>
                <div class="wcpoa-general-input text-title">
                    <label
                        class="wcpoa-general-input-title"><?php 
        esc_html_e( 'Order Details Page Tab Title', 'woocommerce-product-attachment' );
        ?></label>
                    <div class="wcpoa-general-input-value">
                        <input type="text" name="wcpoa_order_tab_name"
                            value="<?php 
        echo  esc_attr( $wcpoa_order_tname ) ;
        ?>">
                        <span class="wcpoa-description-tooltip-icon"></span>
                        <p class="wcpoa-description">
                            <?php 
        esc_html_e( 'Add the name of the order page tab title. It will be displayed on the front end. All attachment showcase under this tab name. Default tab name: Attachment', 'woocommerce-product-attachment' );
        ?>
                        </p>
                        <div class="product_attachment_help">
                            <span class="dashicons dashicons-info-outline"></span>
                            <a href="<?php 
        echo  esc_url( 'https://docs.thedotstore.com/article/397-how-to-update-order-detail-page-attachment-title' ) ;
        ?>"
                                target="_blank"><?php 
        esc_html_e( 'View Documentation', 'woocommerce-product-attachment' );
        ?></a>
                        </div>
                    </div>
                </div>
                <div class="wcpoa-general-input">
                    <label
                        class="wcpoa-general-input-title"><?php 
        esc_html_e( 'Show Attachments Button on Orders Listing Page', 'woocommerce-product-attachment' );
        ?></label>
                    <div class="wcpoa-general-input-value">
                        <div class="wcpoa-name-radio-box">
                            <input type="radio" name="wcpoa_att_btn_in_order_list" class="wcpoa_att_btn_in_order_list"
                                value="wcpoa_att_btn_in_order_list_enable"
                                <?php 
        echo  ( $wcpoa_att_btn_in_order_list === "wcpoa_att_btn_in_order_list_enable" ? 'checked' : '' ) ;
        ?>><?php 
        esc_html_e( 'Enable', 'woocommerce-product-attachment' );
        ?>
                            <input type="radio" name="wcpoa_att_btn_in_order_list" class="wcpoa_att_btn_in_order_list"
                                value="wcpoa_att_btn_in_order_list_disable"
                                <?php 
        echo  ( $wcpoa_att_btn_in_order_list === "wcpoa_att_btn_in_order_list_disable" ? 'checked' : '' ) ;
        ?>><?php 
        esc_html_e( 'Disable', 'woocommerce-product-attachment' );
        ?>
                        </div>
                    </div>
                </div>
                <div class="wcpoa-general-input">
                    <label
                        class="wcpoa-general-input-title"><?php 
        esc_html_e( 'Show Attachments on Order Email', 'woocommerce-product-attachment' );
        ?></label>
                    <div class="wcpoa-general-input-value">
                        <div class="wcpoa-name-radio-box">
                            <input type="radio" name="wcpoa_attachments_show_in_email"
                                class="wcpoa_attachments_show_in_email" value="yes"
                                <?php 
        echo  ( $wcpoa_attachments_show_in_email === "yes" ? 'checked' : '' ) ;
        ?>><?php 
        esc_html_e( 'Yes', 'woocommerce-product-attachment' );
        ?>
                            <input type="radio" name="wcpoa_attachments_show_in_email"
                                class="wcpoa_attachments_show_in_email" value="no"
                                <?php 
        echo  ( $wcpoa_attachments_show_in_email === "no" ? 'checked' : '' ) ;
        ?>><?php 
        esc_html_e( 'No', 'woocommerce-product-attachment' );
        ?>
                        </div>
                    </div>
                </div>
                <?php 
        ?>
                <div class="wcpoa-general-input">
                    <label
                        class="wcpoa-general-input-title"><?php 
        esc_html_e( 'Attachment List Position on Order Details Page', 'woocommerce-product-attachment' );
        echo  wp_kses( '<span class="note_text">- (Available in pro)</span>', $this->allowed_html_tags() ) ;
        ?></label>
                    <div class="wcpoa-general-input-value">
                        <div class="wcpoa-name-radio-box">
                            <input type="radio" name="wcpoa_att_btn_position" class="wcpoa_att_btn_position"
                                value="wcpoa_att_btn_position_after"
                                disabled><?php 
        esc_html_e( 'After Order', 'woocommerce-product-attachment' );
        ?>
                            <input type="radio" name="wcpoa_att_btn_position" class="wcpoa_att_btn_position"
                                value="wcpoa_att_btn_position_before"
                                disabled><?php 
        esc_html_e( 'Before Order', 'woocommerce-product-attachment' );
        ?>
                        </div>
                    </div>
                </div>
                <div class="wcpoa-general-input">
                    <label
                        class="wcpoa-general-input-title"><?php 
        esc_html_e( 'Select to which status email the attachment as to be attached', 'woocommerce-product-attachment' );
        echo  wp_kses( '<span class="note_text">- (Available in pro)</span>', $this->allowed_html_tags() ) ;
        ?></label>
                    <div class="wcpoa-general-input-value">
                        <p class="description">
                            <?php 
        esc_html_e( 'Select order status for which the attachment(s) will be visible.Leave unselected to apply to all.', 'woocommerce-product-attachment' );
        ?>
                        </p>
                        <div class="wcpoa-name-chxbox">
                            <ul class="wcpoa-checkbox-list">
                                <li><label for="wcpoa_wc_order_completed">
                                        <input name="wcpoa_email_order_status[]" class=""
                                            value="customer_completed_order" type="checkbox" disabled>
                                        <?php 
        esc_html_e( 'Completed', 'woocommerce-product-attachment' );
        ?>
                                    </label>
                                </li>
                                <li><label for="wcpoa_wc_order_on_hold">
                                        <input name="wcpoa_email_order_status[]" class="" value="customer_on_hold_order"
                                            type="checkbox" disabled>
                                        <?php 
        esc_html_e( 'On Hold', 'woocommerce-product-attachment' );
        ?>
                                    </label>
                                </li>
                                <li><label for="wcpoa_wc_order_processing">
                                        <input name="wcpoa_email_order_status[]" class=""
                                            value="customer_processing_order" type="checkbox" disabled>
                                        <?php 
        esc_html_e( 'Processing', 'woocommerce-product-attachment' );
        ?>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php 
        ?>
                <div class="wcpoa-general-input">
                    <label
                        class="wcpoa-general-input-title"><?php 
        esc_html_e( 'Admin Order Details Page Tab Title', 'woocommerce-product-attachment' );
        ?></label>
                    <div class="wcpoa-general-input-value text-title">
                        <input type="text" name="wcpoa_admin_order_tab_name"
                            value="<?php 
        echo  esc_attr( $wcpoa_admin_order_tname ) ;
        ?>">
                        <span class="wcpoa-description-tooltip-icon"></span>
                        <p class="wcpoa-description">
                            <?php 
        esc_html_e( 'Add the name of the admin order details page tab title. It will be displayed on the admin side. Default tab name: Attachment', 'woocommerce-product-attachment' );
        ?>
                        </p>
                        <div class="product_attachment_help">
                            <span class="dashicons dashicons-info-outline"></span>
                            <a href="<?php 
        echo  esc_url( 'https://docs.thedotstore.com/article/398-admin-order-page-product-attachment-title' ) ;
        ?>"
                                target="_blank"><?php 
        esc_html_e( 'View Documentation', 'woocommerce-product-attachment' );
        ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wcpoa-general-my-account">
                <div class="wcpoa-general-content-heading">
                    <h3><?php 
        esc_html_e( 'My Account', 'woocommerce-product-attachment' );
        ?></h3>
                </div>
                <div class="wcpoa-general-input">
                    <label
                        class="wcpoa-general-input-title"><?php 
        esc_html_e( 'Show Attachments in My Account Page', 'woocommerce-product-attachment' );
        ?></label>
                    <div class="wcpoa-general-input-value">
                        <div class="wcpoa-name-radio-box">
                            <input type="radio" name="wcpoa_att_in_my_acc" class="wcpoa_att_in_my_acc"
                                value="wcpoa_att_in_my_acc_enable"
                                <?php 
        echo  ( $wcpoa_att_in_my_acc === "wcpoa_att_in_my_acc_enable" ? 'checked' : '' ) ;
        ?>><?php 
        esc_html_e( 'Enable', 'woocommerce-product-attachment' );
        ?>
                            <input type="radio" name="wcpoa_att_in_my_acc" class="wcpoa_att_in_my_acc"
                                value="wcpoa_att_in_my_acc_disable"
                                <?php 
        echo  ( $wcpoa_att_in_my_acc === "wcpoa_att_in_my_acc_disable" ? 'checked' : '' ) ;
        ?>><?php 
        esc_html_e( 'Disable', 'woocommerce-product-attachment' );
        ?>
                            <div class="product_attachment_help">
                                <span class="dashicons dashicons-info-outline"></span>
                                <a href="<?php 
        echo  esc_url( 'https://docs.thedotstore.com/article/371-how-to-show-attachment-in-my-account-page' ) ;
        ?>"
                                    target="_blank"><?php 
        esc_html_e( 'View Documentation', 'woocommerce-product-attachment' );
        ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wcpoa-general-input">
                    <label
                        class="wcpoa-general-input-title"><?php 
        esc_html_e( 'Show Attachments in Thank You Page', 'woocommerce-product-attachment' );
        ?></label>
                    <div class="wcpoa-general-input-value">
                        <div class="wcpoa-name-radio-box">
                            <input type="radio" name="wcpoa_att_in_thankyou" class="wcpoa_att_in_thankyou"
                                value="wcpoa_att_in_thankyou_enable"
                                <?php 
        echo  ( $wcpoa_att_in_thankyou === "wcpoa_att_in_thankyou_enable" ? 'checked' : '' ) ;
        ?>><?php 
        esc_html_e( 'Enable', 'woocommerce-product-attachment' );
        ?>
                            <input type="radio" name="wcpoa_att_in_thankyou" class="wcpoa_att_in_thankyou"
                                value="wcpoa_att_in_thankyou_disable"
                                <?php 
        echo  ( $wcpoa_att_in_thankyou === "wcpoa_att_in_thankyou_disable" ? 'checked' : '' ) ;
        ?>><?php 
        esc_html_e( 'Disable', 'woocommerce-product-attachment' );
        ?>
                            <div class="product_attachment_help">
                                <span class="dashicons dashicons-info-outline"></span>
                                <a href="<?php 
        echo  esc_url( 'https://docs.thedotstore.com/article/372-how-to-show-attachment-on-the-thank-you-page' ) ;
        ?>"
                                    target="_blank"><?php 
        esc_html_e( 'View Documentation', 'woocommerce-product-attachment' );
        ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php 
        ?>
                <div class="wcpoa-general-input">
                    <label
                        class="wcpoa-general-input-title"><?php 
        esc_html_e( 'Show Attachments in Download Tab', 'woocommerce-product-attachment' );
        echo  wp_kses( '<span class="note_text">- (Available in pro)</span>', $this->allowed_html_tags() ) ;
        ?></label>
                    <div class="wcpoa-general-input-value">
                        <div class="wcpoa-name-radio-box">
                            <input type="radio" name="wcpoa_att_btn_in_order_down_tab"
                                class="wcpoa_att_btn_in_order_down_tab" value="wcpoa_att_btn_in_order_down_tab_enable"
                                disabled><?php 
        esc_html_e( 'Enable', 'woocommerce-product-attachment' );
        ?>
                            <input type="radio" name="wcpoa_att_btn_in_order_down_tab"
                                class="wcpoa_att_btn_in_order_down_tab" value="wcpoa_att_btn_in_order_down_tab_disable"
                                disabled><?php 
        esc_html_e( 'Disable', 'woocommerce-product-attachment' );
        ?>
                            <div class="product_attachment_help">
                                <span class="dashicons dashicons-info-outline"></span>
                                <a href="<?php 
        echo  esc_url( 'https://docs.thedotstore.com/article/373-how-to-show-attachment-in-downloads-tab' ) ;
        ?>"
                                    target="_blank"><?php 
        esc_html_e( 'View Documentation', 'woocommerce-product-attachment' );
        ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php 
        ?>
            </div>
            <div class="wcpoa-general-setting">
                <div class="wcpoa-general-content-heading">
                    <h3><?php 
        esc_html_e( 'Attachment Setting', 'woocommerce-product-attachment' );
        ?></h3>
                </div>
                <div class="wcpoa-general-input">
                    <label
                        class="wcpoa-general-input-title"><?php 
        esc_html_e( 'Show Attachments Expire Date', 'woocommerce-product-attachment' );
        ?></label>
                    <div class="wcpoa-general-input-value">
                        <div class="wcpoa-name-radio-box">
                            <input type="radio" name="wcpoa_expired_date_label" class="wcpoa_expired_date_label"
                                value="yes"
                                <?php 
        echo  ( $wcpoa_expired_date_tlabel === "yes" ? 'checked' : '' ) ;
        ?>><?php 
        esc_html_e( 'Yes', 'woocommerce-product-attachment' );
        ?>
                            <input type="radio" name="wcpoa_expired_date_label" class="wcpoa_expired_date_label"
                                value="no"
                                <?php 
        echo  ( $wcpoa_expired_date_tlabel === "no" ? 'checked' : '' ) ;
        ?>><?php 
        esc_html_e( 'No', 'woocommerce-product-attachment' );
        ?>
                            <div class="product_attachment_help">
                                <span class="dashicons dashicons-info-outline"></span>
                                <a href="<?php 
        echo  esc_url( 'https://docs.thedotstore.com/article/375-how-to-show-attachment-expiry-date-for-your-store-as-well-as-email' ) ;
        ?>"
                                    target="_blank"><?php 
        esc_html_e( 'View Documentation', 'woocommerce-product-attachment' );
        ?></a>
                            </div>
                        </div>
                    </div>
                </div>

                <?php 
        ?>
                <div class="wcpoa-general-input">
                    <label
                        class="wcpoa-general-input-title"><?php 
        esc_html_e( 'External URL link button action', 'woocommerce-product-attachment' );
        echo  wp_kses( '<span class="note_text">- (Available in pro)</span>', $this->allowed_html_tags() ) ;
        ?></label>
                    <div class="wcpoa-general-input-value">
                        <div class="wcpoa-name-radio-box">
                            <input type="radio" name="wcpoa_attachments_action_on_click"
                                class="wcpoa_attachments_action_on_click" value="download"
                                disabled><?php 
        esc_html_e( 'Download', 'woocommerce-product-attachment' );
        ?>
                            <input type="radio" name="wcpoa_attachments_action_on_click"
                                class="wcpoa_attachments_action_on_click" value="newtab"
                                disabled><?php 
        esc_html_e( 'View in new tab', 'woocommerce-product-attachment' );
        ?>
                            <span class="wcpoa-description-tooltip-icon"></span>
                            <p class="wcpoa-description">
                                <?php 
        esc_html_e( 'This is the global default settings for external URL. Individual settings will override the settings.', 'woocommerce-product-attachment' );
        ?>
                            </p>
                        </div>

                    </div>
                </div>
                <div class="wcpoa-general-input">
                    <label
                        class="wcpoa-general-input-title"><?php 
        esc_html_e( 'Show Attachments File Icon / Download Button', 'woocommerce-product-attachment' );
        echo  wp_kses( '<span class="note_text">- (Available in pro)</span>', $this->allowed_html_tags() ) ;
        ?></label>
                    <div class="wcpoa-general-input-value">
                        <div class="wcpoa-name-radio-box">
                            <input type="radio" name="wcpoa_att_download_btn" class="wcpoa_att_download_btn"
                                value="wcpoa_att_icon" disabled><?php 
        esc_html_e( 'Upload Icon', 'woocommerce-product-attachment' );
        ?>
                            <input type="radio" name="wcpoa_att_download_btn" class="wcpoa_att_download_btn"
                                value="wcpoa_att_btn" disabled><?php 
        esc_html_e( 'Default Button', 'woocommerce-product-attachment' );
        ?>
                            <div class="product_attachment_help">
                                <span class="dashicons dashicons-info-outline"></span>
                                <a href="<?php 
        echo  esc_url( 'https://docs.thedotstore.com/article/396-global-settings-open-external-url-as-download-or-new-window' ) ;
        ?>"
                                    target="_blank"><?php 
        esc_html_e( 'View Documentation', 'woocommerce-product-attachment' );
        ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php 
        ?>
                <div class="wcpoa-general-input">
                    <label
                        class="wcpoa-general-input-title"><?php 
        esc_html_e( 'Attachments Action', 'woocommerce-product-attachment' );
        ?></label>
                    <div class="wcpoa-general-input-value">
                        <div class="wcpoa-name-radio-box">
                            <input type="radio" name="wcpoa_is_viewable"
                                class="wcpoa_is_viewable" value="no"
                                <?php 
        echo  ( $wcpoa_is_viewable === "no" ? 'checked' : '' ) ;
        ?>><?php 
        esc_html_e( 'Download', 'woocommerce-product-attachment' );
        ?>
                            <input type="radio" name="wcpoa_is_viewable"
                                class="wcpoa_is_viewable" value="yes"
                                <?php 
        echo  ( $wcpoa_is_viewable === "yes" ? 'checked' : '' ) ;
        ?>><?php 
        esc_html_e( 'View', 'woocommerce-product-attachment' );
        ?>
                            <span class="wcpoa-description-tooltip-icon"></span>
                            <p class="wcpoa-description">
                                <?php 
        esc_html_e( 'Set attachments action as download or view in browser.', 'woocommerce-product-attachment' );
        ?>
                            </p>
                        </div>

                    </div>
                </div>
                <div class="wcpoa-general-input">
                    <label
                        class="wcpoa-general-input-title"><?php 
        esc_html_e( 'Download Attachment Option', 'woocommerce-product-attachment' );
        ?></label>
                    <div class="wcpoa-general-input-value">
                        <div class="wcpoa-name-select-box">
                            <select id="wcpoa_product_download_type" name="wcpoa_product_download_type">
                                <option name="download_by_btn" value="download_by_btn" <?php 
        echo  ( $wcpoa_product_download_type === "download_by_btn" ? 'selected' : '' ) ;
        ?>><?php 
        esc_html_e( 'Download By Button', 'woocommerce-product-attachment' );
        ?></option>
                                <option name="download_by_link" value="download_by_link" <?php 
        echo  ( $wcpoa_product_download_type === "download_by_link" ? 'selected' : '' ) ;
        ?>><?php 
        esc_html_e( 'Download By Link', 'woocommerce-product-attachment' );
        ?></option>
                                <option name="download_by_both" value="download_by_both" <?php 
        echo  ( $wcpoa_product_download_type === "download_by_both" ? 'selected' : '' ) ;
        ?>><?php 
        esc_html_e( 'Both', 'woocommerce-product-attachment' );
        ?></option>
                            </select>
                            <span class="wcpoa-description-tooltip-icon"></span>
                            <p class="wcpoa-description"><?php 
        esc_html_e( 'Select an option/type to download the product attachments.', 'woocommerce-product-attachment' );
        ?></p> 
                        </div>

                    </div>
                </div>
            </div>
            <div class="wcpoa-general-setting">
                <div class="wcpoa-general-content-heading">
                    <h3><?php 
        esc_html_e( 'Global Default Setting', 'woocommerce-product-attachment' );
        ?></h3>
                </div>

                <div class="wcpoa-general-input">
                    <label
                        class="wcpoa-general-input-title"><?php 
        esc_html_e( 'Set product attachment tab default selected', 'woocommerce-product-attachment' );
        ?></label>
                    <div class="wcpoa-general-input-value">
                        <div class="wcpoa-name-radio-box">
                            <input type="radio" name="wcpoa_default_tab_selected_flag"
                                class="wcpoa_default_tab_selected_flag" value="yes"
                                <?php 
        echo  ( $wcpoa_default_tab_selected_flag === "yes" ? 'checked' : '' ) ;
        ?>><?php 
        esc_html_e( 'Yes', 'woocommerce-product-attachment' );
        ?>
                            <input type="radio" name="wcpoa_default_tab_selected_flag"
                                class="wcpoa_default_tab_selected_flag" value="no"
                                <?php 
        echo  ( $wcpoa_default_tab_selected_flag === "no" ? 'checked' : '' ) ;
        ?>><?php 
        esc_html_e( 'No', 'woocommerce-product-attachment' );
        ?>
                            <div class="product_attachment_help">
                                <span class="dashicons dashicons-info-outline"></span>
                                <a href="<?php 
        echo  esc_url( 'https://docs.thedotstore.com/article/393-how-to-display-attachment-tab-default-selected' ) ;
        ?>"
                                    target="_blank"><?php 
        esc_html_e( 'View Documentation', 'woocommerce-product-attachment' );
        ?></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="wcpoa-general-input">
                    <label
                        class="wcpoa-general-input-title"><?php 
        esc_html_e( 'Show attachments with size', 'woocommerce-product-attachment' );
        ?></label>
                    <div class="wcpoa-general-input-value">
                        <div class="wcpoa-name-radio-box">
                            <input type="radio" name="wcpoa_show_attachment_size_flag"
                                class="wcpoa_show_attachment_size_flag" value="yes"
                                <?php 
        echo  ( $wcpoa_show_attachment_size_flag === "yes" ? 'checked' : '' ) ;
        ?>><?php 
        esc_html_e( 'Yes', 'woocommerce-product-attachment' );
        ?>
                            <input type="radio" name="wcpoa_show_attachment_size_flag"
                                class="wcpoa_show_attachment_size_flag" value="no"
                                <?php 
        echo  ( $wcpoa_show_attachment_size_flag === "no" ? 'checked' : '' ) ;
        ?>><?php 
        esc_html_e( 'No', 'woocommerce-product-attachment' );
        ?>
                            <div class="product_attachment_help">
                                <span class="dashicons dashicons-info-outline"></span>
                                <a href="<?php 
        echo  esc_url( 'https://docs.thedotstore.com/article/392-how-to-display-attachment-with-attachment-size' ) ;
        ?>"
                                    target="_blank"><?php 
        esc_html_e( 'View Documentation', 'woocommerce-product-attachment' );
        ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
        /**Youtube video new tab admin settings Premium only */
        ?>
            <?php 
        ?>
            <div class="wcpoa-general-setting">
                <div class="wcpoa-general-content-heading">
                    <h3><?php 
        esc_html_e( 'Attachments Custom Styles', 'woocommerce-product-attachment' );
        ?></h3>
                </div>
                <div class="wcpoa-general-input">
                    <label
                        class="wcpoa-general-input-title"><?php 
        esc_html_e( 'Add custom css', 'woocommerce-product-attachment' );
        ?></label>
                    <div class="wcpoa-general-input-value">
                        <textarea name="attachment_custom_style" id="attachment_custom_style" cols="80" rows="5"
                            placeholder=".woocommerce-Tabs-panel--wcpoa_product_tab .wcpoa_attachment_name{}
        .woocommerce-Tabs-panel--wcpoa_product_tab .wcpoa_attachment{}
        .woocommerce-Tabs-panel--wcpoa_product_tab a.wcpoa_attachmentbtn {}"><?php 
        echo  esc_html( $attachment_custom_style ) ;
        ?></textarea>
                        <span class="wcpoa-description-tooltip-icon"></span>
                        <p class="wcpoa-description"><?php 
        esc_html_e( 'Add your custom css for our product attachment section. .woocommerce-Tabs-panel--wcpoa_product_tab .wcpoa_attachment_name{}
        .woocommerce-Tabs-panel--wcpoa_product_tab .wcpoa_attachment{}
        .woocommerce-Tabs-panel--wcpoa_product_tab a.wcpoa_attachmentbtn {}', 'woocommerce-product-attachment' );
        ?></p>
                        <div class="product_attachment_help">
                            <span class="dashicons dashicons-info-outline"></span>
                            <a href="<?php 
        echo  esc_url( 'https://docs.thedotstore.com/article/399-how-to-customize-style-the-attachment-section' ) ;
        ?>"
                                target="_blank"><?php 
        esc_html_e( 'View Documentation', 'woocommerce-product-attachment' );
        ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wcpoa-general-setting">
                <div class="wcpoa-setting-btn wcpoa-general-submit">
                    <?php 
        submit_button();
        ?>
                </div>
            </div>
        </div>
    </form>
</div>
<?php 
    }
    
    /**
     * Plugin Getting started
     *
     */
    function wcpoa_plugin_get_started()
    {
        require_once plugin_dir_path( __FILE__ ) . 'partials/wcpoa-plugin-get-started.php';
    }
    
    /**
     * Plugin Quick Information
     *
     */
    function wcpoa_plugin_quick_info()
    {
        require_once plugin_dir_path( __FILE__ ) . 'partials/wcpoa-plugin-quick-info.php';
    }
    
    public function wcpoa_add_meta_box( $post_type )
    {
        global  $post ;
        
        if ( 'product' === $post_type ) {
            $product_id = $post->ID;
            $_product = wc_get_product( $product_id );
            if ( !$_product->is_type( 'grouped' ) ) {
                add_meta_box(
                    'wcpoa_attachment',
                    __( 'WooCommerce Product Attachment', 'woocommerce-product-attachment' ),
                    array( $this, 'wcpoa_attachment_product_page' ),
                    $post_type,
                    'advanced',
                    'high'
                );
            }
        }
    
    }
    
    public function wcpoa_get_hidden_input( $atts )
    {
        $atts['type'] = 'hidden';
        return '<input ' . $this->wcpoa_esc_attr( $atts ) . ' />';
    }
    
    public function wcpoa_esc_attr( $atts, $return = true )
    {
        // is string?
        
        if ( is_string( $atts ) ) {
            $atts = trim( $atts );
            return esc_attr( $atts );
        }
        
        // validate
        if ( empty($atts) ) {
            return '';
        }
        foreach ( $atts as $key => $value ) {
            echo  esc_html( $key ) . '="' . esc_attr( $value ) . '"' ;
        }
        return;
    }
    
    /**
     * Add metabox on product details page.
     * 
     */
    public function wcpoa_attachment_product_page()
    {
        global 
            $product,
            $post,
            $i,
            $field
        ;
        $product_id = $post->ID;
        $_product = wc_get_product( $product_id );
        // vars
        $div = array(
            'class'    => 'wcpoa-repeater',
            'data-min' => ( isset( $field['min'] ) ? $field['min'] : '' ),
            'data-max' => ( isset( $field['max'] ) ? $field['max'] : '' ),
        );
        // ensure value is an array
        
        if ( empty($field['value']) ) {
            $field['value'] = array();
            $div['class'] .= ' -empty';
        }
        
        // rows
        $field['min'] = ( empty($field['min']) ? 0 : $field['min'] );
        $field['max'] = ( empty($field['max']) ? 0 : $field['max'] );
        // populate the empty row data (used for wcpoacloneindex and min setting)
        $empty_row = array();
        // If there are less values than min, populate the extra values
        if ( $field['min'] ) {
            for ( $i = 0 ;  $i < $field['min'] ;  $i++ ) {
                // continue if already have a value
                if ( array_key_exists( $i, $field['value'] ) ) {
                    continue;
                }
                // populate values
                $field['value'][$i] = $empty_row;
            }
        }
        // If there are more values than man, remove some values
        if ( $field['max'] ) {
            for ( $i = 0 ;  $i < count( $field['value'] ) ;  $i++ ) {
                if ( $i >= $field['max'] ) {
                    unset( $field['value'][$i] );
                }
            }
        }
        // setup values for row clone
        $field['value']['wcpoacloneindex'] = $empty_row;
        // show columns
        $show_order = false;
        $show_add = true;
        
        if ( $field['max'] ) {
            if ( (int) $field['max'] === 1 ) {
                $show_order = false;
            }
            if ( $field['max'] <= $field['min'] ) {
                $show_add = false;
            }
        }
        
        // field wrap
        $before_fields = '';
        $after_fields = '';
        
        if ( 'row' === 'row' ) {
            $before_fields = '<td class="wcpoa-fields -left">';
            $after_fields = '</td>';
        }
        
        // layout
        $div['class'] .= ' -' . 'row';
        $plugin_url = WCPOA_PLUGIN_URL;
        $product_id = $post->ID;
        $product = wc_get_product( $product_id );
        $wcpoa_attachment_ids = get_post_meta( $product_id, 'wcpoa_attachments_id', true );
        $wcpoa_attachment_name = get_post_meta( $product_id, 'wcpoa_attachment_name', true );
        $wcpoa_attach_type = get_post_meta( $product_id, 'wcpoa_attach_type', true );
        $wcpoa_attachment_ext_url = get_post_meta( $product_id, 'wcpoa_attachment_ext_url', true );
        $wcpoa_attachment_url = get_post_meta( $product_id, 'wcpoa_attachment_url', true );
        $wcpoa_attachment_descriptions = get_post_meta( $product_id, 'wcpoa_attachment_description', true );
        $wcpoa_product_open_window_flag = get_post_meta( $product_id, 'wcpoa_product_open_window_flag', true );
        $wcpoa_product_page_enable = get_post_meta( $product_id, 'wcpoa_product_page_enable', true );
        $wcpoa_product_logged_in_flag = get_post_meta( $product_id, 'wcpoa_product_logged_in_flag', true );
        $wcpoa_product_variation = get_post_meta( $product_id, 'wcpoa_variation', true );
        $wcpoa_order_status = array();
        $wcpoa_pd_enable = get_post_meta( $product_id, 'wcpoa_expired_date_enable', true );
        $wcpoa_expired_date = get_post_meta( $product_id, 'wcpoa_expired_date', true );
        wp_nonce_field( plugin_basename( __FILE__ ), 'wcpoa_attachment_nonce' );
        ?>
        <div class="wcpoa-field wcpoa-single-prod-attach wcpoa-field-repeater" data-name="attachments" data-type="repeater"
            data-key="attachments">
            <div class="wcpoa-label">
                <span><?php 
        esc_html_e( 'With these options, Assign attachment to products and categories. ', 'woocommerce-product-attachment' );
        ?></span><br>
                <ul class="wcpoa-top-desc">
                    <li><?php 
        esc_html_e( 'It will downloadable/viewable in the Order details and/or Product pages.', 'woocommerce-product-attachment' );
        ?>
                    </li>
                    <li><?php 
        esc_html_e( 'Each attachment can be visible for different order statuses. ', 'woocommerce-product-attachment' );
        ?>
                    </li>
                    <li><?php 
        esc_html_e( 'Attachments assign to parent category with subcategories (parent category is higher precedence)', 'woocommerce-product-attachment' );
        ?>
                    </li>
                </ul>
            </div>

            <div class="wcpoa-input">
                <div <?php 
        $this->wcpoa_esc_attr_e( $div );
        ?>>
                    <table class="wcpoa-table wcpoa-prod-table">
                        <tbody id="wcpoa-ui-tbody" class="wcpoa-ui-sortable">
                            <tr>
                                <th>
                                    <div class="wcpoa-label top-heading">
                                        <label for="attchment_order"><?php 
        esc_html_e( 'No.', 'woocommerce-product-attachment' );
        ?></label>
                                    </div>
                                    <div class="wcpoa-label top-heading">
                                        <label for="attchment_name"><?php 
        esc_html_e( 'Name', 'woocommerce-product-attachment' );
        ?></label>
                                    </div>
                                    <div class="wcpoa-label top-heading not-mobile">
                                        <label for="attchment_type"><?php 
        esc_html_e( 'Type', 'woocommerce-product-attachment' );
        ?></label>
                                    </div>
                                    <div class="wcpoa-label top-heading not-mobile">
                                        <label
                                            for="attchment_visibility"><?php 
        esc_html_e( 'Show Product page', 'woocommerce-product-attachment' );
        ?></label>
                                    </div>
                                    <div class="wcpoa-label top-heading not-mobile">
                                        <label for="attchment_remove"><?php 
        esc_html_e( 'Expire', 'woocommerce-product-attachment' );
        ?></label>
                                    </div>
                                </th>
                            </tr>
                            <?php 
        $acf_plugin_flag = get_option( 'wcpoa_acf_plugin_active_flag' );
        ?>
                            <input type="hidden" id="acf-plugin-flags" value="<?php 
        esc_attr_e( $acf_plugin_flag, 'woocommerce-product-attachment' );
        ?>">
                            <?php 
        if ( !empty($wcpoa_attachment_ids) && is_array( $wcpoa_attachment_ids ) ) {
            foreach ( $wcpoa_attachment_ids as $key => $wcpoa_attachments_id ) {
                
                if ( !empty($wcpoa_attachments_id) ) {
                    $attachment_name = ( isset( $wcpoa_attachment_name[$key] ) && !empty($wcpoa_attachment_name[$key]) ? $wcpoa_attachment_name[$key] : '' );
                    $wcpoa_attachment_file_id = ( isset( $wcpoa_attachment_url[$key] ) && !empty($wcpoa_attachment_url[$key]) ? $wcpoa_attachment_url[$key] : '' );
                    $wcpoa_attach_type_single = ( isset( $wcpoa_attach_type[$key] ) && !empty($wcpoa_attach_type[$key]) ? $wcpoa_attach_type[$key] : '' );
                    $wcpoa_attachment_description = ( isset( $wcpoa_attachment_descriptions[$key] ) && !empty($wcpoa_attachment_descriptions[$key]) ? $wcpoa_attachment_descriptions[$key] : '' );
                    $wcpoa_product_open_window_flag_val = ( isset( $wcpoa_product_open_window_flag[$key] ) && !empty($wcpoa_product_open_window_flag[$key]) ? $wcpoa_product_open_window_flag[$key] : '' );
                    $wcpoa_product_p_enable = ( isset( $wcpoa_product_page_enable[$key] ) && !empty($wcpoa_product_page_enable[$key]) ? $wcpoa_product_page_enable[$key] : '' );
                    $wcpoa_product_logged_in_flag_val = ( isset( $wcpoa_product_logged_in_flag[$key] ) && !empty($wcpoa_product_logged_in_flag[$key]) ? $wcpoa_product_logged_in_flag[$key] : '' );
                    $wcpoa_product_date_enable = ( isset( $wcpoa_pd_enable[$key] ) && !empty($wcpoa_pd_enable[$key]) ? $wcpoa_pd_enable[$key] : '' );
                    $wcpoa_expired_dates = ( isset( $wcpoa_expired_date[$key] ) && !empty($wcpoa_expired_date[$key]) ? $wcpoa_expired_date[$key] : '' );
                    $wcpoa_order_status_value = get_post_meta( $product_id, 'wcpoa_order_status', true );
                    
                    if ( $wcpoa_order_status_value === 'wc-all' ) {
                        $wcpoa_order_status = array();
                    } else {
                        $wcpoa_order_status = ( isset( $wcpoa_order_status_value[$wcpoa_attachments_id] ) && !empty($wcpoa_order_status_value[$wcpoa_attachments_id]) ? $wcpoa_order_status_value[$wcpoa_attachments_id] : array() );
                    }
                    
                    //file upload
                    // vars
                    $uploader = 'uploader';
                    // vars
                    $o = array(
                        'icon'     => '',
                        'title'    => '',
                        'url'      => '',
                        'filesize' => '',
                        'filename' => '',
                    );
                    $filediv = array(
                        'class'         => 'wcpoa-file-uploader wcpoa-cf',
                        'data-uploader' => $uploader,
                    );
                    // has value?
                    
                    if ( !empty($wcpoa_attachment_file_id) ) {
                        $file = get_post( $wcpoa_attachment_file_id );
                        
                        if ( $file ) {
                            $o['icon'] = wp_mime_type_icon( $wcpoa_attachment_file_id );
                            $o['title'] = $file->post_title;
                            $o['filesize'] = size_format( filesize( get_attached_file( $wcpoa_attachment_file_id ) ) );
                            $o['url'] = wp_get_attachment_url( $wcpoa_attachment_file_id );
                            $explode = explode( '/', $o['url'] );
                            $o['filename'] = end( $explode );
                        }
                        
                        // url exists
                        if ( $o['url'] ) {
                            $filediv['class'] .= ' has-value';
                        }
                    }
                    
                    ?>

                            <tr class="wcpoa-row wcpoa-has-value -collapsed"
                                data-id="<?php 
                    echo  esc_attr( $wcpoa_attachments_id ) ;
                    ?>"
                                id="<?php 
                    echo  esc_attr( $wcpoa_attachments_id ) ;
                    ?>">

                                <?php 
                    echo  wp_kses( $before_fields, $this->allowed_html_tags() ) ;
                    ?>
                                <div class="wcpoa-field -collapsed-target group-title" data-name="_name" data-type="text"
                                    data-key="">
                                    <div class="wcpoa-label order">
                                        <span class="attchment_order"><?php 
                    echo  intval( $i ) + 1 ;
                    $i++;
                    ?></span>
                                    </div>
                                    <div class="wcpoa-label attachment_name">
                                        <label
                                            for="attchment_name"><?php 
                    esc_html_e( $attachment_name, 'woocommerce-product-attachment' );
                    ?></label>
                                        <ul class="attachment_action">
                                            <li><a class="edit_bulk_attach"
                                                    href="#"><?php 
                    esc_html_e( 'Edit', 'woocommerce-product-attachment' );
                    ?></a></li>
                                            <li><a class="-minus small wcpoa-js-tooltip" href="#" data-event="remove-row"
                                                    title="<?php 
                    esc_attr_e( 'Remove', 'woocommerce-product-attachment' );
                    ?>"><?php 
                    esc_html_e( 'Delete', 'woocommerce-product-attachment' );
                    ?></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="wcpoa-label not-mobile">
                                        <?php 
                    
                    if ( $wcpoa_attach_type_single === "file_upload" ) {
                        $path_parts = pathinfo( $o['url'] );
                        $ext = strtolower( $path_parts["extension"] );
                        $file_upload_text = 'File Upload ( .' . $ext . ' )';
                    }
                    
                    ?>
                                        <label
                                            for="attchment_type"><?php 
                    ( $wcpoa_attach_type_single === "file_upload" ? esc_html_e( $file_upload_text, 'woocommerce-product-attachment' ) : esc_html_e( 'External URL', 'woocommerce-product-attachment' ) );
                    ?></label>
                                    </div>
                                    <div class="wcpoa-label not-mobile">
                                        <label for="attchment_visibility">
                                            <?php 
                    
                    if ( "yes" === $wcpoa_product_p_enable ) {
                        esc_html_e( 'Yes', 'woocommerce-product-attachment' );
                    } else {
                        esc_html_e( 'No', 'woocommerce-product-attachment' );
                    }
                    
                    ?>
                                        </label>
                                    </div>
                                    <div class="wcpoa-label not-mobile">
                                        <label for="attchment_expire">
                                            <?php 
                    
                    if ( "no" === $wcpoa_product_date_enable ) {
                        esc_html_e( 'No', 'woocommerce-product-attachment' );
                    } elseif ( "yes" === $wcpoa_product_date_enable ) {
                        esc_html_e( 'Specific Date', 'woocommerce-product-attachment' );
                    } elseif ( "time_amount" === $wcpoa_product_date_enable ) {
                        esc_html_e( 'Specific Time', 'woocommerce-product-attachment' );
                    }
                    
                    ?>
                                        </label>
                                    </div>
                                </div>
                                <div class="wcpoa-field wcpoa-field-id" data-name="id" data-type="text" data-key="">
                                    <div class="wcpoa-label">
                                        <label for=""><?php 
                    esc_html_e( 'Id', 'woocommerce-product-attachment' );
                    ?> </label>
                                    </div>
                                    <div class="wcpoa-input">
                                        <div class="wcpoa-input-wrap">
                                            <input readonly="" class="wcpoa_attachments_id" name="wcpoa_attachments_id[]"
                                                value="<?php 
                    echo  esc_attr( $wcpoa_attachments_id ) ;
                    ?>" placeholder=""
                                                type="text">
                                            <span class="wcpoa-description-tooltip-icon"></span>
                                            <p class="wcpoa-description">
                                                <?php 
                    esc_html_e( 'Attachments Id used to identify each product attachment.This value is automatically generated.', 'woocommerce-product-attachment' );
                    ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="wcpoa-field" data-name="_name" data-type="text" data-key="">
                                    <div class="wcpoa-label">
                                        <label for="attchment_name"><?php 
                    esc_html_e( 'Name', 'woocommerce-product-attachment' );
                    ?>
                                            <span class="wcpoa-required"> *</span></label>
                                    </div>
                                    <div class="wcpoa-input wcpoa-att-name-parent">
                                        <input class="wcpoa-attachment-name" type="text" name="wcpoa_attachment_name[]"
                                            value="<?php 
                    echo  esc_attr( $attachment_name ) ;
                    ?>">
                                        <span class="wcpoa-description-tooltip-icon"></span>
                                        <p class="wcpoa-description">
                                            <?php 
                    esc_html_e( 'Add a name for the attachment. It will be displayed on the front end next download/view button.', 'woocommerce-product-attachment' );
                    ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="wcpoa-field wcpoa-field-textarea " data-name="description" data-type="textarea"
                                    data-key="" data-required="1">
                                    <div class="wcpoa-label">
                                        <label
                                            for="attchment_desc"><?php 
                    esc_html_e( 'Description', 'woocommerce-product-attachment' );
                    ?></label>
                                    </div>
                                    <div class="wcpoa-input">
                                        <textarea class="" name="wcpoa_attachment_description[]" placeholder=""
                                            rows="8"><?php 
                    echo  esc_html( $wcpoa_attachment_description ) ;
                    ?></textarea>
                                        <span class="wcpoa-description-tooltip-icon"></span>
                                        <p class="wcpoa-description">
                                            <?php 
                    esc_html_e( 'You can type a short description of the attachment file. So customers will get details about the attachment file.', 'woocommerce-product-attachment' );
                    ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="wcpoa-field wcpoa-field-select">
                                    <div class="wcpoa-label">
                                        <label
                                            for="wcpoa_attach_type"><?php 
                    esc_html_e( 'Attachment Type', 'woocommerce-product-attachment' );
                    ?></label>
                                    </div>

                                    <div class="wcpoa-input wcpoa_attach_type">
                                        <?php 
                    ?>
                                        <select name="wcpoa_attach_type[]" class="wcpoa_attach_type_list" data-type=""
                                            data-key="">
                                            <option name="file_upload"
                                                <?php 
                    echo  ( $wcpoa_attach_type_single === "file_upload" ? 'selected' : '' ) ;
                    ?>
                                                value="file_upload"><?php 
                    esc_html_e( 'File Upload', 'woocommerce-product-attachment' );
                    ?>
                                            </option>
                                            <option name="" value="" class="wcpoa_pro_class" disabled>
                                                <?php 
                    esc_html_e( 'External URL ( Pro Version )', 'woocommerce-product-attachment' );
                    ?></option>
                                        </select>
                                        <?php 
                    ?>
                                        <span class="wcpoa-description-tooltip-icon"></span>
                                        <p class="wcpoa-description">
                                            <?php 
                    esc_html_e( 'Select the attachment type. Like Upload file / External URL', 'woocommerce-product-attachment' );
                    ?>
                                        </p>
                                    </div>
                                </div>
                                <?php 
                    $is_show = "";
                    ?>
                                <div style="display:<?php 
                    echo  esc_attr( $is_show ) ;
                    ?>"
                                    class="wcpoa-field file_upload wcpoa-field-file required" data-name="file" data-type="file"
                                    data-key="" data-required="1">
                                    <div class="wcpoa-label">
                                        <div class="wcpoa-label">
                                            <label
                                                for="fee_settings_start_date"><?php 
                    esc_html_e( 'Upload Attachment File', 'woocommerce-product-attachment' );
                    ?>
                                                <span class="wcpoa-required">*</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="wcpoa-input" data-id="<?php 
                    echo  esc_attr( $wcpoa_attachments_id ) ;
                    ?>">
                                        <div <?php 
                    $this->wcpoa_esc_attr_e( $filediv );
                    ?>>
                                            <div class="wcpoa-error-message">
                                                <p><?php 
                    echo  'File value is required' ;
                    ?></p>
                                                <input name="wcpoa_attachment_file[]" data-validation="[NOTEMPTY]"
                                                    value="<?php 
                    echo  esc_attr( $wcpoa_attachment_file_id ) ;
                    ?>" data-name="id"
                                                    type="hidden" required="required">
                                            </div>
                                            <div class="show-if-value file-wrap wcpoa-soh">
                                                <div class="file-icon">
                                                    <img data-name="icon" src="<?php 
                    echo  esc_url( $o['icon'] ) ;
                    ?>" alt="" />
                                                </div>
                                                <div class="file-info">
                                                    <p>
                                                        <strong data-name="title"><?php 
                    echo  esc_html( $o['title'] ) ;
                    ?></strong>
                                                    </p>
                                                    <p>
                                                        <strong><?php 
                    esc_html_e( 'File name', 'woocommerce-product-attachment' );
                    ?>
                                                            :</strong>
                                                        <a data-name="filename" href="<?php 
                    echo  esc_url( $o['url'] ) ;
                    ?>"
                                                            target="_blank"><?php 
                    echo  esc_html( $o['filename'] ) ;
                    ?></a>
                                                    </p>
                                                    <p>
                                                        <strong><?php 
                    esc_html_e( 'File size', 'woocommerce-product-attachment' );
                    ?>
                                                            :</strong>
                                                        <span
                                                            data-name="filesize"><?php 
                    echo  esc_html( $o['filesize'] ) ;
                    ?></span>
                                                    </p>

                                                    <ul class="wcpoa-hl wcpoa-soh-target">
                                                        <?php 
                    
                    if ( $uploader !== 'basic' ) {
                        ?>
                                                        <li><a data-id="<?php 
                        echo  esc_attr( $wcpoa_attachments_id ) ;
                        ?>"
                                                                class="wcpoa-icon -pencil dark" data-name="edit" href="#"></a>
                                                        </li>
                                                        <?php 
                    }
                    
                    ?>
                                                        <li><a data-id="<?php 
                    echo  esc_attr( $wcpoa_attachments_id ) ;
                    ?>"
                                                                class="wcpoa-icon -cancel dark" data-name="remove" href="#"></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="hide-if-value">
                                                <?php 
                    
                    if ( $uploader === 'basic' ) {
                        ?>
                                                <?php 
                        
                        if ( $field['value'] && !is_numeric( $field['value'] ) ) {
                            ?>
                                                <div class="wcpoa-error-message">
                                                    <p><?php 
                            echo  esc_html( $field['value'] ) ;
                            ?></p>
                                                </div>
                                                <?php 
                        }
                        
                        ?>
                                                <input type="file" name="<?php 
                        echo  esc_attr( $field['name'] ) ;
                        ?>"
                                                    id="<?php 
                        echo  esc_attr( $field['id'] ) ;
                        ?>" />
                                                <?php 
                    } else {
                        ?>
                                                <p style="margin:0;">
                                                    <?php 
                        esc_html_e( 'No file selected', 'woocommerce-product-attachment' );
                        ?>
                                                    <?php 
                        echo  wp_kses( $this->misha_image_uploader_field( $wcpoa_attachments_id ), $this->allowed_html_tags() ) ;
                        ?>
                                                </p>
                                                <?php 
                    }
                    
                    ?>

                                            </div>
                                            <p class="description">
                                                <?php 
                    esc_html_e( 'Select upload attachment File.', 'woocommerce-product-attachment' );
                    ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php 
                    ?>

                                <div class="wcpoa-field">
                                    <div class="wcpoa-label">
                                        <label
                                            for="product_page_enable"><?php 
                    esc_html_e( 'Open in new window', 'woocommerce-product-attachment' );
                    ?></label>
                                    </div>
                                    <div class="wcpoa-input">
                                        <select id="wcpoa_product_open_window_flag" name="wcpoa_product_open_window_flag[]">
                                            <option name="no"
                                                <?php 
                    echo  ( $wcpoa_product_open_window_flag_val === "no" ? 'selected' : '' ) ;
                    ?>
                                                value="no"><?php 
                    esc_html_e( 'No', 'woocommerce-product-attachment' );
                    ?></option>
                                            <option name="yes"
                                                <?php 
                    echo  ( $wcpoa_product_open_window_flag_val === "yes" ? 'selected' : '' ) ;
                    ?>
                                                value="yes"><?php 
                    esc_html_e( 'Yes', 'woocommerce-product-attachment' );
                    ?></option>
                                        </select>
                                        <span class="wcpoa-description-tooltip-icon"></span>
                                        <p class="wcpoa-description">
                                            <?php 
                    esc_html_e( 'On Product Details page show attachment.', 'woocommerce-product-attachment' );
                    ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="wcpoa-field">
                                    <div class="wcpoa-label">
                                        <label
                                            for="product_page_enable"><?php 
                    esc_html_e( 'Show on Product page', 'woocommerce-product-attachment' );
                    ?></label>
                                    </div>
                                    <div class="wcpoa-input">
                                        <select id="wcpoa_product_page_enable" name="wcpoa_product_page_enable[]">
                                            <option name="yes"
                                                <?php 
                    echo  ( $wcpoa_product_p_enable === "yes" ? 'selected' : '' ) ;
                    ?>
                                                value="yes"><?php 
                    esc_html_e( 'Yes', 'woocommerce-product-attachment' );
                    ?></option>
                                            <option name="no"
                                                <?php 
                    echo  ( $wcpoa_product_p_enable === "no" ? 'selected' : '' ) ;
                    ?> value="no">
                                                <?php 
                    esc_html_e( 'No', 'woocommerce-product-attachment' );
                    ?></option>
                                        </select>
                                        <span class="wcpoa-description-tooltip-icon"></span>
                                        <p class="wcpoa-description">
                                            <?php 
                    esc_html_e( 'On Product Details page show attachment.', 'woocommerce-product-attachment' );
                    ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="wcpoa-field">
                                    <div class="wcpoa-label">
                                        <label
                                            for="product_page_enable"><?php 
                    esc_html_e( 'Show only for logged in users', 'woocommerce-product-attachment' );
                    ?></label>
                                    </div>
                                    <div class="wcpoa-input">
                                        <select id="wcpoa_product_logged_in_flag" name="wcpoa_product_logged_in_flag[]">
                                            <option name="no"
                                                <?php 
                    echo  ( $wcpoa_product_logged_in_flag_val === "no" ? 'selected' : '' ) ;
                    ?>
                                                value="no"><?php 
                    esc_html_e( 'No', 'woocommerce-product-attachment' );
                    ?></option>
                                            <option name="yes"
                                                <?php 
                    echo  ( $wcpoa_product_logged_in_flag_val === "yes" ? 'selected' : '' ) ;
                    ?>
                                                value="yes"><?php 
                    esc_html_e( 'Yes', 'woocommerce-product-attachment' );
                    ?></option>
                                        </select>
                                        <span class="wcpoa-description-tooltip-icon"></span>
                                        <p class="wcpoa-description">
                                            <?php 
                    esc_html_e( 'On Product Details page show attachment.', 'woocommerce-product-attachment' );
                    ?>
                                        </p>
                                    </div>
                                </div>
                                <?php 
                    ?>
                                <div class="wcpoa-field">
                                    <div class="wcpoa-label">
                                        <label
                                            for="attchment_order_status"><?php 
                    esc_html_e( 'Order status', 'woocommerce-product-attachment' );
                    ?></label>

                                    </div>
                                    <div class="wcpoa-input">
                                        <p class="description">
                                            <?php 
                    esc_html_e( 'Select order status, where you want to showcase attachment. Leave unselected then apply to all.', 'woocommerce-product-attachment' );
                    ?>
                                        </p>
                                        <ul class="wcpoa-checkbox-list">
                                            <li><label for="wcpoa_wc_order_completed">
                                                    <input
                                                        name="wcpoa_order_status[<?php 
                    echo  esc_attr( $wcpoa_attachments_id ) ;
                    ?>][]"
                                                        class="" value="wcpoa-wc-completed" type="checkbox"
                                                        <?php 
                    if ( !is_null( $wcpoa_order_status ) && in_array( 'wcpoa-wc-completed', $wcpoa_order_status, true ) ) {
                        echo  'checked="checked"' ;
                    }
                    ?>>
                                                    <?php 
                    esc_html_e( 'Completed', 'woocommerce-product-attachment' );
                    ?>
                                                </label>
                                            </li>
                                            <li><label for="wcpoa_wc_order_on_hold">
                                                    <input
                                                        name="wcpoa_order_status[<?php 
                    echo  esc_attr( $wcpoa_attachments_id ) ;
                    ?>][]"
                                                        class="" value="wcpoa-wc-on-hold" type="checkbox"
                                                        <?php 
                    if ( !is_null( $wcpoa_order_status ) && in_array( 'wcpoa-wc-on-hold', $wcpoa_order_status, true ) ) {
                        echo  'checked="checked"' ;
                    }
                    ?>>
                                                    <?php 
                    esc_html_e( 'On Hold', 'woocommerce-product-attachment' );
                    ?>
                                                </label>
                                            </li>
                                            <li><label for="wcpoa_wc_order_pending">
                                                    <input
                                                        name="wcpoa_order_status[<?php 
                    echo  esc_attr( $wcpoa_attachments_id ) ;
                    ?>][]"
                                                        class="" value="wcpoa-wc-pending" type="checkbox"
                                                        <?php 
                    if ( !is_null( $wcpoa_order_status ) && in_array( 'wcpoa-wc-pending', $wcpoa_order_status, true ) ) {
                        echo  'checked="checked"' ;
                    }
                    ?>>
                                                    <?php 
                    esc_html_e( 'Pending payment', 'woocommerce-product-attachment' );
                    ?>
                                                </label>
                                            </li>
                                            <li><label for="wcpoa_wc_order_processing">
                                                    <input
                                                        name="wcpoa_order_status[<?php 
                    echo  esc_attr( $wcpoa_attachments_id ) ;
                    ?>][]"
                                                        class="" value="wcpoa-wc-processing" type="checkbox"
                                                        <?php 
                    if ( !is_null( $wcpoa_order_status ) && in_array( 'wcpoa-wc-processing', $wcpoa_order_status, true ) ) {
                        echo  'checked="checked"' ;
                    }
                    ?>>
                                                    <?php 
                    esc_html_e( 'Processing', 'woocommerce-product-attachment' );
                    ?>
                                                </label>
                                            </li>
                                            <li><label for="wcpoa_wc_order_cancelled">
                                                    <input
                                                        name="wcpoa_order_status[<?php 
                    echo  esc_attr( $wcpoa_attachments_id ) ;
                    ?>][]"
                                                        class="" value="wcpoa-wc-cancelled" type="checkbox"
                                                        <?php 
                    if ( !is_null( $wcpoa_order_status ) && in_array( 'wcpoa-wc-cancelled', $wcpoa_order_status, true ) ) {
                        echo  'checked="checked"' ;
                    }
                    ?>>
                                                    <?php 
                    esc_html_e( 'Cancelled', 'woocommerce-product-attachment' );
                    ?>
                                                </label>
                                            </li>
                                            <li><label for="wcpoa_wc_order_failed">
                                                    <input
                                                        name="wcpoa_order_status[<?php 
                    echo  esc_attr( $wcpoa_attachments_id ) ;
                    ?>][]"
                                                        class="" value="wcpoa-wc-failed" type="checkbox"
                                                        <?php 
                    if ( !is_null( $wcpoa_order_status ) && in_array( 'wcpoa-wc-failed', $wcpoa_order_status, true ) ) {
                        echo  'checked="checked"' ;
                    }
                    ?>>
                                                    <?php 
                    esc_html_e( 'Failed', 'woocommerce-product-attachment' );
                    ?>
                                                </label>
                                            </li>
                                            <li><label for="wcpoa_wc_order_refunded">
                                                    <input
                                                        name="wcpoa_order_status[<?php 
                    echo  esc_attr( $wcpoa_attachments_id ) ;
                    ?>][]"
                                                        class="" value="wcpoa-wc-refunded" type="checkbox"
                                                        <?php 
                    if ( !is_null( $wcpoa_order_status ) && in_array( 'wcpoa-wc-refunded', $wcpoa_order_status, true ) ) {
                        echo  'checked="checked"' ;
                    }
                    ?>>
                                                    <?php 
                    esc_html_e( 'Refunded', 'woocommerce-product-attachment' );
                    ?>
                                                </label>
                                            </li>
                                        </ul>

                                    </div>
                                </div>

                                <div class="wcpoa-field">
                                    <div class="wcpoa-label">
                                        <label
                                            for="wcpoa_expired_date_enable"><?php 
                    esc_html_e( 'Set Expire date/time', 'woocommerce-product-attachment' );
                    ?></label>
                                    </div>
                                    <div class="wcpoa-input enable_expire_date">
                                        <select name="wcpoa_expired_date_enable[]" class="enable_date_time"
                                            data-type="enable_date_<?php 
                    echo  esc_attr( $wcpoa_attachments_id ) ;
                    ?>" data-key="">
                                            <option name="no"
                                                <?php 
                    echo  ( $wcpoa_product_date_enable === "no" ? 'selected' : '' ) ;
                    ?>
                                                value="no" class=""><?php 
                    esc_html_e( 'No', 'woocommerce-product-attachment' );
                    ?></option>
                                            <option name="yes"
                                                <?php 
                    echo  ( $wcpoa_product_date_enable === "yes" ? 'selected' : '' ) ;
                    ?>
                                                value="yes"><?php 
                    esc_html_e( 'Specific Date', 'woocommerce-product-attachment' );
                    ?></option>
                                            <?php 
                    ?>
                                            <option name="" value="" class="wcpoa_pro_class" disabled>
                                                <?php 
                    esc_html_e( 'Selected time period after purchase ( Pro Version )', 'woocommerce-product-attachment' );
                    ?>
                                            </option>
                                            <?php 
                    ?>
                                        </select>
                                        <span class="wcpoa-description-tooltip-icon"></span>
                                        <p class="wcpoa-description">
                                            <?php 
                    esc_html_e( 'Set a specific date and specific time to access the attachment.', 'woocommerce-product-attachment' );
                    ?>
                                        </p>
                                    </div>
                                </div>
                                <?php 
                    $is_date = ( $wcpoa_product_date_enable !== 'yes' ? 'none' : '' );
                    ?>
                                <div style="display:<?php 
                    echo  esc_attr( $is_date ) ;
                    ?>"
                                    class="wcpoa-field enable_date enable_date_<?php 
                    echo  esc_attr( $wcpoa_attachments_id ) ;
                    ?> wcpoa-field-date-picker"
                                    data-name="date" data-type="date_picker" data-key="" data-required="1" style=''>
                                    <div class="wcpoa-label">
                                        <label
                                            for="wcpoa_expired_date"><?php 
                    esc_html_e( 'Specific Date', 'woocommerce-product-attachment' );
                    ?></label>
                                    </div>
                                    <div class="wcpoa-input">
                                        <div class="wcpoa-date-picker wcpoa-input-wrap" data-date_format="yy/mm/dd">
                                            <input class="input wcpoa-php-date-picker" autocomplete="off"
                                                name="wcpoa_expired_date[]"
                                                value="<?php 
                    if ( $wcpoa_product_date_enable === "yes" ) {
                        echo  esc_attr( $wcpoa_expired_dates ) ;
                    }
                    ?>"
                                                type="text">
                                            <span class="wcpoa-description-tooltip-icon"></span>
                                            <p class="wcpoa-description">
                                                <?php 
                    esc_html_e( 'If an order is placed after the selected date, the attachments will be no longer visible for download. ( Date format: yy/mm/dd )', 'woocommerce-product-attachment' );
                    ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <?php 
                    ?>
                                <?php 
                    echo  wp_kses( $after_fields, $this->allowed_html_tags() ) ;
                    ?>
                            </tr>
                            <?php 
                }
            
            }
        }
        foreach ( $field['value'] as $i => $row ) {
            $row_att = implode( " ", $row );
            $row_class = 'wcpoa-row trr hidden';
            if ( $i === 'wcpoacloneindex' ) {
                $row_class .= ' wcpoa-clone';
            }
            ?>
                            <tr class="<?php 
            echo  esc_attr( $row_class ) ;
            ?>" rowatt="<?php 
            echo  esc_attr( $row_att ) ;
            ?>"
                                data-id="<?php 
            echo  esc_attr( $i ) ;
            ?>">

                                <td class="wcpoa-fields -left">
                                    <div class="wcpoa-field -collapsed-target group-title" data-name="_name" data-type="text"
                                        data-key="">
                                        <div class="wcpoa-label order">
                                            <span class="attchment_order"><?php 
            echo  intval( $i ) + 1 ;
            $i++;
            ?></span>
                                        </div>
                                        <div class="wcpoa-label attachment_name">
                                            <label
                                                for="attchment_name"><?php 
            esc_html_e( 'No Attachment Name', 'woocommerce-product-attachment' );
            ?></label>
                                            <ul class="attachment_action">
                                                <li><a class="edit_bulk_attach"
                                                        href="#"><?php 
            esc_html_e( 'Edit', 'woocommerce-product-attachment' );
            ?></a></li>
                                                <li><a class="-minus small wcpoa-js-tooltip" href="#" data-event="remove-row"
                                                        title="<?php 
            esc_attr_e( 'Remove', 'woocommerce-product-attachment' );
            ?>"><?php 
            esc_html_e( 'Delete', 'woocommerce-product-attachment' );
            ?></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="wcpoa-label not-mobile">
                                            <label for="attchment_type"><?php 
            esc_html_e( '-', 'woocommerce-product-attachment' );
            ?></label>
                                        </div>
                                        <div class="wcpoa-label not-mobile">
                                            <label
                                                for="attchment_visibility"><?php 
            esc_html_e( '-', 'woocommerce-product-attachment' );
            ?></label>
                                        </div>
                                        <div class="wcpoa-label not-mobile">
                                            <label
                                                for="attchment_visibility"><?php 
            esc_html_e( '-', 'woocommerce-product-attachment' );
            ?></label>
                                        </div>
                                    </div>
                                    <div class="wcpoa-field wcpoa-field-id wcpoa-field-58f4972436131" data-name="id"
                                        data-type="text" data-key="field_58f4972436131">
                                        <div class="wcpoa-label">
                                            <label for=""><?php 
            esc_html_e( 'Id', 'woocommerce-product-attachment' );
            ?> </label>
                                        </div>
                                        <div class="wcpoa-input">
                                            <div class="wcpoa-input-wrap">
                                                <input readonly="" class="wcpoa_attachments_id" name="wcpoa_attachments_id[]"
                                                    value="" placeholder="" type="text">
                                                <span class="wcpoa-description-tooltip-icon"></span>
                                                <p class="wcpoa-description">
                                                    <?php 
            esc_html_e( 'Attachments Id used to identify each product attachment.This value is automatically generated.', 'woocommerce-product-attachment' );
            ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="wcpoa-field">
                                        <div class="wcpoa-label">
                                            <label for="attchment_name"><?php 
            esc_html_e( 'Name', 'woocommerce-product-attachment' );
            ?>
                                                <span class="wcpoa-required"> *</span></label>
                                        </div>
                                        <div class="wcpoa-input">
                                            <input class="wcpoa-attachment-name" type="text" name="wcpoa_attachment_name[]"
                                                value="">
                                            <span class="wcpoa-description-tooltip-icon"></span>
                                            <p class="wcpoa-description">
                                                <?php 
            esc_html_e( 'Add a name for the attachment. It will be displayed on the front end next download/view button.', 'woocommerce-product-attachment' );
            ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="wcpoa-field wcpoa-field-textarea " data-name="description" data-type="textarea"
                                        data-key="" data-required="1">
                                        <div class="wcpoa-label">
                                            <label
                                                for="attchment_desc"><?php 
            esc_html_e( 'Description', 'woocommerce-product-attachment' );
            ?></label>
                                        </div>
                                        <div class="wcpoa-input">
                                            <textarea class="" name="wcpoa_attachment_description[]" placeholder=""
                                                rows="8"></textarea>
                                            <span class="wcpoa-description-tooltip-icon"></span>
                                            <p class="wcpoa-description">
                                                <?php 
            esc_html_e( 'You can type a short description of the attachment file. So customers will get details about the attachment file.', 'woocommerce-product-attachment' );
            ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="wcpoa-field">
                                        <div class="wcpoa-label">
                                            <label
                                                for="wcpoa_attach_type"><?php 
            esc_html_e( 'Attachment Type', 'woocommerce-product-attachment' );
            ?></label>
                                        </div>
                                        <div class="wcpoa-input wcpoa_attach_type">
                                            <?php 
            ?>
                                            <select name="wcpoa_attach_type[]" class="wcpoa_attach_type_list" data-type=""
                                                data-key="">
                                                <option name="file_upload" value="file_upload">
                                                    <?php 
            esc_html_e( 'File Upload', 'woocommerce-product-attachment' );
            ?></option>
                                                <option name="" value="" class="wcpoa_pro_class" disabled>
                                                    <?php 
            esc_html_e( 'External URL ( Pro Version )', 'woocommerce-product-attachment' );
            ?>
                                                </option>
                                            </select>
                                            <?php 
            ?>
                                            <span class="wcpoa-description-tooltip-icon"></span>
                                            <p class="wcpoa-description">
                                                <?php 
            esc_html_e( 'Select the attachment type. Like Upload file / External URL.', 'woocommerce-product-attachment' );
            ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="wcpoa-field wcpoa-field-file file_upload" data-name="file" data-type="file"
                                        data-key="field_58f4974e36133" data-required="1">
                                        <div class="wcpoa-label">
                                            <div class="wcpoa-label">
                                                <label
                                                    for="fee_settings_start_date"><?php 
            esc_html_e( 'Upload Attachment File', 'woocommerce-product-attachment' );
            ?>
                                                    <span class="wcpoa-required">*</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="wcpoa-input">
                                            <div class="wcpoa-file-uploader wcpoa-cf" data-uploader="uploader">
                                                <div class="wcpoa-error-message">
                                                    <p><?php 
            esc_html_e( 'File value is required.', 'woocommerce-product-attachment' );
            ?></p>
                                                    <input name="wcpoa_attachment_file[]" value="" data-name="id" type="hidden">
                                                </div>
                                                <div class="show-if-value file-wrap wcpoa-soh">
                                                    <div class="file-icon">
                                                        <img data-name="icon"
                                                            src="<?php 
            echo  esc_url( $plugin_url ) . 'admin/images/default.png' ;
            ?>"
                                                            alt="" title="">
                                                    </div>
                                                    <div class="file-info">
                                                        <p>
                                                            <strong data-name="title"></strong>
                                                        </p>
                                                        <p>
                                                            <strong><?php 
            esc_html_e( 'File name:', 'woocommerce-product-attachment' );
            ?></strong>
                                                            <a data-name="filename" href="" target="_blank"></a>
                                                        </p>
                                                        <p>
                                                            <strong><?php 
            esc_html_e( 'File size:', 'woocommerce-product-attachment' );
            ?></strong>
                                                            <span data-name="filesize"></span>
                                                        </p>

                                                        <ul class="wcpoa-hl wcpoa-soh-target">
                                                            <li><a class="wcpoa-icon -pencil dark" data-name="edit"
                                                                    href="#"></a></li>
                                                            <li><a class="wcpoa-icon -cancel dark" data-name="remove"
                                                                    href="#"></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="hide-if-value">
                                                    <p style="margin:0;">
                                                        <?php 
            esc_html_e( 'No file selected ', 'woocommerce-product-attachment' );
            ?>
                                                        <?php 
            echo  wp_kses( $this->misha_image_uploader_field( 'test' ), $this->allowed_html_tags() ) ;
            ?>
                                                    </p>
                                                </div>
                                                <p class="description">
                                                    <?php 
            esc_html_e( 'Select upload attachment File.', 'woocommerce-product-attachment' );
            ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
            ?>

                                    <div class="wcpoa-field">
                                        <div class="wcpoa-label">
                                            <label
                                                for="product_page_enable"><?php 
            esc_html_e( 'Open in new window', 'woocommerce-product-attachment' );
            ?></label>
                                        </div>
                                        <div class="wcpoa-input">
                                            <select id="wcpoa_product_open_window_flag" name="wcpoa_product_open_window_flag[]">
                                                <option name="no" value="no" selected>
                                                    <?php 
            esc_html_e( 'No', 'woocommerce-product-attachment' );
            ?></option>
                                                <option name="yes" value="yes"><?php 
            esc_html_e( 'Yes', 'woocommerce-product-attachment' );
            ?>
                                                </option>
                                            </select>
                                            <span class="wcpoa-description-tooltip-icon"></span>
                                            <p class="wcpoa-description">
                                                <?php 
            esc_html_e( 'On Product Details page show attachment.', 'woocommerce-product-attachment' );
            ?>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="wcpoa-field">
                                        <div class="wcpoa-label">
                                            <label
                                                for="product_page_enable"><?php 
            esc_html_e( 'Show on Product page', 'woocommerce-product-attachment' );
            ?></label>
                                        </div>
                                        <div class="wcpoa-input">
                                            <select id="wcpoa_product_page_enable" name="wcpoa_product_page_enable[]">
                                                <option name="yes" value="yes" selected>
                                                    <?php 
            esc_html_e( 'Yes', 'woocommerce-product-attachment' );
            ?></option>
                                                <option name="no" value="no"><?php 
            esc_html_e( 'No', 'woocommerce-product-attachment' );
            ?>
                                                </option>
                                            </select>
                                            <span class="wcpoa-description-tooltip-icon"></span>
                                            <p class="wcpoa-description">
                                                <?php 
            esc_html_e( 'On Product Details page show attachment.', 'woocommerce-product-attachment' );
            ?>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="wcpoa-field">
                                        <div class="wcpoa-label">
                                            <label
                                                for="product_page_enable"><?php 
            esc_html_e( 'Show only for logged in users', 'woocommerce-product-attachment' );
            ?></label>
                                        </div>
                                        <div class="wcpoa-input">
                                            <select id="wcpoa_product_logged_in_flag" name="wcpoa_product_logged_in_flag[]">
                                                <option name="no" value="no" selected>
                                                    <?php 
            esc_html_e( 'No', 'woocommerce-product-attachment' );
            ?></option>
                                                <option name="yes" value="yes"><?php 
            esc_html_e( 'Yes', 'woocommerce-product-attachment' );
            ?>
                                                </option>
                                            </select>
                                            <span class="wcpoa-description-tooltip-icon"></span>
                                            <p class="wcpoa-description">
                                                <?php 
            esc_html_e( 'On Product Details page show attachment.', 'woocommerce-product-attachment' );
            ?>
                                            </p>
                                        </div>
                                    </div>
                                    <?php 
            ?>
                                    <div class="wcpoa-field">
                                        <div class="wcpoa-label">
                                            <label
                                                for="attchment_order_status"><?php 
            esc_html_e( 'Order status', 'woocommerce-product-attachment' );
            ?></label>
                                        </div>
                                        <div class="wcpoa-input">
                                            <p class="description">
                                                <?php 
            esc_html_e( 'Select order status, where you want to showcase attachment. Leave unselected then apply to all.', 'woocommerce-product-attachment' );
            ?>
                                            </p>
                                            <ul class="wcpoa-order-checkbox-list">
                                                <li>
                                                    <label for="wcpoa_wc_order_completed">
                                                        <input name="wcpoa_order_status[]" class="" value="wcpoa-wc-completed"
                                                            <?php 
            ?>
                                                            type="checkbox"><?php 
            esc_html_e( 'Completed', 'woocommerce-product-attachment' );
            ?>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label for="wcpoa_wc_order_on_hold">
                                                        <input name="wcpoa_order_status[]" class="" value="wcpoa-wc-on-hold"
                                                            type="checkbox"><?php 
            esc_html_e( 'On Hold', 'woocommerce-product-attachment' );
            ?>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label for="wcpoa_wc_order_pending">
                                                        <input name="wcpoa_order_status[]" class="" value="wcpoa-wc-pending"
                                                            type="checkbox"><?php 
            esc_html_e( 'Pending payment', 'woocommerce-product-attachment' );
            ?>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label for="wcpoa_wc_order_processing">
                                                        <input name="wcpoa_order_status[]" class="" value="wcpoa-wc-processing"
                                                            type="checkbox"><?php 
            esc_html_e( 'Processing', 'woocommerce-product-attachment' );
            ?>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label for="wcpoa_wc_order_cancelled">
                                                        <input name="wcpoa_order_status[]" class="" value="wcpoa-wc-cancelled"
                                                            type="checkbox"><?php 
            esc_html_e( 'Cancelled', 'woocommerce-product-attachment' );
            ?>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label for="wcpoa_wc_order_failed">
                                                        <input name="wcpoa_order_status[]" class="" value="wcpoa-wc-failed"
                                                            type="checkbox"><?php 
            esc_html_e( 'Failed', 'woocommerce-product-attachment' );
            ?>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label for="wcpoa_wc_order_refunded">
                                                        <input name="wcpoa_order_status[]" class="" value="wcpoa-wc-refunded"
                                                            type="checkbox"><?php 
            esc_html_e( 'Refunded', 'woocommerce-product-attachment' );
            ?>
                                                    </label>
                                                </li>

                                            </ul>

                                        </div>
                                    </div>
                                    <div class="wcpoa-field wcpoa-field-select">
                                        <div class="wcpoa-label">
                                            <label
                                                for="wcpoa_expired_date_enable"><?php 
            esc_html_e( 'Set Expire date/time', 'woocommerce-product-attachment' );
            ?></label>
                                        </div>
                                        <div class="wcpoa-input enable_expire_date">
                                            <select name="wcpoa_expired_date_enable[]" class="enable_date_time" data-type=""
                                                data-key="">
                                                <option name="no" value="no" class="" selected="">
                                                    <?php 
            esc_html_e( 'No', 'woocommerce-product-attachment' );
            ?></option>
                                                <option name="yes" value="yes">
                                                    <?php 
            esc_html_e( 'Specific Date', 'woocommerce-product-attachment' );
            ?></option>
                                                <?php 
            ?>
                                                <option name="" value="" class="wcpoa_pro_class" disabled>
                                                    <?php 
            esc_html_e( 'Selected time period after purchase ( Pro Version )', 'woocommerce-product-attachment' );
            ?>
                                                </option>
                                                <?php 
            ?>
                                            </select>
                                            <span class="wcpoa-description-tooltip-icon"></span>
                                            <p class="wcpoa-description">
                                                <?php 
            esc_html_e( 'Set a specific date and specific time to access the attachment.', 'woocommerce-product-attachment' );
            ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="wcpoa-field enable_date" data-key="" data-required="1" style='display: none'>
                                        <div class="wcpoa-label">
                                            <label
                                                for="wcpoa_expired_date"><?php 
            esc_html_e( 'Specific Date', 'woocommerce-product-attachment' );
            ?></label>
                                        </div>
                                        <div class="wcpoa-input">
                                            <div class="wcpoa-input-wrap" data-date_format="yy/mm/dd">
                                                <!--<input id="" class="input-alt" name="wcpoa_expired_date[]" value=""
                                                                    type="hidden">-->
                                                <input class="wcpoa-php-date-picker" value="" name="wcpoa_expired_date[]"
                                                    type="text" autocomplete="off">
                                                <span class="wcpoa-description-tooltip-icon"></span>
                                                <p class="wcpoa-description">
                                                    <?php 
            esc_html_e( 'If an order is placed after the selected date, the attachments will be no longer visible for download. ( Date format: yy/mm/dd )', 'woocommerce-product-attachment' );
            ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
            ?>
                                </td>
                            </tr>
                            <?php 
        }
        ?>
                        </tbody>
                    </table>
                    <?php 
        
        if ( $show_add ) {
            ?>
                    <ul class="wcpoa-actions wcpoa-hl">
                        <li>
                            <a class="wcpoa-button button button-primary"
                                data-event="add-row"><?php 
            esc_html_e( 'Add New Attachment', 'woocommerce-product-attachment' );
            ?></a>
                        </li>
                    </ul>
                    <?php 
        }
        
        ?>
                    <div class="product_attachment_help">
                        <span class="dashicons dashicons-info-outline"></span>
                        <a href="<?php 
        echo  esc_url( 'https://docs.thedotstore.com/article/378-bulk-attachment-for-woocommerce' ) ;
        ?>"
                            target="_blank"><?php 
        esc_html_e( 'View Documentation', 'woocommerce-product-attachment' );
        ?></a>
                    </div>
                </div>
            </div>
        </div>
        <!--File validation-->
        <!--End file validation-->
        <?php 
    }
    
    public function wcpoa_esc_attr_e( $atts )
    {
        echo  wp_kses( $this->wcpoa_esc_attr( $atts ), $this->allowed_html_tags() ) ;
    }
    
    /**
     * Save Meta for post types.
     *
     * @param $product_id
     */
    public function wcpoa_attachment_meta_data( $product_id )
    {
        
        if ( is_admin() ) {
            if ( !function_exists( 'get_current_screen' ) ) {
                //add this line
                return;
            }
            // add this line
            $screen = get_current_screen();
            if ( empty($product_id) || 'product' !== $screen->id ) {
                return;
            }
            // If this is an autosave, our form has not been submitted, so we don't want to do anything.
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                return;
            }
            $post_type = filter_input( INPUT_POST, 'post_type', FILTER_SANITIZE_SPECIAL_CHARS );
            // Check post type is product
            
            if ( isset( $post_type ) && 'product' === $post_type ) {
                $wcpoa_attachments_id = filter_input(
                    INPUT_POST,
                    'wcpoa_attachments_id',
                    FILTER_SANITIZE_SPECIAL_CHARS,
                    FILTER_REQUIRE_ARRAY
                );
                $wcpoa_attachments_id = ( !empty($wcpoa_attachments_id) && isset( $wcpoa_attachments_id ) ? $wcpoa_attachments_id : '' );
                update_post_meta( $product_id, 'wcpoa_attachments_id', $wcpoa_attachments_id );
                $wcpoa_attachment_name = filter_input(
                    INPUT_POST,
                    'wcpoa_attachment_name',
                    FILTER_SANITIZE_SPECIAL_CHARS,
                    FILTER_REQUIRE_ARRAY
                );
                $wcpoa_attachment_name = ( !empty($wcpoa_attachment_name) && isset( $wcpoa_attachment_name ) ? $wcpoa_attachment_name : '' );
                update_post_meta( $product_id, 'wcpoa_attachment_name', $wcpoa_attachment_name );
                $wcpoa_attach_type = filter_input(
                    INPUT_POST,
                    'wcpoa_attach_type',
                    FILTER_SANITIZE_SPECIAL_CHARS,
                    FILTER_REQUIRE_ARRAY
                );
                $wcpoa_attach_type = ( !empty($wcpoa_attach_type) && isset( $wcpoa_attach_type ) ? $wcpoa_attach_type : '' );
                update_post_meta( $product_id, 'wcpoa_attach_type', $wcpoa_attach_type );
                $wcpoa_attachment_file = filter_input(
                    INPUT_POST,
                    'wcpoa_attachment_file',
                    FILTER_SANITIZE_STRING,
                    FILTER_REQUIRE_ARRAY
                );
                $wcpoa_attachment_file = ( !empty($wcpoa_attachment_file) && isset( $wcpoa_attachment_file ) ? $wcpoa_attachment_file : '' );
                update_post_meta( $product_id, 'wcpoa_attachment_url', $wcpoa_attachment_file );
                $wcpoa_attachment_url = filter_input(
                    INPUT_POST,
                    'wcpoa_attachment_url',
                    FILTER_VALIDATE_URL,
                    FILTER_REQUIRE_ARRAY
                );
                $wcpoa_attachment_url = ( !empty($wcpoa_attachment_url) && isset( $wcpoa_attachment_url ) ? $wcpoa_attachment_url : '' );
                update_post_meta( $product_id, 'wcpoa_attachment_ext_url', $wcpoa_attachment_url );
                $wcpoa_attachment_description = filter_input(
                    INPUT_POST,
                    'wcpoa_attachment_description',
                    FILTER_SANITIZE_SPECIAL_CHARS,
                    FILTER_REQUIRE_ARRAY
                );
                $wcpoa_attachment_description = ( !empty($wcpoa_attachment_description) && isset( $wcpoa_attachment_description ) ? $wcpoa_attachment_description : '' );
                update_post_meta( $product_id, 'wcpoa_attachment_description', $wcpoa_attachment_description );
                $wcpoa_order_status = filter_input(
                    INPUT_POST,
                    'wcpoa_order_status',
                    FILTER_SANITIZE_SPECIAL_CHARS,
                    FILTER_REQUIRE_ARRAY
                );
                $wcpoa_order_status_all = ( !empty($wcpoa_order_status) ? $wcpoa_order_status : 'wc-all' );
                update_post_meta( $product_id, 'wcpoa_order_status', $wcpoa_order_status_all );
                $wcpoa_product_open_window_flag = filter_input(
                    INPUT_POST,
                    'wcpoa_product_open_window_flag',
                    FILTER_SANITIZE_SPECIAL_CHARS,
                    FILTER_REQUIRE_ARRAY
                );
                $wcpoa_product_open_window_flag = ( !empty($wcpoa_product_open_window_flag) && isset( $wcpoa_product_open_window_flag ) ? $wcpoa_product_open_window_flag : '' );
                update_post_meta( $product_id, 'wcpoa_product_open_window_flag', $wcpoa_product_open_window_flag );
                $wcpoa_product_page_enable = filter_input(
                    INPUT_POST,
                    'wcpoa_product_page_enable',
                    FILTER_SANITIZE_SPECIAL_CHARS,
                    FILTER_REQUIRE_ARRAY
                );
                $wcpoa_product_page_enable = ( !empty($wcpoa_product_page_enable) && isset( $wcpoa_product_page_enable ) ? $wcpoa_product_page_enable : '' );
                update_post_meta( $product_id, 'wcpoa_product_page_enable', $wcpoa_product_page_enable );
                $wcpoa_product_logged_in_flag = filter_input(
                    INPUT_POST,
                    'wcpoa_product_logged_in_flag',
                    FILTER_SANITIZE_SPECIAL_CHARS,
                    FILTER_REQUIRE_ARRAY
                );
                $wcpoa_product_logged_in_flag = ( !empty($wcpoa_product_logged_in_flag) && isset( $wcpoa_product_logged_in_flag ) ? $wcpoa_product_logged_in_flag : '' );
                update_post_meta( $product_id, 'wcpoa_product_logged_in_flag', $wcpoa_product_logged_in_flag );
                $wcpoa_product_att_icon_check = filter_input(
                    INPUT_POST,
                    'wcpoa_product_att_icon_check',
                    FILTER_SANITIZE_SPECIAL_CHARS,
                    FILTER_REQUIRE_ARRAY
                );
                $wcpoa_expired_date_enable = filter_input(
                    INPUT_POST,
                    'wcpoa_expired_date_enable',
                    FILTER_SANITIZE_SPECIAL_CHARS,
                    FILTER_REQUIRE_ARRAY
                );
                $wcpoa_expired_date_enable = ( !empty($wcpoa_expired_date_enable) && isset( $wcpoa_expired_date_enable ) ? $wcpoa_expired_date_enable : '' );
                update_post_meta( $product_id, 'wcpoa_expired_date_enable', $wcpoa_expired_date_enable );
                $wcpoa_expired_date = filter_input(
                    INPUT_POST,
                    'wcpoa_expired_date',
                    FILTER_SANITIZE_SPECIAL_CHARS,
                    FILTER_REQUIRE_ARRAY
                );
                $wcpoa_expired_date = ( !empty($wcpoa_expired_date) && isset( $wcpoa_expired_date ) ? $wcpoa_expired_date : '' );
                update_post_meta( $product_id, 'wcpoa_expired_date', $wcpoa_expired_date );
            }
        
        }
    
    }
    
    public function wcpoa_attachment_edit_form()
    {
        echo  'enctype="multipart/form-data" novalidate' ;
    }
    
    /**
     * Order wcpoa order meta fields.
     *
     */
    public function wcpoa_order_add_meta_boxes()
    {
        $order_meta_title = get_option( 'wcpoa_admin_order_tab_name' );
        add_meta_box(
            'wcpoa_order_meta_fields',
            __( $order_meta_title, 'woocommerce-product-attachment' ),
            array( $this, 'wcpoa_order_fields_data' ),
            'shop_order',
            'normal',
            'low'
        );
    }
    
    /**
     * Order wcpoa order attachment meta fields.
     * 
     */
    public function wcpoa_order_add_attachment_meta_boxes()
    {
        $order_meta_title = 'Add Attachments';
        add_meta_box(
            'wcpoa_order_attachment_meta_fields',
            __( $order_meta_title, 'woocommerce-product-attachment' ),
            array( $this, 'wcpoa_order_attachment_data' ),
            'shop_order',
            'side',
            'low'
        );
    }
    
    /**
     * User checkout page attachment listing widget
     * 
     */
    public function wcpoa_checkout_attachment_meta_boxes()
    {
        $order_meta_title = 'User Attachments';
        add_meta_box(
            'wcpoa_checkout_attachment_meta_fields',
            __( $order_meta_title, 'woocommerce-product-attachment' ),
            array( $this, 'wcpoa_checkout_attachment_data' ),
            'shop_order',
            'side',
            'low'
        );
    }
    
    /**
     * Admin side: checkout attachment listing.
     * 
     */
    public function wcpoa_checkout_attachment_data()
    {
        global  $post ;
        $wcpoa_all_ids = get_post_meta( $post->ID, '_wcpoa_checkout_attachment_ids', true );
        $wcpoa_meta_box = '';
        $wcpoa_meta_box .= '<div id="wcpoa_checkout_attach">';
        
        if ( isset( $wcpoa_all_ids ) && !empty($wcpoa_all_ids) ) {
            $id_array = explode( ",", $wcpoa_all_ids );
            foreach ( $id_array as $id ) {
                $media_name = get_the_title( $id );
                $media_upload_date = get_the_date( '', $id );
                $wcpoa_meta_box .= '<div>';
                $wcpoa_meta_box .= '<a href="' . wp_get_attachment_url( $id ) . '" target="_blank" class="wcpoa_image_text_wrap">';
                $wcpoa_meta_box .= wp_get_attachment_image( $id, 'thumbnail' );
                $wcpoa_meta_box .= '<h4>' . esc_html( $media_name ) . '</h4>';
                $wcpoa_meta_box .= '</a>';
                $wcpoa_meta_box .= '<p>' . esc_html( $media_upload_date ) . '</p><hr>';
                $wcpoa_meta_box .= '</div>';
            }
        }
        
        $wcpoa_meta_box .= '</div>';
        echo  wp_kses( $wcpoa_meta_box, $this->allowed_html_tags() ) ;
    }
    
    /**
     * Admin side: Add attachment on product status.
     * 
     */
    public function wcpoa_order_attachment_data()
    {
        global  $post ;
        $wcpoa_all_ids = get_post_meta( $post->ID, '_wcpoa_order_attachments', true );
        $wcpoa_meta_box = '';
        $wcpoa_meta_box .= '<input type="hidden" name="wcpoa_media_ids" data-id="' . esc_attr( $post->ID ) . '"  id="wcpoa_media_ids" value=' . esc_attr( $wcpoa_all_ids ) . '>';
        $wcpoa_meta_box .= '<div class="wcpoa-order-attach"><p>';
        $wcpoa_meta_box .= '<a href="#" id="wcpoa-order-upload-file" class="button button-primary">Add Attachment</a>';
        $wcpoa_meta_box .= '</p></div>';
        $wcpoa_meta_box .= '<div id="wcpoa_updated_attach">';
        
        if ( isset( $wcpoa_all_ids ) && !empty($wcpoa_all_ids) ) {
            $id_array = explode( ",", $wcpoa_all_ids );
            foreach ( $id_array as $id ) {
                $media_name = get_the_title( $id );
                $media_upload_date = get_the_date( '', $id );
                $wcpoa_meta_box .= '<div>';
                $wcpoa_meta_box .= '<a href="' . wp_get_attachment_url( $id ) . '" target="_blank" class="wcpoa_image_text_wrap">';
                $wcpoa_meta_box .= wp_get_attachment_image( $id, 'thumbnail' );
                $wcpoa_meta_box .= '<h4>' . esc_html( $media_name ) . '</h4>';
                $wcpoa_meta_box .= '</a>';
                $wcpoa_meta_box .= '<p>' . esc_html( $media_upload_date ) . ' - <a data-id="' . esc_attr( $id ) . '" class="wcpoa_remove_attach" href="#">Remove</a></p><hr>';
                $wcpoa_meta_box .= '</div>';
            }
        }
        
        $wcpoa_meta_box .= '</div>';
        echo  wp_kses( $wcpoa_meta_box, $this->allowed_html_tags() ) ;
    }
    
    /**
     * Admin order attachment save.
     * 
     */
    public function wcpoa_order_update_attachment()
    {
        $wcpoa_media_ids = filter_input( INPUT_POST, 'wcpoa_media_ids', FILTER_SANITIZE_SPECIAL_CHARS );
        $order_id = filter_input( INPUT_POST, 'order_id', FILTER_SANITIZE_SPECIAL_CHARS );
        $wcpoa_media_ids = ( !empty($wcpoa_media_ids) && isset( $wcpoa_media_ids ) ? $wcpoa_media_ids : '' );
        
        if ( !empty($order_id) ) {
            update_post_meta( $order_id, '_wcpoa_order_attachments', $wcpoa_media_ids );
            return true;
        }
    
    }
    
    /**
     * Admin side:Product attachments order data.
     *
     */
    public function wcpoa_order_fields_data()
    {
        global  $post ;
        $wcpoa_order = wc_get_order( $post->ID );
        $order_statuses = wc_get_order_statuses();
        $items = $wcpoa_order->get_items( array( 'line_item' ) );
        $wcpoa_att_values_key = array();
        $current_date = gmdate( "Y/m/d" );
        $wcpoa_today_date = strtotime( $current_date );
        $wcpoa_att_values_product_key = array();
        $wcpoa_all_att_values_product_key = array();
        $get_permalink_structure = get_permalink();
        
        if ( strpos( $get_permalink_structure, "?" ) ) {
            $wcpoa_attachment_url_arg = '&';
        } else {
            $wcpoa_attachment_url_arg = '?';
        }
        
        if ( !empty($items) && is_array( $items ) ) {
            foreach ( $items as $item_id => $item ) {
                // echo '<pre>';
                // print_r($items);
                // exit();
                //single product page attachment
                $wcpoa_order_attachment_items = wc_get_order_item_meta( $item_id, 'wcpoa_order_attachment_order_arr', true );
                
                if ( !empty($wcpoa_order_attachment_items) ) {
                    $wcpoa_attachment_ids = $wcpoa_order_attachment_items['wcpoa_attachment_ids'];
                    $wcpoa_attachment_name = $wcpoa_order_attachment_items['wcpoa_attachment_name'];
                    $wcpoa_attachment_url = $wcpoa_order_attachment_items['wcpoa_attachment_url'];
                    $wcpoa_order_status = $wcpoa_order_attachment_items['wcpoa_order_status'];
                    $wcpoa_order_attachment_expired = $wcpoa_order_attachment_items['wcpoa_order_attachment_expired'];
                    $wcpoa_order_product_variation = "";
                    $selected_variation_id = '';
                    
                    if ( !empty($selected_variation_id) && is_array( $attached_variations ) && in_array( (int) $selected_variation_id, convert_array_to_int( $attached_variations ), true ) ) {
                    } else {
                        foreach ( (array) $wcpoa_attachment_ids as $key => $wcpoa_attachments_id ) {
                            if ( !empty($wcpoa_attachments_id) || $wcpoa_attachments_id !== '' ) {
                                if ( !in_array( $wcpoa_attachments_id, $wcpoa_att_values_key, true ) ) {
                                    
                                    if ( !empty($wcpoa_attachment_ids) ) {
                                        $wcpoa_att_values_key[] = $wcpoa_attachments_id;
                                        $attachment_name = ( isset( $wcpoa_attachment_name[$key] ) && !empty($wcpoa_attachment_name[$key]) ? $wcpoa_attachment_name[$key] : '' );
                                        $wcpoa_attachment_file = ( isset( $wcpoa_attachment_url[$key] ) && !empty($wcpoa_attachment_url[$key]) ? $wcpoa_attachment_url[$key] : '' );
                                        $wcpoa_order_status_val = ( isset( $wcpoa_order_status[$wcpoa_attachments_id] ) && !empty($wcpoa_order_status[$wcpoa_attachments_id]) && $wcpoa_order_status[$wcpoa_attachments_id] ? $wcpoa_order_status[$wcpoa_attachments_id] : array() );
                                        $wcpoa_order_status_new = str_replace( 'wcpoa-', '', $wcpoa_order_status_val );
                                        $wcpoa_expired_dates = ( isset( $wcpoa_order_attachment_expired[$key] ) && !empty($wcpoa_order_attachment_expired[$key]) ? $wcpoa_order_attachment_expired[$key] : '' );
                                        $attachment_id = $wcpoa_attachment_file;
                                        // ID of attachment
                                        echo  '<table class="wcpoa_order">' ;
                                        echo  '<tbody>' ;
                                        $wcpoa_attachment_expired_date = strtotime( $wcpoa_expired_dates );
                                        $attachment_order_name = '<h3 class="wcpoa_attachment_name">' . $attachment_name . '</h3>';
                                        $wcpoa_file_url_btn = '<a class="wcpoa_attachmentbtn" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $attachment_id . '&download_file=' . $wcpoa_attachments_id . '" rel="nofollow">Download</a>';
                                        $wcpoa_file_url_btn = '<a class="wcpoa_attachmentbtn" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $attachment_id . '&download_file=' . $wcpoa_attachments_id . '" rel="nofollow">Download</a>';
                                        $wcpoa_file_expired_url_btn = '<a class="wcpoa_order_attachment_expire" rel="nofollow">Download</a>';
                                        $wcpoa_expire_date_text = '<p class="order_att_expire_date">' . __( 'This Attachment Expire Date Is :: ', 'woocommerce-product-attachment' ) . $wcpoa_expired_dates . '</p>';
                                        $wcpoa_expired_date_text = '<p class="order_att_expire_date">' . __( 'This Attachment Expired', 'woocommerce-product-attachment' ) . '</p>';
                                        $wcpoa_never_expired_date_text = '<p class="order_att_expire_date">' . __( 'This Attachment Is Never Expire', 'woocommerce-product-attachment' ) . '</p>';
                                        
                                        if ( !empty($wcpoa_attachment_expired_date) ) {
                                            
                                            if ( $wcpoa_today_date > $wcpoa_attachment_expired_date ) {
                                                echo  wp_kses( $attachment_order_name, $this->allowed_html_tags() ) ;
                                                echo  wp_kses( $wcpoa_file_expired_url_btn, $this->allowed_html_tags() ) ;
                                                echo  wp_kses( $wcpoa_expired_date_text, $this->allowed_html_tags() ) ;
                                            } else {
                                                echo  wp_kses( $attachment_order_name, $this->allowed_html_tags() ) ;
                                                echo  wp_kses( $wcpoa_file_url_btn, $this->allowed_html_tags() ) ;
                                                echo  wp_kses( $wcpoa_expire_date_text, $this->allowed_html_tags() ) ;
                                            }
                                        
                                        } else {
                                            echo  wp_kses( $attachment_order_name, $this->allowed_html_tags() ) ;
                                            echo  wp_kses( $wcpoa_file_url_btn, $this->allowed_html_tags() ) ;
                                            echo  wp_kses( $wcpoa_never_expired_date_text, $this->allowed_html_tags() ) ;
                                        }
                                        
                                        echo  '<div class="wcpoa-order-status">' ;
                                        foreach ( $order_statuses as $wcpoa_order_status_key => $wcpoa_order_status_value ) {
                                            
                                            if ( in_array( $wcpoa_order_status_key, $wcpoa_order_status_new, true ) ) {
                                                $order_status_available = '<h4><span class="dashicons dashicons-yes"></span>' . $wcpoa_order_status_value . '</h4>';
                                                echo  wp_kses( $order_status_available, $this->allowed_html_tags() ) ;
                                            } elseif ( empty($wcpoa_order_status_new) ) {
                                                $order_status_available = '<h4><span class="dashicons dashicons-yes"></span>' . $wcpoa_order_status_value . '</h4>';
                                                echo  wp_kses( $order_status_available, $this->allowed_html_tags() ) ;
                                            } else {
                                                $order_status_available = '<h4><span class="dashicons dashicons-no"></span>' . $wcpoa_order_status_value . '</h4>';
                                                echo  wp_kses( $order_status_available, $this->allowed_html_tags() ) ;
                                            }
                                        
                                        }
                                        echo  '</div>' ;
                                        echo  '</tbody>' ;
                                        echo  '</table>' ;
                                    }
                                
                                }
                            }
                        }
                    }
                
                }
            
            }
        }
        //Bulk Attachment
        $wcpoa_bulk_att_data = get_option( 'wcpoa_bulk_attachment_data' );
        
        if ( !empty($items) && is_array( $items ) ) {
            $wcpoa_bulk_att_match = 'no';
            foreach ( $items as $key => $item_value ) {
                // for all product
                if ( !empty($wcpoa_bulk_att_data) && is_array( $wcpoa_bulk_att_data ) ) {
                    foreach ( $wcpoa_bulk_att_data as $att_new_key => $wcpoa_bulk_att_values ) {
                        if ( !array_key_exists( 'wcpoa_attach_view', $wcpoa_bulk_att_values ) || "enable" === $wcpoa_bulk_att_values['wcpoa_attach_view'] ) {
                            if ( 'no' === $wcpoa_bulk_att_values['wcpoa_is_condition'] ) {
                                
                                if ( !in_array( $att_new_key, $wcpoa_all_att_values_product_key, true ) ) {
                                    $wcpoa_all_att_values_product_key[] = $att_new_key;
                                    $wcpoa_attachments_bulk_id = ( !empty($wcpoa_bulk_att_values['wcpoa_attachments_id']) ? $wcpoa_bulk_att_values['wcpoa_attachments_id'] : '' );
                                    $wcpoa_bulk_attachments_name = ( isset( $wcpoa_bulk_att_values['wcpoa_attachment_name'] ) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_name']) ? $wcpoa_bulk_att_values['wcpoa_attachment_name'] : '' );
                                    $wcpoa_bulk_attachment_file = ( isset( $wcpoa_bulk_att_values['wcpoa_attachment_file'] ) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_file']) ? $wcpoa_bulk_att_values['wcpoa_attachment_file'] : '' );
                                    $wcpoa_expired_dates = ( isset( $wcpoa_bulk_att_values['wcpoa_expired_date'] ) && !empty($wcpoa_bulk_att_values['wcpoa_expired_date']) ? $wcpoa_bulk_att_values['wcpoa_expired_date'] : '' );
                                    $wcpoa_order_bulk_status = ( isset( $wcpoa_bulk_att_values['wcpoa_order_status'] ) && !empty($wcpoa_bulk_att_values['wcpoa_order_status']) ? $wcpoa_bulk_att_values['wcpoa_order_status'] : '' );
                                    $wcpoa_attachments_name = '<h3 class="wcpoa_attachment_name">' . esc_html__( $wcpoa_bulk_attachments_name, 'woocommerce-product-attachment' ) . '</h3>';
                                    $wcpoa_bulk_file_url_btn = '<a class="wcpoa_attachmentbtn" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $wcpoa_bulk_attachment_file . '&download_file=' . $wcpoa_attachments_bulk_id . '">Download</a>';
                                    $wcpoa_bulk_file_expired_url_btn = '<a class="wcpoa_order_attachment_expire" rel="nofollow"> Download </a>';
                                    $wcpoa_bulk_expired_date_text = '<p class="order_att_expire_date">' . __( 'This Attachment Expired.', 'woocommerce-product-attachment' ) . '</p>';
                                    $wcpoa_bulk_never_expired_date_text = '<p class="order_att_expire_date">' . __( 'This Attachment Never Expires.', 'woocommerce-product-attachment' ) . '</p>';
                                    $wcpoa_bulk_expire_date_text = '<p class="order_att_expire_date">' . __( 'This Attachment Expiry Date :: ', 'woocommerce-product-attachment' ) . $wcpoa_expired_dates . '</p>';
                                    $wcpoa_order_status_bulknew = str_replace( 'wcpoa-wc-', '', $wcpoa_order_bulk_status );
                                    $wcpoa_order_status_bulknew_val = ( !empty($wcpoa_order_status_bulknew) ? $wcpoa_order_status_bulknew : array() );
                                    
                                    if ( !empty($wcpoa_expired_dates) ) {
                                        
                                        if ( $wcpoa_today_date > $wcpoa_expired_dates ) {
                                            echo  wp_kses( $wcpoa_attachments_name, $this->allowed_html_tags() ) ;
                                            echo  wp_kses( $wcpoa_bulk_file_expired_url_btn, $this->allowed_html_tags() ) ;
                                            echo  wp_kses( $wcpoa_bulk_expired_date_text, $this->allowed_html_tags() ) ;
                                            $wcpoa_bulk_att_match = 'yes';
                                        } else {
                                            echo  wp_kses( $wcpoa_attachments_name, $this->allowed_html_tags() ) ;
                                            echo  wp_kses( $wcpoa_bulk_file_url_btn, $this->allowed_html_tags() ) ;
                                            echo  wp_kses( $wcpoa_bulk_expire_date_text, $this->allowed_html_tags() ) ;
                                            $wcpoa_bulk_att_match = 'yes';
                                        }
                                    
                                    } else {
                                        echo  wp_kses( $wcpoa_attachments_name, $this->allowed_html_tags() ) ;
                                        echo  wp_kses( $wcpoa_bulk_file_url_btn, $this->allowed_html_tags() ) ;
                                        echo  wp_kses( $wcpoa_bulk_never_expired_date_text, $this->allowed_html_tags() ) ;
                                        $wcpoa_bulk_att_match = 'yes';
                                    }
                                    
                                    
                                    if ( isset( $order_statuses ) && is_array( $order_statuses ) ) {
                                        echo  '<div class="wcpoa-order-status">' ;
                                        foreach ( $order_statuses as $wcpoa_order_status_key => $wcpoa_order_status_bulkvalue ) {
                                            $wcpoa_order_status_key_new = str_replace( 'wc-', '', $wcpoa_order_status_key );
                                            
                                            if ( in_array( $wcpoa_order_status_key_new, $wcpoa_order_status_bulknew_val, true ) ) {
                                                $bulkorder_status_available = '<h4><span class="dashicons dashicons-yes"></span>' . $wcpoa_order_status_bulkvalue . '</h4>';
                                                echo  wp_kses( $bulkorder_status_available, $this->allowed_html_tags() ) ;
                                            } elseif ( empty($wcpoa_order_status_bulknew_val) ) {
                                                $bulkorder_status_available = '<h4><span class="dashicons dashicons-yes"></span>' . $wcpoa_order_status_bulkvalue . '</h4>';
                                                echo  wp_kses( $bulkorder_status_available, $this->allowed_html_tags() ) ;
                                            } else {
                                                $bulkorder_status_available = '<h4><span class="dashicons dashicons-no"></span>' . $wcpoa_order_status_bulkvalue . '</h4>';
                                                echo  wp_kses( $bulkorder_status_available, $this->allowed_html_tags() ) ;
                                            }
                                        
                                        }
                                        echo  '</div>' ;
                                    }
                                
                                }
                            
                            }
                        }
                    }
                }
            }
        }
    
    }
    
    /*
     * Bulk Attachment
     */
    public function wcpoa_bulk_attachment()
    {
        $submitwcpoabulkatt = filter_input( INPUT_POST, 'submitwcpoabulkatt', FILTER_SANITIZE_SPECIAL_CHARS );
        
        if ( isset( $submitwcpoabulkatt ) && !empty($submitwcpoabulkatt) ) {
            $this->wcpoa_bulk_attachment_data_save();
            ?>
            <div id="message" class="updated wcpoa-notice notice notice-success is-dismissible">
                <p><?php 
            esc_html_e( 'Attachment updated.', 'woocommerce-product-attachment' );
            ?></p>
                <button type="button" class="notice-dismiss">
                    <span class="screen-reader-text"><?php 
            esc_html_e( 'Dismiss this notice.', 'woocommerce-product-attachment' );
            ?></span>
                </button>
            </div> 
            <?php 
        }
        
        $screen = 'woocommerce_product_bulk_attachment_options';
        require_once plugin_dir_path( __FILE__ ) . "partials/header/plugin-header.php";
        ?>
    <div class="wrap wcpoa-bulk-attach-main">
        <form id="post" name="post" method="post" novalidate="novalidate" enctype="multipart/form-data">
            <input type="hidden" name="post_type" value="wcpoa_bulk_att">
            <?php 
        wp_nonce_field( 'some-action-nonce' );
        /* Used to save closed meta boxes and their order */
        wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false );
        wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false );
        ?>

            <div id="poststuff">

                <div class="wcpoa-table-main res-cl wcpoa-bulk-attach-left">
                    <?php 
        //do_meta_boxes($screen, 'normal', null);
        ?>
                    <h2><?php 
        esc_html_e( 'WooCommerce Product Bulk Attachments', 'woocommerce-product-attachment' );
        ?></h2>
                    <?php 
        require_once plugin_dir_path( __FILE__ ) . "partials/wcpoa-bulk-attachement-add.php";
        ?>
                </div>
            </div> <!-- #poststuff -->

        </form>
    </div><!-- .wrap -->
    <?php 
        require_once plugin_dir_path( __FILE__ ) . 'partials/header/plugin-sidebar.php';
        ?>
    <?php 
    }
    
    public function wcpoa_add_my_meta_box()
    {
        $screen = 'woocommerce_product_bulk_attachment_options';
        add_meta_box(
            'wcpoasubmitdiv',
            __( 'Publish', 'woocommerce-product-attachment' ),
            array( $this, 'wcpoa_bulk_submitdiv' ),
            $screen,
            'side',
            'high'
        );
        add_meta_box(
            'wcpoa_bulk_att',
            __( 'WooCommerce Product Bulk Attachments', 'woocommerce-product-attachment' ),
            array( $this, 'wcpoa_bulk_attachment_metabox' ),
            $screen,
            'normal',
            'high'
        );
    }
    
    public function wcpoa_bulk_attachment_metabox()
    {
        require_once plugin_dir_path( __FILE__ ) . "partials/wcpoa-bulk-attachement-add.php";
    }
    
    /* Prints script in footer. This 'initialises' the meta boxes */
    function wcpoa_print_script_in_footer()
    {
        ?>
<script>
jQuery(document).ready(function() {
    postboxes.add_postbox_toggles(pagenow);
});
</script>
<?php 
    }
    
    function wcpoa_bulk_submitdiv( $post, $args )
    {
        ?>
        <div id="major-publishing-actions">

            <div id="publishing-action">
                <span class="spinner"></span>
                <input type="submit" accesskey="p" value="Publish" class="button button-primary button-large" id="publish"
                    name="submitwcpoabulkatt">
            </div>

            <div class="clear"></div>

        </div>
<?php 
    }
    
    /**
     * Save option for bulk attachment data save.
     *
     *
     */
    public function wcpoa_bulk_attachment_data_save()
    {
        $wcpoa_attachments_id = filter_input(
            INPUT_POST,
            'wcpoa_attachments_id',
            FILTER_SANITIZE_SPECIAL_CHARS,
            FILTER_REQUIRE_ARRAY
        );
        unset( $wcpoa_attachments_id[count( $wcpoa_attachments_id ) - 1] );
        $wcpoa_attachments_id = ( !empty($wcpoa_attachments_id) ? $wcpoa_attachments_id : '' );
        $wcpoa_attachment_name = filter_input(
            INPUT_POST,
            'wcpoa_attachment_name',
            FILTER_SANITIZE_SPECIAL_CHARS,
            FILTER_REQUIRE_ARRAY
        );
        $wcpoa_attachment_name = ( !empty($wcpoa_attachment_name) ? $wcpoa_attachment_name : '' );
        $wcpoa_attach_view = filter_input(
            INPUT_POST,
            'wcpoa_attach_view',
            FILTER_SANITIZE_SPECIAL_CHARS,
            FILTER_REQUIRE_ARRAY
        );
        $wcpoa_attach_view = ( !empty($wcpoa_attach_view) ? $wcpoa_attach_view : '' );
        $wcpoa_attach_type = filter_input(
            INPUT_POST,
            'wcpoa_attach_type',
            FILTER_SANITIZE_SPECIAL_CHARS,
            FILTER_REQUIRE_ARRAY
        );
        $wcpoa_attach_type = ( !empty($wcpoa_attach_type) ? $wcpoa_attach_type : '' );
        $wcpoa_attachment_file = filter_input(
            INPUT_POST,
            'wcpoa_attachment_file',
            FILTER_SANITIZE_SPECIAL_CHARS,
            FILTER_REQUIRE_ARRAY
        );
        $wcpoa_attachment_file = ( !empty($wcpoa_attachment_file) ? $wcpoa_attachment_file : '' );
        $wcpoa_attachment_description = filter_input(
            INPUT_POST,
            'wcpoa_attachment_description',
            FILTER_SANITIZE_SPECIAL_CHARS,
            FILTER_REQUIRE_ARRAY
        );
        $wcpoa_attachment_description = ( !empty($wcpoa_attachment_description) ? $wcpoa_attachment_description : '' );
        $wcpoa_order_status = filter_input(
            INPUT_POST,
            'wcpoa_order_status',
            FILTER_SANITIZE_SPECIAL_CHARS,
            FILTER_REQUIRE_ARRAY
        );
        $wcpoa_order_status_all = ( !empty($wcpoa_order_status) ? $wcpoa_order_status : '' );
        $wcpoa_att_visibility = filter_input(
            INPUT_POST,
            'wcpoa_att_visibility',
            FILTER_SANITIZE_SPECIAL_CHARS,
            FILTER_REQUIRE_ARRAY
        );
        $wcpoa_att_visibility = ( !empty($wcpoa_att_visibility) ? $wcpoa_att_visibility : '' );
        $wcpoa_product_logged_in_flag = filter_input(
            INPUT_POST,
            'wcpoa_product_logged_in_flag',
            FILTER_SANITIZE_SPECIAL_CHARS,
            FILTER_REQUIRE_ARRAY
        );
        $wcpoa_product_logged_in_flag = ( !empty($wcpoa_product_logged_in_flag) ? $wcpoa_product_logged_in_flag : '' );
        $wcpoa_is_condition = filter_input(
            INPUT_POST,
            'wcpoa_is_condition',
            FILTER_SANITIZE_SPECIAL_CHARS,
            FILTER_REQUIRE_ARRAY
        );
        $wcpoa_is_condition = ( !empty($wcpoa_is_condition) ? $wcpoa_is_condition : '' );
        $wcpoa_expired_date_enable = filter_input(
            INPUT_POST,
            'wcpoa_expired_date_enable',
            FILTER_SANITIZE_SPECIAL_CHARS,
            FILTER_REQUIRE_ARRAY
        );
        $wcpoa_expired_date_enable = ( !empty($wcpoa_expired_date_enable) ? $wcpoa_expired_date_enable : '' );
        $wcpoa_product_open_window_flag = filter_input(
            INPUT_POST,
            'wcpoa_product_open_window_flag',
            FILTER_SANITIZE_SPECIAL_CHARS,
            FILTER_REQUIRE_ARRAY
        );
        $wcpoa_product_open_window_flag = ( !empty($wcpoa_product_open_window_flag) && isset( $wcpoa_product_open_window_flag ) ? $wcpoa_product_open_window_flag : '' );
        
        if ( $wcpoa_expired_date_enable ) {
            $wcpoa_attachment_time_amount = filter_input(
                INPUT_POST,
                'wcpoa_attachment_time_amount',
                FILTER_SANITIZE_SPECIAL_CHARS,
                FILTER_REQUIRE_ARRAY
            );
            $wcpoa_attachment_time_amount = ( !empty($wcpoa_attachment_time_amount) ? $wcpoa_attachment_time_amount : '' );
            $wcpoa_expired_date = filter_input(
                INPUT_POST,
                'wcpoa_expired_date',
                FILTER_SANITIZE_SPECIAL_CHARS,
                FILTER_REQUIRE_ARRAY
            );
            $wcpoa_expired_date = ( !empty($wcpoa_expired_date) ? $wcpoa_expired_date : '' );
        }
        
        $wcpoa_bulk_attachment_array = [];
        
        if ( !empty($wcpoa_attachments_id) && is_array( $wcpoa_attachments_id ) ) {
            $wcpoa_bulk_attachment_array = [];
            foreach ( $wcpoa_attachments_id as $wcpoa_bulk_key => $wcpoa_bulk_key_value ) {
                $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_attachments_id'] = $wcpoa_attachments_id[$wcpoa_bulk_key];
                $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_is_condition'] = $wcpoa_is_condition[$wcpoa_bulk_key];
                $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_attachment_name'] = $wcpoa_attachment_name[$wcpoa_bulk_key];
                $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_attach_view'] = $wcpoa_attach_view[$wcpoa_bulk_key];
                $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_attach_type'] = $wcpoa_attach_type[$wcpoa_bulk_key];
                $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_attachment_file'] = $wcpoa_attachment_file[$wcpoa_bulk_key];
                $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_attachment_description'] = $wcpoa_attachment_description[$wcpoa_bulk_key];
                
                if ( empty($wcpoa_order_status_all[$wcpoa_bulk_key_value]) ) {
                    $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_order_status'] = array();
                } else {
                    $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_order_status'] = $wcpoa_order_status_all[$wcpoa_bulk_key_value];
                }
                
                $wcpoa_attachment_time_amount = filter_input(
                    INPUT_POST,
                    'wcpoa_attachment_time_amount',
                    FILTER_SANITIZE_SPECIAL_CHARS,
                    FILTER_REQUIRE_ARRAY
                );
                $wcpoa_attachment_time_amount = ( !empty($wcpoa_attachment_time_amount) ? $wcpoa_attachment_time_amount : '' );
                $wcpoa_expired_date = filter_input(
                    INPUT_POST,
                    'wcpoa_expired_date',
                    FILTER_SANITIZE_SPECIAL_CHARS,
                    FILTER_REQUIRE_ARRAY
                );
                $wcpoa_expired_date = ( !empty($wcpoa_expired_date) ? $wcpoa_expired_date : '' );
                $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_att_visibility'] = $wcpoa_att_visibility[$wcpoa_bulk_key];
                $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_product_logged_in_flag'] = $wcpoa_product_logged_in_flag[$wcpoa_bulk_key];
                $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_product_open_window_flag'] = $wcpoa_product_open_window_flag[$wcpoa_bulk_key];
                $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_expired_date_enable'] = $wcpoa_expired_date_enable[$wcpoa_bulk_key];
                $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_expired_date'] = $wcpoa_expired_date[$wcpoa_bulk_key];
            }
        }
        
        update_option( 'wcpoa_bulk_attachment_data', $wcpoa_bulk_attachment_array );
    }
    
    private function _uploadImageToMediaLibrary( $postID, $url )
    {
        // require_once( ABSPATH . "wp-load.php" );
        require_once ABSPATH . "wp-admin/includes/image.php";
        require_once ABSPATH . "wp-admin/includes/file.php";
        require_once ABSPATH . "wp-admin/includes/media.php";
        // Set variables for storage
        // fix file filename for query strings
        preg_match( '/[^\\?]+\\.(jpg|jpe|jpeg|gif|png|webp|pdf|doc|odt|key|ppt|pptx|pps|ppsx|xls|mp3|m4a|ogg|wav|mp4|m4v|mov|wmv|avi|mpg|ogv|3gp|3g2|zip|gz)/i', $url, $matches );
        
        if ( !empty($matches[0]) && "" !== $matches[0] ) {
            $tmp = download_url( $url );
            $file_array = array();
            $file_array['name'] = basename( $matches[0] );
            $file_array['tmp_name'] = $tmp;
            // If error storing temporarily, unlink
            if ( is_wp_error( $tmp ) ) {
                $file_array['tmp_name'] = '';
            }
            // do the validation and storage stuff
            $id = media_handle_sideload( $file_array, $postID );
            // If error storing permanently, unlink
            if ( is_wp_error( $id ) ) {
                $id = "";
            }
        } else {
            $id = "";
        }
        
        return $id;
    }
    
    private function generateRandomString( $length = 14 )
    {
        $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $charactersLength = strlen( $characters );
        $randomString = '';
        for ( $i = 0 ;  $i < $length ;  $i++ ) {
            $randomString .= $characters[rand( 0, $charactersLength - 1 )];
        }
        return $randomString;
    }
    
    public function misha_image_uploader_field( $attachment_id = '' )
    {
        $image = ' button">Upload File';
        return '
        <div>
            <a href="#" data-id="' . esc_attr( $attachment_id ) . '" class="misha_upload_image_button' . $image . '</a>
           
        </div>';
    }
    
    /**
     * Get default site language
     *
     * @return string $default_lang
     *
     */
    public function wcpoa_get_default_langugae_with_sitpress()
    {
        global  $sitepress ;
        
        if ( !empty($sitepress) ) {
            $default_lang = $sitepress->get_current_language();
        } else {
            $default_lang = $this->wcpoa_get_current_site_language();
        }
        
        return $default_lang;
    }
    
    /**
     * Get current site langugae
     *
     * @return string $default_lang
     * @since 1.0.0
     *
     */
    public function wcpoa_get_current_site_language()
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
    
    public function allowed_html_tags( $tags = array() )
    {
        $allowed_tags = array(
            'a'        => array(
            'href'    => array(),
            'title'   => array(),
            'data-id' => array(),
            'class'   => array(),
            'id'      => array(),
            'target'  => array(),
        ),
            'p'        => array(
            'href'  => array(),
            'title' => array(),
            'class' => array(),
        ),
            'span'     => array(
            'href'  => array(),
            'title' => array(),
            'class' => array(),
        ),
            'ul'       => array(
            'class' => array(),
        ),
            'img'      => array(
            'href'  => array(),
            'title' => array(),
            'class' => array(),
            'src'   => array(),
        ),
            'li'       => array(
            'class' => array(),
        ),
            'h1'       => array(
            'id'    => array(),
            'name'  => array(),
            'class' => array(),
        ),
            'h2'       => array(
            'id'    => array(),
            'name'  => array(),
            'class' => array(),
        ),
            'h3'       => array(
            'id'    => array(),
            'name'  => array(),
            'class' => array(),
        ),
            'h4'       => array(
            'id'    => array(),
            'name'  => array(),
            'class' => array(),
        ),
            'div'      => array(
            'class'     => array(),
            'id'        => array(),
            "data-max"  => array(),
            "data-min"  => array(),
            "stlye"     => array(),
            "data-name" => array(),
            "data-type" => array(),
            "data-key"  => array(),
        ),
            'select'   => array(
            'id'       => array(),
            'name'     => array(),
            'class'    => array(),
            'multiple' => array(),
            'style'    => array(),
        ),
            'input'    => array(
            'id'      => array(),
            'value'   => array(),
            'name'    => array(),
            'class'   => array(),
            'type'    => array(),
            'data-id' => array(),
        ),
            'textarea' => array(
            'id'    => array(),
            'name'  => array(),
            'class' => array(),
        ),
            'td'       => array(
            'id'    => array(),
            'name'  => array(),
            'class' => array(),
        ),
            'tr'       => array(
            'id'    => array(),
            'name'  => array(),
            'class' => array(),
        ),
            'tbody'    => array(
            'id'    => array(),
            'name'  => array(),
            'class' => array(),
        ),
            'table'    => array(
            'id'    => array(),
            'name'  => array(),
            'class' => array(),
        ),
            'option'   => array(
            'id'       => array(),
            'selected' => array(),
            'name'     => array(),
            'value'    => array(),
        ),
            'br'       => array(),
            'em'       => array(),
            'strong'   => array(),
            'label'    => array(
            'for' => array(),
        ),
        );
        if ( !empty($tags) ) {
            foreach ( $tags as $key => $value ) {
                $allowed_tags[$key] = $value;
            }
        }
        return $allowed_tags;
    }

}