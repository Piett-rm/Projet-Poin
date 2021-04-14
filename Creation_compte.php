<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Expires" content="0">
    <link rel="stylesheet" href="styles.css" />
</head>

<body>
    <?php
    include("../connexion.php");

    //on met l'en-tete
    include("./en-tete.php");




    if (!isset($_GET['c'])) {
        die();
    }

    switch ($_GET['c']) {

        case 'add':
            foreach ($_GET as $key => $Value) {
                if (empty($Value)) {
                    die("Il manque une valeur pour " . $key);
                }
            }



            $sql = "INSERT INTO personne (Code_Postal, Telephone, nom, Email, prenom, Mots_de_passe, Nom_Utilisateur) values
            ('" . $_GET['Code_Postal'] . "','" . $_GET['tel_pers'] . "','" . $_GET['nom_pers'] . "','" . $_GET['mail_pers'] . "','" . $_GET['prenom_pers'] . "','" . $_GET['mdp_pers'] . "','" . $_GET['utilisateur_pers'] . "')";
            $resultat = mysqli_query($conn, $sql);
            if ($resultat == FALSE) { //si on peut pas ajouter

                die("<br>Echec d'execution de la requete : " . $sql);
            } else {
                $sql = "SELECT * FROM personne where Nom_Utilisateur='" . $_GET['utilisateur_pers'] . "'";
                $resultat = mysqli_query($conn, $sql);
                if (mysqli_num_rows($resultat) == 1) {
                    $row = mysqli_fetch_assoc($resultat);
                    echo "Votre compte a été créé, vous pouvez maintenant vous connecter";
                    $sql = "INSERT INTO Volontaire (IdPersonne ,Date_Inscription) values ('" . $row['IdPersonne'] . "',NOW())";
                    $resultat = mysqli_query($conn, $sql);
                    if ($resultat == FALSE) { //si on peut pas ajouter

                        die("<br>Echec d'execution de la requete : " . $sql);
                    }
                }
            }


            break;



        default: //créer un compte si on est client lambda
    ?>

            <div class="container">
                <div class=" text-center mt-5 ">
                    <h1>Inscription</h1>
                </div>
                <div class="row ">
                    <div class="col-lg-7 mx-auto">
                        <div class="card mt-2 mx-auto p-4 bg-light">
                            <div class="card-body bg-light">
                                <div class="container">
                                    <form id="contact-form" role="form" action="./Creation_compte.php" method="get">
                                        <div class="controls">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label for="prenom_pers">Prénom</label> <input id="prenom_pers" type="text" name="prenom_pers" class="form-control" placeholder="Entrez votre prénom" required="required" data-error="Entrez votre prénom."> </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label for="nom_pers">Nom</label> <input id="nom_pers" type="text" name="nom_pers" class="form-control" placeholder="Entrez votre nom de famille" required="required" data-error="Entrez votre nom de famille."> </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label for="mail_pers">Email</label> <input id="mail_pers" type="email" name="mail_pers" class="form-control" placeholder="Entrez votre email" required="required" data-error="Entrez un email valide."> </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label for="mdp_pers">Mot de passe</label> <input id="mdp_pers" type="password" name="mdp_pers" class="form-control" placeholder="Entrez votre mot de passe" required="required" data-error="Entrez votre mot de passe" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"> </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label for="tel_pers">Telephone</label> <input id="tel_pers" type="text" name="tel_pers" class="form-control" placeholder="Entrez votre telephone" required="required" data-error="Entrez votre telephone"> </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label for="adresse_pers">Nom d'utilisateur</label> <input id="utilisateur_pers" type="text" name="utilisateur_pers" class="form-control" placeholder="Entrez votre Nom d'utilisateur" required="required" data-error="Entrez votre Nom d'utilisateur"> </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label for="Code_Postal">Code Postal</label> <input id="Code_Postal" type="text" name="Code_Postal" class="form-control" placeholder="Entrez votre code postal" required="required" data-error="Entrez votre code postal"> </div>
                                                </div>


                                                <div class="row">
                                                    <input type="hidden" name="c" value="add">
                                                    <div class="col-md-12"> <input type="submit" class="btn btn-success btn-send pt-2 btn-block " value="S'inscrire"> </div>
                                                </div>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    <?php
            break;
    }
    ?>


</body>
<br><br>

</html>