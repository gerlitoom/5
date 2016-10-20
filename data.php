<?php 

	require("functions.php");
	

	if(!isset ($_SESSION["userId"])) {
		header("Location: login.php");
	}
	
	
	
	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login.php");
		exit();
	}
	
	
	
	if (isset($_POST["note"]) &&
		isset($_POST["color"]) &&
		!empty($_POST["note"]) &&
		!empty($_POST["color"])
	) {
		$note = cleanInput($_POST["note"]);
		saveNote($note, $_POST["color"]);
	}
	$notes = getAllNotes();
	
	//echo "<pre>";
	//var_dump($notes);
	//echo "<pre>";
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
<input name="color" type="color" style="width: 70px; height: 30px" value="#FFFCC2">
<br><br>
 <input type="submit">
 </form>
 
 <h2>Arhiiv</h2>
 
 <?php
 
	foreach ($notes as $n) {
		$style = "width:100px; min-height:100px; border: 1px solid grey; background-color:".$n->noteColor.";";
		echo "<p style='  ".$style."  '>".$n->note."</p>";
	}
 
 ?>
 
 <h2 style="clear:both;">Tabel</h2>
 <?php
	
	$html = "<table>";
	
		$html .= "<tr>";
			$html .= "<th>id</th>";
			$html .= "<th>märkus</th>";
			$html .= "<th>värv</th>";
		$html .= "</tr>";
	
	foreach ($notes as $note) {	
		$html .= "<tr>";
			$html .= "<td>".$note->id."</td>";
			$html .= "<td>".$note->note."</td>";
			$html .= "<td>".$note->noteColor."</td>";
		$html .= "</tr>";
	}
	
	$html .= "</table>";
	echo $html;
 
 ?>