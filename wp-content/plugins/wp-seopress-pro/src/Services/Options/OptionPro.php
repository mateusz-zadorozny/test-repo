<?php

namespace SEOPressPro\Services\Options;

defined('ABSPATH') or exit('Cheatin&#8217; uh?');

use SEOPressPro\Services\Options\Schemas\LocalBusinessOptions;
use SEOPressPro\Services\Options\Schemas\PublisherOptions;

class OptionPro {
    use LocalBusinessOptions;
    use PublisherOptions;

    /**
     * @since 4.5.0
     *
     * @return array
     */
    public function getOption() {
        if (is_network_admin() && is_multisite()) {
            return get_option('seopress_pro_mu_option_name');
        } else {
            return get_option('seopress_pro_option_name');
        }
    }

    /**
     * @since 4.5.0
     *
     * @return string|null
     *
     * @param string $key
     */
    protected function searchOptionByKey($key) {
        $data = $this->getOption();

        if (empty($data)) {
            return null;
        }

        if ( ! isset($data[$key])) {
            return null;
        }

        return $data[$key];
    }

    /**
     * @since 4.6.0
     *
     * @return string
     */
    public function getRichSnippetEnable() {
        return $this->searchOptionByKey('seopress_rich_snippets_enable');
    }

    /**
     * @since 4.6.0
     *
     * @return string
     */
    public function getArticlesPublisher() {
        return $this->searchOptionByKey('seopress_social_knowledge_name');
    }

    /**
     * @since 4.6.0
     *
     * @return string
     */
    public function getRichSnippetsSiteNavigation() {
        return $this->searchOptionByKey('seopress_rich_snippets_site_nav');
    }

    /**
     * @since 6.0.0
     *
     * @return string
     */
    public function getBreadcrumbsSeparator() {
        return $this->searchOptionByKey('seopress_breadcrumbs_separator');
    }

    /**
     * @since 6.0.0
     *
     * @return string
     */
    public function getBreadcrumbsI18nHere() {
        return $this->searchOptionByKey('seopress_breadcrumbs_i18n_here');
    }

    /**
     * @since 6.0.0
     *
     * @return string
     */
    public function getBreadcrumbsI18nHome() {
        return $this->searchOptionByKey('seopress_breadcrumbs_i18n_home');
    }

    /**
     * @since 6.0.0
     *
     * @return string
     */
    public function getBreadcrumbsI18nAuthor() {
        return $this->searchOptionByKey('seopress_breadcrumbs_i18n_author');
    }

    /**
     * @since 6.0.0
     *
     * @return string
     */
    public function getBreadcrumbsI18n404() {
        return $this->searchOptionByKey('seopress_breadcrumbs_i18n_404');
    }

    /**
     * @since 6.0.0
     *
     * @return string
     */
    public function getBreadcrumbsI18nSearch() {
        return $this->searchOptionByKey('seopress_breadcrumbs_i18n_search');
    }

    /**
     * @since 6.0.0
     *
     * @return string
     */
    public function getBreadcrumbsI18nNoResults() {
        return $this->searchOptionByKey('seopress_breadcrumbs_i18n_no_results');
    }

    /**
     * @since 6.0.0
     *
     * @return string
     */
    public function getBreadcrumbsI18nAttachments() {
        return $this->searchOptionByKey('seopress_breadcrumbs_i18n_attachments');
    }

    /**
     * @since 6.0.0
     *
     * @return string
     */
    public function getBreadcrumbsI18nPaged() {
        return $this->searchOptionByKey('seopress_breadcrumbs_i18n_paged');
    }

    /**
     * @since 6.0.0
     *
     * @return string
     */
    public function getBreadcrumbsRemoveBlogPage() {
        return $this->searchOptionByKey('seopress_breadcrumbs_remove_blog_page');
    }

    /**
     * @since 6.0.0
     *
     * @return string
     */
    public function getBreadcrumbsRemoveShopPage() {
        return $this->searchOptionByKey('seopress_breadcrumbs_remove_shop_page');
    }

    /**
     * @since 6.0.0
     *
     * @return string
     */
    public function getBreadcrumbsDisableSeparator() {
        return $this->searchOptionByKey('seopress_breadcrumbs_separator_disable');
    }

    /**
     * @since 6.0.0
     *
     * @return string
     */
    public function getBreadcrumbsStorefront() {
        return $this->searchOptionByKey('seopress_breadcrumbs_storefront');
    }
}
