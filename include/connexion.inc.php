<?php

$connect = FALSE;

if (isset($_COOKIE['sid']) && !empty($_COOKIE['sid'])) {
	$sid = $_COOKIE['sid'];
	$sth = $bdd->prepare("SELECT * FROM utilisateurs WHERE sid = :sid");
	$sth->bindValue(':sid', $_COOKIE['sid'], PDO::PARAM_STR); // définie le pointeur de :titre afin d'éviter les injections sql
	$sth->execute();
	$tab_connexion	 = $sth->fetchAll(PDO::FETCH_ASSOC); // permet d'afficher les résultats de la requête
	$rowCount = $sth->rowCount();

	if($rowCount == 0) {
		$connect = FALSE;
	} elseif ($rowCount > 0) {
		$connect = TRUE;
	}
}