<!DOCTYPE html>
<html>
<head>
    <title>WikiPlay</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="bootstrap/css/bootstrap-responsive.css"></link>
    <link rel="stylesheet" href="css/custom.css"></link>
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

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

        <h1>WikiPlay</h1>
        <p>Navigate from one random article to another, just through links in the first paragraph!</p>
        

        <form class="navbar-form pull-left" id="searchForm" action="play.php" method="post">
            <p>
               	<input type="text" value="" class="span2 long-input" id="start" readonly>
                <input type="hidden" name="start_url" value="" id="starturl">
				<button type="button" onClick="dosome('start')" class="badge" id="random2">randomize</button>
            </p>
            <p class="vert-middle"> to </p>
            <p>
                <input type="text" value="" class="span2 long-input" id="finish" readonly>
                <input type="hidden" name="finish_url" value="" id="finishurl">
                <button type="button" class="badge" onClick="dosome('finish')" id="random2" >randomize</button>
            </p>
            <p><button type="submit" class="btn btn-primary btn-large btn-go">Go</button></p>
        </form>
    </div>
</div>
      <!-- Placed at the end of the document so the pages load faster -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
    // Handler for .ready() called.
    dosome("start");
    dosome("finish");
});

    function dosome(name)
    {
        $('#' + name).val("loading...");
        $.post("../backend/ajaxRandom.php", 
            function(data){
                $('#' + name).val(data["heading"]);
                $('#' + name + "url").val(data["url"]);
                
        }, "json");
    }

    </script>
    <!--===================================================-->
</body>
</html>
