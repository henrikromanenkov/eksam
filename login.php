<?php
	
	require_once("functions.php");
	
	//kui kasutaja on issse loginud; siisi suunan data.php lehele
	if(isset($_SESSION["logged_in_user_id"])){
		header("Location: data.php");
	}
	
	
	//muutujad errorite jaoks
	$log_email_error = "";
	$user_email_error = "";
	$log_password_error = "";
	$user_password_error = "";
	$lastname_error = "";
	$firstname_error = "";
	
	//muutujad ab väärtuste jaoks
	$log_email = "";
	$user_email = "";
	$lastname = "";
	$firstname = "";
	$log_password = "";
	$user_password = "";
	
	//kontrollime, et keegi vajutas input nuppu.
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		//echo "Keegi vajutas nuppu";
		
		//keegi vajutas login nuppu
		if(isset($_POST["login"])){
			
			echo "Vajutas login nuppu!";
			
			//kontrollin, et e-post ei ole tühi
			if(empty($_POST["log_email"]) ){
				$log_email_error = " See väli on kohustuslik.";
			}else{
		// puhastame muutuja võimalikest üleliigsetest sümbolitest		
				$log_email = cleanInput($_POST["log_email"]);
			
			}	
				
			//kontrollin, et parool ei ole tühi
			if(empty($_POST["log_password"]) ){
				$log_password_error = "See väli on kohustuslik.";
			}else{
				$log_password = cleanInput($_POST["log_password"]);
			}
				
			// Kui oleme siia jõudnud, võime kasutaja sisse logida
			if($log_password_error == "" && $log_email_error == ""){
				echo "Võib sisse logida! Kasutajanimi on ".$log_email." ja parool on ".$log_password;
				
				$hash = hash("sha512", $log_password);
				
				//kasutaja sisselogimise funktsioon failist function.php
				loginUser($log_email, $hash);
				

				// login if end	
			}
			
		
		// keegi vajutas create  nuppu
		}elseif(isset($_POST["create"])){
			
			echo "Vajutas create nuppu!";
			
			if(empty($_POST["user_email"]) ){
				$user_email_error = " See väli on kohustuslik.";
			}else{
				$user_email = cleanInput($_POST["user_email"]);
			}
			
			//kontrollin, et parool ei ole tühi
			if(empty($_POST["user_password"]) ){
				$user_password_error = "See väli on kohustuslik.";
			}else{
				
				// kui oleme siia jõudnud, siis parool ei ole tühi
				// kontrollin, et oleks vähemalt 8 sümbolit pikk
				if(strlen($_POST["user_password"])<8) {	
					$user_password_error = "Peab olema vähemalt 8 tähemärki pikk";
				}else{
					$user_password = cleanInput($_POST["user_password"]);
				}
			}			
				
			//valideerimine create user vormile
			//kontrollin, et perekonnanimi ei ole tühi
			if( empty($_POST["lastname"]) ) {
				$lastname_error = "See väli on kohustuslik";
			}else{
				//kõik korras
				//test_input eemaldab pahatahtlikud osad
				$lastname = cleanInput($_POST["lastname"]);
			
				
			}
			if($lastname_error == ""){
				echo "salvestan ab'i".$lastname;
			}
			
			//valideerimine create user vormile
			//kontrollin, et eesnimi ei ole tühi
			if( empty($_POST["firstname"]) ) {
				$firstname_error = "See väli on kohustuslik";
			}else{
				//kõik korras
				//test_input eemaldab pahatahtlikud osad
				$firstname = cleanInput($_POST["firstname"]);
			
				
			}
			if($firstname_error == ""){
				echo "salvestan ab'i".$firstname;
			}
			
			if(	$user_email_error == "" && $user_password_error == ""){
				
				// räsi paroolist, mille salvestame ab'i
				$hash = hash("sha512", $user_password);
				
				//kasutaja sisselogimise funktsioon failist function.php
				createUser($user_email, $hash, $lastname, $firstname);
				
				echo "Võib kasutajat luua! Kasutajanimi on ".$user_email." ja parool on ".$user_password. "ja räsi on" .$hash;
			
			}
		
		}	
	}	//võtab ära tühikud, enterid ja tabid
	function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>  
<?php
	$page_title = "Sisselogimise leht";
	$page_file_name = "login.php";
?>  
<!DOCTYPE html>                                               
<html>
<head>
	<title><?php echo $page_title; ?></title>
	
</head>
<body>
	
	<h2>Log in</h2>
		<form action="login.php" method="post">
			<input name="log_email" type="email" placeholder="E-post" value="<?php echo $log_email; ?>">* <?php echo $log_email_error; ?> <br><br>
			<input name="log_password" type="password" placeholder="Parool" value="<?php echo $log_password; ?>">* <?php echo $log_password_error; ?> <br><br>
			<input name="login" type="submit" value="Log in"> 
		</form>
		
	<h2>Create user</h2>
	
		<form action="login.php" method="post">
			<input name="user_email" type="email" placeholder="E-post" value="<?php echo $user_email; ?>">* <?php echo $user_email_error; ?> <br><br>
			<input name="user_password" type="password" placeholder="Parool" value="<?php echo $user_password; ?>">* <?php echo $user_password_error; ?> <br><br>
			<input name="lastname" type="text" placeholder="Perekonnanimi" value="<?php echo $lastname; ?>">* <?php echo $lastname_error; ?><br><br>
			<input name="firstname" type="text" placeholder="Eesnimi" value="<?php echo $firstname; ?>">* <?php echo $firstname_error; ?><br><br>
			<input name="create" type="submit" value="Create">
		</form>
		
		
		
<p><i>Lehe tegi Henrik, 2015a.</i></p>
</body>     
</html>