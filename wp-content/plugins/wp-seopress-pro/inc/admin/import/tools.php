<?php
/**
 * Import / export CSV tool
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="postbox section-tool">
    <div class="sp-section-header">
        <h2>
            <?php _e('Data', 'wp-seopress'); ?>
        </h2>
    </div>
    <div class="inside">
        <h3>
            <?php _e('Import data from a CSV', 'wp-seopress'); ?>
        </h3>
        <p>
            <?php _e('Upload a CSV file to quickly import post (post, page, single post type) and term metadata.', 'wp-seopress'); ?>
            <?php echo seopress_tooltip_link($docs['tools']['csv_import'], __('Learn how to import SEO metadata from a CSV file', 'wp-seopress')); ?>
        </p>
        <ul>
            <li>
                <?php _e('Meta title', 'wp-seopress'); ?>
            </li>
            <li>
                <?php _e('Meta description', 'wp-seopress'); ?>
            </li>
            <li>
                <?php _e('Meta robots (noindex, nofollow...)', 'wp-seopress'); ?>
            </li>
            <li>
                <?php _e('Facebook Open Graph tags (title, description, image)', 'wp-seopress'); ?>
            </li>
            <li>
                <?php _e('Twitter cards tags (title, description, image)', 'wp-seopress'); ?>
            </li>
            <li>
                <?php _e('Redirection (enable, login status, type, URL)', 'wp-seopress'); ?>
            </li>
            <li>
                <?php _e('Primary category', 'wp-seopress'); ?>
            </li>
            <li>
                <?php _e('Canonical URL', 'wp-seopress'); ?>
            </li>
            <li>
                <?php _e('Target keywords', 'wp-seopress'); ?>
            </li>
        </ul>
        <p>
            <a class="btn btnSecondary"
                href="<?php echo admin_url('admin.php?page=seopress_csv_importer'); ?>">
                <?php _e('Run the importer', 'wp-seopress'); ?>
            </a>
        </p>
    </div><!-- .inside -->
</div><!-- .postbox -->
<div id="metadata-migration-tool" class="postbox section-tool">
    <div class="inside">
        <h3>
            <?php _e('Export metadata to a CSV', 'wp-seopress'); ?>
        </h3>
        <p>
            <?php _e('Export your post (post, page, single post type) and term metadata for this site as a .csv file.', 'wp-seopress'); ?>
            <?php echo seopress_tooltip_link($docs['tools']['csv_export'], __('Learn how to export SEO metadata to a CSV file', 'wp-seopress')); ?>
        </p>
        <ul>
            <li>
                <?php _e('Meta title', 'wp-seopress'); ?>
            </li>
            <li>
                <?php _e('Meta description', 'wp-seopress'); ?>
            </li>
            <li>
                <?php _e('Meta robots (noindex, nofollow...)', 'wp-seopress'); ?>
            </li>
            <li>
                <?php _e('Facebook Open Graph tags (title, description, image)', 'wp-seopress'); ?>
            </li>
            <li>
                <?php _e('Twitter cards tags (title, description, image)', 'wp-seopress'); ?>
            </li>
            <li>
                <?php _e('Redirection (enable, login status, type, URL)', 'wp-seopress'); ?>
            </li>
            <li>
                <?php _e('Primary category', 'wp-seopress'); ?>
            </li>
            <li>
                <?php _e('Canonical URL', 'wp-seopress'); ?>
            </li>
            <li>
                <?php _e('Target keywords', 'wp-seopress'); ?>
            </li>
        </ul>
        <form method="post">
            <input type="hidden" name="seopress_action" value="export_csv_metadata" />
            <?php wp_nonce_field('seopress_export_csv_metadata_nonce', 'seopress_export_csv_metadata_nonce'); ?>

            <button id="seopress-metadata-migrate" type="button" class="btn btnSecondary">
                <?php _e('Export', 'wp-seopress'); ?>
            </button>

            <span class="spinner"></span>

            <div class="log"></div>
        </form>
    </div><!-- .inside -->
</div><!-- .postbox -->
