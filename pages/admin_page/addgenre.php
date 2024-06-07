<?php

use moovie\moovieAdmin\Tag_Form;
use moovie\moovieAdmin\Template;
use moovie\moovieAdmin\TagDB;

require_once "../../config.php" ;
session_start() ;  
require_once $GLOBALS['PHP_DIR'] ."class/Autoloader.php";


Autoloader::register();

ob_start();

$tag = new Tag_Form();
$tagDB = new TagDB();

$logged = isset($_SESSION['user']) ;
 
 if ($logged) { 

	$data = [
        'nameTag' => isset($_POST['nameTag']) ? $_POST['nameTag'] : ''
    ];

    if(empty($data['nameTag']) || ($tagDB->isExist($data['nameTag']))){
		  $tag->generateForm_Tag();
    } else {
        $tag->handleFormSubmission($data);
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