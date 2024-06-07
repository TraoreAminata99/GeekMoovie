<?php

use moovie\moovieAdmin\Realisateur_Form;
use moovie\moovieAdmin\RealisateurDB;
use moovie\moovieAdmin\Template;

require_once "../../config.php" ;
session_start() ;  
require_once $GLOBALS['PHP_DIR'] ."class/Autoloader.php";


Autoloader::register();

$logged = isset($_SESSION['user']) ;

 ob_start();
 $reals = new Realisateur_Form();
 $director = new RealisateurDB();
 

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
            $photoPath = 'uploads/realisateur/' . $photoName;

            if (move_uploaded_file($photoTmpPath, $photoPath)) {
                $data['photo'] = $photoPath;
            } else {
        
                echo "Failed to upload photo.";
                exit();
            }
        }

        if (!empty($data['nom'])) {
            $director->updateDirector($data, $id);
            header('Location: realisateur.php');
            exit();
        }
    }

    $reals->editForm_Real($id);
    if($id == -12){
        $director->deleteDirector(1);
    }

} else {
    header("Location:".$GLOBALS['PAGESUser']."signin.php");
    exit();
}
 ?>
<!-- Récupère le contenu du buffer (et le vide) -->
<?php $content=ob_get_clean() ?>
<!-- Utilisation du contenu bufferisé -->
<?php Template::render($content) ?>