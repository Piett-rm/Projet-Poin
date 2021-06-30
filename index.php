<?php
session_start(); //pour demarrer la session

// si l utilisateur clique sur se deconnecter alors on detruit la session et on efface la varible $_SESSION
if (isset($_GET['logout'])) {
	if ($_GET['logout'] == "1") {
		session_destroy();
		unset($_SESSION);
	}
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Accueil</title>
	<link rel="stylesheet" href="index.css" />
</head>

<body>


	<?php
	include '../connexion.php';
	?>

	<!--
on va faire le carré de connexion
	-->
	<div id="en-tete">
		<!-- Ici on récupere l'entete /header -->
		<?php include("./en-tete.php"); ?>
	</div>
	<?php
	if (isset($_GET['login']) && !empty($_GET['login']) && isset($_GET['mdp']) && !empty($_GET['mdp'])) {
		$sql = "select * from PERSONNE where Nom_Utilisateur='" . $_GET['login'] . "' and Mots_de_passe='" . $_GET['mdp'] . "'"; // requete pour chercher si on trouve le login et mdp dasn le étudiants
		$requete = mysqli_query($conn, $sql);

		if ($requete == FALSE) { //si la requete echoue
			echo ("<br>Echec d'execution de la requete : " . $sql);
		} else { //si la requete fonctionne :
			if (mysqli_num_rows($requete) == 1) { // si il y a un resultat dasn la réquete alors ok sinon on ne traite pas car le login doit être unique
				$row = mysqli_fetch_assoc($requete);
				//on initialise les variables  de session
				$_SESSION['IdPersonne'] = $row['IdPersonne'];
				$_SESSION['Nom'] = $row['Nom'];
				$_SESSION['Prenom'] = $row['Prenom'];
			}
		}
	}

	if (isset($_SESSION['id_user'])) { //si on est connecté : on affiche les missions

		include('nav-bar.php');
	}
	?>
	<div id="corps">
		<div id="explications">
			<p>Notre projet a pour but écologique de dépolluer les rues, villages, villes et est basé sur le volontariat récompensé. Il permet également aux personnes les plus démunies d'accéder à internet et également d’avoir des réductions pour les transports en commun (bus, taxis collectifs).<br><br>
				Des événements pour dépolluer les rues sont organisés en échange de récompenses (Internet gratuit, bons de réductions pour les transports en communs, et autres …).
				Sur un site internet les gens peuvent consulter les évènements à venir avec le lieu de départ et l’horaire et éventuellement s’y inscrire.
				<br><br>Une fois sur place des groupes seront formés et dirigés (apporter personnellement des sacs poubelle) et une fois la dépollution terminée il faut ramener les sacs à un endroit précis et des points vous seront attribués ce qui vous permettra d’obtenir des récompenses
			</p>

		</div>

		<div id="news">
			<p>Ici on mettra toutes les news<br>
				Adolescebat autem obstinatum propositum erga haec<br> et similia multa scrutanda, stimulos admovente regina,<br> quae abrupte mariti fortunas trudebat in exitium praeceps, cum <br>eum potius lenitate feminea ad veritatis humanitatisque viam<br> reducere utilia suadendo deberet, ut in Gordianorum actibus factitasse Maximini <br>truculenti illius imperatoris rettulimus coniugem.
				<br>
				Pandente itaque viam fatorum sorte tristissima, <br>qua praestitutum erat eum vita et imperio spoliari,<br> itineribus interiectis permutatione iumentorum emensis venit Petobionem <br>oppidum Noricorum, ubi reseratae sunt insidiarum latebrae omnes<br>, et Barbatio repente apparuit comes, qui sub eo domesticis praefuit, cum Apodemio agente in <br>rebus milites ducens, quos beneficiis suis oppigneratos elegerat imperator certus nec praemiis nec miseratione ulla posse deflecti.
				<br>

				Metuentes igitur idem latrones Lycaoniam magna parte <br>campestrem cum se inpares nostris fore congressione <br>stataria documentis frequentibus scirent, tramitibus deviis petivere Pamphyliam <br>diu quidem intactam sed timore populationum et caedium, <br>milite per omnia diffuso propinqua, magnis undique praesidiis conmunitam.
			</p>
		</div>

	</div>
	<!--On ferme le div du corps -->
</body>

<footer>
	<?php
	include("./footer.html");
	?>
</footer>

</html>