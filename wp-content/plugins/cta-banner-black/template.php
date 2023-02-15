<?php
/**
 * All of the parameters passed to the function where this file is being required are accessible in this scope:
 *
 * @param array    $attributes     The array of attributes for this block.
 * @param string   $content        Rendered block output. ie. <InnerBlocks.Content />.
 * @param WP_Block $block_instance The instance of the WP_Block class that represents the block being rendered.
 *
 * @package gutenberg-examples
 */

 $fontSizeClass = 'default';
 $fontSize = $attributes['fontSize'];
 if ($fontSize === 20) {
     $fontSizeClass = 'medium';
 } else if ($fontSize === 24) {
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
