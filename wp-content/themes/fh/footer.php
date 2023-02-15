<?php
/**
 * The template for displaying the footer.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

	</div>
</div>

<?php
/**
 * generate_before_footer hook.
 *
 * @since 0.1
 */
do_action( 'generate_before_footer' );
?>

<footer <?php generate_do_attr( 'footer' ); ?>>
	<?php
	/**
	 * generate_before_footer_content hook.
	 *
	 * @since 0.1
	 */
	do_action( 'generate_before_footer_content' );
	?>
	<?php 
        $form = rwmb_meta( 'form_short_code_' . (pll_current_language()), ['object_type' => 'setting'], 'footer-settings' );
        $privacyPolicyPageId = rwmb_meta( 'privacy_policy_page_' . (pll_current_language()), ['object_type' => 'setting'], 'footer-settings' );
        $termsPageId = rwmb_meta( 'terms_and_conditions_page_' . (pll_current_language()), ['object_type' => 'setting'], 'footer-settings' );
        ?>
	<div class="container">
		<div class="row mb-4">
			<div class="col-lg-4 mt-2 brand-logo mb-4 pb-3">
				<?php
					if ( function_exists( 'the_custom_logo' ) ) {
						the_custom_logo();
					}
				?>
			</div>
			<div class="col-lg-8">
				<?= do_shortcode($form); ?>
			</div>
		</div>
		<div class="row mb-5">
			<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'container' => 'div',
						'container_class' => 'footer-nav',
						'container_id' => 'footer-menu',
						'menu_class' => '',
						'fallback_cb' => 'generate_menu_fallback',
						'items_wrap' => '<ul id="%1$s" class="%2$s ' . join( ' ', generate_get_element_classes( 'menu' ) ) . '">%3$s</ul>',
					)
				);
			?>
		</div>
		<hr>
		<div class="row bottom-bar text-center text-lg-start">
			<div class="col-lg-6 text-lg-end order-lg-2">
                            <?php if (!empty($termsPageId)) :?>
                                <a class="footer-link" href="<?php the_permalink($termsPageId) ?>"><?= pll_e('Terms and conditions') ?></a>
                            <?php endif;?>
                            <?php if (!empty($privacyPolicyPageId)) :?>
                                <a class="footer-link" href="<?php the_permalink($privacyPolicyPageId) ?>"><?= pll_e('Privacy policy') ?></a>
                            <?php endif;?>
			</div>
			<div class="col-lg-6 mt-4 mt-lg-0 order-lg-1"><?= pll_e('© Copyright 2022 Futurehome AS. All rights reserved. Made by ') ?><a href="https://kambu.pl">kambu</a></div>
		</div>
	</div>

	<script>
		(function (jQuery) {
			window.$ = jQuery

			var submenus = $('.site-header .sf-menu .menu-item-has-children .sub-menu');
			var backToMenu = "<li class=\"back-to-menu\"><a href=\"#\"><i class=\"icon-chevron-left\"></i> <?= pll_e('Back to menu') ?></a></li>"
			submenus.each(function( index ) {
				this.insertAdjacentHTML("afterbegin", backToMenu);
			});

		})(jQuery);
	</script>

	<?php
	/**
	 * generate_after_footer_content hook.
	 *
	 * @since 0.1
	 */
	do_action( 'generate_after_footer_content' );
	?>
</footer>

<?php
/**
 * generate_after_footer hook.
 *
 * @since 2.1
 */
do_action( 'generate_after_footer' );

wp_footer();
?>

</body>
</html>
