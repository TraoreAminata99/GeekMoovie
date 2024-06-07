<?php
namespace moovie\moovieUser;

use pdo_wrapper\PdoWrapper;

class Acteur extends PdoWrapper
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
//         <div class='acteur'>
//             <h3>{$this->nom}</h3>
//             <img src='{$this->photo}' alt='{$this->nom}'>
//         </div>
//         ";
// }

}
?>