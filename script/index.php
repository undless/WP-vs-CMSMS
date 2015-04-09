<?php

// Secure data from the form
function securite_bdd($string)
{
	if(ctype_digit($string))
	{
		$string = intval($string);
	}
	else
	{
		//$string = mysql_real_escape_string($string);
		$string = addcslashes($string, '%_');
	}
	return $string;
}


$ready=false;
if($_POST['dbconnexion_dbadress'] && $_POST['dbconnexion_dbname'] && $_POST['dbconnexion_username'] && $_POST['dbconnexion_pwd']){
	$ready=true;
	try
	{
		$dbadress = ($_POST['dbconnexion_dbadress']);
		$dbname = securite_bdd($_POST['dbconnexion_dbname']);
		$username = securite_bdd($_POST['dbconnexion_username']);
		$pwd = securite_bdd($_POST['dbconnexion_pwd']);
		$bdd = new PDO("mysql:host=$dbadress;dbname=$dbname", $username, $pwd, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	catch (Exception $e)
	{
		die('Erreur : ' . $e->getMessage());
	}
	$reponse = $bdd->query("SELECT post_title,post_content FROM wp_posts ORDER BY ID");
}
?>





<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta content="initial-scale=1" name="viewport">

		<link href="stylesheet.css" type="text/css" rel="stylesheet">
		<title>Link to DB</title>
	</head>
	<body>
		<?php if($ready){ ?>

			<section class="results">
				<?php
				// On affiche chaque entrée une à une
				while ($donnees = $reponse->fetch())
				{
				?>
				    <div class="post">
				    	<div class="post-title"><?php echo htmlspecialchars($donnees['post_title']); ?></div>
				    	<div class="post-content"><?php echo htmlspecialchars($donnees['post_content']); ?></div>
				   </div>
				<?php
				}
				$reponse->closeCursor(); // Termine le traitement de la requête
				?>
			</section>

		<?php }else{ ?>

			<form id="dbconnexion" method="post" action="index.php" class="form">
				<label for="dbconnexion_dbadress">DataBase Adress</label>
				<input type="text" placeholder="" id="dbconnexion_dbadress" name="dbconnexion_dbadress" required>

				<label for="dbconnexion_dbname">DataBase Name</label>
				<input type="text" placeholder="" id="dbconnexion_dbname" name="dbconnexion_dbname" required>

				<label for="dbconnexion_username">User Name</label>
				<input type="text" placeholder="" id="dbconnexion_username" name="dbconnexion_username" required>

				<label for="dbconnexion_pwd">Password</label>
				<input type="password" placeholder="" id="dbconnexion_pwd" name="dbconnexion_pwd" required>

				<button type="submit">Envoyer</button>
			</form>


			<script type="text/javascript">

				if(localStorage.getItem("dbconnexion_dbadress") ){
					document.getElementById("dbconnexion_dbadress").value = localStorage.getItem("dbconnexion_dbadress");
				}
				if(localStorage.getItem("dbconnexion_dbname") ){
					document.getElementById("dbconnexion_dbname").value = localStorage.getItem("dbconnexion_dbname"); 
				}
				if(localStorage.getItem("dbconnexion_username") ){
					document.getElementById("dbconnexion_username").value = localStorage.getItem("dbconnexion_username"); 
				}
				
				document.getElementById("dbconnexion").addEventListener("submit", function(event) {
					localStorage.setItem("dbconnexion_dbadress", document.getElementById("dbconnexion_dbadress").value);
					localStorage.setItem("dbconnexion_dbname", document.getElementById("dbconnexion_dbname").value);
					localStorage.setItem("dbconnexion_username", document.getElementById("dbconnexion_username").value);
				});

			</script>

		<?php } ?>


	</body>
</html>