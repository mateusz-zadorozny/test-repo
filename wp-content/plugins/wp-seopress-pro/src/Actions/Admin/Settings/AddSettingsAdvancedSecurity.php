<?php

namespace SEOPressPro\Actions\Admin\Settings;

if ( ! defined('ABSPATH')) {
    exit;
}

use SEOPress\Core\Hooks\ExecuteHooksBackend;

class AddSettingsAdvancedSecurity implements ExecuteHooksBackend {
    /**
     * @since 4.6.0
     *
     * @return void
     */
    public function hooks() {
        // To be used in case of customer feedback on schema rights
        // add_action('seopress_add_settings_field_advanced_security', [$this, 'addSettings']);
    }

    /**
     * @since 4.6.0
     *
     * @param string $keySettings
     *
     * @return void
     */
    public function render($keySettings) {
        $options = seopress_get_service('AdvancedOption')->getOption();

        global $wp_roles;

        if ( ! isset($wp_roles)) {
            $wp_roles = new WP_Roles();
        }

        foreach ($wp_roles->get_names() as $key => $value) {
            if ('administrator' === $key) {
                continue;
            }
            $uniqueKey   = sprintf('%s_%s', $keySettings, $key);
            $nameKey     = \sprintf('%s_%s', 'seopress_advanced_security_metaboxe', $keySettings);
            $dataOptions = isset($options[$nameKey]) ? $options[$nameKey] : []; ?>
            <div>
                <input
                    type="checkbox"
                    id="seopress_advanced_security_metaboxe_role_pages_<?php echo $uniqueKey; ?>"
                    value="1"
                    name="seopress_advanced_option_name[<?php echo $nameKey; ?>][<?php echo $key; ?>]"
                    <?php if (isset($dataOptions[$key])) {
                checked($dataOptions[$key], '1');
            } ?>
                />
                <label for="seopress_advanced_security_metaboxe_role_pages_<?php echo $uniqueKey; ?>">
                    <strong><?php echo $value; ?></strong> (<em><?php echo translate_user_role($value,  'default'); ?></em>)
                </label>
            </div>
            <?php
        }
    }

    /**
     * @since 4.6.0
     *
     * @param string $name
     * @param array  $params
     *
     * @return void
     */
    public function __call($name, $params) {
        $functionWithKey = explode('-', $name);
        if ( ! isset($functionWithKey[1])) {
            return;
        }

        $this->render($functionWithKey[1]);
    }

    /**
     * @since 4.6.0
     *
     * @return void
     */
    public function addSettings() {
        $postTypes = [
            'seopress_bot'     => __('Broken Link', 'wp-seopresspro-'),
            'seopress_404'     => '404',
            'seopress_schemas' => __('Schemas', 'wp-seopress-pro'),
        ];
        foreach ($postTypes as $key => $value) {
            add_settings_field(
                'seopress_advanced_security_metaboxe_' . $key,
                $value,
                [$this, sprintf('render-%s', $key)],
                'seopress-settings-admin-advanced-security',
                'seopress_setting_section_advanced_security'
            );
        }
    }
}
