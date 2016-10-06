<?php 

	require("functions.php");
	

	if(!isset ($_SESSION["userId"])) {
		header("Location: login.php");
	}
	
	
	
	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login.php");
		
	}
	
	if (isset($_POST["note"]) &&
		isset($_POST["color"]) &&
		!empty($_POST["note"]) &&
		!empty($_POST["color"])
	) {
		
		saveNote($_POST["note"], $_POST["color"]);
	}
	
?>

<h1>Data</h1>
<p>
	Tere tulemast <?=$_SESSION["userEmail"];?>!
	<a href="?logout=1">Logi välja</a>
</p>

<h2>Märkmed</h2>
<form method="POST">
<textarea name="note" rows="4" cols="50" value="text"></textarea>
<br>
<input name="color" type="color" style="width: 370px; height: 30px">
<br><br>
 <input type="submit">
 </form>