<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header();

list($localizations, $types, $countries) = prepareJobTaxonomiesToShow(get_the_ID());
	?>
	

<div class="wp-block-create-block-main-slider">
    <div class="page-intro intro_content_type">
        <div class="intro-slider">
            <div class="main-slider__item intro-slide subpage">
                <?php if (get_the_post_thumbnail_url()): ?>
                    <figure class="intro-background-image product">
                        <img src="<?= get_the_post_thumbnail_url() ?>" />
                    </figure>   
                <?php endif; ?>
            <div class="intro-content">
                <div class="row">
                    <div class="shape-content col-6">
                        <div class="breadcrumbs mb-2 white">
                            <nav>
                            <?php 
                                $page_for_jobs_id = rwmb_meta( 'career_page_'.(pll_current_language()), ['object_type' => 'setting'], 'career-settings' );
                                
                                if ( $page_for_jobs_id ) :
                            ?>
                                <a href="<?php the_permalink($page_for_jobs_id) ?>"><?= get_the_title( $page_for_jobs_id ); ?></a>
                                <span> &#8250;</span>
                            <?php
                                endif;
                               the_title( $page_for_posts_id ); 
                            ?>
                            </nav>
                        </div>
                        <h1 class="mb-1"><?= get_the_title( $page_for_posts_id ); ?></h1>
                        <p class="job-location">
                            <?php if (count($localizations) > 0) :?>
                                <?=implode(', ', $localizations);?>,
                            <?php endif;?>
                            <?php if (count($types) > 0) :?>
                                <?=implode(', ', $types);?>, 
                            <?php endif;?>
                            <?php if (count($countries) > 0) :?>
                                <?=implode(', ', $countries);?>
                            <?php endif;?>
                            
                        </p>
                        <div class="job-salary">
                             <?= pll_e( 'Pay scales' );?>
                            <div class="job-salary-content">
                                <p>
                                    <strong><?= rwmb_meta('pay_scale_amount');?></strong> <?= rwmb_meta('pay_scale_info');?> 
                                </p>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php while ( have_posts() ) : ?>
        <?php the_post(); ?>

        <?php get_template_part( 'content', 'single-job-position' ); ?>

<?php endwhile; // end of the loop. ?>

<?php 
	get_footer();?>
	
