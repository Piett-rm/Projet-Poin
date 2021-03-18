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

    $sql = "SELECT *
    FROM
    participe
    INNER JOIN mission on participe.IdMission = mission.IdMission
    where IdPersonne=1 AND mission.Date_Mission > CURRENT_DATE
    ORDER BY Date_Mission";
    $resultat = mysqli_query($conn, $sql);
    if ($resultat == FALSE) {
        die("<br>Echec d'execution de la requete : " . $sql);
    } else {
        echo "resultat ok";
    }
    ?>

    <table border=1>
        <tr>
            <td>Date</td>
            <td>Ville</td>
            <td>Points</td>
            <td>Description</td>
            <td>Lieu</td>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($resultat)) {
            //mettre une sous requete pour trier par ordre chronologique
            echo '<tr>';

            echo '<td>' . $row['Date_Mission'] . '</td>';
            echo '<td>' . $row['Ville'] . '</td>';
            echo '<td>' . $row['Points'] . '</td>';
            echo '<td>' . $row['Description'] . '</td>';
            echo '<td>' . $row['Numero_rue'] . ' ' . $row['Rue'] . '</td>';

            echo '</tr>';
        }
        echo '</table>';

        ?>