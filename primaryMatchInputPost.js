function postwith(to){

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
    orangePersist.collection("avr").doc(id).set(nums);
    $.post( "primaryDataHandler.php", nums).done(function( data ) {
    });
}
