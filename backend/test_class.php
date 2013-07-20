<?php
    include_once('scrape_wikipedia.php');

    // testing the backend.
    /*$page = scrape_wikipedia::get_random_article();
	while($page->get_description() == '' || $page->get_link_count() == 0)
	{
		$page = scrape_wikipedia::get_random_article();
	}*/
	$page = new scrape_wikipedia("http://en.wikipedia.org/wiki/-");
	echo $page->get_heading() . '\n';
    for($i=0; $i<$page->get_link_count(); $i++)
    {
    	echo $page->get_link($i) . "\n";
    }

?>
    