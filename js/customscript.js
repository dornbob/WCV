function vtype() {
	var type = document.getElementById('volunteer_type').value;

	var animalcare = document.getElementById('animal_care');
	var outreach = document.getElementById('outreach');
	var transport = document.getElementById('transport');
	var veterinary = document.getElementById('veterinary');

	console.log(type);

	if (type == 1) {
		animalcare.style.display = "block";
		outreach.style.display = "none";
		transport.style.display = "none";
		veterinary.style.display = "none";
		$('#submit_application').css('display', 'block')
	}
	else if (type == 2) {
		animalcare.style.display = "none";
		outreach.style.display = "block";
		transport.style.display = "none";
		veterinary.style.display = "none";
		$('#submit_application').css('display', 'block')
	}
	else if (type == 3) {
		animalcare.style.display = "none";
		outreach.style.display = "none";
		transport.style.display = "block";
		veterinary.style.display = "none";
		$('#submit_application').css('display', 'block')
	}
	else if (type == 4) {
		animalcare.style.display = "none";
		outreach.style.display = "none";
		transport.style.display = "none";
		veterinary.style.display = "block";
	}
	
}

function clock() {
	var clockText = document.getElementById('in_out').innerHTML;

	if (clockText == "In") {
		clockText = "Out";
	}
	else if (clockText == "Out") {
		clockText = "In";
	}

	$('#clock_icon').toggleClass('green');
	$('#in_out').html(clockText);
}



$(document).ready(function() {
	$("#tab_stuff").load("profiletab.php");

	$("#button1").click(function() {
		$("#tab_stuff").load("profiletab.php");

		$("#button1").addClass("active");
		$("#button2").removeClass("active");
        $("#button3").removeClass("active");
        $("#button4").removeClass("active");
        $("#button5").removeClass("active");
        $("#button6").removeClass("active");
	});

    $("#button2").click(function() {
        $("#tab_stuff").load("team.php");

        $("#button1").removeClass("active");
        $("#button2").addClass("active");
        $("#button3").removeClass("active");
        $("#button4").removeClass("active");
        $("#button5").removeClass("active");
        $("#button6").removeClass("active");
    });

    $("#button3").click(function() {
        $("#tab_stuff").load("hours.php");

        $("#button1").removeClass("active");
        $("#button2").removeClass("active");
        $("#button3").addClass("active");
        $("#button4").removeClass("active");
        $("#button5").removeClass("active");
        $("#button6").removeClass("active");
    });

    $("#button4").click(function() {
        console.log('working');
        $("#tab_stuff").load("documents.php");

        $("#button1").removeClass("active");
        $("#button2").removeClass("active");
        $("#button3").removeClass("active");
        $("#button4").addClass("active");
        $("#button5").removeClass("active");
        $("#button6").removeClass("active");
    });

    /*$("#button5").click(function() {
    	console.log('working');
        $("#tab_stuff").load("availabilityTab.php");

        $("#button1").removeClass("active");
        $("#button2").removeClass("active");
        $("#button3").removeClass("active");
        $("#button4").removeClass("active");
        $("#button5").addClass("active");
        $("#button6").removeClass("active");
    });*/
    $("#button6").click(function() {
        console.log('working');
        $("#tab_stuff").load("changePassword.php");

        $("#button1").removeClass("active");
        $("#button2").removeClass("active");
        $("#button3").removeClass("active");
        $("#button4").removeClass("active");
        $("#button5").removeClass("active");
        $("#button6").addClass("active");
    });
});