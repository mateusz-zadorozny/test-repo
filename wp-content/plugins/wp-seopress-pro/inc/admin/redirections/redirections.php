<?php
defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

///////////////////////////////////////////////////////////////////////////////////////////////////
//Register SEOPress Redirections Custom Post Type
///////////////////////////////////////////////////////////////////////////////////////////////////
function seopress_404_fn() {
    $labels = [
        'name' => _x('Redirections', 'Post Type General Name', 'wp-seopress-pro'),
        'singular_name' => _x('Redirections', 'Post Type Singular Name', 'wp-seopress-pro'),
        'menu_name' => __('Redirections', 'wp-seopress-pro'),
        'name_admin_bar' => __('Redirections', 'wp-seopress-pro'),
        'archives' => __('Item Archives', 'wp-seopress-pro'),
        'parent_item_colon' => __('Parent Item:', 'wp-seopress-pro'),
        'all_items' => __('All redirections', 'wp-seopress-pro'),
        'add_new_item' => __('Add New redirection', 'wp-seopress-pro'),
        'add_new' => __('Add redirection', 'wp-seopress-pro'),
        'new_item' => __('New redirection', 'wp-seopress-pro'),
        'edit_item' => __('Edit redirection', 'wp-seopress-pro'),
        'update_item' => __('Update redirection', 'wp-seopress-pro'),
        'view_item' => __('View redirection', 'wp-seopress-pro'),
        'search_items' => __('Search redirection', 'wp-seopress-pro'),
        'not_found' => __('Not found', 'wp-seopress-pro'),
        'not_found_in_trash' => __('Not found in Trash', 'wp-seopress-pro'),
        'featured_image' => __('Featured Image', 'wp-seopress-pro'),
        'set_featured_image' => __('Set featured image', 'wp-seopress-pro'),
        'remove_featured_image' => __('Remove featured image', 'wp-seopress-pro'),
        'use_featured_image' => __('Use as featured image', 'wp-seopress-pro'),
        'insert_into_item' => __('Insert into item', 'wp-seopress-pro'),
        'uploaded_to_this_item' => __('Uploaded to this item', 'wp-seopress-pro'),
        'items_list' => __('Redirections list', 'wp-seopress-pro'),
        'items_list_navigation' => __('Redirections list navigation', 'wp-seopress-pro'),
        'filter_items_list' => __('Filter redirections list', 'wp-seopress-pro'),
    ];
    $args = [
        'label' => __('Redirections', 'wp-seopress-pro'),
        'description' => __('Redirections and Monitoring 404', 'wp-seopress-pro'),
        'labels' => $labels,
        'supports' => ['title'],
        'hierarchical' => false,
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => false,
        'menu_icon' => 'dashicons-admin-links',
        'show_in_admin_bar' => false,
        'show_in_nav_menus' => false,
        'can_export' => true,
        'has_archive' => false,
        'exclude_from_search' => true,
        'publicly_queryable' => false,
        'capability_type' => 'redirection',
        'capabilities' => [
            'edit_post' => 'edit_redirection',
            'edit_posts' => 'edit_redirections',
            'edit_others_posts' => 'edit_others_redirections',
            'publish_posts' => 'publish_redirections',
            'read_post' => 'read_redirection',
            'read_private_posts' => 'read_private_redirections',
            'delete_post' => 'delete_redirection',
            'delete_others_posts' => 'delete_others_redirections',
            'delete_published_posts' => 'delete_published_redirections',
        ],
    ];
    register_post_type('seopress_404', $args);
}
add_action('admin_init', 'seopress_404_fn', 10);

///////////////////////////////////////////////////////////////////////////////////////////////////
//Map SEOPress 404 caps
///////////////////////////////////////////////////////////////////////////////////////////////////
add_filter('map_meta_cap', 'seopress_404_map_meta_cap', 10, 4);
function seopress_404_map_meta_cap($caps, $cap, $user_id, $args) {
    /* If editing, deleting, or reading a redirection, get the post and post type object. */
    if ('edit_redirection' === $cap || 'delete_redirection' === $cap || 'read_redirection' === $cap) {
        $post = get_post($args[0]);
        $post_type = get_post_type_object($post->post_type);

        /* Set an empty array for the caps. */
        $caps = [];
    }

    /* If editing a redirection, assign the required capability. */
    if ('edit_redirection' === $cap) {
        if ($user_id == $post->post_author) {
            $caps[] = $post_type->cap->edit_posts;
        } else {
            $caps[] = $post_type->cap->edit_others_posts;
        }
    }

    /* If deleting a redirection, assign the required capability. */
    elseif ('delete_redirection' === $cap) {
        if ($user_id == $post->post_author) {
            $caps[] = $post_type->cap->delete_published_posts;
        } else {
            $caps[] = $post_type->cap->delete_others_posts;
        }
    }

    /* If reading a private redirection, assign the required capability. */
    elseif ('read_redirection' === $cap) {
        if ('private' !== $post->post_status) {
            $caps[] = 'read';
        } elseif ($user_id == $post->post_author) {
            $caps[] = 'read';
        } else {
            $caps[] = $post_type->cap->read_private_posts;
        }
    }

    /* Return the capabilities required by the user. */
    return $caps;
}

///////////////////////////////////////////////////////////////////////////////////////////////////
//Register SEOPress Custom Taxonomy Categories for Redirections
///////////////////////////////////////////////////////////////////////////////////////////////////
function seopress_404_cat_fn() {
    $labels = [
        'name' => _x('Categories', 'Taxonomy General Name', 'wp-seopress-pro'),
        'singular_name' => _x('Category', 'Taxonomy Singular Name', 'wp-seopress-pro'),
        'menu_name' => __('Categories', 'wp-seopress-pro'),
        'all_items' => __('All Categories', 'wp-seopress-pro'),
        'parent_item' => __('Parent Category', 'wp-seopress-pro'),
        'parent_item_colon' => __('Parent Category:', 'wp-seopress-pro'),
        'new_item_name' => __('New Category Name', 'wp-seopress-pro'),
        'add_new_item' => __('Add New Category', 'wp-seopress-pro'),
        'edit_item' => __('Edit Category', 'wp-seopress-pro'),
        'update_item' => __('Update Category', 'wp-seopress-pro'),
        'view_item' => __('View Category', 'wp-seopress-pro'),
        'separate_items_with_commas' => __('Separate categories with commas', 'wp-seopress-pro'),
        'add_or_remove_items' => __('Add or remove categories', 'wp-seopress-pro'),
        'choose_from_most_used' => __('Choose from the most used', 'wp-seopress-pro'),
        'popular_items' => __('Popular Categories', 'wp-seopress-pro'),
        'search_items' => __('Search Categories', 'wp-seopress-pro'),
        'not_found' => __('Not Found', 'wp-seopress-pro'),
        'no_terms' => __('No items', 'wp-seopress-pro'),
        'items_list' => __('Categories list', 'wp-seopress-pro'),
        'items_list_navigation' => __('Categories list navigation', 'wp-seopress-pro'),
    ];
    $args = [
        'labels' => $labels,
        'hierarchical' => true,
        'public' => false,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => false,
        'show_tagcloud' => false,
        'rewrite' => false,
        'show_in_rest' => false,
    ];
    register_taxonomy('seopress_404_cat', ['seopress_404'], $args);
}
add_action('init', 'seopress_404_cat_fn', 10);

///////////////////////////////////////////////////////////////////////////////////////////////////
//Add custom buttons to SEOPress Redirections Custom Post Type
///////////////////////////////////////////////////////////////////////////////////////////////////
function seopress_404_btn_cpt() {
    $screen = get_current_screen();
    if ('seopress_404' === $screen->post_type) {
        ?>
<script>
jQuery(function() {
jQuery("body.post-type-seopress_404 .wrap h1 ~ a").after(
    '<a href="<?php echo admin_url('admin.php?page=seopress-import-export#tab=tab_seopress_tool_redirects'); ?>" id="seopress-import-redirects" class="page-title-action"><?php _e('Import / Export redirects', 'wp-seopress-pro'); ?></a>'
);

jQuery("body.post-type-seopress_404 .wrap h1 ~ #seopress-import-redirects").after(
    '<a href="<?php echo admin_url('admin.php?page=seopress-pro-page#tab=tab_seopress_404'); ?>" id="seopress-redirections-settings" class="page-title-action"><?php _e('Settings', 'wp-seopress-pro'); ?></a>'
);

jQuery("body.post-type-seopress_404 .wrap h1 ~ #seopress-redirections-settings").after(
    '<a href="<?php echo admin_url('admin.php?page=seopress-import-export#tab=tab_seopress_tool_redirects'); ?>" id="seopress-clean-404" class="page-title-action"><?php _e('Clean your 404', 'wp-seopress-pro'); ?></a>'
);

jQuery("body.post-type-seopress_404 .wrap h1 ~ #seopress-clean-404").after(
    '<a href="<?php echo admin_url('admin.php?page=seopress-import-export#tab=tab_seopress_tool_redirects'); ?>" id="seopress-clean-redirects" class="page-title-action"><?php _e('Clean all entries', 'wp-seopress-pro'); ?></a>'
);
});
</script>
<?php
    }
}
add_action('admin_head', 'seopress_404_btn_cpt');

///////////////////////////////////////////////////////////////////////////////////////////////////
//Add buttons to post type list if empty
///////////////////////////////////////////////////////////////////////////////////////////////////
add_action('manage_posts_extra_tablenav', 'seopress_404_maybe_render_blank_state');

function seopress_404_render_blank_state() { ?>
<div class="seopress-BlankState">

<h2 class="seopress-BlankState-message">
<?php esc_html_e('Your redirections and 404 errors will appear here.', 'wp-seopress-pro'); ?>
</h2>

<div class="seopress-BlankState-buttons">

<a class="seopress-BlankState-cta btn btnPrimary"
    href="<?php echo esc_url(admin_url('post-new.php?post_type=seopress_404')); ?>"><?php esc_html_e('Create a redirect', 'wp-seopress-pro'); ?></a>
<a class="seopress-BlankState-cta button"
    href="<?php echo esc_url(admin_url('admin.php?page=seopress-import-export#tab=tab_seopress_tool_redirects')); ?>"><?php esc_html_e('Start Import', 'wp-seopress-pro'); ?></a>

</div>

</div>

<?php
}
function seopress_404_maybe_render_blank_state($which) {
    global $post_type;

    if ('seopress_404' === $post_type && 'bottom' === $which) {
        $counts = (array) wp_count_posts($post_type);
        unset($counts['auto-draft']);
        $count = array_sum($counts);

        if (0 < $count) {
            return;
        }

        seopress_404_render_blank_state();

        echo '<style type="text/css">#posts-filter .wp-list-table, #posts-filter .tablenav.top, .tablenav.bottom .actions, .wrap .subsubsub  { display: none; } #posts-filter .tablenav.bottom { height: auto; } </style>';
    }
}
///////////////////////////////////////////////////////////////////////////////////////////////////
//Row actions links
///////////////////////////////////////////////////////////////////////////////////////////////////
function seopress_404_row_actions($actions, $post) {
    if ('seopress_404' === get_post_type()) {
        //WPML
        add_filter('wpml_get_home_url', 'seopress_remove_wpml_home_url_filter', 20, 5);

        if ('yes' == get_post_meta(get_the_ID(), '_seopress_redirections_enabled', true)) {
            $actions['seopress_404_test'] = "<a href='" . get_home_url() . '/' . get_the_title() . "' target='_blank'>" . __('Test redirection', 'wp-seopress-pro') . '</a>';
        }

        //WPML
        remove_filter('wpml_get_home_url', 'seopress_remove_wpml_home_url_filter', 20);
    }

    return $actions;
}
add_filter('post_row_actions', 'seopress_404_row_actions', 10, 2);

///////////////////////////////////////////////////////////////////////////////////////////////////
//Filters view
///////////////////////////////////////////////////////////////////////////////////////////////////
add_filter('views_edit-seopress_404', 'seopress_404_filter_views_cpt');
function seopress_404_filter_views_cpt($views) {

    $current_view = '';

    if ( isset( $_GET['post_status'] ) ) {
        $current_view = sanitize_text_field( wp_unslash( $_GET['post_status'] ) );
    }

    $views = [
        'redirects' => [
            'href' => admin_url('edit.php?post_type=seopress_404&post_status=redirects'),
            'i18n' => __('Redirects','wp-seopress-pro')
        ],
        '404' => [
            'href' => admin_url('edit.php?post_type=seopress_404&action=-1&m=0&redirect-cat=0&redirection-type=404&redirection-enabled&filter_action=Filter&paged=1&action2=-1&post_status=404'),
            'i18n' => __('404 errors','wp-seopress-pro')
        ],
        'all' => [
            'href' => admin_url('edit.php?post_type=seopress_404&post_status=all'),
            'i18n' => __('All','wp-seopress-pro'),
            'sub_links' => [
                0 => [
                    'href' => admin_url('edit.php?post_status=pending&post_type=seopress_404'),
                    'i18n' => __('Pending','wp-seopress-pro')
                ],
                1 => [
                    'href' => admin_url('edit.php?post_status=draft&post_type=seopress_404'),
                    'i18n' => __('Draft','wp-seopress-pro')
                ],
                2 => [
                    'href' => admin_url('edit.php?post_status=trash&post_type=seopress_404'),
                    'i18n' => __('Trash','wp-seopress-pro')
                ]
            ]
        ],
        'categories' => [
            'href' => admin_url('edit-tags.php?taxonomy=seopress_404_cat&post_type=seopress_404'),
            'i18n' => __('Categories','wp-seopress-pro')
        ],
    ];

    echo "<ul class='subsubsub'>\n";
    $count = count($views);
    $i = 1;
    foreach ( $views as $key => $view ) {
        $class = '';
        $aria = '';
        if ($key == $current_view) {
            $class = 'current';
            $aria = 'aria-current="page"';
        } ?>
        <li class=<?php echo $key; ?>>
            <a class="<?php echo $class; ?>" <?php echo $aria; ?> href="<?php echo $view['href']; ?>">
                <?php echo $view['i18n']; ?>
            </a>
            <?php if (!empty($view['sub_links'])) {
                $count_sub = count($view['sub_links']);
                $i_sub = 1;
                echo '(';
                foreach($view['sub_links'] as $_key => $_value) { ?>
                    <a class="<?php echo $class; ?>" <?php echo $aria; ?> href="<?php echo $_value['href']; ?>">
                        <?php echo $_value['i18n']; ?>
                    </a>
                    <?php if ($count_sub !== $i_sub) {
                        echo ' - ';
                    }
                    $i_sub++;
                }
                echo ')';
            }
            if ($count !== $i) {
                echo ' |';
            } ?>
        </li>
        <?php
        $i++;
    }

    echo '</ul>';
}

add_action('restrict_manage_posts', 'seopress_404_filters_cpt');
function seopress_404_filters_cpt() {
    global $typenow;

    if ('seopress_404' == $typenow) {
        $args = [
            'show_option_all' => __('All categories', 'wp-seopress-pro'),
            'show_option_none' => '',
            'option_none_value' => '-1',
            'orderby' => 'ID',
            'order' => 'ASC',
            'show_count' => 1,
            'hide_empty' => 0,
            'child_of' => 0,
            'exclude' => '',
            'include' => '',
            'echo' => 1,
            'selected' => 0,
            'hierarchical' => 0,
            'name' => 'redirect-cat',
            'id' => '',
            'class' => 'postform',
            'depth' => 0,
            'tab_index' => 0,
            'taxonomy' => 'seopress_404_cat',
            'hide_if_empty' => true,
            'value_field' => 'slug',
        ];
        wp_dropdown_categories($args);

        $redirections_type = ['301', '302', '307', '404', '410', '451'];
        $redirections_enabled = ['yes' => 'Enabled', 'no' => 'Disabled'];

        echo "<select name='redirection-type' id='redirection-type' class='postform'>";
        echo "<option value=''>" . __('Show All', 'wp-seopress-pro') . '</option>';
        foreach ($redirections_type as $type) {
            echo '<option value=' . $type, isset($_GET[$type]) == $type ? ' selected="selected"' : '','>' . $type . '</option>';
        }
        echo '</select>';

        echo "<select name='redirection-enabled' id='redirection-enabled' class='postform'>";
        echo "<option value=''>" . __('All status', 'wp-seopress-pro') . '</option>';
        foreach ($redirections_enabled as $enabled => $value) {
            echo '<option value=' . $enabled, isset($_GET[$enabled]) == $enabled ? ' selected="selected"' : '','>' . $value . '</option>';
        }
        echo '</select>';
    }
}

add_filter('parse_query', 'seopress_404_filters_action');
function seopress_404_filters_action($query) {
    global $pagenow;
    $current_page = isset($_GET['post_type']) ? $_GET['post_type'] : '';

    if (is_admin() && 'seopress_404' == $current_page && 'edit.php' == $pagenow
    && (!isset($_GET['post_status']) && !isset($_GET['s']))) {
        wp_safe_redirect( admin_url( 'edit.php?post_type=seopress_404&post_status=redirects' ), '301' );
        exit();
    }

    if (is_admin() && 'seopress_404' == $current_page && 'edit.php' == $pagenow && (isset($_GET['post_status']) &&
        ('redirects' == $_GET['post_status']))) {
            $query->query_vars['meta_query'] = [
                [
                    'key' => '_seopress_redirections_type',
                    'value' => null,
                    'compare' => '!=',
                ],
            ];
    }

    if (is_admin() && 'seopress_404' == $current_page && 'edit.php' == $pagenow && (isset($_GET['redirect-cat']) &&
        ('0' != $_GET['redirect-cat']))) {
        $redirection_cat = $_GET['redirect-cat'];
        $query->query_vars['tax_query'] = [
            [
                'taxonomy' => 'seopress_404_cat',
                'field' => 'slug',
                'terms' => $redirection_cat,
            ],
        ];
    }

    if (is_admin() && 'seopress_404' == $current_page && 'edit.php' == $pagenow && (isset($_GET['redirect-cat']) &&
        '' != $_GET['redirect-cat'] && isset($_GET['redirection-type']) &&
        '' != $_GET['redirection-type'] && isset($_GET['redirection-enabled']) && '' != $_GET['redirection-enabled'])) {
        $redirection_type = $_GET['redirection-type'];
        $redirection_enabled = $_GET['redirection-enabled'];

        $query->query_vars['meta_relation'] = 'AND';
        if ('no' == $_GET['redirection-enabled']) {
            $compare = 'NOT EXISTS';
        } else {
            $compare = '=';
        }
        $query->query_vars['meta_query'] = [
            'relation' => 'AND',
            [
                'key' => '_seopress_redirections_type',
                'value' => $redirection_type,
                'compare' => '=',
            ],
            [
                'key' => '_seopress_redirections_enabled',
                'value' => $redirection_enabled,
                'compare' => $compare,
            ],
        ];
    }

    if (is_admin() && 'seopress_404' == $current_page && 'edit.php' == $pagenow && isset($_GET['redirection-type']) &&
        '' != $_GET['redirection-type']) {
        $redirection_type = $_GET['redirection-type'];

        $query->query_vars['meta_query'] = [
            'relation' => 'AND',
            [
                'key' => '_seopress_redirections_type',
                'value' => $redirection_type,
                'compare' => '=',
            ],
        ];

        if ('404' == $redirection_type) {
            $query->query_vars['meta_query'] = [
                'relation' => 'AND',
                [
                    'key' => '_seopress_redirections_type',
                    'compare' => 'NOT EXISTS',
                ],
            ];
        }
    }
    if (is_admin() && 'seopress_404' == $current_page && 'edit.php' == $pagenow && isset($_GET['redirection-enabled']) &&
        '' != $_GET['redirection-enabled']) {
        $redirection_enabled = $_GET['redirection-enabled'];
        $query->query_vars['meta_key'] = '_seopress_redirections_enabled';
        $query->query_vars['meta_value'] = $redirection_enabled;
        if ('no' == $redirection_enabled) {
            $query->query_vars['meta_compare'] = 'NOT EXISTS';
        } else {
            $query->query_vars['meta_compare'] = '=';
        }
    }
}

///////////////////////////////////////////////////////////////////////////////////////////////////
//Bulk actions
///////////////////////////////////////////////////////////////////////////////////////////////////
//enable 301
add_filter('bulk_actions-edit-seopress_404', 'seopress_bulk_actions_enable');

function seopress_bulk_actions_enable($bulk_actions) {
    $bulk_actions['seopress_enable'] = __('Enable redirection', 'wp-seopress-pro');

    return $bulk_actions;
}

add_filter('handle_bulk_actions-edit-seopress_404', 'seopress_bulk_action_enable_handler', 10, 3);

function seopress_bulk_action_enable_handler($redirect_to, $doaction, $post_ids) {
    if ('seopress_enable' !== $doaction) {
        return $redirect_to;
    }
    foreach ($post_ids as $post_id) {
        // Perform action for each post.
        update_post_meta($post_id, '_seopress_redirections_enabled', 'yes');
    }
    $redirect_to = add_query_arg('bulk_enable_posts', count($post_ids), $redirect_to);

    return $redirect_to;
}

add_action('seopress_admin_notices', 'seopress_bulk_action_enable_admin_notice');

function seopress_bulk_action_enable_admin_notice() {
    if ( ! empty($_REQUEST['bulk_enable_posts'])) {
        $enable_count = intval($_REQUEST['bulk_enable_posts']);
        printf('<div id="message" class="updated fade"><p>' .
                _n(
                    '%s redirection enabled.',
                    '%s redirections enabled.',
                    $enable_count,
                    'wp-seopress-pro'
                ) . '</p></div>', $enable_count);
    }
}

//disable 301
add_filter('bulk_actions-edit-seopress_404', 'seopress_bulk_actions_disable');

function seopress_bulk_actions_disable($bulk_actions) {
    $bulk_actions['seopress_disable'] = __('Disable redirection', 'wp-seopress-pro');

    return $bulk_actions;
}

add_filter('handle_bulk_actions-edit-seopress_404', 'seopress_bulk_action_disable_handler', 10, 3);

function seopress_bulk_action_disable_handler($redirect_to, $doaction, $post_ids) {
    if ('seopress_disable' !== $doaction) {
        return $redirect_to;
    }
    foreach ($post_ids as $post_id) {
        // Perform action for each post.
        update_post_meta($post_id, '_seopress_redirections_enabled', '');
    }
    $redirect_to = add_query_arg('bulk_disable_posts', count($post_ids), $redirect_to);

    return $redirect_to;
}

add_action('seopress_admin_notices', 'seopress_bulk_action_disable_admin_notice');

function seopress_bulk_action_disable_admin_notice() {
    if ( ! empty($_REQUEST['bulk_disable_posts'])) {
        $disable_count = intval($_REQUEST['bulk_disable_posts']);
        printf('<div id="message" class="updated fade"><p>' .
                _n(
                    '%s redirection disabled.',
                    '%s redirections disabled.',
                    $disable_count,
                    'wp-seopress-pro'
                ) . '</p></div>', $disable_count);
    }
}

//enable regex
add_filter('bulk_actions-edit-seopress_404', 'seopress_bulk_actions_enable_regex');

function seopress_bulk_actions_enable_regex($bulk_actions) {
    $bulk_actions['seopress_enable_regex'] = __('Enable regex', 'wp-seopress-pro');

    return $bulk_actions;
}

add_filter('handle_bulk_actions-edit-seopress_404', 'seopress_bulk_action_enable_regex_handler', 10, 3);

function seopress_bulk_action_enable_regex_handler($redirect_to, $doaction, $post_ids) {
    if ('seopress_enable_regex' !== $doaction) {
        return $redirect_to;
    }
    foreach ($post_ids as $post_id) {
        // Perform action for each post.
        update_post_meta($post_id, '_seopress_redirections_enabled_regex', 'yes');
    }
    $redirect_to = add_query_arg('bulk_enable_regex_posts', count($post_ids), $redirect_to);

    return $redirect_to;
}

add_action('seopress_admin_notices', 'seopress_bulk_action_enable_regex_admin_notice');

function seopress_bulk_action_enable_regex_admin_notice() {
    if ( ! empty($_REQUEST['bulk_enable_regex_posts'])) {
        $enable_regex_count = intval($_REQUEST['bulk_enable_regex_posts']);
        printf('<div id="message" class="updated fade"><p>' .
                _n(
                    '%s redirection with regex enabled.',
                    '%s redirections with regex enabled.',
                    $enable_regex_count,
                    'wp-seopress-pro'
                ) . '</p></div>', $enable_regex_count);
    }
}

//disable regex
add_filter('bulk_actions-edit-seopress_404', 'seopress_bulk_actions_disable_regex');

function seopress_bulk_actions_disable_regex($bulk_actions) {
    $bulk_actions['seopress_disable_regex'] = __('Disable regex', 'wp-seopress-pro');

    return $bulk_actions;
}

add_filter('handle_bulk_actions-edit-seopress_404', 'seopress_bulk_action_disable_regex_handler', 10, 3);

function seopress_bulk_action_disable_regex_handler($redirect_to, $doaction, $post_ids) {
    if ('seopress_disable_regex' !== $doaction) {
        return $redirect_to;
    }
    foreach ($post_ids as $post_id) {
        // Perform action for each post.
        update_post_meta($post_id, '_seopress_redirections_enabled_regex', '');
    }
    $redirect_to = add_query_arg('bulk_disable_regex_posts', count($post_ids), $redirect_to);

    return $redirect_to;
}

add_action('seopress_admin_notices', 'seopress_bulk_action_disable_regex_admin_notice');

function seopress_bulk_action_disable_regex_admin_notice() {
    if ( ! empty($_REQUEST['bulk_disable_regex_posts'])) {
        $disable_count = intval($_REQUEST['bulk_disable_regex_posts']);
        printf('<div id="message" class="updated fade"><p>' .
                _n(
                    '%s redirection with regex disabled.',
                    '%s redirections with regex disabled.',
                    $disable_count,
                    'wp-seopress-pro'
                ) . '</p></div>', $disable_count);
    }
}

//Set as 301
add_filter('bulk_actions-edit-seopress_404', 'seopress_bulk_actions_redirect_301');

function seopress_bulk_actions_redirect_301($bulk_actions) {
    $bulk_actions['seopress_redirect_301'] = __('Mark as 301', 'wp-seopress-pro');

    return $bulk_actions;
}
add_filter('handle_bulk_actions-edit-seopress_404', 'seopress_bulk_action_redirect_301_handler', 10, 3);

function seopress_bulk_action_redirect_301_handler($redirect_to, $doaction, $post_ids) {
    if ('seopress_redirect_301' !== $doaction) {
        return $redirect_to;
    }
    foreach ($post_ids as $post_id) {
        // Perform action for each post.
        update_post_meta($post_id, '_seopress_redirections_type', '301');
    }
    $redirect_to = add_query_arg('bulk_301_redirects_posts', count($post_ids), $redirect_to);

    return $redirect_to;
}

add_action('seopress_admin_notices', 'seopress_bulk_action_redirect_301_admin_notice');

function seopress_bulk_action_redirect_301_admin_notice() {
    if ( ! empty($_REQUEST['bulk_301_redirects_posts'])) {
        $count_301 = intval($_REQUEST['bulk_301_redirects_posts']);
        printf('<div id="message" class="updated fade"><p>' .
        _n(
            '%s marked as 301 redirect.',
            '%s marked as 301 redirect.',
            $count_301,
            'wp-seopress-pro'
        ) . '</p></div>', $count_301);
    }
}

//Set as 302
add_filter('bulk_actions-edit-seopress_404', 'seopress_bulk_actions_redirect_302');

function seopress_bulk_actions_redirect_302($bulk_actions) {
    $bulk_actions['seopress_redirect_302'] = __('Mark as 302', 'wp-seopress-pro');

    return $bulk_actions;
}
add_filter('handle_bulk_actions-edit-seopress_404', 'seopress_bulk_action_redirect_302_handler', 10, 3);

function seopress_bulk_action_redirect_302_handler($redirect_to, $doaction, $post_ids) {
    if ('seopress_redirect_302' !== $doaction) {
        return $redirect_to;
    }
    foreach ($post_ids as $post_id) {
        // Perform action for each post.
        update_post_meta($post_id, '_seopress_redirections_type', '302');
    }
    $redirect_to = add_query_arg('bulk_302_redirects_posts', count($post_ids), $redirect_to);

    return $redirect_to;
}

add_action('seopress_admin_notices', 'seopress_bulk_action_redirect_302_admin_notice');

function seopress_bulk_action_redirect_302_admin_notice() {
    if ( ! empty($_REQUEST['bulk_302_redirects_posts'])) {
        $count_302 = intval($_REQUEST['bulk_302_redirects_posts']);
        printf('<div id="message" class="updated fade"><p>' .
        _n(
            '%s marked as 302 redirect.',
            '%s marked as 302 redirect.',
            $count_302,
            'wp-seopress-pro'
        ) . '</p></div>', $count_302);
    }
}

//Set as 307
add_filter('bulk_actions-edit-seopress_404', 'seopress_bulk_actions_redirect_307');

function seopress_bulk_actions_redirect_307($bulk_actions) {
    $bulk_actions['seopress_redirect_307'] = __('Mark as 307', 'wp-seopress-pro');

    return $bulk_actions;
}
add_filter('handle_bulk_actions-edit-seopress_404', 'seopress_bulk_action_redirect_307_handler', 10, 3);

function seopress_bulk_action_redirect_307_handler($redirect_to, $doaction, $post_ids) {
    if ('seopress_redirect_307' !== $doaction) {
        return $redirect_to;
    }
    foreach ($post_ids as $post_id) {
        // Perform action for each post.
        update_post_meta($post_id, '_seopress_redirections_type', '307');
    }
    $redirect_to = add_query_arg('bulk_307_redirects_posts', count($post_ids), $redirect_to);

    return $redirect_to;
}

add_action('seopress_admin_notices', 'seopress_bulk_action_redirect_307_admin_notice');

function seopress_bulk_action_redirect_307_admin_notice() {
    if ( ! empty($_REQUEST['bulk_307_redirects_posts'])) {
        $count_307 = intval($_REQUEST['bulk_307_redirects_posts']);
        printf('<div id="message" class="updated fade"><p>' .
        _n(
            '%s marked as 307 redirect.',
            '%s marked as 307 redirect.',
            $count_307,
            'wp-seopress-pro'
        ) . '</p></div>', $count_307);
    }
}

//Set as 410
add_filter('bulk_actions-edit-seopress_404', 'seopress_bulk_actions_redirect_410');

function seopress_bulk_actions_redirect_410($bulk_actions) {
    $bulk_actions['seopress_redirect_410'] = __('Mark as 410', 'wp-seopress-pro');

    return $bulk_actions;
}
add_filter('handle_bulk_actions-edit-seopress_404', 'seopress_bulk_action_redirect_410_handler', 10, 3);

function seopress_bulk_action_redirect_410_handler($redirect_to, $doaction, $post_ids) {
    if ('seopress_redirect_410' !== $doaction) {
        return $redirect_to;
    }
    foreach ($post_ids as $post_id) {
        // Perform action for each post.
        update_post_meta($post_id, '_seopress_redirections_type', '410');
    }
    $redirect_to = add_query_arg('bulk_410_redirects_posts', count($post_ids), $redirect_to);

    return $redirect_to;
}

add_action('seopress_admin_notices', 'seopress_bulk_action_redirect_410_admin_notice');

function seopress_bulk_action_redirect_410_admin_notice() {
    if ( ! empty($_REQUEST['bulk_410_redirects_posts'])) {
        $count_410 = intval($_REQUEST['bulk_410_redirects_posts']);
        printf('<div id="message" class="updated fade"><p>' .
        _n(
            '%s marked as 410 redirect.',
            '%s marked as 410 redirect.',
            $count_410,
            'wp-seopress-pro'
        ) . '</p></div>', $count_410);
    }
}

//Set as 451
add_filter('bulk_actions-edit-seopress_404', 'seopress_bulk_actions_redirect_451');

function seopress_bulk_actions_redirect_451($bulk_actions) {
    $bulk_actions['seopress_redirect_451'] = __('Mark as 451', 'wp-seopress-pro');

    return $bulk_actions;
}
add_filter('handle_bulk_actions-edit-seopress_404', 'seopress_bulk_action_redirect_451_handler', 10, 3);

function seopress_bulk_action_redirect_451_handler($redirect_to, $doaction, $post_ids) {
    if ('seopress_redirect_451' !== $doaction) {
        return $redirect_to;
    }
    foreach ($post_ids as $post_id) {
        // Perform action for each post.
        update_post_meta($post_id, '_seopress_redirections_type', '451');
    }
    $redirect_to = add_query_arg('bulk_451_redirects_posts', count($post_ids), $redirect_to);

    return $redirect_to;
}

add_action('seopress_admin_notices', 'seopress_bulk_action_redirect_451_admin_notice');

function seopress_bulk_action_redirect_451_admin_notice() {
    if ( ! empty($_REQUEST['bulk_451_redirects_posts'])) {
        $count_451 = intval($_REQUEST['bulk_451_redirects_posts']);
        printf('<div id="message" class="updated fade"><p>' .
        _n(
            '%s marked as 451 redirect.',
            '%s marked as 451 redirect.',
            $count_451,
            'wp-seopress-pro'
        ) . '</p></div>', $count_451);
    }
}

///////////////////////////////////////////////////////////////////////////////////////////////////
//Set title placeholder for Redirections Custom Post Type
///////////////////////////////////////////////////////////////////////////////////////////////////
add_filter('enter_title_here', 'seopress_404_cpt_title');
function seopress_404_cpt_title($title) {
    if (function_exists('get_current_screen')) {
        $screen = get_current_screen();
        if ('seopress_404' == $screen->post_type) {
            $title = __('Enter the old URL here without domain name', 'wp-seopress-pro');
        }

        return $title;
    }
}

///////////////////////////////////////////////////////////////////////////////////////////////////
//Display help after title
///////////////////////////////////////////////////////////////////////////////////////////////////
add_action('edit_form_after_title', 'seopress_301_after_title');
function seopress_301_after_title() {
    global $typenow;
    if (isset($typenow) && 'seopress_404' == $typenow) {
        echo '<p>' . __('Enter your <strong>relative</strong> URL above. Do not use anchors, they are not sent by your browser.', 'wp-seopress-pro') . '<br>';
        _e('Eg: <strong>"my-custom-permalink"</strong>. If you have a permalink structure like <strong>/%category%/%postname%/</strong>, make sure to include the categories: <strong>"category/sub-category/my-custom-permalink".</strong>', 'wp-seopress-pro');
        echo '</p>';
    }
}

///////////////////////////////////////////////////////////////////////////////////////////////////
//Set messages for Redirections Custom Post Type
///////////////////////////////////////////////////////////////////////////////////////////////////
add_filter('post_updated_messages', 'seopress_404_set_messages');
function seopress_404_set_messages($messages) {
    global $post, $post_ID, $typenow;
    $post_type = 'seopress_404';
    $seopress_404_test = '';

    if ('seopress_404' === $typenow) {
        $obj = get_post_type_object($post_type);
        $singular = $obj->labels->singular_name;

        //WPML
        add_filter('wpml_get_home_url', 'seopress_remove_wpml_home_url_filter', 20, 5);

        if ('yes' == get_post_meta(get_the_ID(), '_seopress_redirections_enabled', true)) {
            $parse_url = wp_parse_url(get_home_url());

            $home_url = get_home_url();
            if ( ! empty($parse_url['scheme']) && ! empty($parse_url['host'])) {
                $home_url = $parse_url['scheme'] . '://' . $parse_url['host'];
            }
            $seopress_404_test = "<a href='" . $home_url . '/' . get_the_title() . "' target='_blank'>" . __('Test redirection', 'wp-seopress-pro') . "</a><span class='dashicons dashicons-external'></span>";
        }

        $messages[$post_type] = [
            0 => '', // Unused. Messages start at index 1.
            1 => sprintf(__($singular . ' updated. %s'), $seopress_404_test),
            2 => __('Custom field updated.'),
            3 => __('Custom field deleted.'),
            4 => sprintf(__($singular . ' updated. %s'), $seopress_404_test),
            5 => isset($_GET['revision']) ? sprintf(__($singular . ' restored to revision from %s'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
            6 => sprintf(__($singular . ' published. %s'), $seopress_404_test),
            7 => __('Redirection saved.'),
            8 => sprintf(__($singular . ' submitted.'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
            9 => sprintf(__($singular . ' scheduled for: <strong>%1$s</strong>. '), date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
            10 => sprintf(__($singular . ' draft updated.'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
        ];

        return $messages;
    } else {
        return $messages;
    }
}

add_filter('bulk_post_updated_messages', 'seopress_404_set_messages_list', 10, 2);
function seopress_404_set_messages_list($bulk_messages, $bulk_counts) {
    $bulk_messages['seopress_404'] = [
        'updated' => _n('%s redirection updated.', '%s redirections updated.', $bulk_counts['updated']),
        'locked' => _n('%s redirection not updated, somebody is editing it.', '%s redirections not updated, somebody is editing them.', $bulk_counts['locked']),
        'deleted' => _n('%s redirection permanently deleted.', '%s redirections permanently deleted.', $bulk_counts['deleted']),
        'trashed' => _n('%s redirection moved to the Trash.', '%s redirections moved to the Trash.', $bulk_counts['trashed']),
        'untrashed' => _n('%s redirection restored from the Trash.', '%s redirections restored from the Trash.', $bulk_counts['untrashed']),
    ];

    return $bulk_messages;
}
///////////////////////////////////////////////////////////////////////////////////////////////////
//Items per page
///////////////////////////////////////////////////////////////////////////////////////////////////
add_filter('edit_seopress_404_per_page', 'seopress_404_items_per_page' );
function seopress_404_items_per_page($per_page) {
    $per_page = 100;
    return $per_page;
}

///////////////////////////////////////////////////////////////////////////////////////////////////
//Columns for SEOPress Redirections Custom Post Type
///////////////////////////////////////////////////////////////////////////////////////////////////

add_filter('manage_edit-seopress_404_columns', 'seopress_404_count_columns');
add_action('manage_seopress_404_posts_custom_column', 'seopress_404_count_display_column', 10, 2);

function seopress_404_count_columns($columns) {
    unset($columns['title']);
    unset($columns['date']);
    unset($columns['taxonomy-seopress_404_cat']);

    $columns['seopress_404_redirect_enable'] = __('On?', 'wp-seopress-pro');
    $columns['title'] = __('Origin URL', 'wp-seopress-pro');
    $columns['seopress_404_redirect_value'] = __('Destination URL', 'wp-seopress-pro');
    $columns['seopress_404_redirect_type'] = __('Type', 'wp-seopress-pro');
    $columns['seopress_404'] = __('Hits', 'wp-seopress-pro');
    $columns['seopress_404_redirect_regex_enable'] = __('Regex?', 'wp-seopress-pro');
    $columns['seopress_404_date'] = __('Date', 'wp-seopress-pro');
    $columns['taxonomy-seopress_404_cat'] = __('Categories', 'wp-seopress-pro');
    $columns['seopress_404_redirect_date_request'] = __('Last time loaded', 'wp-seopress-pro');
    $columns['seopress_404_redirect_ua'] = __('User agent', 'wp-seopress-pro');
    $columns['seopress_404_redirect_referer'] = __('Referer', 'wp-seopress-pro');
    $columns['seopress_404_redirect_ip'] = __('IP address', 'wp-seopress-pro');

    return $columns;
}

function seopress_404_count_display_column($column, $post_id) {
    if ('seopress_404_date' == $column) {
        the_date( '', '', '', true );
    }
    if ('seopress_404' == $column) {
        echo get_post_meta($post_id, 'seopress_404_count', true);
    }
    if ('seopress_404_redirect_enable' == $column) {
        if ('yes' == get_post_meta($post_id, '_seopress_redirections_enabled', true)) {
            echo '<span class="dashicons dashicons-yes-alt"></span>';
        }
    }
    if ('seopress_404_redirect_regex_enable' == $column) {
        if ('yes' == get_post_meta($post_id, '_seopress_redirections_enabled_regex', true)) {
            echo '<span class="dashicons dashicons-yes"></span>';
        }
    }
    if ('seopress_404_redirect_type' == $column) {
        $seopress_redirections_type = get_post_meta($post_id, '_seopress_redirections_type', true);
        switch ($seopress_redirections_type) {

        case '301':
            echo '<span class="seopress_redirection_301 seopress_redirection_status" title="' . __('Moved permanently','wp-seopress-pro') . '">' . $seopress_redirections_type . '</span>';
            break;

        case '302':
            echo '<span class="seopress_redirection_302 seopress_redirection_status" title="' . __('302 Found / Moved Temporarily','wp-seopress-pro') . '">' . $seopress_redirections_type . '</span>';
            break;

        case '307':
            echo '<span class="seopress_redirection_307 seopress_redirection_status" title="' . __('307 Moved Temporarily','wp-seopress-pro') . '">' . $seopress_redirections_type . '</span>';
            break;

        case '410':
            echo '<span class="seopress_redirection_410 seopress_redirection_status" title="' . __('410 Gone','wp-seopress-pro') . '">' . $seopress_redirections_type . '</span>';
            break;

        case '451':
            echo '<span class="seopress_redirection_451 seopress_redirection_status" title="' . __('451 Unavailable For Legal Reasons','wp-seopress-pro') . '">' . $seopress_redirections_type . '</span>';
            break;

        default:
            echo '<span class="seopress_redirection_default seopress_redirection_status" title="' . __('404 not found','wp-seopress-pro') . '">' . __('404', 'wp-seopress-pro') . '</span>';
            break;
        }
    }
    if ('seopress_404_redirect_value' == $column) {
        if (get_post_meta($post_id, '_seopress_redirections_value', true)) {
            echo esc_html(get_post_meta($post_id, '_seopress_redirections_value', true));
        }
    }
    if ('seopress_404_redirect_date_request' == $column) {
        global $wp_version;
        $timestamp = esc_html(get_post_meta($post_id, '_seopress_404_redirect_date_request', true));
        if ('' != $timestamp) {
            echo date(get_option('date_format').' ['.get_option('time_format').']', $timestamp);
        }
    }
    if ('seopress_404_redirect_ua' == $column) {
        echo esc_html(get_post_meta($post_id, 'seopress_redirections_ua', true));
    }
    if ('seopress_404_redirect_referer' == $column) {
        echo '<a target="_blank" href="' . esc_html(get_post_meta($post_id, 'seopress_redirections_referer', true)) . '">' . esc_html(get_post_meta($post_id, 'seopress_redirections_referer', true)) . '</a>';
    }
    if ('seopress_404_redirect_ip' == $column) {
        echo esc_html(get_post_meta($post_id, '_seopress_redirections_ip', true));
    }
}

//Sortable columns
add_filter('manage_edit-seopress_404_sortable_columns', 'seopress_404_sortable_columns');

function seopress_404_sortable_columns($columns) {
    $columns['seopress_404'] = 'seopress_404';
    $columns['seopress_404_redirect_enable'] = 'seopress_404_redirect_enable';
    $columns['seopress_404_redirect_regex_enable'] = 'seopress_404_redirect_regex_enable';
    $columns['seopress_404_redirect_type'] = 'seopress_404_redirect_type';

    return $columns;
}

add_filter('pre_get_posts', 'seopress_404_sort_columns_by');

function seopress_404_sort_columns_by($query) {
    if ( ! is_admin()) {
        return $query;
    }

    global $typenow;
    if ('seopress_404' !== $typenow) {
        return $query;
    }

    if ( isset( $_GET['post_status'] ) ) {
        $current_view = sanitize_text_field( wp_unslash( $_GET['post_status'] ) );
    }

    $orderby = $query->get('orderby');

    //Count
    if ('seopress_404' === $orderby) {
        $query->set('meta_query', [
            'relation' => 'AND',
            [
                'key' => 'seopress_404_count',
                'compare' => 'EXISTS',
                'type' => 'NUMERIC'
            ],
            [
                'key' => '_seopress_redirections_type',
                'compare' => 'NOT EXISTS',
            ],
        ]);
        if ('redirects' === $_GET['post_status'] || 'all' === $_GET['post_status']) {
            $query->set('meta_query', [
                'relation' => 'AND',
                [
                    'key' => 'seopress_404_count',
                    'compare' => 'EXISTS',
                ],
                [
                    'key' => '_seopress_redirections_type',
                    'compare' => 'EXISTS',
                ],
            ]);
        }
        $query->set('orderby', 'meta_value_num');

        if ('404' === $_GET['post_status']) {
            $query->set('orderby', 'seopress_404_count');
        }
    }
    //Enabled?
    if ('seopress_404_redirect_enable' === $orderby) {
        $query->set('meta_query', [
            'relation' => 'OR',
            [
                'key' => '_seopress_redirections_enabled',
                'compare' => 'EXISTS',
            ],
            [
                'key' => '_seopress_redirections_enabled',
                'compare' => 'NOT EXISTS',
            ],
        ]);
        $query->set('orderby', '_seopress_redirections_enabled');
    }
    //Regex?
    if ('seopress_404_redirect_regex_enable' === $orderby) {
        $query->set('meta_query', [
            'relation' => 'OR',
            [
                'key' => '_seopress_redirections_enabled_regex',
                'compare' => 'EXISTS',
            ],
            [
                'key' => '_seopress_redirections_enabled_regex',
                'compare' => 'NOT EXISTS',
            ],
        ]);
        $query->set('orderby', '_seopress_redirections_enabled_regex');
    }
    //Type
    if ('seopress_404_redirect_type' === $orderby) {
        $query->set('orderby', 'meta_value');
        $query->set('meta_query', [
            'relation' => 'OR',
            [
                'key' => '_seopress_redirections_type',
                'compare' => 'EXISTS',
            ],
            [
                'key' => '_seopress_redirections_type',
                'compare' => 'NOT EXISTS',
            ],
        ]);

        if ('redirects' === $_GET['post_status']) {
            $query->set('meta_query', [
                'relation' => 'AND',
                [
                    'key' => '_seopress_redirections_type',
                    'compare' => 'EXISTS',
                ],
            ]);
        }
    }

    return $query;
}

///////////////////////////////////////////////////////////////////////////////////////////////////
//Quick Edit
///////////////////////////////////////////////////////////////////////////////////////////////////
add_action('quick_edit_custom_box', 'seopress_bulk_quick_edit_301_custom_box', 10, 2);
function seopress_bulk_quick_edit_301_custom_box($column_name) {
    static $printNonce = true;
    if ($printNonce) {
        $printNonce = false;
        wp_nonce_field(plugin_basename(__FILE__), 'seopress_301_edit_nonce');
    } ?>
<div class="wp-clearfix"></div>
<fieldset class="inline-edit-col-left">
<div class="inline-edit-col column-<?php echo $column_name; ?>">

<?php
                switch ($column_name) {
                case 'seopress_404_redirect_value':
                ?>
<label class="inline-edit-group">
    <span class="title"><?php _e('New URL', 'wp-seopress-pro'); ?></span>
    <span class="input-text-wrap">
        <input type="text" name="seopress_redirections_value" />
    </span>
</label>
<?php
                break;
                case 'seopress_404_redirect_type':
                ?>
<label class="alignleft">
    <span class="title"><?php _e('Redirection type', 'wp-seopress-pro'); ?></span>
    <select name="seopress_redirections_type">
        <option value="301"><?php _e('301 Moved Permanently', 'wp-seopress-pro'); ?>
        </option>
        <option value="302"><?php _e('302 Found / Moved Temporarily', 'wp-seopress-pro'); ?>
        </option>
        <option value="307"><?php _e('307 Moved Temporarily', 'wp-seopress-pro'); ?>
        </option>
        <option value="410"><?php _e('410 Gone', 'wp-seopress-pro'); ?>
        </option>
        <option value="451"><?php _e('451 Unavailable For Legal Reasons', 'wp-seopress-pro'); ?>
        </option>
    </select>
</label>
<?php
                break;
                case 'seopress_404_redirect_enable':
                ?>
<h4><?php _e('Redirection settings', 'wp-seopress-pro'); ?>
</h4>
<label class="alignleft">
    <input type="checkbox" name="seopress_redirections_enabled" value="yes">
    <span class="checkbox-title"><?php _e('Enable redirection?', 'wp-seopress-pro'); ?></span>
</label>
<?php
                break;
                case 'seopress_404_redirect_regex_enable':
                ?>
<label class="alignleft">
    <input type="checkbox" name="seopress_redirections_enabled_regex" value="yes">
    <span class="checkbox-title"><?php _e('Regex?', 'wp-seopress-pro'); ?></span>
</label>
<?php
                break;
                default:
                break;
                } ?>
</div>
</fieldset>
<?php
}

add_action('save_post', 'seopress_bulk_quick_edit_301_save_post', 10, 2);
function seopress_bulk_quick_edit_301_save_post($post_id) {
    // don't save if Elementor library
    if (isset($_REQUEST['post_type']) && 'elementor_library' === $_REQUEST['post_type']) {
        return $post_id;
    }

    // don't save for autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // dont save for revisions
    if (isset($_REQUEST['post_type']) && 'revision' === $_REQUEST['post_type']) {
        return $post_id;
    }

    if ( ! current_user_can('edit_redirections', $post_id)) {
        return;
    }

    $_REQUEST += ['seopress_301_edit_nonce' => ''];

    if ( ! wp_verify_nonce($_REQUEST['seopress_301_edit_nonce'], plugin_basename(__FILE__))) {
        return;
    }
    if (isset($_REQUEST['seopress_redirections_value'])) {
        update_post_meta($post_id, '_seopress_redirections_value', esc_html($_REQUEST['seopress_redirections_value']));
    }
    if (isset($_REQUEST['seopress_redirections_type'])) {
        update_post_meta($post_id, '_seopress_redirections_type', esc_html($_REQUEST['seopress_redirections_type']));
    }
    if (isset($_REQUEST['seopress_redirections_enabled'])) {
        update_post_meta($post_id, '_seopress_redirections_enabled', 'yes');
    } else {
        delete_post_meta($post_id, '_seopress_redirections_enabled', '');
    }
    if (isset($_REQUEST['seopress_redirections_enabled_regex'])) {
        update_post_meta($post_id, '_seopress_redirections_enabled_regex', 'yes');
    } else {
        delete_post_meta($post_id, '_seopress_redirections_enabled_regex', '');
    }
}

add_filter('wp_insert_post_data', 'seopress_filter_post_title', '99', 2);
function seopress_filter_post_title($data, $postarr) {
    if (isset($data['post_type']) && 'seopress_404' === $data['post_type'] && isset($postarr['ID'])) {
        if ('' != get_post_meta($postarr['ID'], '_seopress_redirections_type', true)) {
            $title = $data['post_title'];

            if ($title) {
                $url = wp_parse_url($title);

                if (isset($url['path']) && ! empty($url['path'])) {
                    $title = $url['path'];
                    if (isset($url['query']) && ! empty($url['query'])) {
                        $title .= '?' . $url['query'];
                    }
                    $data['post_title'] = ltrim($title, '/');
                }
            }
        }
    }

    return $data;
}
