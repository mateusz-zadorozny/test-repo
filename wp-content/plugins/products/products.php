<?php
/**
 * Plugin Name:       [FH] Products Carousel
 * Description:       Interactive module with products. The carousel is interactive in couple ways: main action button is leading to an option of browsing all products. It is possible to scroll sides to see different products and to click on a chosen one to read more about it.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Kambu
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       products
 *
 * @package           create-block
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_block_products_block_init() {
	register_block_type( 
                __DIR__ . '/build',
                [
                    'render_callback' => 'products_block_render_callback',
                ]
                );
}
add_action( 'init', 'create_block_products_block_init' );

add_action( 'wp_enqueue_scripts', 'includeSwiper' );
function productsCarouselSwiperInit() {
    wp_enqueue_script('productsswiperinitjs', plugins_url( 'src/swiper/init.js', __FILE__ ));
}
add_action( 'wp_enqueue_scripts', 'productsCarouselSwiperInit' );

/**
 * This function is called when the block is being rendered on the front end of the site
 *
 * @param array    $attributes     The array of attributes for this block.
 * @param string   $content        Rendered block output. ie. <InnerBlocks.Content />.
 * @param WP_Block $block_instance The instance of the WP_Block class that represents the block being rendered.
 */
function products_block_render_callback( $attributes, $content, $block_instance ) {
	ob_start();
	/**
	 * Keeping the markup to be returned in a separate file is sometimes better, especially if there is very complicated markup.
	 * All of passed parameters are still accessible in the file.
	 */
	require plugin_dir_path( __FILE__ ) . 'template.php';
	return ob_get_clean();
}

function render_products_list($attributes)
{
     $args = [
            'post_type'      => 'product',
            'posts_per_page' => -1,
            'status'         => 'publish',
            'catalog_visibility' => 'visible',
            'post__not_in'           => [get_the_ID()]
        ];

    $products = wc_get_products( $args ); 
    foreach ($products as $product): ?>

        <div class="swiper-slide">
            <a href="<?=$product->get_permalink();?>" class="product-card">
                <figure class="product-image">
                    <?= $product->get_image();?>
                </figure>
                <div class="product-card-content">
                    <h3 class="mb-0"><?=$product->get_title();?></h3>
                    <p class="product-price"><?= $product->get_price_html();?></p>
                </div>
            </a>
        </div>
        
    <?php
    endforeach;

}
