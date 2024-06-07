<?php

use moovie\moovieAdmin\FilmDB;
use moovie\moovieAdmin\Template;

require_once "../../config.php";
session_start();
require_once $GLOBALS['PHP_DIR'] . "class/Autoloader.php";

Autoloader::register();

$logged = isset($_SESSION['user']);

$filmDB = new FilmDB();
$films = $filmDB->getAllFilms();


ob_start();


// Supprimer le film si une requête de suppression est envoyée
if ($logged && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];
    $filmDB->deleteFilm($id);
    header('Location: film.php');
    exit();
}

if(isset($_GET)){
    if(!empty($_GET['search'])){
        $films = $filmDB->rechercher($_GET['search']);
        //var_dump($films);
        //$_SESSION['listeFilms'] = $listeFilms;
    }
}



if ($logged) { ?>
    <!-- main content -->
    <main class="main">
        <div class="container-fluid">
            <div class="row">
                <!-- main title -->
                <div class="col-12">
                    <div class="main__title">
                        <h2>Liste des films</h2>
                        <span class="main__title-stat">Total : <?php echo count($films); ?></span>

                        <form action="film.php"  method="GET" style="margin-left: 20px;">
                            <input class="header__form-input" type="text" name="search" placeholder="je recherche...">
                            <!-- <button class="header__form-btn" type="submit">
                                <svg viewBox="0 0 24 24" >
                                    <path d="M21.71,20.29,18,16.61A9,9,0,1,0,16.61,18l3.68,3.68a1,1,0,0,0,1.42,0A1,1,0,0,0,21.71,20.29ZM11,18a7,7,0,1,1,7-7A7,7,0,0,1,11,18Z"/>
                                </svg>
                            </button> -->
						</form>

                        <a href="addfilm.php" class="main__title-link">Ajout</a>
                    </div>
                </div>
                
				<!-- end main title -->
				<?php if(empty($films)) {
    				echo " <div style=color:red;text-align:center;>Aucun résultat trouvé pour votre recherche ... </div> ";
					}else{
						?>

				<!-- film -->
                <div class="col-12">
                    <div class="main__table-wrap">
                        <table class="main__table">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Titre</th>
                                    <th>Genre</th>
                                    <th>Durée</th>
                                    <th>Réalisateur</th>
                                    <th>Acteurs</th>
                                    <th>Date Sortie</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($films as $film): ?>
                                    <tr>
                                        <td>
                                            <div class="main__user">
                                                <div class="main__avatar">
                                                    <img src="<?php echo htmlspecialchars($film->affiche ?? 'null'); ?>" alt="">
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="main__table-text"><?php echo htmlspecialchars($film->titre ?? 'null'); ?></div>
                                        </td>
                                        <td>
                                            <div class="main__table-text"><?php echo htmlspecialchars($film->tags_noms ?? ''); ?></div>
                                        </td>
                                        <td>
                                            <div class="main__table-text"><?php echo htmlspecialchars($film->heure ?? 'null'); ?></div>
                                        </td>
                                        <td>
                                            <div class="main__table-text"><?php echo htmlspecialchars($film->realisateur_nom ?? 'null'); ?></div>
                                        </td>
                                        <td>
                                            <div class="main__table-text"><?php echo htmlspecialchars($film->acteurs_noms ?? 'null'); ?></div>
                                        </td>
                                        <td>
                                            <div class="main__table-text"><?php echo htmlspecialchars($film->annee ?? 'null'); ?></div>
                                        </td>
                                        <td>
                                            <div class="main__table-btns">
                                                <a href="editfilm.php?id=<?php echo htmlspecialchars($film->id_film ?? 'null'); ?>" class="main__table-btn main__table-btn--edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                        <path d="M22,7.24a1,1,0,0,0-.29-.71L17.47,2.29A1,1,0,0,0,16.76,2a1,1,0,0,0-.71.29L13.22,5.12h0L2.29,16.05a1,1,0,0,0-.29.71V21a1,1,0,0,0,1,1H7.24A1,1,0,0,0,8,21.71L18.87,10.78h0L21.71,8a1.19,1.19,0,0,0,.22-.33,1,1,0,0,0,0-.24.7.7,0,0,0,0-.14ZM6.83,20H4V17.17l9.93-9.93,2.83,2.83ZM18.17,8.66,15.34,5.83l1.42-1.41,2.82,2.82Z"/>
                                                    </svg>
                                                </a>
                                                <form method="POST" action="film.php" style="display:inline;">
                                                    <input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($film->id_film ?? 'null'); ?>">
                                                    <button type="submit" class="main__table-btn main__table-btn--delete">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                            <path d="M10,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,10,18ZM20,6H16V5a3,3,0,0,0-3-3H11A3,3,0,0,0,8,5V6H4A1,1,0,0,0,4,8H5V19a3,3,0,0,0,3,3h8a3,3,0,0,0,3-3V8h1a1,1,0,0,0,0-2ZM10,5a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1V6H10Zm7,14a1,1,0,0,1-1,1H8a1,1,0,0,1-1-1V8H17Zm-3-1a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,14,18Z"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- end film -->
                 
				<?php
			}
			?>
            </div>
        </div>
    </main>
    <!-- end main content -->
<?php } else {
    header("Location:".$GLOBALS['PAGESUser']."signin.php");
    exit();
}
?>
<!-- Récupère le contenu du buffer (et le vide) -->
<?php $content = ob_get_clean(); ?>
<!-- Utilisation du contenu bufferisé -->
<?php Template::render($content); ?>
