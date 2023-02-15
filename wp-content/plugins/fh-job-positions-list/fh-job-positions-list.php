<?php
/**
 * Plugin Name:       [FH] Job Positions List
 * Description:       Block displaying all published Job positions.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Kambu
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       fh-job-positions-list
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
function create_block_fh_job_positions_list_block_init() {
	register_block_type( 
                __DIR__ . '/build',
                [
                    'render_callback' => 'fh_job_positions_list_block_render_callback'
                ]
                );
}
add_action( 'init', 'create_block_fh_job_positions_list_block_init' );


/**
 * This function is called when the block is being rendered on the front end of the site
 *
 * @param array    $attributes     The array of attributes for this block.
 * @param string   $content        Rendered block output. ie. <InnerBlocks.Content />.
 * @param WP_Block $block_instance The instance of the WP_Block class that represents the block being rendered.
 */
function fh_job_positions_list_block_render_callback( $attributes, $content, $block_instance ) {
	ob_start();
	/**
	 * Keeping the markup to be returned in a separate file is sometimes better, especially if there is very complicated markup.
	 * All of passed parameters are still accessible in the file.
	 */
	require plugin_dir_path( __FILE__ ) . 'template.php';
	return ob_get_clean();
}

function prepare_data_to_job_positions_list($attributes)
{
    
    $jobCategories = get_categories( 
            [
		'taxonomy'     => 'job-category',
		'orderby'      => 'name',
		'pad_counts'   => false,
		'hierarchical' => 1,
		'hide_empty'   => true
            ]
        );

    $jobLocalizations = get_categories(
            [
		'taxonomy'     => 'job-localization',
		'orderby'      => 'name',
		'pad_counts'   => false,
		'hierarchical' => 1,
		'hide_empty'   => true
            ]
        );
    
    $args = [
        'post_type' => 'job-position',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => "name",
        'order' => "asc"
    ];

    $results = new WP_Query($args);
    $jobs = [];
    if ($results->have_posts()) {
        foreach ($results->posts as $row) {
            $job = (object)[
                'categoryIds' => [],
                'localizationIds' => [],
                'categories' => [],
                'localizations' => [],
                'types' => [],
                'countries' => [],
                'id' => $row->ID,
                'title' => $row->post_title,
                'link' => get_permalink($row->ID)
            ];
            set_taxonomies($row, $job);
            $jobs[] = $job;
           
        }
    }
    
    
    return [$jobCategories, $jobLocalizations, $jobs];
}

function set_taxonomies($row, &$job)
{
    $terms = wp_get_post_terms($row->ID, ['job-category', 'job-localization', 'job-type', 'job-country']);
             
    foreach ($terms as $term) {
        switch ($term->taxonomy ) {
            case 'job-category': 
                $job->categoryIds[] = $term->term_id;
                $job->categories[] = $term->name;
                break;
            case 'job-localization': 
                $job->localizationIds[] = $term->term_id;
                $job->localizations[] = $term->name;
                break;
            case 'job-type': 
                $job->types[] = $term->name;
                break;
            case 'job-country': 
                $job->countries[] = $term->name;
                break;
            default:
                break;
        }
    }
}

function render_singel_job_item($job)
{
    
    ?>

    <a class="open-positions-banner__item" data-job-id="<?=$job->id;?>" data-categories="<?= implode('|', $job->categoryIds);?>"  data-localizations="<?= implode('|', $job->localizationIds);?>" href="<?=$job->link;?>">
        <div class="open-positions-banner__item-main">
            <div class="open-positions-banner__item-content">
                <h3 class="open-positions-banner__item-content-title"><?=$job->title;?></h3>
                <p>
                    <?php if (count($job->localizations) > 0) :?>
                        <?=implode(', ', $job->localizations);?>,
                    <?php endif;?>
                    <?php if (count($job->types) > 0) :?>
                        <?=implode(', ', $job->types);?>, 
                    <?php endif;?>
                    <?php if (count($job->countries) > 0) :?>
                        <?=implode(', ', $job->countries);?>
                    <?php endif;?>
                </p>
            </div>
            <span class="open-positions-banner__item-icon">
                <i class="icon-arrow-right"></i>
            </span>
        </div>
    </a>
<?php
}