<?php
	require_once("player.php"); 
	$player_name = '';

	$player_name = htmlentities($_POST['player_name']);

    //player's name has to be longer than 1 character to be processed 
	if (strlen($player_name) > 0){
    	$data = findPlayer($player_name);
    	$allPlayers = array();
    	foreach($data as $player){
    		$playerData = array();
    		$playerData["Name"] = $player->getName();
    		$playerData["Fname"] = $player->getFname();
    		$playerData["Lname"] = $player->getLname();
    		$playerData["Team"] = $player->getTeam();
    		$playerData["GP"] = $player->getGamesPlayed();
    		$playerData["FG_M"] = $player->getFieldGoalsMade();
    		$playerData["PPG"] = $player->getAvgGamePoints();
            $playerData["FTM"] = $player->getFTM();
            $playerData["PF"] = $player->getPF();
    		$allPlayers[] = $playerData;
    	}

        //print out the json encoded data to that we can capture it on the front end 
    	echo json_encode($allPlayers);
  	}else{

        $allPlayers = array("player's name is blank");
        echo json_encode($allPlayers);
    }
?>