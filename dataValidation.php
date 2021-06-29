<!DOCTYPE html>

<html>
<?php
include("header.php")?>
<body>
<?php include("navBar.php")?>
<div id="content">
<div class="container row-offcanvas row-offcanvas-left">
<div class="well column  col-lg-112  col-sm-12 col-xs-12" id="content">
<h1>Data Validation</h1>
	<form action="" method="get">
	Enter Match Number: 
	<input type="text" name="match" id="match" size="8">
	<button id="submit" class="btn btn-primary" onclick="">Display</button>
	<br>
	<br>
<?php
	include("databaseLibrary.php");
        
       $result = getAllMatchData();
       if ($result != null){
        $totalAutoUpper = 0;
        $totalTeleopUpper = 0;
        $totalAutoLower = 0;
        $totalTeleopLower = 0;
        $climb = 0;

        $totalredAutoUpper = 0;
         $totalredTeleopUpper = 0;
         $totalredAutoLower = 0;
         $totalredTeleopLower = 0;
         $climbred = 0;

        echo('<div><table  class="table table-hover" id="RawData" border="1"></div>');
        foreach ($result as $row_key => $row){
                if($i==0){
                        echo("<tr>");
                        foreach ($row as $key => $value){
                                        if(!is_numeric($key) && $key != "autoPath"){
                                            echo("<td>".$key."</td>");
                                        }
                                }
                        $i++;
                        echo("</tr>");                
                }
                echo("<tr>");        
                         foreach ($row as $key => $value) {
                                 if(!is_numeric($key) and $row["matchNum"] == $_GET["match"] and $row["allianceColor"] == "blue"){
                                         if($key == "matchNum"){
                                              $value= '<a href="matchData.php?match='.$value.'">'.$value.'</a>';
                                                echo("<td align='center'>".$value."</td>");
                                        }else if($key != "cycleNumber" && ($key != "autoPath") && ($key != "teleopPath")){
                                            echo("<td align='center'>".$value."</td>");
                                         }
                                        if (($key == "upperGoal")){
                                            $totalAutoUpper += $value;
                                        }
                                        if(($key == "upperGoalT")){
                                            $totalTeleopUpper += $value;
                                        }
                                        if(($key == "lowerGoal")){
                                            $totalAutoLower += $value;
                                        }
                                        if(($key == "lowerGoalT")){
                                            $totalTeleopLower += $value;
                                        }
                                        if(($key == "climbCenter")){
                                            $climb += $value;
                                        }
                                        if(($key == "climbSide")){
                                            $climb += $value;
                                        }
                                                                             
                                                                             
                            }
                    } 
                    foreach ($row as $key => $value) {
                        if(!is_numeric($key) and $row["matchNum"] == $_GET["match"] and $row["allianceColor"] == "red"){
                                if($key == "matchNum"){
                                     $value= '<a href="matchData.php?match='.$value.'">'.$value.'</a>';
                                       echo("<td align='center'>".$value."</td>");
                               }else if($key != "cycleNumber" && ($key != "autoPath") && ($key != "teleopPath")){
                                   echo("<td align='center'>".$value."</td>");
                                }
                               if (($key == "upperGoal")){
                                   $totalredAutoUpper += $value;
                               }
                               if(($key == "upperGoalT")){
                                   $totalredTeleopUpper += $value;
                               }
                               if(($key == "lowerGoal")){
                                   $totalredAutoLower += $value;
                               }
                               if(($key == "lowerGoalT")){
                                   $totalredTeleopLower += $value;
                               }
                               if(($key == "climbCenter")){
                                    $climbred += $value;
                                }
                                if(($key == "climbSide")){
                                    $climbred += $value;
                                }
                                                                    
                                                                    
                   }
           }        
                echo("</tr>");                
                }
                echo("</table>");
        }

                 $result = getAllNewMatchData();
                 if ($result != null){
                $totalAutoUpper = 0;
                $totalTeleopUpper = 0;
                $totalAutoLower = 0;
                $totalTeleopLower = 0;
                $climb = 0;

                $totalredAutoUpper = 0;
                 $totalredTeleopUpper = 0;
                 $totalredAutoLower = 0;
                 $totalredTeleopLower = 0;
                 $climbred = 0;
            echo('<div><table  class="table table-hover" id="RawData" border="1"></div>');
            foreach ($result as $row_key => $row){
                    if($i==0){
                            echo("<tr>");
                            foreach ($row as $key => $value){
                                         if((!is_numeric($key) && $key != "cycleNumber") && (($key != "autoPath") && ($key != "teleopPath"))){
                                            echo("<td>".$key."</td>");
                                                                             }
                                    }
                            $i++;
                            echo("</tr>");                
                    }
                    echo("<tr>");        
                         foreach ($row as $key => $value) {
                                 if(!is_numeric($key) and $row["matchNum"] == $_GET["match"] and $row["allianceColor"] == "blue"){
                                         if($key == "matchNum"){
                                              $value= '<a href="matchData.php?match='.$value.'">'.$value.'</a>';
                                                echo("<td align='center'>".$value."</td>");
                                        }else if($key != "cycleNumber" && ($key != "autoPath") && ($key != "teleopPath")){
                                            echo("<td align='center'>".$value."</td>");
                                         }
                                        if (($key == "upperGoal")){
                                            $totalAutoUpper += $value;
                                        }
                                        if(($key == "upperGoalT")){
                                            $totalTeleopUpper += $value;
                                        }
                                        if(($key == "lowerGoal")){
                                            $totalAutoLower += $value;
                                        }
                                        if(($key == "lowerGoalT")){
                                            $totalTeleopLower += $value;
                                        }
                                        if(($key == "climbCenter")){
                                            $climb += $value;
                                        }
                                        if(($key == "climbSide")){
                                            $climb += $value;
                                        }
                                                                             
                                                                             
                            }
                    } 
                    foreach ($row as $key => $value) {
                        if(!is_numeric($key) and $row["matchNum"] == $_GET["match"] and $row["allianceColor"] == "red"){
                                if($key == "matchNum"){
                                     $value= '<a href="matchData.php?match='.$value.'">'.$value.'</a>';
                                       echo("<td align='center'>".$value."</td>");
                               }else if($key != "cycleNumber" && ($key != "autoPath") && ($key != "teleopPath")){
                                   echo("<td align='center'>".$value."</td>");
                                }
                               if (($key == "upperGoal")){
                                   $totalredAutoUpper += $value;
                               }
                               if(($key == "upperGoalT")){
                                   $totalredTeleopUpper += $value;
                               }
                               if(($key == "lowerGoal")){
                                   $totalredAutoLower += $value;
                               }
                               if(($key == "lowerGoalT")){
                                   $totalredTeleopLower += $value;
                               }
                               if(($key == "climbCenter")){
                                    $climbred += $value;
                                }
                                if(($key == "climbSide")){
                                    $climbred += $value;
                                }
                                                                    
                                                                    
                   }
           }
                    echo("</tr>");                
                 }
                 echo("</table>");
                }

                  $match = "2020caln_qm" .$_GET["match"];

                  if (getCorrectData($match, "red", "teleopCellsUpper") == $totalredTeleopUpper){

                }else{
                    echo "total red Teleop Upper is incorrect";
                }
                  if (getCorrectData($match, "red", "autoCellsUpper") == $totalredAutoUpper){
               
                }else{
                    echo "total red Auto Upper is incorrect";
                }
                  if (getCorrectData($match, "red", "autoCellsBottom") == $totalredAutoLower){
    
                }else{
                    echo "total red Auto Lower is incorrect";
                }
                  if (getCorrectData($match, "red", "teleopCellsBottom") == $totalredTeleopLower){
        
                }else{
                    echo "total red Teleop Lower is incorrect";
                }

                  if (getCorrectData($match, "blue", "teleopCellsUpper") == $totalTeleopUpper){
    
                }else{
                    echo "total blue Teleop Upper is incorrect";
                }
                if (getCorrectData($match, "blue", "autoCellsUpper") == $totalAutoUpper){

                }else{
                    echo "total blue Auto Upper is incorrect";
                }
                if (getCorrectData($match, "blue", "autoCellsBottom") == $totalAutoLower){
            
                }else{
                    echo "total blue Auto Lower is incorrect";
                }
                if (getCorrectData($match, "blue", "teleopCellsBottom") == $totalTeleopLower){
              
                }else{
                    echo "total blue Teleop Lower is incorrect";
                }

                $blueClimbCheck;
                $redClimbCheck;

                if (getCorrectData($match, "blue", "endgameRobot1") == "Hang"){
                    $blueClimbCheck += 1;
                }
                if (getCorrectData($match, "blue", "endgameRobot2") == "Hang"){
                    $blueClimbCheck += 1;
                }
                if (getCorrectData($match, "blue", "endgameRobot3") == "Hang"){
                    $blueClimbCheck += 1;
                }
                if (getCorrectData($match, "red", "endgameRobot1") == "Hang"){
                    $redClimbCheck += 1;
                }
                if (getCorrectData($match, "red", "endgameRobot2") == "Hang"){
                    $redClimbCheck += 1;
                }
                if (getCorrectData($match, "red", "endgameRobot3") == "Hang"){
                    $redClimbCheck += 1;
                }
                if ($redClimbCheck != $climbred){
                    echo "red climb incorrect";
                }
                if ($blueClimbCheck != $climb){
                    echo "blue climb incorrect";
                }
                 

        
                 
?>
</div>
</div>
</div>


</body>
</html>

<?php include("footer.php") ?>