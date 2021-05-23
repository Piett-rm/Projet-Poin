<?php
include '../connexion.php';
$sql = "delete from mission where IdMission = " . $_GET['i'] .";";
$requete = mysqli_query($conn, $sql);
if ($requete == FALSE) {
    echo mysqli_error($conn);
}
header('location: ./missions.php');
?>