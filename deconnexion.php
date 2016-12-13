<?php

session_start();
setcookie('sid', '', 1); //permet de changer le temps du cookie à 1 sec il expire donc 1 seconde après la déconnexion
$_SEESSION['deconnect'] = TRUE; // mets la variable de session deconnect active
header('Location: index.php'); // redirection sur la page index
