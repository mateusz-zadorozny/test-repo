<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package GeneratePress
 */


global $wp_query;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
get_header(); 

global $wp_query;
$pages=[];
$products=[];
$items=[];;

foreach ($wp_query->posts as $post) {
	if ($post->post_type==='post'){
		$items[] =$post;
	}
	if ($post->post_type==='page'){
		$pages[] =$post;
	}
	if ($post->post_type==='product'){
		$products[] =$post;
	}

}

?>

	<div <?php generate_do_attr( 'content' ); ?>>
		<main <?php generate_do_attr( 'main' ); ?>>

			<section class="wp-block-create-block-main-slider search-intro p-0">
				<div class="page-intro">
					<div class="intro-slider">
						<div class="main-slider__item intro-slide subpage">
						<div class="intro-content">
							<div class="row">
								<div class="shape-content col-6">
									<h1 class="h1 mb-1"><?php pll_e( 'Search' ); ?>: <?php the_search_query(); ?></h1>
									<div class="product-desc">
										<?php echo $wp_query->found_posts; $wp_query->found_posts > 1 ?  pll_e(' results found') : pll_e(' result found')  ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>

			<section class="search-results-section">
				<div class="container">
					<div class="row justify-content-between flex-lg-row-reverse">
						<div class="col-lg-4">
							<h2 class="h3"><?php pll_e('Result categories') ?></h2>
							<ul class='search-categories'>
								<li>
									<button class="active" data-rel='all'><?php pll_e('All types') ?></button>
								</li>
								<?php if (count($pages)) : ?>
									<li><button data-rel='sites'><?php pll_e('Sites') ?></button></li>
								<?php endif; ?>
								<?php if (count($items)) : ?>
									<li><button data-rel='posts'><?php pll_e('Posts') ?></button></li>
								<?php endif; ?>
								<?php if (count($products)) : ?>
									<li><button data-rel='products'><?php pll_e('Products') ?></button></li>
								<?php endif; ?>
							</ul>
						</div>
						<div class="col-lg-7">
							<?php
							/**
							 * generate_before_main_content hook.
							 *
							 * @since 0.1
							 */
							// do_action( 'generate_before_main_content' );

							if ( generate_has_default_loop() ) {
								if ( $wp_query->have_posts()) :?>

									
										<?php 
										if (count($items)): ?>
											<div id='search-posts' class='search-results'>
												<h2><?php pll_e('Posts'); ?></h2>
												<?php foreach ($items as $item) {
													set_query_var('item', $item);

													generate_do_template_part( 'search' );
												} 
												
												set_query_var('item', null);
												?>
											</div>
										<?php endif ?>

										<?php 
										if (count($pages)): ?>
											<div id='search-sites' class='search-results'>
												<h2><?php pll_e('Sites'); ?></h2>
												<?php foreach ($pages as $page) {
													set_query_var('page', $page);

													generate_do_template_part( 'search' );
												}
													set_query_var('page', null); 
												?>
											</div>
										<?php endif ?>

										<?php 
										if (count($products)): ?>
											<div id='search-products' class='search-results row'>
												<h2><?php pll_e('Products'); ?></h2>
												<?php foreach ($products as $product) {
													set_query_var('product', $product);

													generate_do_template_part( 'search' );
												}
													set_query_var('product', null);
												?>
											</div>
										<?php endif ?>

									
						</div>
					</div>
					<?php /**
					 * generate_after_loop hook.
					 *
					 * @since 2.3
					 */

						else :
                                                    generate_do_template_part( 'none' );

						endif;
					} ?>
				</div>
			</section>
			<?php
				$bgImage = rwmb_meta( 'cta_background_image_' . (pll_current_language()), ['object_type' => 'setting', 'size' => 'full'], 'search-settings', );
				$title = rwmb_meta( 'cta_title_' . (pll_current_language()), ['object_type' => 'setting'], 'search-settings' );
				if (!empty($bgImage) && !empty($title)) :
				$attributes = [
					'fontSize' => rwmb_meta( 'cta_font_size_' . (pll_current_language()), ['object_type' => 'setting'], 'search-settings' ),
					'isFormShortCodeChecked' => rwmb_meta( 'cta_use_form_shortcode_' . (pll_current_language()), ['object_type' => 'setting'], 'search-settings' ),
					'formShortCode' => rwmb_meta( 'cta_form_shortcode_' . (pll_current_language()), ['object_type' => 'setting'], 'search-settings' ),
					'class' => '',
					'colorVariant' => rwmb_meta( 'cta_color_variant_' . (pll_current_language()), ['object_type' => 'setting'], 'search-settings' ),
					'title' => $title,
					'content' => rwmb_meta( 'cta_content_' . (pll_current_language()), ['object_type' => 'setting'], 'search-settings' ),
					'contentLink' => rwmb_meta( 'cta_content_link_url_' . (pll_current_language()), ['object_type' => 'setting'], 'search-settings' ),
					'contentLinkText' => rwmb_meta( 'cta_content_link_text_' . (pll_current_language()), ['object_type' => 'setting'], 'search-settings' ),
					'backgroundImage' => !empty($bgImage) ? $bgImage['url'] : '',
				];
				$fontSizeClass = 'default';
				$fontSize = $attributes['fontSize'];
				if ($fontSize === 'large') {
					$fontSizeClass = 'medium';
				} else if ($fontSize === 'xlarge') {
					$fontSizeClass = 'large';
				}
				$isFormShortCodeChecked = $attributes['isFormShortCodeChecked'];
				$formShortCode = $attributes['formShortCode'];
				$blockClass = get_block_wrapper_attributes([
					'class' => ' ' . $attributes['class'] . ' ' . $attributes['colorVariant'] . ' cta-banner-black-section'
				]);
				?>
				<section <?= $blockClass ?>>
					<div class="container">
						<div class="cta-banner cta-banner-black">
							<div class="row cta-banner__content">
								<div class="col-sm-12 col-lg-8 col-xl-7 cta-banner__content-col">
									<div class="cta-banner__content-col--item">
										<h2 class="cta-banner__title mt-0"><?= $attributes['title'] ?></h2>
										<p class="cta-banner__text <?= $fontSizeClass ?>"><?= $attributes['content'] ?></p>
										<?php if (($isFormShortCodeChecked == false)): ?>
											<a href="<?= $attributes['contentLink'] ?>" class="<?= ($attributes['colorVariant'] == 'dark') ? 'white' : 'secondary' ?> cta-banner__content-link button" type="button"><span><?= $attributes['contentLinkText'] ?></span></a>
										<?php endif; ?>
										<?php if (($isFormShortCodeChecked == true) && (!empty($formShortCode))): ?>
											<?= do_shortcode($attributes['formShortCode']) ?>
										<?php endif; ?>
									</div>
								</div>
								<div class="col-sm-12 col-lg-4 col-xl-5 cta-banner__bg-container">
									<img class="cta-banner__bg" src="<?= $attributes['backgroundImage'] ?>" alt="photo"/>
								</div>
							</div>
						</div>
					</div>
				</section>
			<?php endif;?>
		</main>
	</div>


			
	<?php
	/**
	 * generate_after_main_content hook.
	 *
	 * @since 0.1
	 */
	do_action( 'generate_after_main_content' );
	
	/**
	 * generate_after_primary_content_area hook.
	 *
	 * @since 2.0
	 */
	do_action( 'generate_after_primary_content_area' );

	generate_construct_sidebars();

	get_footer();
