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
    $sql = "SELECT * FROM personne WHERE IdPersonne='1'" ;
    $resultat = mysqli_query($conn, $sql);
    if ($resultat == FALSE) {
        die("<br>Echec d'execution de la requete : " . $sql);
    } elseif (mysqli_num_rows($resultat) == 1) {
    $row = mysqli_fetch_assoc($resultat);
?>
    <form action="mon_compte.php" method="get">
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
        <label for="Mots_de_passe">Mot de passe :</label>
        <input type="text" id="Mots_de_passe" name="Mots_de_passe" value="<?php echo $row['Telephone'] ?>"><br><br>
        <input type="hidden" name="IdPersonne" value="<?php echo $row['IdPersonne'] ?>">
    </form>
    <?php
    }

