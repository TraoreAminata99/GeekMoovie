<?php
namespace moovie\moovieUser;

use pdo_wrapper\PdoWrapper;

class Film extends PdoWrapper
{

    public function __construct()
    {
        parent::__construct(
            $GLOBALS['db_name'],
            $GLOBALS['db_host'],
            $GLOBALS['db_port'],
            $GLOBALS['db_user'],
            $GLOBALS['db_pwd']);
    }

    // public function getHTML()
    // {
    //     return "
    //         <div class='film'>
    //             <h2>{$this->titre}</h2>
    //             <img src='{$this->affiche}' alt='Affiche de {$this->titre}'>
    //             <p>Date de sortie: {$this->date_sortie}</p>
    //             <p>Synopsis: {$this->synopsis}</p>
    //             <p>Réalisateur ID: {$this->id_realisateur}</p>
    //             <p>Durée: {$this->min_film} minutes</p>
    //         </div>
    //     ";
    // }

    public function getFilm_TagRomance(){
        $query = "SELECT Film.id_film, Film.titre,  DATE_FORMAT(`min_film`, '%H:%i') AS `min_film`, Film.affiche
            FROM Film
            JOIN Film_Tag ON Film.id_film = Film_Tag.id_film
            JOIN Tag ON Film_Tag.id_tag = Tag.id_tag
            WHERE Tag.nom = 'Romance'
            ORDER BY RAND()
            LIMIT 5";
         return parent::exec($query, null);
    }

    public function getFilm_TagAction(){
        $query = "SELECT Film.id_film, Film.titre, DATE_FORMAT(`min_film`, '%H:%i') AS `min_film`, Film.affiche
        FROM Film
        JOIN Film_Tag ON Film.id_film = Film_Tag.id_film
        JOIN Tag ON Film_Tag.id_tag = Tag.id_tag
        WHERE Tag.nom = 'Action'
        ORDER BY RAND()
        LIMIT 5;";
         return parent::exec($query, null);
    }

    public function getFilm_TagManga(){
        $query = "SELECT Film.id_film, Film.titre,  DATE_FORMAT(`min_film`, '%H:%i') AS `min_film`, Film.affiche
        FROM Film
        JOIN Film_Tag ON Film.id_film = Film_Tag.id_film
        JOIN Tag ON Film_Tag.id_tag = Tag.id_tag
        WHERE Tag.nom = 'Manga'
        ORDER BY RAND()
        LIMIT 5;";
         return parent::exec($query, null);
    }


}

?>