<?php

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class EventsManager {
	
	public $doingAMP = false;
	
	private $staticEvents = array();
    private $dynamicEvents = array();
    private $triggerEvents = array();
    private $triggerEventTypes = array();

    /**
     * @var SingleEvent array
     */
	private $facebookServerEvents = array();
    private $standardParams = array();

    private $eddCustomerTotals = array();



	public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueueScripts' ),10 );
        add_action( 'wp_enqueue_scripts', array( $this, 'setupEventsParams' ),14 );
        add_action( 'wp_enqueue_scripts', array( $this, 'outputData' ),15 );

		add_action( 'wp_footer', array( $this, 'outputNoScriptData' ), 10 );
	}



	public function enqueueScripts() {

        wp_register_script( 'vimeo', PYS_URL . '/dist/scripts/vimeo.min.js' );
		wp_register_script( 'jquery-bind-first', PYS_URL . '/dist/scripts/jquery.bind-first-0.2.3.min.js', array( 'jquery' ) );
		wp_register_script( 'js-cookie', PYS_URL . '/dist/scripts/js.cookie-2.1.3.min.js', array(), '2.1.3' );
		
		wp_enqueue_script( 'js-cookie' );
		wp_enqueue_script( 'jquery-bind-first' );

		if ( PYS()->getOption( 'automatic_events_enabled' )
            && PYS()->getOption( 'automatic_event_video_enabled' )
            && PYS()->getOption( 'automatic_event_video_vimeo_enabled' )
        ) {

			wp_enqueue_script( 'vimeo' );
		}
        if ( PYS()->getOption( 'сompress_front_js' )){
            wp_enqueue_script( 'pys', PYS_URL . '/dist/scripts/public.bundle.js',
            array( 'jquery', 'js-cookie', 'jquery-bind-first' ), PYS_VERSION );
        }
        else
        {
            wp_enqueue_script( 'pys', PYS_URL . '/dist/scripts/public.js',
                array( 'jquery', 'js-cookie', 'jquery-bind-first' ), PYS_VERSION );
        }


	}

	public function outputData() {

		$data = array(
			'staticEvents'          => $this->staticEvents,
            'dynamicEvents'          => $this->dynamicEvents,
			'triggerEvents'         => $this->triggerEvents,
			'triggerEventTypes'     => $this->triggerEventTypes,
		);

		// collect options for configured pixel
		foreach ( PYS()->getRegisteredPixels() as $pixel ) {
			/** @var Pixel|Settings $pixel */
			
			if ( $pixel->configured() ) {
				$data[ $pixel->getSlug() ] = $pixel->getPixelOptions();
			}
			
		}
		
		$options = array(
			'debug'                             => PYS()->getOption( 'debug_enabled' ),
			'siteUrl'                           => site_url(),
			'ajaxUrl'                           => admin_url( 'admin-ajax.php' ),
			'trackUTMs'                         => PYS()->getOption( 'track_utms' ),
			'trackTrafficSource'                => PYS()->getOption( 'track_traffic_source' ),
            'user_id'                           => GA()->enabled() && GA()->getOption("track_user_id") ? get_current_user_id() : 0,
            'enable_lading_page_param'          => PYS()->getOption( 'enable_lading_page_param' ),
            'cookie_duration'                   => PYS()->getOption( 'cookie_duration' ),
            'enable_event_day_param'            => PYS()->getOption( 'enable_event_day_param' ),
            'enable_event_month_param'          => PYS()->getOption( 'enable_event_month_param' ),
            'enable_event_time_param'           => PYS()->getOption( 'enable_event_time_param' ),
            'enable_remove_target_url_param'    => PYS()->getOption( 'enable_remove_target_url_param' ),
            'enable_remove_download_url_param'  => PYS()->getOption( 'enable_remove_download_url_param' ),
            'visit_data_model'                  => PYS()->getOption('visit_data_model'),
            'last_visit_duration'               => PYS()->getOption('last_visit_duration'),
            'enable_auto_save_advance_matching' => PYS()->getOption( 'enable_auto_save_advance_matching' ),
            'advance_matching_fn_names'         => PYS()->getOption( 'advance_matching_fn_names' ),
            'advance_matching_ln_names'         => PYS()->getOption( 'advance_matching_ln_names' ),
            'advance_matching_tel_names'         => PYS()->getOption( 'advance_matching_tel_names' ),
		);
		
		$options['gdpr'] = array(
			'ajax_enabled'              => PYS()->getOption( 'gdpr_ajax_enabled' ),
			'all_disabled_by_api'       => apply_filters( 'pys_disable_by_gdpr', false ),
			'facebook_disabled_by_api'  => apply_filters( 'pys_disable_facebook_by_gdpr', false ),
            'tiktok_disabled_by_api'  => apply_filters( 'pys_disable_tiktok_by_gdpr', false ),
			'analytics_disabled_by_api' => apply_filters( 'pys_disable_analytics_by_gdpr', false ),
			'google_ads_disabled_by_api' => apply_filters( 'pys_disable_google_ads_by_gdpr', false ),
			'pinterest_disabled_by_api' => apply_filters( 'pys_disable_pinterest_by_gdpr', false ),
			'bing_disabled_by_api' => apply_filters( 'pys_disable_bing_by_gdpr', false ),
			
			'facebook_prior_consent_enabled'   => PYS()->getOption( 'gdpr_facebook_prior_consent_enabled' ),
            'tiktok_prior_consent_enabled'   => PYS()->getOption( 'gdpr_tiktok_prior_consent_enabled' ),
			'analytics_prior_consent_enabled'  => PYS()->getOption( 'gdpr_analytics_prior_consent_enabled' ),
			'google_ads_prior_consent_enabled' => PYS()->getOption( 'gdpr_google_ads_prior_consent_enabled' ),
			'pinterest_prior_consent_enabled'  => PYS()->getOption( 'gdpr_pinterest_prior_consent_enabled' ),
			'bing_prior_consent_enabled' => PYS()->getOption( 'gdpr_bing_prior_consent_enabled' ),

			'cookiebot_integration_enabled'         => isCookiebotPluginActivated() && PYS()->getOption( 'gdpr_cookiebot_integration_enabled' ),
			'cookiebot_facebook_consent_category'   => PYS()->getOption( 'gdpr_cookiebot_facebook_consent_category' ),
			'cookiebot_analytics_consent_category'  => PYS()->getOption( 'gdpr_cookiebot_analytics_consent_category' ),
			'cookiebot_google_ads_consent_category' => PYS()->getOption( 'gdpr_cookiebot_google_ads_consent_category' ),
			'cookiebot_pinterest_consent_category'  => PYS()->getOption( 'gdpr_cookiebot_pinterest_consent_category' ),
			'cookiebot_bing_consent_category' => PYS()->getOption( 'gdpr_cookiebot_bing_consent_category' ),
			'cookie_notice_integration_enabled' => isCookieNoticePluginActivated() && PYS()->getOption( 'gdpr_cookie_notice_integration_enabled' ),
			'cookie_law_info_integration_enabled' => isCookieLawInfoPluginActivated() && PYS()->getOption( 'gdpr_cookie_law_info_integration_enabled' ),
            'real_cookie_banner_integration_enabled' => isRealCookieBannerPluginActivated() && PYS()->getOption( 'gdpr_real_cookie_banner_integration_enabled' ),
            'consent_magic_integration_enabled' => isConsentMagicPluginActivated() && PYS()->getOption( 'consent_magic_integration_enabled' ),
		);

        /**
         * @var EventsFactory[] $eventsFactory
         */
        $eventsFactory = apply_filters("pys_event_factory",[]);
        foreach ($eventsFactory as $factory) {
            $opt =  $factory->getOptions();
            if(!empty($opt)) {
                $options[$factory::getSlug()] = $factory->getOptions();
            }
        }

		$data = array_merge( $data, $options );

		wp_localize_script( 'pys', 'pysOptions', $data );

	}
	
	public function outputNoScriptData() {
		
		foreach ( PYS()->getRegisteredPixels() as $pixel ) {
			/** @var Pixel|Settings $pixel */
			$pixel->outputNoScriptEvents();
		}
		
	}

    public function getEddCustomerTotals() {

        // setup and cache params
        if ( empty( $this->eddCustomerTotals ) ) {
            $this->eddCustomerTotals = getEddCustomerTotals();
        }

        return $this->eddCustomerTotals;

    }

	public function setupEventsParams() {
        $this->standardParams = getStandardParams();

        $this->facebookServerEvents = array();
		// initial event
        foreach ( PYS()->getRegisteredPixels() as $pixel ) {
            if(method_exists($pixel,'generateEvents')) {
                $pixelEvents =  $pixel->generateEvents( new SingleEvent('init_event',EventTypes::$STATIC,'') );
                if ( count($pixelEvents) == 0 ) {
                    continue; // event is disabled or not supported for the pixel
                }
                $event = $pixelEvents[0];
            } else {
                $event = new SingleEvent('init_event',EventTypes::$STATIC,'');
                $isSuccess = $pixel->addParamsToEvent( $event );
                if ( !$isSuccess ) {
                    continue; // event is disabled or not supported for the pixel
                }
            }


            if($pixel->getSlug() != Tiktok()->getSlug()) {
                $params = array();
                if(get_post_type() == "post") {
                    global $post;
                    $catIds = wp_get_object_terms( $post->ID, 'category', array( 'fields' => 'names' ) );
                    $params['post_category'] = implode(", ",$catIds) ;
                }
                $event->addParams($params);
                $event->addParams($this->standardParams);
            }

            $this->addStaticEvent( $event,$pixel,"" );
        }




        if(EventsEdd()->isEnabled()) {
            // AddToCart on button
            if ( isEventEnabled( 'edd_add_to_cart_enabled') && PYS()->getOption( 'edd_add_to_cart_on_button_click' ) ) {
                add_action( 'edd_purchase_link_end', array( $this, 'setupEddSingleDownloadData' ) );
            }
        }

        if(EventsWoo()->isEnabled()){
            // AddToCart on button and Affiliate
            if(PYS()->getOption('woo_add_to_cart_catch_method') == "add_cart_js") {
                if ( isEventEnabled( 'woo_add_to_cart_enabled') && PYS()->getOption( 'woo_add_to_cart_on_button_click' )
                    || isEventEnabled( 'woo_affiliate_enabled') ) {

                    add_action( 'woocommerce_after_shop_loop_item', array( $this, 'setupWooLoopProductData' ) );
                    add_filter( 'woocommerce_blocks_product_grid_item_html', array( $this, 'setupWooBlocksProductData' ), 10, 3 );
                    add_filter('jet-woo-builder/elementor-views/frontend/archive-item-content', array( $this, 'setupWooBlocksProductData' ),10, 3);

                    if(is_product()) {
                        if(PYS()->getOption('woo_add_to_cart_on_single_product') == 'add_cart_hook') {
                            add_action( 'woocommerce_after_add_to_cart_button', 'PixelYourSite\EventsManager::setupWooSingleProductData' );
                        } else {
                            EventsManager::setupWooSingleProductData();
                        }
                    } else {
                        add_action( 'woocommerce_after_add_to_cart_button', 'PixelYourSite\EventsManager::setupWooSingleProductData' );
                    }
                }
            }

            add_filter("pys_validate_pixel_event",array($this,'validatePixelEvent'),10,3);
        }

        /**
        * @var EventsFactory[] $eventsFactory
         **/
        $eventsFactory = apply_filters("pys_event_factory",[]);

        foreach ($eventsFactory as $factory) {
            if(!$factory->isEnabled())  continue;
            $events = $factory->generateEvents();
            $this->addEvents($events,$factory->getSlug());
        }



        // add Facebook Server events for async sending
        if (count($this->facebookServerEvents) > 0 &&  Facebook()->enabled()) {
            FacebookServer()->sendEventsAsync($this->facebookServerEvents);
            $this->facebookServerEvents = array();
        }

        // remove new user mark
        if($user_id = get_current_user_id()) {
            if ( get_user_meta( $user_id, 'pys_complete_registration', true ) ) {
                delete_user_meta( $user_id, 'pys_complete_registration' );
            }
        }
	}



	function addEvents($pixelEvents,$slug) {


	    foreach ($pixelEvents as $pixelSlug => $events) {
            $pixel = PYS()->getRegisteredPixels()[$pixelSlug];
	        foreach ($events as $event) {
                // add standard params
                if($pixelSlug != Tiktok()->getSlug())
                    $event->addParams($this->standardParams);

                if($event->getType() == EventTypes::$STATIC) {
                    $this->addStaticEvent( $event,$pixel,$slug );
                } elseif($event->getType() == EventTypes::$TRIGGER) {
                    $this->addTriggerEvent($event,$pixel,$slug);
                } else {
                    $this->addDynamicEvent($event,$pixel,$slug);
                }
            }

        }
    }

    /**
     * @param SingleEvent $event
     * @param $pixel
     * @param $slug
     */
    function addDynamicEvent($event,$pixel,$slug) {

        if($event->getId() == 'woo_select_content_search' ||
            $event->getId() == 'woo_select_content_shop' ||
            $event->getId() == 'woo_select_content_tag'||
            $event->getId() == 'woo_select_content_single' ||
            $event->getId() == 'woo_select_content_category')
        {
            $eventData = $event->getData();
            $eventData = $this::filterEventParams($eventData,$slug,['event_id'=>$event->getId(),'pixel'=>$pixel->getSlug()]);
            $this->dynamicEvents[ $event->getId() ][ $event->args ][ $pixel->getSlug() ] = $eventData;
        }
        else if($event->getId() == 'edd_remove_from_cart' || $event->getId() == 'woo_remove_from_cart')
        {
            $eventData = $event->getData();
            $eventData = $this::filterEventParams($eventData,$slug,['event_id'=>$event->getId(),'pixel'=>$pixel->getSlug()]);
            $this->dynamicEvents[ $event->getId() ][ $event->args['key'] ][ $pixel->getSlug() ] = $eventData;
        } else {
            $eventData = $event->getData();
            $eventData = $this::filterEventParams($eventData,$slug,['event_id'=>$event->getId(),'pixel'=>$pixel->getSlug()]);
            //save static event data
            $this->dynamicEvents[ $event->getId() ][ $pixel->getSlug() ] = $eventData;
        }
    }



    function addTriggerEvent($event,$pixel,$slug) {
        $eventData = $event->getData();
        $eventData = $this::filterEventParams($eventData,$slug,['event_id'=>$event->getId(),'pixel'=>$pixel->getSlug()]);
        //save static event data
        if($event->getId() == "custom_event") {
            $eventId = $event->args->getPostId();
        } else {
            $eventId = $event->getId();
        }
        $this->triggerEvents[ $eventId ][ $pixel->getSlug() ] = $eventData;
        $this->triggerEventTypes[ $eventData['trigger_type'] ][ $eventId ] = $eventData['trigger_value'];
    }
    /**
     * Create stack event, they fire when page loaded
     * @param PYSEvent $event
     */
    function addStaticEvent($event, $pixel,$slug) {

            $eventData = $event->getData();
            $eventData = $this::filterEventParams($eventData,$slug,['event_id'=>$event->getId(),'pixel'=>$pixel->getSlug()]);
            // send only for FB Server events
            if($pixel->getSlug() == "facebook" &&
                ($event->getId() == "woo_complete_registration") &&
                Facebook()->isServerApiEnabled() &&
                Facebook()->getOption("woo_complete_registration_send_from_server") &&
                !$this->isGdprPluginEnabled() )
            {
                if($eventData['delay'] == 0) {
                    $this->facebookServerEvents[] = $event;
                }
                return;
            }

            //save static event data
            $this->staticEvents[ $pixel->getSlug() ][ $event->getId() ][] = $eventData;
            // fire fb server api event
            if($pixel->getSlug() == "facebook") {
                if( $eventData['delay'] == 0 && !Facebook()->getOption( "server_event_use_ajax" )) {
                    $this->facebookServerEvents[] = $event;
                }
            }

    }

    static function  filterEventParams($data,$slug,$context = null) {

        if(!PYS()->getOption('enable_content_name_param')) {
            unset($data['params']['content_name']);
        }

        if(!PYS()->getOption('enable_page_title_param')) {
            unset($data['params']['page_title']);
        }

        if(!PYS()->getOption('enable_tags_param')) {
            unset($data['params']['tags']);
        }

        if(!PYS()->getOption('enable_categories_param')) {
            unset($data['params']['categories']);
        }
        if(!PYS()->getOption('enable_post_category_param')) {
            unset($data['params']['post_category']);
        }

        if($slug == EventsWoo::getSlug()) {
            if(!PYS()->getOption("enable_woo_category_name_param")) {
                unset($data['params']['category_name']);
            }
            if(!PYS()->getOption("enable_woo_num_items_param")) {
                unset($data['params']['num_items']);
            }
            if(!PYS()->getOption("enable_woo_tags_param")) {
                unset($data['params']['tags']);
            }
            if(!PYS()->getOption("enable_woo_total_param")) {
                unset($data['params']['total']);
            }

            if(!PYS()->getOption("enable_woo_tax_param")) {
                unset($data['params']['tax']);
            }
            if(!PYS()->getOption("enable_woo_transactions_count_param")) {
                unset($data['params']['transactions_count']);
            }
            if(!PYS()->getOption("enable_woo_predicted_ltv_param")) {
                unset($data['params']['predicted_ltv']);
            }
            if(!PYS()->getOption("enable_woo_average_order_param")) {
                unset($data['params']['average_order']);
            }
            if(!PYS()->getOption("enable_woo_coupon_used_param")) {
                unset($data['params']['coupon_used']);
            }
            if(!PYS()->getOption("enable_woo_coupon_name_param")) {
                unset($data['params']['coupon_name']);
            }
            if(!PYS()->getOption("enable_woo_shipping_param")) {
                unset($data['params']['shipping']);
            }
            if(!PYS()->getOption("enable_woo_shipping_cost_param")) {
                unset($data['params']['shipping_cost']);
            }


        }

        if($slug == EventsEdd::getSlug()) {
            if(!PYS()->getOption("enable_edd_category_name_param")) {
                unset($data['params']['category_name']);
            }
            if(!PYS()->getOption("enable_edd_num_items_param")) {
                unset($data['params']['num_items']);
            }
            if(!PYS()->getOption("enable_edd_total_param")) {
                unset($data['params']['total']);
            }

            if(!PYS()->getOption("enable_edd_tags_param")) {
                unset($data['params']['tags']);
            }
            if(!PYS()->getOption("enable_edd_tax_param")) {
                unset($data['params']['tax']);
            }
            if(!PYS()->getOption("enable_edd_coupon_param")) {
                unset($data['params']['coupon']);
            }
        }

        return apply_filters('pys_event_data',$data,$slug,$context);
    }

	function validatePixelEvent($isValid,$event,$pixel) {
        // skip woo purchase by zero value settings
        if( ($event->getId() == "woo_purchase" || $event->getId() ==  "woo_purchase_category")
            && PYS()->getOption("woo_purchase_not_fire_for_zero")
        ) {
            if($pixel->getSlug() == "bing") {
                if($event->getParamValue('event_value') == 0) {
                    return false;
                }
            } else {
                if($event->getParamValue('value') == 0) {
                    return false;
                }
            }

        }

        // skip edd purchase by zero value settings
        if( ($event->getId() == "edd_purchase" || $event->getId() ==  "edd_purchase_category") &&
            PYS()->getOption("edd_purchase_not_fire_for_zero")
        ) {

            if($pixel->getSlug() == "bing") {
                if($event->getParamValue('event_value') == 0) {
                    return false;
                }
            } else {
                if($event->getParamValue('value') == 0) {
                    return false;
                }
            }

        }

        return $isValid;
    }

	public function getStaticEvents( $context ) {
		return isset( $this->staticEvents[ $context ] ) ? $this->staticEvents[ $context ] : array();
	}






	public function setupEddSingleDownloadData() {
		global $post;

		$download_ids = array();

		if ( edd_has_variable_prices( $post->ID ) ) {

			$prices = edd_get_variable_prices( $post->ID );

			foreach ( $prices as $price_index => $price_data ) {
				$download_ids[] = $post->ID . '_' . $price_index;
			}

		} else {
			$download_ids[] = $post->ID;
		}

		$params = array();

		foreach ( $download_ids as $download_id ) {
            $event = EventsEdd()->getEvent('edd_add_to_cart_on_button_click');
            $event->args = $download_id;
			foreach ( PYS()->getRegisteredPixels() as $pixel ) {
				/** @var Pixel|Settings $pixel */
                $pixelEvents =  $pixel->generateEvents( $event );

				foreach ($pixelEvents as $singleEvent) {
                    $eventData = EventsManager::filterEventParams($singleEvent->getData(),"edd");
                    /**
                     * Format is pysEddProductData[ id ][ id ] or pysEddProductData[ id ] [ id_1, id_2, ... ]
                     */
                    $params[ $download_id ][ $pixel->getSlug() ] = [ // replace data there use only one event
                        'params' => $eventData['params']
                    ];
                }
			}
		}

		if ( empty( $params ) ) {
			return;
		}

		?>

		<script type="application/javascript" style="display:none">
			/* <![CDATA[ */
			window.pysEddProductData = window.pysEddProductData || [];
			window.pysEddProductData[<?php echo $post->ID; ?>] = <?php echo json_encode( $params ); ?>;
			/* ]]> */
		</script>

		<?php

	}


	function isGdprPluginEnabled() {
        return apply_filters( 'pys_disable_by_gdpr', false ) ||
            apply_filters( 'pys_disable_facebook_by_gdpr', false ) ||
            isCookiebotPluginActivated() && PYS()->getOption( 'gdpr_cookiebot_integration_enabled' ) ||
            isCookieNoticePluginActivated() && PYS()->getOption( 'gdpr_cookie_notice_integration_enabled' ) ||
            isRealCookieBannerPluginActivated() && PYS()->getOption( 'gdpr_real_cookie_banner_integration_enabled' ) ||
            isConsentMagicPluginActivated() && PYS()->getOption( 'consent_magic_integration_enabled' ) ||
            isCookieLawInfoPluginActivated() && PYS()->getOption( 'gdpr_cookie_law_info_integration_enabled' );
    }

    public function setupWooLoopProductData()
    {
        global $product;
        $this->setupWooProductData($product);
    }

    public function setupWooBlocksProductData($html, $data, $product)
    {
        $this->setupWooProductData($product);
        return $html;
    }

    public function setupWooProductData($product) {
        if ( !is_a($product,"WC_Product")
            || wooProductIsType( $product, 'variable' )
            || wooProductIsType( $product, 'grouped' )
        ) {
            return; // skip variable products
        }

        if ( wooProductIsType( $product, 'external' ) ) {
            $eventType = 'woo_affiliate';
        } else {
            $eventType = 'woo_add_to_cart_on_button_click';
        }

        $product_id = $product->get_id();

        $params = array();


        foreach ( PYS()->getRegisteredPixels() as $pixel ) {
            /** @var Pixel|Settings $pixel */
            $events = [];
            $initEvent = new SingleEvent($eventType,EventTypes::$STATIC,"woo");
            $initEvent->args = ['productId' => $product_id,'quantity' => 1];
            if(method_exists($pixel,'generateEvents')) {
                add_filter('pys_conditional_post_id', function($id) use ($product_id) { return $product_id; });
                $events =  $pixel->generateEvents( $initEvent );
                remove_all_filters('pys_conditional_post_id',10);
            } else {
                $isSuccess = $pixel->addParamsToEvent( $initEvent );
                if ( $isSuccess ) {
                    $events[] = $initEvent;
                }
            }

            if(count($events) == 0) continue;

            $event = $events[0];

            // prepare event data
            $eventData = EventsManager::filterEventParams($event->getData(),"woo",[
                'event_id'=>$event->getId(),
                'pixel'=>$pixel->getSlug(),
                'product_id'=>$product_id
            ]);

            $params[$pixel->getSlug()] = $eventData;


        }

        if ( empty( $params ) ) {
            return;
        }

        $params = json_encode( $params );

        ?>

        <script type="application/javascript" style="display:none">
            /* <![CDATA[ */
            window.pysWooProductData = window.pysWooProductData || [];
            window.pysWooProductData[ <?php echo $product_id; ?> ] = <?php echo $params; ?>;
            /* ]]> */
        </script>

        <?php

    }

    public static function setupWooSingleProductData() {
        global $product;

        if ( ! is_object( $product)) $product = wc_get_product( get_the_ID() );

        if(!$product || !is_a($product,"WC_Product") ) return;

        if ( wooProductIsType( $product, 'external' ) ) {
            $eventType = 'woo_affiliate';
        } else {
            $eventType = 'woo_add_to_cart_on_button_click';
        }
        $product_id = $product->get_id();

        // main product id
        $product_ids[] = $product_id;

        // variations ids
        if ( wooProductIsType( $product, 'variable' ) ) {
            $product_ids = array_merge($product_ids, $product->get_children());
        }

        $params = array();

        foreach ( $product_ids as $product_id ) {

            foreach ( PYS()->getRegisteredPixels() as $pixel ) {
                /** @var Pixel|Settings $pixel */
                $initEvent = new SingleEvent($eventType,EventTypes::$STATIC,"woo");
                $initEvent->args = ['productId' => $product_id,'quantity' => 1];
                $events = [];
                if(method_exists($pixel,'generateEvents')) {
                    add_filter('pys_conditional_post_id', function($id) use ($product_id) { return $product_id; });
                    $events =  $pixel->generateEvents( $initEvent );
                    remove_all_filters('pys_conditional_post_id',10);
                } else {
                    if( $pixel->addParamsToEvent( $initEvent )) {
                        $events[] = $initEvent;
                    }
                }

                if(count($events) == 0) continue;
                $event = $events[0];

                // prepare event data
                $eventData = $event->getData();
                $eventData = EventsManager::filterEventParams($eventData,"woo",[
                                                                        'event_id'=>$event->getId(),
                                                                        'pixel'=>$pixel->getSlug(),
                                                                        'product_id'=>$product_id
                                                                    ]);

                $params[ $product_id ][ $pixel->getSlug() ] = $eventData;

            }

        }

        if ( empty( $params ) ) {
            return;
        }

        ?>

        <script type="application/javascript" style="display:none">
            /* <![CDATA[ */
            window.pysWooProductData = window.pysWooProductData || [];
            <?php foreach ( $params as $product_id => $product_data ) : ?>
            window.pysWooProductData[<?php echo $product_id; ?>] = <?php echo json_encode( $product_data ); ?>;
            <?php endforeach; ?>
            /* ]]> */
        </script>

        <?php

    }

}