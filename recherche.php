<?php

require_once 'settings/bdd.inc.php';
require_once 'settings/init.inc.php';
require_once 'include/connexion.inc.php';
require_once 'libs/Smarty.class.php';

/*********** VARIABLES POUR LA PAGINATION ****************/
$nombreArticle = 2; // on veux afficher 2 articles par pages

$pageCourante = (isset($_GET['p']) ? $_GET['p'] : 1); // permet de récupèrer le numéro de la page courante par la méthode GET

$articleDepart = ($pageCourante - 1) * $nombreArticle; // permet d'avoir l'article de départ, on fait -1 car c'est un tableau d'articles commençant par 0 

/******************* FIN VARIABLE POUR LA PAGINATION *******************/


$recherche = $_GET['recherche'];

$sth = $bdd->prepare("SELECT id, titre, texte, publie, DATE_FORMAT (date, '%d/%m/%Y') as date_fr from articles WHERE (titre LIKE :recherche OR texte LIKE :recherche) LIMIT $articleDepart, $nombreArticle");
$sth->bindValue(':recherche', "%$recherche%", PDO::PARAM_STR);
$sth->execute();

$count = $sth->rowCount(); //compte le nbre de ligne dans le résultat de la requête
if ($count >= 0) {
    $tab_recherches = $sth->fetchAll(PDO::FETCH_ASSOC);
} else {
    $tab_recherches = null;
}

/* * ************************************************************** */
/* * *******************CODE PAGINATION *************************** */
/* * ************************************************************** */

$sql = $bdd->prepare("SELECT COUNT(*) as nbArticles from articles WHERE (titre LIKE :recherche OR texte LIKE :recherche)"); // permet de compter le nombre d'article en BDD ayant publie de cocher
$sql->bindValue(':recherche', "%$recherche%", PDO::PARAM_STR);
$sql->execute(); // execute la requete $sql
$nbArticles = $sql->fetchAll(PDO::FETCH_ASSOC);


$nombreArticlesAuTotal = $nbArticles[0]['nbArticles']; // permet de récuperer le résultat du tableau et de le mettre dans une variable

$nbPages = ceil($nombreArticlesAuTotal / $nombreArticle);



/* * ************************************************************** */
/* * ***************** VARIABLES SMARTY ****************** */
/* * ************************************************************** */

$smarty = new Smarty();

$smarty->setTemplateDir('templates/');
$smarty->setCompileDir('templates_c/');
//$smarty->setConfigDir('/web/www.example.com/guestbook/configs/');
//$smarty->setCacheDir('/web/www.example.com/guestbook/cache/');

/*if (isset($_SESSION['deconnect'])) { // variable de session  de la déconnexion
    $smarty->assign('deconnect', $_SESSION['deconnect']);
}
unset($_SESSION['deconnect']);*/

$smarty->assign('tab_recherches', $tab_recherches);
$smarty->assign('recherche', $recherche);
$smarty->assign('nbPages', $nbPages);
$smarty->assign('pageCourante', $pageCourante);
$smarty->assign('nombreArticlesAuTotal', $nombreArticlesAuTotal);

//$smarty->debugging = TRUE;
include_once 'include/header.inc.php';
$smarty->display('recherche.tpl'); // affiche le code html de recherche.tpl
include_once 'include/menu.inc.php';
include_once 'include/footer.inc.php';
