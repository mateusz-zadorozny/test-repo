<?php
/**
 * Plugin Name:       [FH] Images Carousel
 * Description:       Interactive module with clickable arrows to scroll sides with chosen photos.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Kambu
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       images-carousel-standalone
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
function create_block_images_carousel_standalone_block_init() {
	register_block_type( __DIR__ . '/build' );
}
add_action( 'init', 'create_block_images_carousel_standalone_block_init' );

add_action( 'wp_enqueue_scripts', 'includeSwiper' );
function imagesCarouselStandaloneSwiperInit() {
    wp_enqueue_script('imagesCarouselswiperinitjs', plugins_url( 'src/swiper/init.js', __FILE__ ));
}
add_action( 'wp_enqueue_scripts', 'imagesCarouselStandaloneSwiperInit' );
