<?php

use moovie\moovieAdmin\Acteur_Form;
use moovie\moovieAdmin\ActeurDB;
use moovie\moovieAdmin\Template;

require_once "../../config.php" ;
session_start() ;  
require_once $GLOBALS['PHP_DIR'] ."class/Autoloader.php";


Autoloader::register();
ob_start();

$logged = isset($_SESSION['user']) ;

$act = new Acteur_Form();
$acteur = new ActeurDB();

 
 if ($logged) { 

    $id = $_GET['id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nom' => $_POST['nom'] ?? '',
        'photo' => null
    ];

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $photoTmpPath = $_FILES['photo']['tmp_name'];
        $photoName = basename($_FILES['photo']['name']);
        $photoPath = 'uploads/acteurs/' . $photoName;

        if (move_uploaded_file($photoTmpPath, $photoPath)) {
            $data['photo'] = $photoPath;
        } else {
    
            echo "Failed to upload photo.";
            exit();
        }
    }

    if (!empty($data['nom'])) {
        $acteur->updateActeur($data, $id);
        header('Location: acteur.php');
        exit();
    }
}

$act->editForm_Act($id);
 } else {
	header("Location:".$GLOBALS['PAGESUser']."signin.php");
	exit();
 }
 ?>
<!-- Récupère le contenu du buffer (et le vide) -->
<?php $content=ob_get_clean() ?>
<!-- Utilisation du contenu bufferisé -->
<?php Template::render($content) ?>