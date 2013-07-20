<!DOCTYPE html>
<html>
<head>
<?php 
	define ('SITE_ROOT', realpath(dirname(__FILE__)));
	define ('SITE_URL',    'http://'.$_SERVER['HTTP_HOST']);

    try 
    {
	    if(!isset($_POST["start_url"]) || !isset($_POST["finish_url"]) || $_POST["start_url"] == "" || $_POST["finish_url"] == "")
		{
			throw new Exception("No URLs found.");
		}

	    include "../backend/scrape_wikipedia.php";

    	$start = new scrape_wikipedia($_POST["start_url"]);
    	$finish = new scrape_wikipedia($_POST["finish_url"]);
    	if( $start->get_link_count() < 1)
    	{
    		throw new Exception("No links found. ("  . $start->get_url() . ")");
    	}
    }
    catch ( Exception $e)
    {
    	session_start(); 
    	$_SESSION['error'] = $e->getMessage();
    	header("Location:index.php");
    	exit;
    }

?>
    <title>WikiPlay</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="bootstrap/css/bootstrap-responsive.css" />
    <link rel="stylesheet" href="css/custom.css" />
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>

<body>

<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <button class="btn btn-navbar" data-target=".nav-collapse" data-toggle="collapse" type="button"></button>
            <a class="brand" href="index.php">WikiPlay</a>
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li class="active">
                        <a href="index.php">
                            Home
                        </a>
                    </li>
                    <li><a href="#About">About</a></li>
                    <li><a href="#Contact">Contact</a></li>
                </ul>
            </div>
      <!--/.nav-collapse -->
    </div>
</div>
</div>
<div class="container">

    <div class="hero-unit hero-main hero-play">
    	<ol id="list">
    	</ol>
    	<div class="choices">
    	<p id='hidden0' hidden><a href="<?php echo preg_replace('/(.+?)org/i',"",$start->get_url()); ?>"</a></p>
    	<p><a onClick=getLinks(0) id="0"><?php echo $start->get_heading(); ?></a></p>
    	</div>
		<p>Target: <?php echo $finish->get_heading(); ?></p>
		<p class="desc"><?php echo $finish->get_description(); ?></p>
	</div>

</div>
      <!-- Placed at the end of the document so the pages load faster -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!--===================================================-->
    <script>
    	$(document).ready(function() {
		    // Handler for .ready() called.
		    getLinks(0);
		});

    	function getLinks(id)
    	{
    		var next = $('#'+id).text();
    		var url ="http://en.wikipedia.org"+ $('#hidden'+id + ' a').attr("href");
            $("#list").append("<li>" + next + "</li>");
    		$('.choices').empty();

            // Display loading
             $(".choices").append("<p class='loading''>Loading...</p>");

    		// Now ajax call to get the next list of links.
    		$.post("../backend/getLinks.php", 
    		"url=" + url,
            function(data){
                // remove loading
                $(".choices").empty();
                if(data.length < 1)
                {
                	$('.choices').append("<p class='no-links'>No Links Found.</p>");
                }
                for (var i = 0; i < data.length; i++)
                {
    			   $('.choices').append("<p id='hidden"+ i + "' hidden>" + data[i] + "</p>");
    			   $('.choices').append("<p><a onClick='getLinks(" + i + ")' id='"+ i + "'>" + $(data[i]).text() + "</a></p>");
                }
    			
    			$('div.hero-play').height($('p:last').position().top-120);
    	
    			// scroll to bottom
    			$("html, body").animate({ scrollTop: $(document).height() }, "slow");
        	},
            "json");
    	}
    </script>
</body>
</html>
