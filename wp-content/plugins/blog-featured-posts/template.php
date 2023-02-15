<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


?>
<section <?php echo wp_kses_data(get_block_wrapper_attributes(['class' => 'blog-featured-posts'])); ?>>
    <div class="container">
        <div class="row">
            <?php 
                if (!empty($attributes['firstArticle'])):
                    $article = get_post($attributes['firstArticle']);
                    if (null !== $article && $article->post_status === 'publish'):
                            echo prepare_single_item_template($article, true);
                    endif;
                endif; 
            ?>
            <div class="col-lg-6">
                <div class="row">
                    <?php 
                        if (!empty($attributes['secondArticle'])):
                            $article = get_post($attributes['secondArticle']);
                            if (null !== $article && $article->post_status === 'publish'):
                                    echo prepare_single_item_template($article);
                            endif;
                        endif; 
                    ?>
                    
                    <?php 
                        if (!empty($attributes['thirdArticle'])):
                            $article = get_post($attributes['thirdArticle']);
                            if (null !== $article && $article->post_status === 'publish'):
                                    echo prepare_single_item_template($article);
                            endif;
                        endif; 
                    ?>
                    <?php 
                        if (!empty($attributes['fourthArticle'])):
                            $article = get_post($attributes['fourthArticle']);
                            if (null !== $article && $article->post_status === 'publish'):
                                    echo prepare_single_item_template($article);
                            endif;
                        endif; 
                    ?>
                    <?php 
                        if (!empty($attributes['fifthArticle'])):
                            $article = get_post($attributes['fifthArticle']);
                            if (null !== $article && $article->post_status === 'publish'):
                                    echo prepare_single_item_template($article);
                            endif;
                        endif; 
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>