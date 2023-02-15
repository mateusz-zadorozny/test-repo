<?php 
$blockClass = get_block_wrapper_attributes([
    'class' => $attributes['backgroundColor']  
]);
?>
<section <?= $blockClass ?> >
    <div class="container">
        <div class="icons-columns">
            <div class="row">
                <div class="col-12 col-xl-3 mb-4 mb-xl-0">
                    <div class="icons-columns__content-box">
                        <?php if (!empty($attributes['title'])): ?>
                            <h2 class="icons-columns__header"><?= wp_kses_post($attributes['title']); ?></h2>
                       <?php endif; ?>
                    </div>
                </div>
                <?php if (count($attributes['iconsColumns']) > 0): ?>
                <div class="col-12 col-xl-8 offset-xl-1 pt-2">
                    
                    <div class="icons-columns__row row">
                        <?php foreach ($attributes['iconsColumns'] as $column) :?>
                        <div class="icons-columns__card col-12 col-sm-6 col-lg-4 mb-4 pe-lg-4">
                            <div class="icons-columns__card-left">
                               <?php if (!empty($column['iconImage'])) : ?>
                                <img class="icons-columns__card-left--img" src="<?=$column['iconImage']['url'];?>" alt='icon'/>
                                <?php endif;?>
                                
                            </div>
                            <div class="icons-columns__card-right">
                                <?php if (!empty($column['title'])) : ?>
                                <h3><?= wp_kses_post($column['title']);?></h3>
                                <?php endif;?>
                                <?php if (!empty($column['text'])) : ?>
                                <p><?= wp_kses_post($column['text']);?></p>
                                <?php endif;?>
                            </div>
                        </div>
                        <?php endforeach;?>
                    </div>
                </div>
                <?php endif;?>
            </div>
        </div>
    </div>
</section>
