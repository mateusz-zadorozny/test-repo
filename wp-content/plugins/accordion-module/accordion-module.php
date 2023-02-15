<?php
/**
 * Plugin Name:       [FH] Accordion Module (FAQ)
 * Description:       Interactive (unfolding) module prepared for questions and answers section. Answers visible after clicking on chosen question. No limited number of questions. Answers should be kept rather short (couple sentences).
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Kambu
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       accordion-module
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
function create_block_accordion_module_block_init() {
	register_block_type( 
                __DIR__ . '/build',
                [
                    'render_callback' => 'accordion_module_block_render_callback'
                ]);
}
add_action( 'init', 'create_block_accordion_module_block_init' );

function my_blocks_accordion_module_enqueue_script()
{   
    wp_enqueue_script( 'my_blocks_accordion_module_script', plugin_dir_url( __FILE__ ) . 'js/index.js' );
}
add_action('wp_enqueue_scripts', 'my_blocks_accordion_module_enqueue_script');

function accordion_module_block_render_callback( $attributes, $content, $block_instance ) {
    ob_start();
    
    /**
     * Keeping the markup to be returned in a separate file is sometimes better, especially if there is very complicated markup.
     * All of passed parameters are still accessible in the file.
     */
    
    require plugin_dir_path( __FILE__ ) . 'template.php';
    return ob_get_clean();
}
