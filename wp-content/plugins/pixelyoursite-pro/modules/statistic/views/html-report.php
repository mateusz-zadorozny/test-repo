<?php

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
/**
 * @var String $type // edd or woo
 */
$visitModel = isset($_GET['data_model']) ? $_GET['data_model'] : PYS()->getOption('visit_data_model');
$activeFilter = isset($_GET['active_filter']) ? $_GET['active_filter'] : "traffic_source";
$filterId = isset($_GET['filter_id']) ? $_GET['filter_id'] : -1;
$time = isset($_GET['time']) ? $_GET['time'] : "30";
$title = isset($_GET['title']) ? $_GET['title'] : "";
$timeStart = isset($_GET['time_start']) ? $_GET['time_start'] : "";
$timeEnd = isset($_GET['time_end']) ? $_GET['time_end'] : "";
$perPage = isset($_GET['per_page']) ? $_GET['per_page'] : "25";

$filters = [
    "traffic_source" => "Traffic source",
    "traffic_landing" => "Landing page",
    "utm_source" => "utm_source",
    "utm_medium" => "utm_medium",
    "utm_campaign" => "utm_campaign",
    "utm_content" => "utm_content",
    "utm_term" => "utm_term",
];
$statistic = $type == "woo" ? PysStatistic()->wooStatistic : PysStatistic()->eddStatistic;
$status = $statistic->getSyncStatus();
if($status == OrderStatistics::$SYNC_STATUS_START) :
    include 'html-report-loading.php';
else: ?>
    <div class="row">
        <div class="col">
            <ul class="pys_stats_filters">
                <?php
                    $active = ["data_model","time","time_start","time_end","per_page"];
                    $params="";

                    foreach ($_GET as $key => $val) {
                        if(in_array($key,$active)) {
                            $params .= "&" . $key . "=" . $val;
                        }
                    }
                ?>
                <?php foreach ($filters as $filter => $name) : ?>
                    <li class="filter <?=$activeFilter == $filter ? 'active': '' ?>" data-type="<?=$filter?>">
                        <a href="<?=admin_url("admin.php?page=pixelyoursite_".$type."_reports&active_filter=$filter".$params)?>"><?=$name?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="COG_custom_report_button_block">
        <div class="button-block">
            <button type="button" class="btn button_default button <?php if(!isset($_COOKIE['stat_cog']) || $_COOKIE['stat_cog']=='default'){echo ' btn-primary';}?>" data-value="default">Default</button>
            <button type="button" class="btn button_cog button <?php if(isset($_COOKIE['stat_cog']) && $_COOKIE['stat_cog']=='cog'){echo ' btn-primary';}?>" data-value="cog">Cost and Profit</button>
        </div>
    </div>
    <?php

    if($filterId > 0) {
        include 'html-report-data-single.php';
    } else {
        include 'html-report-data-global.php';
    }
    include 'html-report-settings.php';
endif;
?>
