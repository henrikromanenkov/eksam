<?php
	require_once("functions.php");

	if(!isset($_SESSION["logged_in_user_id"])){
			//header("Location: login.php");
	}

	if(isset($_GET["logout"])){
	
	session_destroy();
		
		header("Location: login.php");
	}
	
	
	$pices = "";
	$price = "";
	$cake = "";
	$cake_error = "";
	
	if(isset($_POST["add_cake"])){
		  

		  
		if(empty($_POST["cake"]) ){
			$cake_error = " See väli on kohustuslik.";
		}else{
			$cake = cleanInput($_POST["cake"]);
		}
		
		if(	$cake_error == ""){	
			$msg = addCake($_POST["cake"], $_POST["pices"], $_POST["price"]);
			
			if($msg != ""){
				$cake = "";
				echo "$msg";
				
			}
			
		}	
	}	
	
	$date ="";
	$daycake ="";
	$daycake_error = "";
	
	if(isset($_POST["add_daycake"])){
		  

		  
		if(empty($_POST["daycake"]) ){
			$daycake_error = " See väli on kohustuslik.";
		}else{
			$cake = cleanInput($_POST["daycake"]);
		}
		
		if(	$daycake_error == ""){	
			$msg = addDayCake($_POST["daycake"], $_POST["date"]);
			
			if($msg != ""){
				$daycake = "";
				echo "$msg";
				
			}
			
		}	
	}
	function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
	
?>
<p>	Tere,  <?=$_SESSION["logged_in_user_email"];?>
	<a href="?logout=1"> Logi välja</a> 
</p> 
	
	
<h2>Lisa kook</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<input name="cake" id="cake" type="text"  value="<?php echo $cake; ?>">* <?php echo $cake_error; ?> <br><br>
	<input name="pices" id="pices" type="text"  value="<?php echo $pices; ?>">*  <br><br>
	<input name="price" id="price" type="text"  value="<?php echo $price; ?>">* <br><br>
	<input name="add_cake" type="submit" value="Salvesta">
	<input name="change_cake" type="submit" value="Muuda" onclick="window.open('table.php')">
</form>

<h2>Lisa päevakook</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<!--<input name="daycake" id="daycake" type="text"  value="<?php echo $daycake; ?>">* <?php echo $daycake_error; ?> -->
	<?php echo createDropdown(); ?>
	<br><br>
	<input name="date" id="date" type="text"  value="<?php echo $date; ?>">* <br><br>
	<input name="add_daycake" type="submit" value="Salvesta">
	<input name="change_cake" type="submit" value="Muuda" onclick="window.open('table.php')">
</form>
