<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="missions.css" />
</head>

<body>
    

<?php
session_start(); //pour demarrer la session

if (!isset($_SESSION['type'])) {
    header('location: ./index.php');
    die();
}

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
    $sql = 'SELECT IdPersonne, IdSuperviseur FROM superviseur WHERE IdPersonne=' . $_SESSION['id_user'];
    global $conn;
    $requete = mysqli_query($conn, $sql);
    if ($requete != FALSE) {
        $row = mysqli_fetch_assoc($requete);

        if (!empty($row['IdSuperviseur'])) {
            return $row['IdSuperviseur'];
        }
    }
    return 0;
}

//on fait une fonction pour voir si on est administrateur
function is_adminitrateur($superviseur) #fait
{ #renvoit l'IdSuperviseur si l'IdSuperviseur est un administrateur, sinon renvoit 0
    if ($superviseur) {
        $sql = 'SELECT IdSuperviseur FROM superviseur WHERE Administrateur=1 and IdSuperviseur =' . $superviseur;
        global $conn;
        $requete = mysqli_query($conn, $sql);
        if ($requete != FALSE) {
            $row = mysqli_fetch_assoc($requete);

            if (!empty($row['IdSuperviseur'])) {
                return $row['IdSuperviseur'];
            }
        }
        return 0;
    };
}

function is_volontaire()
{
    $sql = "SELECT IdPersonne FROM volontaire WHERE IdPersonne=" . $_SESSION['id_user'];
    global $conn;
    $requete = mysqli_query($conn, $sql);
    if ($requete != FALSE) {
        $row = mysqli_fetch_assoc($requete);

        if (!empty($row['IdPersonne'])) {
            return TRUE;
        }
    }
    return false;
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
    include("./nav-bar.php");?>
    <div class="intro">
    <?php echo '<br>Bienvenue sur la page des missions' . ' ' . $_SESSION['prenom_user'] . ' ' . $_SESSION['nom_user'] . '<br><br>';?>
    </div>
    <?php
    switch ($_GET['vu']) {
        case "1":

            $sql = "Select * FROM mission WHERE Date_Mission > CURRENT_DATE ORDER BY Date_Mission";
            $requete = mysqli_query($conn, $sql);
            //on affiche les missions

    ?>
    <style>
        .tableau{
            border-collapse: collapse;
            margin: auto;
            font-size: 0.95em;
            width: 70%;
        }
        .tableau thead tr{
            background-color: #009879;
            color: #ffffff;
            font-weight: bold;
            text-align: center;
        }
        .tableau th{
            padding: 12px;
        }
        .tableau tbody tr{
            border-bottom: 1px solid #dddddd;
            text-align: center;
            
        }
        .tableau td{
            padding: 12px;
        }
        .tableau tr:nth-of-type(even){
            background-color: #f2f3f3;
        }
        .tableau tr:nth-last-child(-n+1){
            border-bottom: 2px solid #009879;
        }
    </style>
            <table class="tableau">
            <thead>
                <tr>           
                    <th>Date</th>
                    <th>Ville</th>
                    <th>Code Postal</th>
                    <th>Points</th>
                    <th>Description</th>
                    <th>Lieu</th>
                    <th>Places Disponibles</th>
                    <th></th>
                    <th></th>
                    <th></th>        
                </tr>
            </thead>
                <?php

                while ($row = mysqli_fetch_assoc($requete)) {?>
                    

                    <tr>
                    <td><?= $row['Date_Mission'] ?></td>
                    <td><?= $row['Ville']?></td>
                    <td><?= $row['Code_Postal']?></td>
                    <td><?= $row['Points']?></td>
                    <td><?= $row['Description']?></td>
                    <td><?= $row['Numero_rue'] . ' ' . $row['Rue'] . '</td>'; ?>
                    <td><?= $row['Nombre_Volontaire']?></td>


                    <?php if (is_volontaire()) {
                        echo '<td>' . '<a href="./confirmation.php?i=t&mission=' . $row['IdMission'] . '">S\'inscrire</a> </td>'; //i(nscription)=t(rue)&mission=[idMission]
                    } else {
                        echo '<td></td>';
                    }
                    if ((is_superviseur() == $row['IdSuperviseur']) or is_adminitrateur(is_superviseur())) {
                        echo '<td><a href="./missions.php?vu=5&i=' . $row['IdMission'] . '">Editer</a></td>';
                        echo '<td><a href="./mission_supp.php?i=' . $row['IdMission'] . '">Supprimer</a></td>';
                    };

                    echo '</tr>';
                }
                echo '</table>';
                ?>
                <style>
                .nouvelle_mission{
                    text-align: center;
                    margin-left: 15%;
                    margin-top: 10px;
                    border-style: outset;
                    height: 40px;
                    width: 160px;
                    background-color: #f2f3f3;
                }
                </style>
                <?php
                if (is_superviseur()) {?>
                    <div class="nouvelle_mission">
                    <?php echo '<a href="./missions.php?vu=2">Nouvelle Mission</a>';}?>      
                    </div>
                <?php break;

            case "2":
                ?>
                <form action="./missions.php?vu=3" method="post">
                    <label for="Date">Date</label>
                    <input type="date" id="Date" name="Date"><br>
                    <label for="Nombre_v">Nombre de volontaires</label>
                    <input type="number" id="Nombre_v" name="Nombre_v"><br>
                    <fieldset>
                        <!-- un peu de CSS sera utile -->
                        <legend> Lieu du rendez-vous </legend>
                        <label for="Ville">Ville</label>
                        <input type="text" id="Ville" name="Ville"><br>
                        <label for="Code_Postal">Code Postal</label>
                        <input type="number" id="Code_Postal" name="Code_Postal"><br>
                        <label for="Rue">Nom de la rue</label>
                        <input type="text" id="Rue" name="Rue"><br>
                        <label for="Address">Numéro du batîment</label>
                        <input type="number" id="Address" name="Address"><br>
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
                if (!date_futur($_POST['Date'])) {
                    $erreur = True;
                    echo "La date est déjà passée.<br>";
                }
                $_POST['Date'] = str_replace('/','-',$_POST['Date']);
                $_POST['Ville'] = str_replace("'","\'",$_POST['Ville']);
                $_POST['Rue'] = str_replace("'","\'",$_POST['Rue']);
                $_POST['Description'] = str_replace("'","\'",$_POST['Description']);
                if (!test_string($_POST['Ville'], 58)) {
                    $erreur = True;
                    echo "Le nom de la ville est trop grand.<br>";
                }
                if (!test_string($_POST['Rue'], 164)) {
                    $erreur = True;
                    echo "Le nom de la rue est trop grand.<br>";
                }
                if (!test_string($_POST['Description'], 500)) {
                    $erreur = True;
                    echo "La Description est limitée à 500 lettres.<br>";
                }

                if ($erreur) {
                    echo '<form action="./missions.php?vu=2" method="post">';
                    echo '<input type="submit" value="Retour vers la création de Mission">';
                    echo '</form>';
                } else {
                    
                    $id = is_superviseur();
                    $sql = "insert into mission(Description, Nombre_Volontaire, Date_Mission, Numero_rue, Rue, Ville, Code_Postal, Points, IdSuperviseur) values('";
                    $sql = $sql . $_POST['Description'] . "', " . $_POST['Nombre_v'] . ", '" . $_POST['Date'] . "', " . $_POST['Address'] . ", '" . $_POST['Rue'];
                    $sql = $sql . "', '" . $_POST['Ville'] . "', " . $_POST['Code_Postal'] . ", " . $_POST['Points'] . ", " . $id . ");";
                    //echo $sql;
                    $requete = mysqli_query($conn, $sql);
                    if ($requete == FALSE) {
                        echo mysqli_error($conn);
                    }
                }
                break;

            case "5":
                $sql = "select * from mission where IdMission = " . $_GET['i'] .";";
                $requete = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($requete);
                ?>
                <form action="./missions.php?vu=6" method="post">
                    <label for="Date">Date</label>
                    <input type="date" id="Date" name="Date" value= "<?php echo $row['Date_Mission'] ?>"><br>
                    <label for="Nombre_v">Nombre de volontaires</label>
                    <input type="number" id="Nombre_v" name="Nombre_v" value= "<?php echo $row['Nombre_Volontaire'] ?>"><br>
                    <fieldset>
                        <!-- un peu de CSS sera utile -->
                        <legend> Lieu du rendez-vous </legend>
                        <label for="Ville">Ville</label>
                        <input type="text" id="Ville" name="Ville" value=" <?php echo $row['Ville'] ?>"><br>
                        <label for="Code_Postal">Code Postal</label>
                        <input type="number" id="Code_Postal" name="Code_Postal" value= "<?php echo $row['Code_Postal'] ?>"><br>
                        <label for="Rue">Nom de la rue</label>
                        <input type="text" id="Rue" name="Rue" value=" <?php echo $row['Rue'] ?>"><br>
                        <label for="Address">Numéro du batîment</label>
                        <input type="number" id="Address" name="Address" value= "<?php echo $row['Numero_rue'] ?>"><br>
                    </fieldset>
                    <label for="Description">Description de la Mission</label>
                    <input type="text" id="Description" name="Description" value= "<?php echo $row['Description'] ?>"><br>
                    <label for="Points">Valeur en nombre de points</label>
                    <input type="number" id="Points" name="Points" value= "<?php echo $row['Points'] ?>"><br>
                    <input type="hidden" id="Mission" name="Mission" value="<?php echo $_GET['i'] ?>">
                    <input type="submit" value="Valider">
                </form>
        <?php
                break;
            case "6":
                $erreur = False;
                foreach ($_POST as $key => $Value) {
                    if (empty($Value)) {
                        $erreur = True;
                        echo "Il manque une valeur pour " . $key . "<br>";
                    }
                }
                if (!date_futur($_POST['Date'])) {
                    $erreur = True;
                    echo "La date est déjà passée.<br>";
                }
                $_POST['Date'] = str_replace('/','-',$_POST['Date']);
                $_POST['Ville'] = str_replace("'","\'",$_POST['Ville']);
                $_POST['Rue'] = str_replace("'","\'",$_POST['Rue']);
                $_POST['Description'] = str_replace("'","\'",$_POST['Description']);
                if (!test_string($_POST['Ville'], 58)) {
                    $erreur = True;
                    echo "Le nom de la ville est trop grand.<br>";
                }
                if (!test_string($_POST['Rue'], 164)) {
                    $erreur = True;
                    echo "Le nom de la rue est trop grand.<br>";
                }
                if (!test_string($_POST['Description'], 500)) {
                    $erreur = True;
                    echo "La Description est limitée à 500 lettres.<br>";
                }

                if ($erreur) {
                    echo '<form action="./missions.php?vu=5&i='.$_POST['Mission'].'" method="post">';
                    echo '<input type="submit" value="Retour vers la modification de la Mission">';
                    echo '</form>';
                } else {
                    
                    $id = is_superviseur();
                    $sql = "update mission set Description = '". $_POST['Description'] . "',  Nombre_Volontaire = " . $_POST['Nombre_v'] .", Date_Mission =  '" . $_POST['Date'] . "', Numero_rue = " . $_POST['Address'] . ", Rue = '". $_POST['Rue'];
                    $sql = $sql . "', Ville = '" . $_POST['Ville'] . "', Code_Postal = " . $_POST['Code_Postal'] . ", Points = " . $_POST['Points'] . ", IdSuperviseur = " . $id . " where IdMission = ". $_POST['Mission'] .";";
                    //echo $sql;
                    $requete = mysqli_query($conn, $sql);
                    if ($requete == FALSE) {
                        echo mysqli_error($conn);
                    }
                }
                break;
                break;
        }
        ?>

</body>

</html>

<?php

function date_futur($date_string)
{
    $date_time = new DateTime($date_string);
    $date_now = new DateTime("now");
    if ($date_now <= $date_time) {
        return TRUE;
    }
    return FALSE;
}

function test_string($string, $taille)
{
    if (strlen($string) <= $taille and strlen($string) > 0) {
        return TRUE;
    }
    return FALSE;
}



/* Plan de modification ;
    selection des missions dans le même departement que le volontaire inutile
    selection des missions que le superviseur a créé (si non administrateur) fait
    modification et suppression des missions fait
*/
?>
</body>
</html>