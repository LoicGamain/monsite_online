<?php

session_start();
require_once 'settings/bdd.inc.php';
require_once 'settings/init.inc.php';
require_once 'include/connexion.inc.php';
require_once 'libs/Smarty.class.php';

if(isset ($_GET['commentaire'])) { //permet de tester si on clic que le lien commentaire d'un article
    $commentaire = $_GET['commentaire']; // variable pour voir si on a cliqué sur les commentaires d'un article
    
    $smarty = new Smarty();
    $smarty->debugging=TRUE;
    $smarty->setTemplateDir('templates/');
    $smarty->setCompileDir('templates_c/');
    //$smarty->setConfigDir('/web/www.example.com/guestbook/configs/');
    //$smarty->setCacheDir('/web/www.example.com/guestbook/cache/');
    
    $smarty->assign('commentaire', $commentaire);
    
} 


/* * ************************************************************** */
/* * *******************CODE PAGINATION *************************** */
/* * ************************************************************** */

$nombreArticle = 2; // on veux afficher 2 articles par pages

$pageCourante = (isset($_GET['p']) ? $_GET['p'] : 1); // permet de récupèrer le numéro de la page courante par la méthode GET

$articleDepart = ($pageCourante - 1) * $nombreArticle; // permet d'avoir l'article de départ, on fait -1 car c'est un tableau d'articles commençant par 0 

$sql = $bdd->prepare("SELECT COUNT(*) as nbArticles FROM articles WHERE publie = :publie"); // permet de compter le nombre d'article en BDD ayant publie de cocher
$sql->bindValue(':publie', 1, PDO::PARAM_INT); // définie le pointeur de :publie afin d'éviter les injections sql
$sql->execute(); // execute la requete $sql
$tab_articles = $sql->fetchAll(PDO::FETCH_ASSOC);
//print_r($tab_articles);

$nombreArticlesAuTotal = $tab_articles[0]['nbArticles']; // permet de récuperer le résultat du tableau et de le mettre dans une variable

$nbPages = ceil($nombreArticlesAuTotal / $nombreArticle);



/* * ************************************************************** */
/* * **************** CODE POUR AFFICHAGE DES ARTICLES ************* */
/* * ************************************************************** */

$sth = $bdd->prepare("select id, titre, texte, DATE_FORMAT (date, '%d/%m/%Y') as date_fr from articles where publie = :publie LIMIT $articleDepart, $nombreArticle"); // requête préparée + mise de la date en français
$sth->bindValue(':publie', 1, PDO::PARAM_INT); // définie le pointeur de :publie afin d'éviter les injections sql
$sth->execute(); // execute la reqûete $sth
$tab_articles = $sth->fetchAll(PDO::FETCH_BOTH); // permet d'afficher les résultats de la requête
//$dernier_id = $sth->lastInsertId();
//print_r($tab_articles);




/* * ******************************************************** */
/* * ***************** VARIABLES SMARTY ****************** */
/* * ******************************************************** */
$smarty = new Smarty();

$smarty->setTemplateDir('templates/');
$smarty->setCompileDir('templates_c/');
//$smarty->setConfigDir('/web/www.example.com/guestbook/configs/');
//$smarty->setCacheDir('/web/www.example.com/guestbook/cache/');

if (isset($_SESSION['refuser'])) { //variable session pour notification de non connexion
    $smarty->assign('refuser', $_SESSION['refuser']);
}
unset($_SESSION['refuser']);

if (isset($_SESSION['deconnect'])) { // variable de session  de la déconnexion
    $smarty->assign('deconnect', $_SESSION['deconnect']);
}
unset($_SESSION['deconnect']);

if (isset($_SESSION['id'])) {  //variable de ssesion de bienvenue
    $smarty->assign('id', $_SESSION['id']);
}
unset($_SESSION['id']);

if (isset($_SESSION['supprimer'])) {  //variable de ssesion de bienvenue
    $smarty->assign('supprimer', $_SESSION['supprimer']);
}
unset($_SESSION['supprimer']);

//$smarty->debugging=TRUE;
$smarty->assign('tab_articles', $tab_articles);
$smarty->assign('connect', $connect);
$smarty->assign('nbPages', $nbPages);
$smarty->assign('pageCourante', $pageCourante);

//$smarty->debugging=TRUE;
include_once 'include/header.inc.php';
$smarty->display('index.tpl'); // affiche le code html de article.tpl
include_once 'include/menu.inc.php';
include_once 'include/footer.inc.php';
?>