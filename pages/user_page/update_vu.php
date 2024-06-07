<?php
require_once "../../config.php";

use moovie\moovieAdmin\FilmDB;

session_start();
require_once $GLOBALS['PHP_DIR'] . "class/Autoloader.php";

Autoloader::register();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id_film = $data['id_film'] ?? null;

    if ($id_film) {
        $filmDB = new FilmDB();
        $result = $filmDB->markAsSeen($id_film);

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'ID du film manquant.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Requête non valide.']);
}
?>
