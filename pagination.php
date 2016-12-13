
<!--Résultat : Page courante, Index de départ de la requête, Index d'arrivée

Déclarer la variable du nombre d'articles par page

Variable qui contient la page courante

Calculer l'index de départ de la requete -->

<?php
require_once 'settings/bdd.inc.php';
require_once 'settings/init.inc.php';

/* $nombreArticle = 2; // on veux afficher 2 articles par pages

  $pageCourante = (isset ($_GET['p']) ? $_GET['p'] : 1) ; // permet de récupèrer le numéro de la page courante par la méthode GET

  $nbPages = ceil($nombreArticlesAuTotal / $nombreArticle);

  $articleDepart = ($pageCourante - 1) * $nombreArticle; // permet d'avoir l'article de départ, on fait -1 car c'est un tableau d'articles commençant par 0 */

$sql = $bdd->prepare("SELECT COUNT(*) as nbArticles FROM articles WHERE publie = :publie"); // permet de compter le nombre d'article en BDD ayant publie de cocher
$sql->bindValue(':publie', 1, PDO::PARAM_INT); // définie le pointeur de :publie afin d'éviter les injections sql
$sql->execute(); // execute la requete $sql
$tab_articles = $sql->fetchAll(PDO::FETCH_ASSOC);
//print_r($tab_articles);

$nombreArticlesAuTotal = $tab_articles[0]['nbArticles']; // permet de récuperer le résultat du tableau et de le mettre dans une variable

echo "<br/><h2><b>Page : " . $pageCourante . "";
echo "<br/><h2><b>Article de départ :  " . $articleDepart . "";
echo "<br/>Le nombre article total en BDD : " . $nombreArticlesAuTotal . " ";

function returnIndex() {
    //calcul des éléments
    $nombreArticle = 2; // on veux afficher 2 articles par pages

    $pageCourante = (isset($_GET['p']) ? $_GET['p'] : 1); // permet de récupèrer le numéro de la page courante par la méthode GET
    //$nbPages = ceil($nombreArticlesAuTotal / $nombreArticle);

    $articleDepart = ($pageCourante - 1) * $nombreArticle; // permet d'avoir l'article de départ, on fait -1 car c'est un tableau d'articles commençant par 0 
}

$indexDepart = returnIndex($_GET['p']);
echo "</br>La fonction affiche :" . $indexDepart . "";
