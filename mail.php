<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
     <meta name="description" content="The website for Wildlife Center volunteers">
    <meta name="keywords" content="wildlife, volunteer, virginia">
    <meta name="author" content="Shanice McCormick and Nicole Moran">
    
    <title>Send Mail | Wildlife Center Volunteers</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Caveat+Brush" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Arimo|Caveat+Brush" rel="stylesheet">

    <!--Leave this area commented!-->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

  <!--display the nav bar -->
  <?php include("navHeader.php"); ?>

<div class="container">
  <div class="row">
    <div class="col-xs-3">
    <!--Spacer-->
    </div> 
    <div class="col-xs-6">
      <h3>WILDLIFE CENTER OF VIRGINIA</h3>
      <img src="images/nature.png" alt="Logo" class="logo img-responsive"> 
    </div>
</div> <!--End row-->
</div>
<!-- end div col-->   
    
    <div class="header">
      <a href="index.html">
       <button type="button" class="btn btn-link">Log Out</button>  
      </a>
    </div>
<!-- end div col-->

    <!--Page heading-->
    <div class="row pageheading">
      <div class="col-sm-3">
        <!--Spacer for desktops-->
      </div>
      <div class="col-xs-12 col-sm-6">
        <h1>Send Mail</h1>
      </div>
    </div>

  	<div class="row">
  		<div class="col-sm-3">
  			<!--Spacer for tablet size and up-->
  		</div>
  		<div class="c0l-xs-12 col-sm-6">
		  <form id="mail">
            Select Individuals:<br>
            <select>
              <option>Jane Doe</option>
              <option>John Smith</option>
              <option>Joe Schmo</option>
              <option>James Madison</option>
            </select><br>
            <br>
            Select Groups:<br>
            <select>
              <option>Animal care volunteers</option>
              <option>Outreach volunteers</option>
              <option>Transporters</option>
              <option>Veterinarians</option>
              <option>Team Leaders</option>
              <option>Everyone</option>
            </select><br>
            <br>
            <textarea>Type your message here...</textarea>
        </form>
        <button><a href="mailto:someone@example.com?Subject=Hello%20again" target="_top">Send</a></button>
  	 </div>
  	</div>

<footer>
	<p>© 2017 The Wildlife Center of Virginia. All Rights Reserved.</p>
</footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>