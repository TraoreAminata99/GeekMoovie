<?php

use moovie\moovieAdmin\FilmDB;

require_once "../../config.php";
require_once $GLOBALS['PHP_DIR'] . "class/Autoloader.php";
Autoloader::register();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    var_dump($_POST);
    $filmId = $_POST['film_id'];
    
    $filmDB = new FilmDB();
    $filmDB->markAsSeen($filmId);
    var_dump(($filmDB));
    // Redirigez l'utilisateur vers la page précédente
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}
