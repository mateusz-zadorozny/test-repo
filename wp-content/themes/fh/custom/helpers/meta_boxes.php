<?php


function generate_meta_boxes_custom_fields_by_laguages($mb, &$meta_boxes)
{
    $languages = pll_the_languages(['raw' =>1, 'hide_current' => 0]);
    $mbTxt = json_encode($mb);
    
    foreach ($languages as $langObject) {
        $lang = $langObject['slug'];
        $mbLang = str_replace('%LANG%', $lang, $mbTxt);
        $meta_boxes[] = json_decode($mbLang, true);
    }
    
}