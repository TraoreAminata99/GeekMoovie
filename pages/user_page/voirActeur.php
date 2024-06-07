<?php

use moovie\moovieAdmin\ActeurDB;
use moovie\moovieAdmin\FilmDB;

require_once "../../config.php" ;
session_start() ;  
require_once $GLOBALS['PHP_DIR'] ."class/Autoloader.php";


Autoloader::register();

$act=new ActeurDB();
$acteur=$act->getActeurById($_GET['id']);

$actFil=new FilmDB();

$actFilm=$actFil->getFilmsByActeur($_GET['id']);


?>
<div class="modal-header" >
        <h5 class="modal-title"><?= htmlspecialchars($acteur->nom ?? '') ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
</div>
<div class="modal-body" style="background-color: black;">
    <div class="row">
        <div class="col-md-12">
            <img src="<?php echo $GLOBALS['IMG']; ?><?= htmlspecialchars($acteur->photo ?? '') ?>" alt="<?= htmlspecialchars($acteur->nom ?? '') ?>" class="img-fluid rounded">
        </div>
    </div>
    <div class="row">
        <h4 style="color: white; margin-left: 20px;">Films joué par <?= htmlspecialchars($acteur->nom ?? '') ?>:</h4>
    
        <?php foreach ($actFilm as $filmAct): ?>
            <div class="col-md-6">
            <ul>
                <li>
                    <a href="details.php?id=<?php echo htmlspecialchars($filmAct->id_film ?? '') ?>" >
                        <img src="<?php echo $GLOBALS['IMG']; ?><?php echo htmlspecialchars($filmAct->affiche ?? '') ?>" alt="<?php echo htmlspecialchars($filmAct->titre ?? '') ?>" class="img-fluid rounded">
                        <span style="color:red"><?php echo htmlspecialchars($filmAct->titre ?? '') ?></span>
                    </a>
                </li>
            </ul>
            </div>
        <?php endforeach; ?>
            
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="background-color: red;">Fermer</button>
</div>



