<?php
/**
 * Plugin Name:       [FH] Site Intro/Main slider
 * Description:       Interactive or non-interactive module, possibly with button. Requires good quality photo as a background. There is no need to prepare the photos in order to make menu bar visible - menu bar contains a black gradient making the tabs always visible.
 * Requires at least: 5.9
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Kambu
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       main-slider
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
function create_block_main_slider_block_init()
{
	register_block_type(__DIR__ . '/build');
}
add_action('init', 'create_block_main_slider_block_init');

function includeSwiper() {
    wp_enqueue_script('swiperjs', plugins_url( 'src/swiper/swiper.min.js', __FILE__ ));
    wp_enqueue_style('swipercss', plugins_url( 'src/swiper/swiper.min.css', __FILE__ ));
}
add_action( 'wp_enqueue_scripts', 'includeSwiper' );
function mainSliderSwiperInit() {
    wp_enqueue_script('swiperinitjs', plugins_url( 'src/swiper/init.js', __FILE__ ));
}
add_action( 'wp_enqueue_scripts', 'mainSliderSwiperInit' );

