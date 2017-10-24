<nav class="navbar navbar-inverse">
    <div class="container-fluid">
<!--        <img src="images/wcv-white.png" alt="Wildlife Center Logo" class="logo">-->
		<h1 class="header-text">Wildlife Center of Virginia</h1>
        <!--<ul class="nav navbar-nav">-->
            <?php
			if ($_SESSION["permission"] >= 2) {
                echo '<a href="adminhome.php"><img src="images/wcv-white.png" alt="Wildlife Center Logo" class="logo"></a>';
               // echo '<li><a href="application-review.php">Application Review</a></li>';
            }else{
                echo '<a href="profile.php"><img src="images/wcv-white.png" alt="Wildlife Center Logo" class="logo"></a>';
            }
            ?>
		
        <a href="logout.php">
            <button type="button" class="btn btn-link logout">Log Out</button>
        </a>
    </div>
</nav>

<div class="row new-nav">
<?php 
if ($_SESSION["permission"] >= 2) { //all team lead/staff stuff
	echo '
	<!--Search-->
		<div class="thumbnail">
			<a href="search.php">
				<img src="images/wcv-pic-1.jpg" class="img-responsive active-image" value=>
				<span class="glyphicon glyphicon-search homeicon" aria-hidden="true"></span>
				<div class="caption">
					<p class="ghost">Search</p>
				</div>
			</a>
		</div>
		
		<!--Application review-->
	<div class="thumbnail">
			<a href="application-review.php">
				<img src="images/wcv-pic-2.jpg" class="img-responsive">
				<span class="glyphicon glyphicon-file homeicon" aria-hidden="true"></span>
			<div class="caption">
					<p class="ghost">Applications</p>
				</div>
			</a>
		</div>
		
		<!--Calendar-->
		<div class="thumbnail">
			<a href="calendar.php">
				<img src="images/wcv-pic-4.jpg" class="img-responsive">
				<span class="glyphicon glyphicon-calendar homeicon" aria-hidden="true"></span>
			<div class="caption">
					<p class="ghost">Calendar</p>
				</div>
			</a>
		</div>
		
		<!--View animals-->
		<div class="thumbnail">
			<a href="view-animals.php">
				<img src="images/wcv-pic-5.jpg" class="img-responsive">
				<i class="fa fa-paw"></i>
				<div class="caption">
					<p class="ghost">Animals</p>
				</div>
			</a>
		</div>
		';
		
} else { // all applicant and volunteer
	echo '
	
	<!--Profile-->	
		<div class="thumbnail">
			<a href="profile.php">
				<img src="images/wcv-pic-1.jpg" class="img-responsive" value=>
				<span class="glyphicon glyphicon-user homeicon" aria-hidden="true"></span>
				<div class="caption">
					<p class="ghost">Profile</p>
				</div>
			</a>
		</div>
		
		<!--Apply Specific-->
		<div class="thumbnail">
			<a href="apply-specific.php">
				<img src="images/wcv-pic-2.jpg" class="img-responsive">
				<span class="glyphicon glyphicon-check homeicon" aria-hidden="true"></span>
				<div class="caption">
					<p class="ghost">Apply</p>
				</div>
			</a>
		</div>
	';
	
}

if ($_SESSION["permission"] == 1) { //staff specific
echo '		<!--Calendar-->
		<div class="thumbnail">
			<a href="calendar.php">
				<img src="images/wcv-pic-4.jpg" class="img-responsive">
				<span class="glyphicon glyphicon-calendar homeicon" aria-hidden="true"></span>
				<div class="caption">
					<p class="ghost">Calendar</p>
				</div>
			</a>
		</div>

	<!--Clock In-->		
		<div class="thumbnail">
			<a href="clocktime.php">
				<img src="images/wcv-pic-3.jpg" class="img-responsive">
				<span class="glyphicon glyphicon-time homeicon" aria-hidden="true"></span>
				<div class="caption">
					<p class="ghost">Clock Time</p>
				</div>
			</a>
		</div>
		
	<!--View Animals-->
		<div class="thumbnail">
			<a href="view-animals.php">
				<img src="images/wcv-pic-5.jpg" class="img-responsive">
				<i class="fa fa-paw"></i>
				<div class="caption">
					<p class="ghost">Animals</p>
				</div>
			</a>
		</div>
	';

    /*echo '

<!--Profile-->	
		<div class="thumbnail">
			<a href="profile.php">
				<img src="images/wcv-pic-1.jpg" class="img-responsive" value=>
				<span class="glyphicon glyphicon-user homeicon" aria-hidden="true"></span>
				<div class="caption">
					<p>Profile</p>
				</div>
			</a>
		</div>

<!--Apply Specific-->
		<div class="thumbnail">
			<a href="apply-specific.php">
				<img src="images/wcv-pic-2.jpg" class="img-responsive">
				<span class="glyphicon glyphicon-check homeicon" aria-hidden="true"></span>
				<div class="caption">
					<p>Apply</p>
				</div>
			</a>
		</div>

';*/
	
}

?>
</div>
