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
<section <?php echo wp_kses_data(get_block_wrapper_attributes()); ?>>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-8 col-xl-7 mb-5 mb-md-0 mb-lg-5 mb-xl-0 post-card__hover">
                <?php 
                    if (!empty($attributes['firstProduct'])):
                        $product = get_post($attributes['firstProduct']);
                        $productBackground = $attributes['firstProductBackgroundImage'];
                        if (null !== $product && $product->post_status === 'publish'):
                                echo prepare_product_template($product, $productBackground);
                        endif;
                    endif; 
                ?>
            </div>
            <div class="col-md-6 col-lg-4 col-md-6 col-xl-5 second-featured post-card__hover">
                <?php 
                    if (!empty($attributes['secondProduct'])):
                        $product = get_post($attributes['secondProduct']);
                        $productBackground = $attributes['secondProductBackgroundImage'];
                        if (null !== $product && $product->post_status === 'publish'):
                            echo prepare_product_template($product, $productBackground);
                        endif; 
                    endif; 
                ?>
            </div>
        </div>
    </div>
</section>