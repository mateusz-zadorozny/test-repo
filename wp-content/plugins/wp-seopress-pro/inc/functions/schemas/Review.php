<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

//Review JSON-LD
function seopress_automatic_rich_snippets_review_option($schema_datas) {
    //if no data
    if (0 != count(array_filter($schema_datas, 'strlen'))) {
        $review_item 							     = $schema_datas['item'];
        $review_type 							     = $schema_datas['item_type'];
        $review_img 							      = $schema_datas['img'];
        $review_rating 						        = $schema_datas['rating'];
        $review_max_rating 						    = $schema_datas['max_rating'];
        $review_body 							     = $schema_datas['body'];

        if ($review_type) {
            $type = $review_type;
        } else {
            $type = 'Thing';
        }

        $json = [
            '@context'     => seopress_check_ssl() . 'schema.org/',
            '@type'        => 'Review',
            'itemReviewed' => [
                '@type' => $type,
                'name'  => $review_item,
            ],
            'datePublished' => get_the_date('c'),
            'author'        => [
                '@type' => 'Person',
                'name'  => get_the_author(),
            ],
            'reviewBody' => $review_body,
        ];

        if ('' != $review_img) {
            $json['image'] = [
                '@type' => 'ImageObject',
                'url'   => $review_img,
            ];
        }

        if ('' != $review_rating) {
            $json['reviewRating'] = [
                '@type'       => 'Rating',
                'ratingValue' => $review_rating,
            ];
        }

        if ('' != $review_rating && '' != $review_max_rating) {
            $json['reviewRating']['bestRating'] = $review_max_rating;
            $json['reviewRating']['worstRating'] = 1;
        }

        $json = array_filter($json);

        $json = apply_filters('seopress_schemas_auto_review_json', $json);

        $json = '<script type="application/ld+json">' . json_encode($json) . '</script>' . "\n";

        $json = apply_filters('seopress_schemas_auto_review_html', $json);

        echo $json;
    }
}
