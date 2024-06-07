<?php

use moovie\moovieAdmin\FilmDB;
use moovie\moovieAdmin\RealisateurDB;

require_once "../../config.php" ;
session_start() ;  
require_once $GLOBALS['PHP_DIR'] ."class/Autoloader.php";

Autoloader::register();

$real = new RealisateurDB();
$realisateur = $real->getRealisateurById($_GET['id']);

$realFil = new FilmDB();
$realFilm = $realFil->getFilmsByDirector($_GET['id']);


?>
<div class="modal-header">
    <h5 class="modal-title"><?= htmlspecialchars($realisateur->nom ?? '') ?></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body" style="background-color: black;">
    <div class="row">
        <div class="col-md-12">
            <img src="<?php echo $GLOBALS['IMG']; ?><?= htmlspecialchars($realisateur->photo ?? '') ?>" alt="<?= htmlspecialchars($realisateur->nom ?? '') ?>" class="img-fluid rounded">
        </div>
    </div>
    <div class="row">
        <h4 style="color: white; margin-left: 20px;">Films réalisés par <?= htmlspecialchars($realisateur->nom ?? '') ?>:</h4>
        <?php if (!empty($realFilm)): ?>
            <?php foreach ($realFilm as $filmReal): ?>
                <div class="col-md-6">
                    <ul>
                        <li>
                            <a href="details.php?id=<?= htmlspecialchars($filmReal->id_film ?? '') ?>">
                                <img src="<?php echo $GLOBALS['IMG']; ?><?= htmlspecialchars($filmReal->affiche ?? '') ?>" alt="<?= htmlspecialchars($filmReal->titre ?? '') ?>" class="img-fluid rounded">
                                <span style="color:red"><?= htmlspecialchars($filmReal->titre ?? '') ?></span>
                            </a>
                        </li>
                    </ul>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="color: white; margin-left: 20px;">Aucun film trouvé pour ce réalisateur.</p>
        <?php endif; ?>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="background-color: red;">Fermer</button>
</div>
