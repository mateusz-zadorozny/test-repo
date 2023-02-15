<?php
/**
 * Plugin Name:       [FH] Parallax Background Section
 * Description:       Section with Parallax Background in three different variants - text counters, charts and image columns. You may use additional mask on top of the background image.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Kambu
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       counters-section
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
function create_block_counters_section_block_init() {
	register_block_type( __DIR__ . '/build' );
}
add_action( 'init', 'create_block_counters_section_block_init' );

function my_block_counters_section_enqueue_script()
{   
    wp_enqueue_script( 'my_block_counters_section_enqueue_script', plugin_dir_url( __FILE__ ) . 'js/mk_charts.js' );
}
add_action('wp_enqueue_scripts', 'my_block_counters_section_enqueue_script');