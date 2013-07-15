<!DOCTYPE html>
<html>
<head>
    <title>WikiPlay</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap-responsive.css"></link>
    <link rel="stylesheet" href="../css/custom.css"></link>
    <script src="/jquery/jquery.min.js" type="text/javascript"></script>
</head>

<body>
<?php 
    include "../backend/scrape_wikipedia.php";
?>
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <button class="btn btn-navbar" data-target=".nav-collapse" data-toggle="collapse" type="button"></button>
            <a class="brand" href="#">WikiPlay</a>
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li class="active">
                        <a href="#">
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

    <div class="hero-unit hero-main">

        <h1>WikiPlay</h1>
        <p>Navigate from one random article to another, just through links in the first paragraph!</p>
        

        <form class="navbar-form pull-left">
            <p><form id="foo">
               	<input type="text" value="<?php echo scrape_wikipedia::get_random_article()->get_heading(); ?>" class="span2 long-input" id="start">
				<input type="submit" value="Send" />
            </form></p>
            <p class="vert-middle"> to </p>
            <p>
                <input type="text" value="<?php echo scrape_wikipedia::get_random_article()->get_heading(); ?>" class="span2 long-input" id="finish">
                <button type="button" class="badge" onclick="random_wiki(this.id)" id="random2">randomize</button>
            </p>
            <p><button type="submit" class="btn btn-primary btn-large btn-go">Go</button></p>
        </form> 
    </div>
</div>
      <!-- /container -->
    
      <!-- Le javascript
    ================================================== -->
    
      <!-- Placed at the end of the document so the pages load faster -->
    <script src="bootstrap/js/bootstrap-min.js"></script>

    <!--===================================================-->
    <!-- Custom javascript -->
    <script  type="text/javascript">
	// variable to hold request
	
	var request;
	// bind to the submit event of our form
	$("#foo").submit(function(event){
    		// abort any pending request
	    	if (request) {
        		request.abort();
    		}
    
			// setup some local variables
		    var $form = $(this);
    		// let's select and cache all the fields
	    	var $inputs = $form.find("input, select, button, textarea");
	    	// serialize the data in the form
    		var serializedData = $form.serialize();

	    	// fire off the request to /form.php
		    request = $.ajax({
    	 	   	url: "backend/ajaxBackend.php",
        		type: "post",
		        data: serializedData
    		});

	    	// callback handler that will be called on success
    		request.done(function (response, textStatus, jqXHR){
        
				// log a message to the console
	        	console.log("Hooray, it worked!");
			});

		    // callback handler that will be called on failure
		    request.fail(function (jqXHR, textStatus, errorThrown){
        	// log the error to the console
		        console.error(
	    	        "The following error occured: "+
        	    	textStatus, errorThrown
        		);
		    });

		    // callback handler that will be called regardless
	    	// if the request failed or succeeded
		    request.always(function () {
    		    // reenable the inputs
		        $inputs.prop("disabled", false);
		    });
});
    </script>
    <!--===================================================-->
</body>
</html>
