<?php

add_filter( 'pll_the_languages_args', 'my_language_switcher_args' );
 
function my_language_switcher_args( $args ) {
    $args['display_names_as'] = 'slug';
    return $args;
}


add_action('init', function() {
  pll_register_string('back_to_menu_footer', 'Back to menu');
  pll_register_string('terms_and_conditions_footer', 'Terms and conditions');
  pll_register_string('privacy_policy_footer', 'Privacy policy');
  pll_register_string('copyright_2022_futurehome_as_footer', '© Copyright 2022 Futurehome AS. All rights reserved. Made by ');
  pll_register_string('pay_scales_job_position', 'Pay scales');
  pll_register_string('we_haven_t_added_anything_here_yet_archive_empty_list', 'We haven`t added anything here yet');
  pll_register_string('search_results_for_archive_search_info', 'Search results for:');
  pll_register_string('share_on_your_social_media_job_position', 'Share on your social media');
  pll_register_string('or_social_media_job_position', 'or');
  pll_register_string('article_content_single', 'Article');
  pll_register_string('back_to_blog_list_content_single', 'Back to blog list');
  pll_register_string('read_more_content_single', 'Read more');
  pll_register_string('latest_articles_home', 'Latest articles');
  pll_register_string('all_categories_home', 'All categories');
  pll_register_string('nothing_found_no_results', 'Nothing Found');
  pll_register_string('sorry_but_nothing_matched_your_search_no_results', 'Sorry, but nothing matched your search terms. Please try again with some different keywords.');
  pll_register_string('it_seems_we_cant_find_what_you_re_looking_for_no_results', 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.');
  
  pll_register_string('read_more_archive', 'Read more');
  pll_register_string('all_products_archive_products', 'All products');
  pll_register_string('no_products_found_archive_products', 'No products found');
  pll_register_string('product_additional_information_tab', 'Technical details');
  pll_register_string('buy_now_product', 'Buy now');
  pll_register_string('find_an_installer', 'Find an installer');
  pll_register_string('buy_via_partner', 'Buy via partner');
  pll_register_string('visit_partner_button', 'Visit partner');
  pll_register_string('search_title_search', 'Search');
  pll_register_string('search_title_results_found', 'results found');
  pll_register_string('search_headers_posts', 'Posts');
  pll_register_string('search_headers_sites', 'Sites');
  pll_register_string('search_headers_products', 'Products');
  pll_register_string('search_headers_all_types', 'All types');
  pll_register_string('search_headers_result_categories', 'Result categories');
});
