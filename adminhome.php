<?php
include("loginheader.php");
include("teamLeadHeader.php");
include ("navHeader.php");
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
            

            <!--This is the admin view of the homepage-->
            <div id="adminview">
                <?php
                if ($_SESSION['permission'] == 3) {
                    echo "<h1>Team Lead</h1>";
                } elseif ($_SESSION['permission'] == 2) {
                    echo "<h1>Staff</h1>";
                }
                ?>
                <div class="row">

                    


						
					   </div><!--end div .sidebar-->

                    
                    </div><!--End column-->

                    <div class="col-sm-7 home-info">
                      <h2>Welcome!</h2>

<!--
            
                        <div class="slideshow-container">
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

                        <!--Admin paragraph-->
                    <br /><h5>This is your dashboard for everything you need to handle volunteers at the Wildlife Center. Search the database, review applications, add events to the calendar, and get in contact with everyone easily.</h5>


                        <h2>Today's Events</h2>
                        <div id="event-feed"></div>

                    </div>

                </div> <!--End row-->
            </div> <!--End admin view-->
        </div><!--End vellum column-->
    </div><!--End row-->
</div><!--End Container-->

    <?php include("footer.php")?>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/customscript.js"></script>
	<script src="calendar/lib/moment.min.js"></script>
    <script src="calendar/fullcalendar.js"></script>
    <script src="js/events.js"></script>
    <!--This is the animation-->
<script>
    $(document).ready(function() {
            $(".4").hide().delay(1500).fadeIn(1200);
        });

        $(document).ready(function() {
            $(".3").hide().delay(1000).fadeIn(1200);
        });

        $(document).ready(function() {
            $(".2").hide().delay(500).fadeIn(1200);
        });

        $(document).ready(function() {
            $(".1").hide().fadeIn(1200);
        });
    </script>
</body>
</html>
