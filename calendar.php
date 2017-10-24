<!DOCTYPE html>
<html lang="en">
  <head>
	<?php include('htmlHead.php')?>
    
    <title>Calendar | Wildlife Center Volunteers</title>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

      <link rel='stylesheet' href='calendar/fullcalendar.css' />
      <script src='calendar/lib/jquery.min.js'></script>
      <script src='calendar/lib/moment.min.js'></script>
      <script src='calendar/fullcalendar.js'></script>


  </head>
<body>
<?php
include("loginheader.php");
include("navHeader.php");
include('SQLConnection.php');

//Gets the contents of the events table

    $newSQL = new SQLConnection();
	$conn = $newSQL->makeConn();
    $sql = "select * from wcv.events";
    $result = $conn->query($sql);

    $json_array = array();
    $return_array = array();



//Assigns results to array
    while ($row = mysqli_fetch_assoc($result)) {


        $id = $row['eventID'];
       // echo $id;
        $sql = "SELECT firstname as 'firstname', lastname as 'lastname' FROM wcv.events e inner join wcv.personevent pe on e.eventID = pe.eventID inner join wcv.person q on pe.personID = q.personid where e.eventID = $id";
        $stuff = $conn->query($sql);
        $name = "";


        $count = 0;
        while($moreStuff = mysqli_fetch_assoc($stuff)) {
           // $name = "";
            $firstName = $moreStuff['firstname'];
            $lastName = $moreStuff['lastname'];
            $name =' ' . $firstName . ' ' . $lastName ;
           // echo $name;
            $json_array['name'][$count] = $name;
          //  print_r($json_array['name']);
            $count++;
        }
        //echo $count;
        //echo "SKOOOOOOOO";
        $name = "";
       if($count == 0)
       {
           $json_array['name'] = "";
       }

        $json_array['id'] = $row['eventID'];
        $json_array['title'] = $row['title'];
        $json_array['description'] = $row['description'];
        $json_array['start'] = $row['start'];
        $json_array['end'] = $row['end'];
        $json_array['repeatableID'] = $row['repeatableID'];
        $json_array['editable'] = $row['editable'];
        $json_array['repeatweeklyuntil'] = $row['repeatweeklyuntil'];
        $json_array['department'] = $row['department'];
        $json_array['type'] = $row['type'];

        $json_array['slots'] = $row['slots'];
        $json_array['className'] = $row['className'];
        $json_array['creatorID'] = $row['creatorID'];





       // print_r($json_array['name']);

        array_push($return_array, $json_array);
        unset($json_array['name']);
    }
//encodes and sends the db contents to the JSON file
    $jsonEncode = json_encode($return_array);
    file_put_contents('events.json',$jsonEncode, null);



?>
<div class="container">
  <div class="row">
    <div class="col-sm-1">
    <!--Spacer-->
    </div> 
    <div class="col-xs-12 col-sm-10 vellum">

        <h1>Calendar</h1>
        <span>View only events for:</span>
          <button id="outreach-toggle" class="btn toggle green off">Outreach</button>
          <button id="animalcare-toggle" class="btn toggle blue off">Animal Care</button>
          <button id="vetteam-toggle" class="btn toggle orange off">Vet Team</button>
          <button id="transport-toggle" class="btn toggle red off">Transport</button>
          <button id="frontdesk-toggle" class="btn toggle yellow off">Front Desk</button>
          <button id="other-toggle" class="btn toggle other off">Other</button>
            <button id="all-toggle" class="btn toggle black on">All</button>

            <button id="newEvent" class="btn btn-lg blue">+</button>

		
          <div id="events-calendar"></div>
		  
		  <!--Where the event details modal will go-->
          <div id="eventdetails"></div>
		  
		  <!--Where the new event modal will go-->
		  <div id="newEventDiv">

              <div class="modal fade" id="newEventModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                      <div id="form" class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title" id="myModalLabel">Create Event</h4>
                          </div>
                          <div class="modal-body">
                              Title:<br>
                              <input type="text" id="newEventTitle" required><br>
                              Description:<br>
                              <input type="text" id="newEventDescrip" required><br>
                              Type of Event:<br>
                              <select id="newEventType">
                                  <option value="shift">Shift</option>
                                  <option value="Training">Training</option>
                                  <option value="other">Other</option>
                              </select><br>
                              How many people do you need for this shift?<br>
                              <input type="text" id="newEventSlots" required><br>
                              What department is this?<br>
                              <select id="newEventDept">
                                  <option value="animalcare">Animal Care</option>
                                  <option value="vetteam">Vet Team</option>
                                  <option value="transport">Transporter</option>
                                  <option value="outreach">Outreach</option>
                                  <option value="frontdesk">Front Desk</option>
                                  <option value="other">Other</option>
                              </select><br>
                              Would you like others to edit this event?<br>
                              <input type="checkbox" id="newEditEvent">Yes
                              <br>
                              Will you be attending this event?<br>
                              <input type="checkbox" id="newEventAttend">Yes
                              <br>

                              Start Time:<br>
                              <input type="datetime-local" id="newEventStart" required><br>
                              End Time:<br>
                              <input type="datetime-local" id="newEventEnd" required><br>
                              Is this a repeating event?<br>
                              <input type="checkbox" id="newEventRepeat" onchange="displayRepeat()" value="1">Yes<br>
                              <div id="newEventRepeatStuff" style="display: none">
                                  Repeat...<br>
                                  <input type="radio" name="radio" value="0">Monthly until...<br>
                                  <input type="radio" name="radio" value="1">Weekly until...<br>
                                  <div id="newEventUntilDate" >
                                  <input type="date" id="newEventUntil"><br>
                                  </div>
                              </div>
                              <script>
                                  //Displays repeat options
                                  function displayRepeat() {
                                      var x = document.getElementById('newEventRepeatStuff');
                                      if (x.style.display === 'none') {
                                          x.style.display = 'block';
                                      } else {
                                          x.style.display = 'none';
                                      }
                                  }

                                  //Displays until option
                                  /*function displayUntil() {
                                      var x = document.getElementById('newEventUntilDate');
                                      if (x.style.display === 'none') {
                                          x.style.display = 'block';
                                      } else {
                                          x.style.display = 'none';
                                      }
                                  }*/

                                  //Displays hides until option
                                 /* function hideUntil() {
                                      var x = document.getElementById('newEventUntilDate');
                                      if (x.style.display === 'block') {
                                          x.style.display = 'none';
                                      } else {
                                          x.style.display = 'none';
                                      }
                                  }
                                  */
                                  </script>
                          </div>
                          <div class="modal-footer">
                              <button type="submit" class="btn btn-primary" name="create" id="create"
                              data-toggle="modal" onclick="sendEvent()" >Create</button>
                              <script>
                                  function sendEvent(){
                                      var untilWM = $('input[name="radio"]:checked').val();
                                      var title = $('#newEventTitle').val();
                                      var description = $('#newEventDescrip').val();
                                      var type = $('#newEventType').val();
                                      var slots = $('#newEventSlots').val();
                                      var department = $('#newEventDept').val();
                                      var start = $('#newEventStart').val();
                                      var end = $('#newEventEnd').val();
                                      //var attend = $('#newEventAttend').val();
                                      //console.log(untilWM);
                                      //var editable = $('#newEditEvent').val();
                                      //var repeatable = $('#newEventRepeat').val();
                                      var repeatweeklyuntil = $('#newEventUntil').val();


                                          if ($('#newEditEvent').is(":checked")) {
                                              editable = 1;
                                          }
                                          else {
                                              editable =  0;

                                          }

                                      if ($('#newEventAttend').is(":checked")) {
                                          attend = 1;
                                      }
                                      else {
                                          attend =  0;

                                      }
                                      console.log(attend);

                                          if ($('#newEventRepeat').is(":checked")) {
                                              repeatable = 1;
                                          }
                                          else {
                                              repeatable =  0;
                                          }

                                      $.ajax({
                                          type: "POST",
                                          url: "eventCreate.php?p=add",
                                          data: "title="+title+"&description="+description+"&type="+type+
                                          "&slots="+slots+"&department="+department+"&start="+start+
                                          "&end="+end+"&editable="+editable+"&repeatable="+repeatable+
                                          "&repeatweeklyuntil="+repeatweeklyuntil+"&radio="+untilWM+"&attend="+attend
                                          ,
                                          success: function(e){
                                              $('#newEventModal').modal('hide');
                                              window.location.reload();
                                          }
                                      });
                                  }
                              </script>
                          </div>
                      </div>
                  </div>
              </div>

          </div>

    </div><!--End vellum box-->
  </div><!--End row-->

<footer>
	<p>© 2017 The Wildlife Center of Virginia. All Rights Reserved.</p>
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