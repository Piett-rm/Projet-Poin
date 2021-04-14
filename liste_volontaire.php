<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Circuits</title>
    <link rel="stylesheet" href="styles.css" />

</head>

<body>

    <?php
    include("./en-tete.php");
    //ici on se connecte a la base sql
    include("../connexion.php");

    switch ($_GET['c']) {


        case 'create':
    ?>
            <form action="./liste_volontaire.php" method="get">

                <label for="Nom">Nom :</label>
                <input type="text" id="Nom" name="Nom"><br><br>
                <label for="Prenom">Prénom :</label>
                <input type="text" id="Prenom" name="Prenom"><br><br>
                <label for="Email">Mail :</label>
                <input type="text" id="Email" name="Email"><br><br>
                <label for="Telephone">Téléphone :</label>
                <input type="text" id="Telephone" name="Telephone"><br><br>
                <label for="Code_Postal">Code Postal :</label>
                <input type="text" id="Code_Postal" name="Code_Postal"><br><br>
                <label for="Nom_Utilisateur">Nom d'utilisateur :</label>
                <input type="text" id="Nom_Utilisateur" name="Nom_Utilisateur"><br><br>
                <label for="Mots_de_passe">Mot de passe :</label>
                <input type="text" id="Mots_de_passe" name="Mots_de_passe"><br><br>

                <input type="hidden" name="c" value="add">

                <input type="submit" value="Appuie pour faire les changements">
            </form>


            <?php
            break;

        case 'add':

            $sql = "INSERT INTO personne (Code_Postal, Telephone, nom, Email, prenom, Mots_de_passe, Nom_Utilisateur) values
            ('" . $_GET['Code_Postal'] . "','" . $_GET['Telephone'] . "','" . $_GET['Nom'] . "','" . $_GET['Email'] . "','" . $_GET['Prenom'] . "','" . $_GET['Mots_de_passe'] . "','" . $_GET['Nom_Utilisateur'] . "')";
            $resultat = mysqli_query($conn, $sql);
            if ($resultat == FALSE) { //si on peut pas ajouter

                die("<br>Echec d'execution de la requete : " . $sql);
            } else {
                $sql = "SELECT * FROM personne where Nom_Utilisateur='" . $_GET['Nom_Utilisateur'] . "'";
                $resultat = mysqli_query($conn, $sql);
                if (mysqli_num_rows($resultat) == 1) {
                    $row = mysqli_fetch_assoc($resultat);
                    echo "Le compte a été créé";
                    $sql = "INSERT INTO Volontaire (IdPersonne ,Date_Inscription) values ('" . $row['IdPersonne'] . "',NOW())";
                    $resultat = mysqli_query($conn, $sql);
                    echo '<a href="./liste_volontaire.php?c=default">Retour aux Volontaires</a>';
                    if ($resultat == FALSE) { //si on peut pas ajouter

                        die("<br>Echec d'execution de la requete : " . $sql);
                    }
                }
            }
            break;

        case 'read':

            $sql = "SELECT * FROM personne WHERE IdPersonne=" . $_GET['IdPersonne'];
            $resultat = mysqli_query($conn, $sql);
            if ($resultat == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } elseif (mysqli_num_rows($resultat) == 1) {
                $row = mysqli_fetch_assoc($resultat);
            ?>
                <form action="./liste_volontaire.php" method="get">
                    <label for="Nom">Nom :</label>
                    <input type="text" id="Nom" name="Nom" value="<?php echo $row['Nom'] ?>"><br><br>
                    <label for="Prenom">Prénom :</label>
                    <input type="text" id="Prenom" name="Prenom" value="<?php echo $row['Prenom'] ?>"><br><br>
                    <label for="Email">Mail :</label>
                    <input type="text" id="Email" name="Email" value="<?php echo $row['Email'] ?>"><br><br>
                    <label for="Telephone">Téléphone :</label>
                    <input type="text" id="Telephone" name="Telephone" value="<?php echo $row['Telephone'] ?>"><br><br>
                    <label for="Code_Postal">Code Postal :</label>
                    <input type="text" id="Code_Postal" name="Code_Postal" value="<?php echo $row['Code_Postal'] ?>"><br><br>
                    <label for="Nom_Utilisateur">Nom d'utilisateur :</label>
                    <input type="text" id="Nom_Utilisateur" name="Nom_Utilisateur" value="<?php echo $row['Nom_Utilisateur'] ?>"><br><br>
            
                    <input type="hidden" name="IdPersonne" value="<?php echo $row['IdPersonne'] ?>">

                    <input type="hidden" name="c" value="update">
                    <input type="submit" value="Appuie pour faire les changements">
                </form>
            <?php
            }
            break;

        case 'update':

            $sql = "UPDATE personne SET Nom='" . $_GET['Nom'] . "', Prenom='" . $_GET['Prenom'] . "',Email='" . $_GET['Email'] . "', Telephone='" . $_GET['Telephone'] . "', Code_Postal='" . $_GET['Code_Postal'] . "', Nom_Utilisateur='" . $_GET['Nom_Utilisateur'] . "' where IdPersonne=" . $_GET['IdPersonne'];
            $stmt = mysqli_query($conn, $sql);
            if ($stmt == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } else {
                echo "Enregistrement mis à jour<br><br>";
                echo '<a href="./liste_volontaire.php?c=default">Retour aux volontaires</a>';
            }
            break;

        case 'del':
            $sql = "DELETE FROM volontaire where IdPersonne='" . $_GET['IdPersonne'] . "'";
            $resultat = mysqli_query($conn, $sql);
            if ($resultat == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } else {
                echo "Enregistrement supprimé";
            }
            break;



        default: //liste les enregistrements

            $sql = 'SELECT * FROM personne inner join volontaire on volontaire.IdPersonne=personne.IdPersonne';
            $resultat = mysqli_query($conn, $sql);
            if ($resultat == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } else {

            ?>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col align-self-center">
                            <p>Liste des volontaire</p>
                            <p><br><a href='./liste_volontaire.php?c=create'>Ajouter</a></p>

                            <table class="table table-striped">
                                <tr>
                                    <td>nom</td>
                                    <td>prenom</td>
                                    <td>Nom utilisateur</td>
                                    <td>Date inscription</td>
                                    <td>mail</td>
                                    <td>téléphone</td>
                                    <td>code postale</td>
                                    <td>Points</td>
                                    <td></td>
                                </tr>
                            <?php
                            while ($row = mysqli_fetch_assoc($resultat)) {
                                echo "<tr>";
                                echo "<td>" . $row['Nom'] . "</td>";
                                echo "<td>" . $row['Prenom'] . "</td>";
                                echo "<td>" . $row['Nom_Utilisateur'] . "</td>";
                                echo "<td>" . $row['Date_Inscription'] . "</td>";
                                echo "<td>" . $row['Email'] . "</td>";
                                echo "<td>" . $row['Telephone'] . "</td>";
                                echo "<td>" . $row['Code_Postal'] . "</td>";

                                echo "<td>" . $row['Points'] . "</td>";

                                echo "<td><a href=./liste_volontaire.php?c=del&IdPersonne=" . $row['IdPersonne'] . ">supprimer</a></td>";
                                echo "<td><a href=./liste_volontaire.php?c=read&IdPersonne=" . $row['IdPersonne'] . ">éditer</a></td>";
                            }
                            echo "</tr>";
                        }
                        echo "</table>";
                            ?>

                        </div>
                    </div>
                </div>


        <?php

            break;
    }

        ?>



</body>

</html>