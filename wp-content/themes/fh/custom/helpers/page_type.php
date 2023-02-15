<?php

function isBlogPage()
{
    global $wp;
    $currentLang = pll_current_language();
    $postLink = '';
    $postLinkArray = explode('/', get_the_permalink());
    foreach ($postLinkArray as $partLink) {
        if ($partLink !== '') {
            $postLink = $partLink;
        }
    }
    
    return $wp->request !== $postLink && $wp->request !== $currentLang;
}
