<?php

session_start();

require_once 'settings/bdd.inc.php';
require_once 'settings/init.inc.php';
require_once 'include/connexion.inc.php';
require_once 'libs/Smarty.class.php';

if ($connect == FALSE) { //permet de protéger l'accès aux articles aux utilisateurs qui ne sont pas conenctés !
    $_SESSION['refuser'] = TRUE;
    header('Location: index.php');
} else {
    echo "";
}

$verifIdExistant = isset($_GET['id']) ? $_GET['id'] : "";


if ($verifIdExistant == "") { // si on n'a pas d'ID dans l'url alors on mets tout à zéro
    $titreArticle = "";
    $texteArticle = "";
    $publieArticle = "";
    $boutonValidation = "Ajouter";
    $tab_articles = NULL;

    if (isset($_POST['Ajouter'])) { //ajouter un article
        $date_ajout = date("Y-m-d"); // création date avec fonction php
        $_POST['date_ajout'] = $date_ajout; // création nouvelle clé dans le tableau
        // condition ternaire
        $_POST['publie'] = isset($_POST['publie']) ? 1 : 0;

        // INSERTION des données du formulaire dans la BDD
        if ($_FILES['image']['error'] == 0) { //si pas d'erreur
            $sth = $bdd->prepare("INSERT INTO articles (titre, texte, date, publie) VALUES (:titre, :texte, :date, :publie)"); // requête préparée + mise de la date en français
            $sth->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR); // définie le pointeur de :titre afin d'éviter les injections sql
            $sth->bindValue(':texte', $_POST['texte'], PDO::PARAM_STR); // définie le pointeur de :texte afin d'éviter les injections sql
            $sth->bindValue(':date', $_POST['date_ajout'], PDO::PARAM_STR); // définie le pointeur de :date afin d'éviter les injections sql
            $sth->bindValue(':publie', $_POST['publie'], PDO::PARAM_BOOL); // définie le pointeur de :publie afin d'éviter les injections sql
            $sth->execute(); // execute la reqûete $sth
            $dernier_id = $bdd->lastInsertId();
            //echo $dernier_id;
            move_uploaded_file($_FILES['image']['tmp_name'], dirname(__FILE__) . "/img/$dernier_id.jpg");

            $_SESSION['notification_ajout'] = TRUE;

            //header('Location: article.php');
        } else { //si erreurs
            echo 'Image erreur ';
        }
    }

    if (isset($_POST['Modifier'])) { // pour la modification d'un article
        $idArticle = $_POST['id'];
        $sth = $bdd->prepare("UPDATE articles set titre = :titre, texte = :texte where id = $idArticle"); // requête préparée + mise de la date en français
        // "UPDATE articles SET titre='$titre', texte='$texte', publie='$publie' where id='$id'";       /// requete du prof
        $sth->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR); // définie le pointeur de :titre afin d'éviter les injections sql
        $sth->bindValue(':texte', $_POST['texte'], PDO::PARAM_STR); // définie le pointeur de :texte afin d'éviter les injections sql
        $sth->execute(); // execute la reqûete $sth
        $dernier_id = $bdd->lastInsertId();

        $_SESSION['notification_modif'] = TRUE;

        //header('Location: index.php');
    }
} else { // code pour afficher les articles si on a un ID dans l'URL /obligé de mettre un else sinon les notifications fonctionnent pas)
    $requete = $bdd->prepare("select * from articles"); // requête préparée pour récuperer les infos des articles
    //$requete->bindValue(':publie', 1, PDO::PARAM_INT); // définie le pointeur de :publie afin d'éviter les injections sql
    $requete->execute(); // execute la reqûete $requete
    $tab_articles = $requete->fetchAll(PDO::FETCH_BOTH); // permet d'afficher les résultats de la requête

    $titreArticle = $tab_articles[$_GET['id'] - 1]['titre']; // je dois faire -1 car sinon j'ai le titre de l'article suivant qui s'affiche
    $texteArticle = $tab_articles[$_GET['id'] - 1]['texte'];
    $publieArticle = "checked";
    $boutonValidation = "Modifier";
    $identifiantArticle = $_GET['id'];
}

/* * ***************** VARIABLES SMARTY ****************** */
$smarty = new Smarty();

$smarty->setTemplateDir('templates/');
$smarty->setCompileDir('templates_c/');
//$smarty->setConfigDir('/web/www.example.com/guestbook/configs/');
//$smarty->setCacheDir('/web/www.example.com/guestbook/cache/');

if (isset($_SESSION['notification_ajout'])) {
    $smarty->assign('notification_ajout', $_SESSION['notification_ajout']);
}
unset($_SESSION['notification_ajout']);


//$smarty->debugging=TRUE;
if (isset($_SESSION['notification_modif'])) {
    $smarty->assign('notification_modif', $_SESSION['notification_modif']);
}
unset($_SESSION['notification_modif']);

/* * **************** assigner les variables pour pouvoir les utiliser sur les fichier tpl ********************** */
$smarty->assign('tab_articles', $tab_articles);
$smarty->assign('textArtcle', $texteArticle);
$smarty->assign('publieArticle', $publieArticle);
$smarty->assign('boutonValidation', $boutonValidation);
$smarty->assign('verifIdExistant', $verifIdExistant);


include_once 'include/header.inc.php';
$smarty->display('article.tpl'); // affiche le code html de article.tpl
include_once 'include/menu.inc.php';
include_once 'include/footer.inc.php';
