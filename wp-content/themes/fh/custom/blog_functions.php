<?php
$theme_dir = get_template_directory();
require_once $theme_dir . '/custom/helpers/pagination.php';
require_once $theme_dir . '/custom/helpers/page_type.php';
//custom


// Add our own.
add_action( 'generate_before_do_template_part', function() {

    if ( is_home() ) : 
        $page_for_posts = get_option( 'page_for_posts' );
        $post = get_post($page_for_posts);
        $blocks = parse_blocks($post->post_content);
        foreach ($blocks as $block) {
            echo render_block($block);
        }
    endif;
} );

function preparePostFilters()
{
    $categories = [];
    $tags = [];
   
    foreach (get_categories() as $cat) {
        $categories[$cat->cat_ID] = $cat->name; 
    }
    $postsPerPage = 9;
    if (!isset($_GET['page']) || $_GET['page'] < 1) {
        $_GET['page'] = 1;
    }
    $selected = $_GET;
    $queryArgs = prepareQueryArgs($selected, $postsPerPage, 'post');
            
    return [$categories, $selected, $queryArgs, $postsPerPage];
}


function prepareQueryArgs($selected, $postsPerPage, $postType)
{
    $sortConfig = [
        'postDateDESC' => [
            'orderby' => 'post_date',
            'order' => 'DESC',
        ],
        'postDateASC' => [
            'orderby' => 'post_date',
            'order' => 'ASC',
        ],
    ];
    $metaQuery = [];
    $args = [
        'post_type' => $postType,
        'post_status' => 'publish',
        'posts_per_page' => $postsPerPage,
        'orderby' => isset($selected['order']) ? $sortConfig[$selected['order']]['orderby'] : "ID",
        'order' => "DESC",
        'paged' => $selected['page']
    ];
    if (isset($selected['s']) && !empty($selected['s'])) {
        $args['s'] = $selected['s'];
    }
    
    //dodane sprawdzenie is_array, bo przy załadowaniu strony nie jest tablicą
    if (isset($selected['category']) && is_array($selected['category']) && !in_array('ALL', $selected['category'])) {
        $args['cat'] = $selected['category'];
    }
    if (isset($selected['tag']) && !in_array('ALL', $selected['tags'])) {
        $args['tag'] = $selected['tag'];
    }
    if (!empty($metaQuery)) {
        $args['meta_query'] = $metaQuery;
    }

    
    return $args;
}


function postSearchScript()
{
    wp_enqueue_script('postSearch');

    $scriptParams = [
        'ajax_url' => site_url() . '/wp-admin/admin-ajax.php?lang='.pll_current_language(),
        'afp_nonce' => wp_create_nonce('afp_nonce'),
        'currentPage' => isset($_GET['page']) && !empty($_GET['page']) ? trim($_GET['page']) : "1"
    ];
    
    wp_localize_script('custom-scripts', 'postSearchParams', $scriptParams);

}
add_action('wp_enqueue_scripts', 'postSearchScript', 100);


function postSearchHandler()
{   
    if (!isset($_POST['afp_nonce']) || !wp_verify_nonce($_POST['afp_nonce'], 'afp_nonce')) {
        return;
    }
    if ($_POST['action'] !== 'posts_search') {
        return;
    }
    $selected = $_POST;
    $postsPerPage = 9;
    $queryArgs = prepareQueryArgs($selected, $postsPerPage, 'post');
    $results = new WP_Query($queryArgs);
    
    $totalPages = ceil($results->found_posts / $postsPerPage);
   
    $items = [];
    $postsHtml = '';
    $paginationHtml = '';
    
    if (!empty($queryArgs['s'])) {
        ob_start();
        set_query_var('searchText', $queryArgs['s']);
        get_template_part('archive-search-info');
        $postsHtml .= ob_get_contents();
        ob_clean();
        ob_end_clean();
    }
    if ($results->have_posts()) {
        foreach ($results->posts as $row) {
            $item = new stdClass();
            $item->thumbnail = get_the_post_thumbnail_url($row->ID, 'medium');
            $item->title = $row->post_title;
            $item->date = get_the_date(get_option('date_format'), $row->ID);
            $item->link = get_permalink($row->ID);
            $items[] = $item;
        }
        ob_start();
        foreach ($items as $item) {
            set_query_var('item', $item);
            get_template_part('archive-item');
            $post = ob_get_contents();
            $postsHtml .= $post;
            ob_clean();
        }
        ob_end_clean();
        $paginationHtml .= pagination($selected['page'], $totalPages, $postsPerPage);
        
    } else {
        ob_start();
        get_template_part('archive-empty-list');
        $postsHtml .= ob_get_contents();
        ob_clean();
        ob_end_clean();
    }
//    
//    ob_end_clean();
    
    $response = [
        'items' => $postsHtml,
        'pagination' => $paginationHtml,
        'success' => true
    ];
    echo json_encode($response);
    wp_die();

}

add_action('wp_ajax_posts_search', 'postSearchHandler');
add_action('wp_ajax_nopriv_posts_search', 'postSearchHandler');

