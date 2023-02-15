<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$fontSizeClass = 'default';
$fontSize = $attributes['fontSize'];
if ($fontSize === 20) {
    $fontSizeClass = 'medium';
} else if ($fontSize === 24) {
    $fontSizeClass = 'large';
}
?>
<?php 
$blockClass = get_block_wrapper_attributes([
    'class' => 'halvesModule ' . $attributes['textPosition'] . ' ' . $attributes['backgroundColor']  . ' ' . $attributes['blockVariant'] 
]);
?>
<section <?= $blockClass ?> >
    <div class="container">
        <div class="row halvesModule__row">
            <div class="<?= ($attributes['blockVariant'] == 'infographic') ? 'col-sm-12 col-md-6 col-lg-5' : 'col-sm-12 col-md-6' ?>  halvesModule__img-container">
                <img class="halvesModule__img img-fluid" src="<?=$attributes['backgroundImage'];?>" alt="image"/>
            </div>
            <div class="<?= ($attributes['blockVariant'] == 'infographic') ? 'col-sm-12 col-md-6 col-lg-7' : 'col-sm-12 col-md-6' ?> halvesModule__content">
                <div class="halvesModule__content-box">
                    <?php if (!empty($attributes['title'])): ?>
                    <h2 class="halvesModule__header"><?= wp_kses_post($attributes['title']); ?></h2>
                    <?php endif; ?>
                    <?php if (!empty($attributes['content'])): ?>
                    <p class="halvesModule__desc <?= $fontSizeClass ?>">
                        <?= wp_kses_post($attributes['content']); ?>
                    </p>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</section>