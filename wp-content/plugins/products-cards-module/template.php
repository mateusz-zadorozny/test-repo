
<?php 
$blockClass = get_block_wrapper_attributes([
    'class' => 'wp-block-create-block-products-cards-module '
]);
?>
<section <?= $blockClass ?> >
    <div class="container">
        <div class="productCards">
            <div class="row">
                <div class="col-12 col-xl-4 pe-xl-5 mb-5 mb-xl-0">
                    <div class="productCards__content pe-xxl-5 pe-xl-3">
                        <?php if (!empty($attributes['title'])): ?>
                        <h2 class="productCards__header">
                           <?= wp_kses_post($attributes['title']); ?>
                        </h2>
                        <?php endif;?>
                        <?php if (!empty($attributes['content'])): ?>
                        <p class="productCards__text mb-4 pb-2 mobile-hide">
                            <?= wp_kses_post($attributes['content']); ?>
                        </p>
                        <?php endif;?>
                        <?php if (!empty($attributes['contentLinkText'])): ?>
                        <a class="button secondary mobile-hide" href="<?=$attributes['contentLink'];?>">
                           <?= wp_kses_post($attributes['contentLinkText']); ?>
                        </a>
                        <?php endif;?>
                    </div>
                </div>
                <div class="col-12 col-xl-8">
                    <?php if (count($attributes['products']) > 0) :?>
                    <div class="productCards__row row">
                        <?php foreach ($attributes['products'] as $product): ?>
                        <div class="col-4 col-sm-12 col-lg-4 productCards__col mb-4">
                            <div class="productCards__card">
                                <div class="productCards__card-imgBox">
                                    <?php if (!empty($product['image'])) :?>
                                    <img class="productCards__card-img" src="<?=$product['image'];?>" alt="product"/>
                                    <?php endif;?>
                                </div>
                                <span class="productCards__card-span"></span>
                                <div class="productCards__card-bottom">
                                    <?php if (!empty($product['title'])) : ?>
                                    <h3 class="productCards__card-title">SWITCH SSM-U01</h3>
                                    <?php endif;?>
                                    <?php if (!empty($product['logo'])) :?>
                                    <img class="productCards__card-logo" src="<?=$product['logo'];?>" alt="logo"/>
                                    <?php endif;?>
                                </div>
                                <?php if (!empty($product['linkUrl'])) :?>
                                <a href="<?=$product['linkUrl'];?>"> </a>
                                <?php endif;?>
                            </div>
                        </div>
                        <?php endforeach;?>

                    </div>
                    <?php endif;?>
                    <?php if (!empty($attributes['contentLinkText'])): ?>
                        <a class="button secondary text-center mobile-visible mt-4" href="<?=$attributes['contentLink'];?>">
                           <?= wp_kses_post($attributes['contentLinkText']); ?>
                        </a>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</section>