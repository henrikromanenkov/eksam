<?php
	// Loon andmebaasi �henduse
	require_once("../config_global.php");
	$database = "if15_henrrom";
	session_start();
	
		//v�tab andmed ja sisestab andmebaasi
	function createUser($user_email, $hash, $lastname, $firstname){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare('INSERT INTO user_info (email, password, lastname, firstname) VALUES (?, ?, ?, ?)');
		// asendame k�sim�rgid. ss - s on string email, s on string password
		$stmt->bind_param("ssss", $user_email, $hash, $lastname, $firstname);
		$stmt->execute();
		
		$stmt->close();
		$mysqli->close();
	}

	function loginUser($log_email, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT email, id FROM user_info WHERE email=? AND password=?");
		$stmt->bind_param("ss", $log_email, $hash);
		//muutujad tulemustele
		$stmt->bind_result($email_from_db, $id_from_db);
		$stmt->execute();
		//kontrolli, kas tulemus leiti
		if($stmt->fetch()){
			//ab'i oli midagi
			echo "Email ja parool �iged, kasutaja id=".$id_from_db;	
			
			//tekitan sessiooni muutujad
			$_SESSION["logged_in_user_id"] = $id_from_db;
			$_SESSION["logged_in_user_email"] = $email_from_db;
			
			//suunan data.php lehele
			header("Location: data.php");
			
		}else{
			//ei leidnud
			echo "wrong credentials";
		}			
		$stmt->close();
		$mysqli->close();	
	}
	
	
	
	function addCake($cake, $pices, $price){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO cake (user_id, name, pices, price) VALUES (?,?,?,?)");
		$stmt->bind_param("isii", $_SESSION["logged_in_user_id"], $cake, $pices, $price);
		
		//S�num
		$message = "";
		
		if($stmt->execute()){
			//kui on t�ene siis INSERT �nnestut
			$message = "Sai edukalt lisatud";
			
		}else{
			// kui on v��r, siis kuvame error
			echo $stmt->error;
		}
		return $message;
		
		$stmt->close();
		$mysqli->close();
	}
	
		function addDayCake($daycake, $date){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO daycake (cakename, date) VALUES (?, ?)");
		$stmt->bind_param("ss", $daycake, $date);
		
		//S�num
		$message = "";
		
		if($stmt->execute()){
			//kui on t�ene siis INSERT �nnestut
			$message = "Sai edukalt lisatud";
			
		}else{
			// kui on v��r, siis kuvame error
			echo $stmt->error;
		}
		return $message;
		
		$stmt->close();
		$mysqli->close();
	}
	
	
	
	
	function getCakeData($keyword=""){

		$search = "%%";
		
		if($keyword == ""){

		}else{
			//otsin
			echo"Otsin ".$keyword;
			$search = "%".$keyword."%";
		}
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, name, pices, price from cake WHERE deleted IS NULL AND (name LIKE ?)");
		$stmt->bind_param("s", $search);
		$stmt->bind_result($id, $cake, $pices, $price);
		$stmt->execute();
		
		//tekitan t�hja massiivi, kus edaspidi hoian objekte 
		$cake_array = array();
		
		//tee midagi seni, kuni saad ab'st �he rea andmeid.
		while($stmt->fetch()){
			//seda siin sees tehakse nii mitu korda kui on ridu.
			
			//tekitan objekti; kus hakkan hoidma v��rtusi
			$post = new StdClass();
			$post->id = $id;
			$post->name = $cake;
			$post->pices = $pices;
			$post->price = $price;
			
			//lisan massiivi
			array_push($cake_array, $post);
			//var_dump �tleb muutuja t��bi ja sisu
			//echo "<pre>";
			//var_dump($car_array);
			//echo "</pre><br>";
		}
		
		//tagastan massiivi, kus k�ik read sees
		return $cake_array;
			
		$stmt->close();
		$mysqli->close();
	}
	
	
	
	
	function getDayCakeData($keyword=""){

		$search = "%%";
		
		if($keyword == ""){

		}else{
			//otsin
			echo"Otsin ".$keyword;
			$search = "%".$keyword."%";
		}
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, cakename, date from daycake WHERE (cakename LIKE ?)");
		$stmt->bind_param("s", $search);
		$stmt->bind_result($id, $daycake, $date);
		$stmt->execute();
		
		//tekitan t�hja massiivi, kus edaspidi hoian objekte 
		$daycake_array = array();
		
		//tee midagi seni, kuni saad ab'st �he rea andmeid.
		while($stmt->fetch()){
			//seda siin sees tehakse nii mitu korda kui on ridu.
			
			//tekitan objekti; kus hakkan hoidma v��rtusi
			$post = new StdClass();
			$post->id = $id;
			$post->cakename = $daycake;
			$post->cake_date = $date;
			
			//lisan massiivi
			array_push($daycake_array, $post);
			//var_dump �tleb muutuja t��bi ja sisu
			//echo "<pre>";
			//var_dump($car_array);
			//echo "</pre><br>";
		}
		
		//tagastan massiivi, kus k�ik read sees
		return $daycake_array;
			
		$stmt->close();
		$mysqli->close();
	}
	
	
	function createDropdown(){
		
		$html = '';
		
		$html .= '<select name="daycake">';
		//$html .= '<option selected>3</option>';
		//$stmt = $this->connection->prepare("SELECT id, name FROM interests");
		//kuvame ainult puuduolevad huvialad
		// EI T��TA KORRALIKULT
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare(" SELECT id, name FROM cake ");
		//$stmt->bind_param("s", $cake);
		$stmt->bind_result($id, $name);
		$stmt->execute();
		
		//iga rea kohta, mis on ab'is
		while($stmt->fetch()){
			$html .= '<option value="'.$name.'">'.$name.'</option>';
		}
		
		
		$html .= '</select>';
		return $html;
		
	}
	
	
	
	function deleteCake($cake){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE cake SET deleted=NOW() WHERE name=?");
		$stmt->bind_param("s", $cake);
		if($stmt->execute()){
			
			header("Location: table.php");
		}
		$stmt->close();
		$mysqli->close();
	}
	
	function updateCake($cake, $id){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE cake SET name=? WHERE id=?");
		$stmt->bind_param("si", $cake, $id );
		if($stmt->execute()){

			//header("Location: table.php");
		}
		$stmt->close();
		$mysqli->close();
	}


?>