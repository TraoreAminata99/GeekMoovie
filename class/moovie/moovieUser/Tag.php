<?php
namespace moovie\moovieUser;

class Tag{
    public $nom;

    public function __construct($nom)
    {
        $this->nom = $nom;
    }

    public function getHTML()
    {
        return "<span class='tag'>{$this->nom}</span>";
    }
}
?>