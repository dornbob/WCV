

<!DOCTYPE html>

<?php
include("SQLConnection.php");
include("PersonClass.php");
include("EmergContactClass.php");
include("loginheader.php");
?>
<!--<form runat="server">-->
<html lang="en">
<title>Profile</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body {font-family: "Lato", sans-serif}
.mySlides {display: none}
</style>
<body>

<!-- Navbar -->
<div class="w3-top">
  <div class="w3-bar w3-black w3-card-2">
    <a class="w3-bar-item w3-button w3-padding-large w3-hide-medium w3-hide-large w3-right" href="javascript:void(0)" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
    <a href="UserProfile.php" class="w3-bar-item w3-button w3-padding-large">PROFILE</a>
      <a href="calendar.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small">CALENDAR</a>
    <a href="apply-main.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small">APPLY</a>
    <a href="clockin.html" class="w3-bar-item w3-button w3-padding-large w3-hide-small">CLOCKIN</a>
	<a href="mail.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small">CONTACT</a>
    <a href="login.php" style="float:right" class="w3-bar-item w3-button w3-padding-large w3-hide-small">LOG OUT</a>
  </div>
</div>

<!-- Navbar on small screens -->
<div id="navDemo" class="w3-bar-block w3-black w3-hide w3-hide-large w3-hide-medium w3-top" style="margin-top:46px">
  <a href="UserProfile.php" class="w3-bar-item w3-button w3-padding-large">PROFILE</a>
  <a href="calendar.php" class="w3-bar-item w3-button w3-padding-large">CALENDAR</a>
  <a href="apply-main.php" class="w3-bar-item w3-button w3-padding-large">APPLY</a>
  <a href="clockin.html" class="w3-bar-item w3-button w3-padding-large">CONTACT</a>
  <a href="mail.php" class="w3-bar-item w3-button w3-padding-large">MAIL</a>
  <a href="login.php" class="w3-bar-item w3-button w3-padding-large">LOG OUT</a>
</div>




<script>
    // Automatic Slideshow - change image every 4 seconds
    var myIndex = 0;
    carousel();

    function carousel() {
        var i;
        var x = document.getElementsByClassName("mySlides");
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        myIndex++;
        if (myIndex > x.length) { myIndex = 1 }
        x[myIndex - 1].style.display = "block";
        setTimeout(carousel, 4000);
    }

    // Used to toggle the menu on small screens when clicking on the menu button
    function myFunction() {
        var x = document.getElementById("navDemo");
        if (x.className.indexOf("w3-show") == -1) {
            x.className += " w3-show";
        } else {
            x.className = x.className.replace(" w3-show", "");
        }
    }

    // When the user clicks anywhere outside of the modal, close it
    var modal = document.getElementById('ticketModal');
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

</body>
</html>
    <br />
    <br />

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="The website for Wildlife Center volunteers">
    <meta name="keywords" content="wildlife, volunteer, virginia">
    <meta name="author" content="Shanice McCormick and Nicole Moran">
    
    <title>Home | Wildlife Center Volunteers</title>

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
<style>
html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif}
</style>

<!-- Page Container -->
<div class="w3-content w3-margin-top" style="max-width:1400px;">

  <!-- The Grid -->
  <div class="w3-row-padding">
  
    <!-- Left Column -->
    <div class="w3-third">
    
      <div class="w3-white w3-text-grey w3-card-4">
        <div class="w3-display-container">
          <img src="images/volunteer2.jpg" style="width:100%" alt="Avatar">
          <div class="w3-display-bottomleft w3-container w3-text-black"><br />
          </div>
        </div>
        <div class="w3-container">
           <!-- <h2><asp:TextBox ID="txtProfileFirstName" text="Jane" runat="server" onkeyup="resizeTextBox(this)" maxlength="30" readonly="true" BorderStyle="None" BackColor="Transparent" PlaceHolder="First Name" Width="172px"></asp:TextBox>
                <asp:TextBox ID="txtProfileMiddleInitial" text="A" runat="server" onkeyup="resizeTextBox(this)" maxlength="1" readonly="true" BorderStyle="None" BackColor="Transparent" PlaceHolder="Middle Initial" Width="24px"></asp:TextBox>
                <asp:TextBox ID="txtProfileLastName" text="Doe" runat="server" onkeyup="resizeTextBox(this)" maxlength="30" readonly="true" BorderStyle="None" BackColor="Transparent" PlaceHolder="Last Name" Width="195px"></asp:TextBox>
                <asp:Button ID="btnEditProfile" runat="server" Text="Edit Profile" OnClick="btnEditProfile_Click" Width="161px" /><asp:Button ID="btnSaveProfile" runat="server" Text="Save Profile" Visible="False" OnClick="btnSaveProfile_Click" Width="176px" /></h2>
            
          <p><i class="fa fa-briefcase fa-fw w3-margin-right w3-large w3-text-teal"></i><asp:TextBox ID="txtVolunteerType" text="Outreach" runat="server" readonly="true" BorderStyle="None" BackColor="Transparent" PlaceHolder="Volunteer Type" ></asp:TextBox></p>
          <p><i class="fa fa-home fa-fw w3-margin-right w3-large w3-text-teal"></i><asp:TextBox ID="txtProfileHouseNumber" runat="server" onkeyup="resizeTextBox(this)" readonly="true" BorderStyle="None" BackColor="Transparent" PlaceHolder="House Number" Width="49px"></asp:TextBox>
                        <asp:TextBox ID="txtProfileStreet" runat="server" onkeyup="resizeTextBox(this)" text="Main Steet" readonly="true" BorderStyle="None" BackColor="Transparent" PlaceHolder="Street" Width="126px"></asp:TextBox><br />
    					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    					<asp:TextBox ID="txtProfileCity" text="Harrisonburg" runat="server" readonly="true" BorderStyle="None" BackColor="Transparent" PlaceHolder="City" Width="92px"></asp:TextBox>, 
                        <asp:TextBox ID="txtProfileState" text="VA" maxlength="2" runat="server" onkeyup="resizeTextBox(this)" readonly="true" BorderStyle="None" BackColor="Transparent" PlaceHolder="State" Width="21px" ></asp:TextBox>
    					<asp:TextBox ID="txtProfileZipCode" text="22801" maxlength="5" type="integer" runat="server" onkeyup="resizeTextBox(this)" readonly="true" BorderStyle="None" BackColor="Transparent" PlaceHolder="Zip Code" Width="45px"></asp:TextBox><br></p>
          <p><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-teal"></i><asp:TextBox ID="txtProfileEmailAddress" text="janesemail@example.com" runat="server" readonly="true" BorderStyle="None" BackColor="Transparent" PlaceHolder="Email" href="mailto:janesemail@example.com?Subject=Hello%20again" target="_top" Width="255px" Height="16px"></asp:TextBox><br><br></p>
          <p><i class="fa fa-phone fa-fw w3-margin-right w3-large w3-text-teal"></i><asp:TextBox ID="txtProfilePhoneNumber" text="(540) 123-4567" runat="server" readonly="true" BorderStyle="None" BackColor="Transparent" ></asp:TextBox><br></p>
          <hr>

          <p class="w3-large"><b><i class="fa fa-asterisk fa-fw w3-margin-right w3-text-teal"></i>Emergency Contact</b></p>
          <p>Name</p>
          <div class="w3-light-grey w3-round-xlarge w3-small">
            <asp:TextBox ID="txtEmergencyContactFirstName" text="Jim" runat="server" onkeyup="resizeTextBox(this)" readonly="true" BorderStyle="None" BackColor="Transparent" PlaceHolder="Emergency Contact First Name" Width="44px"></asp:TextBox>
            <asp:TextBox ID="txtEmergencyContactLastName" text="Doe" runat="server" onkeyup="resizeTextBox(this)" readonly="true" BorderStyle="None" BackColor="Transparent" PlaceHolder="Emergency Contact Last Name" Width="35px"></asp:TextBox><br />
          </div>
          <p>Phone Number</p>
          <div class="w3-light-grey w3-round-xlarge w3-small">
             <asp:TextBox ID="txtEmergencyContactPhone" text="(540) 123-4567" runat="server" readonly="true" BorderStyle="None" BackColor="Transparent" PlaceHolder="Emergency Contact Phone Number"></asp:TextBox>
          </div>
          <p>Relationship</p>
          <div class="w3-light-grey w3-round-xlarge w3-small">
               <asp:TextBox ID="txtEmergencyContactRelationship" text="Husband" runat="server" readonly="true" BorderStyle="None" BackColor="Transparent" PlaceHolder="Emergency Contact Email"></asp:TextBox>
          </div>
          <br>
          <p class="w3-large w3-text-theme"><b><i class="fa fa-globe fa-fw w3-margin-right w3-text-teal"></i><asp:Button ID="btnViewResume" runat="server" href="sampleresume.pdf" target="_" Text="View Resume" OnClick="btnViewResume_Click" OnClientClick ="document.forms[0].target = '_blank';" />
                <asp:FileUpload ID="txtResumeUpload" visible="false" runat="server" Width="256px" /></b></p>-->
          <br>
        </div>
      </div><br>

    <!-- End Left Column -->
    </div>

    <!-- Right Column -->
    <div class="w3-twothird">
      <div class="w3-container w3-card-2 w3-white w3-margin-bottom">
        <!-- Navbar -->
        <div class="w3-twothird">
          <div class="w3-bar w3-black w3-card-2">
            <a class="w3-bar-item w3-button w3-padding-large w3-hide-medium w3-hide-large w3-right" href="javascript:void(0)" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
            <a href="#" class="w3-bar-item w3-button w3-padding-large">General Profile</a>
            <a href="#" class="w3-bar-item w3-button w3-padding-large w3-hide-small">Volunteer Type</a>
            <a href="#" class="w3-bar-item w3-button w3-padding-large w3-hide-small">Travel & Mileage</a>
	        <a href="#" class="w3-bar-item w3-button w3-padding-large w3-hide-small">Change Password</a>
          </div>
        </div>

        <!-- Navbar on small screens -->
        <div id="Div1" class="w3-bar-block w3-black w3-hide w3-hide-large w3-hide-medium w3-top" style="margin-top:46px">
          <a href="UserProfile.php" class="w3-bar-item w3-button w3-padding-large">General Profile</a>
          <a href="calendar.php" class="w3-bar-item w3-button w3-padding-large">Volunteer Type</a>
          <a href="apply-main.php" class="w3-bar-item w3-button w3-padding-large">Travel & Mileage</a>
          <a href="clockin.html" class="w3-bar-item w3-button w3-padding-large">Change Password</a>
        </div>

          <br />
          <br />
          <br />

        <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-suitcase fa-fw w3-margin-right w3-xxlarge w3-text-teal">

                                               </i>Work Experience<span><small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
           <!-- <asp:TextBox ID="txtSaveProfileConfirmation" runat="server" Text="&#10004; Changes Saved Successfully!" readonly="true" Visible="False" Width="282px" OnClick="btnSaveProfile_Click" BorderStyle="None" BackColor="Transparent"  />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <asp:TextBox ID="txtSaveProfileError" runat="server" Text="&#x2718; ERROR: Changes Were Not Saved, Please Correct Your Form!" readonly="true" Visible="False" Width="565px" OnClick="btnSaveProfile_Click" BorderStyle="None" BackColor="Transparent"  /></small></span></h2>-->
        <div class="w3-container">
          <h5 class="w3-opacity"><b>Front End Developer / w3schools.com</b></h5>
          <h6 class="w3-text-teal"><i class="fa fa-calendar fa-fw w3-margin-right"></i>Jan 2015 - <span class="w3-tag w3-teal w3-round">Current</span></h6>
          <p>Lorem ipsum dolor sit amet. Praesentium magnam consectetur vel in deserunt aspernatur est reprehenderit sunt hic. Nulla tempora soluta ea et odio, unde doloremque repellendus iure, iste.</p>
          <hr>
        </div>
        <div class="w3-container">
          <h5 class="w3-opacity"><b>Web Developer / something.com</b></h5>
          <h6 class="w3-text-teal"><i class="fa fa-calendar fa-fw w3-margin-right"></i>Mar 2012 - Dec 2014</h6>
          <p>Consectetur adipisicing elit. Praesentium magnam consectetur vel in deserunt aspernatur est reprehenderit sunt hic. Nulla tempora soluta ea et odio, unde doloremque repellendus iure, iste.</p>
          <hr>
        </div>
        <div class="w3-container">
          <h5 class="w3-opacity"><b>Graphic Designer / designsomething.com</b></h5>
          <h6 class="w3-text-teal"><i class="fa fa-calendar fa-fw w3-margin-right"></i>Jun 2010 - Mar 2012</h6>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        </div>
      </div>

<%--      <div class="w3-container w3-card-2 w3-white">
        <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-certificate fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Education</h2>
        <div class="w3-container">
          <h5 class="w3-opacity"><b>W3Schools.com</b></h5>
          <h6 class="w3-text-teal"><i class="fa fa-calendar fa-fw w3-margin-right"></i>Forever</h6>
          <p>Web Development! All I need to know in one place</p>
          <hr>
        </div>
        <div class="w3-container">
          <h5 class="w3-opacity"><b>London Business School</b></h5>
          <h6 class="w3-text-teal"><i class="fa fa-calendar fa-fw w3-margin-right"></i>2013 - 2015</h6>
          <p>Master Degree</p>
          <hr>
        </div>
        <div class="w3-container">
          <h5 class="w3-opacity"><b>School of Coding</b></h5>
          <h6 class="w3-text-teal"><i class="fa fa-calendar fa-fw w3-margin-right"></i>2010 - 2013</h6>
          <p>Bachelor Degree</p><br>
        </div>
      </div>--%>

    <!-- End Right Column -->
    </div>
    
  <!-- End Grid -->
  </div>
  
  <!-- End Page Container -->
        <script>
            function resizeTextBox(txt) {
                txt.style.width = "1px";
                txt.style.width = (1 + txt.scrollWidth) + "px";
            }
    </script>
</div>

     <br />
     <br />


<!-- Footer -->
<footer class="w3-container w3-padding-64 w3-center w3-opacity w3-light-grey w3-xlarge">
  <i class="fa fa-facebook-official w3-hover-opacity" onclick="window.location='https://www.facebook.com/wildlifecenter/'"></i>
  <i class="fa fa-instagram w3-hover-opacity" onclick="window.location='https://www.instagram.com/explore/locations/292750036/'"></i>
  <i class="fa fa-youtube w3-hover-opacity" onclick="window.location='https://www.youtube.com/user/WildlifeCenterVA'"></i>
  <i class="fa fa-twitter w3-hover-opacity" onclick="window.location='https://twitter.com/WCVtweets'"></i>
  <i class="fa fa-linkedin w3-hover-opacity" onclick="window.location='https://www.linkedin.com/company/wildlife-center-of-va'"></i>
  <p class="w3-medium">Visit us at <a href="http://wildlifecenter.org/" target="_blank">WildLifeCenter.org</a></p>
  <p class="w3-medium">© 2017 The Wildlife Center of Virginia. All Rights Reserved.</p>
</footer>


</form>
</body>
</html>


