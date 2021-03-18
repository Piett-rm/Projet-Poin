<?php
session_start(); //pour demarrer la session

// si l utilisateur clique sur se deconnecter alors on detruit la session et on efface la varible $_SESSION
if (isset($_GET['logout'])) {
    if ($_GET['logout'] == "1") {
        session_destroy();
        unset($_SESSION);
    }
}


function is_superviseur($IdPersonne)
{
    $sql = 'SELECT * FROM superviseur WHERE IdPersonne=' . $_SESSION['IdPersonne'];
    if ($sql) {
        return TRUE;
    } else {
        return FALSE;
    }
}

//on fait une fonction pour voir si on est administrateur
function is_adminitrateur($IdPersonne)
{
    if (is_superviseur($IdPersonne)) {
        $sql = 'SELECT * FROM superviseur WHERE Administrateur=1';
    };

    if ($sql) {
        return TRUE;
    } else {
        return FALSE;
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
    echo '<br>Bienvenue sur la page des missions' . ' ' . $_SESSION['Prenom'] . ' ' . $_SESSION['Nom'] . '<br><br>';

    include("./nav-bar.php");

    $sql = "Select * FROM mission WHERE Date_Mission > CURRENT_DATE ORDER BY Date_Mission";
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
            <td> - </td>

            <?php
            if (is_adminitrateur($_SESSION['IdPersonne'])) {
                echo '<td>Editer</td>';
                echo '<td>Supprimer</td>';
            }
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
            echo '<td>' . '<a href="./confirmation.php?i=t&mission=' . $row['IdMission'] . '">S\'inscrire</a> </td>'; //i(nscription)=t(rue)&mission=[idMission]

            if (is_adminitrateur($_SESSION['IdPersonne'])) {
                echo '<td><a href="">Editer</a></td>';
                echo '<td><a href="">Supprimer</a></td>';
            }



            echo '</tr>';
        }
        echo '</table>';
        ?>

</body>

</html>