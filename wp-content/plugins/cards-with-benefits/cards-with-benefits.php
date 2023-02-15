<?php
/**
 * Plugin Name:       [FH] Columns Grid
 * Description:       Interactive or non-interactive module. Possibility of 3 types of grid composition (1, 2 or 3 columns enlarged in the upper part of module). Each column may be turned into interactive element leading to a sub-page.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Kambu
 * Text Domain:       cards-with-benefits
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
function create_block_cards_with_benefits_block_init() {
	register_block_type( __DIR__ . '/build' );
}
add_action( 'init', 'create_block_cards_with_benefits_block_init' );
