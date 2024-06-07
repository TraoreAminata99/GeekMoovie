<?php
use moovie\moovieAdmin\FilmDB;

require_once "../../config.php";
require_once $GLOBALS['PHP_DIR'] . "class/Autoloader.php";

Autoloader::register();

// Vérifie si l'ID du film est fourni
if (isset($_POST['id'])) {
    $filmId = intval($_POST['id']);
    
    // Crée une instance de FilmDB
    $filmDB = new FilmDB();
    
    // Ajoute le film aux favoris (ou gère cela comme vous le souhaitez)
    $result = $filmDB->addToFavorites($filmId); // Vous devez implémenter cette méthode dans votre classe FilmDB
    header("Location:../../pages/user_page/");
    
    if ($result) {
        echo 'success';
      
    } else {
        echo 'error';
    }
} else {
    echo 'No film ID provided';
}
?>
