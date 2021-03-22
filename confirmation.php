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
    <meta charset="UTF-8">
    <title> Accueil </title>
    <link rel="stylesheet" href="styles.css" />
</head>

<body>


    <?php
    //var de conexion à la base de donnée
    include '../connexion.php';
    ?>
    <div id="en-tete">
        <?php include("./en-tete.php"); ?>
    </div>
    <?php
    include("./nav-bar.php");

    $sql = "INSERT INTO participe (IdMission, IdPersonne) values ('" . $_GET['mission'] . "','" . $_SESSION['IdPersonne'] . "')";
    $resultat = mysqli_query($conn, $sql);
    if ($resultat == FALSE) {
        die("<br>Echec d'execution de la requete : " . $sql);
    } else {
        echo "Inscription validée";
        $sql = "UPDATE mission set  Nombre_Volontaire = Nombre_Volontaire - 1 WHERE IdMission = " . $_GET['mission'];
        $resultat = mysqli_query($conn, $sql);
        if ($resultat == FALSE) {
            die("<br>Echec d'execution de la requete : " . $sql);
        }
    }


    ?>