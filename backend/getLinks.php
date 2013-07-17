<?php 

  include "../backend/scrape_wikipedia.php";

  $url = $_POST["url"];

  $page = new scrape_wikipedia($url);

  $count = $page->get_link_count();

    $return_array = array();
    for($i=0;$i<$count;$i++)
    {
        $return_array[$i] = $page->get_link($i);
    }

  echo json_encode($return_array);

?>
