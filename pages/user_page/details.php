<?php

use moovie\moovieAdmin\ActeurDB;
use moovie\moovieAdmin\FilmDB;
use moovie\moovieUser\Template;

require_once "../../config.php" ;
session_start() ;  
require_once $GLOBALS['PHP_DIR'] ."class/Autoloader.php";


Autoloader::register();


$filmDB = new FilmDB();
$film = null;

if (isset($_GET['id'])) {
    $filmId = (int)$_GET['id'];
    $film = $filmDB->getFilmById($filmId);
}

if (!$film) {
    echo "Film not found.";
    exit();
}

//var_dump($film);

?>
 
<!-- head -->
<section class="section section--head section--head-fixed section--gradient section--details">
	<div class="container">
		<!-- article -->
		<div class="article">
			<div class="row">
				<div class="col-12 col-xl-12">
					<!-- article content -->
					<div class="article__content">
						<a href="catalog.php" class="article__category"><?php echo htmlspecialchars($film->tags_noms); ?></a>

						<span class="article__date">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
								<path d="M12,2A10,10,0,1,0,22,12,10.01114,10.01114,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8.00917,8.00917,0,0,1,12,20ZM14.09814,9.63379,13,10.26807V7a1,1,0,0,0-2,0v5a1.00025,1.00025,0,0,0,1.5.86621l2.59814-1.5a1.00016,1.00016,0,1,0-1-1.73242Z"/>
							</svg>
							<?php echo htmlspecialchars($film->heure); ?>
						</span>

						<h1><?php echo htmlspecialchars($film->titre); ?></h1>
						<img src="<?php echo $GLOBALS['IMG']; ?><?php echo htmlspecialchars($film->affiche); ?>" alt="filmDetail">
						<blockquote>
							<p><?php echo htmlspecialchars($film->synopsis);?></p>
						</blockquote>
						<ul>
                            <li>Réaliser par <b> <a class="real" href="voirRealisateur.php?id=<?php echo htmlspecialchars($film->id_real ?? ''); ?>"><?php echo htmlspecialchars($film->realisateur_nom); ?></a> </b></li>
                            <li>Acteurs : <a class="act" href="voirActeur.php?id=<?php echo htmlspecialchars($film->acteurs_id ?? ''); ?>"><?php echo htmlspecialchars($film->acteurs_noms); ?></a></li>
                            <li>Date de sortie: <?php echo htmlspecialchars($film->annee); ?></li>
                            <li>Tag : <?php echo htmlspecialchars($film->tags_noms); ?></li>
                            <li>Vu : <?php echo $film->vu ? 'Vu' : 'Non vu'; ?></li>
                        </ul>
					</div>
				</div>
			</div>
		</div>

		<?php 
			$logged = isset($_SESSION['user']);
			if ($logged) {?>
				<a href="<?php echo $GLOBALS['IMG']; ?>editfilm.php?id=<?php echo htmlspecialchars($film->id_film ?? 'null'); ?>" class="article__category modif">Modifier</a>
			<?php }else { ?>
				<div></div>
		    <?php }
		?>

		<!-- end article -->
	</div>
</section>

	<!-- Structure de la modal -->
		<div class="modal fade" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					
				</div>
			</div>
		</div>

<!-- end head -->

<!-- Inclure jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Détection du clic sur le lien de modification
        $('.real').click(function(e) {
            e.preventDefault(); // Empêche la redirection

            // Récupération de l'URL de la page de modification
            var url = $(this).attr('href');

            // Chargement du contenu de la page de modification dans la modal
            $.get(url, function(data) {
                // Ajout du contenu récupéré à la modal
                $('.modal-content').html(data);
                // Affichage de la modal
                $('.modal').modal('show');
            });
        });
    });
</script>



<!-- Votre script JavaScript -->
<script>
    $(document).ready(function() {
        // Détection du clic sur le lien de modification
        $('.act').click(function(e) {
            e.preventDefault(); // Empêche la redirection

            // Récupération de l'URL de la page de modification
            var url = $(this).attr('href');

            // Chargement du contenu de la page de modification dans la modal
            $.get(url, function(data) {
                // Ajout du contenu récupéré à la modal
                $('.modal-content').html(data);
                // Affichage de la modal
                $('.modal').modal('show');
            });
        });
    });
</script>


<script>
    $(document).ready(function() {
        // Détection du clic sur le lien de modification
        $('.act').click(function(e) {
            e.preventDefault(); // Empêche la redirection

            // Récupération de l'URL de la page de modification
            var url = $(this).attr('href');

            // Chargement du contenu de la page de modification dans la modal
            $.get(url, function(data) {
                // Ajout du contenu récupéré à la modal
                $('.modal-content').html(data);
                // Affichage de la modal
                $('.modal').modal('show');
            });
        });
    });
</script>



<!-- Récupère le contenu du buffer (et le vide) -->
<?php $content=ob_get_clean() ?>
<!-- Utilisation du contenu bufferisé -->
<?php Template::render($content) ?>