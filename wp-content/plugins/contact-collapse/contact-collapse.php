<?php
/**
 * Plugin Name:       [FH] Contact Section
 * Description:       Interactive module prepared for contact details. Unfolded segment shows the category/kind of the contact person, details are unhidden after click. The box on the right may display the fluentform shortcode.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Kambu
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       contact-collapse
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
function create_block_contact_collapse_block_init() {
	register_block_type( __DIR__ . '/build', 
    [
        'render_callback' => 'contact_collaps_block_render_callback'
    ] );
}
add_action( 'init', 'create_block_contact_collapse_block_init' );


/**
 * This function is called when the block is being rendered on the front end of the site
 *
 * @param array    $attributes     The array of attributes for this block.
 * @param string   $content        Rendered block output. ie. <InnerBlocks.Content />.
 * @param WP_Block $block_instance The instance of the WP_Block class that represents the block being rendered.
 */
function contact_collaps_block_render_callback( $attributes, $content, $block_instance ) {
	ob_start();
	/**
	 * Keeping the markup to be returned in a separate file is sometimes better, especially if there is very complicated markup.
	 * All of passed parameters are still accessible in the file.
	 */
	require plugin_dir_path( __FILE__ ) . 'template.php';
	return ob_get_clean();
}



function my_blocks_collapse_enqueue_script()
{   
    wp_enqueue_script( 'my_blocks_collapse_script', plugin_dir_url( __FILE__ ) . 'js/init.js' );
}
add_action('wp_enqueue_scripts', 'my_blocks_collapse_enqueue_script');