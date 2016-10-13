<?php 
	require("../../config.php");
	session_start();
	
	
	$database = "if16_gerltoom";
	
	//var_dump($GLOBALS);
	
	function signup($email, $password) {
		
		$mysqli = new mysqli(
		
		$GLOBALS["serverHost"], 
		$GLOBALS["serverUsername"],  
		$GLOBALS["serverPassword"],  
		$GLOBALS["database"]
		
		);
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?, ?)");
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $email, $password );
		if ( $stmt->execute() ) {
			echo "salvestamine õnnestus";	
		} else {	
			echo "ERROR ".$stmt->error;
		}
		
	}
	
	
	function login($email, $password) {
		
		$notice = "";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],  $GLOBALS["serverPassword"],  $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
		
			SELECT id, email, password, created
			FROM user_sample
			WHERE email = ?
		
		");

		$stmt->bind_param("s", $email);
		

		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		
		$stmt->execute();
		
	
		if ($stmt->fetch()) {
			
	
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDb) {
	
				echo "Kasutaja ".$id." logis sisse";
				
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				
				header("Location: data.php");
				
			} else {
				$notice = "Vale parool!";
			}
			
		} else {
			$notice = "Sellist emaili ei ole!";
		}
		
		return $notice;
	}
	
	function saveNote($note, $color) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],  $GLOBALS["serverPassword"],  $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO colorNotes (note, color) VALUES (?, ?)");
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $note, $color );
		if ( $stmt->execute() ) {
			echo "salvestamine õnnestus";	
		} else {	
			echo "ERROR ".$stmt->error;
		}
		
	}
	
	function getAllNotes() {
		
		$mysqli=new mysqli ($GLOBALS["serverHost"],$GLOBALS["serverUsername"],  $GLOBALS["serverPassword"],  $GLOBALS["database"]);
		$stmt = $mysqli->prepare("
			SELECT id, note, color
			FROM colorNotes
		");
		$stmt->bind_result($id, $note, $color);
		$stmt->execute();
		
		$result = array();
		
		while($stmt->fetch()) {
			//echo $note."<br>";
			
			$object = new StdClass();
			$object ->id = $id;
			$object ->note = $note;
			$object ->noteColor = $color;
			
			array_push($result, $object);
		}
		return $result;
	}
	
	
	function cleanInput ($input){
		
		$input= trim($input);
		$input= stripslashes($input);
		$input= htmlspecialchars($input);
		return $input;
		
	}
	
	
?>