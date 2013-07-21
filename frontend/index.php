<!DOCTYPE html>
<html>
<head>
<?php
    $error='';
    session_start(); 
    if(isset($_SESSION['error']))
    {
        $error = $_SESSION['error'] . " (click to remove)";
        unset($_SESSION['error']);
    }
?>
    <title>WikiPlay</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="bootstrap/css/bootstrap-responsive.css" />
    <link rel="stylesheet" href="css/custom.css" />
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
    <p class="error" onClick="removeError()"><?php echo $error; ?></p>
    <div class="hero-unit hero-main hero-index">

        <h1>WikiPlay</h1>
        <p>Navigate from one random article to another, just through links in the first paragraph!</p>
        

        <form class="navbar-form pull-left" id="searchForm" action="play.php" method="post">
            <p id="startp">
               	<input type="text" value="" class="span2 long-input" id="start" readonly>
                <input type="hidden" name="start_url" value="" id="starturl">
				<button type="button" id="startbtn" onClick="getRandomLink('start')" class="badge">randomize</button>
            </p>
            <p class="vert-middle"> to </p>
            <p id="finishp">
                <input type="text" value="" class="span2 long-input" id="finish" readonly>
                <input type="hidden" name="finish_url" value="" id="finishurl">
                <button type="button" id="finishbtn" class="badge" onClick="getRandomLink('finish')">randomize</button>
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
    getRandomLink("start");
    getRandomLink("finish");
});

    function getRandomLink(name)
    {
        $('#' + name).val("loading...");
        $('#' + name + "btn").hide();
        $('#' + name + 'p').append("<img id='" + name + "gif' class='loadgif' src='http://www.oenovaults.com/images/loading.gif'/>");
        $.post("../backend/ajaxRandom.php", 
            function(data){
                $('#' + name).val(data["heading"]);
                $('#' + name + "url").val(data["url"]);
                $('#' + name + "btn").show();
                $('#' + name + 'gif').remove();
                
        }, "json");
    }

    function removeError()
    {
        $("p.error").empty();
    }
    </script>
    <!--===================================================-->
</body>
</html>
