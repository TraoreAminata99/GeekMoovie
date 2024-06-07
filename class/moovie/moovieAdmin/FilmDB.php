<?php

namespace moovie\moovieAdmin;

use Exception;
use PDO;
use pdo_wrapper\PdoWrapper;
use PDOException;

include __DIR__ . "../../../../DB_CREDENTIALS.php" ;

/**
 * Classe FilmDB pour gérer les films dans la base de données.
 */
class FilmDB extends PdoWrapper
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

    /* renvoie tous les films */

    public function getAllFilms()
    {
        $query = "SELECT film.id_film, film.titre, DATE_FORMAT(film.date_sortie,'%d-%m-%Y') As annee, film.affiche, film.synopsis, DATE_FORMAT(film.min_film, '%H:%i') As heure, film.vu,
                        realisateur.nom as realisateur_nom,
                        GROUP_CONCAT(DISTINCT acteur.nom ORDER BY acteur.nom ASC SEPARATOR ', ') as acteurs_noms,
                        GROUP_CONCAT(DISTINCT tag.nom ORDER BY tag.nom ASC SEPARATOR ', ') as tags_noms
                FROM film
                LEFT JOIN realisateur ON film.id_real = realisateur.id_real
                LEFT JOIN film_acteur ON film.id_film = film_acteur.id_film
                LEFT JOIN acteur ON film_acteur.id_act = acteur.id_act
                LEFT JOIN film_tag ON film.id_film = film_tag.id_film
                LEFT JOIN tag ON film_tag.id_tag = tag.id_tag
                GROUP BY film.id_film
                ORDER BY film.titre";
        return parent::exec($query, null);
    }

    //liste tous les films d'un tag

    public function getFilmByTag($tag){
        try {
            $query = "SELECT film.id_film, film.titre, DATE_FORMAT(film.date_sortie,'%d-%m-%Y') As annee, film.affiche, film.synopsis,film.min_film, film.vu,
                            realisateur.nom as realisateur_nom,
                            GROUP_CONCAT(DISTINCT acteur.nom ORDER BY acteur.nom ASC SEPARATOR ', ') as acteurs_noms,
                            GROUP_CONCAT(DISTINCT tag.nom ORDER BY tag.nom ASC SEPARATOR ', ') as tags_noms
                    FROM film
                    LEFT JOIN realisateur ON film.id_real = realisateur.id_real
                    LEFT JOIN film_acteur ON film.id_film = film_acteur.id_film
                    LEFT JOIN acteur ON film_acteur.id_act = acteur.id_act
                    LEFT JOIN film_tag ON film.id_film = film_tag.id_film
                    LEFT JOIN tag ON film_tag.id_tag = tag.id_tag
                    WHERE tag.nom LIKE :tag
                    GROUP BY film.id_film
                    ORDER BY film.titre";
    
            $stmt = $this->pdo->prepare($query);
            $tag = "%{$tag}%";
            $stmt->bindParam(':tag', $tag, PDO::PARAM_STR);
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des films par tag: " . $e->getMessage());
        }
    }
    

// marque un film comme etant vu

    public function markAsSeen($filmId) {
        $query = "UPDATE film SET vu = 1 WHERE id_film = :id";
        $params = [':id' => $filmId];
        try {
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            // Log the error message
            error_log("Error updating film: " . $e->getMessage());
            return false;
        }
    }

    
    // il retourne tous le film correspondant a cet id

    public function getFilmById($id)
    {
        $query = "SELECT film.id_film, film.titre, DATE_FORMAT(film.date_sortie,'%d-%m-%Y') As annee, film.affiche, film.synopsis, DATE_FORMAT(film.min_film, '%H:%i') As heure,film.id_real, film.vu,
                        realisateur.nom as realisateur_nom,
                        GROUP_CONCAT(DISTINCT acteur.id_act ORDER BY acteur.id_act ASC SEPARATOR ', ') as acteurs_id,
                        GROUP_CONCAT(DISTINCT acteur.nom ORDER BY acteur.nom ASC SEPARATOR ', ') as acteurs_noms,
                        GROUP_CONCAT(DISTINCT tag.nom ORDER BY tag.nom ASC SEPARATOR ', ') as tags_noms
                FROM film
                LEFT JOIN realisateur ON film.id_real = realisateur.id_real
                LEFT JOIN film_acteur ON film.id_film = film_acteur.id_film
                LEFT JOIN acteur ON film_acteur.id_act = acteur.id_act
                LEFT JOIN film_tag ON film.id_film = film_tag.id_film
                LEFT JOIN tag ON film_tag.id_tag = tag.id_tag
                WHERE film.id_film = :id
                GROUP BY film.id_film";

        $params = [':id' => $id];
        return parent::exec($query, $params)[0];
    }

    public function getFilmsByActeur($acteurId) {
        // La requête SQL pour récupérer les films dans lesquels l'acteur a joué
        $query = "SELECT f.id_film, f.titre, f.date_sortie, f.affiche, f.synopsis, f.id_real, f.vu, DATE_FORMAT(f.min_film, '%H:%i') AS heure
            FROM film f
            INNER JOIN film_acteur fa ON f.id_film = fa.id_film
            WHERE fa.id_act = :acteurId
        ";
        // Les paramètres de la requête
        $params = [':acteurId' => $acteurId];
    
        // Exécuter la requête et retourner les résultats
        return $this->exec($query, $params);
    }
    
    public function getFilmsByDirector($id) {
        // Requête SQL pour sélectionner tous les films réalisés par un réalisateur
        $query =$this->pdo->prepare( "SELECT `id_film`, `titre`, `date_sortie`, `affiche`, `synopsis`, `id_real`, `vu`, DATE_FORMAT(`min_film`, '%H:%i') AS `min_film` 
                FROM film WHERE id_real = :id_realisateur");
        
        // Paramètres de la requête
       $query->execute([':id_realisateur' => $id]);
        
        // Récupération des résultats sous forme d'objets
        return  $query->fetchAll(PDO::FETCH_OBJ);
    } //me retourne les films réalisés par ce réalisateur
    

    public function updateFilm($data, $id)
    {
      
    // Validation des données
    $vuValue = isset($data['vu']) && ($data['vu'] === '0' || $data['vu'] === '1') ? $data['vu'] : 0;

    $query = 'UPDATE film SET titre = :titreFilm, date_sortie= :date_sortieFilm, affiche = :afficheFilm, synopsis = :synopsisFilm, id_real= :id_realFilm, vu= :vuFilm, min_film= :minFilm WHERE id_film = :id';
    $params = [
        ':id' => $id,
        ':titreFilm' => $data['titre'],
        ':afficheFilm' => $data['affiche'],
        ':date_sortieFilm' => $data['date_sortie'],
        ':synopsisFilm' => $data['synopsis'],
        ':id_realFilm' => $data['id_real'],
        ':vuFilm' => $vuValue,
        ':minFilm' => $data['min_film'],
    ];

    try {
        $this->exec($query, $params);
    } catch (Exception $e) {
        throw new Exception('Failed to update film: ' . $e->getMessage());
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
        $dirname = 'uploads/';

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
    
    public function validateFormData($data) {
        foreach ($data as $key => $value) {
            if (empty($value)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @throws Exception
     */
    public function insertFilm($data)
    {
        // Valider les données du formulaire
        if (!$this->validateFormData($data)) {
            throw new Exception('Invalid form data');
        }
    
        // Récupérer l'ID du réalisateur
        $query = 'SELECT id_real FROM realisateur WHERE nom = :nom';
        $params = [':nom' => $data['nameReal']];
        $result = $this->exec($query, $params);
        if (empty($result)) {
            throw new Exception('Realisateur not found');
        }
        $idRealisateur = $result[0]->id_real;
    
        // Insérer le film dans la base de données
        $query = 'INSERT INTO film (titre, date_sortie, affiche, synopsis, id_real, min_film) VALUES (:titre, :date_sortie, :affiche, :synopsis, :id_real, :min_film)';
        $params = [
            ':titre' => $data['titre'],
            ':date_sortie' => $data['date_sortie'],
            ':affiche' => $this->addPicture($data['affiche']),
            ':synopsis' => $data['synopsis'],
            ':id_real' => $idRealisateur,
            ':min_film' => $data['min_film'],
        ];
        $this->exec($query, $params);
    
        $idFilm = $this->lastInsertId();
    
        // Récupérer les ID des acteurs
        $acteursSelectionnes = $data['acteurs'];
        if (!is_array($acteursSelectionnes)) {
            throw new Exception('Actors data must be an array');
        }
        $query = 'SELECT id_act FROM acteur WHERE nom IN (' . implode(',', array_fill(0, count($acteursSelectionnes), '?')) . ')';
        $resultat = $this->pdo->prepare($query);
        $resultat->execute($acteursSelectionnes);
        $idsActeurs = $resultat->fetchAll(PDO::FETCH_COLUMN);
    
        foreach ($idsActeurs as $idActeur) {
            $this->film_actor($idFilm, $idActeur);
        }
    
        // Récupérer les ID des tags
        $tagsSelectionnes = $data['tags'];
        if (!is_array($tagsSelectionnes)) {
            throw new Exception('Tags data must be an array');
        }
        $query = 'SELECT id_tag FROM tag WHERE nom IN (' . implode(',', array_fill(0, count($tagsSelectionnes), '?')) . ')';
        $resultat = $this->pdo->prepare($query);
        $resultat->execute($tagsSelectionnes);
        $idsTags = $resultat->fetchAll(PDO::FETCH_COLUMN);
    
        foreach ($idsTags as $idTag) {
            $this->film_tag($idFilm, $idTag);
        }
    
        return true;
    }
    
    public function film_actor($idFilm, $idActor)
    {
        $query = 'INSERT INTO film_acteur (id_film, id_act) VALUES (:id_film, :id_act)';
        $params = [
            ':id_film' => $idFilm,
            ':id_act' => $idActor,
        ];
        $this->exec($query, $params);
    }

    public function film_tag($idFilm, $idTag)
    {
        $query = 'INSERT INTO film_tag (id_film, id_tag) VALUES (:id_film, :id_tag)';
        $params = [
            ':id_film' => $idFilm,
            ':id_tag' => $idTag
        ];
        $this->exec($query, $params);
    }


    public function deleteFilm($id){
        $query = "DELETE FROM Film_Acteur WHERE id_film = :id";
        $params = [
            ':id' => $id,
        ];
        try {
            $this->exec($query, $params);
        } catch (Exception $e) {
            // Handle exception (log it, rethrow it, etc.)
            throw new Exception('Failed to update film: ' . $e->getMessage());
        }

        $query = "DELETE FROM Film_Tag WHERE id_film = :id";
        $params = [
            ':id' => $id,
        ];
        try {
            $this->exec($query, $params);
        } catch (Exception $e) {
            // Handle exception (log it, rethrow it, etc.)
            throw new Exception('Failed to update film: ' . $e->getMessage());
        }

        $query = "DELETE FROM Film WHERE id_film = :id";
        $params = [
            ':id' => $id,
        ];
        try {
            $this->exec($query, $params);
        } catch (Exception $e) {
            // Handle exception (log it, rethrow it, etc.)
            throw new Exception('Failed to update film: ' . $e->getMessage());
        }

    }

     // Ajoute un film aux favoris
     public function addToFavorites($filmId) {
        // Exemple de requête SQL pour ajouter un film aux favoris
        $sql = "UPDATE film SET favoris = 1 WHERE id_film = :filmId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':filmId', $filmId, PDO::PARAM_INT);
        return $stmt->execute();
        
    }

    //liste m'envoie les films uniquement
    public function rechercher($word) {
        // Rechercher le film par titre
        $query = "SELECT f.id_film, f.titre, f.date_sortie, f.affiche, f.synopsis, f.id_real, DATE_FORMAT(f.date_sortie,'%d-%m-%Y') As annee, f.vu, DATE_FORMAT(f.min_film, '%H:%i') AS heure,
                GROUP_CONCAT(DISTINCT a.nom) AS acteurs_noms,
                r.nom AS realisateur_nom,
                GROUP_CONCAT(DISTINCT t.nom) AS tags_noms
                FROM 
                    film f
                LEFT JOIN 
                    film_acteur fa ON f.id_film = fa.id_film
                LEFT JOIN 
                    acteur a ON fa.id_act = a.id_act
                LEFT JOIN 
                    realisateur r ON f.id_real = r.id_real
                LEFT JOIN 
                    film_tag ft ON f.id_film = ft.id_film
                LEFT JOIN 
                    tag t ON ft.id_tag = t.id_tag
                WHERE 
                    SOUNDEX(f.titre) LIKE CONCAT('%', SOUNDEX(:word), '%')
                GROUP BY 
                    f.id_film, f.titre, f.date_sortie, f.affiche, f.synopsis, f.id_real, f.vu, f.min_film, r.nom
                ORDER BY 
                    f.titre;
                ";
        $params = [":word" => $word];
        $liste = $this->exec($query, $params);
        //var_dump(array_column($liste,'id_act'));
        
        //rechercher par acteur
        if(empty($liste)){
            //je sélectionne les acteurs dont les noms sonnent comme le nom envoyé
            $query = "SELECT f.id_film, f.titre, f.date_sortie, f.affiche, f.synopsis, f.id_real, f.vu, DATE_FORMAT(f.min_film, '%H:%i') AS heure,
                GROUP_CONCAT(DISTINCT a.nom) AS acteurs_noms,
                r.nom AS realisateur_nom,
                GROUP_CONCAT(DISTINCT t.nom) AS tags_noms
                FROM 
                    film f
                LEFT JOIN 
                    film_acteur fa ON f.id_film = fa.id_film
                LEFT JOIN 
                    acteur a ON fa.id_act = a.id_act
                LEFT JOIN 
                    realisateur r ON f.id_real = r.id_real
                LEFT JOIN 
                    film_tag ft ON f.id_film = ft.id_film
                LEFT JOIN 
                    tag t ON ft.id_tag = t.id_tag
                WHERE 
                    SOUNDEX(a.nom) LIKE CONCAT('%', SOUNDEX(:word), '%')
                GROUP BY 
                    f.id_film, f.titre, f.date_sortie, f.affiche, f.synopsis, f.id_real, f.vu, f.min_film, r.nom
                ORDER BY 
                    f.titre;
                ";
            $params = [":word" => $word];
            $liste = $this->exec($query,$params);}
        //var_dump($liste);
        
        //rechercher par realisateur
        if(empty($liste)){ 
            $query = "SELECT f.id_film, f.titre, f.date_sortie, f.affiche, f.synopsis, f.id_real, f.vu, DATE_FORMAT(f.min_film, '%H:%i') AS heure,
                GROUP_CONCAT(DISTINCT a.nom) AS acteurs_noms,
                r.nom AS realisateur_nom,
                GROUP_CONCAT(DISTINCT t.nom) AS tags_noms
                FROM 
                    film f
                LEFT JOIN 
                    film_acteur fa ON f.id_film = fa.id_film
                LEFT JOIN 
                    acteur a ON fa.id_act = a.id_act
                LEFT JOIN 
                    realisateur r ON f.id_real = r.id_real
                LEFT JOIN 
                    film_tag ft ON f.id_film = ft.id_film
                LEFT JOIN 
                    tag t ON ft.id_tag = t.id_tag
                WHERE 
                    SOUNDEX(r.nom) LIKE CONCAT('%', SOUNDEX(:word), '%')
                GROUP BY 
                    f.id_film, f.titre, f.date_sortie, f.affiche, f.synopsis, f.id_real, f.vu, f.min_film, r.nom
                ORDER BY 
                    f.titre;
                ";
            $params = [":word" => $word];
            $liste = $this->exec($query,$params);
        }
         
        return $liste;
    }
    
    /**
     * Filtre les films en fonction des acteurs et de la date.
     *
     * @param array $idFilmsArray Liste des identifiants des films.
     * @param string $filtrage Type de filtrage à appliquer ("before", "after", "exact").
     * @param string $date Date utilisée pour le filtrage.
     * @return array|false Retourne un tableau de films filtrés ou false en cas d'erreur.
     */
    public function filtre($idFilmsArray, $filtrage, $date){
        $placeholders = implode(',', array_fill(0, count($idFilmsArray), '?'));
        $params = $idFilmsArray;
        $params[] = $date;
        //var_dump($idActeursArray);
        if($filtrage == "before"){
            $query = "SELECT id_film, titre, date_sortie, affiche, synopsis, id_real, vu, DATE_FORMAT(min_film, '%H:%i') AS heure FROM film WHERE id_film IN ($placeholders) and date_sortie < ?";
            
        }else if($filtrage == "after"){
            $query = "SELECT id_film, titre, date_sortie, affiche, synopsis, id_real, vu, DATE_FORMAT(min_film, '%H:%i') AS heure FROM film WHERE id_film IN ($placeholders) and date_sortie > ?";

        }else{
            $query = "SELECT id_film, titre, date_sortie, affiche, synopsis, id_real, vu, DATE_FORMAT(min_film, '%H:%i') AS heure FROM film WHERE id_film IN ($placeholders) and date_sortie = ?";
        }
    
        return $this->exec($query, $params);

    }
    
    public function rechercherByDateHeure($date, $filter) {
        $query = "SELECT id_film, titre, date_sortie, affiche, synopsis, id_real, vu, DATE_FORMAT(min_film, '%H:%i') AS heure FROM Film WHERE ";
        $params = [];

        if ($filter == 'before') {
            $query .= "date_sortie < :date ORDER BY date_sortie;";
            $params = [":date" => $date];
        } elseif ($filter == 'after') {
            $query .= "date_sortie > :date ORDER BY date_sortie;";
            $params = [":date" => $date];
        } elseif ($filter == 'exact') {
            $query .= "date_sortie = :date ORDER BY date_sortie;";
            $params = [":date" => $date];
        }

        return $this->exec($query, $params);
    }


    public function listeVu(){
        $query = "SELECT `id_film`, `titre`, `date_sortie`, `affiche`, `synopsis`, `id_real`, `vu`, DATE_FORMAT(`min_film`, '%H:%i') AS `min_film` FROM `film` WHERE vu = 1";
        return $this->exec($query);
    }


}
