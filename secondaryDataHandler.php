<?php
include("secondaryMatchInput.php");

function filter($str)
{
	return filter_var($str, FILTER_SANITIZE_STRING);
}
?>

<?php
if (isset($_POST['matchNum'])) {

	include("databaseLibrary.php");
	$user = filter($_POST['userName']);

	$matchNum = filter($_POST['matchNum']);
	$teamNum = filter($_POST['teamNum']);
	$allianceColor = filter($_POST['allianceColor']);
	$autoPath = filter($_POST['autoPath']);
	$crossLineA = filter($_POST['crossLineA']);
    $teleopPath = filter($_POST['teleopPath']);
	$ID = $matchNum . "-" . $teamNum;

	$climb = filter($_POST['climb']);
	$climbTwo = filter($_POST['climbTwo']);
	$climbThree = filter($_POST['climbThree']);
	$climbCenter = filter($_POST['climbCenter']);
	$climbSide = filter($_POST['climbSide']);

	$issues = filter($_POST['issues']);
	$defenseBot = filter($_POST['defenseBot']);
	$defenseComments = filter($_POST['defenseComments']);
	$matchComments = filter($_POST['matchComments']);
	$penalties = filter($_POST['penalties']);
	$cycleNumber = filter($_POST['cycleNumber']);

	secondaryMatchInput(
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
	);
}


?>
<script>
	function getSecondaryMatchData() {
		$.ajax({
			type: "POST",
			url: "beckythescout/secondaryDataHandler.php?matchData:",
			data: JSON.stringify(nums),
			success: success,
		});
	}
</script>