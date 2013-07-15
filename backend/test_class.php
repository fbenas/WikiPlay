<?php
    include_once('scrape_wikipedia.php');

  /*  $bla = new scrape_wikipedia("http://en.wikipedia.org/wiki/Php");
    echo "Heading:\n" . $bla->get_heading() . "\n";
    echo "Description:\n" . $bla->get_description() . "\n";
    echo "Link 1:\n" . $bla->get_next_link() . "\n";
    $bla->reset_links();
    echo "Link 1:\n" . $bla->get_next_link() . "\n";
*/
    $random = scrape_wikipedia::get_random_article();
    echo $random->get_heading() . "\n";
    echo $random->get_next_link() . "\n";
?>