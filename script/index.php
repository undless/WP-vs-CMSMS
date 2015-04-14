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


$logResult=false;
if($_POST['dbconnexion_dbadress_from'] && $_POST['dbconnexion_dbname_from'] && $_POST['dbconnexion_username_from'] && $_POST['dbconnexion_pwd_from']){
	$logResult=true;
	try
	{
		$dbadress = securite_bdd($_POST['dbconnexion_dbadress_from']);
		$dbname = securite_bdd($_POST['dbconnexion_dbname_from']);
		$username = securite_bdd($_POST['dbconnexion_username_from']);
		$pwd = securite_bdd($_POST['dbconnexion_pwd_from']);
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

		<link href="css/font.css" type="text/css" rel="stylesheet">
		<link href="css/stylesheet.css" type="text/css" rel="stylesheet">
		<title>Link to DB</title>
	</head>
	<body>
		<form id="dbconnexion" method="post" action="index.php" class="max-width form">
			<div class="fromDB">
				<div class="formLine">
					<label for="dbconnexion_dbadress_from" class="icon-server">DataBase Server</label>
					<input type="text" placeholder="" id="dbconnexion_dbadress_from" name="dbconnexion_dbadress_from" required />
				</div><!--
				--><div class="formLine">
					<label for="dbconnexion_dbname_from" class="icon-tag">DataBase Name</label>
					<input type="text" placeholder="" id="dbconnexion_dbname_from" name="dbconnexion_dbname_from" required />
				</div><!--
				--><div class="formLine">
					<label for="dbconnexion_username_from" class="icon-head">User Name</label>
					<input type="text" placeholder="" id="dbconnexion_username_from" name="dbconnexion_username_from" required />
				</div><!--
				--><div class="formLine">
					<label for="dbconnexion_pwd_from" class="icon-lock">Password</label>
					<input type="password" placeholder="" id="dbconnexion_pwd_from" name="dbconnexion_pwd_from" required />
				</div>
			</div>
			<div class="toDB">
				unused
			</div>
			<div class="formActionLine">
				<div id="reset" class="btn btn-reset">Reset</div>
				<button type="submit" class="btn btn-main">Envoyer</button>
			</div>
		</form>
		<script type="text/javascript">

			var i = 0;
			var localStorageKey = "";

			/* Get localStorage */
			for (i = 0; i < localStorage.length; i++) {
				localStorageKey = localStorage.key(i);
				if (document.getElementById(localStorageKey)) {
					document.getElementById(localStorageKey).value = localStorage.getItem(localStorageKey);
				};
			};

			/* Set localStorage */
			var inputList = document.getElementById("dbconnexion").getElementsByTagName("input");
			for (i = 0; i < inputList.length ; i++) {
				inputList[i].addEventListener("focusout", function(event) {
					localStorage.setItem(this.name, document.getElementById(this.name).value);
				});
			};

			/* Clear localStorage */
			var reset = document.getElementById("reset");
			reset.addEventListener("click", function(event) {
				localStorage.clear();
				console.log("localStorage Cleaned")
			});

		</script>

		<?php if($logResult){ ?>

			<section class="max-width results">
				<?php
				// On affiche chaque entrée une à une
				while ($donnees = $reponse->fetch())
				{
				?>
				    <div class="post">
				    	<?php if ($donnees['post_title']) { ?>
				    		<div class="post-title"><?php echo htmlspecialchars($donnees['post_title']); ?></div>
				    	<?php } ?>
				    	<?php if ($donnees['post_content']) { ?>
				    		<div class="post-content"><?php echo htmlspecialchars($donnees['post_content']); ?></div>
				    	<?php }else{ ?>
				    		<div class="post-content">No content</div>
				    	<?php } ?>
				   </div>
				<?php
				}
				$reponse->closeCursor(); // Termine le traitement de la requête
				?>
			</section>

		<?php } ?>


	</body>
</html>