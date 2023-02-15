<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


get_header();

list($categories, $selected, $queryArgs, $postsPerPage) = preparePostFilters();

$posts = new WP_Query($queryArgs);
$totalPages = ceil($posts->found_posts / $postsPerPage);
?>

<div <?php generate_do_attr('content'); ?>>
    <main>
        <?php generate_do_template_part('content'); ?>

        <section class="lgrey-bg pb-5" id="posts">
            <div class="container">
                <form class="row align-items-end" id="posts-filters" method="get">
                    <div class="col-lg-8 blog-list-title-col">
                        <h2 class="mb-4">
                            <?php pll_e('Latest articles'); ?>
                        </h2>
                    </div>
                    <div class="col-lg-4 mb-4 flex-column d-flex">
                        <select class="select2" name="category[]" multiple="multiple" data-placeholder="<?php pll_e('All categories') ?>">
                            <?php if (!empty($categories)) :?>
                                <?php foreach ($categories as $slug => $name) :?>
                                    <option value="<?=$slug;?>" <?= in_array($slug, $selected['category'])  ? 'selected' : '';?>><?=$name;?></option>
                                <?php endforeach;?>
                            <?php endif;?>
                        </select>
                    </div>
                    <input name="page" value="<?= $selected['page']; ?>" type="hidden" />
                    <input name="s" value="<?= $selected['s']; ?>" type="hidden" />
                </form>
                <div class="row my-md-5 filters-list-items">
                    <?php if (!empty($selected['s'])):
                            set_query_var('searchText', $selected['s']);
                            get_template_part('archive-search-info');
                        endif; 
                    ?>
                        
                    <?php if ($posts->have_posts()): ?>
                        <?php while ($posts->have_posts()):
                                $posts->the_post();
                                $item = new stdClass();
                                $item->thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'large');
                                $item->title = get_the_title();
                                $item->category = get_the_category(get_the_ID());
                                $item->link = get_the_permalink();

                                set_query_var('item', $item);
                                get_template_part('archive-item');
                        
                            endwhile;?>
                    <?php else: 
                        get_template_part('archive-empty-list'); 
                    endif; ?>

                </div>
                <div class="row">
                    <div class="col-md-12 pagination-container">
                        <?= pagination($selected['page'], $totalPages, $postsPerPage) ?>
                    </div>
                </div>
            </div>
        </section>

        <script>
            var productsBlockContainer = document.getElementById('blog-list');
            var productsWrapper = document.getElementById('posts');
            document.addEventListener("DOMContentLoaded", () => {
                productsBlockContainer.replaceWith(productsWrapper)
            });
        </script>

        <?php
        /**
         * generate_after_main_content hook.
         *
         * @since 0.1
         */
        do_action('generate_after_main_content');
        ?>
    </main>
</div>


<?php
/**
 * generate_after_primary_content_area hook.
 *
 * @since 2.0
 */
do_action('generate_after_primary_content_area');

generate_construct_sidebars();

get_footer();
