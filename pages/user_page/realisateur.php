<?php

use moovie\moovieAdmin\RealisateurDB;
use moovie\moovieUser\Template;

require_once "../../config.php" ;
session_start() ;  
require_once $GLOBALS['PHP_DIR'] ."class/Autoloader.php";


Autoloader::register();

$real = new RealisateurDB();

$realisateur = $real->getAllRealisateur();

?>
<!-- Démarre le buffering -->
<?php ob_start() ?>

<!-- Famille Favorite -->
<section class="section section--head section--head-fixed">
	<div class="container">
		<div class="row">
			<div class="col-12 col-xl-6">
				<h1 class="section__title section__title--head"><b>Nos realisateurs</b></h1>
			</div>
		</div>
	</div>
</section>

<section class="section" style="margin-top: -90px;">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="section__carousel-wrap">
					<div class="section__interview owl-carousel" id="geek">
						<?php for ($i = 0; $i < count($realisateur); $i++) : ?>
							<div class="interview">
								<a href="voirRealisateur.php?id=<?php echo htmlspecialchars($realisateur[$i]->id_real ?? ''); ?>" class="interview__cover">
									<img src="<?php echo $GLOBALS['IMG']; ?><?= $realisateur[$i]->photo; ?>" alt="">
									<span>
                                        <svg viewBox="0 0 24 24">
                                            <path d="M12.3,12.22A4.92,4.92,0,0,0,14,8.5a5,5,0,0,0-10,0,4.92,4.92,0,0,0,1.7,3.72A8,8,0,0,0,1,19.5a1,1,0,0,0,2,0,6,6,0,0,1,12,0,1,1,0,0,0,2,0A8,8,0,0,0,12.3,12.22ZM9,11.5a3,3,0,1,1,3-3A3,3,0,0,1,9,11.5Zm9.74.32A5,5,0,0,0,15,3.5a1,1,0,0,0,0,2,3,3,0,0,1,3,3,3,3,0,0,1-1.5,2.59,1,1,0,0,0-.5.84,1,1,0,0,0,.45.86l.39.26.13.07a7,7,0,0,1,4,6.38,1,1,0,0,0,2,0A9,9,0,0,0,18.74,11.82Z"/>
                                        </svg>
										<?= $realisateur[$i]->nom ?>
									</span>
								</a>
								<h4 class="interview__title">
									<a href="voirRealisateur.php?id=<?php echo htmlspecialchars($realisateur[$i]->id_act ?? ''); ?>"></a>
								</h4>
							</div>
						<?php endfor ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- end Famille Favorite -->


<!-- Structure de la modal -->
<div class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" >
        <div class="modal-content">
            
        </div>
    </div>
</div>



<!-- Inclure jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Votre script JavaScript -->
<script>
    $(document).ready(function() {
        // Détection du clic sur le lien de modification
        $('.interview__cover').click(function(e) {
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