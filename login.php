<?php 
	
	require("functions.php");
	
	
	if(isset ($_SESSION["userId"])) {
		header("Location: data.php");
	}
	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);
		
	$signupUsername = "";
	$signupUsernameError="";
		if(isset ($_POST["signupUsername"])) {
			if (empty ($_POST["signupUsername"])){
				$signupUsernameError="See väli on kohustuslik";
			} else {
				$signupUsername=$_POST["signupUsername"];
			}
		}
		
	$signupEmail = "";	
	$signupEmailError = "";
		if (isset ($_POST["signupEmail"])) {
			if (empty ($_POST["signupEmail"])) {	
				$signupEmailError = "See väli on kohustuslik";	
			} else {
				$signupEmail = $_POST["signupEmail"];
			}
		}
	
	$signupPasswordError = "";
		if (isset ($_POST["signupPassword"])) {
			if (empty ($_POST["signupPassword"])) {
			$signupPasswordError = "See väli on kohustuslik";
			} else {
			if (strlen ($_POST["signupPassword"]) < 8 ) {	
				$signupPasswordError = "Parool peab olema vähemalt 8 tm pikk";
				}
			}
		}
	
	$loginEmail = "";
		if (isset ($_POST["loginEmail"])) {
			if (!empty ($_POST["loginEmail"])) {	
				$loginEmail = $_POST["loginEmail"];
			}
		}
	
	$gender = "";
	if(isset($_POST["gender"])) {
		if(!empty($_POST["gender"])){	
			$gender = $_POST["gender"];
		}
	}
	
	if ( isset($_POST["signupEmail"]) &&
		 isset($_POST["signupPassword"]) &&
		 $signupEmailError == "" && 
		 empty($signupPasswordError)
	   ) {
		
		
		echo "salvestan...<br>";
		echo "email ".$signupEmail."<br>";
		echo "parool ".$_POST["signupPassword"]."<br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		echo "räsi ".$password."<br>";
		
		
		signup($signupEmail, $password);
		
	}	
	
	
	$notice = "";
	
	if (	isset($_POST["loginEmail"]) && 
			isset($_POST["loginPassword"]) && 
			!empty($_POST["loginEmail"]) && 
			!empty($_POST["loginPassword"]) 
	) {
		$notice = login($_POST["loginEmail"], $_POST["loginPassword"]);
		
	}
	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sisselogimise leht</title>
	</head>
	<body>

		<h1>Logi sisse</h1>
		<p style="color:red;"><?php echo $notice; ?></p>
		<form method="POST">
			
			<label>Email</label><br>
			<input name="loginEmail" type="email" value="<?php echo $loginEmail ?>">
			
			<br><br>
			
			<label>Parool</label><br>
			<input name="loginPassword" type="password">
						
			<br><br>
			
			<input type="submit"><br><br>
		
		</form>
		
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script>
	$(document).ready(function(){
		$("#flip").click(function(){
			$("#panel").slideToggle("slow");
		});
	});
	</script>

	<style>
	#panel, #flip {
		padding: 5px;
		text-align: left;
		background-color: #FFFFFF;
		width:290px;
		
		
	}

	#panel {
		display: none;
		width:200px; 
	}
	</style>
		
		<div id="flip"><h2>Loo kasutaja</h2></div>
		<div id="panel">
		
		<form method="POST">
			
			<input placeholder="Kasjutajanimi" name="signupUsername" type="username" value="<?php echo $signupUsername ?>"><?php echo $signupUsernameError; ?><br><br>
			
			<input placeholder="Email" name="signupEmail" type="email" value="<?=$signupEmail;?>" > <?php echo $signupEmailError; ?>
			
			<br><br>
			
			<input placeholder="Parool" name="signupPassword" type="password"> <?php echo $signupPasswordError; ?>
						
			<br><br>
			
				<?php if ($gender == "female") { ?>
				<input type="radio" name="gender" value="female" checked > Naine<br>
			<?php } else { ?>
				<input type="radio" name="gender" value="female"> Naine<br>
			<?php } ?>
		
			
			
			<?php if ($gender == "male") { ?>
				<input type="radio" name="gender" value="male" checked > Mees<br>
			<?php } else { ?>
				<input type="radio" name="gender" value="male"> Mees<br><br>
			<?php } ?>
			
		
			<input type="submit" value="Loo kasutaja">
		
		</form>
		</div>

	</body>
</html>