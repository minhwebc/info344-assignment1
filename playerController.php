<?php
	//findPlayer will take in a player name and find all the players who match the given name
	function findPlayer($player_name){
		try {
			$dsn = 'mysql:host=mydbinstance.c1twv2grp5l4.us-west-2.rds.amazonaws.com;port=3306;dbname=players';
			$username = 'minhwebc';
			$password = 'jimnan8987718';
			$dbh = new PDO($dsn, $username, $password);
			$query = "SELECT * FROM StatsCleaned WHERE Name LIKE ? OR levenshtein(?, `Name`) BETWEEN 0 AND 4;";
			$params = array("%$player_name%", "$player_name");
			$stmt = $dbh->prepare($query);
			$stmt->execute($params);
			$players = $stmt->fetchAll();
		    $dbh = null;
		    $playersResult = array();
		    foreach($players as $player){
		    	$playersResult[] = new Player($player["Name"], $player["Team"], $player["GP"], $player["FG_M"], $player["PPG"], $player["Fname"], $player["Lname"], $player["FT_M"], $player["PF"]);
		    };
		    return $playersResult;
		} catch (PDOException $e) {
		    print "Error!: " . $e->getMessage() . "<br/>";
		    die();
		}
	}

	//Player class will have full name, team, number of games played, field goals made, avg game point
	//first name, last name, free throws made and personal fouls 
	class Player{
		private $name;
		private $team;
		private $gamesPlayed; 
		private $fieldGoalsMade; 
		private $avgGamePoints; 
		private $Fname;
		private $Lname;
		private $FTM; 
		private $PF;

		function __construct($name, $team, $gamesPlayed, $fieldGoalsMade, $avgGamePoints, $Fname, $Lname, $FT_M, $PF) {
	        $this->name = $name;
	        $this->team = $team;
	        $this->gamesPlayed = $gamesPlayed;
	        $this->fieldGoalsMade = $fieldGoalsMade;
	        $this->avgGamePoints = $avgGamePoints; 
	        $this->Fname = $Fname; 
	        $this->Lname = $Lname;
	        $this->FT_M = $FT_M;
	        $this->PF = $PF;
	    }

	    //get the name of the player
	    public function getName(){
			return $this->name;
		}

		//get the last name of the player
		public function getFname(){
			return $this->Fname;
		}

		//get the number of the free throws made from the player 
		public function getFTM(){
			return $this->FT_M;
		}

		//get the number of personal fouls from the player
		public function getPF(){
			return $this->PF;
		}

		//get the last name of the player
		public function getLname(){
			return $this->Lname;
		}

		//get the team of the player plays in
		public function getTeam(){
			return $this->team;
		}

		//get the number of games played by the player
		public function getGamesPlayed(){
			return $this->gamesPlayed;
		}

		//get the number field goals made by the player
		public function getFieldGoalsMade(){
			return $this->fieldGoalsMade;
		}

		//get the average points of the player
		public function getAvgGamePoints(){
			return $this->avgGamePoints;
		}
	} 
?>