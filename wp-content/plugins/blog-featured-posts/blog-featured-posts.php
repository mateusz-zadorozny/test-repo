<?php
/**
 * Plugin Name:       [FH] Blog — Featured posts
 * Description:       Interactive module with 5 chosen segments showing a shortcut of specific article. Clicking on a segment is leading to an article. One (most important) article is highlighted with a different segment size. 
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Kambu
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       blog-featured-posts
 *
 * @package           create-block
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_block_blog_featured_posts_block_init() {
	register_block_type( 
                __DIR__ . '/build',
                [
                    'render_callback' => 'block_blog_featured_posts_block_render_callback'
                ]
            );
}
add_action( 'init', 'create_block_blog_featured_posts_block_init' );

function block_blog_featured_posts_block_render_callback($attributes, $content, $block_instance)
{
    ob_start();
    /**
     * Keeping the markup to be returned in a separate file is sometimes better, especially if there is very complicated markup.
     * All of passed parameters are still accessible in the file.
     */
    require plugin_dir_path(__FILE__) . 'template.php';
    return ob_get_clean();
}

function prepare_single_item_template($post, $featured = false)
{
    $thumbnail = $featured ? get_the_post_thumbnail_url($post->ID, 'large') : get_the_post_thumbnail_url($post->ID, 'large');
    $link = get_permalink($post->ID);
    $categories = get_the_category($post->ID);

    if ($featured) {
    ?>
    <div class="col-lg-6 pe-lg-5 mb-5 post-card__hover">
        <a href="<?=$link;?>" class="post-card featured-post mb-4" style="background-image: url('<?=$thumbnail;?>')">
            <div class="post-content">
                <p class="mb-2 category-badge">
                <?php foreach ($categories as $cat): ?>
                    <?=($i > 0 ? ', ' : '') . $cat->name; ?>
                    <?php $i++; ?>
                <?php endforeach; ?>
                </p>
                <h3 class="mb-3 mb-md-1">
                    <?= $post->post_title; ?>
                </h3>
                <p class="mb-md-0">
                <?php
                    $propostExcerpt = $post->post_excerpt;
                    $mobilePropostExcerpt = $post->post_excerpt;
                    $excerptLimit = 180;
                    $mobileExcerptLimit = 120;
                    if (strlen($propostExcerpt) > $excerptLimit) {
                        $propostExcerpt = wordwrap($propostExcerpt, $excerptLimit);
                        $propostExcerpt = substr($propostExcerpt, 0, strpos($propostExcerpt, "\n")) . '...';
                    }
                    if (strlen($mobilePropostExcerpt) > $mobileExcerptLimit) {
                        $mobilePropostExcerpt = wordwrap($mobilePropostExcerpt, $mobileExcerptLimit);
                        $mobilePropostExcerpt = substr($mobilePropostExcerpt, 0, strpos($mobilePropostExcerpt, "\n")) . '...';
                    }
                    echo '<span class="d-block d-md-none">' . $mobilePropostExcerpt . '</span>';
                    echo '<span class="d-none d-md-block">' . $propostExcerpt . '</span>';
                    ?>
                </p>
                <p class="read-more white d-md-none"><?= __('Read more', 'selected-articles') ?> <i class="icon-arrow-right"></i></p>

            </div>
        </a>
    </div>
    <?php } else { ?>
    <div class="col-sm-6 post-card__hover">
        <a href="<?=$link;?>" class="post-card d-block">
            <figure class="ratio-16x9 post-image-wrapper">
                <img
                    class="post-image"
                    src="<?= $thumbnail; ?>"
                    />
            </figure>
            <div class="post-info pt-2">
                <p class="m-0 category-badge">
                    <?php foreach ($categories as $cat): ?>
                    <?=($i > 0 ? ', ' : '') . $cat->name; ?>
                    <?php $i++; ?>
                <?php endforeach; ?>
                </p>
                <h3 class="mb-0">
                    <?= $post->post_title;?>
                </h3>
                <p class="read-more mt-2 d-md-none"><?= __('Read more', 'selected-articles') ?> <i class="icon-arrow-right"></i></p>
            </div>
        </a>
    </div>
<?php
    }
}