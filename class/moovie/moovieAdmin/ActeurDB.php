<?php

namespace moovie\moovieAdmin;

use Exception;
use PDO;
use pdo_wrapper\PdoWrapper;

include __DIR__ . "../../../../DB_CREDENTIALS.php" ;
class ActeurDB extends PdoWrapper
{
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

     /* tous les acteurs */
    public function getAllActeur()
    {
        return parent::exec("SELECT * FROM acteur ORDER BY nom", null);
    }

    public function getFilm_Acteur() {
        $query = "SELECT DISTINCT id_act FROM film_acteur";
        return $this->exec($query,null,null,PDO::FETCH_COLUMN,0);
    }    
     

    public function getActeurById($id) {
        $results = $this->exec("SELECT * FROM acteur WHERE id_act = :id", [':id' => $id]);
        return $results ? $results[0] : null; // Retourne le premier élément ou null si aucun résultat
    }

    public function isExist($name) : bool{
        $result = $this->exec("SELECT nom FROM acteur WHERE nom = :name",[':name'=>$name]);
        return !empty($result);
    }

    public function updateActeur($data, $id)
    {
        $query = 'UPDATE acteur SET nom = :nomAct, photo = :photoAct WHERE id_act = :id';
        $params = [
            ':id' => $id,
            ':nomAct' => $data['nom'],
            ':photoAct' => $data['photo']
        ];

        try {
            $this->exec($query, $params);
        } catch (Exception $e) {
            throw new Exception('Failed to update director: ' . $e->getMessage());
        }
    }

    public function deleteActeur($id){
        try {
            // Début de la transaction
            $this->pdo->beginTransaction();
            
            // Supprimer les enregistrements associés dans film_tag
            $query = 'DELETE FROM film_acteur WHERE id_act = :id';
            $params = [':id' => $id];
            $this->exec($query, $params);
            
            // Supprimer le tag
            $query = 'DELETE FROM Acteur WHERE id_act = :id';
            $this->exec($query, $params);
            
            // Commit de la transaction
            $this->pdo->commit();
        } catch (Exception $e) {
            // Rollback de la transaction en cas d'erreur
            $this->pdo->rollBack();
            // Lever une exception avec un message d'erreur plus détaillé
            throw new Exception('Failed to remove Tag: ' . $e->getMessage());
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
        $dirname = 'uploads/acteurs/';

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
    public function registerActor($data)
    {
        // Insérer un acteur dans la base de données
        $query = 'INSERT INTO acteur(nom, photo) VALUES (:nom, :photo)';
        $params = [
            ':nom' => $data['nameActeur'],
            ':photo' =>$this->addPicture($data['pictureActeur']),
        ];
        $this->exec($query, $params);

        return $this->lastInsertId();
    }

    public function getActorByName($name){
        $query = "SELECT * FROM acteur WHERE SOUNDEX(acteur.nom) LIKE CONCAT('%', SOUNDEX(:name), '%') ";
        $params = [":name" => $name];

        return $this->exec($query, $params);
    }

}