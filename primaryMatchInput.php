<html>
<?php
include("navBar.php");
?>
<script src="Orange-Rind/js/orangePersist.js"></script>
<script src="primaryMatchInputDynamic.js"></script>
<script>
	function postwith(to) {

		if (document.getElementById('matchNum').value == "" || document.getElementById('teamNum').value == "") {
			return;
		}

		var nums = {
			'userName': document.getElementById('userName').value,
			'matchNum': document.getElementById('matchNum').value,
			'teamNum': document.getElementById('teamNum').value,
			'allianceColor': document.getElementById('allianceColor').value,

			'upperGoal': upperGoal,
			'upperGoalMiss': upperGoalMiss,
			'lowerGoal': lowerGoal,

			'upperGoalT': upperGoalT,
			'upperGoalMissT': upperGoalMissT,
			'lowerGoalT': lowerGoalT,

			'controlPanelPosT': document.getElementById('controlPanelPosT').checked ? 1 : 0,
			'controlPanelNumT': document.getElementById('controlPanelNumT').checked ? 1 : 0,

			'matchComments': document.getElementById('matchComments').value,
			'cycleNumber': cycleNumber
		};

		var id = document.getElementById('matchNum').value + "-" + document.getElementById('teamNum').value;
		console.log(JSON.stringify(nums));

		$.post("primaryDataHandler.php", nums).done(function(data) {}).done(function() {
			alert("Submission Succeeded! Form Reloading.");
			location.reload(true);
		}).fail(function() {
			alert("Submission Failed! Please alert your  or lead scout!");
		});
	}
</script>

<body>

	<div class="container row-offcanvas row-offcanvas-left">
		<div class="well column  col-lg-12  col-sm-12 col-xs-12" id="content">
			<div class="row" style="text-align: center;">
			<div class="col-md-2">
					User:
					<input type="text" name="userName" onKeyUp="saveUserName1()" id="userName" size="8" class="form-control">
				</div>
				<div class="col-md-2">
					Match Number:
					<input type="text" name="matchNum" id="matchNum" size="8" class="form-control">
				</div>
				<div class="col-md-2">
					Team Number:
					<input type="text" name="teamNum" id="teamNum" size="8" class="form-control">
				</div>
				<div class="col-md-3">
					Alliance Color:
					<select id="allianceColor" class="form-control">
						<option value='blue'>Blue</option>
						<option value='red'>Red</option>
					</select>
				</div>
				<div class="col-md-3">
					<button id="Switch" onclick="autotele();" class="btn btn-primary">Teleop</button>
				</div>
			</div>

			<!--Auto Scouting-->
			<div id="autoscouting">
				<a>
					<h2><b><u>Auto Scouting:</u></b></h2>
				</a>
				<div>
					<div class="row">
						<a>
							<h3><b><u> Upper Goal:</u></b></h3>
						</a>
						<button type="button" onClick="updateupperGoal()" class="enlargedtext stylishUpper" id="bigFont"><a id="upperGoal" class="enlargedtext">0</a> Upper Goal </button>
						<button type="button" onClick="updateupperGoalMiss()" class="enlargedtext stylishUpper" id="bigFont"> Upper Goal Miss <a id="upperGoalMiss" class="enlargedtext">0</a></button>
						<button type="button" onClick="upperGoalClear()" class="enlargedtext stylishUpperMiss" id="bigFont"> Clear <a class="enlargedtext"></a></button>
						<br>
						<br>
						<br>

						<a>
							<h3><b><u>Lower Goal:</u></b></h3>
						</a>
						<button type="button" onClick="updatelowerGoal()" class="enlargedtext stylishLower" id="bigFont"><a id="lowerGoal" class="enlargedtext">0</a> Lower Goal </button>
						<button type="button" onClick="lowerGoalClear()" class="enlargedtext stylishUpperMiss" id="bigFont"> Clear <a class="enlargedtext"></a></button>
						<br>
						<br>
					</div>
				</div>
			</div>

			<!--Tepeop scouting section-->
			<div id="teleopscouting">
				<a>
					<h2><b><u>Teleop Scouting:</u></b></h2>
				</a>
				<div>
				</div>

				<script>

					function updatelowerGoal() {
						lowerGoal += increment;

						document.getElementById("lowerGoal").innerHTML = lowerGoal;

					}

					function updateupperGoalMiss() {

						upperGoalMiss += increment;

						document.getElementById("upperGoalMiss").innerHTML = upperGoalMiss;

					}

					function updateupperGoal() {
						upperGoal += increment;

						document.getElementById("upperGoal").innerHTML = upperGoal;

					}

					function upperGoalClear() {
						upperGoal = 0;
						upperGoalMiss = 0;

						document.getElementById("upperGoal").innerHTML = upperGoalT;
						document.getElementById("upperGoalMiss").innerHTML = upperGoalT;

					}

					function lowerGoalClear() {
						lowerGoal = 0;

						document.getElementById("lowerGoal").innerHTML = upperGoalT;

					}









					upperGoalTemp = 0;
					upperGoalMissTemp = 0;
					lowerGoalTemp = 0;
					climb = 0;
					climbTwo = 0;
					climbThree = 0;
					climbCenter = 0;
					climbSide = 0;
					lowerGoalMissTemp = 0;
					lowerMissTemp = 0;


					function updateupperGoalT() {
						upperGoalTemp += increment;

						document.getElementById("upperGoalTemp").innerHTML = upperGoalTemp;

					}

					function updateupperGoalMissT() {
						upperGoalMissTemp += increment;
						document.getElementById("upperGoalMissTemp").innerHTML = upperGoalMissTemp;

					}

					function updatelowerGoalT() {
						lowerGoalTemp += increment;
						document.getElementById("lowerGoalTemp").innerHTML = lowerGoalTemp;

					}
					
					function updatelowerGoalMissT() {
						lowerGoalMissTemp += increment;
						document.getElementById("lowerGoalMissTemp").innerHTML = lowerGoalMissTemp;

					}

					function upperGoalClearT() {
						upperGoalTemp = 0;
						upperGoalMissTemp = 0;

						document.getElementById("upperGoalTemp").innerHTML = upperGoalTemp;
						document.getElementById("upperGoalMissTemp").innerHTML = upperGoalMissTemp;

					}

					function lowerGoalClearT() {
						lowerGoalTemp = 0;
						lowerGoalMissTemp = 0;
						

						document.getElementById("lowerGoalTemp").innerHTML = lowerGoalTemp;
						document.getElementById("lowerGoalMissTemp").innerHTML = lowerGoalMissTemp;


					}

					function check(){
						cycleNumber = cycleNumber.substring(0, cycleNumber.length -2);
						cycleNumber += ("]");
					}

					function okButton() {
						lowerGoalT += lowerGoalTemp;
						upperGoalT += upperGoalTemp;
						upperGoalMissT += upperGoalMissTemp;

						if ((lowerGoalTemp + upperGoalTemp + upperGoalMissTemp + lowerGoalMissTemp) == 0) {
							cycleCount = cycleCount;
						} else {
							cycleCount++;
							cycleNumber += ("["+cycleCount + ", " + upperGoalTemp + ", " + upperGoalMissTemp + ", " + lowerGoalTemp + "], ");
							lowerMissTemp = lowerGoalMissTemp;
						}

						lowerGoalTemp = 0;
						upperGoalTemp = 0;
						upperGoalMissTemp = 0;
						lowerGoalMissTemp = 0;

						document.getElementById("lowerGoalTemp").innerHTML = lowerGoalTemp;
						document.getElementById("upperGoalTemp").innerHTML = upperGoalTemp;
						document.getElementById("upperGoalMissTemp").innerHTML = upperGoalMissTemp;
						document.getElementById("lowerGoalMissTemp").innerHTML = lowerGoalMissTemp;
						console.log(cycleCount);
						console.log(cycleNumber);

					}

					function undoSave() {
						
						if (cycleCount == 0){
							console.log("continue");
						}else{
							console.log((cycleNumber.substring(cycleNumber.length -4, cycleNumber.length -3)));
							cycleCount -= 1;
							lowerGoalTemp = parseInt(cycleNumber.substring(cycleNumber.length -4, cycleNumber.length -3));
							upperGoalTemp = parseInt(cycleNumber.substring(cycleNumber.length -10, cycleNumber.length -9));
							upperGoalMissTemp = parseInt(cycleNumber.substring(cycleNumber.length -7, cycleNumber.length -6));
							lowerGoalMissTemp = lowerMissTemp;

							lowerGoalT -= lowerGoalTemp;
							upperGoalT -= upperGoalTemp;
							upperGoalMissT -= upperGoalMissTemp;
							
							
						}
						
						cycleNumber = cycleNumber.substring(0, cycleNumber.length -14);

						document.getElementById("lowerGoalTemp").innerHTML = lowerGoalTemp;
						document.getElementById("upperGoalTemp").innerHTML = upperGoalTemp;
						document.getElementById("upperGoalMissTemp").innerHTML = upperGoalMissTemp;	
						document.getElementById("lowerGoalMissTemp").innerHTML = lowerGoalMissTemp;					

					}

				</script>

				<script>
					var increment = 1;
					var upperGoal = 0;
					var upperGoalMiss = 0;
					var lowerGoal = 0;

					var upperGoalT = 0;
					var upperGoalMissT = 0;
					var lowerGoalT = 0;
					var cycleCount = 0;
					var cycleNumber = document.getElementById("[");;
					cycleNumber = "[";
				</script>

				<a>
					<h3><b><u>Upper Goal:</u></b></h3>
				</a>
				<button type="button" onClick="updateupperGoalT()" class="enlargedtext stylishUpper" id="bigFont"><a id="upperGoalTemp" class="enlargedtext">0</a> Upper Goal </button>
				<button type="button" onClick="updateupperGoalMissT()" class="enlargedtext stylishUpper" id="bigFont"> Upper Goal Miss <a id="upperGoalMissTemp" class="enlargedtext">0</a></button>
				<button type="button" onClick="upperGoalClearT()" class="enlargedtext stylishUpperMiss" id="bigFont"> Clear <a class="enlargedtext"></a></button>
				<br>
				<br>
				<br>

				<a>
					<h3><b><u>Lower Goal:</u></b></h3>
				</a>
				<button type="button" onClick="updatelowerGoalT()" class="enlargedtext stylishLower" id="bigFont"><a id="lowerGoalTemp" class="enlargedtext">0</a> Lower Goal </button>
				<button type="button" onClick="updatelowerGoalMissT()" class="enlargedtext stylishLower" id="bigFont"><a id="lowerGoalMissTemp" class="enlargedtext">0</a> Lower Goal Miss</button>
				<button type="button" onClick="lowerGoalClearT()" class="enlargedtext stylishUpperMiss" id="bigFont"> Clear <a class="enlargedtext"></a></button>
				<br>
				<br>
				<br>

				<button type="button" onClick="okButton()" class="btn btn-primary" id="bigFont"> Save Cycle <a class="enlargedtext"></a></button>
				<button type="button" onClick="undoSave()" class="btn btn-primary" id="bigFont"> Edit Last Save <a class="enlargedtext"></a></button>


				<div class="togglebutton" id="reach">
					<h4><b>Control Panel Rotation Control</b></h4>
					<label>
						<input id="controlPanelNumT" type="checkbox">
					</label>
				</div>

				<div class="togglebutton" id="reach">
					<h4><b>Control Panel Position Control</b></h4>
					<label>
						<input id="controlPanelPosT" type="checkbox">
					</label>
				</div>

				<h4><b><u>Comments / Strategy: </u></b></h4>
				<textarea placeholder="Please write strategy of the robot or interesting observations of the robot" type="text" id="matchComments" class="form-control md-textarea" rows="6"></textarea>
				<br>

				<br> <br>
				<div style="padding: 5px; padding-bottom: 10;">
					<input type="button" value="Submit Data" id="submitButton" class="btn btn-primary" onclick="okButton(''); check(); postwith('')" />


				</div>
			</div>
		</div>
	</div>
	</div>
	</div>
	</div>

	<style>
		.stylishLower {
			background-color: rgb(58, 133, 129);
			color: white;
			border-radius: 2px;
			font-family: Helvetica;
			font-weight: bold;
			/*To get rid of weird 3D affect in some browsers*/
			border: solid rgb(58, 133, 129);
		}

		.stylishLower:hover {
			background-color: Orange;
			border-color: Orange;
		}

		.stylishUpperMiss {
			background-color: rgb(255, 0, 0);
			color: white;
			border-radius: 2px;
			font-family: Helvetica;
			font-weight: bold;
			/*To get rid of weird 3D affect in some browsers*/
			border: solid rgb(255, 0, 0);
		}

		.stylishLowerMiss:hover {
			background-color: Orange;
			border-color: Orange;
		}


		.stylishUpper {
			background-color: rgb(255, 120, 50);
			color: white;
			border-radius: 2px;
			font-family: Helvetica;
			font-weight: bold;
			/*To get rid of weird 3D affect in some browsers*/
			border: solid rgb(255, 120, 50);
		}

		.stylishUpper:hover {
			background-color: Orange;
			border-color: Orange;
		}

		#bigFont {
			font-size: 20px
		}

		#mediumFont {
			font-size: 15px
		}

		#smallFont {
			font-size: 10px
		}

		.feedback:hover {
			background-color: Orange;
		}
	</style>
</body>

</html>
<?php include("footer.php"); ?>