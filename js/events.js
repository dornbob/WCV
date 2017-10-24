$(document).ready(function() {
    $('#events-calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listWeek'
        },
        defaultDate: '2017-04-09',
        editable: true,
        navLinks: true, // can click day/week names to navigate views
        eventLimit: true, // allow "more" link when too many events
        events: {
            url: 'calendar/php/get-events.php'
        },

        eventClick: function(event) {
            //Creates a Bootstrap modal window with the event details
            $('#eventdetails').html('<div class="modal fade" id="eventModal" tabindex="-1" role="dialog"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title">' + event.title +'</h4></div><div class="modal-body" id="modal-body"><p>' + event.department + ' ' + event.type + '</p><p>' + event.description + '</p><p>Open Spots: ' + event.slots + "<br>Signed-Up: " + event.name +'</div><div class="modal-footer"></button><button type="button" class="btn btn-danger" id="cancel" onclick="cancel(\''+ event.id +'\',\''+ event.slots +'\')">Cancel Sign-Up</button> <button type="button" class="btn btn-danger" id="deleteStuff" onclick="deleteEventModal(\''+ event.id + '\')">Delete Event</button><button type="button" class="btn btn-primary" onclick="signup(\''+ event.id +'\',\''+ event.slots +'\')">Sign-Up</button><button type="button" class="btn btn-primary" data-dismiss="modal">Done</button></div></div></div></div>');

            //Open the modal
            $('#eventModal').modal({
                show:true
            });
        }
    });

    //Event listeners for checkboxes that hide and show certain classes of events
    $('#outreach-toggle').click(function() {
        if ($(this).hasClass('off')) {
            //make all toggle buttons off
            $('.toggle').each(function() {
                $(this).removeClass('on');
                $(this).addClass('off');
            });

            //make this particular button on
            $(this).removeClass('off');
            $(this).addClass('on');

            //hide all events
            $('.event').each(function() {
                $(this).addClass('hideme');
            });

            //show only the stuff specified
            $('.outreach-event').each(function() {
                $(this).removeClass('hideme');
            });
        }
        //nothing happens if you click it and it doesn't have a class of "off"


    });

    $('#animalcare-toggle').click(function() {
        //make all toggle buttons off
        $('.toggle').each(function() {
            $(this).removeClass('on');
            $(this).addClass('off');
        });

        //make this particular button on
        $(this).removeClass('off');
        $(this).addClass('on');

        //hide all events
        $('.event').each(function() {
            $(this).addClass('hideme');
        });

        //show only the stuff specified
        $('.animalcare-event').each(function() {
            $(this).removeClass('hideme');
        });
    });

    $('#vetteam-toggle').click(function() {
        //make all toggle buttons off
        $('.toggle').each(function() {
            $(this).removeClass('on');
            $(this).addClass('off');
        });

        //make this particular button on
        $(this).removeClass('off');
        $(this).addClass('on');

        //hide all events
        $('.event').each(function() {
            $(this).addClass('hideme');
        });

        //show only the stuff specified
        $('.vetteam-event').each(function() {
            $(this).removeClass('hideme');
        });
    });

    $('#transport-toggle').click(function() {
        //make all toggle buttons off
        $('.toggle').each(function() {
            $(this).removeClass('on');
            $(this).addClass('off');
        });

        //make this particular button on
        $(this).removeClass('off');
        $(this).addClass('on');

        //hide all events
        $('.event').each(function() {
            $(this).addClass('hideme');
        });

        //show only the stuff specified
        $('.transport-event').each(function() {
            $(this).removeClass('hideme');
        });
    });

    $('#frontdesk-toggle').click(function() {
        //make all toggle buttons off
        $('.toggle').each(function() {
            $(this).removeClass('on');
            $(this).addClass('off');
        });

        //make this particular button on
        $(this).removeClass('off');
        $(this).addClass('on');

        //hide all events
        $('.event').each(function() {
            $(this).addClass('hideme');
        });

        //show only the stuff specified
        $('.frontdesk-event').each(function() {
            $(this).removeClass('hideme');
        });
    });

    $('#other-toggle').click(function() {
        //make all toggle buttons off
        $('.toggle').each(function() {
            $(this).removeClass('on');
            $(this).addClass('off');
        });

        //make this particular button on
        $(this).removeClass('off');
        $(this).addClass('on');

        //hide all events
        $('.event').each(function() {
            $(this).addClass('hideme');
        });

        //show only the stuff specified
        $('.other-event').each(function() {
            $(this).removeClass('hideme');
        });
    });

    $('#all-toggle').click(function() {
        //make all toggle buttons off
        $('.toggle').each(function() {
            $(this).removeClass('on');
            $(this).addClass('off');
        });

        //make this particular button on
        $(this).removeClass('off');
        $(this).addClass('on');


        //show all events
        $('.event').each(function() {
            $(this).removeClass('hideme');
        });
    });
	
	//Load today's events on the homepage
	$('#event-feed').fullCalendar({
		header: {
			left:'',
            center: 'title',
			right:''
        },
        defaultDate: new Date(),
        eventLimit: true, // allow "more" link when too many events
        events: {
            url: 'calendar/php/get-events.php'
        },
		defaultView: 'basicDay',
		duration: { days: 1}
	});
});
	
	//Event listener for new event button click
	//Runs new event function
	$('#newEvent').click(function() {
		//Open the modal
		$('#newEventModal').modal({
			show: true
		});
	});

function signup(eventID, eventSlots){

    if(eventSlots > 0)
    {
        $.ajax({
            type: "POST",
            url: "eventCreate.php?p=signup",
            data: "eventID="+eventID
            ,
            success: function(e){
                $('#eventModal').modal('hide');
               // var element = document.getElementById("schedule");
                //if (element.value=="Cancel Sign-Up"){
                  //  element.value = "Sign-Up";
                //}
                //else element.value = "Cancel Sign-Up";
                //document.getElementById( "schedule" ).setAttribute( "onClick", "javascript: cancel(eventID, eventSlots) ;" );
                //document.getElementById( "schedule" ).setAttribute( "value", "Cancel" );
                location.reload();
            }
        });
    }
    else
    {
        alert("No open slots");
        $('#eventModal').modal('hide');
    }

}

function cancel(eventID, eventSlots)
{
    $.ajax({
        type: "POST",
        url: "eventCreate.php?p=cancel",
        data: "eventID="+eventID+"&slots="+eventSlots
        ,
        success: function(e){
            $('#eventModal').modal('hide');
           // var element = document.getElementById("schedule");
            //if (element.value=="Cancel Sign-Up")
            //{
              //  element.value = "Sign-Up";
            //}
            //else element.value = "Cancel Sign-Up";
            //document.getElementById( "schedule" ).setAttribute( "onClick", "javascript: signup(eventID, eventSlots);" );
            //document.getElementById( "schedule" ).setAttribute( "value", "Sign-Up" );
            location.reload();
        }
    });
}

function deleteEventModal(eventID) {
    $('#modal-body').html('<p>Would you like to delete</p><br><button name="series" id="series" class="btn">All instances of this event</button></br><br><button name="instance" id="instance" class="btn">Only this instance of the event</button></br>');
    var idClicked = 10;
    //var eventID = event.id;

    $("button").click(function(){
        idClicked = this.id;

        console.log(idClicked);
        $.ajax({
            type: "POST",
            url: "eventCreate.php?p=delete",
            data: "type="+idClicked+"&eventID="+eventID
            ,
            success: function(e){
                $('#eventModal').modal('hide');
                //alert("success");
                location.reload();
            }
        });
    });

}

