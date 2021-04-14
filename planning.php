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
    $sql = "Select * FROM mission WHERE IdMission='1'";
            $requete = mysqli_query($conn, $sql);
            //on affiche les missions

            ?>
            <table border=1>
                <tr>
                    <td>Date</td>
                    <td>Ville</td>
                    <td>Points</td>
                    <td>Description</td>
                    <td>Lieu</td>
                    <td>Places Disponibles</td>
                    

                    <?php
                    //if (is_superviseur()) {
                        //echo '<td>Editer</td>';
                        //echo '<td>Supprimer</td>';
                    //}
                    ?>
                </tr>

<?php
while ($row = mysqli_fetch_assoc($requete)) {
    echo '<tr>';

    echo '<td>' . $row['Date_Mission'] . '</td>';
    echo '<td>' . $row['Ville'] . '</td>';
    echo '<td>' . $row['Points'] . '</td>';
    echo '<td>' . $row['Description'] . '</td>';
    echo '<td>' . $row['Numero_rue'] . ' ' . $row['Rue'] . '</td>';
    echo '<td>' . $row['Nombre_Volontaire'] . '</td>';

}
?>
