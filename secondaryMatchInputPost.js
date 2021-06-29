function postwith(to){

    var nums = {
    'userName' : document.getElementById('userName').value,
    'matchNum' : document.getElementById('matchNum').value,
    'teamNum' : document.getElementById('teamNum').value,
    'allianceColor' : document.getElementById('allianceColor').value,
    'autoPath' : JSON.stringify(coordinateList),
    'crossLineA' : document.getElementById('crossLineA').checked?1:0,
    'teleopPath' : JSON.stringify(coordinateList),

    'climb' : climb,
    'climbTwo' : climbTwo,
    'climbThree' : climbThree,
    'climbCenter' : document.getElementById('climbCenter').checked?1:0,
    'climbSide' : document.getElementById('climbSide').checked?1:0,

    'issues' : document.getElementById('issues').value,
    'defenseBot' : document.getElementById('defenseBot').checked?1:0,
    'defenseComments' : document.getElementById('defenseComments').value,
    'matchComments' : document.getElementById('matchComments').value,
    'cycleNumber': cycleNumber
    };

    var id = document.getElementById('matchNum').value + "-" + document.getElementById('teamNum').value;
    console.log(JSON.stringify(nums));
    orangePersist.collection("avr").doc(id).set(nums);
    $.post( "secondaryDataHandler.php", nums).done(function( data ) {
    });
}
