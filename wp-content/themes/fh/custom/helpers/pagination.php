<?php


function pagination($currentPage = 1, $nbOfPages = 1, $range = 3)
{
  global $wp;

  $request = $wp->request;

  $previousPageName = "Previous";
  $nextPageName = "Next";

  $maxNbOfPages = 10;
  $html = '<div class="text-center">
                <ul class="pagination">';
  if ($currentPage != 1) {

    $previousPage = $currentPage-1;
    $html .= "<li class=\"prev-button\"><a aria-label='$previousPageName' href=\"\" data-page=\"".($previousPage)."\" ><span aria-hidden=\"true\"><i class=\"icon-chevron-left\"></i></span></a></li>";
  }
  if ($currentPage > $nbOfPages) {
    $currentPage = 1;
  }
  $startPage = $currentPage <= ceil($maxNbOfPages / 2) || $nbOfPages <= $maxNbOfPages ? 1 : $currentPage - ceil($maxNbOfPages / 2) + 2;
  $lastPage = min($nbOfPages, $startPage + $maxNbOfPages -1);
  if ($startPage != 1){
    $html .= "<li><a data-page=\"1\" href=\"\">1</a></li>";
    $html .= "<li> ... </li>";
  }
  for ($i = $startPage; $i <= $lastPage; $i++) {
    if ($currentPage == $i) {
      $html .= "<li class=\"active\"><a data-page=\"".$currentPage."\"  href=\"\">$currentPage</a></li>";
    } else {
      $html .= "<li><a data-page=\"".$i."\"  href=\"\">$i</a></li>";
    }
  }
  if ($currentPage != $nbOfPages) {

    $nextPage = $currentPage+1;
    $html .= "<li class=\"next-button\"><a aria-label='$nextPageName' data-page=\"".($nextPage)."\"  href=\"/" . "\"><span aria-hidden=\"true\"><i class=\"icon-chevron-right\"></i></span></a></li>";
  }
  $html .= '</ul></div>';
  return $html;

}
