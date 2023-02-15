<?php

$theme_dir = get_template_directory();
require_once $theme_dir . '/custom/helpers/pagination.php';


function productsSearchHandler()
{
    $productCategories = get_categories( array(
		'taxonomy'     => 'product_cat',
		'orderby'      => 'name',
		'pad_counts'   => false,
		'hierarchical' => 1,
		'hide_empty'   => true
	) );
    $activeCategory = isset($_POST['category']) && !empty($_POST['category']) ? $_POST['category'] : null;
    $html = '';
    ob_start();
    foreach ($productCategories as $subcat) {
        if ($activeCategory !== null  && $subcat->term_id != $activeCategory ) {
            continue;
        }

        $html .= '<div class="row">
                <div class="col-lg-3">
                        <h2>'. $subcat->name .'</h2>
                </div>
                <div class="col-lg-9 col-xl-8 offset-xl-1">
                        <div class="row mb-5">';
                                

                                        $categories = $subcat->slug; // Set child category slug for each query of products
                                        $categoryArgs = array(
                                                'post_type' => 'product',
                                                'product_cat' => $categories,
                                        );
                                        $loop = new WP_Query($categoryArgs);
                                        if ($loop->have_posts()){
                                                while ($loop->have_posts()) { $loop->the_post(); 
                                                   $product = wc_get_product(get_the_ID());
                                                   $html .= '<div class="col-sm-6 col-xxl-4 mb-4">
                                                                <a href="' . $product->get_permalink(). '" rel="bookmark" title="' . $product->get_title() .'" class="product-card lgrey">
                                                                        <figure class="product-image">
                                                                                ' .$product->get_image(). '
                                                                        </figure>
                                                                        <div class="product-card-content">
                                                                                <h3 class="mb-0">' .  $product->get_title() .'</h3>
                                                                                <p class="product-price">' . $product->get_price_html(). '</p>
                                                                        </div>
                                                                </a>

                                                        </div>';
                                                }
                                        } else {
                                               $html .= ' <h2>' . __('No products found'). '</h2>';
                                        }
                                wp_reset_postdata(); // Reset Query 
                       $html .=  ' </div>
                </div>

        </div>


					<!--/.products-->';
	}
        ob_clean();
        ob_end_clean();
        $response = [
            'items' => $html,
            'pagination' => '',
            'success' => true
        ];
        echo json_encode($response);
        wp_die();
}
add_action('wp_ajax_products_search', 'productsSearchHandler');
add_action('wp_ajax_nopriv_products_search', 'productsSearchHandler');


add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98);
function woo_rename_tabs($tabs) {
    global $product;
    if( $product->has_attributes() || $product->has_dimensions() || $product->has_weight() ) { // Check if product has attributes, dimensions or weight
        $tabs['additional_information']['title'] = pll__('Technical details');
	}
return $tabs;
}


// Disable the core template part on the blog page.
add_filter( 'generate_do_template_part', function( $do ) {
    if ( is_home() || is_shop()) {
        return false;
    }
    return $do;
} );


remove_action('woocommerce_archive_description', 'woocommerce_product_archive_description', 10);
add_action( 'woocommerce_archive_description', 'display_product_decription' );

function display_product_decription() {
    $isShopPage = rwmb_meta('is_shop_page');
    
    if ( is_shop() || $isShopPage == 1) : 
        $shop_page = $isShopPage == 1 ? get_the_ID() : get_option( 'woocommerce_shop_page_id' );
        $post = get_post($shop_page);
        $blocks = parse_blocks($post->post_content);
        foreach ($blocks as $block) {
            echo render_block($block);
        }
    endif;
}


// Enable Gutenberg editor for WooCommerce
function activate_gutenberg_product( $can_edit, $post_type ) {
    if ( $post_type == 'product' ) {
           $can_edit = true;
       }
       return $can_edit;
   }
   add_filter( 'use_block_editor_for_post_type', 'activate_gutenberg_product', 10, 2 );
   
// enable taxonomy fields for woocommerce with gutenberg on
function enable_taxonomy_rest( $args ) {
    $args['show_in_rest'] = true;
    return $args;
}
add_filter( 'woocommerce_taxonomy_args_product_cat', 'enable_taxonomy_rest' );
add_filter( 'woocommerce_taxonomy_args_product_tag', 'enable_taxonomy_rest' );

add_filter('woocommerce_breadcrumb_defaults', function( $defaults ) {
    unset($defaults['home']); //removes home link.
    
    return $defaults; //returns rest of links
});


function getShopLinkByLang()
{
    $currentLang = pll_current_language();

    if ('en' === $currentLang) {
        return get_permalink( wc_get_page_id( 'shop' ) );
    }
    
    $args = [
            'post_type' => 'page',
            'posts_per_page' => 1,
            'orderby' => 'ID',
            'order' => 'ASC',
            'status' => ['publish'],
            'lang' => $currentLang,
            'meta_query' => [
                [
                    'key' => 'is_shop_page',
                    'value' => '1',
                    'compare' => '=',
                    'type' => 'CHAR'
                ],
                ]
    ];

    $results = new WP_Query($args);
    $item = reset($results->get_posts());
    
    return null !== $item ? get_permalink($item->ID) : home_url();
}

add_filter( 'woocommerce_get_breadcrumb', 'custom_breadcrumb', 10, 2 );
function custom_breadcrumb( $crumbs, $object_class ){
    $currentLang = pll_current_language();
    // Loop through all $crumb

    $shopLink = getShopLinkByLang();
    foreach( $crumbs as $key => $crumb ){
        $taxonomy = 'product_cat'; 
        $term_array = term_exists( $crumb[0], $taxonomy );
        
        $termId = pll_get_term($term_array['term_id']);
        if ($termId === false) {
            $args = [
                'name' => $crumb[0],
                'lang' => $currentLang
            ];
            $results = new WP_Term_Query($args);
            if (empty($results->terms)) {
                continue;
            }
            foreach ($results->terms as $term) {
                if (pll_get_term($term->term_id) !== false) {
                    $termId = $term->term_id;
                    continue;
                }
            }
        }
        $crumbs[$key][1] = $shopLink . '?category=' . $termId; // or use all other dedicated functions
    }

    return $crumbs;
}
