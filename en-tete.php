<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet" id="bootstrap-css">

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<link rel="stylesheet" href="./styles.css" />

<div class="container-fluid bg-success" id="div-en-tete">
    <div class="row">


        <div class="col-2 align-self-start">
            <img src="./logo.png" alt="Logo du Poin" width="100%">
        </div>
        <div class="col-8 center-block align-self-center">
            <h1 class="text-center bolder-weight-text" id="text-camping">Green Wifi Corp</h1>
        </div>
        <div class="col-2 right-block text-right">
            <?php
            if (!isset($_SESSION['id_user'])) {
                echo '<a href="./login.php" class="text-light">Se connecter</a>';
                echo '<br>';
                echo '<a href="./Creation_compte.php?c=test" class="text-light">S\'inscrire</a>';
            } else {

                echo '<p class="text-light">Connecté en tant que :' . $_SESSION['prenom_user'] . '</p>';
                echo '<br><br><p class="text-light">';
                echo  $_SESSION['type'];
                echo '</p><br><br><a href="./index.php?logout=1" class="text-light">Se deconnecter</a><br><br>';
            }
            ?>

        </div>
    </div>
</div>
</body>

</html>