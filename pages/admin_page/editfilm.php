<?php

use moovie\moovieAdmin\Film_Form;
use moovie\moovieAdmin\FilmDB;
use moovie\moovieAdmin\Template;

require_once "../../config.php";
session_start();
require_once $GLOBALS['PHP_DIR'] . "class/Autoloader.php";

Autoloader::register();

$logged = isset($_SESSION['user']);

ob_start();
$film = new Film_Form();
$filmDB = new FilmDB();

if ($logged) {
    $id = $_GET['id'];
    $errors = [];
    $data = [
        'titre' => '',
        'date_sortie' => '',
        'min_film' => '',
        'synopsis' => '',
        'id_real' => '',
        'vu' => '',
        'affiche' => null,
        'acteurs' => [],
        'tags' => []
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'titre' => $_POST['titre'] ?? '',
            'date_sortie' => $_POST['date_sortie'] ?? '',
            'min_film' => $_POST['min_film'] ?? '',
            'synopsis' => $_POST['synopsis'] ?? '',
            'id_real' => $_POST['id_real'] ?? '',
            'vu' => $_POST['vu'] ?? '',
            'affiche' => null,
            'acteurs' => $_POST['acteurs'] ?? [],
            'tags' => $_POST['tags'] ?? []
        ];
        if (isset($_FILES['affiche']) && $_FILES['affiche']['error'] === UPLOAD_ERR_OK) {
            $photoTmpPath = $_FILES['affiche']['tmp_name'];
            $photoName = basename($_FILES['affiche']['name']);
            $photoPath = 'uploads/' . $photoName;

            if (move_uploaded_file($photoTmpPath, $photoPath)) {
                $data['affiche'] = $photoPath;
            } else {
                $errors['affiche'] = "Échec de l'upload de l'image.";
            }
        }

        // Validation des champs
        if (empty($data['titre'])) {
            $errors['titre'] = "Le titre est requis.";
        }
        if (empty($data['synopsis'])) {
            $errors['synopsis'] = "Le synopsis est requis.";
        }
        if (empty($data['date_sortie'])) {
            $errors['date_sortie'] = "La date de sortie est requise.";
        }
        if (empty($data['min_film'])) {
            $errors['min_film'] = "La durée du film est requise.";
        }
        if (empty($data['id_real'])) {
            $errors['id_real'] = "Le réalisateur est requis.";
        }
        if (empty($data['acteurs'])) {
            $errors['acteurs'] = "Au moins un acteur est requis.";
        }
        if (empty($data['tags'])) {
            $errors['tags'] = "Au moins un genre est requis.";
        }
        
        // Si aucune erreur, mettre à jour le film
        if (empty($errors)) {
            try {
                $filmDB->updateFilm($data, $id);
                // var_dump($data);
                // echo "ouhgougo";
                header('Location: film.php');
                exit();
            } catch (Exception $e) {
                $errors['database'] = "Échec de la mise à jour du film: " . $e->getMessage();
            }
        } else {
            $_SESSION['errors'] = $errors;
            $_SESSION['data'] = $data;
        }
    }

    $film->editForm_Film($id, $errors, $data);
} else {
    header("Location:".$GLOBALS['PAGESUser']."signin.php");
    exit();
}
?>
<!-- Récupère le contenu du buffer (et le vide) -->
<?php $content = ob_get_clean() ?>
<!-- Utilisation du contenu bufferisé -->
<?php Template::render($content) ?>
