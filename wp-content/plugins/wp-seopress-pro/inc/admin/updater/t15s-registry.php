<?php
/**
 * Main T15S library.
 *
 * @since 1.0.0
 *
 * @package WP_Translations\T15S_registry
 */
// Exit if accessed directly
if ( ! defined('ABSPATH')) {
    exit;
}
class SEOPRESS_Language_Packs {

    /**
     * Transient key
     *
     * @var string
     */
    const TRANSIENT_KEY_PLUGIN = 't15s-registry-wp-seopress-pro';

    /**
     * Project directory slug
     *
     * @var string
     */
    private $slug = '';

    /**
     * Full GlotPress API URL for the project.
     *
     * @var string
     */
    private $api_url = '';

    /**
     * Installed translations.
     *
     * @var array
     */
    private static $installed_translations;

    /**
     * Available languages.
     *
     * @var array
     */
    private static $available_languages;

    /**
     * Adds a new project to load translations for.
     *
     * @since 1.1
     *
     * @param string $slug    Project directory slug.
     * @param string $api_url Full GlotPress API URL for the project.
     */
    public function __construct($slug, $api_url) {
        $this->slug = $slug;
        $this->api_url = $api_url;

        add_action('init', [ __CLASS__, 'register_clean_translations_cache' ], 9999);
        add_filter('translations_api', [ $this, 'translations_api' ], 10, 3);
        add_filter('site_transient_update_plugins', [ $this, 'site_transient_update_plugins' ]);
    }

    /**
     * Short-circuits translations API requests for private projects.
     *
     * @since 1.1
     *
     * @param bool|array $result         The result object. Default false.
     * @param string     $requested_type The type of translations being requested.
     * @param object     $args           Translation API arguments.
     * @return bool|array
     */
    public function translations_api($result, $requested_type, $args) {
        if ('plugins' === $requested_type && $this->slug === $args['slug']) {
            return self::get_translations($args['slug'], $this->api_url);
        }

        return $result;
    }

    /**
     * Filters the translations transients to include the private plugin or theme.
     *
     * @see wp_get_translation_updates()
     *
     * @since 1.1
     *
     * @param bool|array $value The transient value.
     */
    public function site_transient_update_plugins($value) {
        if ( ! $value) {
            $value = new stdClass();
        }

        if ( ! isset($value->translations)) {
            $value->translations = [];
        }

        $translations = self::get_translations($this->slug, $this->api_url);

        if ( ! isset($translations['translations'])) {
            return $value;
        }

        $installed_translations = self::get_installed_translations();

        foreach ((array) $translations['translations'] as $translation) {
            if (in_array($translation['language'], self::get_available_languages())) {
                if (isset($installed_translations[ $this->slug ][ $translation['language'] ]) && $translation['updated']) {
                    $local = new DateTime($installed_translations[ $this->slug ][ $translation['language'] ]['PO-Revision-Date']);
                    $remote = new DateTime($translation['updated']);

                    if ($local >= $remote) {
                        continue;
                    }
                }

                $translation['type'] = 'plugin';
                $translation['slug'] = $this->slug;

                $value->translations[] = $translation;
            }
        }

        return $value;
    }

    /**
     * Registers actions for clearing translation caches.
     *
     * @since 1.1
     */
    public static function register_clean_translations_cache() {
        add_action('set_site_transient_update_plugins', [ __CLASS__, 'clean_translations_cache' ]);
        add_action('delete_site_transient_update_plugins', [ __CLASS__, 'clean_translations_cache' ]);
    }

    /**
     * Clears existing translation cache.
     *
     * @since 1.1
     */
    public static function clean_translations_cache() {
        $translations = get_site_transient(self::TRANSIENT_KEY_PLUGIN);

        if ( ! is_object($translations)) {
            return;
        }

        /*
         * Don't delete the cache if the transient gets changed multiple times
         * during a single request. Set cache lifetime to maximum 15 seconds.
         */
        $cache_lifespan = 15;
        $time_not_changed = isset($translations->_last_checked) && (time() - $translations->_last_checked) > $cache_lifespan;

        if ( ! $time_not_changed) {
            return;
        }

        delete_site_transient(self::TRANSIENT_KEY_PLUGIN);
    }

    /**
     * Gets the translations for a given project.
     *
     * @since 1.1
     *
     * @param string $slug Project directory slug.
     * @param string $url  Full GlotPress API URL for the project.
     * @return array Translation data.
     */
    private static function get_translations($slug, $url) {
        $translations = get_site_transient(self::TRANSIENT_KEY_PLUGIN);

        if ( ! is_object($translations)) {
            $translations = new stdClass();
        }

        if (isset($translations->{$slug}) && is_array($translations->{$slug})) {
            return $translations->{$slug};
        }

        $result = json_decode(wp_remote_retrieve_body(wp_remote_get($url, [ 'timeout' => 2 ])), true);

        // Nothing found.
        if ( ! is_array($result)) {
            $result = [];
        }

        $translations->{$slug} = $result;
        $translations->_last_checked = time();

        set_site_transient(self::TRANSIENT_KEY_PLUGIN, $translations);
        return $result;
    }

    /**
     * Returns installed translations.
     *
     * Used to cache the result of wp_get_installed_translations() as it is very expensive.
     *
     * @since 1.1
     *
     * @return array
     */
    private static function get_installed_translations() {
        if (null === self::$installed_translations) {
            self::$installed_translations = wp_get_installed_translations('plugins');
        }
        return self::$installed_translations;
    }

    /**
     * Returns available languages.
     *
     * Used to cache the result of get_available_languages() as it is very expensive.
     *
     * @since 1.1
     *
     * @return array
     */
    private static function get_available_languages() {
        if (null === self::$available_languages) {
            self::$available_languages = get_available_languages();
        }
        return self::$available_languages;
    }
}
