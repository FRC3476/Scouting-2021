var keyPressOk = true;
var mode = true;

$(function(){
  		$('#teleopscouting').hide();
	});

    function autotele(){
		if(mode == true){
			$('#autoscouting').hide();
			$('#teleopscouting').show();
			document.getElementById("Switch").innerHTML = "Auto";
		}
		else{
			$('#autoscouting').show();
			$('#teleopscouting').hide();
			document.getElementById("Switch").innerHTML="Teleop";
		}
		mode = !mode;
	}
	function toggleColor(){

		 var colorTog = document.getElementById("allianceColor");
		if (colorTog.innerHTML !== "Blue <b>(a)</b>") {
			colorTog.innerHTML = "Blue <b>(a)</b>";
			document.getElementById("allianceColor").value="Blue";
		}
		else {
			colorTog.innerHTML = "Red <b>(a)</b>";
			document.getElementById("allianceColor").value="Red";
		}
    }

	function saveUserName1(){
		console.log("SETTING USERNAME");
		localStorage.setItem("userName", $("#userName").val());
  	}

	  $(document).ready(function(){
		orangePersist.initializeApp();
		console.log("GETTING USERNAME");
		$("#userName").val(localStorage.getItem("userName"));
	  });

