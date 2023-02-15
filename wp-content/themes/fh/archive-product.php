<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined('ABSPATH') || exit;

get_header('shop');

?>
<?php
/**
 * Hook: woocommerce_archive_description.
 *
 * @hooked woocommerce_taxonomy_archive_description - 10
 * @hooked woocommerce_product_archive_description - 10
 */
do_action('woocommerce_archive_description');	

?>
<?php
	$productCategories = get_categories( array(
		'taxonomy'     => 'product_cat',
		'orderby'      => 'name',
		'pad_counts'   => false,
		'hierarchical' => 1,
		'hide_empty'   => true
	) );
?>

<?php if ($productCategories): 
        $activeCategory = isset($_GET['category']) && !empty($_GET['category']) ? $_GET['category'] : null;
        $categoryInLang = pll_get_term($activeCategory);
        if ($activeCategory !== $categoryInLang) {
            $activeCategory = !$categoryInLang ? null : $categoryInLang;
            
            if ($activeCategory === null) :?>
    <script>
            var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname;
            window.history.pushState({ path: newurl }, '', newurl);
    </script>
    <?php else :?>
    <script>
            var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?category=<?=$activeCategory;?>';
            window.history.pushState({ path: newurl }, '', newurl);
    </script>
    <?php endif;?>
<?php
        }
    ?>
	<section id="products-section" class="py-0">
		<section class="product-categories-section">
			<div class="container">
                            <form name='products-list' method="get" action="#products-section">
                                <input type='hidden' name='category' value='<?=$activeCategory;?>' />
                            </form>
                            <ul class="products-categories-list">
                                    <li class="category-block <?= $activeCategory == null ? 'active' : '';?>" data-term-id=''>
                                            <figure class="category-image">
                                                    <img src="<?= get_template_directory_uri() . '/assets/images/category-all.svg' ?>" alt="All">
                                            </figure>
                                            <span><?= pll_e('All products')?></span>
                                    </li>
                                    <?php foreach ($productCategories as $subcat): ?>
                                            <?php $thumbnail_id = get_term_meta( $subcat->term_id, 'thumbnail_id', true ); ?>
                                            <li class="category-block <?= $activeCategory == $subcat->term_id ? 'active' : '';?>" data-term-id='<?=$subcat->term_id;?>'>
                                                    <figure class="category-image">
                                                            <img src="<?= wp_get_attachment_url( $thumbnail_id );  ?>">
                                                    </figure>
                                                    <span><?= $subcat->name ?></span>
                                            </li>
                                    <?php endforeach; ?>
                            </ul>
			</div>
		</section>

		<section class="products-list">
			<div class="container filters-list-items">
			
				<?php foreach ($productCategories as $subcat): 
                                    
                                    if ($activeCategory !== null  && $subcat->term_id != $activeCategory ) :
                                        continue;
                                    endif;
                                    ?>

					<div class="row">
						<div class="col-lg-3">
							<h2><?= $subcat->name ?></h2>
						</div>
						<div class="col-lg-9 col-xl-8 offset-xl-1">
							<div class="row mb-5">
								<?php
									$categories = $subcat->slug; // Set child category slug for each query of products
									$categoryArgs = array(
										'post_type' => 'product',
										'product_cat' => $categories,
									);
									$loop = new WP_Query($categoryArgs);
									if ($loop->have_posts()):
										while ($loop->have_posts()) : $loop->the_post(); ?>
											<div class="col-sm-6 col-xxl-4 mb-4">
												<?php $product = wc_get_product(get_the_ID()); // get the WC_Product Object ?>
												<a href="<?php the_permalink();?>" rel="bookmark" title="<?php the_title_attribute(); ?>" class="product-card lgrey">
													<figure class="product-image">
														<?= $product->get_image();?>
													</figure>
													<div class="product-card-content">
														<h3 class="mb-0"><?php the_title(); ?></h3>
														<p class="product-price"><?= $product->get_price_html();?></p>
													</div>
												</a>

											</div>
										<?php endwhile; ?>
									<?php else: ?>
										<h2><?= pll_e('No products found')?></h2>
									<?php endif; ?>
								<?php wp_reset_postdata(); // Reset Query ?>
							</div>
						</div>

					</div>


					<!--/.products-->
				<?php endforeach;?>
			
			</div>
		</section>
	</section>

	<script>
		var productsBlockContainer = document.getElementById('products-container');
		var productsWrapper = document.getElementById('products-section');
		document.addEventListener("DOMContentLoaded", () => {
			productsBlockContainer.replaceWith(productsWrapper)
		});
	</script>
	
<?php endif; ?>

<?php

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('woocommerce_after_main_content');

get_footer('shop');