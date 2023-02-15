<?php
/**
 * Plugin Name:       [FH] Blog - Selected Articles
 * Description:       Interactive module with button leading to the blog page. Two interactive segments showing a shortcut of a specific article. Clicking on a segment is leading to an article.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Kambu
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       selected-articles
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
function create_block_selected_articles_block_init()
{
    register_block_type(
        __DIR__ . '/build',
        [
            'render_callback' => 'selected_articles_block_render_callback',
        ]
    );
}
add_action('init', 'create_block_selected_articles_block_init');


/**
 * This function is called when the block is being rendered on the front end of the site
 *
 * @param array    $attributes     The array of attributes for this block.
 * @param string   $content        Rendered block output. ie. <InnerBlocks.Content />.
 * @param WP_Block $block_instance The instance of the WP_Block class that represents the block being rendered.
 */
function selected_articles_block_render_callback($attributes, $content, $block_instance)
{
    ob_start();
    /**
     * Keeping the markup to be returned in a separate file is sometimes better, especially if there is very complicated markup.
     * All of passed parameters are still accessible in the file.
     */
    require plugin_dir_path(__FILE__) . 'template.php';
    return ob_get_clean();
}

function prepare_article_template($article)
{
    $thumbnail = get_the_post_thumbnail_url($article->ID, 'large');
    $link = get_permalink($article->ID);
?>
<a href="<?= $link; ?>" class="post-card">
    <?php if (null !== $thumbnail): ?>
    <figure class="post-image-wrapper mb-2">
        <img class="post-image" src="<?= $thumbnail; ?>" />
    </figure>
    <?php endif; ?>
    <div class="post-info py-2">
        <h3 class="m-md-0"><?= $article->post_title;?></h3>
        <div class="d-sm-none mb-3 mobile-excerpt">
        <?php
            $postExcerpt = $article->post_excerpt;
            $excerptLimit = 90;
            if (strlen($postExcerpt) > $excerptLimit) {
                $productExcerpt = wordwrap($postExcerpt, $excerptLimit);
                $productExcerpt = substr($postExcerpt, 0, strpos($productExcerpt, "\n")) . '...';
            }
            echo $productExcerpt;
        ?>
        </div>
        <p class="read-more d-md-none"><?= __('Read more', 'selected-articles') ?> <i class="icon-arrow-right"></i></p>
    </div>
</a>
<?php
}