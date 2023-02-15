<?php

namespace SEOPressPro\Services\Admin\Settings\LocalBusiness\Fields;

defined('ABSPATH') or exit('Cheatin&#8217; uh?');

trait FieldPage
{
    /**
     * @since 4.5.0
     *
     * @return void
     */
    public function renderFieldPage()
    {
        $value = seopress_pro_get_service('OptionPro')->getLocalBusinessPage(); ?>
<input type="text" name="seopress_pro_option_name[seopress_local_business_page]"
    placeholder="<?php esc_html_e('Enter your post, page or post type ID, eg: 64', 'wp-seopress-pro'); ?>"
    aria-label="<?php _e('Post ID', 'wp-seopress-pro'); ?>"
    value="<?php echo esc_html($value); ?>" />
<p class="description">
    <?php _e('Default: homepage. Google recommends to include your business details (address, phone, website...) for your visitors too.', 'wp-seopress-pro'); ?>
</p>
<?php
    }
}
