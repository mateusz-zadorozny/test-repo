<?php
/**
 * The template for displaying posts within the loop.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$item = get_query_var('item');
$product = get_query_var('product');
$page = get_query_var('page');
?>


<?php
if ($item): 
    $formatTime = 'F j, Y';
    $stringDate = strtotime($item->post_date);

    $content = $item->post_content ;
    if ($content) {
        preg_match_all('|<p>(.*?)</p>|', $content, $output);
        $content = $output[0][0];
        $ret = get_custom_excerpt($content, 400);
    }
    $excerpt = $ret ? $ret : '';
?>
<article>
    <div>
       <?php gp_breadcrumbs($item) ?>
        <a href="<?php echo get_permalink($item->ID); ?>">
            <h3><?php echo $item->post_title ?></h3>
            <p><?php echo $excerpt ?></p>
            <p class="post-meta">
                <span><?php echo wp_date($formatTime, $stringDate) ?></span>
            </p>
        </a>
    </div>
</article>
<?php endif;


if ($page): 
    $content = $page->post_content ;
    if ($content) {
        preg_match_all('|<p>(.*?)</p>|', $content, $output);
        $content = trim(strip_tags($output[0][0]));
        
        if (empty($content)) {
            $content = $page->post_content ;
            preg_match_all('|<p(.*?)</p>|', $content, $output);
            $content = trim(strip_tags($output[0][0]));
        }
        
        $ret = get_custom_excerpt( $content, 800);
    }
    $excerpt = $ret ? $ret : '';
?>
<article>
    <div>
        <a href="<?php echo get_permalink($page->ID); ?>">
            <h3><?php echo $page->post_title ?></h3>
            <p><?php echo $excerpt ?></p>
        </a>
    </div>
    
</article>
<?php endif;

?>


<?php
if ($product): 

    $product = wc_get_product( $product->ID);
?>


<div class="col-sm-6 col-xxl-4 mb-4">
    <a href="<?php echo $product->get_permalink(); ?>" rel="bookmark" title="<?php echo $product->get_title(); ?>" class="product-card lgrey">
        <figure class="product-image">
            <?php echo $product->get_image(); ?>
        </figure>
        <div class="product-card-content">
            <h3 class="mb-0"> <?php echo $product->get_title(); ?></h3>
            <p class="product-price"><?php echo $product->get_price_html(); ?></p>
        </div>
    </a>

</div>
<?php endif;

