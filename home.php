<?php
include ('loginheader.php');
include("navHeader.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Home | Wildlife Center Volunteers</title>
    <?php include("htmlHead.php")?>
  </head>
 <body>
<div class="container">
  <div class="row">
    <div class="col-sm-1">
    <!--Spacer-->
    </div> 
    <div class="col-xs-12 col-sm-10 vellum">


    <!--This is the standard user's view of the homepage.-->
        <div id="userview" class="">
            <?php
            if ($_SESSION['permission'] == 1) {
                echo "<h1>Volunteer</h1>";
            } elseif ($_SESSION['permission'] == 0) {
                echo "<h1>Applicant</h1>";
            }
            ?>
          <div class="row">
<div class="sidebar">
            
          
</div><!--end .sidebar-->
	</div> <!--End column-->

        <div class="col-sm-7 home-info">
          <h3>Welcome!</h3>
            <!--trying a slideshow-->
            <!--<div class="slideshow-container">
                <div class="mySlides fade">
                    <div class="numbertext">1 / 5</div>
                    <img src="images/slideshow1.jpg" style="width:100%">
                    <div class="text"></div>
                </div>

                <div class="mySlides fade">
                    <div class="numbertext">2 / 5</div>
                    <img src="images/slideshow2.jpg" style="width:100%">
                    <div class="text"></div>
                </div>

                <div class="mySlides fade">
                    <div class="numbertext">3 / 5</div>
                    <img src="images/slideshow3.jpg" style="width:100%">
                    <div class="text"></div>
                </div>

                <div class="mySlides fade">
                    <div class="numbertext">4 / 5</div>
                    <img src="images/slideshow7.jpg" style="width:100%">
                    <div class="text"></div>
                </div>

                <div class="mySlides fade">
                    <div class="numbertext">5 / 5</div>
                    <img src="images/slideshow8.jpg" style="width:100%">
                    <div class="text"></div>
                </div>

                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a>
            </div>
            <br>

            <div style="text-align:center">
                <span class="dot" onclick="currentSlide(1)"></span>
                <span class="dot" onclick="currentSlide(2)"></span>
                <span class="dot" onclick="currentSlide(3)"></span>
                <span class="dot" onclick="currentSlide(4)"></span>
                <span class="dot" onclick="currentSlide(5)"></span>
            </div>
            <script>var slideIndex = 0;
                showSlides();

                function showSlides() {
                    var i;
                    var slides = document.getElementsByClassName("mySlides");
                    for (i = 0; i < slides.length; i++) {
                        slides[i].style.display = "none";
                    }
                    slideIndex++;
                    if (slideIndex> slides.length) {slideIndex = 1}
                    slides[slideIndex-1].style.display = "block";
                    setTimeout(showSlides, 3500); // Change image every 2 seconds
                }</script>
				-->
<?php
if ($_SESSION['permission'] == 0) {
    echo "<!--Applicant paragraph-->
          <p>Thank you for your interest in volunteering with the Wildlife Center. If you haven't already, please fill out an application for a specific volunteer type. You'll be able to log back in and see the status of your application. Best of luck!</p>";
}
elseif ($_SESSION['permission'] == 1) {
    echo " <!--Volunteer paragraph-->
          <p>This is your Wildlife Center homepage. Make changes to your profile, update your hours, check the calendar, and sign up for shifts. If you have any questions, contact your team lead!</p>";
}
elseif ($_SESSION['permission'] == 2) {
    echo "<!--Admin paragraph-->
          <p>This is your dashboard for everything you need to handle volunteers at the Wildlife Center. Search the database, review applications, add events to the calendar, and get in contact with everyone easily.</p>";
}
?>
          <h3>Today's Events</h3>
          <div id="event-feed"></div>
        </div>

        </div><!--End row-->
        </div> <!--End user view-->
    </div><!--End vellum column-->
  </div><!--End row-->

    <footer>
        <i class="fa fa-facebook-official w3-hover-opacity" onclick="window.location='https://www.facebook.com/wildlifecenter/'"></i>
        <i class="fa fa-instagram w3-hover-opacity" onclick="window.location='https://www.instagram.com/explore/locations/292750036/'"></i>
        <i class="fa fa-youtube w3-hover-opacity" onclick="window.location='https://www.youtube.com/user/WildlifeCenterVA'"></i>
        <i class="fa fa-twitter w3-hover-opacity" onclick="window.location='https://twitter.com/WCVtweets'"></i>
        <i class="fa fa-linkedin w3-hover-opacity" onclick="window.location='https://www.linkedin.com/company/wildlife-center-of-va'"></i>
        <p class="w3-medium">Visit us at <a href="http://wildlifecenter.org/" target="_blank">WildLifeCenter.org</a></p>
        <p class="w3-medium">© 2017 The Wildlife Center of Virginia. All Rights Reserved.</p>
    </footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/customscript.js"></script>
	<script src="calendar/lib/moment.min.js"></script>
    <script src="calendar/fullcalendar.js"></script>
    <script src="js/events.js"></script>
  </body>
</html>