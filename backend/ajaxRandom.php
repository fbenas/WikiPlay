<?php 

//  include "../backend/scrape_wikipedia.php";
//  $randomWikiURL = scrape_wikipedia::get_random_article()->get_heading();
//  echo json_encode($randomWikiURL);

$bar = $_POST['bar'];

$.post('/form.php', serializedData, function(response) {
    // log the response to the console
    console.log("Response: " . "response");
});
?>
