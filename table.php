<?php
	
	require_once("functions.php");
	
	if(isset($_GET["delete"])){
		
		echo "Kustutame id".$_GET["delete"];
		deleteCake($_GET["delete"]);	
	}
	
	if(isset($_POST["save"])){
		updateCake($_POST["name"], $_POST["id"]);
	}
	
	$keyword = "";
	if(isset($_GET["keyword"])){
		
		$keyword = ($_GET["keyword"]); 
		$array_of_cake = getCakeData($keyword);
	}else{
		
		$array_of_cake = getCakeData();
	}
	
	$keyword = "";
	if(isset($_GET["keyword"])){
		
		$keyword = ($_GET["keyword"]); 
		$array_of_daycake = getDayCakeData($keyword);
	}else{
		
		$array_of_daycake = getDayCakeData();
	}
	
?>

<h2>Minu koogid</h2>

<form action="table.php" method="get">
	<input type="search" name="keyword" value="<?=$keyword;?>">
	<input type="Submit" value="Otsi">
	<input type="Submit" value="Tagasi" onclick="window.open('data.php')">
</form>
<table border="1">
	<tr>
		<th>Koogi nimi</th>
		<th>Tükkide arv</th>
		<th>hind</th>
		<th>Kustuta</th>
		<th>Muuda</th>
	</tr>
	
	<?php
		//trükime välja read
		// massiivi pikkus count()
		for($i = 0; $i < count($array_of_cake); $i++){
			//echo $array_of_cars[$i]->id;
			//echo "<tr>";
			
				
			if(isset($_GET["edit"]) && $array_of_cake[$i]->name == $_GET["edit"]){
			
			echo"<tr>";
			echo"<form action='table.php' method='post'>";
			echo "<input type='hidden' name='id' value='".$array_of_cake[$i]->id."'>";
			echo "<td><input name='name' value='".$array_of_cake[$i]->name."'></td>";
			echo "<td><input name='pices' value='".$array_of_cake[$i]->pices."'></td>";
			echo "<td><input name='price' value='".$array_of_cake[$i]->price."'></td>";
			echo "<td><a href ='table.php'>cancel</a></td>";
			echo "<td><input type='submit' name='save'></td>";
			echo"</form>";
			echo"</tr>";
			
			}else{
			echo"<tr>";
			echo "<td>".$array_of_cake[$i]->name."</td>";
			echo "<td>".$array_of_cake[$i]->pices."</td>";
			echo "<td>".$array_of_cake[$i]->price."</td>";
			echo "<td> <a href ='?delete=".$array_of_cake[$i]->name."'>X</a></td>";
			echo "<td> <a href ='?edit=".$array_of_cake[$i]->name."'>edit</a></td>";
			echo"</tr>";
			}
			
		
				
		}
	
	?>
</table>

<h2>Päevakoogid</h2>


<form action="table.php" method="get">
	<input type="search" name="keyword" value="<?=$keyword;?>">
	<input type="Submit" value="Otsi">
	<input type="Submit" value="Tagasi" onclick="window.open('data.php')">
</form>
<table border="1">
	<tr>
		<th>Koogi nimi</th>
		<th>Kuupäev</th>
	</tr>
	
	<?php
		//trükime välja read
		// massiivi pikkus count()
		for($i = 0; $i < count($array_of_daycake); $i++){
			//echo $array_of_cars[$i]->id;
			//echo "<tr>";
			
				
			if(isset($_GET["edit"]) && $array_of_daycake[$i]->cakename == $_GET["edit"]){
			
			echo"<tr>";
			echo"<form action='table.php' method='post'>";
			echo "<input type='hidden' name='id' value='".$array_of_cake[$i]->id."'>";
			echo "<td><input name='name' value='".$array_of_daycake[$i]->cakename."'></td>";
			echo "<td><input name='cake_date' value='".$array_of_daycake[$i]->date."'></td>";
			echo"</form>";
			echo"</tr>";
			
			}else{
			echo"<tr>";
			echo "<td>".$array_of_daycake[$i]->cakename."</td>";
			echo "<td>".$array_of_daycake[$i]->cake_date."</td>";
			echo"</tr>";
			}
			
		
				
		}
	
	?>
</table>