<?php

namespace moovie\moovieAdmin;

use Exception;
use PDO;
use pdo_wrapper\PdoWrapper;

include __DIR__ . "../../../../DB_CREDENTIALS.php" ;

/**
 * Classe FilmDB pour gérer les films dans la base de données.
 */
class TagDB extends PdoWrapper
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

    /* tous les tags */
    public function getAllTag()
    {
        return parent::exec("SELECT * FROM tag ORDER BY nom", null);
    }

    public function getTagById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM tag WHERE id_tag = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getTagByName($name){
        $query = "SELECT * FROM tag WHERE SOUNDEX(tag.nom) LIKE CONCAT('%', SOUNDEX(:name), '%') ";
        $params = [":name" => $name];

        return $this->exec($query, $params);
    }
    
    public function updateTag($data, $id)
    {
        $query = 'UPDATE tag SET nom = :nomTag WHERE id_tag = :id';
        $params = [
            ':id' => $id,
            ':nomTag' => $data['nom']
        ];

        try {
            $this->exec($query, $params);
        } catch (Exception $e) {
            throw new Exception('Failed to update tag: ' . $e->getMessage());
        }
    }

    public function deleteTag($id){
        try {
            // Début de la transaction
            $this->pdo->beginTransaction();
            
            // Supprimer les enregistrements associés dans film_tag
            $query = 'DELETE FROM film_tag WHERE id_tag = :id';
            $params = [':id' => $id];
            $this->exec($query, $params);
            
            // Supprimer le tag
            $query = 'DELETE FROM Tag WHERE id_tag = :id';
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
    public function registerTags($data)
    {
        // Insérer un tag dans la base de données
        $query = 'INSERT INTO tag (nom) VALUES (:nom)';
        $params = [
            ':nom' => $data['nameTag']
        ];
        $this->exec($query, $params);

        return $this->lastInsertId();
    }

    public function isExist($name) : bool{
        $result = $this->exec("SELECT nom FROM tag WHERE nom = :name",[':name'=>$name]);
        return !empty($result);
    }

}