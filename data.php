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
		
		if(empty($_POST["name"]) ){
			$cake_error = " See väli on kohustuslik.";
		}else{
			$cake = cleanInput($_POST["name"]);
		}
		
		if(	$cake_error == ""){
	
			$msg = addCake($cake);
			
			if($msg != ""){
				$cake = "";
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
	<label for="cake">kook</label><br>
	<input name="cake" id="name" type="text"  value="<?php echo $cake; ?>">* <?php echo $cake_error; ?> <br><br>
	<input name="pices" id="pices" type="text"  value="<?php echo $pices; ?>">*  <br><br>
	<input name="price" id="price" type="text"  value="<?php echo $price; ?>">* <br><br>
	<input name="add_tweet" type="submit" value="Salvesta">
	<input name="change_tweet" type="submit" value="Muuda" onclick="window.open('table.php')">
</form>

<h2>Säutsud</h2>

<?php
	require_once("functions.php");
	
	if(isset($_GET["delete"])){
		
		echo "Kustutame id".$_GET["delete"];
		deleteCake($_GET["delete"]);	
	}
	
	if(isset($_POST["save"])){
		
		updateCake($_POST["id"],$_POST["cake"]);
	}
	
	$keyword = "";
	if(isset($_GET["keyword"])){
		
		$keyword = ($_GET["keyword"]); 
		$array_of_cake = getCakeData($keyword);
	}else{
		
		$array_of_cake = getCakeData();
	}
?>
<table border="1">
	<tr>
		<th>koogi nimi</th>
		<th>Tükkide arv</th>
		<th>Hind</th>

	</tr>
	
	<?php
		for($i = 0; $i < count($array_of_cake); $i++){

			
			if(isset($_GET["edit"]) && $array_of_cake[$i]->id == $_GET["edit"]){
				
				echo"<tr>";
				echo"<form action='table.php' method='post'>";
				echo "<input type='hidden' name='id' value='".$array_of_cake[$i]->id."'>";
				echo "<td>".$array_of_cake[$i]->name."</td>";
				echo "<td>".$array_of_cake[$i]->pices."</td>";
				echo "<td>".$array_of_cake[$i]->price."</td>";
				echo "<td><input name='cake' value='".$array_of_cake[$i]->name."'></td>";
				echo"</form>";
				echo"</tr>";
				
			}else{
				echo"<tr>";
				echo "<td>".$array_of_cake[$i]->name."</td>";
				echo "<td>".$array_of_cake[$i]->pices."</td>";
				echo "<td>".$array_of_cake[$i]->price."</td>";
				echo"</tr>";
			
			}
				
		}
	
	?>
</table>