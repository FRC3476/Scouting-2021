<html>
<?php
include("navBar.php");
?>
<script src="Orange-Rind/js/orangePersist.js"></script>
<script src="secondaryMatchInputDynamic.js"></script>
<script>
	function postwith(to) {
		if (document.getElementById('penalties').value == "") {
			document.getElementById('penalties').value = 0;
		}

		if (document.getElementById('matchNum').value == "" || document.getElementById('teamNum').value == "") {
			return;
		}

		var nums = {
			'userName': document.getElementById('userName').value,
			'matchNum': document.getElementById('matchNum').value,
			'teamNum': document.getElementById('teamNum').value,
			'allianceColor': document.getElementById('allianceColor').value,
			'autoPath': JSON.stringify(coordinateList),
			'crossLineA': document.getElementById('crossLineA').checked ? 1 : 0,
            'teleopPath' : JSON.stringify(coordinateList2),

			'climb': climb,
			'climbTwo': climbTwo,
			'climbThree': climbThree,
			'climbCenter': climbCenter,
			'climbSide': climbSide,

			'issues': document.getElementById('issues').value,
			'defenseBot': document.getElementById('defenseBot').checked ? 1 : 0,
			'defenseComments': document.getElementById('defenseComments').value,
			'matchComments': document.getElementById('matchComments').value,
			'penalties': document.getElementById('penalties').value,
			'cycleNumber': cycleNumber
		};

		var id = document.getElementById('matchNum').value + "-" + document.getElementById('teamNum').value;
		console.log(JSON.stringify(nums));
		console.log("hello");

		$.post("secondaryDataHandler.php", nums).done(function(data) {}).done(function() {
			alert("Submission Succeeded! Form Reloading.");
			location.reload(true);
		}).fail(function() {
			alert("Submission Failed! Please alert your head or lead scout!");
		});
	}
</script>

<body>

	<div class="container row-offcanvas row-offcanvas-left">
		<div class="well column  col-lg-12  col-sm-12 col-xs-12" id="content">
			<div class="row" style="text-align: center;">
				<div class="col-md-2">
					User:
					<input type="text" name="userName" onKeyUp="saveUserName()" id="userName" size="8" class="form-control">
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
				<div class="row">
					<div class="col-md-4">
						<div class="togglebutton" id="reach">
							<h4><b>Left Auto Line:</b></h4>
							<label>
								<input id="crossLineA" type="checkbox">
							</label>
						</div>
						<a href="javascript:void(0)" class="btn btn-raised btn-boulder btn-material-teal-600" onclick="clearPath()"><b>CLEAR PATH</b></a>
						<div class="row">
							<canvas id="myCanvas" width=600px height=460px style="border:0px solid #d3d3d3;">
								<script src="Drawing.js"></script>
							</canvas>
						</div>
                        
					</div>
				</div>
			</div>

			<!--Tepeop scouting section-->
			<div id="teleopscouting">
				<a>
					<h2><b><u>Teleop Scouting:</u></b></h2>
				</a>
				<div>
						<div class="row">
							<canvas id="myCanvas2" width=600px height=300px style="border:0px solid #d3d3d3;">
								<script src="Drawing2.js"></script>
							</canvas>
						</div>
				</div>
                <a href="javascript:void(0)" class="btn btn-raised btn-boulder btn-material-teal-600" onclick="okButton(); clearPath3()"><b>Save Cycle</b></a>


				<script>
					

					function okButton() {
						addCoordinate2();
						cycleNumber += 1;

					}

					function climbLoc(climbLocation) {
						if (climbLocation == 1) {
							climbSide = 1;
							climbCenter = 0;
						} else {
							if (climbLocation == 2) {
								climbCenter = 1;
								climbSide = 0;
							}
						}

					}

					function climbTyp(climbType) {
						if (climbType == 1) {
							climb = 1;
							climbTwo = 0;
							climbThree = 0;
						} else {
							if (climbType == 2) {
								climbTwo = 1;
								climbThree = 0;
								climb = 0;
							} else {
								if (climbType == 3) {
									climbThree = 1;
									climb = 0;
									climbTwo = 0;

								}
							}
						}
					}
				</script>

				<script>
					var increment = 1;
					var climb = 0;
					var climbTwo = 0;
					var climbThree = 0;
					var climbSide = 0;
					var climbCenter = 0;
					var cycleNumber = 0;

				</script>

				<!--Defense-->
				<a>
					<h3><b><u>Defense:</u></b></h3>
				</a>
				<div class="togglebutton" id="reach">
					<h4><b>Defense?</b></h4>
					<label>
						<input id="defenseBot" type="checkbox">
					</label>
				</div>

				<h4><b><u>Defense Comments: </u></b></h4>
				<textarea placeholder="Please write strategy of the robot or interesting observations of the robot" type="text" id="defenseComments" class="form-control md-textarea" rows="6"></textarea>
				<br>

				<!--Climb-->
				<a>
					<h3><b><u>Climb:</u></b></h3>
				</a>
				<input type="radio" onClick="climbTyp(0)" name="ClimbTyp" value="None"> None&nbsp&nbsp</button>
				<input type="radio" onClick="climbTyp(1)" name="ClimbTyp" value="Single"> Single&nbsp&nbsp</button>
				<input type="radio" onClick="climbTyp(2)" name="ClimbTyp" value="Double"> Double&nbsp&nbsp</button>
				<input type="radio" onClick="climbTyp(3)" name="ClimbTyp" value="Triple"> Triple&nbsp&nbsp</button>


				<a>
					<h3><b><u>Where did they climb:</u></b></h3>
				</a>
				<input type="radio" onClick="climbLoc(0)" name="Climb" value="None"> None&nbsp&nbsp</button>
				<input type="radio" onClick="climbLoc(1)" name="Climb" value="Side"> Side&nbsp&nbsp</button>
				<input type="radio" onClick="climbLoc(2)" name="Climb" value="Center"> Center&nbsp&nbsp</button>

				<h4><b><u>Penalties: </u></b></h4>
				<textarea placeholder="Number of Penalties" type="text" id="penalties" class="form-control md-textarea" rows="6">0</textarea>

				<a>
					<h3><b><u>Robot Issues:</u></b></h3>
				</a>
				<select id="issues" multiple="" class="form-control">
					<option value="N/A">None</option>
					<option value="dead">Dead</option>
					<option value="stopped working">Stopped Working</option>
					<option value="fell over">Fell Over</option>
				</select>


				<h4><b><u>Comments / Strategy: </u></b></h4>
				<textarea placeholder="Please write strategy of the robot or interesting observations of the robot" type="text" id="matchComments" class="form-control md-textarea" rows="6"></textarea>
				<br>

				<br> <br>
				<div style="padding: 5px; padding-bottom: 10;">
					<input type="button" value="Submit Data" id="submitButton" class="btn btn-primary" onclick="postwith(''); okButton()" />


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