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
?>

<section class="<?= wp_kses_post($attributes['backgroundColor']); ?> social-media-section" <?php echo wp_kses_data(get_block_wrapper_attributes()); ?>>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-3">
                <div class="social-media__content-box">
                    <h2 class="social-media__header"><?= wp_kses_post($attributes['title']); ?></h2>
                    <p class="social__text <?= $fontSizeClass ?>"><?= wp_kses_post($attributes['content']); ?></p>
                </div>
            </div>
            <div class="col-sm-12 col-lg-8 offset-lg-1">
                <div class="social-media-banner">
                    <?php    
                        if(!empty($attributes['socialCardsBlock'])):
                            foreach($attributes['socialCardsBlock'] as $socialCard):
                    ?>
                                <a class="social-media-banner__item"  href="<?php echo wp_kses_post($socialCard['socialURL']) ?>">
                                    <div class="social-media-banner__item-main">
                                        <div>
                                            <h3 class="social-media-banner__item-title mb-1"><?php echo wp_kses_post($socialCard['title']) ?></h3>
                                            <p class="social-media-banner__item-content mt-1"><?php echo wp_kses_post($socialCard['text']) ?></p>
                                        </div>
                                        <span class="social-media-banner__item-icon">
                                            <?php if (!empty($socialCard['iconImage']['url'])): ?>
                                                <figure class="social-media-banner__avatar">
                                                    <img class="social-media-banner__img img-fluid" src="<?php echo wp_kses_post($socialCard['iconImage']['url']) ?>" alt="Icon" />
                                                </figure>
                                            <?php else: ?>
                                                <i class="icon-arrow-right"></i>
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                </a>
                    <?php	
                            endforeach;
                        endif;	
                    ?>

                </div>
            </div>
        </div>
    </div>
</section>