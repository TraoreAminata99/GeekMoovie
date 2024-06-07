<?php

use moovie\moovieAdmin\Template;
use moovie\moovieAdmin\Film_Form;

require_once "../../config.php" ;
session_start() ;  
require_once $GLOBALS['PHP_DIR'] ."class/Autoloader.php";


Autoloader::register();

ob_start();

$film = new Film_Form();
$logged = isset($_SESSION['user']) ;
 
 if ($logged) { 
    $data = [
        'affiche' => isset($_FILES['affiche']) ? $_FILES['affiche'] : null,
        'titre' => isset($_POST['titre']) ? $_POST['titre'] : '',
        'synopsis' => isset($_POST['synopsis']) ? $_POST['synopsis'] : '',
        'date_sortie' => isset($_POST['date_sortie']) ? $_POST['date_sortie'] : '',
        'min_film' => isset($_POST['min_film']) ? $_POST['min_film'] : '',
        'nameReal' => isset($_POST['nameReal']) ? $_POST['nameReal'] : '',
        'acteurs' => isset($_POST['acteurs']) ? $_POST['acteurs'] : [],
        'tags' => isset($_POST['tags']) ? $_POST['tags'] : []
    ];

    if (empty($data['titre']) || empty($data['synopsis']) || empty($data['date_sortie']) || empty($data['min_film']) || empty($data['nameReal']) || !is_array($data['acteurs']) || !is_array($data['tags']) || count($data['acteurs']) === 0 || count($data['tags']) === 0) {
        $film->generateFilm_Form(); 
    } else {
        $film->handleFormSubmission($data);
    }
    
} else {
	header("Location:".$GLOBALS['PAGESUser']."signin.php");
	# code...
 }
?>

<!-- Récupère le contenu du buffer (et le vide) -->
<?php $content=ob_get_clean() ?>
<!-- Utilisation du contenu bufferisé -->
<?php Template::render($content) ?>