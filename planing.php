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

    <style>
    .table{
        border-collapse: collapse;
        margin: auto;
        font-size: 0.95em;
        width: 60%;
    }
    .table thead tr{
        background-color: #009879;
        color: #ffffff;
        font-weight: bold;
        text-align: center;
    }
    .table th{
        padding: 12px;
    }
    .table tbody tr{
        border-bottom: 1px solid #dddddd;
        text-align: center;
        
    }
    .table td{
        padding: 12px;
    }
    .table tr:nth-of-type(even){
        background-color: #f2f3f3;
    }
    .table tr:nth-last-child(-n+1){
        border-bottom: 2px solid #009879;
    }
    </style>

    <table class="table">
    <thead>
        <tr>
            <th>Date</th>
            <th>Ville</th>
            <th>Points</th>
            <th>Description</th>
            <th>Lieu</th>
        </tr>
    </thead>
        <?php
        while ($row = mysqli_fetch_assoc($resultat)) {?>
            //mettre une sous requete pour trier par ordre chronologique
            <tr>

            <td><?=$row['Date_Mission']?></td>
            <td><?=$row['Ville']?></td>
            <td><?=$row['Points']?></td>
            <td><?=$row['Description']?></td>
            <td><?=$row['Numero_rue'] . ' ' . $row['Rue'] . '</td>';?>

            </tr>
            <?php } ?>
        </table>
        