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
    'class' => 'OpinionsModule__section ' .  $attributes['backgroundColor']  
]);
?>
<section <?= $blockClass ?> >
    <div class="container">
        <div class="OpinionsModule">
            <div class="row">
                <div class="col-12 col-xl-3 mb-5 mb-xl-0">
                    <div class="OpinionsModule__content-box">
                        <h2 class="OpinionsModule__header mb-0">
                        <?php echo wp_kses_post($attributes['title']); ?>
                        </h2>
                    </div>
                </div>
                <div class="col-12 col-xl-8 offset-xl-1">
                    <div class="OpinionsModule__row row">
                        <?php    
                            if(!empty($attributes['opinionsBlock'])):
                                foreach($attributes['opinionsBlock'] as $opinion):
                        ?>
                            <div class="OpinionsModule__content-card col-4 col-sm-12 col-md-4 col-lg-4">

                                <div class="OpinionsModule__content-card--item">
                                    <svg class="rate-<?php echo $opinion['rate'] ?>-5" width="136" height="24" viewBox="0 0 136 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="#EF8C5E"/>
                                        <path d="M40 2L43.09 8.26L50 9.27L45 14.14L46.18 21.02L40 17.77L33.82 21.02L35 14.14L30 9.27L36.91 8.26L40 2Z" fill="#EF8C5E"/>
                                        <path d="M68 2L71.09 8.26L78 9.27L73 14.14L74.18 21.02L68 17.77L61.82 21.02L63 14.14L58 9.27L64.91 8.26L68 2Z" fill="#EF8C5E"/>
                                        <path d="M96 2L99.09 8.26L106 9.27L101 14.14L102.18 21.02L96 17.77L89.82 21.02L91 14.14L86 9.27L92.91 8.26L96 2Z" fill="#EF8C5E"/>
                                        <path d="M124 2L127.09 8.26L134 9.27L129 14.14L130.18 21.02L124 17.77L117.82 21.02L119 14.14L114 9.27L120.91 8.26L124 2Z" fill="#EF8C5E"/>
                                    </svg>
                                    <p class="OpinionsModule__quote">
                                        <?php echo  wp_kses_post($opinion['text']) ?>
                                    </p>
                                    <span class="card-item-span"></span>
                                    <div class="OpinionsModule__quote-author">
                                            <?php if (wp_kses_post($opinion['clientImage']['url'])): ?>
                                            <figure class="OpinionsModule__avatar">
                                                <img class="OpinionsModule__img img-fluid" src="<?php echo  wp_kses_post($opinion['clientImage']['url']) ?>" alt="Client"/>
                                            </figure>
                                        <?php endif; ?>
                                        <p class="OpinionsModule__name"><?php echo  wp_kses_post($opinion['clientName']) ?></p>
                                    </div>
                                </div>
                            </div>
                        
                        <?php	
                                endforeach;
                            endif;	
                        ?>
                    </div>
                        
                </div>
            </div>
        </div>
    </div>
</section>