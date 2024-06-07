<?php

use moovie\moovieAdmin\Tag_Form;
use moovie\moovieAdmin\TagDB;
use moovie\moovieAdmin\Template;

require_once "../../config.php" ;
session_start() ;  
require_once $GLOBALS['PHP_DIR'] ."class/Autoloader.php";


Autoloader::register();

$logged = isset($_SESSION['user']) ;

 ob_start();
 $genre = new Tag_Form();
 $genreDB = new TagDB();

 if ($logged) { 

	$id = $_GET['id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'nom' => $_POST['nom'] ?? ''
        ];

        if (!empty($data['nom'])) {
            $genreDB->updateTag($data, $id);
            header('Location: genre.php');
            exit();
        }
    }

    $genre->editForm_Tag($id);

	}
	else {
	header("Location:".$GLOBALS['PAGESUser']."signin.php");
	exit();
 }
 ?>
<!-- Récupère le contenu du buffer (et le vide) -->
<?php $content=ob_get_clean() ?>
<!-- Utilisation du contenu bufferisé -->
<?php Template::render($content) ?>