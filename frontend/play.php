<!DOCTYPE html>
<html>
<head>
<?php 
	define ('SITE_ROOT', realpath(dirname(__FILE__)));
	define ('SITE_URL',    'http://'.$_SERVER['HTTP_HOST']);

	if(!isset($_POST["start_url"]) || !isset($_POST["finish_url"]) || $_POST["start_url"] == "" || $_POST["finish_url"] == "")
	{
		header("Location:index.php");
	}

    include "../backend/scrape_wikipedia.php";
    $start = new scrape_wikipedia($_POST["start_url"]);
    $finish = new scrape_wikipedia($_POST["finish_url"]);

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

    <div class="hero-unit hero-main block-form">
    	<ol id="list">
    		<li>Starting here: <?php echo $start->get_heading(); ?></li>
    	</ol>
    	<div class="choices">
    	<?php
    		for($i=0; $i < $start->get_link_count(); $i++)
    		{
    			echo "<p><a onClick='dosome($i)' id='$i'>" . strip_tags ($start->get_link($i)) . "</a></p>";
    			echo "<p id='hidden$i' hidden>" . $start->get_link($i) . "</p>";
    			$link = $start->get_next_link();
    		}
    	 ?>
    	</div>
		<p>Finishing here: <?php echo $finish->get_heading(); ?></p>
	</div>

</div>
      <!-- Placed at the end of the document so the pages load faster -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!--===================================================-->
    <script>
    	function dosome(id)
    	{
    		var next = $('#'+id).text();
    		var url ="http://en.wikipedia.org"+ $('#hidden'+id + ' a').attr('href');
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
                for (var i = 0; i < data.length; i++)
                {
    			   $('.choices').append("<p id='hidden"+ i + "' hidden>" + data[i] + "</p>");
    			   $('.choices').append("<p><a onClick='dosome(" + i + ")' id='"+ i + "'>" + $(data[i]).text() + "</a></p>");
                }

                // Check div size.
                if($('p:last').position().top > 400)
    			{
    				$('div.hero-main').height($('p:last').position().top-100);
    			}
    			else
    			{
    				$('div.hero-main').height(400);
    			}
    			// scroll to bottom
    			$("html, body").animate({ scrollTop: $(document).height() }, "slow");
        	},
            "json");
    	}
    </script>
</body>
</html>
