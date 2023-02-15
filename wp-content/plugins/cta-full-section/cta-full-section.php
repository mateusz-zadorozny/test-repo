<?php
/**
 * Plugin Name:       [FH] CTA Full Section
 * Description:       Full width interactive section with a button leading to specific section or outside link. Two seperate images available for desktop and mobile views.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Kambu
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       cta-full-section
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
function create_block_cta_full_section_block_init() {
	register_block_type( __DIR__ . '/build' );
}
add_action( 'init', 'create_block_cta_full_section_block_init' );
