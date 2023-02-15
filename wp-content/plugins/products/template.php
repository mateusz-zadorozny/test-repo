<?php 
$blockClass = get_block_wrapper_attributes([
    'class' => 'lgrey-bg'
]);
?>
<section <?= $blockClass ?> >
    <div class="container">
        <div class="row">

            <?php if (!empty($attributes['title'])) : ?>
                <div class="col-12 col-lg-7 order-1">
                    <h2><?= wp_kses_post($attributes['title']); ?></h2>
                </div>
            <?php endif; ?>

            <div class="col-12 col-lg-5 order-3 order-lg-2">
                <div class="progress-pagination my-4"></div>
            </div>

            
            <div class="swiper products-carousel mb-3 my-sm-3 my-xl-5 order-2 order-lg-3">
                <div class="swiper-wrapper">
                    <?php echo render_products_list($attributes);?>
                </div>

                <button class="carousel-button-prev shape-button"><i class="icon-chevron-left"></i></button>
                <button class="carousel-button-next shape-button"><i class="icon-chevron-right"></i></button>

            </div>
                
            <?php if (!empty($attributes['contentLink']) && !empty($attributes['contentLinkText'])): ?>
                <div class="col-12 mt-3 mt-sm-5 text-center order-4">
                    <a type="button" class="button secondary" href="<?= wp_kses_post($attributes['contentLink']); ?>">
                        <span><?= wp_kses_post($attributes['contentLinkText']); ?></span>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>   
</section>