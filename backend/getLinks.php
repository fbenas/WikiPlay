<?php 

  include "../backend/scrape_wikipedia.php";
  $url = $_POST["url"];
  $page = new scrape_wikipedia($url);

  $return_array = $page->get_links();
  echo json_encode($return_array);

?>
