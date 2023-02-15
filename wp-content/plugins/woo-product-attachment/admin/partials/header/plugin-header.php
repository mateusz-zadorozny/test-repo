<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$plugin_url = WCPOA_PLUGIN_URL;
$plugin_name = WCPOA_PLUGIN_NAME;
global  $wpap_fs ;
$version_label = 'Free Version';
?>
<div id="dotsstoremain">
    <div class="all-pad">
        <header class="dots-header">
            <div class="dots-plugin-details">
                <div class="dots-header-left">
                    <div class="dots-logo-main">
                        <div class="logo-image">
                            <img  src="<?php 
echo  esc_url( $plugin_url ) . '/admin/images/woo-product-attachment.png' ;
?>">
                        </div>
                        <div class="plugin-version">
                            <span><?php 
esc_html_e( $version_label, 'woocommerce-product-attachment' );
?> <?php 
echo  esc_html( WCPOA_PLUGIN_VERSION ) ;
?></span>
                        </div>
                    </div>
                    <div class="plugin-name">
                        <div class="title"><?php 
esc_html_e( $plugin_name, 'woocommerce-product-attachment' );
?></div>
                        <div class="desc"><?php 
esc_html_e( 'Enhance your customer experience of product pages with downloadable files, such as technical descriptions, certificates, and licenses, user guides, and manuals, etc.', 'woocommerce-product-attachment' );
?></div>
                    </div>
                </div>
                <div class="dots-header-right">
                    

                    <div class="button-group">
                        <div class="button-dots">
                            <span class="support_dotstore_image">
                                <a target="_blank" href="<?php 
echo  esc_url( 'http://www.thedotstore.com/support/' ) ;
?>">
                                    <span class="dashicons dashicons-sos"></span>
                                    <strong><?php 
esc_html_e( 'Quick Support', 'woocommerce-product-attachment' );
?></strong>
                                </a>
                            </span>
                        </div>

                        <div class="button-dots">
                            <span class="support_dotstore_image">
                                <a target="_blank" href="<?php 
echo  esc_url( 'https://docs.thedotstore.com/category/353-premium-plugin-settings' ) ;
?>">
                                    <span class="dashicons dashicons-media-text"></span>
                                    <strong><?php 
esc_html_e( 'Documentation', 'woocommerce-product-attachment' );
?></strong>
                                </a>
                            </span>
                        </div>

                        <?php 
?>
                            <div class="button-dots">
                                <span class="support_dotstore_image">
                                    <a target="_blank" href="<?php 
echo  esc_url( $wpap_fs->get_upgrade_url() ) ;
?>">
                                        <span class="dashicons dashicons-upload"></span>
                                        <strong><?php 
esc_html_e( 'Upgrade To Pro', 'woocommerce-product-attachment' );
?></strong>
                                    </a>
                                </span>
                            </div>
                        <?php 
?>
                    </div>
                </div>
            </div>
            <?php 
$about_plugin_setting_menu_enable = '';
$wcpoa_bulk_attachment = '';
$about_plugin_get_started = '';
$about_plugin_quick_info = '';
$dotstore_setting_menu_enable = '';
$wcpoa_plugin_setting_page = '';
$woocommerce_product_bulk_attachment = '';
$tab_menu = filter_input( INPUT_GET, 'tab', FILTER_SANITIZE_SPECIAL_CHARS );
$page_menu = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_SPECIAL_CHARS );
if ( isset( $tab_menu ) && $tab_menu === 'wcpoa_plugin_setting_page' ) {
    $wcpoa_plugin_setting_page = "active";
}
if ( empty($tab_menu) && $page_menu === 'woocommerce_product_attachment' ) {
    $wcpoa_plugin_setting_page = "active";
}

if ( !empty($tab_menu) && $tab_menu === 'wcpoa-plugin-getting-started' ) {
    $about_plugin_setting_menu_enable = "active";
    $about_plugin_get_started = "active";
}


if ( !empty($tab_menu) && $tab_menu === 'wcpoa-plugin-quick-info' ) {
    $about_plugin_setting_menu_enable = "active";
    $about_plugin_quick_info = "active";
}

if ( !empty($page_menu) && $page_menu === 'wcpoa_bulk_attachment' ) {
    $woocommerce_product_bulk_attachment = "active";
}
?>

            <div class="dots-menu-main">
                <nav>
                    <ul>
                        <li><a class="dotstore_plugin <?php 
echo  esc_attr( $wcpoa_plugin_setting_page ) ;
?>" href="<?php 
echo  esc_url( site_url( 'wp-admin/admin.php?page=woocommerce_product_attachment&tab=wcpoa_plugin_setting_page' ) ) ;
?>"><?php 
esc_html_e( 'Settings', 'woocommerce-product-attachment' );
?></a></li>

                        <li><a class="dotstore_plugin <?php 
echo  esc_attr( $woocommerce_product_bulk_attachment ) ;
?>" href="<?php 
echo  esc_url( site_url( 'wp-admin/admin.php?page=wcpoa_bulk_attachment' ) ) ;
?>"><?php 
esc_html_e( 'Bulk Attachment', 'woocommerce-product-attachment' );
?></a></li>
                            
                        <li>
                            <a class="dotstore_plugin <?php 
echo  esc_attr( $about_plugin_setting_menu_enable ) ;
?>" href="<?php 
echo  esc_url( site_url( 'wp-admin/admin.php?page=woocommerce_product_attachment&tab=wcpoa-plugin-getting-started' ) ) ;
?>"><?php 
esc_html_e( 'About Plugin', 'woocommerce-product-attachment' );
?></a>
                        <ul class="sub-menu">
                            <li>
                                <a class="dotstore_plugin <?php 
echo  esc_attr( $about_plugin_get_started ) ;
?>" href="<?php 
echo  esc_url( site_url( 'wp-admin/admin.php?page=woocommerce_product_attachment&tab=wcpoa-plugin-getting-started' ) ) ;
?>"><?php 
esc_html_e( 'Getting Started', 'woocommerce-product-attachment' );
?></a></li>
                            <li>
                                <a class="dotstore_plugin <?php 
echo  esc_attr( $about_plugin_quick_info ) ;
?>" href="<?php 
echo  esc_url( site_url( 'wp-admin/admin.php?page=woocommerce_product_attachment&tab=wcpoa-plugin-quick-info' ) ) ;
?>">Introduction</a>
                            </li>
                            <li><a target="_blank" href="https://www.thedotstore.com/feature-requests/">Suggest A Feature</a></li>
                        </ul>

                        </li>
                        <li>
                            <a class="dotstore_plugin <?php 
echo  esc_attr( $dotstore_setting_menu_enable ) ;
?>"  href="#">Dotstore</a>
                            <ul class="sub-menu">
                                <li><a target="_blank" href="https://www.thedotstore.com/woocommerce-plugins/"><?php 
esc_html_e( 'WooCommerce Plugins', 'woocommerce-product-attachment' );
?></a></li>
                                <li><a target="_blank" href="https://www.thedotstore.com/wordpress-plugins/"><?php 
esc_html_e( 'Wordpress Plugins', 'woocommerce-product-attachment' );
?></a></li><br>
                                <li><a target="_blank" href="https://www.thedotstore.com/support"><?php 
esc_html_e( 'Contact Support', 'woocommerce-product-attachment' );
?></a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>
        <div class="dots-settings-inner-main">
            <div class="wcpoa-section-left">