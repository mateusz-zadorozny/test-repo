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

?>

<?php 
$blockClass = get_block_wrapper_attributes([
    'class' => 'wp-block-create-block-selected-articles ' . $attributes['backgroundColor']
]);
?>
<section <?= $blockClass ?> >
    <div class="container">
        <div class="row">
            <div class="col-12 col-xl-3 mb-4 mb-xl-0">

                <?php if (!empty($attributes['title'])): ?>
                    <h2 class="mb-3"><?= wp_kses_post($attributes['title']); ?></h2>
                <?php endif; ?>

                <?php if (!empty($attributes['subtitle'])): ?>
                    <p class="mb-xl-4 pb-xl-3"><?= wp_kses_post($attributes['subtitle']); ?></p>
                <?php endif; ?>

                <?php if (!empty($attributes['contentLink']) && !empty($attributes['contentLinkText'])): ?>
                    <a class="button secondary d-none d-xl-inline-block" href="<?= wp_kses_post($attributes['contentLink']); ?>"><span><?= wp_kses_post($attributes['contentLinkText']); ?></span></a>
                <?php endif; ?>

            </div>
            <div class="col-xl-4 col-sm-6 offset-xl-1 mb-4 mb-sm-0 pe-lg-4 post-card__hover">
                    <?php 
                        if (!empty($attributes['firstArticle'])):
                            $article = get_post($attributes['firstArticle']);
                            if (null !== $article && $article->post_status === 'publish'):
                                    echo prepare_article_template($article);
                            endif;
                        endif; 
                    ?>
            </div>
            <div class="col-xl-4 col-sm-6 mb-4 mb-sm-0 ps-lg-4 post-card__hover">
                <?php 
                    if (!empty($attributes['secondArticle'])):
                        $article = get_post($attributes['secondArticle']);
                        if (null !== $article && $article->post_status === 'publish'):
                            echo prepare_article_template($article);
                        endif; 
                    endif; 
                ?>
            </div>
            <?php if (!empty($attributes['contentLink']) && !empty($attributes['contentLinkText'])): ?>
                <div class="text-center d-inline-block d-xl-none mt-2 mt-sm-4">
                    <a class="button secondary" href="<?= wp_kses_post($attributes['contentLink']); ?>">
                        <span><?= wp_kses_post($attributes['contentLinkText']); ?></span>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>