<?php
/**
 * Plugin Name:       [FH] Products - Featured products
 * Description:       Two interactive segments. Clicking on a product leads to subpage with more information. Segments displays a photo of a product with transparent background.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Kambu
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       featured-products
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
function create_block_featured_products_block_init()
{
	register_block_type(
		__DIR__ . '/build',
		[
			'render_callback' => 'featured_products_block_render_callback',
		]
	);
	wp_register_style('featured-products-style', plugin_dir_path(__FILE__) . '/style.css');
}
add_action('init', 'create_block_featured_products_block_init');


/**
 * This function is called when the block is being rendered on the front end of the site
 *
 * @param array    $attributes     The array of attributes for this block.
 * @param string   $content        Rendered block output. ie. <InnerBlocks.Content />.
 * @param WP_Block $block_instance The instance of the WP_Block class that represents the block being rendered.
 */
function featured_products_block_render_callback($attributes, $content, $block_instance)
{
	ob_start();
	/**
	 * Keeping the markup to be returned in a separate file is sometimes better, especially if there is very complicated markup.
	 * All of passed parameters are still accessible in the file.
	 */
	require plugin_dir_path(__FILE__) . 'template.php';
	return ob_get_clean();
}

function prepare_product_template($product, $productBackground)
{
	$thumbnail = get_the_post_thumbnail_url($product->ID, 'medium');
	$link = get_permalink($product->ID);
	$categories = wp_get_post_terms($product->ID, 'product_cat');
?>
<a href="<?= $link; ?>" class="featured-product post-card">
	<div class="row featured-product__content">
		<div class="col-sm-12 col-lg-7 col-xl-7 featured-product__content-col">
			<div class="featured-product__content-col--item">
				<?php if (count($categories) > 0):
					$i = 0 ?>
					<p class="h3 mb-2">
						<?php foreach ($categories as $cat): ?>
						<?=($i > 0 ? ', ' : '') . $cat->name; ?>

							<?php $i++; ?>
							<?php endforeach; ?>
					</p>
				<?php endif; ?>
				<h2 class="featured-product__title mb-3 mt-3">
					<?= $product->post_title; ?>
				</h2>
				<div class="featured-product__text">
					<?php
						$productExcerpt = $product->post_excerpt;
						$excerptLimit = 120;
						if (strlen($productExcerpt) > $excerptLimit) {
							$productExcerpt = wordwrap($productExcerpt, $excerptLimit);
							$productExcerpt = substr($productExcerpt, 0, strpos($productExcerpt, "\n")) . '...';
						}
						echo $productExcerpt;
					 ?>
				</div>
			</div>
		</div>
		<div class="col-sm-12 col-lg-5 col-xl-5 featured-product__bg-container"
			style="background-image: url('<?= $productBackground ?>')">
			<img class="featured-product__photo" src="<?= $thumbnail; ?>'" />
		</div>
	</div>
</a>
<?php
}