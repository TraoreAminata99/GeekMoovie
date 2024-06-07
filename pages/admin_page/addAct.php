<?php

use moovie\moovieAdmin\Template;
use moovie\moovieAdmin\Acteur_Form;
use moovie\moovieAdmin\ActeurDB;

require_once "../../config.php" ;
session_start() ;  
require_once $GLOBALS['PHP_DIR'] ."class/Autoloader.php";


Autoloader::register();

ob_start();

$act = new Acteur_Form();
$actDB = new ActeurDB();
$logged = isset($_SESSION['user']) ;
 
 if ($logged) { 

	$data = [
        'pictureActeur' => isset($_FILES['pictureActeur']) ? $_FILES['pictureActeur'] : null,
        'nameActeur' => isset($_POST['nameActeur']) ? $_POST['nameActeur'] : '',
    ];

    // if ($actDB->isExist($data['nameActeur'])) {
    //   $errors['nameActeur'] = "Le titre est requis.";
    //   $act->generateForm_Act();
    // }

    if (empty($data['nameActeur']) || ($actDB->isExist($data['nameActeur']))){
		  $act->generateForm_Act();
    }
    else {
		$act->handleFormSubmission($data);
    }

} else {
	header("Location:".$GLOBALS['PAGESUser']."signin.php");
 }
?>



<!-- Récupère le contenu du buffer (et le vide) -->
<?php $content=ob_get_clean() ?>
<!-- Utilisation du contenu bufferisé -->
<?php Template::render($content) ?>