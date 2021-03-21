<?php
session_start(); //pour demarrer la session

// si l utilisateur clique sur se deconnecter alors on detruit la session et on efface la varible $_SESSION
if (isset($_GET['logout'])) {
    if ($_GET['logout'] == "1") {
        session_destroy();
        unset($_SESSION);
    }
}
if (!isset($_GET['vu'])) {
    header('location: http://' . $_SERVER['HTTP_HOST'] .    $_SERVER['REQUEST_URI'] . '?vu=1');
    die();
}

function is_superviseur() #fait
{ #renvoit l'IdSuperviseur si l'utilisateur est un superviseur, sinon renvoit 0
    $sql = 'SELECT IdPersonne FROM superviseur WHERE IdPersonne=' . $_SESSION['IdPersonne'];
    global $conn;
    $requete = mysqli_query($conn, $sql);
    if ($requete != FALSE) {
        $row = mysqli_fetch_assoc($requete);
        
        if( !empty( $row['IdPersonne'])){
            return $row['IdPersonne'];
        }
    }
    return 0;
}

//on fait une fonction pour voir si on est administrateur
function is_adminitrateur($superviseur) #fait
{ #renvoit l'IdSuperviseur si l'IdSuperviseur est un administrateur, sinon renvoit 0
    if ($superviseur) {
        $sql = 'SELECT IdSuperviseur FROM superviseur WHERE Administrateur=1 and IdSuperviseur ='. $superviseur;
        global $conn;
        $requete = mysqli_query($conn, $sql);
        if ($requete != FALSE) {
            $row = mysqli_fetch_assoc($requete);
            
            if( !empty( $row['IdSuperviseur'])){
                return $row['IdSuperviseur'];
            }
        }
        return 0;
    };
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
    switch ($_GET['vu']) 
    {
        case "1": 

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
                    if (is_superviseur()) {
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

                    if (is_superviseur()) {
                        echo '<td><a href="">Editer</a></td>';
                        echo '<td><a href="">Supprimer</a></td>';
                    };

                    echo '</tr>';
                }
            echo '</table>';
            
            if (is_superviseur()) {
                echo '<a href="./missions.php?vu=2">Nouvelle Mission</a>';
            }
            break;

        case "2":
            ?>
            <form action="./missions.php?vu=3" method="post">
                <label for="Date">Date</label>
                <input type="date" id="Date" name="Date"><br>
                <label for="Nombre_v">Nombre de volontaires</label>
                <input type="number" id="Nombre_v" name="Nombre_v"><br>
                <fieldset>  <!-- un peu de CSS sera utile -->
                    <legend> Lieu du rendez-vous </legend>
                    <label for="Ville">Ville</label>
                    <input type="text" id="Ville" name="Ville"><br>
                    <label for="Rue">Nom de la rue</label>
                    <input type="text" id="Rue" name="Rue"><br>
                    <label for="Address">Numéro du batîment</label>
                    <input type="text" id="Address" name="Address"><br>
                </fieldset>
                <label for="Description">Description de la Mission</label>
                <input type="text" id="Description" name="Description"><br>
                <label for="Points">Valeur en nombre de points</label>
                <input type="number" id="Points" name="Points"><br>
                <input type="submit" value="Valider">
            </form>
            <?php
            break;

        case "3":
            $erreur = False;
            foreach ($_POST as $key => $Value) {
                if (empty($Value)) {
                    $erreur = True;
                    echo "Il manque une valeur pour " . $key . "<br>";
                }
            }
            if ($erreur){
                echo '<form action="./missions.php?vu=2" method="post">';
                echo '<input type="submit" value="Retour vers la création de Mission">';
                echo '</form>';
            }
            else{
                """
                Vérifié si toute les informations sont présentes v
                    renvois case 2 si des infos sont absente v
		                peut-être sauvegarder les infos (si temps)
                Vérifié si toute les informations sont valides. (prio)
                insert dans BD x
                """
            }
            break;
    }
        ?>

</body>

</html>