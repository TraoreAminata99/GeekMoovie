<?php

namespace moovie\moovieAdmin;

use Exception;
use PDO;
use pdo_wrapper\PdoWrapper;

include __DIR__ . "../../../../DB_CREDENTIALS.php" ;
class RealisateurDB extends PdoWrapper{
    /**
     * Constructeur de la classe.
     *
     * @param string $db_name Le nom de la base de données.
     */
    public function __construct()
    {

        parent::__construct(
            $GLOBALS['db_name'],
            $GLOBALS['db_host'],
            $GLOBALS['db_port'],
            $GLOBALS['db_user'],
            $GLOBALS['db_pwd']) ;
    }

    /* tous les réalisateurs */
    public function getAllRealisateur()
    {
        return parent::exec("SELECT * FROM realisateur ORDER BY nom", null);
    }

    public function getRealisateurById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM realisateur WHERE id_real = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

   

    public function updateDirector($data, $id)
    {
        $query = 'UPDATE Realisateur SET nom = :nomReal, photo = :photoReal WHERE id_real = :id';
        $params = [
            ':id' => $id,
            ':nomReal' => $data['nom'],
            ':photoReal' => $data['photo']
        ];

        try {
            $this->exec($query, $params);
        } catch (Exception $e) {
            // Handle exception (log it, rethrow it, etc.)
            throw new Exception('Failed to update director: ' . $e->getMessage());
        }
    }

    public function getFilm_Real() {
        $query = "SELECT DISTINCT id_real FROM film";
        return $this->exec($query,null,null,PDO::FETCH_COLUMN,0);
    } //me retourne tous les réalisateurs ayant réalisés un film => c'est un tableau

    public function getDirectorByName($name){
        $query = "SELECT * FROM realisateur WHERE SOUNDEX(realisateur.nom) LIKE CONCAT('%', SOUNDEX(:name), '%') ";
        $params = [":name" => $name];

        return $this->exec($query, $params);
    }

    public function deleteDirector($id){
        $filmDB = new FilmDB();

        // Supprimer tous les films associés au réalisateur
        $films = $filmDB->getFilmsByDirector($id);
        foreach ($films as $film) {
            $filmDB->deleteFilm($film->id_film);
        }

        // Supprimer le réalisateur
        $query = 'DELETE FROM Realisateur WHERE id_real = :id';
        $params = [
            'id' => $id
        ];
        try {
            $this->exec($query, $params);
        } catch (Exception $e) {
            // Handle exception (log it, rethrow it, etc.)
            throw new Exception('Failed to delete director: ' . $e->getMessage());
        }
    } 

    /**
     * @throws Exception
     */
    private function addPicture($file) : string
    {
        // Vérification du type MIME pour s'assurer qu'il s'agit d'une image
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array(mime_content_type($file['tmp_name']), $allowedMimeTypes)) {
            throw new Exception("Le fichier doit être une image (jpg, png, gif).");
        }

        $pictureName = pathinfo($file['name'], PATHINFO_FILENAME) . date("Ymd_His") . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        $dirname = 'uploads/realisateur/';

        // Vérification d'existence (et éventuelle création) du dossier cible
        if (!is_dir($dirname)) {
            mkdir($dirname);
        }

        // Enregistrer le fichier
        if (!move_uploaded_file($file['tmp_name'], $dirname . $pictureName)) {
            throw new Exception("FILE NOT UPLOADED");
        }

        return $dirname . $pictureName;
    }

    /**
     * @throws Exception
     */
    public function registerDirector($data)
    {
        // Insérer un acteur dans la base de données
        $query = 'INSERT INTO realisateur(nom, photo) VALUES (:nom, :photo)';
        $params = [
            ':nom' => $data['nameReal'],
            ':photo' =>$this->addPicture($data['pictureReal']),
        ];
        $this->exec($query, $params);

        return $this->lastInsertId();
    }

    public function isExist($name) : bool{
        $result = $this->exec("SELECT nom FROM realisateur WHERE nom = :name",[':name'=>$name]);
        return empty($result);
    }

}