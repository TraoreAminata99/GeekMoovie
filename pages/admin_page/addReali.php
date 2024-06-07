<?php

use moovie\moovieAdmin\Realisateur_Form;
use moovie\moovieAdmin\Template;
use moovie\moovieAdmin\RealisateurDB;

require_once "../../config.php" ;
session_start() ;  
require_once $GLOBALS['PHP_DIR'] ."class/Autoloader.php";


Autoloader::register();

ob_start();

$real = new Realisateur_Form();
$realDB = new RealisateurDB();
$logged = isset($_SESSION['user']);
 
 if ($logged) { 

	$data = [
        'pictureReal' => isset($_FILES['pictureReal']) ? $_FILES['pictureReal'] : null,
        'nameReal' => isset($_POST['nameReal']) ? $_POST['nameReal'] : '',
    ];

    if (!$realDB->isExist($data['nameReal']) || (empty($data['nameReal']))){
      $real->generateForm_Real();
    }else {
		  $real->handleFormSubmission($data);
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