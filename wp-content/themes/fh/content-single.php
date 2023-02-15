<section class="post-intro pb-0"> 
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="py-5">
                    <div class="breadcrumbs mb-2">
                        <?php 
                            $page_for_posts_id = get_option('page_for_posts', true);
                            if ( $page_for_posts_id ) :
                        ?>
                            <a href="<?php the_permalink($page_for_posts_id) ?>"><?= get_the_title( $page_for_posts_id ); ?></a>
                            <span> &#8250;</span>
                        <?php
                            endif;
                            pll_e( 'Article' );
                        ?>
                        <?php $category = get_the_category() ?>
                        <?php if (isset($category)): ?>
                            <span class="px-3">|</span>
                            <span class="category-badge">
                                <?= $category[0]->name; ?>
                            </span>
                        <?php endif; ?>
                    </div>
                   
                    
                    <h1><?php the_title() ?></h1>
                </div>
            </div>
        </div>
    </div>
    <?php if (get_the_post_thumbnail_url()): ?>
	    <figure class="post-intro-image" style="background-image: url('<?= get_the_post_thumbnail_url() ?>')"></figure>
    <?php endif; ?>
</div>


<section class="container post-main">
    <div class="row">
        <div id="post-content" class="col-lg-8">
            <?= the_content()?>
            <ul class="post-tags mt-5">
                <?php
                $post_id = get_the_ID();
                $tags = get_the_tags($post_id);
                if ( $tags ) :
                    foreach ( $tags as $tag ) : ?>
                        <li><?php echo esc_html( $tag->name ); ?></li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
            <a href="<?php the_permalink($page_for_posts_id) ?>" class="my-5 button secondary back"><?php pll_e('Back to blog list') ?></a>
        </div>
        <div class="col-lg-3 offset-lg-1 post-sidebar">
            <div class="sidebar-content">
                <h2 class="mb-4 h2"><?php pll_e( 'Read more' ); ?></h2>
                <?php $postsList = get_posts(['numberposts'=>3, 'post_type' => 'post', 'post__not_in' => array($post->ID)]); ?>
                <?php if (! empty($postsList)) :?>
                    <?php
                        foreach ($postsList as $post):
                            $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'large');
                            $title = get_the_title();
                            $category = get_the_category(get_the_ID());
                            $link = get_the_permalink();
                    ?>

                        <div class="post-card__hover">
                            <a href="<?= $link; ?>" class="post-card mb-4 d-block">
                                <?php if (!empty($thumbnail)): ?>
                                <figure class="post-image-wrapper">
                                    <img class="post-image" src="<?= $thumbnail ?>" />
                                </figure>
                                <?php endif; ?>
                                <div class="post-info py-2">
                                    <?php if (isset($category)): ?>
                                    <p class="m-0 category-badge">
                                        <?= $category[0]->name; ?>
                                    </p>
                                    <?php endif; ?>
                                    <h3><?= $title; ?></h3>
                                    <p class="read-more mt-2 d-md-none"><?= pll_e('Read more') ?> <i class="icon-arrow-right"></i></p>
                                    
                                </div>
                            </a>
                        </div>
                    <?php endforeach;?>
                <?php endif; ?>

            </div>
        </div>


    </div>
</section>