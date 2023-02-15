<?php
defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

///////////////////////////////////////////////////////////////////////////////////////////////////
//Get page by title
// @since 3.8.7
// @author Benjamin
///////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * @deprecated 5.3.0
 * @param mixed $page_title
 * @param mixed $output
 * @param mixed $post_type
 */
function seopress_get_page_by_title($page_title, $output = OBJECT, $post_type = 'seopress_404') {
    return seopress_pro_get_service('Redirection')->getPageByTitle($page_title);
}

///////////////////////////////////////////////////////////////////////////////////////////////////
//Do redirect
///////////////////////////////////////////////////////////////////////////////////////////////////
function seopress_301_do_redirect() {
    if (is_admin()) {
        return;
    }

    global $wp;
    global $post;

    $home_url = home_url($wp->request);

    //WPML
    if (defined('ICL_SITEPRESS_VERSION')) {
        $home_url = untrailingslashit(home_url($wp->request));
    }

    if ( ! isset($_SERVER['QUERY_STRING'])) {
        $_SERVER['QUERY_STRING'] = '';
    }

    $get_init_current_url = htmlspecialchars(rawurldecode(add_query_arg($_SERVER['QUERY_STRING'], '', $home_url)));
    $get_current_url = wp_parse_url($get_init_current_url);

    if (defined('ICL_SITEPRESS_VERSION')) {
        add_filter('wpml_get_home_url', 'seopress_remove_wpml_home_url_filter', 20, 5);
        $home_url2 = home_url($wp->request);
        $get_init_current_url2 = htmlspecialchars(rawurldecode(add_query_arg($_SERVER['QUERY_STRING'], '', $home_url2)));
        $get_current_url2 = wp_parse_url($get_init_current_url2);
        remove_filter('wpml_get_home_url', 'seopress_remove_wpml_home_url_filter', 20);
    }

    $uri = '';
    $uri2 = '';
    $uri3 = '';
    $seopress_get_page = '';
    $if_exact_match = true;

    //Path and Query
    if (isset($get_current_url['path']) && ! empty($get_current_url['path']) && isset($get_current_url['query']) && ! empty($get_current_url['query'])) {
        $uri = trailingslashit($get_current_url['path']) . '?' . $get_current_url['query'];
        $uri2 = $get_current_url['path'] . '?' . $get_current_url['query'];

        $uri = ltrim($uri, '/');
        $uri2 = ltrim($uri2, '/');

        if (defined('ICL_SITEPRESS_VERSION')) {
            if (isset($get_current_url2['path']) && ! empty($get_current_url2['path']) && isset($get_current_url2['query']) && ! empty($get_current_url2['query'])) {
                $uri3 = $get_current_url2['path'] . '?' . $get_current_url2['query'];
                $uri3 = ltrim($uri3, '/');
            }
        }
    }
    //Path only
    elseif (isset($get_current_url['path']) && ! empty($get_current_url['path']) && ! isset($get_current_url['query'])) {
        $uri = $get_current_url['path'];
        $uri = ltrim($uri, '/');

        if (defined('ICL_SITEPRESS_VERSION')) {
            if (isset($get_current_url2['path']) && ! empty($get_current_url2['path']) && ! isset($get_current_url2['query'])) {
                $uri3 = $get_current_url2['path'];
                $uri3 = ltrim($uri3, '/');
            }
        }
    }

    //Query only
    elseif (isset($get_current_url['query']) && ! empty($get_current_url['query']) && ! isset($get_current_url['path'])) {
        $uri = '?' . $get_current_url['query'];
        $uri = ltrim($uri, '/');

        if (defined('ICL_SITEPRESS_VERSION')) {
            if (isset($get_current_url2['query']) && ! empty($get_current_url2['query']) && ! isset($get_current_url2['path'])) {
                $uri3 = '?' . $get_current_url2['query'];
                $uri3 = ltrim($uri3, '/');
            }
        }
    }
    //default - home
    else {
        $uri = $get_current_url['host'];
    }

    //Necessary to allowed "&" in query
    $uri = htmlspecialchars_decode($uri);
    $uri2 = htmlspecialchars_decode($uri2);
    $uri3 = htmlspecialchars_decode($uri3);

    $page_uri = seopress_get_page_by_title(trailingslashit($uri), '', 'seopress_404');
    $page_uri2 = seopress_get_page_by_title($uri2, '', 'seopress_404');

    if (defined('ICL_SITEPRESS_VERSION')) {
        $page_uri4 = seopress_get_page_by_title($uri3, '', 'seopress_404');
    }

    $page_uri3 = seopress_get_page_by_title($uri, '', 'seopress_404');

    //Find URL in Redirections post type --- EXACT MATCH
    /**With trailing slash**/
    if (isset($uri) && '' != $uri && $page_uri) {
        $seopress_get_page = $page_uri;
    }
    /**Without trailing slash**/
    elseif (isset($uri2) && '' != $uri2 && $page_uri2) {
        $seopress_get_page = $page_uri2;
    }
    /**Without language prefix**/
    elseif (defined('ICL_SITEPRESS_VERSION') && isset($uri3) && '' != $uri3 && $page_uri4) {
        $seopress_get_page = $page_uri4;
    }
    /**Default**/
    else {
        $seopress_get_page = $page_uri3;
    }

    //Find URL in Redirections post type --- IGNORE ALL PARAMETERS
    if (empty($seopress_get_page)) {
        $if_exact_match = false;

        $uri = wp_parse_url($uri, PHP_URL_PATH);
        $uri2 = wp_parse_url($uri2, PHP_URL_PATH);
        $uri3 = wp_parse_url($uri3, PHP_URL_PATH);

        $uri = ltrim($uri, '/');
        $uri2 = ltrim($uri2, '/');
        $uri3 = ltrim($uri3, '/');

        $page_uri = seopress_get_page_by_title(trailingslashit($uri), '', 'seopress_404');
        $page_uri2 = seopress_get_page_by_title($uri2, '', 'seopress_404');

        if (defined('ICL_SITEPRESS_VERSION')) {
            $page_uri4 = seopress_get_page_by_title($uri3, '', 'seopress_404');
        }

        $page_uri3 = seopress_get_page_by_title($uri, '', 'seopress_404');

        $page_uri = seopress_get_page_by_title(trailingslashit($uri), '', 'seopress_404');
        $page_uri2 = seopress_get_page_by_title($uri2, '', 'seopress_404');
        $page_uri3 = seopress_get_page_by_title($uri, '', 'seopress_404');

        /**With trailing slash**/
        if (isset($uri) && '' != $uri && $page_uri) {
            $seopress_get_page = $page_uri;
        }
        /**Without trailing slash**/
        elseif (isset($uri2) && '' != $uri2 && $page_uri2) {
            $seopress_get_page = $page_uri2;
        }
        /**Without language prefix**/
        elseif (defined('ICL_SITEPRESS_VERSION') && isset($uri3) && '' != $uri3 && $page_uri4) {
            $seopress_get_page = $page_uri4;
        }
        /**Default**/
        else {
            $seopress_get_page = $page_uri3;
        }
    }

    do_action('seopress_before_redirect', $seopress_get_page);

    if ( ! isset($seopress_get_page->ID)) {
        seopress_pro_get_service('Redirection')->checkRegexRedirect();
        return;
    }

    if ('publish' !== get_post_status($seopress_get_page->ID)) {
        seopress_pro_get_service('Redirection')->checkRegexRedirect();
        return;
    }


    seopress_pro_get_service('Redirection')->handleRedirectionWithId($seopress_get_page->ID, [
        'init_url' => $get_init_current_url,
        'if_exact_match' => $if_exact_match
    ]);
}
add_action('template_redirect', 'seopress_301_do_redirect', 1);

///////////////////////////////////////////////////////////////////////////////////////////////////
//Disable guess redirect url for 404
///////////////////////////////////////////////////////////////////////////////////////////////////
function seopress_404_disable_guess_automatic_redirects_404_option() {
    $seopress_404_disable_guess_automatic_redirects_404_option = get_option('seopress_pro_option_name');
    if ( ! empty($seopress_404_disable_guess_automatic_redirects_404_option)) {
        foreach ($seopress_404_disable_guess_automatic_redirects_404_option as $key => $seopress_404_disable_guess_automatic_redirects_404_value) {
            $options[$key] = $seopress_404_disable_guess_automatic_redirects_404_value;
        }
        if (isset($seopress_404_disable_guess_automatic_redirects_404_option['seopress_404_disable_guess_automatic_redirects_404'])) {
            return $seopress_404_disable_guess_automatic_redirects_404_option['seopress_404_disable_guess_automatic_redirects_404'];
        }
    }
}
if (seopress_404_disable_guess_automatic_redirects_404_option() ==='1') {
    add_filter('do_redirect_guess_404_permalink', '__return_false');
}

///////////////////////////////////////////////////////////////////////////////////////////////////
//Monitor 404
///////////////////////////////////////////////////////////////////////////////////////////////////

//404 monitoring
function seopress_404_enable_option() {
    $seopress_404_enable_option = get_option('seopress_pro_option_name');
    if ( ! empty($seopress_404_enable_option)) {
        foreach ($seopress_404_enable_option as $key => $seopress_404_enable_value) {
            $options[$key] = $seopress_404_enable_value;
        }
        if (isset($seopress_404_enable_option['seopress_404_enable'])) {
            return $seopress_404_enable_option['seopress_404_enable'];
        }
    }
}
//Redirect to home
function seopress_404_redirect_home_option() {
    $seopress_404_redirect_home_option = get_option('seopress_pro_option_name');
    if ( ! empty($seopress_404_redirect_home_option)) {
        foreach ($seopress_404_redirect_home_option as $key => $seopress_404_redirect_home_value) {
            $options[$key] = $seopress_404_redirect_home_value;
        }
        if (isset($seopress_404_redirect_home_option['seopress_404_redirect_home'])) {
            return $seopress_404_redirect_home_option['seopress_404_redirect_home'];
        }
    }
}
//Redirect to custom url
function seopress_404_redirect_custom_url_option() {
    $seopress_404_redirect_custom_url_option = get_option('seopress_pro_option_name');
    if ( ! empty($seopress_404_redirect_custom_url_option)) {
        foreach ($seopress_404_redirect_custom_url_option as $key => $seopress_404_redirect_custom_url_value) {
            $options[$key] = $seopress_404_redirect_custom_url_value;
        }
        if (isset($seopress_404_redirect_custom_url_option['seopress_404_redirect_custom_url'])) {
            return $seopress_404_redirect_custom_url_option['seopress_404_redirect_custom_url'];
        }
    }
}
//Status code
function seopress_404_redirect_status_code_option() {
    $seopress_404_redirect_status_code_option = get_option('seopress_pro_option_name');
    if ( ! empty($seopress_404_redirect_status_code_option)) {
        foreach ($seopress_404_redirect_status_code_option as $key => $seopress_404_redirect_status_code_value) {
            $options[$key] = $seopress_404_redirect_status_code_value;
        }
        if (isset($seopress_404_redirect_status_code_option['seopress_404_redirect_status_code'])) {
            return $seopress_404_redirect_status_code_option['seopress_404_redirect_status_code'];
        }
    }
}
//Enable Mail notifications
function seopress_404_enable_mails_option() {
    $seopress_404_enable_mails_option = get_option('seopress_pro_option_name');
    if ( ! empty($seopress_404_enable_mails_option)) {
        foreach ($seopress_404_enable_mails_option as $key => $seopress_404_enable_mails_value) {
            $options[$key] = $seopress_404_enable_mails_value;
        }
        if (isset($seopress_404_enable_mails_option['seopress_404_enable_mails'])) {
            return $seopress_404_enable_mails_option['seopress_404_enable_mails'];
        }
    }
}
//To Mail Alert
function seopress_404_enable_mails_from_option() {
    $seopress_404_enable_mails_from_option = get_option('seopress_pro_option_name');
    if ( ! empty($seopress_404_enable_mails_from_option)) {
        foreach ($seopress_404_enable_mails_from_option as $key => $seopress_404_enable_mails_from_value) {
            $options[$key] = $seopress_404_enable_mails_from_value;
        }
        if (isset($seopress_404_enable_mails_from_option['seopress_404_enable_mails_from'])) {
            return $seopress_404_enable_mails_from_option['seopress_404_enable_mails_from'];
        }
    }
}
//IP logging
function seopress_404_ip_logging_option() {
    $seopress_404_ip_logging_option = get_option('seopress_pro_option_name');
    if ( ! empty($seopress_404_ip_logging_option)) {
        foreach ($seopress_404_ip_logging_option as $key => $seopress_404_ip_logging_value) {
            $options[$key] = $seopress_404_ip_logging_value;
        }
        if (isset($seopress_404_ip_logging_option['seopress_404_ip_logging'])) {
            return $seopress_404_ip_logging_option['seopress_404_ip_logging'];
        }
    }
}
function seopress_404_send_alert($get_current_url) {
    function seopress_404_send_alert_content_type() {
        return 'text/html';
    }
    add_filter('wp_mail_content_type', 'seopress_404_send_alert_content_type');

    $to = seopress_404_enable_mails_from_option();
    $subject = '404 alert - ' . get_bloginfo('name');

    $body = "<style>
        #wrapper {
            background-color: #F9F9F9;
            margin: 0;
            padding: 70px 0 70px 0;
            -webkit-text-size-adjust: none !important;
            width: 100%;
        }

        #template_container {
            box-shadow:0 0 0 1px #f3f3f3 !important;
            background-color: #ffffff;
            border: 1px solid #e9e9e9;
            padding: 0;
        }

        #template_header {
            color: #333;
            font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;
        }

        #template_header h1,
        #template_header h1 a {
            color: #232323;
        }

        #template_footer td {
            padding: 0;
        }

        #template_footer #credit {
            font-family: courier, 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif;
            font-size: 12px;
            line-height: 125%;
            text-align: center;
            padding: 12px 28px 28px 28px;
        }

        #body_content {
            background-color: #ffffff;
        }

        #body_content table td {
            padding: 48px;
        }

        #body_content table td td {
            padding: 12px;
        }

        #body_content table td th {
            padding: 12px;
        }

        #body_content p {
            margin: 0 0 16px;
        }

        #body_content_inner {
            color: #505050;
            font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;
            font-size: 14px;
            line-height: 150%;
        }

        .td {
            color: #505050;
            border: 1px solid #E5E5E5;
        }

        .text {
            color: #505050;
            font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;
        }

        .link {
            color: #232323;
        }

        #header_wrapper {
            padding: 12px 0 8px 48px;
            display: block;
            border-bottom: 1px solid #F1F1F1;
        }

        h1 {
            color: #232323;
            font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;
            font-size: 18px;
            margin: 0;
            -webkit-font-smoothing: antialiased;
        }

        h2 {
            color: #232323;
            display: block;
            font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;
            font-size: 18px;
            font-weight: bold;
            line-height: 130%;
            margin: 16px 0 8px;
        }

        h3 {
            color: #232323;
            display: block;
            font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;
            font-size: 16px;
            font-weight: bold;
            line-height: 130%;
            margin: 16px 0 8px;
        }

        a {
            color: #232323;
            font-weight: normal;
            text-decoration: underline;
        }

        img {
            border: none;
            display: inline;
            font-size: 14px;
            font-weight: bold;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
            text-transform: capitalize;
        }
    </style>";
    $body .= '<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
        <div id="wrapper">
            <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                <tr>
                    <td align="center" valign="top">
                        <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container">
                            <tr>
                                <td align="center" valign="top">
                                    <!-- Header -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_header">
                                        <tr>
                                            <td id="header_wrapper">
                                                <h1>' . __('404 alert', 'wp-seopress-pro') . '</h1>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- End Header -->
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <!-- Body -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_body">
                                        <tr>
                                            <td valign="top" id="body_content">
                                                <!-- Content -->
                                                <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td valign="top">
                                                            <div id="body_content_inner">
                                                                <p>' . __('You are receiving this email because a new 404 error has been logged on your site. See below:', 'wp-seopress-pro') . '</p>
                                                                <ul><li>' . get_home_url() . '/' . $get_current_url . '</li></ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- End Content -->
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- End Body -->
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <!-- Footer -->
                                    <table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer">
                                        <tr>
                                            <td valign="top">
                                                <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td colspan="2" id="credit" style="border:0;color: #878787; border-top: 1px solid #F1F1F1;" valign="middle">
                                                            <p><a href="' . get_home_url() . '">' . get_bloginfo('name') . '</a></p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- End Footer -->
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>';

    wp_mail($to, $subject, $body);

    remove_filter('wp_mail_content_type', 'seopress_404_send_alert_content_type');
}

//Create Redirection in Post Type
function seopress_404_create_redirect() {
    global $wp;
    global $post;

    $get_current_url = htmlspecialchars(rawurldecode(add_query_arg([], $wp->request)));

    //Exclude URLs from cache
    $match = false;
    $seopress_404_exclude = ['wp-content/cache'];
    $seopress_404_exclude = apply_filters('seopress_404_exclude', $seopress_404_exclude);

    foreach ($seopress_404_exclude as $kw) {
        if (0 === strpos($get_current_url, $kw)) {
            $match = true;
            break;
        }
    }

    //Get Current Time
    $seopress_get_current_time = time();

    //Creating 404 error in seopress_404
    if (false === $match) {
        $seopress_get_page = seopress_get_page_by_title($get_current_url, '', 'seopress_404');

        //Get Title
        if ('' != $seopress_get_page) {
            $seopress_get_post_title = $seopress_get_page->post_title;
        } else {
            $seopress_get_post_title = '';
        }

        //Get User Agent
        $seopress_get_ua = '';
        if ( ! empty($_SERVER['HTTP_USER_AGENT'])) {
            $seopress_get_ua = $_SERVER['HTTP_USER_AGENT'];
        }

        //Get Referer
        $seopress_get_referer = '';
        if (wp_get_referer()) {
            $seopress_get_referer = wp_get_referer();
        }

        //Get IP Address
        $seopress_get_ip = '';
        $ip_logging = 'full';
        if (seopress_404_ip_logging_option()) {
            $ip_logging = seopress_404_ip_logging_option();
        }
        if ($ip_logging === 'full' || $ip_logging === 'anon') {
            if (function_exists('seopress_get_ip_address') && '' != seopress_get_ip_address()) {
                $seopress_get_ip = seopress_get_ip_address();

                if ($ip_logging === 'anon' && function_exists('wp_privacy_anonymize_ip')) {
                    $seopress_get_ip = wp_privacy_anonymize_ip(seopress_get_ip_address());
                }
            }
        }

        if ($get_current_url && $seopress_get_post_title != $get_current_url) {
            wp_insert_post(
                [
                    'post_title' => $get_current_url,
                    'meta_input' => [
                        'seopress_redirections_ua' => $seopress_get_ua,
                        'seopress_redirections_referer' => $seopress_get_referer,
                        '_seopress_404_redirect_date_request' => $seopress_get_current_time,
                        '_seopress_redirections_ip' => $seopress_get_ip,
                    ],
                    'post_type' => 'seopress_404',
                    'post_status' => 'publish',
                ]
            );

            if ('1' === seopress_404_enable_mails_option() && '' !== seopress_404_enable_mails_from_option()) {
                seopress_404_send_alert($get_current_url);
            }
        } elseif ($get_current_url && $seopress_get_page->post_title == $get_current_url) {
            $seopress_404_count = get_post_meta($seopress_get_page->ID, 'seopress_404_count', true);
            update_post_meta($seopress_get_page->ID, 'seopress_404_count', ++$seopress_404_count);
            update_post_meta($seopress_get_page->ID, '_seopress_404_redirect_date_request', $seopress_get_current_time);
            update_post_meta($seopress_get_page->ID, 'seopress_redirections_ua', $seopress_get_ua);
            update_post_meta($seopress_get_page->ID, 'seopress_redirections_referer', $seopress_get_referer);
            update_post_meta($seopress_get_page->ID, '_seopress_redirections_ip', $seopress_get_ip);
        }
    }
}
function seopress_is_bot() {
    $bot_regex = '/BotLink|bingbot|AhrefsBot|ahoy|AlkalineBOT|anthill|appie|arale|araneo|AraybOt|ariadne|arks|ATN_Worldwide|Atomz|bbot|Bjaaland|Ukonline|borg\-bot\/0\.9|boxseabot|bspider|calif|christcrawler|CMC\/0\.01|combine|confuzzledbot|CoolBot|cosmos|Internet Cruiser Robot|cusco|cyberspyder|cydralspider|desertrealm, desert realm|digger|DIIbot|grabber|downloadexpress|DragonBot|dwcp|ecollector|ebiness|elfinbot|esculapio|esther|fastcrawler|FDSE|FELIX IDE|ESI|fido|H�m�h�kki|KIT\-Fireball|fouineur|Freecrawl|gammaSpider|gazz|gcreep|golem|googlebot|griffon|Gromit|gulliver|gulper|hambot|havIndex|hotwired|htdig|iajabot|INGRID\/0\.1|Informant|InfoSpiders|inspectorwww|irobot|Iron33|JBot|jcrawler|Teoma|Jeeves|jobo|image\.kapsi\.net|KDD\-Explorer|ko_yappo_robot|label\-grabber|larbin|legs|Linkidator|linkwalker|Lockon|logo_gif_crawler|marvin|mattie|mediafox|MerzScope|NEC\-MeshExplorer|MindCrawler|udmsearch|moget|Motor|msnbot|muncher|muninn|MuscatFerret|MwdSearch|sharp\-info\-agent|WebMechanic|NetScoop|newscan\-online|ObjectsSearch|Occam|Orbsearch\/1\.0|packrat|pageboy|ParaSite|patric|pegasus|perlcrawler|phpdig|piltdownman|Pimptrain|pjspider|PlumtreeWebAccessor|PortalBSpider|psbot|Getterrobo\-Plus|Raven|RHCS|RixBot|roadrunner|Robbie|robi|RoboCrawl|robofox|Scooter|Search\-AU|searchprocess|Senrigan|Shagseeker|sift|SimBot|Site Valet|skymob|SLCrawler\/2\.0|slurp|ESI|snooper|solbot|speedy|spider_monkey|SpiderBot\/1\.0|spiderline|nil|suke|http:\/\/www\.sygol\.com|tach_bw|TechBOT|templeton|titin|topiclink|UdmSearch|urlck|Valkyrie libwww\-perl|verticrawl|Victoria|void\-bot|Voyager|VWbot_K|crawlpaper|wapspider|WebBandit\/1\.0|webcatcher|T\-H\-U\-N\-D\-E\-R\-S\-T\-O\-N\-E|WebMoose|webquest|webreaper|webs|webspider|WebWalker|wget|winona|whowhere|wlm|WOLP|WWWC|none|XGET|Nederland\.zoek|AISearchBot|woriobot|NetSeer|Nutch|YandexBot|YandexMobileBot|SemrushBot|FatBot|MJ12bot|DotBot|AddThis|baiduspider|SeznamBot|mod_pagespeed|CCBot|openstat.ru\/Bot|m2e/i';

    $bot_regex = apply_filters('seopress_404_bots', $bot_regex);

    $userAgent = empty($_SERVER['HTTP_USER_AGENT']) ? false : $_SERVER['HTTP_USER_AGENT'];
    if ('' != $bot_regex && '' != $userAgent) {
        $isBot = ! $userAgent || preg_match($bot_regex, $userAgent);

        return $isBot;
    }
}

function seopress_404_log() {
    if (is_404() && ! is_admin() && '' != seopress_404_redirect_home_option()) {
        if ('home' === seopress_404_redirect_home_option()) {
            if ('' != seopress_404_redirect_status_code_option()) {
                if ('1' != seopress_is_bot() && seopress_404_enable_option()) {
                    seopress_404_create_redirect();
                }
                wp_redirect(get_home_url(), seopress_404_redirect_status_code_option());
                exit;
            } else {
                if ('1' != seopress_is_bot() && seopress_404_enable_option()) {
                    seopress_404_create_redirect();
                }
                wp_redirect(get_home_url(), '301');
                exit;
            }
        } elseif ('custom' === seopress_404_redirect_home_option() && '' !== seopress_404_redirect_custom_url_option()) {
            if ('' != seopress_404_redirect_status_code_option()) {
                if ('1' != seopress_is_bot() && seopress_404_enable_option()) {
                    seopress_404_create_redirect();
                }
                wp_redirect(seopress_404_redirect_custom_url_option(), seopress_404_redirect_status_code_option());
                exit;
            } else {
                if ('1' != seopress_is_bot() && seopress_404_enable_option()) {
                    seopress_404_create_redirect();
                }
                wp_redirect(seopress_404_redirect_custom_url_option(), '301');
                exit;
            }
        } else {
            if ('1' != seopress_is_bot() && seopress_404_enable_option()) {
                seopress_404_create_redirect();
            }
        }
    } elseif (is_404() && ! is_admin() && seopress_404_enable_option()) {
        if ('1' != seopress_is_bot() && seopress_404_enable_option()) {
            seopress_404_create_redirect();
        }
    }
}
add_action('template_redirect', 'seopress_404_log');

add_filter('auto-draft_to_publish', 'seopress_prevent_title_redirection_already_exist');
add_filter('draft_to_publish', 'seopress_prevent_title_redirection_already_exist');
function seopress_prevent_title_redirection_already_exist($post) {
    if ('seopress_404' !== $post->post_type) {
        return;
    }

    if (wp_is_post_revision($post)) {
        return;
    }

    global $wpdb;

    $sql = $wpdb->prepare(
        "SELECT *
        FROM $wpdb->posts
        WHERE 1=1
        AND post_title = %s
        AND post_type = %s
        AND post_status = 'publish'",
        $post->post_title,
        'seopress_404'
    );

    $wpdb->get_results($sql);

    $count_post_title_exist = $wpdb->num_rows;

    if ($count_post_title_exist > 1) { // already exist
        wp_delete_post($post->ID);
        $exist_redirect_post = get_page_by_title($post->post_title, OBJECT, 'seopress_404');

        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : admin_url('edit.php?post_type=seopress_404');
        $url = remove_query_arg('wp-post-new-reload', $referer);
        set_transient('seopress_prevent_title_redirection_already_exist', [
            'insert_post' => $post,
            'post_exist' => $exist_redirect_post,
            'seopress_redirections_value' => isset($_POST['seopress_redirections_value']) ? $_POST['seopress_redirections_value'] : null,
        ], 3600);

        wp_safe_redirect($url);
        exit;
    }

    // Remove notice watcher if needed
    $notices = seopress_get_option_post_need_redirects();

    if ($notices) {
        foreach ($notices as $key => $notice) {
            if (false !== strpos($notice['before_url'], $post->post_title)) {
                seopress_remove_notification_for_redirect($notice['id']);
            }
        }
    }
}

add_action('seopress_admin_notices', 'seopress_notice_prevent_create_title_redirection');
function seopress_notice_prevent_create_title_redirection() {
    $transient = get_transient('seopress_prevent_title_redirection_already_exist');
    if ( ! $transient) {
        return;
    }

    // Remove notice watcher if needed
    $notices = seopress_get_option_post_need_redirects();
    if ($notices) {
        foreach ($notices as $key => $notice) {
            if (false !== strpos($notice['before_url'], $transient['insert_post']->post_name)) {
                seopress_remove_notification_for_redirect($notice['id']);
            }
        }
    }

    delete_transient('seopress_prevent_title_redirection_already_exist');

    $edit_post_link = get_edit_post_link($transient['post_exist']->ID);

    $message = sprintf(
        /* translators: %s: post name (slug) %s: url redirect */
        __('<p>We were unable to create the redirection you requested (<code>%s</code> to <code>%s</code>).</p>', 'wp-seopress-pro'),
        $transient['insert_post']->post_name,
        $transient['seopress_redirections_value']
    );

    $message .= sprintf(
        /* translators: %s: get_edit_post_link() %s: post name (slug) */
        __('<p>This URL has already a redirection: <a href="%s">%s</a> </p>', 'wp-seopress-pro'),
        $edit_post_link,
        $transient['post_exist']->post_name
    ); ?>
<div class="error notice is-dismissable">
<?php echo $message; ?>
</div>
<?php
}

add_action('save_post_seopress_404', 'seopress_need_add_term_auto_redirect', 10, 2);
function seopress_need_add_term_auto_redirect($post_id, $post) {
    if ('POST' !== $_SERVER['REQUEST_METHOD']) {
        return;
    }

    $referer = wp_get_referer();
    if ( ! $referer) {
        return;
    }

    $parse_referer = wp_parse_url($referer);
    if (false === strpos($parse_referer['query'], 'prepare_redirect=1')) {
        return;
    }

    $name_term = 'Auto Redirect';
    $slug_term = 'autoredirect_by_seopress';
    $term_autoredirect = get_term_by('slug', $slug_term, 'seopress_404_cat', ARRAY_A);
    if ( ! $term_autoredirect) {
        $term_autoredirect = wp_insert_term($name_term, 'seopress_404_cat', [
            'slug' => $slug_term,
        ]);
    }

    $term_id = $term_autoredirect['term_id'];

    $terms = get_the_terms($post_id, 'seopress_404_cat');
    $terms_id = [$term_id];
    if ($terms) {
        foreach ($terms as $term) {
            $terms_id[] = $term->term_id;
        }
    }

    wp_set_post_terms($post_id, $terms_id, 'seopress_404_cat');
}
