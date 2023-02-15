<?php

namespace SEOPressPro\Services\Forms\Schemas;

defined('ABSPATH') || exit;

use SEOPressPro\Core\FormApi;

class FormSchemaRecipe extends FormApi {
    protected function getTypeByField($field) {
        switch ($field) {
            case '_seopress_pro_rich_snippets_recipes_desc':
            case '_seopress_pro_rich_snippets_recipes_ingredient':
            case '_seopress_pro_rich_snippets_recipes_instructions':
                return 'textarea';
            case '_seopress_pro_rich_snippets_recipes_name':
            case '_seopress_pro_rich_snippets_recipes_cat':
            case '_seopress_pro_rich_snippets_recipes_video':
            case '_seopress_pro_rich_snippets_recipes_yield':
            case '_seopress_pro_rich_snippets_recipes_keywords':
            case '_seopress_pro_rich_snippets_recipes_cuisine':
                return 'input';
            case '_seopress_pro_rich_snippets_recipes_prep_time':
            case '_seopress_pro_rich_snippets_recipes_cook_time':
            case '_seopress_pro_rich_snippets_recipes_calories':
                return 'number';
            case '_seopress_pro_rich_snippets_recipes_img':
                return 'upload';
        }
    }

    protected function getLabelByField($field) {
        switch ($field) {
            case '_seopress_pro_rich_snippets_recipes_name':
                return __('Recipe name', 'wp-seopress-pro');
            case '_seopress_pro_rich_snippets_recipes_desc':
                return __('Short recipe description', 'wp-seopress-pro');
            case '_seopress_pro_rich_snippets_recipes_cat':
                return __('Recipe category', 'wp-seopress-pro');
            case '_seopress_pro_rich_snippets_recipes_img':
                return __('Image', 'wp-seopress-pro');
            case '_seopress_pro_rich_snippets_recipes_video':
                return __('Video URL of the recipe', 'wp-seopress-pro');
            case '_seopress_pro_rich_snippets_recipes_prep_time':
                return __('Preparation time (in minutes)', 'wp-seopress-pro');
            case '_seopress_pro_rich_snippets_recipes_cook_time':
                return __('Cooking time (in minutes)', 'wp-seopress-pro');
            case '_seopress_pro_rich_snippets_recipes_calories':
                return __('Calories', 'wp-seopress-pro');
            case '_seopress_pro_rich_snippets_recipes_yield':
                return __('Recipe yield', 'wp-seopress-pro');
            case '_seopress_pro_rich_snippets_recipes_keywords':
                return __('Keywords', 'wp-seopress-pro');
            case '_seopress_pro_rich_snippets_recipes_cuisine':
                return __('Recipe cuisine', 'wp-seopress-pro');
            case '_seopress_pro_rich_snippets_recipes_ingredient':
                return __('Recipe ingredients', 'wp-seopress-pro');
            case '_seopress_pro_rich_snippets_recipes_instructions':
                return __('Recipe instructions', 'wp-seopress-pro');
        }
    }

    protected function getDescriptionByField($field) {
        switch ($field) {
            case '_seopress_pro_rich_snippets_recipes_img':
                return __('Minimum size: 185px by 185px, aspect ratio 1:1', 'wp-seopress-pro');
        }
    }

    protected function getPlaceholderByField($field) {
        switch ($field) {
            case '_seopress_pro_rich_snippets_recipes_name':
                return __('The name of your dish', 'wp-seopress-pro');
            case '_seopress_pro_rich_snippets_recipes_desc':
                return __('A short summary describing the dish.', 'wp-seopress-pro');
            case '_seopress_pro_rich_snippets_recipes_cat':
                return __('Eg: appetizer, entree, or dessert', 'wp-seopress-pro');
            case '_seopress_pro_rich_snippets_recipes_img':
                return __('Select your image', 'wp-seopress-pro');
            case '_seopress_pro_rich_snippets_recipes_video':
                return __('Eg: https://www.youtube.com/watch?v=n-a2U4_anWA', 'wp-seopress-pro');
            case '_seopress_pro_rich_snippets_recipes_prep_time':
                return __('Eg: 30 min', 'wp-seopress-pro');
            case '_seopress_pro_rich_snippets_recipes_cook_time':
                return __('Eg: 45 min', 'wp-seopress-pro');
            case '_seopress_pro_rich_snippets_recipes_calories':
                return __('Number of calories', 'wp-seopress-pro');
            case '_seopress_pro_rich_snippets_recipes_yield':
                return __('Eg: number of people served, or number of servings', 'wp-seopress-pro');
            case '_seopress_pro_rich_snippets_recipes_keywords':
                return __('Eg: winter apple pie, nutmeg crust (NOT recommended: dessert, American)', 'wp-seopress-pro');
            case '_seopress_pro_rich_snippets_recipes_cuisine':
                return __('The region associated with your recipe. For example, "French", Mediterranean", or "American"', 'wp-seopress-pro');
            case '_seopress_pro_rich_snippets_recipes_ingredient':
                return __("Ingredients used in the recipe. One ingredient per line. Include only the ingredient text that is necessary for making the recipe. Don't include unnecessary information, such as a definition of the ingredient.", 'wp-seopress-pro');
            case '_seopress_pro_rich_snippets_recipes_instructions':
                return __('eg: Heat oven to 425°F. Include only text on how to make the recipe and don\'t include other text such as "Directions", "Watch the video", "Step 1".', 'wp-seopress-pro');
            default:
                return '';
        }
    }

    protected function getDetails() {
        return [
            [
                'key' => '_seopress_pro_rich_snippets_recipes_name',
            ],
            [
                'key' => '_seopress_pro_rich_snippets_recipes_desc',
            ],
            [
                'key' => '_seopress_pro_rich_snippets_recipes_cat',
            ],
            [
                'key' => '_seopress_pro_rich_snippets_recipes_img',
            ],
            [
                'key' => '_seopress_pro_rich_snippets_recipes_video',
            ],
            [
                'key' => '_seopress_pro_rich_snippets_recipes_prep_time',
                'min' => 1,
            ],
            [
                'key' => '_seopress_pro_rich_snippets_recipes_cook_time',
                'min' => 1,
            ],
            [
                'key' => '_seopress_pro_rich_snippets_recipes_calories',
                'min' => 1,
            ],
            [
                'key' => '_seopress_pro_rich_snippets_recipes_yield',
            ],
            [
                'key' => '_seopress_pro_rich_snippets_recipes_keywords',
            ],
            [
                'key' => '_seopress_pro_rich_snippets_recipes_cuisine',
            ],
            [
                'key' => '_seopress_pro_rich_snippets_recipes_ingredient',
                'class' => 'seopress-textarea-high-size'
            ],
            [
                'key' => '_seopress_pro_rich_snippets_recipes_instructions',
                'class' => 'seopress-textarea-high-size'
            ],
        ];
    }
}
