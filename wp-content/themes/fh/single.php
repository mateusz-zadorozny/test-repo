<?php
/**
 * The Template for displaying all single posts.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


get_header();
	if ( generate_has_default_loop() ) {
		while ( have_posts() ) :

			the_post();
                        generate_do_template_part( 'single' );

		endwhile;
	}
	/**
	 * generate_after_primary_content_area hook.
	 *
	 * @since 2.0
	 */

	get_footer();

