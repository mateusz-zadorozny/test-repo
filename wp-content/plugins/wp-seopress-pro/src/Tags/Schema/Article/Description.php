<?php

namespace SEOPressPro\Tags\Schema\Article;

if ( ! defined('ABSPATH')) {
    exit;
}

use SEOPress\Models\GetTagValue;

class Description implements GetTagValue {
    const NAME = 'schema_article_desc';

    /**
     * @since 5.4.0
     *
     * @param array $args
     *
     * @return string
     */
    public function getValue($args = null) {
        $context = isset($args[0]) ? $args[0] : null;

        $value      = '';

        if (seopress_get_service('CheckContextPage')->hasSchemaManualValues($context)) {
            $schema = $context['schemas_manual'][$context['key_get_json_schema']];

            if (array_key_exists('_seopress_pro_rich_snippets_article_desc', $schema)) {
                $value = $schema['_seopress_pro_rich_snippets_article_desc'];
            }
        }

        if (empty($value) && isset($context['post']->ID)) {
            $value = wp_trim_words(esc_html(get_the_excerpt($context['post']->ID)), 30);
        }

        return apply_filters('seopress_pro_get_tag_schema_article_desc', $value, $context);
    }
}
