<?php 

  include "../backend/scrape_wikipedia.php";
  $page = scrape_wikipedia::get_random_article();
  while($page->get_description() == '' || $page->get_link_count() == 0)
  {
  	$page = scrape_wikipedia::get_random_article();
  }
  $heading = $page->get_heading();
  $url = $page->get_url();
  $return_array = array('heading'=>$heading, 'url'=>$url);
  echo json_encode($return_array);

?>
