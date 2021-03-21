<?php
session_start(); //pour demarrer la session

// si l utilisateur clique sur se deconnecter alors on detruit la session et on efface la varible $_SESSION
if (isset($_GET['logout'])) {
    if ($_GET['logout'] == "1") {
        session_destroy();
        unset($_SESSION);
    }
}

function is_superviseur()
{
    $sql = 'SELECT IdSuperviseur FROM superviseur WHERE IdPersonne=' . $_SESSION['IdPersonne'];
    global $conn;
    $requete = mysqli_query($conn, $sql);
    if ($requete != FALSE) {
        $row = mysqli_fetch_assoc($requete);
        
        if( !empty( $row['IdSuperviseur'])){
            return $row['IdSuperviseur'];
        }
    }
    return 0;
    
}
function is_adminitrateur($superviseur)
{
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
	<title> Gaëtan va tester </title>
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
     echo is_adminitrateur(is_superviseur());
    ?>
</body>
</html>