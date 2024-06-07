<?php

use moovie\moovieUser\Template;

require_once "../../config.php" ;
session_start() ;  
require_once $GLOBALS['PHP_DIR'] ."class/Autoloader.php";


Autoloader::register();


?>
<!-- Démarre le buffering -->
<?php ob_start() ?>
 
	<!-- head -->
	<section class="section section--head section--head-fixed">
		<div class="container">
			<div class="row">
				<div class="col-12 col-xl-6">
					<h1 class="section__title section__title--head">GeekMoovie – Meilleur endroit pour les films</h1>
				</div>
			</div>
		</div>
	</section>
	<!-- end head -->

	<!-- about -->
	<section class="section section--pb0">
		<div class="container">
			<div class="row">
				<!-- section text -->
				<div class="col-12">
					<p class="section__text section__text--small">GeekMoovie se distingue comme le refuge ultime pour tous les cinéphiles et amateurs de films. Doté d'une vaste bibliothèque de films couvrant tous les genres et époques, GeekMoovie offre une expérience de visionnage inégalée. Que vous soyez fan de classiques intemporels, de blockbusters récents ou de films d'auteur indépendants, GeekMoovie dispose d'une collection soigneusement sélectionnée pour satisfaire tous les goûts.</p>

					<p class="section__text section__text--small">Chaque film est accompagné de critiques détaillées, de notes des utilisateurs et de recommandations personnalisées, facilitant ainsi la découverte de nouveaux joyaux cinématographiques. De plus, la plateforme est intuitive et facile à naviguer, garantissant une expérience utilisateur fluide et agréable.</p>
				</div>
				<!-- end section text -->
			</div>

			<div class="row row--grid">
				<div class="col-12 col-lg-4">
					<div class="step">
						<span class="step__number">01</span>
						<h3 class="step__title">Technologie de pointe</h3>
						<p class="step__text">GeekMoovie utilise les dernières innovations en matière de projection et de sonorisation. Chaque film est présenté avec une qualité d'image exceptionnelle et un son immersif.</p>
					</div>
				</div>
				
				<div class="col-12 col-lg-4">
					<div class="step">
						<span class="step__number">02</span>
						<h3 class="step__title">Films diversifiée</h3>
						<p class="step__text">GeekMoovie propose une programmation variée qui inclut les derniers blockbusters, des films d'auteur, des classiques du cinéma, ainsi que des productions.</p>
					</div>
				</div>

				<div class="col-12 col-lg-4">
					<div class="step">
						<span class="step__number">03</span>
						<h3 class="step__title">Ambiance conviviale</h3>
						<p class="step__text">Au-delà des projections, GeekMoovie offre une atmosphère unique et immersive. La décoration intérieure est inspirée des grands classiques du cinéma, avec des affiches.</p>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end about -->

	<!-- Récupère le contenu du buffer (et le vide) -->
<?php $content=ob_get_clean() ?>
<!-- Utilisation du contenu bufferisé -->
<?php Template::render($content) ?>