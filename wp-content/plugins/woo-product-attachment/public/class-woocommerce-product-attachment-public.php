<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.multidots.com/
 * @since      1.0.0
 *
 * @package    Woocommerce_Product_Attachment
 * @subpackage Woocommerce_Product_Attachment/public
 */
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woocommerce_Product_Attachment
 * @subpackage Woocommerce_Product_Attachment/public
 * @author     multidots <nirav.soni@multidots.com>
 */
class Woocommerce_Product_Attachment_Public
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
    private static  $admin_object = null ;
    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of the plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct( $plugin_name, $version )
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        self::$admin_object = new Woocommerce_Product_Attachment_Admin( '', '' );
    }
    
    /**
     * Register the stylesheets for the public-facing side of the site.
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
        wp_enqueue_style(
            $this->plugin_name,
            plugin_dir_url( __FILE__ ) . 'css/woocommerce-product-attachment-public.css',
            array(),
            $this->version,
            'all'
        );
    }
    
    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script(
            $this->plugin_name,
            plugin_dir_url( __FILE__ ) . 'js/woocommerce-product-attachment-public.js',
            array( 'jquery' ),
            $this->version,
            false
        );
    }
    
    // Start the download if there is a request for that
    function wcpoa_download_file()
    {
        if ( is_admin() ) {
            return;
        }
        $attachment_id = filter_input( INPUT_GET, 'attachment_id', FILTER_SANITIZE_SPECIAL_CHARS );
        $download_file = filter_input( INPUT_GET, 'download_file', FILTER_SANITIZE_SPECIAL_CHARS );
        $wcpoa_attachment_order_id = filter_input( INPUT_GET, 'wcpoa_attachment_order_id', FILTER_SANITIZE_SPECIAL_CHARS );
        
        if ( !empty($attachment_id) && !empty($download_file) && !empty($wcpoa_attachment_order_id) ) {
            $wcpoa_attachment_order_id = $wcpoa_attachment_order_id;
            $order = new WC_Order( $wcpoa_attachment_order_id );
            $items = $order->get_items( array( 'line_item' ) );
            //Bulk Attachement
            if ( isset( $items ) && is_array( $items ) ) {
                foreach ( array_keys( $items ) as $items_key ) {
                    $wcpoa_order_attachment_items = wc_get_order_item_meta( $items_key, 'wcpoa_order_attachment_order_arr', true );
                    $current_date = gmdate( "Y/m/d" );
                    $wcpoa_today_date = strtotime( $current_date );
                    $download_flag = 0;
                    $premium_flag = 0;
                    
                    if ( !empty($wcpoa_order_attachment_items) ) {
                        $wcpoa_attachment_ids = $wcpoa_order_attachment_items['wcpoa_attachment_ids'];
                        $wcpoa_order_attachment_expired = $wcpoa_order_attachment_items['wcpoa_order_attachment_expired'];
                        $wcpoa_order_attachment_expired_new = array();
                        $wcpoa_order_attachment_expired_new = array_combine( $wcpoa_attachment_ids, $wcpoa_order_attachment_expired );
                        $download_file = filter_input( INPUT_GET, 'download_file', FILTER_SANITIZE_SPECIAL_CHARS );
                        if ( !empty($wcpoa_order_attachment_expired_new) ) {
                            foreach ( $wcpoa_order_attachment_expired_new as $attach_key => $attach_value ) {
                                if ( $attach_key === $download_file && (strtotime( $attach_value ) >= $wcpoa_today_date || empty($attach_value)) ) {
                                    $download_flag = 1;
                                }
                            }
                        }
                    }
                    
                    $premium_flag = 1;
                    
                    if ( $premium_flag === 1 ) {
                        $wcpoa_bulk_att_data = get_option( 'wcpoa_bulk_attachment_data' );
                        if ( !empty($wcpoa_bulk_att_data) ) {
                            foreach ( $wcpoa_bulk_att_data as $wcpoa_bulk_value ) {
                                $wcpoa_attachment_ids = ( !empty($wcpoa_bulk_value['wcpoa_attachments_id']) ? $wcpoa_bulk_value['wcpoa_attachments_id'] : array() );
                                $wcpoa_bulk_order_attachment_expired_new = $wcpoa_bulk_value['wcpoa_expired_date'];
                                if ( $wcpoa_attachment_ids === $download_file && (strtotime( $wcpoa_bulk_order_attachment_expired_new ) >= $wcpoa_today_date || empty($wcpoa_bulk_order_attachment_expired_new)) ) {
                                    $download_flag = 1;
                                }
                            }
                        }
                    }
                    
                    if ( $download_flag === 1 ) {
                        $this->wcpoa_send_file();
                    }
                }
            }
            wp_die( sprintf( __( '<strong>This Attachement is Expired.</strong> You are no longer to download this attachement.', 'woocommerce-product-attachment' ) ) );
        } else {
            $this->wcpoa_send_file();
        }
    
    }
    
    public function wcpoa_send_file()
    {
        $attachment_id = filter_input( INPUT_GET, 'attachment_id', FILTER_SANITIZE_SPECIAL_CHARS );
        
        if ( isset( $attachment_id ) ) {
            $attID = $attachment_id;
            $theFile = wp_get_attachment_url( $attID );
            if ( !$theFile ) {
                return;
            }
            $upload_dir = wp_upload_dir();
            //clean the fileurl
            $file_url = stripslashes( trim( $theFile ) );
            //get filename
            $files_arr = explode( "/uploads", $file_url );
            set_time_limit( 0 );
            // disable the time limit for this script
            $path = $upload_dir['basedir'] . $files_arr[1];
            // change the path to fit your websites document structure
            
            if ( is_multisite() ) {
                $site = get_current_blog_id();
                if ( !empty($site) ) {
                    
                    if ( !is_main_site( $site ) ) {
                        $files_arr = explode( "sites/" . $site, $file_url );
                        $path = $upload_dir['basedir'] . $files_arr[1];
                        // change the path to fit your websites document structure
                    }
                
                }
            }
            
            $fullPath = $path;
            $pdf_download_mode = '';
            
            if ( get_option( 'wcpoa_is_viewable' ) ) {
                $wcpoa_is_viewable = get_option( 'wcpoa_is_viewable' );
                
                if ( 'yes' === $wcpoa_is_viewable ) {
                    $pdf_download_mode = "inline";
                } else {
                    $pdf_download_mode = "attachment";
                }
            
            } else {
                $pdf_download_mode = "attachment";
            }
            
            global  $wp_filesystem ;
            require_once ABSPATH . '/wp-admin/includes/file.php';
            WP_Filesystem();
            
            if ( $wp_filesystem->exists( $fullPath ) ) {
                $fsize = filesize( $fullPath );
                $path_parts = pathinfo( $fullPath );
                $ext = strtolower( $path_parts["extension"] );
                switch ( $ext ) {
                    ///Image Mime Types
                    case 'jpg':
                        $mimetype = "image/jpg";
                        break;
                    case 'jpeg':
                        $mimetype = "image/jpeg";
                        break;
                    case 'gif':
                        $mimetype = "image/gif";
                        break;
                    case 'png':
                        $mimetype = "image/png";
                        break;
                    case 'bm':
                        $mimetype = "image/bmp";
                        break;
                    case 'bmp':
                        $mimetype = "image/bmp";
                        break;
                    case 'art':
                        $mimetype = "image/x-jg";
                        break;
                    case 'dwg':
                        $mimetype = "image/x-dwg";
                        break;
                    case 'dxf':
                        $mimetype = "image/x-dwg";
                        break;
                    case 'flo':
                        $mimetype = "image/florian";
                        break;
                    case 'fpx':
                        $mimetype = "image/vnd.fpx";
                        break;
                    case 'g3':
                        $mimetype = "image/g3fax";
                        break;
                    case 'ief':
                        $mimetype = "image/ief";
                        break;
                    case 'jfif':
                        $mimetype = "image/pjpeg";
                        break;
                    case 'jfif-tbnl':
                        $mimetype = "image/jpeg";
                        break;
                    case 'jpe':
                        $mimetype = "image/pjpeg";
                        break;
                    case 'jps':
                        $mimetype = "image/x-jps";
                        break;
                    case 'jut':
                        $mimetype = "image/jutvision";
                        break;
                    case 'mcf':
                        $mimetype = "image/vasa";
                        break;
                    case 'nap':
                        $mimetype = "image/naplps";
                        break;
                    case 'naplps':
                        $mimetype = "image/naplps";
                        break;
                    case 'nif':
                        $mimetype = "image/x-niff";
                        break;
                    case 'niff':
                        $mimetype = "image/x-niff";
                        break;
                    case 'cod':
                        $mimetype = "image/cis-cod";
                        break;
                    case 'ief':
                        $mimetype = "image/ief";
                        break;
                    case 'svg':
                        $mimetype = "image/svg+xml";
                        break;
                    case 'tif':
                        $mimetype = "image/tiff";
                        break;
                    case 'tiff':
                        $mimetype = "image/tiff";
                        break;
                    case 'ras':
                        $mimetype = "image/x-cmu-raster";
                        break;
                    case 'cmx':
                        $mimetype = "image/x-cmx";
                        break;
                    case 'ico':
                        $mimetype = "image/x-icon";
                        break;
                    case 'pnm':
                        $mimetype = "image/x-portable-anymap";
                        break;
                    case 'pbm':
                        $mimetype = "image/x-portable-bitmap";
                        break;
                    case 'pgm':
                        $mimetype = "image/x-portable-graymap";
                        break;
                    case 'ppm':
                        $mimetype = "image/x-portable-pixmap";
                        break;
                    case 'rgb':
                        $mimetype = "image/x-rgb";
                        break;
                    case 'xbm':
                        $mimetype = "image/x-xbitmap";
                        break;
                    case 'xpm':
                        $mimetype = "image/x-xpixmap";
                        break;
                    case 'xwd':
                        $mimetype = "image/x-xwindowdump";
                        break;
                    case 'rgb':
                        $mimetype = "image/x-rgb";
                        break;
                    case 'xbm':
                        $mimetype = "image/x-xbitmap";
                        break;
                    case "wbmp":
                        $mimetype = "image/vnd.wap.wbmp";
                        break;
                        //Files MIME Types
                    //Files MIME Types
                    case 'css':
                        $mimetype = "text/css";
                        break;
                    case 'htm':
                        $mimetype = "text/html";
                        break;
                    case 'html':
                        $mimetype = "text/html";
                        break;
                    case 'stm':
                        $mimetype = "text/html";
                        break;
                    case 'c':
                        $mimetype = "text/plain";
                        break;
                    case 'h':
                        $mimetype = "text/plain";
                        break;
                    case 'txt':
                        $mimetype = "text/plain";
                        break;
                    case 'rtx':
                        $mimetype = "text/richtext";
                        break;
                    case 'htc':
                        $mimetype = "text/x-component";
                        break;
                    case 'vcf':
                        $mimetype = "text/x-vcard";
                        break;
                        //Applications MIME Types
                    //Applications MIME Types
                    case 'doc':
                        $mimetype = "application/msword";
                        break;
                    case 'xls':
                        $mimetype = "application/vnd.ms-excel";
                        break;
                    case 'ppt':
                        $mimetype = "application/vnd.ms-powerpoint";
                        break;
                    case 'pps':
                        $mimetype = "application/vnd.ms-powerpoint";
                        break;
                    case 'pot':
                        $mimetype = "application/vnd.ms-powerpoint";
                        break;
                    case "ogg":
                        $mimetype = "application/ogg";
                        break;
                    case "pls":
                        $mimetype = "application/pls+xml";
                        break;
                    case "asf":
                        $mimetype = "application/vnd.ms-asf";
                        break;
                    case "wmlc":
                        $mimetype = "application/vnd.wap.wmlc";
                        break;
                    case 'dot':
                        $mimetype = "application/msword";
                        break;
                    case 'class':
                        $mimetype = "application/octet-stream";
                        break;
                    case 'exe':
                        $mimetype = "application/octet-stream";
                        break;
                    case 'pdf':
                        $mimetype = "application/pdf";
                        break;
                    case 'rtf':
                        $mimetype = "application/rtf";
                        break;
                    case 'xla':
                        $mimetype = "application/vnd.ms-excel";
                        break;
                    case 'xlc':
                        $mimetype = "application/vnd.ms-excel";
                        break;
                    case 'xlm':
                        $mimetype = "application/vnd.ms-excel";
                        break;
                    case 'msg':
                        $mimetype = "application/vnd.ms-outlook";
                        break;
                    case 'mpp':
                        $mimetype = "application/vnd.ms-project";
                        break;
                    case 'cdf':
                        $mimetype = "application/x-cdf";
                        break;
                    case 'tgz':
                        $mimetype = "application/x-compressed";
                        break;
                    case 'dir':
                        $mimetype = "application/x-director";
                        break;
                    case 'dvi':
                        $mimetype = "application/x-dvi";
                        break;
                    case 'gz':
                        $mimetype = "application/x-gzip";
                        break;
                    case 'js':
                        $mimetype = "application/x-javascript";
                        break;
                    case 'mdb':
                        $mimetype = "application/x-msaccess";
                        break;
                    case 'dll':
                        $mimetype = "application/x-msdownload";
                        break;
                    case 'wri':
                        $mimetype = "application/x-mswrite";
                        break;
                    case 'cdf':
                        $mimetype = "application/x-netcdf";
                        break;
                    case 'swf':
                        $mimetype = "application/x-shockwave-flash";
                        break;
                    case 'tar':
                        $mimetype = "application/x-tar";
                        break;
                    case 'man':
                        $mimetype = "application/x-troff-man";
                        break;
                    case 'zip':
                        $mimetype = "application/zip";
                        break;
                    case 'xlsx':
                        $mimetype = "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
                        break;
                    case 'pptx':
                        $mimetype = "application/vnd.openxmlformats-officedocument.presentationml.presentation";
                        break;
                    case 'docx':
                        $mimetype = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
                        break;
                    case 'xltx':
                        $mimetype = "application/vnd.openxmlformats-officedocument.spreadsheetml.template";
                        break;
                    case 'potx':
                        $mimetype = "application/vnd.openxmlformats-officedocument.presentationml.template";
                        break;
                    case 'ppsx':
                        $mimetype = "application/vnd.openxmlformats-officedocument.presentationml.slideshow";
                        break;
                    case 'sldx':
                        $mimetype = "application/vnd.openxmlformats-officedocument.presentationml.slide";
                        break;
                        ///Audio and Video Files
                    ///Audio and Video Files
                    case 'mp3':
                        $mimetype = "audio/mpeg";
                        break;
                    case 'wav':
                        $mimetype = "audio/x-wav";
                        break;
                    case 'au':
                        $mimetype = "audio/basic";
                        break;
                    case 'snd':
                        $mimetype = "audio/basic";
                        break;
                    case 'm3u':
                        $mimetype = "audio/x-mpegurl";
                        break;
                    case 'ra':
                        $mimetype = "audio/x-pn-realaudio";
                        break;
                    case 'mp2':
                        $mimetype = "video/mpeg";
                        break;
                    case 'mov':
                        $mimetype = "video/quicktime";
                        break;
                    case 'qt':
                        $mimetype = "video/quicktime";
                        break;
                    case 'mp4':
                        $mimetype = "video/mp4";
                        break;
                    case 'm4a':
                        $mimetype = "audio/mp4";
                        break;
                    case 'mp4a':
                        $mimetype = "audio/mp4";
                        break;
                    case 'm4p':
                        $mimetype = "audio/mp4";
                        break;
                    case 'm3a':
                        $mimetype = "audio/mpeg";
                        break;
                    case 'm2a':
                        $mimetype = "audio/mpeg";
                        break;
                    case 'mp2a':
                        $mimetype = "audio/mpeg";
                        break;
                    case 'mp2':
                        $mimetype = "audio/mpeg";
                        break;
                    case 'mpga':
                        $mimetype = "audio/mpeg";
                        break;
                    case '3gp':
                        $mimetype = "video/3gpp";
                        break;
                    case '3g2':
                        $mimetype = "video/3gpp2";
                        break;
                    case 'mp4v':
                        $mimetype = "video/mp4";
                        break;
                    case 'mpg4':
                        $mimetype = "video/mp4";
                        break;
                    case 'm2v':
                        $mimetype = "video/mpeg";
                        break;
                    case 'm1v':
                        $mimetype = "video/mpeg";
                        break;
                    case 'mpe':
                        $mimetype = "video/mpeg";
                        break;
                    case 'avi':
                        $mimetype = "video/x-msvideo";
                        break;
                    case 'midi':
                        $mimetype = "audio/midi";
                        break;
                    case 'mid':
                        $mimetype = "audio/mid";
                        break;
                    case 'amr':
                        $mimetype = "audio/amr";
                        break;
                    default:
                        $mimetype = "application/octet-stream";
                }
                header( 'Content-Description: File Transfer' );
                header( 'Content-Type: ' . $mimetype );
                header( "Content-Disposition: " . $pdf_download_mode . "; filename=\"" . $path_parts["basename"] . "\"" );
                header( 'Content-Transfer-Encoding: binary' );
                header( 'Cache-Control: post-check=0, pre-check=0', false );
                header( 'Cache-Control: no-store, no-cache, must-revalidate' );
                header( 'Pragma: no-cache' );
                header( "Content-Length: {$fsize}" );
                $chunk = 1 * (1024 * 1024);
                $handle = fopen( $fullPath, "rb" );
                while ( !feof( $handle ) ) {
                    print fread( $handle, $chunk );
                    //phpcs:ignore
                    ob_flush();
                    flush();
                }
                fclose( $handle );
            }
            
            exit;
        }
    
    }
    
    // Adds the new tab
    public function wcpoa_new_product_tab( $tabs )
    {
        global  $post, $sitepress ;
        $product_id = $post->ID;
        
        if ( has_filter( 'wcpoa_md_cs_filter' ) ) {
            $product = wc_get_product( $product_id );
            $item_sku = $product->get_sku();
            $ids = wc_get_product_id_by_sku( $item_sku );
            $product_id = $ids;
        }
        
        $product_tab = get_option( 'wcpoa_product_tab_name' );
        $wcpoa_default_tab_selected_flag = get_option( 'wcpoa_default_tab_selected_flag' );
        
        if ( isset( $wcpoa_default_tab_selected_flag ) && 'yes' === $wcpoa_default_tab_selected_flag ) {
            $tab_priority = 10;
        } else {
            $tab_priority = 50;
        }
        
        $tab_priority = apply_filters( 'attachment_tab_priority_no', $tab_priority );
        
        if ( !empty($sitepress) ) {
            $default_lang = self::$admin_object->wcpoa_get_default_langugae_with_sitpress();
            $product_tab_name = apply_filters(
                'wpml_translate_single_string',
                $product_tab,
                'woocommerce-product-attachment',
                $product_tab,
                $default_lang
            );
        } else {
            $product_tab_name = $product_tab;
        }
        
        $_product = wc_get_product( $product_id );
        $wcpoa_bulk_att_data = get_option( 'wcpoa_bulk_attachment_data' );
        $wcpoa_product_page_enable = get_post_meta( $product_id, 'wcpoa_product_page_enable', true );
        if ( !empty($wcpoa_product_page_enable) || !empty($wcpoa_bulk_att_data) || $_product->is_type( 'grouped' ) ) {
            $tabs['wcpoa_product_tab'] = array(
                'title'    => __( $product_tab_name, 'woocommerce-product-attachment' ),
                'priority' => $tab_priority,
                'callback' => array( $this, 'wcpoa_product_tab_content' ),
            );
        }
        return $tabs;
    }
    
    /*
     * The wcpoa_new_product_tab tab content
     */
    public function wcpoa_product_tab_content( $attachment_id, $parameters )
    {
        global  $post ;
        do_action( 'before_wcpoa_product_tab_content' );
        $product_id = $post->ID;
        $_product = wc_get_product( $product_id );
        if ( !is_a( $_product, 'WC_Product' ) ) {
            return;
        }
        $wcpoa_bulk_att_match = '';
        $youtube_video_only = '';
        $current_date = gmdate( "Y/m/d" );
        $wcpoa_today_date = strtotime( $current_date );
        $wcpoa_expired_date_tlabel = get_option( 'wcpoa_expired_date_label' );
        $get_permalink_structure = get_permalink();
        
        if ( strpos( $get_permalink_structure, "?" ) ) {
            $wcpoa_attachment_url_arg = '&';
        } else {
            $wcpoa_attachment_url_arg = '?';
        }
        
        if ( !$_product->is_type( 'grouped' ) ) {
            /** Get all the main products attachments */
            
            if ( isset( $youtube_video_only ) && 'Yes' === $youtube_video_only ) {
                $showcase_video_tab = $this->get_attachments_from_id( $product_id, $parameters );
            } else {
                $wcpoa_bulk_att_match = $this->get_attachments_from_id( $product_id, $parameters );
            }
        
        }
        
        if ( $_product->is_type( 'grouped' ) ) {
            $grouped_products = $_product->get_children();
            if ( isset( $grouped_products ) && is_array( $grouped_products ) ) {
                foreach ( $grouped_products as $gp_id ) {
                    
                    if ( 'yes' != $wcpoa_bulk_att_match ) {
                        /**Get all the grouped product attachmetns */
                        $wcpoa_bulk_att_match = $this->get_attachments_from_id( $gp_id, $parameters );
                    } else {
                        /**Get all the grouped product attachmetns */
                        $this->get_attachments_from_id( $gp_id, $parameters );
                    }
                
                }
            }
        }
        
        //Bulk Attachment
        $wcpoa_bulk_att_data = get_option( 'wcpoa_bulk_attachment_data' );
        $wcpoa_bulk_att_values = array();
        $wcpoa_bulk_att_values_key = array();
        if ( !empty($wcpoa_bulk_att_data) && is_array( $wcpoa_bulk_att_data ) ) {
            foreach ( $wcpoa_bulk_att_data as $att_new_key => $wcpoa_bulk_att_values ) {
                if ( !array_key_exists( 'wcpoa_attach_view', $wcpoa_bulk_att_values ) || "enable" === $wcpoa_bulk_att_values['wcpoa_attach_view'] ) {
                    
                    if ( !in_array( $att_new_key, convert_array_to_int( $wcpoa_bulk_att_values_key ), true ) ) {
                        $wcpoa_bulk_att_visibility = ( isset( $wcpoa_bulk_att_values['wcpoa_att_visibility'] ) && !empty($wcpoa_bulk_att_values['wcpoa_att_visibility']) ? $wcpoa_bulk_att_values['wcpoa_att_visibility'] : '' );
                        $wcpoa_product_logged_in_flag = ( isset( $wcpoa_bulk_att_values['wcpoa_product_logged_in_flag'] ) && !empty($wcpoa_bulk_att_values['wcpoa_product_logged_in_flag']) ? $wcpoa_bulk_att_values['wcpoa_product_logged_in_flag'] : '' );
                        $wcpoa_product_open_window_flag = ( isset( $wcpoa_bulk_att_values['wcpoa_product_open_window_flag'] ) && !empty($wcpoa_bulk_att_values['wcpoa_product_open_window_flag']) ? $wcpoa_bulk_att_values['wcpoa_product_open_window_flag'] : '' );
                        $download_target = ( $wcpoa_product_open_window_flag === 'yes' ? 'target="_blank"' : '' );
                        
                        if ( 'yes' === $wcpoa_product_logged_in_flag && is_user_logged_in() || 'no' === $wcpoa_product_logged_in_flag || '' === $wcpoa_product_logged_in_flag ) {
                            $wcpoa_is_condition = ( isset( $wcpoa_bulk_att_values['wcpoa_is_condition'] ) && !empty($wcpoa_bulk_att_values['wcpoa_is_condition']) ? $wcpoa_bulk_att_values['wcpoa_is_condition'] : '' );
                            $wcpoa_attachments_bulk_id = ( !empty($wcpoa_bulk_att_values['wcpoa_attachments_id']) ? $wcpoa_bulk_att_values['wcpoa_attachments_id'] : '' );
                            $wcpoa_bulk_attachments_name = ( isset( $wcpoa_bulk_att_values['wcpoa_attachment_name'] ) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_name']) ? $wcpoa_bulk_att_values['wcpoa_attachment_name'] : '' );
                            $wcpoa_bulk_attachment_type = ( isset( $wcpoa_bulk_att_values['wcpoa_attach_type'] ) && !empty($wcpoa_bulk_att_values['wcpoa_attach_type']) ? $wcpoa_bulk_att_values['wcpoa_attach_type'] : '' );
                            $wcpoa_bulk_attachment_file = ( isset( $wcpoa_bulk_att_values['wcpoa_attachment_file'] ) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_file']) ? $wcpoa_bulk_att_values['wcpoa_attachment_file'] : '' );
                            $wcpoa_attachment_descriptions = ( isset( $wcpoa_bulk_att_values['wcpoa_attachment_description'] ) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_description']) ? $wcpoa_bulk_att_values['wcpoa_attachment_description'] : '' );
                            $wcpoa_expired_dates = ( isset( $wcpoa_bulk_att_values['wcpoa_expired_date'] ) && !empty($wcpoa_bulk_att_values['wcpoa_expired_date']) ? $wcpoa_bulk_att_values['wcpoa_expired_date'] : '' );
                            
                            if ( isset( $wcpoa_bulk_attachment_file ) ) {
                                $attachment_id = $wcpoa_bulk_attachment_file;
                                $wcpoa_attachments_type = get_post_mime_type( $attachment_id );
                                $wcpoa_mime_type = explode( '/', $wcpoa_attachments_type );
                                $wcpoa_att_type = ( isset( $wcpoa_mime_type['1'] ) ? $wcpoa_mime_type['1'] : $wcpoa_mime_type['0'] );
                            } else {
                                $wcpoa_attachments_type = 'default';
                                $wcpoa_att_type = 'default';
                            }
                            
                            $wcpoa_attachments_icons = WCPOA_PLUGIN_URL . 'public/images/default.png';
                            $wcpoa_attachments_expired_icons = WCPOA_PLUGIN_URL . 'public/images/expired.png';
                            
                            if ( $wcpoa_att_type === 'png' || $wcpoa_att_type === 'jpeg' ) {
                                $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/image.png';
                            } elseif ( $wcpoa_att_type === 'pdf' ) {
                                $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/pdf.png';
                            } elseif ( $wcpoa_att_type === 'csv' ) {
                                $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/csv.png';
                            } elseif ( $wcpoa_att_type === 'video' ) {
                                $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/video.png';
                            } elseif ( $wcpoa_att_type === 'xml' ) {
                                $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/xml.png';
                            } elseif ( $wcpoa_att_type === 'msword' ) {
                                $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/doc.png';
                            } elseif ( $wcpoa_att_type === 'zip' ) {
                                $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/zip.png';
                            } elseif ( $wcpoa_att_type === 'vnd.openxmlformats-officedocument.spreadsheetml.sheet' ) {
                                $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/excel.png';
                            } else {
                                $wcpoa_attachments_icon = $wcpoa_attachments_icons;
                            }
                            
                            $wcpoa_att_btn = __( 'Download', 'woocommerce-product-attachment' );
                            $wcpoa_att_ex_btn = __( 'Download', 'woocommerce-product-attachment' );
                            
                            if ( isset( $wcpoa_show_attachment_size_flag ) && 'yes' === $wcpoa_show_attachment_size_flag ) {
                                $attachment_size = size_format( filesize( get_attached_file( $wcpoa_bulk_att_values['wcpoa_attachment_file'] ) ) );
                                if ( isset( $attachment_size ) && '' != $attachment_size ) {
                                    
                                    if ( isset( $parameters['hide_size_label'] ) && "true" === $parameters['hide_size_label'] ) {
                                        $wcpoa_att_btn = $wcpoa_att_btn;
                                    } else {
                                        $wcpoa_att_btn = $wcpoa_att_btn . '<span class="attachment_size">(' . $attachment_size . ')</span>';
                                    }
                                
                                }
                            }
                            
                            
                            if ( isset( $parameters['hide_title'] ) && !empty($parameters['hide_title']) && "true" === $parameters['hide_title'] ) {
                                $hide_me_cls = "wcpoa_hide_me";
                            } else {
                                $hide_me_cls = "";
                            }
                            
                            // get attachment download type
                            $wcpoa_product_download_type = get_option( 'wcpoa_product_download_type' );
                            
                            if ( !empty($wcpoa_product_download_type) && 'download_by_link' === $wcpoa_product_download_type || 'download_by_both' === $wcpoa_product_download_type ) {
                                $wcpoa_attachments_name = '<h4 class="wcpoa_attachment_name ' . esc_attr( $hide_me_cls ) . ' "><a class="wcpoa_title_with_link" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $wcpoa_bulk_attachment_file . '&download_file=' . $wcpoa_attachments_bulk_id . '" rel="nofollow" ' . $download_target . '> ' . esc_html__( $wcpoa_bulk_attachments_name, 'woocommerce-product-attachment' ) . ' </a></h4>';
                            } else {
                                $wcpoa_attachments_name = '<h4 class="wcpoa_attachment_name ' . esc_attr( $hide_me_cls ) . ' ">' . esc_html__( $wcpoa_bulk_attachments_name, 'woocommerce-product-attachment' ) . '</h4>';
                            }
                            
                            $wcpoa_bulk_file_url_btn = '<a class="wcpoa_attachmentbtn" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $wcpoa_bulk_attachment_file . '&download_file=' . $wcpoa_attachments_bulk_id . '" rel="nofollow" ' . $download_target . '> ' . $wcpoa_att_btn . ' </a>';
                            $wcpoa_bulk_file_expired_url_btn = '<a class="wcpoa_order_attachment_expire" rel="nofollow">' . $wcpoa_att_ex_btn . '</a>';
                            if ( !empty($wcpoa_product_download_type) && 'download_by_link' === $wcpoa_product_download_type || 'download_by_both' === $wcpoa_product_download_type ) {
                                $wcpoa_expired_attachments_name = '<h4 class="wcpoa_attachment_name ' . esc_attr( $hide_me_cls ) . ' "><a class="wcpoa_title_with_link wcpoa_expired_title_with_link"> ' . esc_html__( $wcpoa_bulk_attachments_name, 'woocommerce-product-attachment' ) . ' </a></h4>';
                            }
                            
                            if ( isset( $parameters['hide_description'] ) && !empty($parameters['hide_description']) && "true" === $parameters['hide_description'] ) {
                                $hide_me_cls = "wcpoa_hide_me";
                            } else {
                                $hide_me_cls = "";
                            }
                            
                            $wcpoa_attachment_descriptions = '<p class="wcpoa_attachment_desc ' . esc_attr( $hide_me_cls ) . ' ">' . __( $wcpoa_attachment_descriptions, 'woocommerce-product-attachment' ) . '</p>';
                            
                            if ( 'no' === $wcpoa_bulk_att_values['wcpoa_expired_date_enable'] || 'no' === $wcpoa_expired_date_tlabel ) {
                                $wcpoa_bulk_expired_date_text = '';
                                $wcpoa_bulk_expire_date_text = '';
                            } else {
                                $wcpoa_bulk_expired_date_text = '<p class="order_att_expire_date"><span>*</span>' . __( 'This Attachment Expired.', 'woocommerce-product-attachment' ) . '</p>';
                                $wcpoa_bulk_expire_date_text = '<p class="order_att_expire_date"><span>*</span>' . __( 'This Attachment Expiry Date : ', 'woocommerce-product-attachment' ) . $wcpoa_expired_dates . '</p>';
                            }
                            
                            $wcpoa_attachment_expired_date = strtotime( $wcpoa_expired_dates );
                            $wcpoa_bulk_att_values_key[] = $att_new_key;
                            
                            if ( $wcpoa_bulk_att_visibility === 'product_details_page' || $wcpoa_bulk_att_visibility === 'wcpoa_all' ) {
                                echo  '<div class="wcpoa_attachment">' ;
                                if ( $wcpoa_is_condition === 'no' ) {
                                    
                                    if ( !empty($wcpoa_attachment_expired_date) ) {
                                        
                                        if ( $wcpoa_today_date > $wcpoa_attachment_expired_date ) {
                                            
                                            if ( !empty($wcpoa_product_download_type) && 'download_by_link' === $wcpoa_product_download_type || 'download_by_both' === $wcpoa_product_download_type ) {
                                                echo  wp_kses( $wcpoa_expired_attachments_name, $this->allowed_html_tags() ) ;
                                            } else {
                                                echo  wp_kses( $wcpoa_attachments_name, $this->allowed_html_tags() ) ;
                                            }
                                            
                                            if ( !empty($wcpoa_product_download_type) && 'download_by_btn' === $wcpoa_product_download_type || 'download_by_both' === $wcpoa_product_download_type ) {
                                                echo  wp_kses( $wcpoa_bulk_file_expired_url_btn, $this->allowed_html_tags() ) ;
                                            }
                                            echo  wp_kses( $wcpoa_attachment_descriptions, $this->allowed_html_tags() ) ;
                                            echo  wp_kses( $wcpoa_bulk_expired_date_text, $this->allowed_html_tags() ) ;
                                            $wcpoa_bulk_att_match = 'yes';
                                        } else {
                                            echo  wp_kses( $wcpoa_attachments_name, $this->allowed_html_tags() ) ;
                                            if ( !empty($wcpoa_product_download_type) && 'download_by_btn' === $wcpoa_product_download_type || 'download_by_both' === $wcpoa_product_download_type ) {
                                                echo  wp_kses( $wcpoa_bulk_file_url_btn, $this->allowed_html_tags() ) ;
                                            }
                                            echo  wp_kses( $wcpoa_attachment_descriptions, $this->allowed_html_tags() ) ;
                                            echo  wp_kses( $wcpoa_bulk_expire_date_text, $this->allowed_html_tags() ) ;
                                            $wcpoa_bulk_att_match = 'yes';
                                        }
                                    
                                    } else {
                                        echo  wp_kses( $wcpoa_attachments_name, $this->allowed_html_tags() ) ;
                                        if ( !empty($wcpoa_product_download_type) && 'download_by_btn' === $wcpoa_product_download_type || 'download_by_both' === $wcpoa_product_download_type ) {
                                            echo  wp_kses( $wcpoa_bulk_file_url_btn, $this->allowed_html_tags() ) ;
                                        }
                                        echo  wp_kses( $wcpoa_attachment_descriptions, $this->allowed_html_tags() ) ;
                                        $wcpoa_bulk_att_match = 'yes';
                                    }
                                
                                }
                                echo  '</div>' ;
                            }
                        
                        }
                    
                    }
                
                }
            }
        }
        /** Check Attachment tab want to display or not */
        if ( '' === $youtube_video_only && $wcpoa_bulk_att_match !== 'yes' ) {
            ?>
            <style type="text/css">
            #tab-title-wcpoa_product_tab {
                display: none !important;
            }
            </style>
            <?php 
        }
        /** Check Attachment video tab want to display or not */
        if ( 'Yes' === $youtube_video_only && $showcase_video_tab !== 'yes' ) {
            ?>
            <style type="text/css">
            #tab-title-wcpoa_product_youtube_video_tab {
                display: none !important;
            }
            </style>
            <?php 
        }
        /** Adding custom CSS for the attachment section */
        $attachment_custom_style = get_option( 'attachment_custom_style' );
        
        if ( isset( $attachment_custom_style ) && '' !== $attachment_custom_style ) {
            ?>
            <style type="text/css" class="custom_css_call_inline">
            <?php 
            echo  esc_html( $attachment_custom_style ) ;
            ?>
            </style>
            <?php 
        }
        
        do_action( 'after_wcpoa_product_tab_content' );
    }
    
    /**
     * @param $product_id
     */
    public function get_attachments_from_id( $product_id, $parameters = array() )
    {
        if ( isset( $parameters['product_id'] ) && !empty($parameters['product_id']) ) {
            $product_id = $parameters['product_id'];
        }
        
        if ( has_filter( 'wcpoa_md_cs_filter' ) ) {
            $product = wc_get_product( $product_id );
            $item_sku = $product->get_sku();
            $ids = wc_get_product_id_by_sku( $item_sku );
            $product_id = $ids;
        }
        
        $wcpoa_attachment_ids = get_post_meta( $product_id, 'wcpoa_attachments_id', true );
        $wcpoa_attachment_name = get_post_meta( $product_id, 'wcpoa_attachment_name', true );
        $wcpoa_attachment_description = get_post_meta( $product_id, 'wcpoa_attachment_description', true );
        $wcpoa_product_page_enable = get_post_meta( $product_id, 'wcpoa_product_page_enable', true );
        $wcpoa_product_logged_in_flag = get_post_meta( $product_id, 'wcpoa_product_logged_in_flag', true );
        $wcpoa_product_open_window_flag = get_post_meta( $product_id, 'wcpoa_product_open_window_flag', true );
        $wcpoa_attach_type = get_post_meta( $product_id, 'wcpoa_attach_type', true );
        $wcpoa_attachment_ext_url = get_post_meta( $product_id, 'wcpoa_attachment_ext_url', true );
        $wcpoa_attachment_url = get_post_meta( $product_id, 'wcpoa_attachment_url', true );
        $wcpoa_expired_date_enable = get_post_meta( $product_id, 'wcpoa_expired_date_enable', true );
        $wcpoa_expired_date = get_post_meta( $product_id, 'wcpoa_expired_date', true );
        $get_permalink_structure = get_permalink();
        $wcpoa_expired_date_tlabel = get_option( 'wcpoa_expired_date_label' );
        $user = wp_get_current_user();
        $wcpoa_att_download_restrict_flag = 0;
        $youtube_video_only = '';
        $wcpoa_att_download_restrict = get_option( 'wcpoa_att_download_restrict' );
        $wcpoa_show_attachment_size_flag = get_option( 'wcpoa_show_attachment_size_flag' );
        
        if ( $wcpoa_att_download_restrict === 'wcpoa_att_download_loggedin' ) {
            
            if ( is_user_logged_in() ) {
                $wcpoa_att_download_restrict_flag = 1;
            } else {
                esc_html_e( 'Please Login To Download Attachment', 'woocommerce-product-attachment' );
            }
        
        } elseif ( $wcpoa_att_download_restrict === 'wcpoa_att_download_guest' ) {
            $wcpoa_att_download_restrict_flag = 1;
        }
        
        $wcpoa_att_download_visible_user = $user->roles;
        $prefixed_wcpoa_att_download_visible_user = preg_filter( '/^/', 'wcpoa_att_download_', $wcpoa_att_download_visible_user );
        
        if ( empty($wcpoa_att_download_restrict) ) {
            $wcpoa_att_download_restrict_flag = 1;
            // apply for all users
        } elseif ( in_array( 'wcpoa_att_download_guest', $wcpoa_att_download_restrict, true ) && !is_user_logged_in() ) {
            $wcpoa_att_download_restrict_flag = 1;
            // apply for guest users
        } elseif ( array_intersect( $prefixed_wcpoa_att_download_visible_user, $wcpoa_att_download_restrict ) ) {
            $wcpoa_att_download_restrict_flag = 1;
            // apply for admin user roles which is set by admin side
        } else {
            
            if ( is_user_logged_in() ) {
                esc_html_e( 'Restrict To Download Attachment', 'woocommerce-product-attachment' );
            } else {
                esc_html_e( 'Please Login To Download Attachment', 'woocommerce-product-attachment' );
            }
        
        }
        
        
        if ( strpos( $get_permalink_structure, "?" ) ) {
            $wcpoa_attachment_url_arg = '&';
        } else {
            $wcpoa_attachment_url_arg = '?';
        }
        
        $current_date = gmdate( "Y/m/d" );
        $wcpoa_today_date = strtotime( $current_date );
        $wcpoa_bulk_att_match = 'no';
        if ( (int) $wcpoa_att_download_restrict_flag === 1 ) {
            if ( !empty($wcpoa_attachment_ids) ) {
                foreach ( (array) $wcpoa_attachment_ids as $key => $wcpoa_attachments_id ) {
                    $video_box = false;
                    $hide_video = false;
                    
                    if ( !empty($wcpoa_attachments_id) ) {
                        $wcpoa_attachments_single_name = ( isset( $wcpoa_attachment_name[$key] ) && !empty($wcpoa_attachment_name[$key]) ? $wcpoa_attachment_name[$key] : '' );
                        $wcpoa_attach_type_single = ( isset( $wcpoa_attach_type[$key] ) && !empty($wcpoa_attach_type[$key]) ? $wcpoa_attach_type[$key] : '' );
                        $wcpoa_attachment_file = ( isset( $wcpoa_attachment_url[$key] ) && !empty($wcpoa_attachment_url[$key]) ? $wcpoa_attachment_url[$key] : '' );
                        $wcpoa_attachment_ext_url_single = ( isset( $wcpoa_attachment_ext_url[$key] ) && !empty($wcpoa_attachment_ext_url[$key]) ? $wcpoa_attachment_ext_url[$key] : '' );
                        $wcpoa_product_pages_enable = ( isset( $wcpoa_product_page_enable[$key] ) && !empty($wcpoa_product_page_enable[$key]) ? $wcpoa_product_page_enable[$key] : '' );
                        $wcpoa_product_logged_in_flag_value = ( isset( $wcpoa_product_logged_in_flag[$key] ) && !empty($wcpoa_product_logged_in_flag[$key]) ? $wcpoa_product_logged_in_flag[$key] : '' );
                        $wcpoa_expired_dates_enable = ( isset( $wcpoa_expired_date_enable[$key] ) && !empty($wcpoa_expired_date_enable[$key]) ? $wcpoa_expired_date_enable[$key] : '' );
                        $wcpoa_expired_dates = ( isset( $wcpoa_expired_date[$key] ) && !empty($wcpoa_expired_date[$key]) ? $wcpoa_expired_date[$key] : '' );
                        $wcpoa_attachment_descriptions = ( isset( $wcpoa_attachment_description[$key] ) && !empty($wcpoa_attachment_description[$key]) ? $wcpoa_attachment_description[$key] : '' );
                        $attachment_id = $wcpoa_attachment_file;
                        // ID of attachment
                        $wcpoa_product_open_window_flag_val = ( isset( $wcpoa_product_open_window_flag[$key] ) && !empty($wcpoa_product_open_window_flag[$key]) ? $wcpoa_product_open_window_flag[$key] : '' );
                        $wcpoa_attachments_type = get_post_mime_type( $attachment_id );
                        $wcpoa_mime_type = explode( '/', $wcpoa_attachments_type );
                        $wcpoa_att_type = ( isset( $wcpoa_mime_type['1'] ) ? $wcpoa_mime_type['1'] : $wcpoa_mime_type['0'] );
                        $wcpoa_attachments_icons = WCPOA_PLUGIN_URL . 'public/images/default.png';
                        $wcpoa_attachments_expired_icons = WCPOA_PLUGIN_URL . 'public/images/expired.png';
                        
                        if ( $wcpoa_att_type === 'png' || $wcpoa_att_type === 'jpeg' ) {
                            $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/image.png';
                        } elseif ( $wcpoa_att_type === 'pdf' ) {
                            $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/pdf.png';
                        } elseif ( $wcpoa_att_type === 'csv' ) {
                            $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/csv.png';
                        } elseif ( $wcpoa_att_type === 'video' ) {
                            $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/video.png';
                        } elseif ( $wcpoa_att_type === 'xml' ) {
                            $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/xml.png';
                        } elseif ( $wcpoa_att_type === 'msword' ) {
                            $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/doc.png';
                        } elseif ( $wcpoa_att_type === 'zip' ) {
                            $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/zip.png';
                        } elseif ( $wcpoa_att_type === 'vnd.openxmlformats-officedocument.spreadsheetml.sheet' ) {
                            $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/excel.png';
                        } else {
                            $wcpoa_attachments_icon = $wcpoa_attachments_icons;
                        }
                        
                        $wcpoa_att_btn = __( 'Download', 'woocommerce-product-attachment' );
                        $wcpoa_att_ex_btn = __( 'Download', 'woocommerce-product-attachment' );
                        if ( $wcpoa_product_pages_enable === "yes" ) {
                            
                            if ( 'yes' === $wcpoa_product_logged_in_flag_value && is_user_logged_in() || 'no' === $wcpoa_product_logged_in_flag_value || '' === $wcpoa_product_logged_in_flag_value ) {
                                $wcpoa_attachment_expired_date = strtotime( $wcpoa_expired_dates );
                                
                                if ( isset( $parameters['hide_title'] ) && !empty($parameters['hide_title']) && "true" === $parameters['hide_title'] ) {
                                    $hide_me_cls = "wcpoa_hide_me";
                                } else {
                                    $hide_me_cls = "";
                                }
                                
                                // get attachment download type
                                $wcpoa_product_download_type = get_option( 'wcpoa_product_download_type' );
                                
                                if ( isset( $wcpoa_show_attachment_size_flag ) && 'yes' === $wcpoa_show_attachment_size_flag ) {
                                    $attachment_size = size_format( filesize( get_attached_file( $attachment_id ) ) );
                                    if ( isset( $attachment_size ) && '' != $attachment_size ) {
                                        
                                        if ( isset( $parameters['hide_size_label'] ) && "true" === $parameters['hide_size_label'] ) {
                                            $wcpoa_att_btn = $wcpoa_att_btn;
                                        } else {
                                            $wcpoa_att_btn = $wcpoa_att_btn . '<span class="attachment_size">(' . $attachment_size . ')</span>';
                                        }
                                    
                                    }
                                }
                                
                                $download_target = ( $wcpoa_product_open_window_flag_val === 'yes' ? 'target="_blank"' : '' );
                                
                                if ( !empty($wcpoa_product_download_type) && 'download_by_link' === $wcpoa_product_download_type || 'download_by_both' === $wcpoa_product_download_type ) {
                                    $wcpoa_attachments_name = '<h4 class="wcpoa_attachment_name ' . esc_attr( $hide_me_cls ) . ' "><a class="wcpoa_title_with_link" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $attachment_id . '&download_file=' . $wcpoa_attachments_id . '" rel="nofollow" ' . $download_target . '> ' . __( $wcpoa_attachments_single_name, 'woocommerce-product-attachment' ) . '</a></h4>';
                                } else {
                                    $wcpoa_attachments_name = '<h4 class="wcpoa_attachment_name ' . esc_attr( $hide_me_cls ) . ' ">' . __( $wcpoa_attachments_single_name, 'woocommerce-product-attachment' ) . '</h4>';
                                }
                                
                                $wcpoa_file_url_btn = '<a class="wcpoa_attachmentbtn" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $attachment_id . '&download_file=' . $wcpoa_attachments_id . '" rel="nofollow" ' . $download_target . '> ' . $wcpoa_att_btn . '</a>';
                                $wcpoa_file_expired_url_btn = '<a class="wcpoa_order_attachment_expire" rel="nofollow"> ' . $wcpoa_att_ex_btn . ' </a>';
                                if ( !empty($wcpoa_product_download_type) && 'download_by_link' === $wcpoa_product_download_type || 'download_by_both' === $wcpoa_product_download_type ) {
                                    $wcpoa_expired_attachments_name = '<h4 class="wcpoa_attachment_name ' . esc_attr( $hide_me_cls ) . ' "><a class="wcpoa_title_with_link wcpoa_expired_title_with_link"> ' . esc_html__( $wcpoa_attachments_single_name, 'woocommerce-product-attachment' ) . ' </a></h4>';
                                }
                                
                                if ( isset( $parameters['hide_description'] ) && !empty($parameters['hide_description']) && "true" === $parameters['hide_description'] ) {
                                    $hide_me_cls = "wcpoa_hide_me";
                                } else {
                                    $hide_me_cls = "";
                                }
                                
                                $wcpoa_attachment_descriptions = '<p class="wcpoa_attachment_desc ' . esc_attr( $hide_me_cls ) . '">' . __( $wcpoa_attachment_descriptions, 'woocommerce-product-attachment' ) . '</p>';
                                
                                if ( $wcpoa_expired_date_tlabel === 'no' ) {
                                    $wcpoa_expire_date_text = '';
                                    $wcpoa_expired_date_text = '';
                                } else {
                                    $wcpoa_expire_date_text = '<p class="order_att_expire_date"><span>*</span>' . __( 'This Attachment Expiry Date : ', 'woocommerce-product-attachment' ) . $wcpoa_expired_dates . '</p>';
                                    $wcpoa_expired_date_text = '<p class="order_att_expire_date"><span>*</span>' . __( 'This Attachment Expired.', 'woocommerce-product-attachment' ) . '</p>';
                                }
                                
                                echo  '<div class="wcpoa_attachment">' ;
                                
                                if ( 'no' === $wcpoa_expired_dates_enable ) {
                                    /** Custom video section start */
                                    
                                    if ( true === $video_box ) {
                                        echo  wp_kses( $wcpoa_attachments_name, $this->allowed_html_tags() ) ;
                                        echo  $wcpoa_file_url_btn ;
                                        //phpcs:ignore
                                        echo  wp_kses( $wcpoa_attachment_descriptions, $this->allowed_html_tags() ) ;
                                        $wcpoa_bulk_att_match = 'yes';
                                    } else {
                                        
                                        if ( false == $hide_video && 'Yes' !== $youtube_video_only ) {
                                            echo  wp_kses( $wcpoa_attachments_name, $this->allowed_html_tags() ) ;
                                            if ( !empty($wcpoa_product_download_type) && 'download_by_btn' === $wcpoa_product_download_type || 'download_by_both' === $wcpoa_product_download_type ) {
                                                echo  wp_kses( $wcpoa_file_url_btn, $this->allowed_html_tags() ) ;
                                            }
                                            echo  wp_kses( $wcpoa_attachment_descriptions, $this->allowed_html_tags() ) ;
                                            $wcpoa_bulk_att_match = 'yes';
                                        }
                                    
                                    }
                                    
                                    /** Custom video section end */
                                } else {
                                    
                                    if ( !empty($wcpoa_attachment_expired_date) ) {
                                        
                                        if ( $wcpoa_today_date > $wcpoa_attachment_expired_date ) {
                                            /** Custom video section start */
                                            
                                            if ( true === $video_box ) {
                                                echo  wp_kses( $wcpoa_attachments_name, $this->allowed_html_tags() ) ;
                                                echo  $wcpoa_file_url_btn ;
                                                //phpcs:ignore
                                                echo  wp_kses( $wcpoa_attachment_descriptions, $this->allowed_html_tags() ) ;
                                                $wcpoa_bulk_att_match = 'yes';
                                            } else {
                                                
                                                if ( false == $hide_video && 'Yes' !== $youtube_video_only ) {
                                                    
                                                    if ( !empty($wcpoa_product_download_type) && 'download_by_link' === $wcpoa_product_download_type || 'download_by_both' === $wcpoa_product_download_type ) {
                                                        echo  wp_kses( $wcpoa_expired_attachments_name, $this->allowed_html_tags() ) ;
                                                    } else {
                                                        echo  wp_kses( $wcpoa_attachments_name, $this->allowed_html_tags() ) ;
                                                    }
                                                    
                                                    if ( !empty($wcpoa_product_download_type) && 'download_by_btn' === $wcpoa_product_download_type || 'download_by_both' === $wcpoa_product_download_type ) {
                                                        echo  wp_kses( $wcpoa_file_expired_url_btn, $this->allowed_html_tags() ) ;
                                                    }
                                                    echo  wp_kses( $wcpoa_attachment_descriptions, $this->allowed_html_tags() ) ;
                                                    echo  wp_kses( $wcpoa_expired_date_text, $this->allowed_html_tags() ) ;
                                                    $wcpoa_bulk_att_match = 'yes';
                                                }
                                            
                                            }
                                            
                                            /** Custom video section end */
                                        } else {
                                            /** Custom video section start */
                                            
                                            if ( true === $video_box ) {
                                                echo  wp_kses( $wcpoa_attachments_name, $this->allowed_html_tags() ) ;
                                                echo  $wcpoa_file_url_btn ;
                                                //phpcs:ignore
                                                echo  wp_kses( $wcpoa_attachment_descriptions, $this->allowed_html_tags() ) ;
                                                $wcpoa_bulk_att_match = 'yes';
                                            } else {
                                                
                                                if ( false == $hide_video && 'Yes' !== $youtube_video_only ) {
                                                    echo  wp_kses( $wcpoa_attachments_name, $this->allowed_html_tags() ) ;
                                                    if ( !empty($wcpoa_product_download_type) && 'download_by_btn' === $wcpoa_product_download_type || 'download_by_both' === $wcpoa_product_download_type ) {
                                                        echo  wp_kses( $wcpoa_file_url_btn, $this->allowed_html_tags() ) ;
                                                    }
                                                    echo  wp_kses( $wcpoa_attachment_descriptions, $this->allowed_html_tags() ) ;
                                                    echo  wp_kses( $wcpoa_expire_date_text, $this->allowed_html_tags() ) ;
                                                    $wcpoa_bulk_att_match = 'yes';
                                                }
                                            
                                            }
                                            
                                            /** Custom video section end */
                                        }
                                    
                                    } else {
                                        /** Custom video section start */
                                        
                                        if ( true === $video_box ) {
                                            echo  wp_kses( $wcpoa_attachments_name, $this->allowed_html_tags() ) ;
                                            echo  $wcpoa_file_url_btn ;
                                            //phpcs:ignore
                                            echo  wp_kses( $wcpoa_attachment_descriptions, $this->allowed_html_tags() ) ;
                                            $wcpoa_bulk_att_match = 'yes';
                                        } else {
                                            
                                            if ( false == $hide_video && 'Yes' !== $youtube_video_only ) {
                                                echo  wp_kses( $wcpoa_attachments_name, $this->allowed_html_tags() ) ;
                                                if ( !empty($wcpoa_product_download_type) && 'download_by_btn' === $wcpoa_product_download_type || 'download_by_both' === $wcpoa_product_download_type ) {
                                                    echo  wp_kses( $wcpoa_file_url_btn, $this->allowed_html_tags() ) ;
                                                }
                                                echo  wp_kses( $wcpoa_attachment_descriptions, $this->allowed_html_tags() ) ;
                                                $wcpoa_bulk_att_match = 'yes';
                                            }
                                        
                                        }
                                        
                                        /** Custom video section end */
                                    }
                                
                                }
                                
                                echo  '</div>' ;
                            }
                        
                        }
                    }
                
                }
            }
        }
        return $wcpoa_bulk_att_match;
    }
    
    /**
     * Product attachments data save in order table.
     *
     * @param $item_id
     * @param $item
     * @param $order_id
     */
    public function wcpoa_add_values_to_order_item_meta( $item_id, $item, $order_id )
    {
        $item_product = new WC_Order_Item_Product( $item );
        $product_id = $item_product->get_product_id();
        
        if ( has_filter( 'wcpoa_md_cs_filter' ) ) {
            $product = wc_get_product( $product_id );
            $item_sku = $product->get_sku();
            $ids = wc_get_product_id_by_sku( $item_sku );
            $product_id = $ids;
        }
        
        $wcpoa_attachment_ids = get_post_meta( $product_id, 'wcpoa_attachments_id', true );
        $wcpoa_attachment_name = get_post_meta( $product_id, 'wcpoa_attachment_name', true );
        $wcpoa_attachment_description = get_post_meta( $product_id, 'wcpoa_attachment_description', true );
        $wcpoa_attachment_url = get_post_meta( $product_id, 'wcpoa_attachment_url', true );
        $wcpoa_attach_type = get_post_meta( $product_id, 'wcpoa_attach_type', true );
        $wcpoa_order_status = get_post_meta( $product_id, 'wcpoa_order_status', true );
        $wcpoa_expired_date_enable = get_post_meta( $product_id, 'wcpoa_expired_date_enable', true );
        $wcpoa_expired_date = get_post_meta( $product_id, 'wcpoa_expired_date', true );
        
        if ( !empty($wcpoa_attachment_ids) ) {
            $wcpoa_order_attachment_order_arr = array(
                'wcpoa_attachment_ids'           => $wcpoa_attachment_ids,
                'wcpoa_attachment_name'          => $wcpoa_attachment_name,
                'wcpoa_att_order_description'    => $wcpoa_attachment_description,
                'wcpoa_attachment_url'           => $wcpoa_attachment_url,
                'wcpoa_attach_type'              => $wcpoa_attach_type,
                'wcpoa_order_status'             => $wcpoa_order_status,
                'wcpoa_expired_date_enable'      => $wcpoa_expired_date_enable,
                'wcpoa_order_attachment_expired' => $wcpoa_expired_date,
            );
            wc_add_order_item_meta( $item_id, 'wcpoa_order_attachment_order_arr', $wcpoa_order_attachment_order_arr );
        }
    
    }
    
    /**
     * Product attachments data show on thankyou page.
     *
     * @since    1.0.0
     * @access   public
     */
    public function wcpoa_order_data_show_on_thankyou( $order_id )
    {
        global  $sitepress ;
        $order = new WC_Order( $order_id );
        $order_data = $order->get_data();
        $order_time = $order_data['date_created']->date( 'Y/m/d H:i:s' );
        $items = $order->get_items( array( 'line_item' ) );
        $items_order_status = $order->get_status();
        $items_order_id = $order_id;
        $wcpoa_order_tab_name = get_option( 'wcpoa_order_tab_name' );
        //wcpoa order tab option name
        $wcpoa_expired_date_tlabel = get_option( 'wcpoa_expired_date_label' );
        $is_download = '';
        // get attachment download type
        $wcpoa_download_type = get_option( 'wcpoa_product_download_type' );
        $get_permalink_structure = apply_filters( 'get_default_site_url_filter', get_permalink() );
        
        if ( strpos( $get_permalink_structure, "?" ) ) {
            $wcpoa_attachment_url_arg = '&';
        } else {
            $wcpoa_attachment_url_arg = '?';
        }
        
        $current_date = gmdate( "Y/m/d" );
        $wcpoa_today_date = strtotime( $current_date );
        $wcpoa_today_date_time = current_time( 'Y/m/d H:i:s' );
        $wcpoa_end_div = '';
        $wcpoa_att_values_key = array();
        $tab_title_match = 'no';
        $wcpoa_bulk_att_data = get_option( 'wcpoa_bulk_attachment_data' );
        if ( !empty($items) && is_array( $items ) ) {
            foreach ( $items as $item_id => $item ) {
                $wcpoa_order_attachment_items = wc_get_order_item_meta( $item_id, 'wcpoa_order_attachment_order_arr', true );
            }
        }
        $wcpoa_bulk_att_product_key = array();
        //Bulk Attachment
        if ( !empty($items) ) {
            if ( !empty($wcpoa_bulk_att_data) ) {
                foreach ( $wcpoa_bulk_att_data as $att_new_key => $wcpoa_bulk_att_values ) {
                    if ( !array_key_exists( 'wcpoa_attach_view', $wcpoa_bulk_att_values ) || "enable" === $wcpoa_bulk_att_values['wcpoa_attach_view'] ) {
                        
                        if ( !in_array( $att_new_key, $wcpoa_bulk_att_product_key, true ) ) {
                            $wcpoa_bulk_att_visibility = ( isset( $wcpoa_bulk_att_values['wcpoa_att_visibility'] ) && !empty($wcpoa_bulk_att_values['wcpoa_att_visibility']) ? $wcpoa_bulk_att_values['wcpoa_att_visibility'] : '' );
                            $wcpoa_is_condition = ( isset( $wcpoa_bulk_att_values['wcpoa_is_condition'] ) && !empty($wcpoa_bulk_att_values['wcpoa_is_condition']) ? $wcpoa_bulk_att_values['wcpoa_is_condition'] : '' );
                            $wcpoa_attachments_bulk_id = ( !empty($wcpoa_bulk_att_values['wcpoa_attachments_id']) ? $wcpoa_bulk_att_values['wcpoa_attachments_id'] : '' );
                            $wcpoa_order_status = ( !empty($wcpoa_bulk_att_values['wcpoa_order_status']) ? $wcpoa_bulk_att_values['wcpoa_order_status'] : '' );
                            $wcpoa_order_status_val = str_replace( 'wcpoa-wc-', '', $wcpoa_order_status );
                            $wcpoa_order_status_new = ( !empty($wcpoa_order_status_val) ? $wcpoa_order_status_val : array() );
                            $wcpoa_bulk_att_values_key[] = $att_new_key;
                            $wcpoa_end_div = '';
                            if ( $wcpoa_bulk_att_visibility === 'order_details_page' || $wcpoa_bulk_att_visibility === 'wcpoa_all' ) {
                                if ( empty($wcpoa_order_status_new) || in_array( $items_order_status, $wcpoa_order_status_new, true ) ) {
                                    
                                    if ( $wcpoa_is_condition === 'no' ) {
                                        $wcpoa_att_id = $wcpoa_bulk_att_values['wcpoa_attachments_id'];
                                        if ( empty($wcpoa_attachments_id_bulk) || !in_array( $wcpoa_att_id, $wcpoa_attachments_id_bulk, true ) ) {
                                            $tab_title_match = 'yes';
                                        }
                                    }
                                
                                }
                            }
                        }
                    
                    }
                }
            }
        }
        $wcpoa_checkout_all_ids = get_post_meta( $order_id, '_wcpoa_checkout_attachment_ids', true );
        $wcpoa_bulk_att_values_key = array();
        $wcpoa_bulk_att_product_key = array();
        // User role accessibility
        $user = wp_get_current_user();
        $wcpoa_att_download_restrict_flag = 0;
        $wcpoa_att_download_restrict = get_option( 'wcpoa_att_download_restrict' );
        
        if ( $wcpoa_att_download_restrict === 'wcpoa_att_download_loggedin' ) {
            
            if ( is_user_logged_in() ) {
                $wcpoa_att_download_restrict_flag = 1;
            } else {
                esc_html_e( 'Please Login To Download Attachment', 'woocommerce-product-attachment' );
            }
        
        } elseif ( $wcpoa_att_download_restrict === 'wcpoa_att_download_guest' ) {
            $wcpoa_att_download_restrict_flag = 1;
        }
        
        $wcpoa_att_download_visible_user = $user->roles;
        $prefixed_wcpoa_att_download_visible_user = preg_filter( '/^/', 'wcpoa_att_download_', $wcpoa_att_download_visible_user );
        
        if ( empty($wcpoa_att_download_restrict) ) {
            $wcpoa_att_download_restrict_flag = 1;
            // apply for all users
        } elseif ( in_array( 'wcpoa_att_download_guest', $wcpoa_att_download_restrict, true ) && !is_user_logged_in() ) {
            $wcpoa_att_download_restrict_flag = 1;
            // apply for guest users
        } elseif ( array_intersect( $prefixed_wcpoa_att_download_visible_user, $wcpoa_att_download_restrict ) ) {
            $wcpoa_att_download_restrict_flag = 1;
            // apply for admin user roles which is set by admin side
        } else {
            
            if ( is_user_logged_in() ) {
                esc_html_e( 'Restrict To Download Attachment', 'woocommerce-product-attachment' );
            } else {
                esc_html_e( 'Please Login To Download Attachment', 'woocommerce-product-attachment' );
            }
        
        }
        
        
        if ( (int) $wcpoa_att_download_restrict_flag === 1 ) {
            echo  '<section class="woocommerce-attachment-details">' ;
            do_action( 'before_wcpoa_order_data_show_on_thankyou' );
            
            if ( $tab_title_match === 'yes' || !empty($wcpoa_checkout_all_ids) || !empty($wcpoa_order_attachment_items) ) {
                
                if ( !empty($sitepress) ) {
                    $default_lang = self::$admin_object->wcpoa_get_default_langugae_with_sitpress();
                    $wcpoa_order_tab_name_lang = apply_filters(
                        'wpml_translate_single_string',
                        $wcpoa_order_tab_name,
                        'woocommerce-product-attachment',
                        $wcpoa_order_tab_name,
                        $default_lang
                    );
                } else {
                    $wcpoa_order_tab_name_lang = $wcpoa_order_tab_name;
                }
                
                echo  '<h2 class="woocommerce-order-details__title">' . esc_html( $wcpoa_order_tab_name_lang ) . '</h2>' ;
            }
            
            $wcpoa_attachments_id_bulk = array();
            if ( !empty($items) && is_array( $items ) ) {
                foreach ( $items as $item_id => $item ) {
                    $wcpoa_order_attachment_items = wc_get_order_item_meta( $item_id, 'wcpoa_order_attachment_order_arr', true );
                    
                    if ( !empty($wcpoa_order_attachment_items) ) {
                        $wcpoa_attachment_ids = $wcpoa_order_attachment_items['wcpoa_attachment_ids'];
                        $wcpoa_attachment_name = $wcpoa_order_attachment_items['wcpoa_attachment_name'];
                        $wcpoa_attachment_description = $wcpoa_order_attachment_items['wcpoa_att_order_description'];
                        $wcpoa_attachment_url = $wcpoa_order_attachment_items['wcpoa_attachment_url'];
                        $wcpoa_attach_type = $wcpoa_order_attachment_items['wcpoa_attach_type'];
                        $wcpoa_order_status = $wcpoa_order_attachment_items['wcpoa_order_status'];
                        $wcpoa_expired_date_enable = $wcpoa_order_attachment_items['wcpoa_expired_date_enable'];
                        $wcpoa_order_attachment_expired = $wcpoa_order_attachment_items['wcpoa_order_attachment_expired'];
                        $selected_variation_id = "";
                        $attached_variations = array();
                        
                        if ( !empty($selected_variation_id) && is_array( $attached_variations ) && in_array( (int) $selected_variation_id, convert_array_to_int( $attached_variations ), true ) ) {
                        } else {
                            if ( !empty($wcpoa_attachment_ids) && is_array( $wcpoa_attachment_ids ) ) {
                                //End Woo Product Attachment Order Tab
                                foreach ( $wcpoa_attachment_ids as $key => $wcpoa_attachments_id ) {
                                    if ( !empty($wcpoa_attachments_id) || $wcpoa_attachments_id !== '' ) {
                                        
                                        if ( !in_array( $wcpoa_attachments_id, $wcpoa_att_values_key, true ) ) {
                                            $wcpoa_att_values_key[] = $wcpoa_attachments_id;
                                            $attachment_name = ( isset( $wcpoa_attachment_name[$key] ) && !empty($wcpoa_attachment_name[$key]) ? $wcpoa_attachment_name[$key] : '' );
                                            $wcpoa_attachment_type = ( isset( $wcpoa_attach_type[$key] ) && !empty($wcpoa_attach_type[$key]) ? $wcpoa_attach_type[$key] : '' );
                                            $wcpoa_attachment_file = ( isset( $wcpoa_attachment_url[$key] ) && !empty($wcpoa_attachment_url[$key]) ? $wcpoa_attachment_url[$key] : '' );
                                            $wcpoa_attachment_descriptions = ( isset( $wcpoa_attachment_description[$key] ) && !empty($wcpoa_attachment_description[$key]) ? $wcpoa_attachment_description[$key] : '' );
                                            $wcpoa_order_status_val = ( isset( $wcpoa_order_status[$wcpoa_attachments_id] ) && !empty($wcpoa_order_status[$wcpoa_attachments_id]) && $wcpoa_order_status[$wcpoa_attachments_id] ? $wcpoa_order_status[$wcpoa_attachments_id] : '' );
                                            $wcpoa_order_status_new = str_replace( 'wcpoa-wc-', '', $wcpoa_order_status_val );
                                            $wcpoa_expired_date_enable = ( isset( $wcpoa_expired_date_enable[$key] ) && !empty($wcpoa_expired_date_enable[$key]) ? $wcpoa_expired_date_enable[$key] : '' );
                                            $wcpoa_order_attachment_expired_date = ( isset( $wcpoa_order_attachment_expired[$key] ) && !empty($wcpoa_order_attachment_expired[$key]) ? $wcpoa_order_attachment_expired[$key] : '' );
                                            $wcpoa_attachment_time_amount_concate_single = "";
                                            $attachment_id = $wcpoa_attachment_file;
                                            // ID of attachment
                                            $wcpoa_attachment_expired_date = strtotime( $wcpoa_order_attachment_expired_date );
                                            $wcpoa_att_btn = __( 'Download', 'woocommerce-product-attachment' );
                                            $wcpoa_att_ex_btn = __( 'Download', 'woocommerce-product-attachment' );
                                            
                                            if ( !empty($wcpoa_download_type) && 'download_by_link' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                $attachment_order_name = '<h4 class="wcpoa_attachment_name"><a class="wcpoa_title_with_link" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $attachment_id . '&download_file=' . $wcpoa_attachments_id . '&wcpoa_attachment_order_id=' . $items_order_id . '" rel="nofollow"' . $is_download . '>' . __( $attachment_name, 'woocommerce-product-attachment' ) . '</a></h4>';
                                            } else {
                                                $attachment_order_name = '<h4 class="wcpoa_attachment_name">' . __( $attachment_name, 'woocommerce-product-attachment' ) . '</h4>';
                                            }
                                            
                                            $wcpoa_file_url_btn = '<a class="wcpoa_attachmentbtn" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $attachment_id . '&download_file=' . $wcpoa_attachments_id . '&wcpoa_attachment_order_id=' . $items_order_id . '" rel="nofollow">' . $wcpoa_att_btn . '</a>';
                                            $wcpoa_file_expired_url_btn = '<a class="wcpoa_order_attachment_expire" rel="nofollow">' . $wcpoa_att_ex_btn . '</a>';
                                            if ( !empty($wcpoa_download_type) && 'download_by_link' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                $attachment_expired_order_name = '<h4 class="wcpoa_attachment_name"><a class="wcpoa_title_with_link wcpoa_expired_title_with_link" rel="nofollow">' . __( $attachment_name, 'woocommerce-product-attachment' ) . '</a></h4>';
                                            }
                                            $wcpoa_order_attachment_descriptions = '<p class="wcpoa_attachment_desc">' . __( $wcpoa_attachment_descriptions, 'woocommerce-product-attachment' ) . '</p>';
                                            
                                            if ( $wcpoa_expired_date_tlabel === 'no' ) {
                                                $wcpoa_expire_date_text = '';
                                                $wcpoa_expired_date_text = '';
                                            } else {
                                                $wcpoa_expire_date_text = '<p class="order_att_expire_date"><span>*</span>' . __( 'This Attachment Expiry Date : ', 'woocommerce-product-attachment' ) . $wcpoa_order_attachment_expired_date . '</p>';
                                                $wcpoa_expired_date_text = '<p class="order_att_expire_date"><span>*</span>' . __( 'This Attachment Expired', 'woocommerce-product-attachment' ) . '</p>';
                                            }
                                            
                                            
                                            if ( !empty($wcpoa_order_status_new) ) {
                                                
                                                if ( !empty($wcpoa_attachment_expired_date) && $wcpoa_expired_date_enable === "yes" ) {
                                                    
                                                    if ( $wcpoa_today_date > $wcpoa_attachment_expired_date ) {
                                                        
                                                        if ( in_array( $items_order_status, $wcpoa_order_status_new, true ) ) {
                                                            
                                                            if ( !empty($wcpoa_download_type) && 'download_by_link' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                                echo  wp_kses( $attachment_expired_order_name, $this->allowed_html_tags() ) ;
                                                            } else {
                                                                echo  wp_kses( $attachment_order_name, $this->allowed_html_tags() ) ;
                                                            }
                                                            
                                                            if ( !empty($wcpoa_download_type) && 'download_by_btn' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                                echo  wp_kses( $wcpoa_file_expired_url_btn, $this->allowed_html_tags() ) ;
                                                            }
                                                            echo  wp_kses( $wcpoa_order_attachment_descriptions, $this->allowed_html_tags() ) ;
                                                            echo  wp_kses( $wcpoa_expired_date_text, $this->allowed_html_tags() ) ;
                                                            $tab_title_match = 'yes';
                                                        }
                                                    
                                                    } else {
                                                        
                                                        if ( in_array( $items_order_status, $wcpoa_order_status_new, true ) ) {
                                                            echo  wp_kses( $attachment_order_name, $this->allowed_html_tags() ) ;
                                                            if ( !empty($wcpoa_download_type) && 'download_by_btn' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                                echo  wp_kses( $wcpoa_file_url_btn, $this->allowed_html_tags() ) ;
                                                            }
                                                            echo  wp_kses( $wcpoa_order_attachment_descriptions, $this->allowed_html_tags() ) ;
                                                            echo  wp_kses( $wcpoa_expire_date_text, $this->allowed_html_tags() ) ;
                                                            $tab_title_match = 'yes';
                                                        }
                                                    
                                                    }
                                                
                                                } elseif ( !empty($wcpoa_attachment_time_amount_concate_single) && $wcpoa_expired_date_enable === "time_amount" ) {
                                                } else {
                                                    
                                                    if ( in_array( $items_order_status, $wcpoa_order_status_new, true ) ) {
                                                        echo  wp_kses( $attachment_order_name, $this->allowed_html_tags() ) ;
                                                        if ( !empty($wcpoa_download_type) && 'download_by_btn' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                            echo  wp_kses( $wcpoa_file_url_btn, $this->allowed_html_tags() ) ;
                                                        }
                                                        echo  wp_kses( $wcpoa_order_attachment_descriptions, $this->allowed_html_tags() ) ;
                                                        $tab_title_match = 'yes';
                                                    }
                                                
                                                }
                                            
                                            } else {
                                                
                                                if ( !empty($wcpoa_attachment_expired_date) && $wcpoa_expired_date_enable === "yes" ) {
                                                    
                                                    if ( $wcpoa_today_date > $wcpoa_attachment_expired_date ) {
                                                        
                                                        if ( !empty($wcpoa_download_type) && 'download_by_link' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                            echo  wp_kses( $attachment_expired_order_name, $this->allowed_html_tags() ) ;
                                                        } else {
                                                            echo  wp_kses( $attachment_order_name, $this->allowed_html_tags() ) ;
                                                        }
                                                        
                                                        if ( !empty($wcpoa_download_type) && 'download_by_btn' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                            echo  wp_kses( $wcpoa_file_expired_url_btn, $this->allowed_html_tags() ) ;
                                                        }
                                                        echo  wp_kses( $wcpoa_order_attachment_descriptions, $this->allowed_html_tags() ) ;
                                                        echo  wp_kses( $wcpoa_expired_date_text, $this->allowed_html_tags() ) ;
                                                        $tab_title_match = 'yes';
                                                    } else {
                                                        echo  wp_kses( $attachment_order_name, $this->allowed_html_tags() ) ;
                                                        if ( !empty($wcpoa_download_type) && 'download_by_btn' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                            echo  wp_kses( $wcpoa_file_url_btn, $this->allowed_html_tags() ) ;
                                                        }
                                                        echo  wp_kses( $wcpoa_order_attachment_descriptions, $this->allowed_html_tags() ) ;
                                                        $tab_title_match = 'yes';
                                                    }
                                                
                                                } elseif ( !empty($wcpoa_attachment_time_amount_concate_single) && $wcpoa_expired_date_enable === "time_amount" ) {
                                                } else {
                                                    echo  wp_kses( $attachment_order_name, $this->allowed_html_tags() ) ;
                                                    if ( !empty($wcpoa_download_type) && 'download_by_btn' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                        echo  wp_kses( $wcpoa_file_url_btn, $this->allowed_html_tags() ) ;
                                                    }
                                                    echo  wp_kses( $wcpoa_order_attachment_descriptions, $this->allowed_html_tags() ) ;
                                                    $tab_title_match = 'yes';
                                                }
                                            
                                            }
                                            
                                            echo  wp_kses( $wcpoa_end_div, $this->allowed_html_tags() ) ;
                                        }
                                    
                                    }
                                }
                            }
                        }
                    
                    }
                    
                    //Bulk Attachment
                    if ( !empty($items) ) {
                        if ( !empty($wcpoa_bulk_att_data) ) {
                            foreach ( $wcpoa_bulk_att_data as $att_new_key => $wcpoa_bulk_att_values ) {
                                if ( !array_key_exists( 'wcpoa_attach_view', $wcpoa_bulk_att_values ) || "enable" === $wcpoa_bulk_att_values['wcpoa_attach_view'] ) {
                                    
                                    if ( !in_array( $att_new_key, $wcpoa_bulk_att_product_key, true ) ) {
                                        $wcpoa_bulk_att_visibility = ( isset( $wcpoa_bulk_att_values['wcpoa_att_visibility'] ) && !empty($wcpoa_bulk_att_values['wcpoa_att_visibility']) ? $wcpoa_bulk_att_values['wcpoa_att_visibility'] : '' );
                                        $wcpoa_is_condition = ( isset( $wcpoa_bulk_att_values['wcpoa_is_condition'] ) && !empty($wcpoa_bulk_att_values['wcpoa_is_condition']) ? $wcpoa_bulk_att_values['wcpoa_is_condition'] : '' );
                                        $wcpoa_attachments_bulk_id = ( !empty($wcpoa_bulk_att_values['wcpoa_attachments_id']) ? $wcpoa_bulk_att_values['wcpoa_attachments_id'] : '' );
                                        $wcpoa_bulk_attachments_name = ( isset( $wcpoa_bulk_att_values['wcpoa_attachment_name'] ) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_name']) ? $wcpoa_bulk_att_values['wcpoa_attachment_name'] : '' );
                                        $wcpoa_bulk_attachment_type = ( isset( $wcpoa_bulk_att_values['wcpoa_attach_type'] ) && !empty($wcpoa_bulk_att_values['wcpoa_attach_type']) ? $wcpoa_bulk_att_values['wcpoa_attach_type'] : '' );
                                        $wcpoa_bulk_attachment_file = ( isset( $wcpoa_bulk_att_values['wcpoa_attachment_file'] ) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_file']) ? $wcpoa_bulk_att_values['wcpoa_attachment_file'] : '' );
                                        $wcpoa_attachment_descriptions = ( isset( $wcpoa_bulk_att_values['wcpoa_attachment_description'] ) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_description']) ? $wcpoa_bulk_att_values['wcpoa_attachment_description'] : '' );
                                        $wcpoa_expired_date_enable = ( isset( $wcpoa_bulk_att_values['wcpoa_expired_date_enable'] ) && !empty($wcpoa_bulk_att_values['wcpoa_expired_date_enable']) ? $wcpoa_bulk_att_values['wcpoa_expired_date_enable'] : '' );
                                        $wcpoa_expired_dates = ( isset( $wcpoa_bulk_att_values['wcpoa_expired_date'] ) && !empty($wcpoa_bulk_att_values['wcpoa_expired_date']) ? $wcpoa_bulk_att_values['wcpoa_expired_date'] : '' );
                                        $wcpoa_order_status = ( isset( $wcpoa_bulk_att_values['wcpoa_order_status'] ) && !empty($wcpoa_bulk_att_values['wcpoa_order_status']) ? $wcpoa_bulk_att_values['wcpoa_order_status'] : '' );
                                        
                                        if ( isset( $wcpoa_bulk_attachment_file ) ) {
                                            $attachment_id = $wcpoa_bulk_attachment_file;
                                            $wcpoa_attachments_type = get_post_mime_type( $attachment_id );
                                            $wcpoa_mime_type = explode( '/', $wcpoa_attachments_type );
                                            $wcpoa_att_type = $wcpoa_mime_type['0'];
                                        } else {
                                            $wcpoa_attachments_type = 'default';
                                            $wcpoa_att_type = 'default';
                                        }
                                        
                                        $wcpoa_attachments_icons = WCPOA_PLUGIN_URL . 'public/images/default.png';
                                        $wcpoa_attachments_expired_icons = WCPOA_PLUGIN_URL . 'public/images/expired.png';
                                        
                                        if ( $wcpoa_att_type === 'image' ) {
                                            $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/image.png';
                                        } elseif ( $wcpoa_attachments_type === 'text/csv' ) {
                                            $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/csv.png';
                                        } elseif ( $wcpoa_att_type === 'video' ) {
                                            $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/video.png';
                                        } elseif ( $wcpoa_attachments_type === 'text/xml' ) {
                                            $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/xml.png';
                                        } elseif ( $wcpoa_attachments_type === 'text/doc' ) {
                                            $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/doc.png';
                                        } else {
                                            $wcpoa_attachments_icon = $wcpoa_attachments_icons;
                                        }
                                        
                                        $wcpoa_att_btn = __( 'Download', 'woocommerce-product-attachment' );
                                        $wcpoa_att_ex_btn = __( 'Download', 'woocommerce-product-attachment' );
                                        
                                        if ( !empty($wcpoa_download_type) && 'download_by_link' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                            $wcpoa_attachments_name = '<h4 class="wcpoa_attachment_name"><a class="wcpoa_title_with_link" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $wcpoa_bulk_attachment_file . '&download_file=' . $wcpoa_attachments_bulk_id . '&wcpoa_attachment_order_id=' . $items_order_id . '" rel="nofollow"' . $is_download . '>' . esc_html__( $wcpoa_bulk_attachments_name, 'woocommerce-product-attachment' ) . '</a></h4>';
                                        } else {
                                            $wcpoa_attachments_name = '<h4 class="wcpoa_attachment_name">' . esc_html__( $wcpoa_bulk_attachments_name, 'woocommerce-product-attachment' ) . '</h4>';
                                        }
                                        
                                        $wcpoa_bulk_file_url_btn = '<a class="wcpoa_attachmentbtn" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $wcpoa_bulk_attachment_file . '&download_file=' . $wcpoa_attachments_bulk_id . '&wcpoa_attachment_order_id=' . $items_order_id . '" rel="nofollow">' . $wcpoa_att_btn . '</a>';
                                        if ( !empty($wcpoa_download_type) && 'download_by_link' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                            $wcpoa_expired_attachments_name = '<h4 class="wcpoa_attachment_name"><a class="wcpoa_title_with_link wcpoa_expired_title_with_link" rel="nofollow">' . esc_html__( $wcpoa_bulk_attachments_name, 'woocommerce-product-attachment' ) . '</a></h4>';
                                        }
                                        $wcpoa_bulk_file_expired_url_btn = '<a class="wcpoa_order_attachment_expire" rel="nofollow"> ' . $wcpoa_att_ex_btn . ' </a>';
                                        $wcpoa_attachment_descriptions = '<p class="wcpoa_attachment_desc">' . __( $wcpoa_attachment_descriptions, 'woocommerce-product-attachment' ) . '</p>';
                                        $wcpoa_bulk_expired_date_text = '<p class="order_att_expire_date">' . __( 'This Attachment Expired.', 'woocommerce-product-attachment' ) . '</p>';
                                        $wcpoa_bulk_expire_date_text = '<p class="order_att_expire_date">' . __( 'This Attachment Expiry Date : ', 'woocommerce-product-attachment' ) . $wcpoa_expired_dates . '</p>';
                                        $wcpoa_attachment_expired_date = strtotime( $wcpoa_expired_dates );
                                        $wcpoa_order_status_val = str_replace( 'wcpoa-wc-', '', $wcpoa_order_status );
                                        $wcpoa_order_status_new = ( !empty($wcpoa_order_status_val) ? $wcpoa_order_status_val : array() );
                                        $wcpoa_bulk_att_values_key[] = $att_new_key;
                                        $wcpoa_end_div = '';
                                        if ( $wcpoa_bulk_att_visibility === 'order_details_page' || $wcpoa_bulk_att_visibility === 'wcpoa_all' ) {
                                            if ( empty($wcpoa_order_status_new) || in_array( $items_order_status, $wcpoa_order_status_new, true ) ) {
                                                
                                                if ( $wcpoa_is_condition === 'no' ) {
                                                    $wcpoa_att_id = $wcpoa_bulk_att_values['wcpoa_attachments_id'];
                                                    
                                                    if ( empty($wcpoa_attachments_id_bulk) || !in_array( $wcpoa_att_id, $wcpoa_attachments_id_bulk, true ) ) {
                                                        $wcpoa_attachments_id_bulk[] = $wcpoa_bulk_att_values['wcpoa_attachments_id'];
                                                        
                                                        if ( !empty($wcpoa_attachment_expired_date) && $wcpoa_expired_date_enable === 'yes' ) {
                                                            
                                                            if ( $wcpoa_today_date > $wcpoa_attachment_expired_date ) {
                                                                
                                                                if ( !empty($wcpoa_download_type) && 'download_by_link' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                                    echo  wp_kses( $wcpoa_expired_attachments_name, $this->allowed_html_tags() ) ;
                                                                } else {
                                                                    echo  wp_kses( $wcpoa_attachments_name, $this->allowed_html_tags() ) ;
                                                                }
                                                                
                                                                if ( !empty($wcpoa_download_type) && 'download_by_btn' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                                    echo  wp_kses( $wcpoa_bulk_file_expired_url_btn, $this->allowed_html_tags() ) ;
                                                                }
                                                                echo  wp_kses( $wcpoa_attachment_descriptions, $this->allowed_html_tags() ) ;
                                                                echo  wp_kses( $wcpoa_bulk_expired_date_text, $this->allowed_html_tags() ) ;
                                                                $tab_title_match = 'yes';
                                                            } else {
                                                                echo  wp_kses( $wcpoa_attachments_name, $this->allowed_html_tags() ) ;
                                                                if ( !empty($wcpoa_download_type) && 'download_by_btn' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                                    echo  wp_kses( $wcpoa_bulk_file_url_btn, $this->allowed_html_tags() ) ;
                                                                }
                                                                echo  wp_kses( $wcpoa_attachment_descriptions, $this->allowed_html_tags() ) ;
                                                                echo  wp_kses( $wcpoa_bulk_expire_date_text, $this->allowed_html_tags() ) ;
                                                                $tab_title_match = 'yes';
                                                            }
                                                        
                                                        } else {
                                                            echo  wp_kses( $wcpoa_attachments_name, $this->allowed_html_tags() ) ;
                                                            if ( !empty($wcpoa_download_type) && 'download_by_btn' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                                echo  wp_kses( $wcpoa_bulk_file_url_btn, $this->allowed_html_tags() ) ;
                                                            }
                                                            echo  wp_kses( $wcpoa_attachment_descriptions, $this->allowed_html_tags() ) ;
                                                            $tab_title_match = 'yes';
                                                        }
                                                    
                                                    }
                                                
                                                }
                                            
                                            }
                                        }
                                        echo  wp_kses( $wcpoa_end_div, $this->allowed_html_tags() ) ;
                                    }
                                
                                }
                            }
                        }
                    }
                }
            }
            $wcpoa_checkout_all_ids = get_post_meta( $order_id, '_wcpoa_checkout_attachment_ids', true );
            
            if ( !empty($wcpoa_checkout_all_ids) && "" !== $wcpoa_checkout_all_ids ) {
                $id_checkout_array = explode( ",", $wcpoa_checkout_all_ids );
                foreach ( $id_checkout_array as $wcpoa_checkout_id ) {
                    $media_name_checkout = get_the_title( $wcpoa_checkout_id );
                    
                    if ( !empty($wcpoa_download_type) && 'download_by_link' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                        $wcpoa_attachments_name_chk = '<h4 class="wcpoa_attachment_name"><a class="wcpoa_title_with_link" href="' . get_permalink() . '?post_type=shop_order&p=' . $order_id . '&attachment_id=' . $wcpoa_checkout_id . '&wcpoa_attachment_order_id=' . $order_id . '" >' . esc_html__( $media_name_checkout, 'woocommerce-product-attachment' ) . '</a></h4>';
                    } else {
                        $wcpoa_attachments_name_chk = '<h4 class="wcpoa_attachment_name">' . esc_html__( $media_name_checkout, 'woocommerce-product-attachment' ) . '</h4>';
                    }
                    
                    $wcpoa_bulk_file_url_btn_chk = '<a class="wcpoa_attachmentbtn" href="' . get_permalink() . '?post_type=shop_order&p=' . $order_id . '&attachment_id=' . $wcpoa_checkout_id . '&wcpoa_attachment_order_id=' . $order_id . '" > Download </a>';
                    $wcpoa_attachment_descriptions_chk = '<p class="wcpoa_attachment_desc"></p>';
                    echo  wp_kses( $wcpoa_attachments_name_chk, $this->allowed_html_tags() ) ;
                    if ( !empty($wcpoa_download_type) && 'download_by_btn' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                        echo  wp_kses( $wcpoa_bulk_file_url_btn_chk, $this->allowed_html_tags() ) ;
                    }
                    echo  wp_kses( $wcpoa_attachment_descriptions_chk, $this->allowed_html_tags() ) ;
                    $tab_title_match = 'yes';
                }
            }
            
            echo  '</section>' ;
            do_action( 'after_wcpoa_order_data_show_on_thankyou' );
        }
        
        return null;
    }
    
    /**
     * Product attachments data show on my account page.
     *
     * @since    1.0.0
     * @access   public
     */
    public function wcpoa_order_data_show_my_account( $order_id )
    {
        global  $sitepress ;
        $order = new WC_Order( $order_id );
        $order_data = $order->get_data();
        $order_time = $order_data['date_created']->date( 'Y/m/d H:i:s' );
        $items = $order->get_items( array( 'line_item' ) );
        $items_order_status = $order->get_status();
        $items_order_id = $order_id;
        $wcpoa_order_tab_name = get_option( 'wcpoa_order_tab_name' );
        //wcpoa order tab option name
        $wcpoa_expired_date_tlabel = get_option( 'wcpoa_expired_date_label' );
        $get_permalink_structure = get_permalink();
        
        if ( strpos( $get_permalink_structure, "?" ) ) {
            $wcpoa_attachment_url_arg = '&';
        } else {
            $wcpoa_attachment_url_arg = '?';
        }
        
        $current_date = gmdate( "Y/m/d" );
        $wcpoa_today_date = strtotime( $current_date );
        $wcpoa_today_date_time = current_time( 'Y/m/d H:i:s' );
        $wcpoa_end_div = '';
        $wcpoa_att_values_key = array();
        $tab_title_match = 'no';
        $wcpoa_bulk_att_data = get_option( 'wcpoa_bulk_attachment_data' );
        $wcpoa_bulk_att_values_key = array();
        $wcpoa_bulk_att_product_key = array();
        if ( !empty($items) && is_array( $items ) ) {
            foreach ( $items as $item_id => $item ) {
                $wcpoa_order_attachment_items = wc_get_order_item_meta( $item_id, 'wcpoa_order_attachment_order_arr', true );
            }
        }
        $wcpoa_bulk_att_product_key = array();
        //Bulk Attachment
        if ( !empty($items) ) {
            if ( !empty($wcpoa_bulk_att_data) ) {
                foreach ( $wcpoa_bulk_att_data as $att_new_key => $wcpoa_bulk_att_values ) {
                    if ( !array_key_exists( 'wcpoa_attach_view', $wcpoa_bulk_att_values ) || "enable" === $wcpoa_bulk_att_values['wcpoa_attach_view'] ) {
                        
                        if ( !in_array( $att_new_key, $wcpoa_bulk_att_product_key, true ) ) {
                            $wcpoa_bulk_att_visibility = ( isset( $wcpoa_bulk_att_values['wcpoa_att_visibility'] ) && !empty($wcpoa_bulk_att_values['wcpoa_att_visibility']) ? $wcpoa_bulk_att_values['wcpoa_att_visibility'] : '' );
                            $wcpoa_is_condition = ( isset( $wcpoa_bulk_att_values['wcpoa_is_condition'] ) && !empty($wcpoa_bulk_att_values['wcpoa_is_condition']) ? $wcpoa_bulk_att_values['wcpoa_is_condition'] : '' );
                            $wcpoa_attachments_bulk_id = ( !empty($wcpoa_bulk_att_values['wcpoa_attachments_id']) ? $wcpoa_bulk_att_values['wcpoa_attachments_id'] : '' );
                            $wcpoa_order_status = ( isset( $wcpoa_bulk_att_values['wcpoa_order_status'] ) && !empty($wcpoa_bulk_att_values['wcpoa_order_status']) ? $wcpoa_bulk_att_values['wcpoa_order_status'] : '' );
                            $wcpoa_order_status_val = str_replace( 'wcpoa-wc-', '', $wcpoa_order_status );
                            $wcpoa_order_status_new = ( !empty($wcpoa_order_status_val) ? $wcpoa_order_status_val : array() );
                            $wcpoa_bulk_att_values_key[] = $att_new_key;
                            $wcpoa_end_div = '';
                            if ( $wcpoa_bulk_att_visibility === 'order_details_page' || $wcpoa_bulk_att_visibility === 'wcpoa_all' ) {
                                if ( empty($wcpoa_order_status_new) || in_array( $items_order_status, $wcpoa_order_status_new, true ) ) {
                                    
                                    if ( $wcpoa_is_condition === 'no' ) {
                                        $wcpoa_att_id = $wcpoa_bulk_att_values['wcpoa_attachments_id'];
                                        if ( empty($wcpoa_attachments_id_bulk) || !in_array( $wcpoa_att_id, $wcpoa_attachments_id_bulk, true ) ) {
                                            $tab_title_match = 'yes';
                                        }
                                    }
                                
                                }
                            }
                        }
                    
                    }
                }
            }
        }
        // get checkout page attachment ids
        $wcpoa_checkout_all_ids = get_post_meta( $order_id, '_wcpoa_checkout_attachment_ids', true );
        // get attachment download type
        $wcpoa_download_type = get_option( 'wcpoa_product_download_type' );
        // User role accessibility
        $user = wp_get_current_user();
        $wcpoa_att_download_restrict_flag = 0;
        $wcpoa_att_download_restrict = get_option( 'wcpoa_att_download_restrict' );
        
        if ( $wcpoa_att_download_restrict === 'wcpoa_att_download_loggedin' ) {
            
            if ( is_user_logged_in() ) {
                $wcpoa_att_download_restrict_flag = 1;
            } else {
                esc_html_e( 'Please Login To Download Attachment', 'woocommerce-product-attachment' );
            }
        
        } elseif ( $wcpoa_att_download_restrict === 'wcpoa_att_download_guest' ) {
            $wcpoa_att_download_restrict_flag = 1;
        }
        
        $wcpoa_att_download_visible_user = $user->roles;
        $prefixed_wcpoa_att_download_visible_user = preg_filter( '/^/', 'wcpoa_att_download_', $wcpoa_att_download_visible_user );
        
        if ( empty($wcpoa_att_download_restrict) ) {
            $wcpoa_att_download_restrict_flag = 1;
            // apply for all users
        } elseif ( in_array( 'wcpoa_att_download_guest', $wcpoa_att_download_restrict, true ) && !is_user_logged_in() ) {
            $wcpoa_att_download_restrict_flag = 1;
            // apply for guest users
        } elseif ( array_intersect( $prefixed_wcpoa_att_download_visible_user, $wcpoa_att_download_restrict ) ) {
            $wcpoa_att_download_restrict_flag = 1;
            // apply for admin user roles which is set by admin side
        } else {
            
            if ( is_user_logged_in() ) {
                esc_html_e( 'Restrict To Download Attachment', 'woocommerce-product-attachment' );
            } else {
                esc_html_e( 'Please Login To Download Attachment', 'woocommerce-product-attachment' );
            }
        
        }
        
        
        if ( (int) $wcpoa_att_download_restrict_flag === 1 ) {
            echo  '<section class="woocommerce-attachment-details">' ;
            do_action( 'before_wcpoa_order_data_show_my_account' );
            
            if ( $tab_title_match === 'yes' || !empty($wcpoa_checkout_all_ids) || !empty($wcpoa_order_attachment_items) ) {
                
                if ( !empty($sitepress) ) {
                    $default_lang = self::$admin_object->wcpoa_get_default_langugae_with_sitpress();
                    $wcpoa_order_tab_name_lang = apply_filters(
                        'wpml_translate_single_string',
                        $wcpoa_order_tab_name,
                        'woocommerce-product-attachment',
                        $wcpoa_order_tab_name,
                        $default_lang
                    );
                } else {
                    $wcpoa_order_tab_name_lang = $wcpoa_order_tab_name;
                }
                
                echo  '<h2 class="woocommerce-order-details__title">' . esc_html( $wcpoa_order_tab_name_lang ) . '</h2>' ;
            }
            
            $wcpoa_attachments_id_bulk = array();
            if ( !empty($items) && is_array( $items ) ) {
                foreach ( $items as $item_id => $item ) {
                    $wcpoa_order_attachment_items = wc_get_order_item_meta( $item_id, 'wcpoa_order_attachment_order_arr', true );
                    
                    if ( !empty($wcpoa_order_attachment_items) ) {
                        $wcpoa_attachment_ids = $wcpoa_order_attachment_items['wcpoa_attachment_ids'];
                        $wcpoa_attachment_name = $wcpoa_order_attachment_items['wcpoa_attachment_name'];
                        $wcpoa_attachment_description = $wcpoa_order_attachment_items['wcpoa_att_order_description'];
                        $wcpoa_attachment_url = $wcpoa_order_attachment_items['wcpoa_attachment_url'];
                        $wcpoa_attach_type = $wcpoa_order_attachment_items['wcpoa_attach_type'];
                        $wcpoa_order_status = $wcpoa_order_attachment_items['wcpoa_order_status'];
                        $wcpoa_expired_date_enable = $wcpoa_order_attachment_items['wcpoa_expired_date_enable'];
                        $wcpoa_order_attachment_expired = $wcpoa_order_attachment_items['wcpoa_order_attachment_expired'];
                        $selected_variation_id = "";
                        $attached_variations = array();
                        
                        if ( !empty($selected_variation_id) && is_array( $attached_variations ) && in_array( (int) $selected_variation_id, convert_array_to_int( $attached_variations ), true ) ) {
                        } else {
                            if ( !empty($wcpoa_attachment_ids) && is_array( $wcpoa_attachment_ids ) ) {
                                //End Woo Product Attachment Order Tab
                                foreach ( $wcpoa_attachment_ids as $key => $wcpoa_attachments_id ) {
                                    if ( !empty($wcpoa_attachments_id) || $wcpoa_attachments_id !== '' ) {
                                        
                                        if ( !in_array( $wcpoa_attachments_id, $wcpoa_att_values_key, true ) ) {
                                            $wcpoa_att_values_key[] = $wcpoa_attachments_id;
                                            $attachment_name = ( isset( $wcpoa_attachment_name[$key] ) && !empty($wcpoa_attachment_name[$key]) ? $wcpoa_attachment_name[$key] : '' );
                                            $wcpoa_attachment_type = ( isset( $wcpoa_attach_type[$key] ) && !empty($wcpoa_attach_type[$key]) ? $wcpoa_attach_type[$key] : '' );
                                            $wcpoa_attachment_file = ( isset( $wcpoa_attachment_url[$key] ) && !empty($wcpoa_attachment_url[$key]) ? $wcpoa_attachment_url[$key] : '' );
                                            $wcpoa_attachment_descriptions = ( isset( $wcpoa_attachment_description[$key] ) && !empty($wcpoa_attachment_description[$key]) ? $wcpoa_attachment_description[$key] : '' );
                                            $wcpoa_order_status_val = ( isset( $wcpoa_order_status[$wcpoa_attachments_id] ) && !empty($wcpoa_order_status[$wcpoa_attachments_id]) && $wcpoa_order_status[$wcpoa_attachments_id] ? $wcpoa_order_status[$wcpoa_attachments_id] : '' );
                                            $wcpoa_order_status_new = str_replace( 'wcpoa-wc-', '', $wcpoa_order_status_val );
                                            $wcpoa_expired_date_enable = ( isset( $wcpoa_expired_date_enable[$key] ) && !empty($wcpoa_expired_date_enable[$key]) ? $wcpoa_expired_date_enable[$key] : '' );
                                            $wcpoa_order_attachment_expired_date = ( isset( $wcpoa_order_attachment_expired[$key] ) && !empty($wcpoa_order_attachment_expired[$key]) ? $wcpoa_order_attachment_expired[$key] : '' );
                                            $wcpoa_attachment_time_amount_concate_single = "";
                                            $attachment_id = $wcpoa_attachment_file;
                                            // ID of attachment
                                            $wcpoa_attachment_expired_date = strtotime( $wcpoa_order_attachment_expired_date );
                                            $wcpoa_att_btn = __( 'Download', 'woocommerce-product-attachment' );
                                            $wcpoa_att_ex_btn = __( 'Download', 'woocommerce-product-attachment' );
                                            
                                            if ( !empty($wcpoa_download_type) && 'download_by_link' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                $attachment_order_name = '<h4 class="wcpoa_attachment_name"><a class="wcpoa_title_with_link" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $attachment_id . '&download_file=' . $wcpoa_attachments_id . '&wcpoa_attachment_order_id=' . $items_order_id . '" rel="nofollow">' . __( $attachment_name, 'woocommerce-product-attachment' ) . '</a></h4>';
                                            } else {
                                                $attachment_order_name = '<h4 class="wcpoa_attachment_name">' . __( $attachment_name, 'woocommerce-product-attachment' ) . '</h4>';
                                            }
                                            
                                            $wcpoa_file_url_btn = '<a class="wcpoa_attachmentbtn" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $attachment_id . '&download_file=' . $wcpoa_attachments_id . '&wcpoa_attachment_order_id=' . $items_order_id . '" rel="nofollow">' . $wcpoa_att_btn . '</a>';
                                            if ( !empty($wcpoa_download_type) && 'download_by_link' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                $wcpoa_expired_attachments_name = '<h4 class="wcpoa_attachment_name"><a class="wcpoa_title_with_link wcpoa_expired_title_with_link"> ' . __( $attachment_name, 'woocommerce-product-attachment' ) . ' </a></h4>';
                                            }
                                            $wcpoa_file_expired_url_btn = '<a class="wcpoa_order_attachment_expire" rel="nofollow">' . $wcpoa_att_ex_btn . '</a>';
                                            $wcpoa_order_attachment_descriptions = '<p class="wcpoa_attachment_desc">' . __( $wcpoa_attachment_descriptions, 'woocommerce-product-attachment' ) . '</p>';
                                            
                                            if ( $wcpoa_expired_date_tlabel === 'no' ) {
                                                $wcpoa_expire_date_text = '';
                                                $wcpoa_expired_date_text = '';
                                            } else {
                                                $wcpoa_expire_date_text = '<p class="order_att_expire_date"><span>*</span>' . __( 'This Attachment Expiry Date : ', 'woocommerce-product-attachment' ) . $wcpoa_order_attachment_expired_date . '</p>';
                                                $wcpoa_expired_date_text = '<p class="order_att_expire_date"><span>*</span>' . __( 'This Attachment Expired', 'woocommerce-product-attachment' ) . '</p>';
                                            }
                                            
                                            
                                            if ( !empty($wcpoa_order_status_new) ) {
                                                
                                                if ( !empty($wcpoa_attachment_expired_date) && $wcpoa_expired_date_enable === "yes" ) {
                                                    
                                                    if ( $wcpoa_today_date > $wcpoa_attachment_expired_date ) {
                                                        
                                                        if ( in_array( $items_order_status, $wcpoa_order_status_new, true ) ) {
                                                            
                                                            if ( !empty($wcpoa_download_type) && 'download_by_link' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                                echo  wp_kses( $wcpoa_expired_attachments_name, $this->allowed_html_tags() ) ;
                                                            } else {
                                                                echo  wp_kses( $attachment_order_name, $this->allowed_html_tags() ) ;
                                                            }
                                                            
                                                            if ( !empty($wcpoa_download_type) && 'download_by_btn' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                                echo  wp_kses( $wcpoa_file_expired_url_btn, $this->allowed_html_tags() ) ;
                                                            }
                                                            echo  wp_kses( $wcpoa_order_attachment_descriptions, $this->allowed_html_tags() ) ;
                                                            echo  wp_kses( $wcpoa_expired_date_text, $this->allowed_html_tags() ) ;
                                                            $tab_title_match = 'yes';
                                                        }
                                                    
                                                    } else {
                                                        
                                                        if ( in_array( $items_order_status, $wcpoa_order_status_new, true ) ) {
                                                            echo  wp_kses( $attachment_order_name, $this->allowed_html_tags() ) ;
                                                            if ( !empty($wcpoa_download_type) && 'download_by_btn' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                                echo  wp_kses( $wcpoa_file_url_btn, $this->allowed_html_tags() ) ;
                                                            }
                                                            echo  wp_kses( $wcpoa_order_attachment_descriptions, $this->allowed_html_tags() ) ;
                                                            echo  wp_kses( $wcpoa_expire_date_text, $this->allowed_html_tags() ) ;
                                                            $tab_title_match = 'yes';
                                                        }
                                                    
                                                    }
                                                
                                                } elseif ( !empty($wcpoa_attachment_time_amount_concate_single) && $wcpoa_expired_date_enable === "time_amount" ) {
                                                } else {
                                                    
                                                    if ( in_array( $items_order_status, $wcpoa_order_status_new, true ) ) {
                                                        echo  wp_kses( $attachment_order_name, $this->allowed_html_tags() ) ;
                                                        if ( !empty($wcpoa_download_type) && 'download_by_btn' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                            echo  wp_kses( $wcpoa_file_url_btn, $this->allowed_html_tags() ) ;
                                                        }
                                                        echo  wp_kses( $wcpoa_order_attachment_descriptions, $this->allowed_html_tags() ) ;
                                                        $tab_title_match = 'yes';
                                                    }
                                                
                                                }
                                            
                                            } else {
                                                
                                                if ( !empty($wcpoa_attachment_expired_date) && $wcpoa_expired_date_enable === "yes" ) {
                                                    
                                                    if ( $wcpoa_today_date > $wcpoa_attachment_expired_date ) {
                                                        
                                                        if ( !empty($wcpoa_download_type) && 'download_by_link' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                            echo  wp_kses( $wcpoa_expired_attachments_name, $this->allowed_html_tags() ) ;
                                                        } else {
                                                            echo  wp_kses( $attachment_order_name, $this->allowed_html_tags() ) ;
                                                        }
                                                        
                                                        if ( !empty($wcpoa_download_type) && 'download_by_btn' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                            echo  wp_kses( $wcpoa_file_expired_url_btn, $this->allowed_html_tags() ) ;
                                                        }
                                                        echo  wp_kses( $wcpoa_order_attachment_descriptions, $this->allowed_html_tags() ) ;
                                                        echo  wp_kses( $wcpoa_expired_date_text, $this->allowed_html_tags() ) ;
                                                        $tab_title_match = 'yes';
                                                    } else {
                                                        echo  wp_kses( $attachment_order_name, $this->allowed_html_tags() ) ;
                                                        if ( !empty($wcpoa_download_type) && 'download_by_btn' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                            echo  wp_kses( $wcpoa_file_url_btn, $this->allowed_html_tags() ) ;
                                                        }
                                                        echo  wp_kses( $wcpoa_order_attachment_descriptions, $this->allowed_html_tags() ) ;
                                                        $tab_title_match = 'yes';
                                                    }
                                                
                                                } elseif ( !empty($wcpoa_attachment_time_amount_concate_single) && $wcpoa_expired_date_enable === "time_amount" ) {
                                                } else {
                                                    echo  wp_kses( $attachment_order_name, $this->allowed_html_tags() ) ;
                                                    if ( !empty($wcpoa_download_type) && 'download_by_btn' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                        echo  wp_kses( $wcpoa_file_url_btn, $this->allowed_html_tags() ) ;
                                                    }
                                                    echo  wp_kses( $wcpoa_order_attachment_descriptions, $this->allowed_html_tags() ) ;
                                                    $tab_title_match = 'yes';
                                                }
                                            
                                            }
                                            
                                            echo  wp_kses( $wcpoa_end_div, $this->allowed_html_tags() ) ;
                                        }
                                    
                                    }
                                }
                            }
                        }
                    
                    }
                    
                    //Bulk Attachment
                    if ( !empty($items) ) {
                        if ( !empty($wcpoa_bulk_att_data) ) {
                            foreach ( $wcpoa_bulk_att_data as $att_new_key => $wcpoa_bulk_att_values ) {
                                if ( !array_key_exists( 'wcpoa_attach_view', $wcpoa_bulk_att_values ) || "enable" === $wcpoa_bulk_att_values['wcpoa_attach_view'] ) {
                                    
                                    if ( !in_array( $att_new_key, $wcpoa_bulk_att_product_key, true ) ) {
                                        $wcpoa_bulk_att_visibility = ( isset( $wcpoa_bulk_att_values['wcpoa_att_visibility'] ) && !empty($wcpoa_bulk_att_values['wcpoa_att_visibility']) ? $wcpoa_bulk_att_values['wcpoa_att_visibility'] : '' );
                                        $wcpoa_is_condition = ( isset( $wcpoa_bulk_att_values['wcpoa_is_condition'] ) && !empty($wcpoa_bulk_att_values['wcpoa_is_condition']) ? $wcpoa_bulk_att_values['wcpoa_is_condition'] : '' );
                                        $wcpoa_attachments_bulk_id = ( !empty($wcpoa_bulk_att_values['wcpoa_attachments_id']) ? $wcpoa_bulk_att_values['wcpoa_attachments_id'] : '' );
                                        $wcpoa_bulk_attachments_name = ( isset( $wcpoa_bulk_att_values['wcpoa_attachment_name'] ) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_name']) ? $wcpoa_bulk_att_values['wcpoa_attachment_name'] : '' );
                                        $wcpoa_bulk_attachment_type = ( isset( $wcpoa_bulk_att_values['wcpoa_attach_type'] ) && !empty($wcpoa_bulk_att_values['wcpoa_attach_type']) ? $wcpoa_bulk_att_values['wcpoa_attach_type'] : '' );
                                        $wcpoa_bulk_attachment_file = ( isset( $wcpoa_bulk_att_values['wcpoa_attachment_file'] ) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_file']) ? $wcpoa_bulk_att_values['wcpoa_attachment_file'] : '' );
                                        $wcpoa_attachment_descriptions = ( isset( $wcpoa_bulk_att_values['wcpoa_attachment_description'] ) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_description']) ? $wcpoa_bulk_att_values['wcpoa_attachment_description'] : '' );
                                        $wcpoa_expired_date_enable = ( isset( $wcpoa_bulk_att_values['wcpoa_expired_date_enable'] ) && !empty($wcpoa_bulk_att_values['wcpoa_expired_date_enable']) ? $wcpoa_bulk_att_values['wcpoa_expired_date_enable'] : '' );
                                        $wcpoa_expired_dates = ( isset( $wcpoa_bulk_att_values['wcpoa_expired_date'] ) && !empty($wcpoa_bulk_att_values['wcpoa_expired_date']) ? $wcpoa_bulk_att_values['wcpoa_expired_date'] : '' );
                                        $wcpoa_order_status = ( isset( $wcpoa_bulk_att_values['wcpoa_order_status'] ) && !empty($wcpoa_bulk_att_values['wcpoa_order_status']) ? $wcpoa_bulk_att_values['wcpoa_order_status'] : '' );
                                        
                                        if ( isset( $wcpoa_bulk_attachment_file ) ) {
                                            $attachment_id = $wcpoa_bulk_attachment_file;
                                            $wcpoa_attachments_type = get_post_mime_type( $attachment_id );
                                            $wcpoa_mime_type = explode( '/', $wcpoa_attachments_type );
                                            $wcpoa_att_type = $wcpoa_mime_type['0'];
                                        } else {
                                            $wcpoa_attachments_type = 'default';
                                            $wcpoa_att_type = 'default';
                                        }
                                        
                                        $wcpoa_attachments_icons = WCPOA_PLUGIN_URL . 'public/images/default.png';
                                        $wcpoa_attachments_expired_icons = WCPOA_PLUGIN_URL . 'public/images/expired.png';
                                        
                                        if ( $wcpoa_att_type === 'image' ) {
                                            $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/image.png';
                                        } elseif ( $wcpoa_attachments_type === 'text/csv' ) {
                                            $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/csv.png';
                                        } elseif ( $wcpoa_att_type === 'video' ) {
                                            $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/video.png';
                                        } elseif ( $wcpoa_attachments_type === 'text/xml' ) {
                                            $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/xml.png';
                                        } elseif ( $wcpoa_attachments_type === 'text/doc' ) {
                                            $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/doc.png';
                                        } else {
                                            $wcpoa_attachments_icon = $wcpoa_attachments_icons;
                                        }
                                        
                                        $wcpoa_att_btn = __( 'Download', 'woocommerce-product-attachment' );
                                        $wcpoa_att_ex_btn = __( 'Download', 'woocommerce-product-attachment' );
                                        
                                        if ( !empty($wcpoa_download_type) && 'download_by_link' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                            $wcpoa_attachments_name = '<h4 class="wcpoa_attachment_name"><a class="wcpoa_title_with_link" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $wcpoa_bulk_attachment_file . '&download_file=' . $wcpoa_attachments_bulk_id . '&wcpoa_attachment_order_id=' . $items_order_id . '" rel="nofollow">' . esc_html__( $wcpoa_bulk_attachments_name, 'woocommerce-product-attachment' ) . '</a></h4>';
                                        } else {
                                            $wcpoa_attachments_name = '<h4 class="wcpoa_attachment_name">' . esc_html__( $wcpoa_bulk_attachments_name, 'woocommerce-product-attachment' ) . '</h4>';
                                        }
                                        
                                        $wcpoa_bulk_file_url_btn = '<a class="wcpoa_attachmentbtn" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $wcpoa_bulk_attachment_file . '&download_file=' . $wcpoa_attachments_bulk_id . '&wcpoa_attachment_order_id=' . $items_order_id . '" rel="nofollow">' . $wcpoa_att_btn . '</a>';
                                        if ( !empty($wcpoa_download_type) && 'download_by_link' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                            $wcpoa_expired_attachments_name = '<h4 class="wcpoa_attachment_name"><a class="wcpoa_title_with_link wcpoa_expired_title_with_link"> ' . esc_html__( $wcpoa_bulk_attachments_name, 'woocommerce-product-attachment' ) . ' </a></h4>';
                                        }
                                        $wcpoa_bulk_file_expired_url_btn = '<a class="wcpoa_order_attachment_expire" rel="nofollow"> ' . $wcpoa_att_ex_btn . ' </a>';
                                        $wcpoa_attachment_descriptions = '<p class="wcpoa_attachment_desc">' . __( $wcpoa_attachment_descriptions, 'woocommerce-product-attachment' ) . '</p>';
                                        $wcpoa_bulk_expired_date_text = '<p class="order_att_expire_date">' . __( 'This Attachment Expired.', 'woocommerce-product-attachment' ) . '</p>';
                                        $wcpoa_bulk_expire_date_text = '<p class="order_att_expire_date">' . __( 'This Attachment Expiry Date : ', 'woocommerce-product-attachment' ) . $wcpoa_expired_dates . '</p>';
                                        $wcpoa_attachment_expired_date = strtotime( $wcpoa_expired_dates );
                                        $wcpoa_order_status_val = str_replace( 'wcpoa-wc-', '', $wcpoa_order_status );
                                        $wcpoa_order_status_new = ( !empty($wcpoa_order_status_val) ? $wcpoa_order_status_val : array() );
                                        $wcpoa_bulk_att_values_key[] = $att_new_key;
                                        $wcpoa_end_div = '';
                                        if ( $wcpoa_bulk_att_visibility === 'order_details_page' || $wcpoa_bulk_att_visibility === 'wcpoa_all' ) {
                                            if ( empty($wcpoa_order_status_new) || in_array( $items_order_status, $wcpoa_order_status_new, true ) ) {
                                                
                                                if ( $wcpoa_is_condition === 'no' ) {
                                                    $wcpoa_att_id = $wcpoa_bulk_att_values['wcpoa_attachments_id'];
                                                    
                                                    if ( empty($wcpoa_attachments_id_bulk) || !in_array( $wcpoa_att_id, $wcpoa_attachments_id_bulk, true ) ) {
                                                        $wcpoa_attachments_id_bulk[] = $wcpoa_bulk_att_values['wcpoa_attachments_id'];
                                                        
                                                        if ( !empty($wcpoa_attachment_expired_date) && $wcpoa_expired_date_enable === 'yes' ) {
                                                            
                                                            if ( $wcpoa_today_date > $wcpoa_attachment_expired_date ) {
                                                                
                                                                if ( !empty($wcpoa_download_type) && 'download_by_link' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                                    echo  wp_kses( $wcpoa_expired_attachments_name, $this->allowed_html_tags() ) ;
                                                                } else {
                                                                    echo  wp_kses( $wcpoa_attachments_name, $this->allowed_html_tags() ) ;
                                                                }
                                                                
                                                                if ( !empty($wcpoa_download_type) && 'download_by_btn' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                                    echo  wp_kses( $wcpoa_bulk_file_expired_url_btn, $this->allowed_html_tags() ) ;
                                                                }
                                                                echo  wp_kses( $wcpoa_attachment_descriptions, $this->allowed_html_tags() ) ;
                                                                echo  wp_kses( $wcpoa_bulk_expired_date_text, $this->allowed_html_tags() ) ;
                                                                $tab_title_match = 'yes';
                                                            } else {
                                                                echo  wp_kses( $wcpoa_attachments_name, $this->allowed_html_tags() ) ;
                                                                if ( !empty($wcpoa_download_type) && 'download_by_btn' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                                    echo  wp_kses( $wcpoa_bulk_file_url_btn, $this->allowed_html_tags() ) ;
                                                                }
                                                                echo  wp_kses( $wcpoa_attachment_descriptions, $this->allowed_html_tags() ) ;
                                                                echo  wp_kses( $wcpoa_bulk_expire_date_text, $this->allowed_html_tags() ) ;
                                                                $tab_title_match = 'yes';
                                                            }
                                                        
                                                        } else {
                                                            echo  wp_kses( $wcpoa_attachments_name, $this->allowed_html_tags() ) ;
                                                            if ( !empty($wcpoa_download_type) && 'download_by_btn' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                                echo  wp_kses( $wcpoa_bulk_file_url_btn, $this->allowed_html_tags() ) ;
                                                            }
                                                            echo  wp_kses( $wcpoa_attachment_descriptions, $this->allowed_html_tags() ) ;
                                                            $tab_title_match = 'yes';
                                                        }
                                                    
                                                    }
                                                
                                                }
                                            
                                            }
                                        }
                                        echo  wp_kses( $wcpoa_end_div, $this->allowed_html_tags() ) ;
                                    }
                                
                                }
                            }
                        }
                    }
                }
            }
            $wcpoa_checkout_all_ids = get_post_meta( $order_id, '_wcpoa_checkout_attachment_ids', true );
            
            if ( !empty($wcpoa_checkout_all_ids) && "" !== $wcpoa_checkout_all_ids ) {
                $id_checkout_array = explode( ",", $wcpoa_checkout_all_ids );
                foreach ( $id_checkout_array as $wcpoa_checkout_id ) {
                    $media_name_checkout = get_the_title( $wcpoa_checkout_id );
                    
                    if ( !empty($wcpoa_download_type) && 'download_by_link' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                        $wcpoa_attachments_name_chk = '<h4 class="wcpoa_attachment_name"><a class="wcpoa_title_with_link" href="' . get_permalink() . '?post_type=shop_order&p=' . $order_id . '&attachment_id=' . $wcpoa_checkout_id . '&wcpoa_attachment_order_id=' . $order_id . '" > ' . esc_html__( $media_name_checkout, 'woocommerce-product-attachment' ) . ' </a></h4>';
                    } else {
                        $wcpoa_attachments_name_chk = '<h4 class="wcpoa_attachment_name">' . esc_html__( $media_name_checkout, 'woocommerce-product-attachment' ) . '</h4>';
                    }
                    
                    $wcpoa_bulk_file_url_btn_chk = '<a class="wcpoa_attachmentbtn" href="' . get_permalink() . '?post_type=shop_order&p=' . $order_id . '&attachment_id=' . $wcpoa_checkout_id . '&wcpoa_attachment_order_id=' . $order_id . '" > Download </a>';
                    $wcpoa_attachment_descriptions_chk = '<p class="wcpoa_attachment_desc"></p>';
                    echo  wp_kses( $wcpoa_attachments_name_chk, $this->allowed_html_tags() ) ;
                    if ( !empty($wcpoa_download_type) && 'download_by_btn' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                        echo  wp_kses( $wcpoa_bulk_file_url_btn_chk, $this->allowed_html_tags() ) ;
                    }
                    echo  wp_kses( $wcpoa_attachment_descriptions_chk, $this->allowed_html_tags() ) ;
                    $tab_title_match = 'yes';
                }
            }
            
            echo  '</section>' ;
            do_action( 'after_wcpoa_order_data_show_my_account' );
        }
        
        return null;
    }
    
    /**
     * Product attachments data show on email.
     *
     * @since    1.0.0
     * @access   public
     */
    public function wcpoa_order_data_show_email( $order_id )
    {
        global  $sitepress ;
        $order = new WC_Order( $order_id );
        $order_data = $order->get_data();
        $order_time = $order_data['date_created']->date( 'Y/m/d H:i:s' );
        $items = $order->get_items( array( 'line_item' ) );
        $items_order_status = $order->get_status();
        $items_order_id = $order_id;
        $wcpoa_order_tab_name = get_option( 'wcpoa_order_tab_name' );
        //wcpoa order tab option name
        $wcpoa_expired_date_tlabel = get_option( 'wcpoa_expired_date_label' );
        // get attachment download type
        $wcpoa_download_type = get_option( 'wcpoa_product_download_type' );
        $get_permalink_structure = get_permalink();
        
        if ( strpos( $get_permalink_structure, "?" ) ) {
            $wcpoa_attachment_url_arg = '&';
        } else {
            $wcpoa_attachment_url_arg = '?';
        }
        
        $current_date = gmdate( "Y/m/d" );
        $wcpoa_today_date = strtotime( $current_date );
        $wcpoa_today_date_time = current_time( 'Y/m/d H:i:s' );
        $wcpoa_end_div = '';
        $wcpoa_att_values_key = array();
        $tab_title_match = 'no';
        $wcpoa_bulk_att_data = get_option( 'wcpoa_bulk_attachment_data' );
        $wcpoa_bulk_att_values_key = array();
        $wcpoa_bulk_att_product_key = array();
        if ( !empty($items) && is_array( $items ) ) {
            foreach ( $items as $item_id => $item ) {
                $wcpoa_order_attachment_items = wc_get_order_item_meta( $item_id, 'wcpoa_order_attachment_order_arr', true );
            }
        }
        $wcpoa_bulk_att_product_key = array();
        //Bulk Attachment
        if ( !empty($items) ) {
            if ( !empty($wcpoa_bulk_att_data) ) {
                foreach ( $wcpoa_bulk_att_data as $att_new_key => $wcpoa_bulk_att_values ) {
                    if ( !array_key_exists( 'wcpoa_attach_view', $wcpoa_bulk_att_values ) || "enable" === $wcpoa_bulk_att_values['wcpoa_attach_view'] ) {
                        
                        if ( !in_array( $att_new_key, $wcpoa_bulk_att_product_key, true ) ) {
                            $wcpoa_is_condition = ( isset( $wcpoa_bulk_att_values['wcpoa_is_condition'] ) && !empty($wcpoa_bulk_att_values['wcpoa_is_condition']) ? $wcpoa_bulk_att_values['wcpoa_is_condition'] : '' );
                            $wcpoa_order_status = ( isset( $wcpoa_bulk_att_values['wcpoa_order_status'] ) && !empty($wcpoa_bulk_att_values['wcpoa_order_status']) ? $wcpoa_bulk_att_values['wcpoa_order_status'] : '' );
                            $wcpoa_attachments_bulk_id = ( !empty($wcpoa_bulk_att_values['wcpoa_attachments_id']) ? $wcpoa_bulk_att_values['wcpoa_attachments_id'] : '' );
                            $wcpoa_order_status_val = str_replace( 'wcpoa-wc-', '', $wcpoa_order_status );
                            $wcpoa_order_status_new = ( !empty($wcpoa_order_status_val) ? $wcpoa_order_status_val : array() );
                            $wcpoa_bulk_att_values_key[] = $att_new_key;
                            $wcpoa_end_div = '';
                            if ( empty($wcpoa_order_status_new) || in_array( $items_order_status, $wcpoa_order_status_new, true ) ) {
                                
                                if ( $wcpoa_is_condition === 'no' ) {
                                    $wcpoa_att_id = $wcpoa_bulk_att_values['wcpoa_attachments_id'];
                                    if ( empty($wcpoa_attachments_id_bulk) || !in_array( $wcpoa_att_id, $wcpoa_attachments_id_bulk, true ) ) {
                                        $tab_title_match = 'yes';
                                    }
                                }
                            
                            }
                        }
                    
                    }
                }
            }
        }
        $wcpoa_checkout_all_ids = get_post_meta( $order_id, '_wcpoa_checkout_attachment_ids', true );
        echo  '<section class="woocommerce-attachment-details">' ;
        
        if ( $tab_title_match === 'yes' || !empty($wcpoa_checkout_all_ids) || !empty($wcpoa_order_attachment_items) ) {
            
            if ( !empty($sitepress) ) {
                $default_lang = self::$admin_object->wcpoa_get_default_langugae_with_sitpress();
                $wcpoa_order_tab_name_lang = apply_filters(
                    'wpml_translate_single_string',
                    $wcpoa_order_tab_name,
                    'woocommerce-product-attachment',
                    $wcpoa_order_tab_name,
                    $default_lang
                );
            } else {
                $wcpoa_order_tab_name_lang = $wcpoa_order_tab_name;
            }
            
            echo  '<h2 class="woocommerce-order-details__title">' . esc_html( $wcpoa_order_tab_name_lang ) . '</h2>' ;
        }
        
        $wcpoa_attachments_id_bulk = array();
        if ( !empty($items) && is_array( $items ) ) {
            foreach ( $items as $item_id => $item ) {
                $wcpoa_order_attachment_items = wc_get_order_item_meta( $item_id, 'wcpoa_order_attachment_order_arr', true );
                
                if ( !empty($wcpoa_order_attachment_items) ) {
                    $wcpoa_attachment_ids = $wcpoa_order_attachment_items['wcpoa_attachment_ids'];
                    $wcpoa_attachment_name = $wcpoa_order_attachment_items['wcpoa_attachment_name'];
                    $wcpoa_attachment_description = $wcpoa_order_attachment_items['wcpoa_att_order_description'];
                    $wcpoa_attachment_url = $wcpoa_order_attachment_items['wcpoa_attachment_url'];
                    $wcpoa_attach_type = $wcpoa_order_attachment_items['wcpoa_attach_type'];
                    $wcpoa_expired_date_enable = $wcpoa_order_attachment_items['wcpoa_expired_date_enable'];
                    $wcpoa_order_attachment_expired = $wcpoa_order_attachment_items['wcpoa_order_attachment_expired'];
                    $selected_variation_id = "";
                    $attached_variations = array();
                    
                    if ( !empty($selected_variation_id) && is_array( $attached_variations ) && in_array( (int) $selected_variation_id, convert_array_to_int( $attached_variations ), true ) ) {
                    } else {
                        if ( !empty($wcpoa_attachment_ids) && is_array( $wcpoa_attachment_ids ) ) {
                            //End Woo Product Attachment Order Tab
                            foreach ( $wcpoa_attachment_ids as $key => $wcpoa_attachments_id ) {
                                if ( !empty($wcpoa_attachments_id) || $wcpoa_attachments_id !== '' ) {
                                    
                                    if ( !in_array( $wcpoa_attachments_id, $wcpoa_att_values_key, true ) ) {
                                        $wcpoa_att_values_key[] = $wcpoa_attachments_id;
                                        $attachment_name = ( isset( $wcpoa_attachment_name[$key] ) && !empty($wcpoa_attachment_name[$key]) ? $wcpoa_attachment_name[$key] : '' );
                                        $wcpoa_attachment_type = ( isset( $wcpoa_attach_type[$key] ) && !empty($wcpoa_attach_type[$key]) ? $wcpoa_attach_type[$key] : '' );
                                        $wcpoa_attachment_file = ( isset( $wcpoa_attachment_url[$key] ) && !empty($wcpoa_attachment_url[$key]) ? $wcpoa_attachment_url[$key] : '' );
                                        $wcpoa_attachment_descriptions = ( isset( $wcpoa_attachment_description[$key] ) && !empty($wcpoa_attachment_description[$key]) ? $wcpoa_attachment_description[$key] : '' );
                                        $wcpoa_expired_date_enable = ( isset( $wcpoa_expired_date_enable[$key] ) && !empty($wcpoa_expired_date_enable[$key]) ? $wcpoa_expired_date_enable[$key] : '' );
                                        $wcpoa_order_attachment_expired_date = ( isset( $wcpoa_order_attachment_expired[$key] ) && !empty($wcpoa_order_attachment_expired[$key]) ? $wcpoa_order_attachment_expired[$key] : '' );
                                        $wcpoa_attachment_time_amount_concate_single = "";
                                        $attachment_id = $wcpoa_attachment_file;
                                        // ID of attachment
                                        $wcpoa_attachment_expired_date = strtotime( $wcpoa_order_attachment_expired_date );
                                        $wcpoa_att_btn = __( 'Download', 'woocommerce-product-attachment' );
                                        $wcpoa_att_ex_btn = __( 'Download', 'woocommerce-product-attachment' );
                                        
                                        if ( !empty($wcpoa_download_type) && 'download_by_link' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                            $attachment_order_name = '<h4 class="wcpoa_attachment_name"><a class="wcpoa_title_with_link" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $attachment_id . '&download_file=' . $wcpoa_attachments_id . '&wcpoa_attachment_order_id=' . $items_order_id . '" rel="nofollow">' . __( $attachment_name, 'woocommerce-product-attachment' ) . '</a></h4>';
                                        } else {
                                            $attachment_order_name = '<h4 class="wcpoa_attachment_name">' . __( $attachment_name, 'woocommerce-product-attachment' ) . '</h4>';
                                        }
                                        
                                        $wcpoa_file_url_btn = '<a class="wcpoa_attachmentbtn" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $attachment_id . '&download_file=' . $wcpoa_attachments_id . '&wcpoa_attachment_order_id=' . $items_order_id . '" rel="nofollow">' . $wcpoa_att_btn . '</a>';
                                        if ( !empty($wcpoa_download_type) && 'download_by_link' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                            $wcpoa_expired_attachments_name = '<h4 class="wcpoa_attachment_name"><a class="wcpoa_title_with_link wcpoa_expired_title_with_link" rel="nofollow"> ' . __( $attachment_name, 'woocommerce-product-attachment' ) . ' </a></h4>';
                                        }
                                        $wcpoa_file_expired_url_btn = '<a class="wcpoa_order_attachment_expire" rel="nofollow">' . $wcpoa_att_ex_btn . '</a>';
                                        $wcpoa_order_attachment_descriptions = '<p class="wcpoa_attachment_desc">' . __( $wcpoa_attachment_descriptions, 'woocommerce-product-attachment' ) . '</p>';
                                        
                                        if ( $wcpoa_expired_date_tlabel === 'no' ) {
                                            $wcpoa_expire_date_text = '';
                                            $wcpoa_expired_date_text = '';
                                        } else {
                                            $wcpoa_expire_date_text = '<p class="order_att_expire_date"><span>*</span>' . __( 'This Attachment Expiry Date : ', 'woocommerce-product-attachment' ) . $wcpoa_order_attachment_expired_date . '</p>';
                                            $wcpoa_expired_date_text = '<p class="order_att_expire_date"><span>*</span>' . __( 'This Attachment Expired', 'woocommerce-product-attachment' ) . '</p>';
                                        }
                                        
                                        
                                        if ( !empty($wcpoa_attachment_expired_date) && $wcpoa_expired_date_enable === "yes" ) {
                                            
                                            if ( $wcpoa_today_date > $wcpoa_attachment_expired_date ) {
                                                
                                                if ( !empty($wcpoa_download_type) && 'download_by_link' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                    echo  wp_kses( $wcpoa_expired_attachments_name, $this->allowed_html_tags() ) ;
                                                } else {
                                                    echo  wp_kses( $attachment_order_name, $this->allowed_html_tags() ) ;
                                                }
                                                
                                                if ( !empty($wcpoa_download_type) && 'download_by_btn' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                    echo  wp_kses( $wcpoa_file_expired_url_btn, $this->allowed_html_tags() ) ;
                                                }
                                                echo  wp_kses( $wcpoa_order_attachment_descriptions, $this->allowed_html_tags() ) ;
                                                echo  wp_kses( $wcpoa_expired_date_text, $this->allowed_html_tags() ) ;
                                                $tab_title_match = 'yes';
                                            } else {
                                                echo  wp_kses( $attachment_order_name, $this->allowed_html_tags() ) ;
                                                if ( !empty($wcpoa_download_type) && 'download_by_btn' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                    echo  wp_kses( $wcpoa_file_url_btn, $this->allowed_html_tags() ) ;
                                                }
                                                echo  wp_kses( $wcpoa_order_attachment_descriptions, $this->allowed_html_tags() ) ;
                                                $tab_title_match = 'yes';
                                            }
                                        
                                        } elseif ( !empty($wcpoa_attachment_time_amount_concate_single) && $wcpoa_expired_date_enable === "time_amount" ) {
                                        } else {
                                            echo  wp_kses( $attachment_order_name, $this->allowed_html_tags() ) ;
                                            if ( !empty($wcpoa_download_type) && 'download_by_btn' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                echo  wp_kses( $wcpoa_file_url_btn, $this->allowed_html_tags() ) ;
                                            }
                                            echo  wp_kses( $wcpoa_order_attachment_descriptions, $this->allowed_html_tags() ) ;
                                            $tab_title_match = 'yes';
                                        }
                                        
                                        echo  wp_kses( $wcpoa_end_div, $this->allowed_html_tags() ) ;
                                    }
                                
                                }
                            }
                        }
                    }
                
                }
                
                //Bulk Attachment
                if ( !empty($items) ) {
                    if ( !empty($wcpoa_bulk_att_data) ) {
                        foreach ( $wcpoa_bulk_att_data as $att_new_key => $wcpoa_bulk_att_values ) {
                            if ( !array_key_exists( 'wcpoa_attach_view', $wcpoa_bulk_att_values ) || "enable" === $wcpoa_bulk_att_values['wcpoa_attach_view'] ) {
                                
                                if ( !in_array( $att_new_key, $wcpoa_bulk_att_product_key, true ) ) {
                                    $wcpoa_is_condition = ( isset( $wcpoa_bulk_att_values['wcpoa_is_condition'] ) && !empty($wcpoa_bulk_att_values['wcpoa_is_condition']) ? $wcpoa_bulk_att_values['wcpoa_is_condition'] : '' );
                                    $wcpoa_attachments_bulk_id = ( !empty($wcpoa_bulk_att_values['wcpoa_attachments_id']) ? $wcpoa_bulk_att_values['wcpoa_attachments_id'] : '' );
                                    $wcpoa_bulk_attachments_name = ( isset( $wcpoa_bulk_att_values['wcpoa_attachment_name'] ) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_name']) ? $wcpoa_bulk_att_values['wcpoa_attachment_name'] : '' );
                                    $wcpoa_bulk_attachment_type = ( isset( $wcpoa_bulk_att_values['wcpoa_attach_type'] ) && !empty($wcpoa_bulk_att_values['wcpoa_attach_type']) ? $wcpoa_bulk_att_values['wcpoa_attach_type'] : '' );
                                    $wcpoa_bulk_attachment_file = ( isset( $wcpoa_bulk_att_values['wcpoa_attachment_file'] ) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_file']) ? $wcpoa_bulk_att_values['wcpoa_attachment_file'] : '' );
                                    $wcpoa_attachment_descriptions = ( isset( $wcpoa_bulk_att_values['wcpoa_attachment_description'] ) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_description']) ? $wcpoa_bulk_att_values['wcpoa_attachment_description'] : '' );
                                    $wcpoa_expired_date_enable = ( isset( $wcpoa_bulk_att_values['wcpoa_expired_date_enable'] ) && !empty($wcpoa_bulk_att_values['wcpoa_expired_date_enable']) ? $wcpoa_bulk_att_values['wcpoa_expired_date_enable'] : '' );
                                    $wcpoa_expired_dates = ( isset( $wcpoa_bulk_att_values['wcpoa_expired_date'] ) && !empty($wcpoa_bulk_att_values['wcpoa_expired_date']) ? $wcpoa_bulk_att_values['wcpoa_expired_date'] : '' );
                                    
                                    if ( isset( $wcpoa_bulk_attachment_file ) ) {
                                        $attachment_id = $wcpoa_bulk_attachment_file;
                                        $wcpoa_attachments_type = get_post_mime_type( $attachment_id );
                                        $wcpoa_mime_type = explode( '/', $wcpoa_attachments_type );
                                        $wcpoa_att_type = $wcpoa_mime_type['0'];
                                    } else {
                                        $wcpoa_attachments_type = 'default';
                                        $wcpoa_att_type = 'default';
                                    }
                                    
                                    $wcpoa_attachments_icons = WCPOA_PLUGIN_URL . 'public/images/default.png';
                                    $wcpoa_attachments_expired_icons = WCPOA_PLUGIN_URL . 'public/images/expired.png';
                                    
                                    if ( $wcpoa_att_type === 'image' ) {
                                        $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/image.png';
                                    } elseif ( $wcpoa_attachments_type === 'text/csv' ) {
                                        $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/csv.png';
                                    } elseif ( $wcpoa_att_type === 'video' ) {
                                        $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/video.png';
                                    } elseif ( $wcpoa_attachments_type === 'text/xml' ) {
                                        $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/xml.png';
                                    } elseif ( $wcpoa_attachments_type === 'text/doc' ) {
                                        $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/doc.png';
                                    } else {
                                        $wcpoa_attachments_icon = $wcpoa_attachments_icons;
                                    }
                                    
                                    $wcpoa_att_btn = __( 'Download', 'woocommerce-product-attachment' );
                                    $wcpoa_att_ex_btn = __( 'Download', 'woocommerce-product-attachment' );
                                    
                                    if ( !empty($wcpoa_download_type) && 'download_by_link' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                        $wcpoa_attachments_name = '<h4 class="wcpoa_attachment_name"><a class="wcpoa_title_with_link" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $wcpoa_bulk_attachment_file . '&download_file=' . $wcpoa_attachments_bulk_id . '&wcpoa_attachment_order_id=' . $items_order_id . '" rel="nofollow">' . esc_html__( $wcpoa_bulk_attachments_name, 'woocommerce-product-attachment' ) . '</a></h4>';
                                    } else {
                                        $wcpoa_attachments_name = '<h4 class="wcpoa_attachment_name">' . esc_html__( $wcpoa_bulk_attachments_name, 'woocommerce-product-attachment' ) . '</h4>';
                                    }
                                    
                                    $wcpoa_bulk_file_url_btn = '<a class="wcpoa_attachmentbtn" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $wcpoa_bulk_attachment_file . '&download_file=' . $wcpoa_attachments_bulk_id . '&wcpoa_attachment_order_id=' . $items_order_id . '" rel="nofollow">' . $wcpoa_att_btn . '</a>';
                                    if ( !empty($wcpoa_download_type) && 'download_by_link' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                        $wcpoa_expired_attachments_name = '<h4 class="wcpoa_attachment_name"><a class="wcpoa_title_with_link wcpoa_expired_title_with_link" rel="nofollow"> ' . esc_html__( $wcpoa_bulk_attachments_name, 'woocommerce-product-attachment' ) . ' </a></h4>';
                                    }
                                    $wcpoa_bulk_file_expired_url_btn = '<a class="wcpoa_order_attachment_expire" rel="nofollow"> ' . $wcpoa_att_ex_btn . ' </a>';
                                    $wcpoa_attachment_descriptions = '<p class="wcpoa_attachment_desc">' . __( $wcpoa_attachment_descriptions, 'woocommerce-product-attachment' ) . '</p>';
                                    $wcpoa_bulk_expired_date_text = '<p class="order_att_expire_date">' . __( 'This Attachment Expired.', 'woocommerce-product-attachment' ) . '</p>';
                                    $wcpoa_bulk_expire_date_text = '<p class="order_att_expire_date">' . __( 'This Attachment Expiry Date : ', 'woocommerce-product-attachment' ) . $wcpoa_expired_dates . '</p>';
                                    $wcpoa_attachment_expired_date = strtotime( $wcpoa_expired_dates );
                                    $wcpoa_bulk_att_values_key[] = $att_new_key;
                                    $wcpoa_end_div = '';
                                    if ( empty($wcpoa_order_status_new) || in_array( $items_order_status, $wcpoa_order_status_new, true ) ) {
                                        
                                        if ( $wcpoa_is_condition === 'no' ) {
                                            $wcpoa_att_id = $wcpoa_bulk_att_values['wcpoa_attachments_id'];
                                            
                                            if ( empty($wcpoa_attachments_id_bulk) || !in_array( $wcpoa_att_id, $wcpoa_attachments_id_bulk, true ) ) {
                                                $wcpoa_attachments_id_bulk[] = $wcpoa_bulk_att_values['wcpoa_attachments_id'];
                                                
                                                if ( !empty($wcpoa_attachment_expired_date) && $wcpoa_expired_date_enable === 'yes' ) {
                                                    
                                                    if ( $wcpoa_today_date > $wcpoa_attachment_expired_date ) {
                                                        
                                                        if ( !empty($wcpoa_download_type) && 'download_by_link' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                            echo  wp_kses( $wcpoa_expired_attachments_name, $this->allowed_html_tags() ) ;
                                                        } else {
                                                            echo  wp_kses( $wcpoa_attachments_name, $this->allowed_html_tags() ) ;
                                                        }
                                                        
                                                        if ( !empty($wcpoa_download_type) && 'download_by_btn' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                            echo  wp_kses( $wcpoa_bulk_file_expired_url_btn, $this->allowed_html_tags() ) ;
                                                        }
                                                        echo  wp_kses( $wcpoa_attachment_descriptions, $this->allowed_html_tags() ) ;
                                                        echo  wp_kses( $wcpoa_bulk_expired_date_text, $this->allowed_html_tags() ) ;
                                                        $tab_title_match = 'yes';
                                                    } else {
                                                        echo  wp_kses( $wcpoa_attachments_name, $this->allowed_html_tags() ) ;
                                                        if ( !empty($wcpoa_download_type) && 'download_by_btn' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                            echo  wp_kses( $wcpoa_bulk_file_url_btn, $this->allowed_html_tags() ) ;
                                                        }
                                                        echo  wp_kses( $wcpoa_attachment_descriptions, $this->allowed_html_tags() ) ;
                                                        echo  wp_kses( $wcpoa_bulk_expire_date_text, $this->allowed_html_tags() ) ;
                                                        $tab_title_match = 'yes';
                                                    }
                                                
                                                } else {
                                                    echo  wp_kses( $wcpoa_attachments_name, $this->allowed_html_tags() ) ;
                                                    if ( !empty($wcpoa_download_type) && 'download_by_btn' === $wcpoa_download_type || 'download_by_both' === $wcpoa_download_type ) {
                                                        echo  wp_kses( $wcpoa_bulk_file_url_btn, $this->allowed_html_tags() ) ;
                                                    }
                                                    echo  wp_kses( $wcpoa_attachment_descriptions, $this->allowed_html_tags() ) ;
                                                    $tab_title_match = 'yes';
                                                }
                                            
                                            }
                                        
                                        }
                                    
                                    }
                                    echo  wp_kses( $wcpoa_end_div, $this->allowed_html_tags() ) ;
                                }
                            
                            }
                        }
                    }
                }
            }
        }
        echo  '</section>' ;
        return null;
    }
    
    /**
     * Emails Real Attachments.
     */
    public function wcpoa_emails_attach_downloadables( $attachments, $email_id, $order )
    {
        $order_id = null;
        if ( is_array( $order ) ) {
            
            if ( isset( $order['order_id'] ) ) {
                $order_id = $order['order_id'];
                $order = wc_get_order( $order_id );
            } else {
                return;
            }
        
        }
        if ( !is_a( $order, 'WC_Order' ) ) {
            return;
        }
        $order_id = $order->get_id();
        $wcpoa_email_order_status = get_option( 'wcpoa_email_order_status' );
        $wcpoa_flag = "false";
        
        if ( empty($wcpoa_email_order_status) ) {
            if ( $email_id === 'customer_completed_order' || $email_id === 'customer_on_hold_order' || $email_id === 'customer_processing_order' ) {
                $wcpoa_flag = "true";
            }
        } else {
            if ( in_array( $email_id, $wcpoa_email_order_status, true ) ) {
                $wcpoa_flag = "true";
            }
        }
        
        
        if ( "true" === $wcpoa_flag ) {
            // start
            $order_data = $order->get_data();
            $order_time = $order_data['date_created']->date( 'Y/m/d H:i:s' );
            $items = $order->get_items( array( 'line_item' ) );
            $items_order_status = $order->get_status();
            $current_date = gmdate( "Y/m/d" );
            $wcpoa_today_date = strtotime( $current_date );
            $wcpoa_today_date_time = current_time( 'Y/m/d H:i:s' );
            $wcpoa_att_values_key = array();
            $wcpoa_bulk_att_data = get_option( 'wcpoa_bulk_attachment_data' );
            $wcpoa_bulk_att_values_key = array();
            $wcpoa_bulk_att_product_key = array();
            //Bulk Attachement
            $wcpoa_attachments_id_bulk = array();
            if ( !empty($items) && is_array( $items ) ) {
                foreach ( $items as $item_id => $item ) {
                    $wcpoa_order_attachment_items = wc_get_order_item_meta( $item_id, 'wcpoa_order_attachment_order_arr', true );
                    $wcpoa_order_product_variation_id = $item['variation_id'];
                    
                    if ( !empty($wcpoa_order_attachment_items) ) {
                        $wcpoa_attachment_ids = $wcpoa_order_attachment_items['wcpoa_attachment_ids'];
                        $wcpoa_attachment_url = $wcpoa_order_attachment_items['wcpoa_attachment_url'];
                        $wcpoa_attach_type = $wcpoa_order_attachment_items['wcpoa_attach_type'];
                        $wcpoa_order_attachment_expired = $wcpoa_order_attachment_items['wcpoa_order_attachment_expired'];
                        $wcpoa_order_product_variation_value = $wcpoa_order_attachment_items['wcpoa_order_product_variation'];
                        
                        if ( !empty($wcpoa_order_product_variation_value) && is_array( $wcpoa_order_product_variation_value ) ) {
                            $attached_variations = array();
                            foreach ( $wcpoa_order_product_variation_value as $var_list ) {
                                if ( !empty($var_list) && is_array( $var_list ) ) {
                                    foreach ( $var_list as $var_id ) {
                                        $attached_variations[] = $var_id;
                                    }
                                }
                            }
                        }
                        
                        $selected_variation_id = $item->get_variation_id();
                        
                        if ( !empty($selected_variation_id) && is_array( $attached_variations ) && in_array( (int) $selected_variation_id, convert_array_to_int( $attached_variations ), true ) ) {
                            if ( !empty($wcpoa_attachment_ids) && is_array( $wcpoa_attachment_ids ) ) {
                                //End Woo Product Attachment Order Tab
                                foreach ( $wcpoa_attachment_ids as $key => $wcpoa_attachments_id ) {
                                    if ( !empty($wcpoa_attachments_id) || $wcpoa_attachments_id !== '' ) {
                                        
                                        if ( !in_array( $wcpoa_attachments_id, $wcpoa_att_values_key, true ) ) {
                                            $wcpoa_order_product_variation = ( isset( $wcpoa_order_product_variation_value[$wcpoa_attachments_id] ) && !empty($wcpoa_order_product_variation_value[$wcpoa_attachments_id]) ? $wcpoa_order_product_variation_value[$wcpoa_attachments_id] : '' );
                                            $wcpoa_attachment_file = ( isset( $wcpoa_attachment_url[$key] ) && !empty($wcpoa_attachment_url[$key]) ? $wcpoa_attachment_url[$key] : '' );
                                            
                                            if ( is_array( $wcpoa_order_product_variation ) && in_array( (int) $selected_variation_id, convert_array_to_int( $wcpoa_order_product_variation ), true ) ) {
                                                $wcpoa_att_values_key[] = $wcpoa_attachments_id;
                                                $wcpoa_attachment_type = ( isset( $wcpoa_attach_type[$key] ) && !empty($wcpoa_attach_type[$key]) ? $wcpoa_attach_type[$key] : '' );
                                                $wcpoa_attachment_file = ( isset( $wcpoa_attachment_url[$key] ) && !empty($wcpoa_attachment_url[$key]) ? $wcpoa_attachment_url[$key] : '' );
                                                $wcpoa_order_attachment_expired_date = ( isset( $wcpoa_order_attachment_expired[$key] ) && !empty($wcpoa_order_attachment_expired[$key]) ? $wcpoa_order_attachment_expired[$key] : '' );
                                                $wcpoa_attachment_expired_date = strtotime( $wcpoa_order_attachment_expired_date );
                                                if ( $wcpoa_attachment_type === "file_upload" ) {
                                                    
                                                    if ( !empty($wcpoa_attachment_expired_date) ) {
                                                        
                                                        if ( $wcpoa_today_date > $wcpoa_attachment_expired_date ) {
                                                        } else {
                                                            $attachments[] = get_attached_file( $wcpoa_attachment_file );
                                                        }
                                                    
                                                    } else {
                                                        $attachments[] = get_attached_file( $wcpoa_attachment_file );
                                                    }
                                                
                                                }
                                            }
                                        
                                        }
                                    
                                    }
                                }
                            }
                        } else {
                            if ( !empty($wcpoa_attachment_ids) && is_array( $wcpoa_attachment_ids ) ) {
                                //End Woo Product Attachment Order Tab
                                foreach ( $wcpoa_attachment_ids as $key => $wcpoa_attachments_id ) {
                                    if ( !empty($wcpoa_attachments_id) || $wcpoa_attachments_id !== '' ) {
                                        
                                        if ( !in_array( $wcpoa_attachments_id, $wcpoa_att_values_key, true ) ) {
                                            $wcpoa_att_values_key[] = $wcpoa_attachments_id;
                                            $wcpoa_attachment_type = ( isset( $wcpoa_attach_type[$key] ) && !empty($wcpoa_attach_type[$key]) ? $wcpoa_attach_type[$key] : '' );
                                            $wcpoa_attachment_file = ( isset( $wcpoa_attachment_url[$key] ) && !empty($wcpoa_attachment_url[$key]) ? $wcpoa_attachment_url[$key] : '' );
                                            $wcpoa_expired_date_enable = ( isset( $wcpoa_expired_date_enable[$key] ) && !empty($wcpoa_expired_date_enable[$key]) ? $wcpoa_expired_date_enable[$key] : '' );
                                            $wcpoa_order_attachment_expired_date = ( isset( $wcpoa_order_attachment_expired[$key] ) && !empty($wcpoa_order_attachment_expired[$key]) ? $wcpoa_order_attachment_expired[$key] : '' );
                                            $wcpoa_attachment_time_amount_concate_single = "";
                                            $attachment_id = $wcpoa_attachment_file;
                                            // ID of attachment
                                            $wcpoa_attachment_expired_date = strtotime( $wcpoa_order_attachment_expired_date );
                                            if ( $wcpoa_attachment_type === "file_upload" ) {
                                                
                                                if ( !empty($wcpoa_attachment_expired_date) && $wcpoa_expired_date_enable === "yes" ) {
                                                    
                                                    if ( $wcpoa_today_date > $wcpoa_attachment_expired_date ) {
                                                    } else {
                                                        $attachments[] = get_attached_file( $wcpoa_attachment_file );
                                                    }
                                                
                                                } elseif ( !empty($wcpoa_attachment_time_amount_concate_single) && $wcpoa_expired_date_enable === "time_amount" ) {
                                                } else {
                                                    $attachments[] = get_attached_file( $wcpoa_attachment_file );
                                                }
                                            
                                            }
                                        }
                                    
                                    }
                                }
                            }
                        }
                    
                    }
                    
                    //Bulk Attachment
                    
                    if ( !empty($items) ) {
                        $terms = get_the_terms( $item['product_id'], 'product_cat' );
                        //Product Category Get
                        if ( !empty($wcpoa_bulk_att_data) ) {
                            foreach ( $wcpoa_bulk_att_data as $att_new_key => $wcpoa_bulk_att_values ) {
                                if ( !array_key_exists( 'wcpoa_attach_view', $wcpoa_bulk_att_values ) || "enable" === $wcpoa_bulk_att_values['wcpoa_attach_view'] ) {
                                    
                                    if ( !in_array( $att_new_key, $wcpoa_bulk_att_product_key, true ) ) {
                                        $wcpoa_is_condition = ( isset( $wcpoa_bulk_att_values['wcpoa_is_condition'] ) && !empty($wcpoa_bulk_att_values['wcpoa_is_condition']) ? $wcpoa_bulk_att_values['wcpoa_is_condition'] : '' );
                                        $wcpoa_attachments_bulk_id = ( !empty($wcpoa_bulk_att_values['wcpoa_attachments_id']) ? $wcpoa_bulk_att_values['wcpoa_attachments_id'] : '' );
                                        $wcpoa_bulk_attachment_type = ( isset( $wcpoa_bulk_att_values['wcpoa_attach_type'] ) && !empty($wcpoa_bulk_att_values['wcpoa_attach_type']) ? $wcpoa_bulk_att_values['wcpoa_attach_type'] : '' );
                                        $wcpoa_expired_date_enable = ( isset( $wcpoa_bulk_att_values['wcpoa_expired_date_enable'] ) && !empty($wcpoa_bulk_att_values['wcpoa_expired_date_enable']) ? $wcpoa_bulk_att_values['wcpoa_expired_date_enable'] : '' );
                                        $wcpoa_expired_dates = ( isset( $wcpoa_bulk_att_values['wcpoa_expired_date'] ) && !empty($wcpoa_bulk_att_values['wcpoa_expired_date']) ? $wcpoa_bulk_att_values['wcpoa_expired_date'] : '' );
                                        $wcpoa_attachment_time_amount = ( isset( $wcpoa_bulk_att_values['wcpoa_attachment_time_amount'] ) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_time_amount']) ? $wcpoa_bulk_att_values['wcpoa_attachment_time_amount'] : '' );
                                        $wcpoa_attachment_time_type = ( isset( $wcpoa_bulk_att_values['wcpoa_attachment_time_type'] ) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_time_type']) ? $wcpoa_bulk_att_values['wcpoa_attachment_time_type'] : '' );
                                        $wcpoa_time_amount_concate = $wcpoa_attachment_time_amount . " " . $wcpoa_attachment_time_type;
                                        $wcpoa_attachment_time_amount = strtotime( $wcpoa_time_amount_concate );
                                        $wcpoa_bulk_att_values_key[] = $att_new_key;
                                    }
                                
                                }
                            }
                        }
                    }
                
                }
            }
            // over
            /* Attachments from user checkout */
            $wcpoa_checkout_all_ids = get_post_meta( $order_id, '_wcpoa_checkout_attachment_ids', true );
            
            if ( !empty($wcpoa_checkout_all_ids) && "" !== $wcpoa_checkout_all_ids ) {
                $id_checkout_array = explode( ",", $wcpoa_checkout_all_ids );
                foreach ( $id_checkout_array as $wcpoa_checkout_id ) {
                    $attachment_file = get_attached_file( $wcpoa_checkout_id );
                    $attachments[] = $attachment_file;
                }
            }
            
            /* Attachments from admin order status */
            $wcpoa_all_ids = get_post_meta( $order_id, '_wcpoa_order_attachments', true );
            
            if ( !empty($wcpoa_all_ids) && "" !== $wcpoa_all_ids ) {
                $id_array = explode( ",", $wcpoa_all_ids );
                foreach ( $id_array as $wcpoa_id ) {
                    $attachment_file = get_attached_file( $wcpoa_id );
                    $attachments[] = $attachment_file;
                }
            }
        
        }
        
        return $attachments;
    }
    
    /*
     * Emails Attachment
     */
    public function wcpoa_woocommerce_email_order_attachment(
        $order,
        $sent_to_admin,
        $plain_text,
        $email
    )
    {
        if ( is_customize_preview() ) {
            return;
        }
        $order_id = $order->get_id();
        $this->wcpoa_order_data_show_email( $order_id );
    }
    
    /*
     * Add order column in order listing page
     */
    public function wcpoa_woocommerce_add_account_orders_column( $columns )
    {
        $columns['wcpoa-attachment'] = __( 'Attachment', 'woocommerce-product-attachment' );
        return $columns;
    }
    
    /*
     * Add order column data in order listing page
     */
    public function wcpoa_woocommerce_add_account_orders_column_rows( $order )
    {
        $items = $order->get_items( array( 'line_item' ) );
        $wcpoa_attachmen_order_url = $order->get_view_order_url();
        $wcpoa_bulk_att_data = get_option( 'wcpoa_bulk_attachment_data' );
        $wcpoa_bulk_att_values_key = array();
        $wcpoa_bulk_att_product_key = array();
        $wcpoa_attachments_id_bulk = array();
        $current_date = gmdate( "Y/m/d" );
        $wcpoa_today_date = strtotime( $current_date );
        $wcpoa_today_date_time = current_time( 'Y/m/d H:i:s' );
        if ( !empty($items) && is_array( $items ) ) {
            foreach ( $items as $item_id => $item ) {
                $wcpoa_order_attachment_items = wc_get_order_item_meta( $item_id, 'wcpoa_order_attachment_order_arr', true );
                
                if ( !empty($wcpoa_order_attachment_items) ) {
                    $wcpoa_attachment_ids = $wcpoa_order_attachment_items['wcpoa_attachment_ids'];
                    
                    if ( $wcpoa_attachment_ids ) {
                        ?>
<a href="<?php 
                        echo  esc_url( $wcpoa_attachmen_order_url ) ;
                        ?>" class="woocommerce-button button view">
    <?php 
                        esc_html_e( 'View', 'woocommerce-product-attachment' );
                        ?>
</a>
<?php 
                        break;
                    }
                
                }
                
                //Bulk Attachment
                $bulk_index = 1;
                if ( !empty($wcpoa_bulk_att_data) ) {
                    foreach ( $wcpoa_bulk_att_data as $att_new_key => $wcpoa_bulk_att_values ) {
                        if ( !array_key_exists( 'wcpoa_attach_view', $wcpoa_bulk_att_values ) || "enable" === $wcpoa_bulk_att_values['wcpoa_attach_view'] ) {
                            
                            if ( !in_array( $att_new_key, $wcpoa_bulk_att_product_key, true ) ) {
                                $wcpoa_bulk_att_visibility = ( isset( $wcpoa_bulk_att_values['wcpoa_att_visibility'] ) && !empty($wcpoa_bulk_att_values['wcpoa_att_visibility']) ? $wcpoa_bulk_att_values['wcpoa_att_visibility'] : '' );
                                $wcpoa_is_condition = ( isset( $wcpoa_bulk_att_values['wcpoa_is_condition'] ) && !empty($wcpoa_bulk_att_values['wcpoa_is_condition']) ? $wcpoa_bulk_att_values['wcpoa_is_condition'] : '' );
                                $wcpoa_expired_date_enable = ( isset( $wcpoa_bulk_att_values['wcpoa_expired_date_enable'] ) && !empty($wcpoa_bulk_att_values['wcpoa_expired_date_enable']) ? $wcpoa_bulk_att_values['wcpoa_expired_date_enable'] : '' );
                                $wcpoa_expired_dates = ( isset( $wcpoa_bulk_att_values['wcpoa_expired_date'] ) && !empty($wcpoa_bulk_att_values['wcpoa_expired_date']) ? $wcpoa_bulk_att_values['wcpoa_expired_date'] : '' );
                                $wcpoa_order_status = ( isset( $wcpoa_bulk_att_values['wcpoa_order_status'] ) && !empty($wcpoa_bulk_att_values['wcpoa_order_status']) ? $wcpoa_bulk_att_values['wcpoa_order_status'] : '' );
                                $wcpoa_attachment_expired_date = strtotime( $wcpoa_expired_dates );
                                $wcpoa_order_status_val = str_replace( 'wcpoa-wc-', '', $wcpoa_order_status );
                                $wcpoa_order_status_new = ( !empty($wcpoa_order_status_val) ? $wcpoa_order_status_val : array() );
                                $wcpoa_bulk_att_values_key[] = $att_new_key;
                                if ( $wcpoa_bulk_att_visibility === 'order_details_page' || $wcpoa_bulk_att_visibility === 'wcpoa_all' ) {
                                    if ( empty($wcpoa_order_status_new) || in_array( $items_order_status, $wcpoa_order_status_new, true ) ) {
                                        
                                        if ( $wcpoa_is_condition === 'no' ) {
                                            $wcpoa_att_id = $wcpoa_bulk_att_values['wcpoa_attachments_id'];
                                            
                                            if ( empty($wcpoa_attachments_id_bulk) || !in_array( $wcpoa_att_id, $wcpoa_attachments_id_bulk, true ) ) {
                                                ?>
<a href="<?php 
                                                echo  esc_url( $wcpoa_attachmen_order_url ) ;
                                                ?>" class="woocommerce-button button view">
    <?php 
                                                esc_html_e( 'View', 'woocommerce-product-attachment' );
                                                ?>
</a>
<?php 
                                                $bulk_index++;
                                                break;
                                            }
                                        
                                        }
                                    
                                    }
                                }
                            }
                        
                        }
                    }
                }
                if ( $bulk_index > 1 ) {
                    break;
                }
            }
        }
    }
    
    /*
     * Emails Attachment custome style
     */
    public function wcpoa_woocommerce_email_add_css_to_email_attachment()
    {
        echo  '<st' . 'yle type="text/css">
                        a.wcpoa_attachmentbtn {padding: 10px;background: #35a87b;color: #fff;}
                        a.wcpoa_order_attachment_expire {padding: 10px;background: #ccc;color: #ffffff;cursor: no-drop;box-shadow: none;}
                        .wcpoa_attachment_desc{padding: 8px 0px;}
                        .order_att_expire_date { padding: 8px 0px; }

                </st' . 'yle>' ;
    }
    
    public static function my_attachment_content( $atts )
    {
        //get attachments
        $public_plugin = new Woocommerce_Product_Attachment_Public( '', '' );
        ob_start();
        $product_id = get_the_id();
        /* bhavesh code */
        $wcpoa_youtube_default_showcase_flag = get_option( 'wcpoa_youtube_default_showcase_flag' );
        
        if ( isset( $atts ) && !empty($atts) ) {
            $atts['youtube_video_only'] = 'no';
            $parray = $atts;
        } else {
            $parray['youtube_video_only'] = 'no';
        }
        
        /* bhavesh code */
        
        if ( isset( $product_id ) ) {
            echo  '<div class="custom_attachment_block wcpoa_cs_shortcode">' ;
            
            if ( 'no' === $parray['youtube_video_only'] ) {
                $wcpoa_product_attach = $public_plugin->wcpoa_product_tab_content( $product_id, $parray );
                echo  wp_kses( $wcpoa_product_attach, $public_plugin->allowed_html_tags() ) ;
                $parray['youtube_video_only'] = 'yes';
            }
            
            
            if ( 'yes' === $parray['youtube_video_only'] && 'yes' === $wcpoa_youtube_default_showcase_flag ) {
                $wcpoa_product_attach = $public_plugin->wcpoa_product_tab_content( $product_id, $parray );
                echo  wp_kses( $wcpoa_product_attach, $public_plugin->allowed_html_tags() ) ;
            }
            
            echo  '</div>' ;
        } else {
            echo  esc_html( '<p> Invalid product </p>', 'woocommerce-product-attachment' ) ;
        }
        
        return ob_get_clean();
    }
    
    /**
     * Checkout page files form.
     * 
     */
    public function wcpoa_order_checkout_attachment_form()
    {
        ?>
        <form name="wcpoa_checkout_attachment" id="wcpoa_checkout_attachment" method="post" action="" enctype="multipart/form-data" style="visibility: hidden; display: none; opacity: 0;">
            <input type="file" name="wcpoa_order_file_attachment" id="wcpoa_order_file_attachment" style="display:none;" onchange="fileSelected(this)" />
        </form>
        <?php 
    }
    
    public function wcpoa_order_checkout_shipping_fields( $address_fields )
    {
        $address_fields['wcpoa_order_file_attachment_ids'] = array(
            'type'     => 'hidden',
            'required' => false,
            'class'    => array( 'wcpoa_order_file_ids' ),
            'clear'    => true,
        );
        return $address_fields;
    }
    
    /**
     * Checkout page attachment data store proceed.
     * 
     */
    public function wcpoa_order_checkout_attachment_save_processed( $order_id, $posted_data, $order )
    {
        $wcpoa_all_ids = $posted_data['wcpoa_order_file_attachment_ids'];
        if ( !empty($wcpoa_all_ids) ) {
            update_post_meta( $order_id, '_wcpoa_checkout_attachment_ids', $wcpoa_all_ids );
        }
    }
    
    /**
     * Checkout page attachment.
     * 
     */
    public function wcpoa_order_checkout_attachment( $checkout )
    {
        ?>
        <div class="wcpoa_order_attachments">
            <div class="wcpoa_order_attachments_btn">
                <input type="button" value="<?php 
        esc_attr_e( 'Add Attachment', 'woocommerce-product-attachment' );
        ?>" onclick="openAttachment()" id="wcpoa-order-file-attachment-opn">
                <input type="hidden" name="wcpoa_order_file_attachment_ids" id="wcpoa_order_file_attachment_ids">
                
            </div>
            <div class="wcpoa_order_attachments_items">
                <a href="javascript:void(0)" style="display:none;" id="wcpoa-clear-aitem" onclick="wcpoa_reset_files(this)">Clear</a>
            </div>
        </div>
        <?php 
    }
    
    /**
     * Save checkout page attachments.
     */
    public function wcpoa_order_checkout_attachment_save()
    {
        require_once ABSPATH . "wp-load.php";
        require_once ABSPATH . "wp-admin/includes/image.php";
        require_once ABSPATH . "wp-admin/includes/file.php";
        require_once ABSPATH . "wp-admin/includes/media.php";
        
        if ( isset( $_FILES['file'] ) && !empty($_FILES['file']) ) {
            $files = $_FILES['file'];
            //phpcs:ignore
            $tmp = $files['tmp_name'];
            $file_array = array();
            $file_array['name'] = $files['name'];
            $file_array['tmp_name'] = $tmp;
            // If error storing temporarily, unlink
            if ( is_wp_error( $tmp ) ) {
                $file_array['tmp_name'] = '';
            }
            // do the validation and storage stuff
            $id = media_handle_sideload( $file_array, 0 );
            // If error storing permanently, unlink
            if ( is_wp_error( $id ) ) {
                $id = "";
            }
        } else {
            $id = '';
        }
        
        echo  esc_html( $id ) ;
        die;
    }
    
    public function allowed_html_tags( $tags = array() )
    {
        $allowed_tags = array(
            'a'        => array(
            'href'     => array(),
            'title'    => array(),
            'target'   => array(),
            'class'    => array(),
            'download' => array(),
        ),
            'ul'       => array(
            'class' => array(),
        ),
            'li'       => array(
            'class' => array(),
        ),
            'p'        => array(
            'class' => array(),
        ),
            'img'      => array(
            'href'  => array(),
            'title' => array(),
            'class' => array(),
            'src'   => array(),
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
            'id'    => array(),
            'value' => array(),
            'name'  => array(),
            'class' => array(),
            'type'  => array(),
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