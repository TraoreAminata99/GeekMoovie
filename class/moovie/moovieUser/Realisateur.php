<?php
namespace moovie\moovieUser;

class Realisateur
{
    public $nom;
    public $photo;

    public function __construct($nom, $photo)
    {
        $this->nom = $nom;
        $this->photo = $photo;
    }

    public function getHTML()
    {
        return "
            <div class='realisateur'>
                <h3>{$this->nom}</h3>
                <img src='{$this->photo}' alt='{$this->nom}'>
            </div>
        ";
    }
}

?>