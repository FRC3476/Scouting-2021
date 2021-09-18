<?php
include("databaseName.php");
//Input- runQuery, establishes connection with server, runs query, closes connection.
//Output- queryOutput, data to/from the tables in phpMyAdmin databases.

#function getThreePointNumber()
#{
#	$command = escapeshellcmd('/Documents/FRC/Strategy/frcstrat/oprcalcufinal.py');
#	$output = shell_exec($command);
#	echo $output;
#}

function runQuery($queryString)
{
	global $servername;
	global $username;
	global $password;
	global $dbname;
	global $pitScoutTable;
	global $matchScoutTable;
	global $secondaryMatchScoutTable;
	global $primaryMatchScoutTable;
	global $bettingTable;
	//Establish Connection
	try {
		$conn = connectToDB();
	} catch (Exception $e) {
		error_log("CREATING DB");
		createDB();
		$conn = connectToDB();
	}
	//new mysqli($servername, $username, $password, $dbname);
	//error_log($queryString);
	try {
		$statement = $conn->prepare($queryString);
	} catch (PDOException $e) {
		error_log($e->getMessage());
		error_log($e->getCode());
		if ($e->getCode() == "42S02") {
			error_log("CREATING TABLES");
			createTables();
		}
		$statement = $conn->prepare($queryString);
	}
	if (!$statement->execute()) {
		die("Failed!");
	}
	try {
		//error_log("".$statement->fetchAll());
		return $statement->fetchAll();
	} catch (Exception $e) {
		return;
	}
}
function createDB()
{
	global $dbname;
	$connection = connectToServer();
	$statement = $connection->prepare('CREATE DATABASE IF NOT EXISTS ' . $dbname);
	if (!$statement->execute()) {
		throw new Exception("constructDatabase Error: CREATE DATABASE query failed.");
	}
}
function connectToServer()
{
	global $servername;
	global $username;
	global $password;
	global $dbname;
	global $charset;
	$dsn = "mysql:host=" . $servername . ";charset=" . $charset;
	$opt = [
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES   => false
	];
	return (new PDO($dsn, $username, $password, $opt));
}
function connectToDB()
{
	global $servername;
	global $username;
	global $password;
	global $dbname;
	global $charset;
	$dsn = "mysql:host=" . $servername . ";dbname=" . $dbname . ";charset=" . $charset;
	$opt = [
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES   => false
	];
	return (new PDO($dsn, $username, $password, $opt));
}
function createTables()
{
	global $servername;
	global $username;
	global $password;
	global $dbname;
	global $pitScoutTable;
	global $matchScoutTable;
	global $secondaryMatchScoutTable;
	global $primaryMatchScoutTable;
	global $leadScoutTable;
	global $bettingTable;
	$conn = connectToDB();
	$query = "CREATE TABLE " . $dbname . "." . $pitScoutTable . " (
			teamNumber VARCHAR(50) NOT NULL PRIMARY KEY,
			teamName VARCHAR(60) NOT NULL,
			numBatteries VARCHAR(20) NOT NULL,
			chargedBatteries VARCHAR(20) NOT NULL,
			codeLanguage VARCHAR(10) NOT NULL,
			pitComments LONGTEXT NOT NULL,
			climbHelp LONGTEXT NOT NULL
		)";
	$statemennt = $conn->prepare($query);
	if (!$statemennt->execute()) {
		throw new Exception("constructDatabase Error: CREATE TABLE pitScoutTable query failed.");
	}
	$query = "CREATE TABLE " . $dbname . "." . $matchScoutTable . " (
			user VARCHAR(20) NOT NULL,
			ID VARCHAR(8) NOT NULL PRIMARY KEY,
			matchNum INT(11) NOT NULL,
			teamNum INT(11) NOT NULL,
			allianceColor TEXT NOT NULL,
			autoPath LONGTEXT NOT NULL,
			crossLineA INT(11) NOT NULL,
			upperGoal INT(11) NOT NULL,
			upperGoalMiss INT(11) NOT NULL,
			lowerGoal INT(11) NOT NULL,
			lowerGoalMiss INT(11) NOT NULL,
			upperGoalT INT(11) NOT NULL,
			upperGoalMissT INT(11) NOT NULL,
			lowerGoalT INT(11) NOT NULL,
			lowerGoalMissT INT(11) NOT NULL,
			controlPanelPosT TINYINT(4) NOT NULL,
			controlPanelNumT TINYINT(4) NOT NULL,
			climb TINYINT(4) NOT NULL,
			climbTwo TINYINT(4) NOT NULL,
			climbThree TINYINT(4) NOT NULL,
			climbCenter TINYINT(4) NOT NULL,
			climbSide TINYINT(4) NOT NULL,
			issues LONGTEXT NOT NULL,
			defenseBot INT(11) NOT NULL,
			defenseComments LONGTEXT NOT NULL,
			matchComments LONGTEXT NOT NULL,
			penalties INT(11) NOT NULL,
			cycleNumber INT(11) NOT NULL
		)";
	$statement = $conn->prepare($query);
	if (!$statement->execute()) {
		throw new Exception("constructDatabase Error: CREATE TABLE matchScoutTable query failed.");
	}


	$query = "CREATE TABLE " . $dbname . "." . $secondaryMatchScoutTable . " (
			user VARCHAR(20) NOT NULL,
			ID VARCHAR(8) NOT NULL PRIMARY KEY,
			matchNum INT(11) NOT NULL,
			teamNum INT(11) NOT NULL,
			allianceColor TEXT NOT NULL,
			autoPath LONGTEXT NOT NULL,
			crossLineA INT(11) NOT NULL,
			teleopPath LONGTEXT NOT NULL,
			climb TINYINT(4) NOT NULL,
			climbTwo TINYINT(4) NOT NULL,
			climbThree TINYINT(4) NOT NULL,
			climbCenter TINYINT(4) NOT NULL,
			climbSide TINYINT(4) NOT NULL,
			issues LONGTEXT NOT NULL,
			defenseBot INT(11) NOT NULL,
			defenseComments LONGTEXT NOT NULL,
			matchComments LONGTEXT NOT NULL,
			penalties INT(11) NOT NULL,
			cycleNumber INT(11) NOT NULL
		)";
	$statement = $conn->prepare($query);
	if (!$statement->execute()) {
		throw new Exception("constructDatabase Error: CREATE TABLE secondaryMatchScoutTable query failed.");
	}

	$query = "CREATE TABLE " . $dbname . "." . $primaryMatchScoutTable . " (
			user VARCHAR(20) NOT NULL,
			ID VARCHAR(8) NOT NULL PRIMARY KEY,
			matchNum INT(11) NOT NULL,
			teamNum INT(11) NOT NULL,
			allianceColor TEXT NOT NULL,
			upperGoal INT(11) NOT NULL,
			upperGoalMiss INT(11) NOT NULL,
			lowerGoal INT(11) NOT NULL,
			upperGoalT INT(11) NOT NULL,
			upperGoalMissT INT(11) NOT NULL,
			lowerGoalT INT(11) NOT NULL,
			controlPanelPosT TINYINT(4) NOT NULL,
			controlPanelNumT TINYINT(4) NOT NULL,
			matchComments LONGTEXT NOT NULL,
			cycleNumber LONGTEXT NOT NULL
		)";
	$statement = $conn->prepare($query);
	if (!$statement->execute()) {
		throw new Exception("constructDatabase Error: CREATE TABLE primaryMatchScoutTable query failed.");
	}

	$query = "CREATE TABLE " . $dbname . "." . $leadScoutTable . " (
			matchNum INT(11) NOT NULL PRIMARY KEY,
			team1Off INT(11) NOT NULL,
			team2Off INT(11) NOT NULL,
			team3Off INT(11) NOT NULL,
			team1Def INT(11) NOT NULL,
			team2Def INT(11) NOT NULL,
			team3Def INT(11) NOT NULL,
			team1Dri INT(11) NOT NULL,
			team2Dri INT(11) NOT NULL,
			team3Dri INT(11) NOT NULL
		)";
	$statement = $conn->prepare($query);
	if (!$statement->execute()) {
		throw new Exception("constructDatabase Error: CREATE TABLE leadScoutTable query failed.");
	}

	$query = "CREATE TABLE " . $dbname . "." . $bettingTable . " (
		user VARCHAR(20) NOT NULL,
		ID VARCHAR(8) NOT NULL PRIMARY KEY,
		allianceOne INT(11) NOT NULL,
		allianceTwo INT(11) NOT NULL,
		allianceThree INT(11) NOT NULL,
		allianceFour INT(11) NOT NULL,
		allianceFive INT(11) NOT NULL,
		allianceSix INT(11) NOT NULL,
		allianceSeven INT(11) NOT NULL,
		allianceEight INT(11) NOT NULL,
		championTeam INT(11) NOT NULL,
		mostContribution INT(11) NOT NULL,
		mostClimb INT(11) NOT NULL
	)";
	$statement = $conn->prepare($query);
	if (!$statement->execute()) {
		throw new Exception("constructDatabase Error: CREATE TABLE BettingTable query failed.");
	}
}

//Input- pitScoutInput, Data from pit scout form is assigned to columns in 17template_pitscout.
//Output- queryString and "Success" statement, data put in columns.

function pitScoutInput($teamNumber, $teamName, $numBatteries, $chargedBatteries, $codeLanguage, $pitComments, $climbHelp)
{
	global $pitScoutTable;
	$queryString = "REPLACE INTO `" . $pitScoutTable . "` (`teamNumber`, `teamName`, `numBatteries`,`chargedBatteries`, `codeLanguage`, `pitComments`, `climbHelp`)";
	$queryString = $queryString . ' VALUES ("' . $teamNumber . '", "' . $teamName . '", "' . $numBatteries . '", "' . $chargedBatteries . '", "' . $codeLanguage . '", "' . $pitComments . '", "' . $climbHelp . '")';
	$queryOutput = runQuery($queryString);
}


//Input- getTeamList, accesses match scout table and gets team numbers from it.
//Output- array, list of teams in teamNumber column of pitscout table.
function getTeamList()
{
	global $matchScoutTable;
	global $primaryMatchScoutTable;
	$queryString = "SELECT `teamNum` FROM `" . $primaryMatchScoutTable . "`";
	$result = runQuery($queryString);
	$queryStringTwo = "SELECT `teamNum` FROM `" . $matchScoutTable . "`";
	$resultTwo = runQuery($queryStringTwo);
	$teams = array();

	foreach ($result as $row_key => $row) {
		if (!in_array($row["teamNum"], $teams)) {
			array_push($teams, $row["teamNum"]);
		}
	}
	foreach ($resultTwo as $row_key => $row) {
		if (!in_array($row["teamNum"], $teams)) {
			array_push($teams, $row["teamNum"]);
		}
	}
	return ($teams);
}

function getUpperGoalTeamList()
{
	global $matchScoutTable;
	global $primaryMatchScoutTable;
	$queryString = "SELECT `teamNum` FROM `" . $matchScoutTable . "`";
	$result = runQuery($queryString);
	$queryStringTwo = "SELECT `teamNum` FROM `" . $primaryMatchScoutTable . "`";
	$resultTwo = runQuery($queryStringTwo);
	$teams = array();

	foreach ($result as $row_key => $row) {
		if ((!in_array($row["teamNum"], $teams)) && (getTotalUpperGoal($row["teamNum"]) != 0)) {
			array_push($teams, $row["teamNum"]);
		}
	}
	foreach ($resultTwo as $row_key => $row) {
			if ((!in_array($row["teamNum"], $teams)) && (getTotalUpperGoal($row["teamNum"]) != 0)) {
				array_push($teams, $row["teamNum"]);
			}
		}
	return ($teams);
}

function primaryMatchInput(
	$user,
	$ID,
	$matchNum,
	$teamNum,
	$allianceColor,
	$upperGoal,
	$upperGoalMiss,
	$lowerGoal,
	$upperGoalT,
	$upperGoalMissT,
	$lowerGoalT,
	$controlPanelPosT,
	$controlPanelNumT,
	$matchComments,
	$cycleNumber
) {

	global $servername;
	global $username;
	global $password;
	global $dbname;
	global $primaryMatchScoutTable;
	$queryString = "REPLACE INTO `" . $primaryMatchScoutTable . '`(  `user`,
															 `ID`,
															 `matchNum`,
															 `teamNum`,
															 `allianceColor`,
															 `upperGoal`,
															 `upperGoalMiss`,
															 `lowerGoal`,
															 `upperGoalT`,
															 `upperGoalMissT`,
															 `lowerGoalT`,
															 `controlPanelPosT`,
															 `controlPanelNumT`,
															 `matchComments`,
															 `cycleNumber`)
													VALUES ( "' . $user . '",
															 "' . $ID . '",
															 "' . $matchNum . '",
															 "' . $teamNum . '",
															 "' . $allianceColor . '",
															 "' . $upperGoal . '",
															 "' . $upperGoalMiss . '",
															 "' . $lowerGoal . '",
															 "' . $upperGoalT . '",
															 "' . $upperGoalMissT . '",
															 "' . $lowerGoalT . '",
															 "' . $controlPanelPosT . '",
															 "' . $controlPanelNumT . '",
															 "' . $matchComments . '",
															 "' . $cycleNumber . '")';
	$queryOutput = runQuery($queryString);
}

function bettingTableInput(
	$user,
	$ID,
	$allianceOne,
	$allianceTwo,
	$allianceThree,
	$allianceFour,
	$allianceFive,
	$allianceSix,
	$allianceSeven,
	$allianceEight,
	$championTeam,
	$mostContribution,
	$mostClimb
) {

	global $servername;
	global $username;
	global $password;
	global $dbname;
	global $bettingTable;
	$queryString = "REPLACE INTO `" . $bettingTable . '`(  `user`,
															 `ID`,
															 `allianceOne`,
															 `allianceTwo`,
															 `allianceThree`,
															 `allianceFour`,
															 `allianceFive`,
															 `allianceSix`,
															 `allianceSeven`,
															 `allianceEight`,
															 `championTeam`,
															 `mostContribution`,
															 `mostClimb`)
													VALUES ( "' . $user . '",
															 "' . $ID . '",
															 "' . $allianceOne . '",
															 "' . $allianceTwo . '",
															 "' . $allianceThree . '",
															 "' . $allianceFour . '",
															 "' . $allianceFive . '",
															 "' . $allianceSix . '",
															 "' . $allianceSeven . '",
															 "' . $allianceEight . '",
															 "' . $championTeam . '",
															 "' . $mostContribution . '",
															 "' . $mostClimb . '")';
	$queryOutput = runQuery($queryString);
}

function secondaryMatchInput(
	$user,
	$ID,
	$matchNum,
	$teamNum,
	$allianceColor,
	$autoPath,
	$crossLineA,
	$teleopPath,
	$climb,
	$climbTwo,
	$climbThree,
	$climbCenter,
	$climbSide,
	$issues,
	$defenseBot,
	$defenseComments,
	$matchComments,
	$penalties,
	$cycleNumber
) {

	global $servername;
	global $username;
	global $password;
	global $dbname;
	global $secondaryMatchScoutTable;
	$queryString = "REPLACE INTO `" . $secondaryMatchScoutTable . '`(  `user`,
															 `ID`,
															 `matchNum`,
															 `teamNum`,
															 `allianceColor`,
															 `autoPath`,
															 `crossLineA`,
															 `teleopPath`,
															 `climb`,
															 `climbTwo`,
															 `climbThree`,
															 `climbCenter`,
															 `climbSide`,
															 `issues`,
															 `defenseBot`,
															 `defenseComments`,
															 `matchComments`,
															 `penalties`,
															 `cycleNumber`)
													VALUES ( "' . $user . '",
															 "' . $ID . '",
															 "' . $matchNum . '",
															 "' . $teamNum . '",
															 "' . $allianceColor . '",
															 "' . $autoPath . '",
															 "' . $crossLineA . '",
															 "' . $teleopPath . '",
															 "' . $climb . '",
															 "' . $climbTwo . '",
															 "' . $climbThree . '",
															 "' . $climbCenter . '",
															 "' . $climbSide . '",
															 "' . $issues . '",
															 "' . $defenseBot . '",
															 "' . $defenseComments . '",
															 "' . $matchComments . '",
															 "' . $penalties . '",
															 "' . $cycleNumber . '")';
	$queryOutput = runQuery($queryString);
}



function matchInput(
	$user,
	$ID,
	$matchNum,
	$teamNum,
	$allianceColor,
	$autoPath,
	$crossLineA,
	$upperGoal,
	$upperGoalMiss,
	$lowerGoal,
	$lowerGoalMiss,
	$upperGoalT,
	$upperGoalMissT,
	$lowerGoalT,
	$lowerGoalMissT,
	$controlPanelPosT,
	$controlPanelNumT,
	$climb,
	$climbTwo,
	$climbThree,
	$climbCenter,
	$climbSide,
	$issues,
	$defenseBot,
	$defenseComments,
	$matchComments,
	$penalties,
	$cycleNumber
) {

	global $servername;
	global $username;
	global $password;
	global $dbname;
	global $matchScoutTable;
	$queryString = "REPLACE INTO `" . $matchScoutTable . '`(  `user`,
															 `ID`,
															 `matchNum`,
															 `teamNum`,
															 `allianceColor`,
															 `autoPath`,
															 `crossLineA`,
															 `upperGoal`,
															 `upperGoalMiss`,
															 `lowerGoal`,
															 `lowerGoalMiss`,
															 `upperGoalT`,
															 `upperGoalMissT`,
															 `lowerGoalT`,
															 `lowerGoalMissT`,
															 `controlPanelPosT`,
															 `controlPanelNumT`,
															 `climb`,
															 `climbTwo`,
															 `climbThree`,
															 `climbCenter`,
															 `climbSide`,
															 `issues`,
															 `defenseBot`,
															 `defenseComments`,
															 `matchComments`,
															 `penalties`,
															 `cycleNumber`)
													VALUES ( "' . $user . '",
															 "' . $ID . '",
															 "' . $matchNum . '",
															 "' . $teamNum . '",
															 "' . $allianceColor . '",
															 "' . $autoPath . '",
															 "' . $crossLineA . '",
															 "' . $upperGoal . '",
															 "' . $upperGoalMiss . '",
															 "' . $lowerGoal . '",
															 "' . $lowerGoalMiss . '",
															 "' . $upperGoalT . '",
															 "' . $upperGoalMissT . '",
															 "' . $lowerGoalT . '",
															 "' . $lowerGoalMissT . '",
															 "' . $controlPanelPosT . '",
															 "' . $controlPanelNumT . '",
															 "' . $climb . '",
															 "' . $climbTwo . '",
															 "' . $climbThree . '",
															 "' . $climbCenter . '",
															 "' . $climbSide . '",
															 "' . $issues . '",
															 "' . $defenseBot . '",
															 "' . $defenseComments . '",
															 "' . $matchComments . '",
															 "' . $penalties . '",
															 "' . $cycleNumber . '")';
	$queryOutput = runQuery($queryString);
}









function leadScoutInput(
	$matchNum,
	$team1Off,
	$team2Off,
	$team3Off,
	$team1Def,
	$team2Def,
	$team3Def,
	$team1Dri,
	$team2Dri,
	$team3Dri
) {
	global $servername;
	global $username;
	global $password;
	global $dbname;
	global $leadScoutTable;
	$queryString = "REPLACE INTO `" . $leadScoutTable . '`(  `matchNum`,
															`team1Off`,
															`team2Off`,
															`team3Off`,
															`team1Def`,
															`team2Def`,
															`team3Def`,
															`team1Dri`,
															`team2Dri`,
															`team3Dri`)
															VALUES
															("' . $matchNum . '",
															"' . $team1Off . '",
															"' . $team2Off . '",
															"' . $team3Off . '",
															"' . $team1Def . '",
															"' . $team2Def . '",
															"' . $team3Def . '",
															"' . $team1Dri . '",
															"' . $team2Dri . '",
															"' . $team3Dri . '")';
	error_log($queryString);
	$queryOutput = runQuery($queryString);
}

function getBettingData($username){
	global $servername;
	global $username;
	global $password;
	global $dbname;
	global $bettingTable;
	$qs1 = "SELECT * FROM `" . $bettingTable . "` WHERE user = " . $username . "";
	$result = runQuery($qs1);
	$bettingData = array();
	if ($result != FALSE) {
		foreach ($result as $row_key => $row) {
			array_push($bettingData, $row["user"], $row["ID"], $row["allianceOne"], $row["allianceTwo"], $row["allianceThree"], $row["allianceFour"], $row["allianceFive"], $row["allianceSix"], $row["allianceSeven"], $row["allianceEight"], $row["championTeam"], $row["mostContribution"], $row["mostClimb"]);
		}
	}
	return($bettingData);
}

function getTeamData($teamNumber)
{
	global $servername;
	global $username;
	global $password;
	global $dbname;
	global $pitScoutTable;
	global $matchScoutTable;
	global $leadScoutTable;
	global $primaryMatchScoutTable;
	global $secondaryMatchScoutTable;
	$qs1 = "SELECT * FROM `" . $pitScoutTable . "` WHERE teamNumber = " . $teamNumber . "";
	$qs2 = "SELECT * FROM `" . $matchScoutTable . "`  WHERE teamNum = " . $teamNumber . "";
	$qs3 = "SELECT * FROM `" . $leadScoutTable . "`";
	$qs4 = "SELECT * FROM `" . $primaryMatchScoutTable . "`  WHERE teamNum = " . $teamNumber . "";
	$qs5 = "SELECT * FROM `" . $secondaryMatchScoutTable . "`  WHERE teamNum = " . $teamNumber . "";

	$result = runQuery($qs1);
	$result2 = runQuery($qs2);
	$result3 = runQuery($qs3);
	$result4 = runQuery($qs4);
	$result5 = runQuery($qs5);
	$teamData = array();
	$pitExists = False;
	if ($result != FALSE) {
		// output data of each row
		foreach ($result as $row_key => $row) {
			array_push($teamData, $row["teamNumber"], $row["teamName"], $row["numBatteries"], $row["chargedBatteries"], $row["codeLanguage"], $row["pitComments"], $row["climbHelp"], array(), array(), array(), array());
			$pitExists = True;
		}
	}
	if (!$pitExists) {
		array_push($teamData, $teamNumber, 'NA', 'NA', 'NA', 'NA', 'NA', 'NA', array(), array(), array(), array());
	}
	if ($result2 != FALSE) {
		foreach ($result2 as $row_key => $row) {
			array_push($teamData[8], array(
				$row["user"], $row["ID"], $row["matchNum"],
				$row["teamNum"], $row["allianceColor"], $row["autoPath"],
				$row["crossLineA"], $row["upperGoal"], $row["upperGoalMiss"],
				$row["lowerGoal"], $row["lowerGoalMiss"], $row["upperGoalT"],
				$row["upperGoalMissT"],  $row["lowerGoalT"], $row["lowerGoalMissT"],
				$row["controlPanelPosT"], $row["controlPanelNumT"], $row["climb"],
				$row["climbTwo"], $row["climbThree"], $row["climbCenter"],
				$row["climbSide"], $row["issues"], $row["defenseBot"],
				$row["defenseComments"], $row["matchComments"], $row["penalties"], $row["cycleNumber"]
			));
		}
	}
	if ($result3 != FALSE) {
		foreach ($result3 as $row_key => $row) {
			array_push($teamData[7], array(
				$row["matchNum"], $row["team1Off"], $row["team2Off"],
				$row["team3Off"], $row["team1Def"], $row["team2Def"], $row["team3Def"], $row["team1Dri"],
				$row["team2Dri"], $row["team3Dri"]
			));
		}
	}
	if ($result4 != FALSE) {
		foreach ($result4 as $row_key => $row) {
			array_push($teamData[9], array(
				$row["user"], $row["ID"], $row["matchNum"],
				$row["teamNum"], $row["allianceColor"], $row["upperGoal"], $row["upperGoalMiss"],
				$row["lowerGoal"], $row["upperGoalT"],
				$row["upperGoalMissT"],  $row["lowerGoalT"],
				$row["controlPanelPosT"], $row["controlPanelNumT"], $row["matchComments"],
				$row["cycleNumber"]
			));
		}
	}
	if ($result5 != FALSE) {
		foreach ($result5 as $row_key => $row) {
			array_push($teamData[10], array(
				$row["user"], $row["ID"], $row["matchNum"],
				$row["teamNum"], $row["allianceColor"], $row["autoPath"],
				$row["crossLineA"], $row["teleopPath"], $row["climb"],
				$row["climbTwo"], $row["climbThree"], $row["climbCenter"],
				$row["climbSide"], $row["issues"], $row["defenseBot"],
				$row["defenseComments"], $row["matchComments"], $row["penalties"], $row["cycleNumber"]
			));
		}
	}
	return ($teamData);
}

function getAutoUpperGoal($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$matchN = matchNum($teamNumber);
	$cubeGraphT = array();
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$cubeGraphT[$teamData[8][$i][2]] = $teamData[8][$i][7];
		}
	} else{
		for ($i = 0; $i != sizeof($teamData[9]); $i++) {
			$cubeGraphT[$teamData[9][$i][2]] = $teamData[9][$i][5];
		}
	}
	$out = array();
	for ($i = 0; $i != sizeof($matchN); $i++) {
		array_push($out, $cubeGraphT[$matchN[$i]]);
	}
	return ($out);
}

function getAutoLowerGoal($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$matchN = matchNum($teamNumber);
	$cubeGraphT = array();
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$cubeGraphT[$teamData[8][$i][2]] = $teamData[8][$i][9];
		}
	} else{
		for ($i = 0; $i != sizeof($teamData[9]); $i++) {
			$cubeGraphT[$teamData[9][$i][2]] = $teamData[9][$i][7];
		}
	}
	$out = array();
	for ($i = 0; $i != sizeof($matchN); $i++) {
		array_push($out, $cubeGraphT[$matchN[$i]]);
	}
	return ($out);
}



function getAutoUpperGoalMiss($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$matchN = matchNum($teamNumber);
	$cubeGraphT = array();
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$cubeGraphT[$teamData[8][$i][2]] = $teamData[8][$i][8];
		}
	} else {
		for ($i = 0; $i != sizeof($teamData[9]); $i++) {
			$cubeGraphT[$teamData[9][$i][2]] = $teamData[9][$i][6];
		}
	}
	$out = array();
	for ($i = 0; $i != sizeof($matchN); $i++) {
		array_push($out, $cubeGraphT[$matchN[$i]]);
	}
	return ($out);
}


function getTeleopUpperGoal($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$matchN = matchNum($teamNumber);
	$cubeGraphT = array();
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$cubeGraphT[$teamData[8][$i][2]] = $teamData[8][$i][11];
		}
	} else{
		for ($i = 0; $i != sizeof($teamData[9]); $i++) {
			$cubeGraphT[$teamData[9][$i][2]] = $teamData[9][$i][8];
		}
	}
	$out = array();
	for ($i = 0; $i != sizeof($matchN); $i++) {
		array_push($out, $cubeGraphT[$matchN[$i]]);
	}
	return ($out);
}


function getTeleopLowerGoal($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$matchN = matchNum($teamNumber);
	$cubeGraphT = array();
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$cubeGraphT[$teamData[8][$i][2]] = $teamData[8][$i][13];
		}
	} else{
		for ($i = 0; $i != sizeof($teamData[9]); $i++) {
			$cubeGraphT[$teamData[9][$i][2]] = $teamData[9][$i][10];
		}
	}
	$out = array();
	for ($i = 0; $i != sizeof($matchN); $i++) {
		array_push($out, $cubeGraphT[$matchN[$i]]);
	}
	return ($out);
}


function getTeleopUpperGoalMiss($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$matchN = matchNum($teamNumber);
	$cubeGraphT = array();
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$cubeGraphT[$teamData[8][$i][2]] = $teamData[8][$i][12];
		}
	} else{
		for ($i = 0; $i != sizeof($teamData[9]); $i++) {
			$cubeGraphT[$teamData[9][$i][2]] = $teamData[9][$i][9];
		}
	}
	$out = array();
	for ($i = 0; $i != sizeof($matchN); $i++) {
		array_push($out, $cubeGraphT[$matchN[$i]]);
	}
	return ($out);
}

function getLowerGoal($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$matchN = matchNum($teamNumber);
	$cubeGraphT = array();
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$cubeGraphT[$teamData[8][$i][2]] = $teamData[8][$i][9] + $teamData[8][$i][13];
		}
	} else{
		for ($i = 0; $i != sizeof($teamData[9]); $i++) {
			$cubeGraphT[$teamData[9][$i][2]] = $teamData[9][$i][7] + $teamData[9][$i][10];
		}
	}
	$out = array();
	for ($i = 0; $i != sizeof($matchN); $i++) {
		array_push($out, $cubeGraphT[$matchN[$i]]);
	}
	return ($out);
}

function getClimb($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$matchN = matchNum($teamNumber);
	$cubeGraphT = array();
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$cubeGraphT[$teamData[8][$i][2]] = $teamData[8][$i][17] + $teamData[8][$i][18] + $teamData[8][$i][19];
		}
	} else{
		for ($i = 0; $i != sizeof($teamData[10]); $i++) {
			$cubeGraphT[$teamData[10][$i][2]] = $teamData[10][$i][8] + $teamData[10][$i][9] + $teamData[10][$i][10];
		}
	}
	$out = array();
	for ($i = 0; $i != sizeof($matchN); $i++) {
		array_push($out, $cubeGraphT[$matchN[$i]]);
	}
	return ($out);
}


function getUpperShotPercentage($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$matchN = matchNum($teamNumber);
	$cubeGraphT = array();
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			if ((($teamData[8][$i][12]) + (($teamData[8][$i][11]) + ($teamData[8][$i][7]) + ($teamData[8][$i][8]))) != 0){
				$cubeGraphT[$teamData[8][$i][2]] = (100 * ((($teamData[8][$i][11]) + ($teamData[8][$i][7])) / (($teamData[8][$i][12]) + (($teamData[8][$i][11]) + ($teamData[8][$i][7]) + ($teamData[8][$i][8])))));
			} else {
				$cubeGraphT[$teamData[8][$i][2]] = 0;
			}
		}
	} else{
		for ($i = 0; $i != sizeof($teamData[9]); $i++) {
			if ((($teamData[9][$i][5]) + ($teamData[9][$i][8]) + ($teamData[9][$i][6]) + ($teamData[9][$i][9])) != 0){
				$cubeGraphT[$teamData[9][$i][2]] = (100 * ((($teamData[9][$i][5]) + ($teamData[9][$i][8])) / (($teamData[9][$i][5]) + (($teamData[9][$i][8]) + ($teamData[9][$i][6]) + ($teamData[9][$i][9])))));
			} else {
				$cubeGraphT[$teamData[9][$i][2]] = 0;
			}
		}
	}
	$out = array();
	for ($i = 0; $i != sizeof($matchN); $i++) {
		array_push($out, $cubeGraphT[$matchN[$i]]);
	}
	return ($out);
}



function getAutoUpperShotPercentage($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$matchN = matchNum($teamNumber);
	$cubeGraphT = array();
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$cubeGraphT[$teamData[8][$i][2]] = ($teamData[8][$i][7]) / ($teamData[8][$i][8]);
		}
	} else{
		for ($i = 0; $i != sizeof($teamData[9]); $i++) {
			$cubeGraphT[$teamData[9][$i][2]] = ($teamData[9][$i][5]) / ($teamData[9][$i][6]);
		}
	}
	$out = array();
	for ($i = 0; $i != sizeof($matchN); $i++) {
		array_push($out, $cubeGraphT[$matchN[$i]]);
	}
	return ($out);
}



function getAvgUpperShotPercentage($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$upperGoalCount = 0;
	$upperGoalMissCount = 0;
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$upperGoalCount = $upperGoalCount + $teamData[8][$i][11] + $teamData[8][$i][7];
		}
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$upperGoalMissCount = $upperGoalMissCount + $teamData[8][$i][8] + $teamData[8][$i][12];
		}
		if (($upperGoalCount + $upperGoalMissCount) == 0) {
			return (0);
		}
	} else{
		for ($i = 0; $i != sizeof($teamData[9]); $i++) {
			$upperGoalCount = $upperGoalCount + $teamData[9][$i][5] + $teamData[9][$i][8];
		}
		for ($i = 0; $i != sizeof($teamData[9]); $i++) {
			$upperGoalMissCount = $upperGoalMissCount + $teamData[9][$i][6] + $teamData[9][$i][9];
		}
		if (($upperGoalCount + $upperGoalMissCount) == 0) {
			return (0);
		}
	}
	return (round((100 * ($upperGoalCount / ($upperGoalCount + $upperGoalMissCount))), 3));
}




function getAvgUpperGoalT($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$upperGoalCountT = 0;
	$matchCount  = 0;
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$upperGoalCountT = $upperGoalCountT + $teamData[8][$i][11];
			$matchCount++;
		}
	} else{
		for ($i = 0; $i != sizeof($teamData[9]); $i++) {
			$upperGoalCountT = $upperGoalCountT + $teamData[9][$i][8];
			$matchCount++;
		}
	}
	return (round(($upperGoalCountT / $matchCount), 3));
}

function getAvgLowerGoalT($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$lowerGoalCountT = 0;
	$matchCount  = 0;
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$lowerGoalCountT = $lowerGoalCountT + $teamData[8][$i][13];
			$matchCount++;
		}
	} else{
		for ($i = 0; $i != sizeof($teamData[9]); $i++) {
			$lowerGoalCountT = $lowerGoalCountT + $teamData[9][$i][10];
			$matchCount++;
		}
	}
	return ($lowerGoalCountT / $matchCount);
}

function getAvgUpperGoalMissT($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$upperGoalMissCountT = 0;
	$matchCount  = 0;
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$upperGoalMissCountT = $upperGoalMissCountT + $teamData[8][$i][12];
			$matchCount++;
		}
	} else{
		for ($i = 0; $i != sizeof($teamData[9]); $i++) {
			$upperGoalMissCountT = $upperGoalMissCountT + $teamData[9][$i][6];
			$matchCount++;
		}
	}
	return (round(($upperGoalMissCountT / $matchCount), 3));
}



//Auto Upper and Lower statistics 



function getAvgUpperGoal($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$upperGoalCount = 0;
	$matchCount  = 0;
	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		$upperGoalCount = $upperGoalCount + $teamData[8][$i][7];
		$matchCount++;
	}
	if ($matchCount == 0){
		$upperGoalCount = 0;
		for ($i = 0; $i != sizeof($teamData[9]); $i++) {
			$upperGoalCount = $upperGoalCount + $teamData[9][$i][5];
			$matchCount++;
		}
	}
	return (round(($upperGoalCount / $matchCount), 3));
}

function getAvgLowerGoal($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$lowerGoalCount = 0;
	$matchCount  = 0;
	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		$lowerGoalCount = $lowerGoalCount + $teamData[8][$i][9];
		$matchCount++;
	}
	if ($matchCount == 0){
		$lowerGoalCount = 0;
		for ($i = 0; $i != sizeof($teamData[9]); $i++) {
			$lowerGoalCount = $lowerGoalCount + $teamData[9][$i][7];
			$matchCount++;
		}
	}
	return ($lowerGoalCount / $matchCount);
}



//Teleop


function getMaxUpperGoalT($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$maxUpperGoalT = 0;
	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		if ($maxUpperGoalT < $teamData[8][$i][11]) {
			$maxUpperGoalT = $teamData[8][$i][11];
		}
	}
	if ($teamData[8] == null){
		for ($i = 0; $i != sizeof($teamData[9]); $i++) {
			if ($maxUpperGoalT < $teamData[9][$i][8]) {
				$maxUpperGoalT = $teamData[9][$i][8];
			}
		}
	}
	return ($maxUpperGoalT);
}

function getMaxLowerGoalT($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$maxLowerGoalT = 0;
	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		if ($maxLowerGoalT < $teamData[8][$i][13]) {
			$maxLowerGoalT = $teamData[8][$i][13];
		}
	}
	if ($teamData[8] == null){
		for ($i = 0; $i != sizeof($teamData[9]); $i++) {
			if ($maxLowerGoalT < $teamData[9][$i][10]) {
				$maxLowerGoalT = $teamData[9][$i][10];
			}
		}
	}
	return ($maxLowerGoalT);
}

//Auto


function getMaxUpperGoal($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$maxUpperGoal = 0;
	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		if ($maxUpperGoal < $teamData[8][$i][7]) {
			$maxUpperGoal = $teamData[8][$i][7];
		}
	}
	if ($teamData[8] == null){
		for ($i = 0; $i != sizeof($teamData[9]); $i++) {
			if ($maxUpperGoal < $teamData[9][$i][5]) {
				$maxUpperGoal = $teamData[9][$i][5];
			}
		}
	}
	return ($maxUpperGoal);
}

function getMaxLowerGoal($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$maxLowerGoal = 0;
	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		if ($maxLowerGoal < $teamData[8][$i][9]) {
			$maxLowerGoal = $teamData[8][$i][9];
		}
	}
	if ($teamData[8] == null){
		for ($i = 0; $i != sizeof($teamData[9]); $i++) {
			if ($maxLowerGoal < $teamData[9][$i][7]) {
				$maxLowerGoal = $teamData[9][$i][7];
			}
		}
	}
	return ($maxLowerGoal);
}

function getAvgClimb($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$climbSum = 0;
	$matchCount = 0;

	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		$climbSum += $teamData[8][$i][20];
		$climbSum += $teamData[8][$i][21];
		$matchCount++;
	}
	if ($matchCount == 0){
		$climbSum = 0;
		for ($i = 0; $i != sizeof($teamData[10]); $i++) {
			$climbSum += $teamData[10][$i][11];
			$climbSum += $teamData[10][$i][12];
			$matchCount++;
		}
	}
	return ($climbSum / $matchCount);
}

function getAllMatchData()
{
	global $matchScoutTable;
	$qs1 = "SELECT * FROM `" . $matchScoutTable . "`";
	return runQuery($qs1);
}
function getAllPrimaryMatchData()
{
	global $primaryMatchScoutTable;
	$qs1 = "SELECT * FROM `" . $primaryMatchScoutTable . "`";
	return runQuery($qs1);
}

function getAllNewMatchData()
{
	global $primaryMatchScoutTable;
	global $secondaryMatchScoutTable;
	$qs1 = "SELECT * FROM " . $primaryMatchScoutTable. ", " . $secondaryMatchScoutTable. " WHERE " . $primaryMatchScoutTable. ".ID = " .$secondaryMatchScoutTable. ".ID";
	return runQuery($qs1);
}

function getAllSecondaryMatchData()
{
	global $secondaryMatchScoutTable;
	$qs1 = "SELECT * FROM `" . $secondaryMatchScoutTable . "`";
	return runQuery($qs1);
}
function getAllLeadScoutData()
{
	global $leadScoutTable;
	$qs1 = "SELECT * FROM `" . $leadScoutTable . "`";
	return runQuery($qs1);
}

function getTotalClimb($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$climbCount = 0;
	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		$climbCount = $climbCount + $teamData[8][$i][17];
		$climbCount = $climbCount + $teamData[8][$i][18];
		$climbCount = $climbCount + $teamData[8][$i][19];
	}
	if ($teamData[8] == null){
		$climbCount = 0;
		for ($i = 0; $i != sizeof($teamData[9]); $i++) {
			$climbCount += $teamData[10][$i][11];
			$climbCount += $teamData[10][$i][12];
		}
	}
	return ($climbCount);
}

function getTotalAuto($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$auto = 0;
	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		$auto = $auto + $teamData[8][$i][6];

	}
	if ($teamData[8] == null){
		$auto = 0;
		for ($i = 0; $i != sizeof($teamData[9]); $i++) {
			$auto += $teamData[10][$i][6];
		}
	}
	return ($auto);
}

function getAuto($teamNumber)
{
	$auto = getTotalAuto($teamNumber);
	if ($auto == 0){
		return "No";
	} else{
		return "Yes";
	}
}

function getSideClimbAbility($teamNumber)
{
	$climbCount = getTotalClimbSide($teamNumber);
	if ($climbCount == 0){
		return "No";
	} else{
		return "Yes";
	}
}

function getCenterClimbAbility($teamNumber)
{
	$climbCount = getTotalClimbCenter($teamNumber);
	if ($climbCount == 0){
		return "No";
	} else{
		return "Yes";
	}
}

function getClimbAbility($teamNumber)
{
	$climbCount = getTotalClimbCenter($teamNumber) + getTotalClimbSide($teamNumber);
	if ($climbCount == 0){
		return "No";
	} else{
		return "Yes";
	}
}

function getTotalUpperGoal($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$upperGoal = 0;
	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		$upperGoal = $upperGoal + $teamData[8][$i][7];
		$upperGoal = $upperGoal + $teamData[8][$i][11];
	}
	if ($teamData[8] == null){
		$upperGoal = 0;
		for ($i = 0; $i != sizeof($teamData[9]); $i++) {
			$upperGoal += $teamData[9][$i][5];
			$upperGoal += $teamData[9][$i][5];
		}
	}
	return ($upperGoal);
}



function getTotalSingleClimb($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$climbCount = 0;
	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		$climbCount = $climbCount + $teamData[8][$i][17];
	}
	if ($teamData[8] == null){
		$climbCount = 0;
		for ($i = 0; $i != sizeof($teamData[10]); $i++) {
			$climbCount = $climbCount + $teamData[10][$i][8];
		}
	}
	return ($climbCount);
}

function getTotalDoubleClimb($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$climbCount = 0;
	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		$climbCount = $climbCount + $teamData[8][$i][18];
	}
	if ($teamData[8] == null){
		$climbCount = 0;
		for ($i = 0; $i != sizeof($teamData[10]); $i++) {
			$climbCount = $climbCount + $teamData[10][$i][9];
		}
	}
	return ($climbCount);
}

function getTotalTripleClimb($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$climbCount = 0;
	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		$climbCount = $climbCount + $teamData[8][$i][19];
	}
	if ($teamData[8] == null){
		$climbCount = 0;
		for ($i = 0; $i != sizeof($teamData[10]); $i++) {
			$climbCount = $climbCount + $teamData[10][$i][10];
		}
	}
	return ($climbCount);
}

function getTotalClimbSide($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$climbCount = 0;
	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		$climbCount = $climbCount + $teamData[8][$i][21];
	}
	if ($teamData[8] == null){
		$climbCount = 0;
		for ($i = 0; $i != sizeof($teamData[10]); $i++) {
			$climbCount = $climbCount + $teamData[10][$i][12];
		}
	}
	return ($climbCount);
}

function getTotalClimbCenter($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$climbCount = 0;
	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		$climbCount = $climbCount + $teamData[8][$i][20];
	}
	if ($teamData[8] == null){
		$climbCount = 0;
		for ($i = 0; $i != sizeof($teamData[10]); $i++) {
			$climbCount = $climbCount + $teamData[10][$i][11];
		}
	}
	return ($climbCount);
}


function getAvgDriveRank($teamNumber)
{
	$result = getAllLeadScoutData();
	$driveRankSum = 0;
	$matchCount = 0;
	foreach ($result as $row_key => $row) {
		foreach ($row as $key => $value) {
			$num = $key;
			if ($value == $teamNumber) {
				if ($key == "team1Dri") {
					$driveRankSum += 1;
					$matchCount++;
				} else if ($key == "team2Dri") {
					$driveRankSum += 2;
					$matchCount++;
				} else if ($key == "team3Dri") {
					$driveRankSum += 3;
					$matchCount++;
				}
			}
		}
	}
	if ($matchCount == 0) {
		$matchCount = 1;
	} else {
		$matchCount = $matchCount;
	}

	return ($driveRankSum / $matchCount);
}

function getAvgDefenseRank($teamNumber)
{
	$result = getAllLeadScoutData();
	$defenseRankSum = 0;
	$matchCount = 0;
	foreach ($result as $row_key => $row) {
		foreach ($row as $key => $value) {
			$num = $key;
			if ($value == $teamNumber) {
				if ($key == "team1Def") {
					$defenseRankSum += 1;
					$matchCount++;
				} else if ($key == "team2Def") {
					$defenseRankSum += 2;
					$matchCount++;
				} else if ($key == "team3Def") {
					$defenseRankSum += 3;
					$matchCount++;
				}
			}
		}
	}
	if ($matchCount == 0) {
		$matchCount = 1;
	} else {
		$matchCount = $matchCount;
	}

	return ($defenseRankSum / $matchCount);
}

function getAvgOffenseRank($teamNumber)
{
	$result = getAllLeadScoutData();
	$offenseRankSum = 0;
	$matchCount = 0;
	foreach ($result as $row_key => $row) {
		foreach ($row as $key => $value) {
			$num = $key;
			if ($value == $teamNumber) {
				if ($key == "team1Off") {
					$offenseRankSum += 1;
					$matchCount++;
				} else if ($key == "team2Off") {
					$offenseRankSum += 2;
					$matchCount++;
				} else if ($key == "team3Off") {
					$offenseRankSum += 3;
					$matchCount++;
				}
			}
		}
	}
	if ($matchCount == 0) {
		$matchCount = 1;
	} else {
		$matchCount = $matchCount;
	}

	return ($offenseRankSum / $matchCount);
}


function matchNum($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$matchNum = array();
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			array_push($matchNum, $teamData[8][$i][2]);
		}
	}else{
		for ($i = 0; $i != sizeof($teamData[9]); $i++) {
			array_push($matchNum, $teamData[9][$i][2]);
		}
	}
	sort($matchNum);
	return ($matchNum);
}

function defenseComments($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$defenseComments = array();
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			array_push($defenseComments, $teamData[8][$i][24]);
		}
	}else{
		for ($i = 0; $i != sizeof($teamData[10]); $i++) {
			array_push($defenseComments, $teamData[10][$i][15]);
		}
	}
	return ($defenseComments);
}

function matchComments($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$matchComments = array();
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			array_push($matchComments, $teamData[8][$i][25]);
		}
	}else{
		for ($i = 0; $i != sizeof($teamData[10]); $i++) {
			array_push($matchComments, $teamData[10][$i][16]);
		}
		for ($i = 0; $i != sizeof($teamData[9]); $i++) {
			array_push($matchComments, $teamData[9][$i][13]);
		}
	}
	return ($matchComments);
}


function getScore($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$matchN = matchNum($teamNumber);
	$cubeGraphT = array();
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$cubeGraphT[$teamData[8][$i][2]] = ((4 * ($teamData[8][$i][7])) + (2 * ($teamData[8][$i][9])) + (2 * ($teamData[8][$i][11])) + ($teamData[8][$i][13]) + (25 * ($teamData[8][$i][20])) + (25 * ($teamData[8][$i][21])) + (20 * ($teamData[8][$i][15])) + (10 * ($teamData[8][$i][16])) + (5 * ($teamData[8][$i][6])));
		}
	} else{
		for ($i = 0; $i != sizeof($teamData[9]); $i++) {
			$cubeGraphT[$teamData[9][$i][2]] = ((4 * ($teamData[9][$i][5])) + (2 * ($teamData[9][$i][7])) + (2 * ($teamData[9][$i][8])) + ($teamData[9][$i][10]) + (25 * ($teamData[10][$i][11])) + (25 * ($teamData[10][$i][12])) + (20 * ($teamData[9][$i][11])) + (10 * ($teamData[9][$i][12])) + (5 * ($teamData[10][$i][6])));
		}
	}
	$out = array();
	for ($i = 0; $i != sizeof($matchN); $i++) {
		array_push($out, $cubeGraphT[$matchN[$i]]);
	}
	return ($out);
}







function getPickList($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$pointCal = 0;
	$matchCount = 0;
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$pointCal = ($pointCal + (2 * ($teamData[8][$i][21])));
			$pointCal = ($pointCal + (2 * ($teamData[8][$i][20])));
			$pointCal = ($pointCal + (2 * ($teamData[8][$i][7])));
			$pointCal = ($pointCal + (1 * ($teamData[8][$i][9])));
			$pointCal = ($pointCal + (1 * ($teamData[8][$i][11])));
			$pointCal = ($pointCal + (0.5 * ($teamData[8][$i][13])));
			$pointCal = ($pointCal + (2 * ($teamData[8][$i][15])));
			$pointCal = ($pointCal + (1 * ($teamData[8][$i][16])));
			$pointCal = ($pointCal - (2 * ($teamData[8][$i][14])));
			$pointCal = ($pointCal - (1 * ($teamData[8][$i][12])));
			$pointCal = ($pointCal - (1 * ($teamData[8][$i][10])));
			$pointCal = ($pointCal - (0.5 * ($teamData[8][$i][8])));
			$matchCount++;
		}
	}else{
		for ($i = 0; $i != sizeof($teamData[9]); $i++) {
			$pointCal = ($pointCal + (2 * ($teamData[10][$i][12])));
			$pointCal = ($pointCal + (2 * ($teamData[10][$i][11])));
			$pointCal = ($pointCal + (2 * ($teamData[9][$i][5])));
			$pointCal = ($pointCal + (1 * ($teamData[9][$i][7])));
			$pointCal = ($pointCal + (1 * ($teamData[9][$i][8])));
			$pointCal = ($pointCal + (0.5 * ($teamData[9][$i][10])));
			$pointCal = ($pointCal + (2 * ($teamData[9][$i][11])));
			$pointCal = ($pointCal + (1 * ($teamData[9][$i][12])));
			$pointCal = ($pointCal - (0.5 * ($teamData[9][$i][6])));
			$pointCal = ($pointCal - (1 * ($teamData[9][$i][9])));
			$matchCount++;
		}
	}
	return (round(($pointCal / $matchCount), 3));
}


function getAvgPenalties($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$penalCount = 0;
	$matchCount  = 0;
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$penalCount = $penalCount + $teamData[8][$i][26];
			$matchCount++;
		}
	} else{
		for ($i = 0; $i != sizeof($teamData[10]); $i++) {
			$penalCount = $penalCount + $teamData[10][$i][17];
			$matchCount++;
		}
	}
	return ($penalCount / $matchCount);
}

function getTotalControlNumber($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$numberCount = 0;
	$matchCount  = 0;
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$numberCount = $numberCount + $teamData[8][$i][16];
			$matchCount++;
		}
	} else{
		for ($i = 0; $i != sizeof($teamData[9]); $i++) {
			$numberCount = $numberCount + $teamData[9][$i][12];
			$matchCount++;
		}
	}
	return ($numberCount);
}

function getTotalControlPosition($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$positionCount = 0;
	$matchCount  = 0;
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$positionCount = $positionCount + $teamData[8][$i][15];
			$matchCount++;
		}
	} else{
		for ($i = 0; $i != sizeof($teamData[9]); $i++) {
			$positionCount = $positionCount + $teamData[9][$i][11];
			$matchCount++;
		}
	}
	return ($positionCount);
}

function getControlPanelPosition($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$positionCount = getTotalControlPosition($teamNumber);

	if ($positionCount == 0){
		return "No";
	} else{
		return "Yes";
	}
	
}

function getControlPanelNumber($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$rotationCount  = getTotalControlNumber($teamNumber);

	if ($rotationCount == 0){
		return "No";
	} else{
		return "Yes";
	}
	
}


function getAvgCycleCount($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$cycleCount = 0;
	$matchCount  = 0;
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$cycleCount = $cycleCount + $teamData[8][$i][27];
			$matchCount++;
		}
	} else{
		for ($i = 0; $i != sizeof($teamData[10]); $i++) {
			$cycleCount = $cycleCount + $teamData[10][$i][18];
			$matchCount++;
		}
	}
	return ($cycleCount / $matchCount);
}

function getAvgScore($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$matchCount  = 0;
	$Score = 0;
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$Score = $Score + ((4 * ($teamData[8][$i][7])) + (2 * ($teamData[8][$i][9])) + (2 * ($teamData[8][$i][11])) + ($teamData[8][$i][13]) + (25 * ($teamData[8][$i][20])) + (25 * ($teamData[8][$i][21])) + (20 * ($teamData[8][$i][15])) + (10 * ($teamData[8][$i][16])) + (5 * ($teamData[8][$i][6])));
			$matchCount++;
		}
	} else{
		for ($i = 0; $i != sizeof($teamData[9]); $i++) {
			$Score = $Score + ((4 * ($teamData[9][$i][5])) + (2 * ($teamData[9][$i][7])) + (2 * ($teamData[9][$i][8])) + ($teamData[9][$i][10]) + (25 * ($teamData[10][$i][11])) + (25 * ($teamData[10][$i][12])) + (20 * ($teamData[9][$i][11])) + (10 * ($teamData[9][$i][12])) + (5 * ($teamData[10][$i][6])));
			$matchCount++;
		}
	}
	return ($Score / $matchCount);
}

function getTotalScore($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$matchCount  = 0;
	$Score = 0;
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$Score = $Score + ((4 * ($teamData[8][$i][7])) + (2 * ($teamData[8][$i][9])) + (2 * ($teamData[8][$i][11])) + ($teamData[8][$i][13]) + (25 * ($teamData[8][$i][20])) + (25 * ($teamData[8][$i][21])) + (20 * ($teamData[8][$i][15])) + (10 * ($teamData[8][$i][16])) + (5 * ($teamData[8][$i][6])));
			$matchCount++;
		}
	} else{
		for ($i = 0; $i != sizeof($teamData[9]); $i++) {
			$Score = $Score + ((4 * ($teamData[9][$i][5])) + (2 * ($teamData[9][$i][7])) + (2 * ($teamData[9][$i][8])) + ($teamData[9][$i][10]) + (25 * ($teamData[10][$i][11])) + (25 * ($teamData[10][$i][12])) + (20 * ($teamData[9][$i][11])) + (10 * ($teamData[9][$i][12])) + (5 * ($teamData[10][$i][6])));
			$matchCount++;
		}
	}
	return ($Score);
}

function getTotalDefense($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$defenseCount = 0;
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$defenseCount = $defenseCount + $teamData[8][$i][23];
		}
	} else{
		for ($i = 0; $i != sizeof($teamData[10]); $i++) {
			$defenseCount = $defenseCount + $teamData[10][$i][14];
		}
	}
	return ($defenseCount);
}


function getCorrectData($match, $alliance, $detail)
{
	// ************* Call API:
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://www.thebluealliance.com/api/v3/match/" . $match . "?X-TBA-Auth-Key=VPexr6soymZP0UMtFw2qZ11pLWcaDSxCMUYOfMuRj5CQT3bzoExsUGHuO1JvyCyU");
	curl_setopt($ch, CURLOPT_HEADER, 0);  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
	$json = curl_exec($ch);
	curl_close ($ch);
	$data = json_decode($json,true);

	if ($detail == "teleopCellsUpper"){
		return ($data["score_breakdown"]["$alliance"]["teleopCellsInner"] + $data["score_breakdown"]["$alliance"]["teleopCellsOuter"]);
	} else if($detail == "autoCellsUpper"){
		return ($data["score_breakdown"]["$alliance"]["autoCellsInner"] + $data["score_breakdown"]["$alliance"]["autoCellsOuter"]);
	} else{
		return $data["score_breakdown"]["$alliance"]["$detail"];
	}
	
}

function getThreePointNew($teamNumber)
{
	//chdir("js");
	$command = escapeshellcmd('python3 threecalcufinal.py');
	$output = shell_exec($command);

	$csvFile = file('ThreeOPR.txt');
    $data = array();
    foreach ($csvFile as $line) {
        $data[] = str_getcsv($line);
    }

	for($x = 0; $x < sizeof($data); $x++){
		$word = $data[$x][0];
		$word = substr($word, 3);
		if ($word == $teamNumber){
			return round($data[$x][1],2);
		}
	}
}

function getUpperTotal($teamNumber)
{
	//chdir("js");
	$command = escapeshellcmd('python3 uppercalcufinal.py');
	$output = shell_exec($command);

	$csvFile = file('upperOPR.txt');
    $data = array();
    foreach ($csvFile as $line) {
        $data[] = str_getcsv($line);
    }

	for($x = 0; $x < sizeof($data); $x++){
		$word = $data[$x][0];
		$word = substr($word, 3);
		if ($word == $teamNumber){
			return round($data[$x][1],2);
		}
	}
}

function getOPR($teamNumber)
{
	chdir("js");
	$command = escapeshellcmd('python3 oprcalcufinal.py');
	$output = shell_exec($command);

	$csvFile = file('OPR.txt');
    $data = array();
    foreach ($csvFile as $line) {
        $data[] = str_getcsv($line);
    }

	for($x = 0; $x < sizeof($data); $x++){
		$word = $data[$x][0];
		$word = substr($word, 3);
		if ($word == $teamNumber){
			return round($data[$x][1],2);
		}
	}
}