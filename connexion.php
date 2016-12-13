<?php

session_start();

require_once 'settings/bdd.inc.php';
require_once 'settings/init.inc.php';
include_once 'include/connexion.inc.php';
require_once 'libs/Smarty.class.php';


if (isset($_POST['connexion'])) {

    $sth = $bdd->prepare("SELECT * FROM utilisateurs WHERE email = :email AND mdp = :mdp");
    $sth->bindValue(':email', $_POST['email'], PDO::PARAM_STR); // définie le pointeur de :titre afin d'éviter les injections sql
    $sth->bindValue(':mdp', $_POST['mdp'], PDO::PARAM_STR); // définie le pointeur de :texte afin d'éviter les injections sql
    $sth->execute();
    $tab_connexion = $sth->fetchAll(PDO::FETCH_ASSOC); // permet d'afficher les résultats de la requête
    $count = $sth->rowCount();


    if ($count == 0) { // si il n'y a pas de couple login/mdp trouvé sur la bdd
        $_SESSION['error'] = TRUE; // création d'une variable de session d'erreur
        header('Location: connexion.php');
    } elseif ($count == 1) { // si il existe un coucple login/mdp identique sur la bdd alors l'utilisateur peut se connecter
        $email = $tab_connexion[0]['email']; // je récupère l'email du tableau $tab_connexion
        $sid = md5($email . time()); // je crée le sid
        $sth = $bdd->prepare("UPDATE utilisateurs set sid = :sid where id=" . $tab_connexion[0]['id'] . ""); // requete préparé pour insérer le sid a l'utilisateur
        $sth->bindValue(':sid', $sid, PDO::PARAM_STR); // définie le pointeur de :titre afin d'éviter les injections sql
        $sth->execute();

        setcookie('sid', $sid, time() + 3600); // création du cookie sid 

        $_SESSION['email'] = $email; // création d'une variable de session avec l'email de l'utilisateur connecté
        $_SESSION['id'] = $tab_connexion[0]['id']; // variable de session avec l'id de l'utilisateur connecté

        header('Location: index.php');
        echo "<div class='alert alert-success alert-dismissible' role='alert'><strong>Bienvenue ! </div>";
    }
}

/* * ***************** VARIABLES SMARTY ****************** */
$smarty = new Smarty();

$smarty->setTemplateDir('templates/');
$smarty->setCompileDir('templates_c/');
//$smarty->setConfigDir('/web/www.example.com/guestbook/configs/');
//$smarty->setCacheDir('/web/www.example.com/guestbook/cache/');

if (isset($_SESSION['error'])) { //pour faire passer la variable de session dans smarty
    $smarty->assign('error', $_SESSION['error']);
}
unset($_SESSION['error']);
//$smarty->debugging = TRUE;

include_once 'include/header.inc.php';
$smarty->display('connexion.tpl'); // affiche le code HTML de connexion.tpl pour la saisie login/password
include_once 'include/menu.inc.php';
include_once 'include/footer.inc.php';

?>