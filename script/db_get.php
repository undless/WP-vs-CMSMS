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
	$reponse = $bdd->query("SELECT * FROM wp_posts WHERE post_type='post' AND post_status='publish' ORDER BY post_date_gmt");
}


$WPtable = [
	'ID',
	'post_date_gmt',
	'post_title',
	'post_type',
	'post_status',
	'post_name',
	'post_content'
];


if($logResult){ 
	/*/ On affiche chaque entrée une à une
    echo '<pre>';
	var_dump($reponse->fetch());
    echo '</pre>';
    */
	echo "<table>";
		echo '<tr>';
		foreach ($WPtable as $value) {
			echo "<th>";
				echo $value;
			echo "</th>";
		}
		echo '</tr>';

	while ($donnees = $reponse->fetch()){
	    echo '<tr>';

			foreach ($WPtable as $value) {
				echo "<td>";
				echo htmlspecialchars($donnees[$value]);
				echo "</td>";
			}
	   echo '</tr>';
	}
	$reponse->closeCursor(); // Termine le traitement de la requête

	echo '</table>';
 } 
