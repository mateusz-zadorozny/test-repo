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
    'class' => 'logos-exhibition-section section-padd-small ' . $attributes['backgroundColor']
]);
?>
<section <?= $blockClass ?> >
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h2 class="h3 logos-exhibition-section-title">
                    <?php echo wp_kses_post($attributes['title']); ?>
                </h2>
                 <?php if (isset($attributes['icons']) && count($attributes['icons']) > 0): ?>
                    <div class="logos-wrapper">
                        <?php foreach ($attributes['icons'] as $icon): ?>
                        <img class="logos-exhibition-section-logo" src="<?= $icon['url']; ?>" alt="icon" />
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>