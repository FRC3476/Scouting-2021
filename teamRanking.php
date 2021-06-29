<html>
<?php
include("header.php") ?>

<body>
	<?php include("navBar.php") ?>

	<div class="container row-offcanvas row-offcanvas-left">
		<div class="well column  col-lg-12  col-sm-12 col-xs-12" id="content">
			<h2>Team Ranking</h2>
			<table class="sortable table table-hover" id="RawData" border="1">
				<tr>
					<th>Team Number</th>
					<th>Weighted Score</th>
					<th>Avg Predicted Score Contribution</th>
					<th>Total Predicted Score Contribution</th>
					<th>Avg Upper Shot Percentage</th>
					<th>OPR</th>
					<th>Three Point OPR</th>
					<th>Avg Drive Rank</th>
					<th>Avg Offense Score</th>
					<th>Avg Defense Score</th>
					<th>Avg Teleop Upper Goal</th>
					<th>Avg Teleop Lower Goal</th>
					<th>Avg Teleop Upper Goal Miss</th>
					<th>Avg Auto Upper Goal</th>
					<th>Avg Auto Lower Goal</th>
					<th>Max Teleop Upper Goal</th>
					<th>Max Teleop Lower Goal</th>
					<th>Max Auto Upper Goal</th>
					<th>Max Auto Lower Goal</th>
					<th>Avg Climb</th>
					<th>Total Center Climb</th>
					<th>Total Side Climb</th>
					<th>Total Defense</th>
					
				</tr>
				<?php
				include("databaseLibrary.php");
				$teamList = getTeamList();
				foreach ($teamList as $teamNumber) {

					$i = 0;
					$picklist = (getPickList($teamNumber) - getAvgDriveRank($teamNumber));
					$avgPredictedScore = getAvgScore($teamNumber);
					$totalPredictedScore = getTotalScore($teamNumber);
					$UpperShotPercentage = getAvgUpperShotPercentage($teamNumber);
					$OPR = getOPR($teamNumber);
					$threePoint = getThreePointNew($teamNumber);
					$avgDriveRank = getAvgDriveRank($teamNumber);
					$avgOffenseRank = getAvgOffenseRank($teamNumber);
					$avgDefenseRank = getAvgDefenseRank($teamNumber);
					$avgTeleopUpper = getAvgUpperGoalT($teamNumber);
					$avgTeleopLower = getAvgLowerGoalT($teamNumber);
					$avgTeleopUpperMiss = getAvgUpperGoalMissT($teamNumber);
					$avgAutoUpper = getAvgUpperGoal($teamNumber);
					$avgAutoLower = getAvgLowerGoal($teamNumber);
					$maxTeleopUpper = getMaxUpperGoalT($teamNumber);
					$maxTeleopLower = getMaxLowerGoalT($teamNumber);
					$maxAutoUpper = getMaxUpperGoal($teamNumber);
					$maxAutoLower = getMaxLowerGoal($teamNumber);
					$avgClimb = getAvgClimb($teamNumber);
					$centerClimb = getTotalClimbCenter($teamNumber);
					$sideClimb = getTotalClimbSide($teamNumber);
					$totalDefense = getTotalDefense($teamNumber);
					





					echo ("<tr>
					<td><a href='teamData.php?team=" . $teamNumber . "'>" . $teamNumber . "</a></td>
					<th>" . $picklist . "</th>
					<th>" . $avgPredictedScore . "</th>
					<th>" . $totalPredictedScore . "</th>
					<th>" . $UpperShotPercentage . "</th>
					<th>" . $OPR . "</th>
					<th>" . $threePoint . "</th>
					<th>" . $avgDriveRank . "</th>
					<th>" . $avgOffenseRank . "</th>
					<th>" . $avgDefenseRank . "</th>
					<th>" . $avgTeleopUpper . "</th>
					<th>" . $avgTeleopLower . "</th>
					<th>" . $avgTeleopUpperMiss . "</th>
					<th>" . $avgAutoUpper . "</th>
					<th>" . $avgAutoLower . "</th>
					<th>" . $maxTeleopUpper . "</th>
					<th>" . $maxTeleopLower . "</th>
					<th>" . $maxAutoUpper . "</th>
					<th>" . $maxAutoLower . "</th>
					<th>" . $avgClimb . "</th>
					<th>" . $centerClimb . "</th>
					<th>" . $sideClimb . "</th>
					<th>" . $totalDefense . "</th>
					</tr>");
				}

				?>
			</table>
		</div>
	</div>
</body>
<?php include("footer.php") ?>