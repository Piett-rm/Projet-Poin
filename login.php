<?php
include('./session.php');
$erreur_login = FALSE;

if (isset($_POST['Mots_de_passe'])) {
    //ici on se connecte a la base sql
    include("../connexion.php");

    $sql = 'SELECT * from personne where Email=\'' . $_POST["mail_user"] . '\' and Mots_de_passe=\'' . $_POST["Mots_de_passe"] . '\'';
    $resultat = mysqli_query($conn, $sql);

    if ($resultat == FALSE) {
        die("<br>Echec d'execution de la requete : " . $sql);
    } else {
        if (mysqli_num_rows($resultat) == 1) { //si la personne existe :

            $row = mysqli_fetch_array($resultat);
            $_SESSION['id_user'] = $row['IdPersonne'];
            $_SESSION['nom_user'] = $row['Nom'];
            $_SESSION['prenom_user'] = $row['Prenom'];
            //si son id est ds volontaire : on set session type a volontaire
            $sql = 'SELECT * from volontaire where IdPersonne=\'' . $_SESSION['id_user'] . '\'';
            $resultat = mysqli_query($conn, $sql);
            if ($resultat) { //si c un volontaire
                if (mysqli_num_rows($resultat) == 1) {

                    $_SESSION['type'] = "volontaire";
                } else { //sinon, on check si c'est un superviseur
                    $sql = 'SELECT * from superviseur where IdPersonne=' . $_SESSION['id_user'];
                    $resultat = mysqli_query($conn, $sql);
                    if ($resultat) {
                        if (mysqli_num_rows($resultat) == 1) {
                            //on est un superviseur
                            $row = mysqli_fetch_assoc($resultat);
                            if ($row['Administrateur'] == 0){
                                $_SESSION['type'] = "superviseur";

                            } else {

                                $_SESSION['type'] = "administrateur";
                            }


                        }
                    }
                }
            }

            $url = $_SERVER['HTTP_REFERER'];
            $tableau = explode("/", $url, -1);
            $location = "";
            foreach ($tableau as $valeur) {
                $location = $location . $valeur . "/";
            }
            $location = $location . 'index.php';
            header("Location: $location");
            exit();
        }
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="Expires" content="0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css" />
</head>

<body>


    <?php
    //on met l'en-tete
    include("./en-tete.php");
    //include("./menu.php");

    ?>
    <div class="container">
        <div class="row">
            <div class="col">

                <?php

                if ($erreur_login) {
                    echo 'Identifiant ou mot de passe incorrecte';
                }

                if (isset($_SESSION['type'])) {

                    echo 'Hello ' . (($_SESSION['type'] == "superviseur") ? "superviseur" : "volontaire") . $_SESSION['nom_user'] . ' ' . $_SESSION['prenom_user'];
                    echo '<br><a href="./login.php?logout=1">Se deconnecter</a><br><br>';
                    echo '<br><a href="./index.php">Aller à l\'acceuil</a><br><br>';
                }

                if (!isset($_SESSION['id_user'])) {
                ?>
                    <h1 class="connexion">connexion</h1>
                    <div class="login">
                    <form action="./login.php" method="post">
                        <label class="mail" for="nom">Mail :</label>
                        <input type="text" id="mail_user" name="mail_user"><br><br>
                        <label class="mot_de_passe" for="password">Mot de passe :</label>
                        <input type="password" id="Mots_de_passe" name="Mots_de_passe"><br><br>
                        <input class="envoyer" type="submit" value="Envoyer">
                    </form>
                    </div>

                <?php
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>