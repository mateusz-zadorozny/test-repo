<?php
$theme_dir = get_template_directory();
require_once $theme_dir . '/custom/helpers/page_type.php';

function search_filter($query) {
        
    if ( $query->is_search && (!is_admin() && !wp_is_json_request() && !isBlogPage() && !wp_doing_ajax()) ) {
        $query->set( 'post_type', ['post', 'page', 'product'] );
        $query->set( 'posts_per_page', -1 );
    }
}
add_action( 'pre_get_posts', 'search_filter');


function gp_breadcrumbs($post) {
    
    $delimiter = '<span class="delimiter">></span>';
    $home = 'Homepage'; // text for 'Homepage' link
    $before = '<span class="current">'; // tag before crumb
    $after = '</span>'; // tag after crumb
  
    $postType = $post->post_type;
    $postTitle = $post->post_title;

    if ($postType == 'post'){
        $postTitle = get_custom_excerpt($postTitle, 50);
    }

    $homeLink = get_bloginfo( 'url' );
    $page_for_posts_id = get_option('page_for_posts', true);
    $titleCategory = get_the_title($page_for_posts_id);
    $pemalinkCategory = get_permalink($page_for_posts_id);

    if ( is_search() ) {
        if ($postType == 'post') {
            echo '<div id="crumbs" class="breadcrumbs"><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ' . '<a href="' . $pemalinkCategory . '">' . $titleCategory . '</a> ' . $delimiter . ' ' . $postTitle ;
            echo '</div>';
        } else {
            echo '<div id="crumbs" class="breadcrumbs"><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
            echo '</div>';
        }
    };
    
}

function get_custom_excerpt($content, $limit) {
    
    $content = strip_tags($content);
        $content = strip_shortcodes($content);
        $content = trim(preg_replace('/\s+/', ' ', $content));
        $ret = $content;

        if (mb_strlen($content) >= $limit) {
           $ret = mb_substr($content, 0, $limit);
           if (mb_substr($ret, -1) !== ' ') {
              $space_pos_in_substr = mb_strrpos($ret, ' ');
              $space_pos_in_content = mb_strpos($content, ' ', $limit);
              if ($space_pos_in_content != false && $space_pos_in_content - $limit <= $limit - $space_pos_in_substr) {
                 $ret = mb_substr($content, 0, $space_pos_in_content);
              } else {
                 $ret = mb_substr($content, 0, $space_pos_in_substr);
              }
           }
        }
        if ($ret){
            return $ret . '...';
        }
        return $ret;
    
 }

 add_filter( 'posts_search', function( $search, \WP_Query $q )
{
    if( ! is_admin() && empty( $search ) && $q->is_search() && $q->is_main_query() )
        $search .=" AND 0=1 ";

    return $search;
}, 10, 2 );

add_filter( 'generate_navigation_search_output', function() {
    $current_language = '';
    $url = home_url('/');
    if ( function_exists( 'pll_current_language' ) ) {
        $current_language = pll_current_language();
        
        if ( 'en' !== $current_language ) {
	    $urlArr =  explode('/', $url);
            if (end($urlArr) === '') {
                array_pop($urlArr);
            }
            if (end($urlArr) !== $current_language) {
                array_pop($urlArr);
                
                $url = implode('/', $urlArr) . '/';
            }
        }
    }

    return sprintf( // WPCS: XSS ok, sanitization ok.
        '<form method="get" class="search-form navigation-search" action="%1$s">
                <input type="search" class="search-field" value="%2$s" name="s" title="%3$s" />
        </form>',
        esc_url($url),
        esc_attr( get_search_query() ),
        esc_attr_x( 'Search', 'label', 'generatepress' )
    );
} );

