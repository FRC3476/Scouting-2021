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
					<th>Upper Goal OPR</th>
					<th>Inner Shot Percentage</th>
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
					$upperGoal = getUpperTotal($teamNumber);
					$shotPercentage = round($threePoint/$upperGoal, 2); 
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
					<th>" . $upperGoal . "</th>
					<th>" . $shotPercentage . "</th>
					<th>" . round($avgDriveRank,3) . "</th>
					<th>" . round($avgOffenseRank,3) . "</th>
					<th>" . round($avgDefenseRank,3) . "</th>
					<th>" . round($avgTeleopUpper,3) . "</th>
					<th>" . round($avgTeleopLower,3) . "</th>
					<th>" . round($avgTeleopUpperMiss,3) . "</th>
					<th>" . round($avgAutoUpper,3) . "</th>
					<th>" . round($avgAutoLower,3) . "</th>
					<th>" . $maxTeleopUpper . "</th>
					<th>" . $maxTeleopLower . "</th>
					<th>" . $maxAutoUpper . "</th>
					<th>" . $maxAutoLower . "</th>
					<th>" . round($avgClimb,3) . "</th>
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