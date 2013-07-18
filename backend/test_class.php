<?php
    include_once('scrape_wikipedia.php');

    // testing the backend.
    $random = new scrape_wikipedia("http://en.wikipedia.org/wiki/Computer_networks");
    echo $random->get_heading() . "\n";

    echo $random->get_description() . "\n";
    //echo $random->get_url() ."\n";

    for($i=0; $i<$random->get_link_count(); $i++)
    {
    	echo $random->get_link($i) . "\n";
    }

?>