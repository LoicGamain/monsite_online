<?php
session_start();
require_once 'settings/bdd.inc.php';
require_once 'settings/init.inc.php';

if(isset($_GET['id'])) {
    $idArticle = $_GET['id'];
    $sth = $bdd->prepare("DELETE FROM articles where id = $idArticle"); // requête préparée + mise de la date en français
    $sth->execute(); // execute la reqûete $sth
    $dernier_id = $bdd->lastInsertId();

    $_SESSION['supprimer'] = TRUE;
    header('Location: index.php');

}
        

