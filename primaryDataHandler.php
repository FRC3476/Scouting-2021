<?php
include("primaryMatchInput.php");

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
    $ID = $matchNum . "-" . $teamNum;

    $upperGoal = filter($_POST['upperGoal']);
    $upperGoalMiss = filter($_POST['upperGoalMiss']);
    $lowerGoal = filter($_POST['lowerGoal']);

    $upperGoalT = filter($_POST['upperGoalT']);
    $upperGoalMissT = filter($_POST['upperGoalMissT']);
    $lowerGoalT = filter($_POST['lowerGoalT']);

    $controlPanelPosT = filter($_POST['controlPanelPosT']);
    $controlPanelNumT = filter($_POST['controlPanelNumT']);

    $matchComments = filter($_POST['matchComments']);
    $cycleNumber = filter($_POST['cycleNumber']);


    primaryMatchInput(
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
    );
}


?>
<script>
    function getPrimaryMatchData() {
        $.ajax({
            type: "POST",
            url: "beckythescout/primaryDataHandler.php?matchData:",
            data: JSON.stringify(nums),
            success: success,
        });
    }
</script>