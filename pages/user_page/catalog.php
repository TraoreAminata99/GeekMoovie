<?php

use moovie\moovieAdmin\FilmDB;
use moovie\moovieAdmin\TagDB;
use moovie\moovieUser\Template;

require_once "../../config.php" ;
session_start() ;  
require_once $GLOBALS['PHP_DIR'] ."class/Autoloader.php";


Autoloader::register();

$tagDB = new TagDB();
$tags = $tagDB->getAllTag();	

$filmDB= new FilmDB();
$films=$filmDB->getAllFilms();



// Associez des images différentes à chaque tag
$tagImages = [
    'Romance' => 'category/1.jpg',
    'Action' => 'category/action.jpeg',
    'Manga' => 'category/dessin.png',
    'Comedie' => 'category/4.jpg',
];


ob_start() 

?>
 
	<!-- home -->

    <div id="myCarousel" class="carousel slide" data-ride="carousel">
		<div class="carousel-inner">
			<div class="item active">
			<img src="<?php echo $GLOBALS['IMG_DIR']; ?>home/film1.jpeg" alt="Slide 1">
			</div>
			
		</div>
	</div>

   <!-- end home -->

	<!-- head -->
	<section class="section section--head section--head-fixed">
		<div class="container">
			<div class="row">
				<div class="col-12 col-xl-6">
					<h1 class="section__title section__title--head">Catalogues</h1>
				</div>
			</div>
		</div>
	</section>
	<!-- end head -->

	<!-- categories -->
	<section class="section section--pb0">
		<div class="container">
			<div class="row row--grid">
				<?php foreach ($tags as $genre): ?>
					<div class="col-12 col-sm-6 col-lg-4 col-xl-3">
						<a href="genre.php?tag=<?php echo htmlspecialchars($genre->nom); ?>" class="category">
							<div class="category__cover">
								<?php 
									$image = isset($tagImages[$genre->nom]) ? $tagImages[$genre->nom] : 'default.jpg';
								?>
								<img src="<?php echo $GLOBALS['IMG_DIR'] . htmlspecialchars($image); ?>" alt="">
							</div>
							<h3 class="category__title"><?php echo htmlspecialchars($genre->nom ?? 'null'); ?></h3>
							<!-- <span class="category__value">322</span> -->
						</a>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<!-- endcategories -->

	<!-- popular -->
	<section class="section section--pb0">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<h2 class="section__title"><a href="genre.php">Les films populaires</a></h2>
				</div>
				<div class="col-12">
					<div class="section__carousel-wrap">
						<div class="section__carousel owl-carousel" id="popular">
							<?php for ($i = 0; $i < min(8, count($films)); $i++) : ?>
								<div class="card" style="background-color: transparent;">
									<a href="details.php?id=<?php echo htmlspecialchars($films[$i]->id_film); ?>" class="card__cover">
										<img src="<?php echo $GLOBALS['IMG']; ?><?php echo $films[$i]->affiche ; ?>" alt="">
										<svg width="22" height="22" viewBox="0 0 22 22" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M11 1C16.5228 1 21 5.47716 21 11C21 16.5228 16.5228 21 11 21C5.47716 21 1 16.5228 1 11C1 5.47716 5.47716 1 11 1Z" stroke-linecap="round" stroke-linejoin="round"/><path fill-rule="evenodd" clip-rule="evenodd" d="M14.0501 11.4669C13.3211 12.2529 11.3371 13.5829 10.3221 14.0099C10.1601 14.0779 9.74711 14.2219 9.65811 14.2239C9.46911 14.2299 9.28711 14.1239 9.19911 13.9539C9.16511 13.8879 9.06511 13.4569 9.03311 13.2649C8.93811 12.6809 8.88911 11.7739 8.89011 10.8619C8.88911 9.90489 8.94211 8.95489 9.04811 8.37689C9.07611 8.22089 9.15811 7.86189 9.18211 7.80389C9.22711 7.69589 9.30911 7.61089 9.40811 7.55789C9.48411 7.51689 9.57111 7.49489 9.65811 7.49789C9.74711 7.49989 10.1091 7.62689 10.2331 7.67589C11.2111 8.05589 13.2801 9.43389 14.0401 10.2439C14.1081 10.3169 14.2951 10.5129 14.3261 10.5529C14.3971 10.6429 14.4321 10.7519 14.4321 10.8619C14.4321 10.9639 14.4011 11.0679 14.3371 11.1549C14.3041 11.1999 14.1131 11.3999 14.0501 11.4669Z" stroke-linecap="round" stroke-linejoin="round"/></svg>
									</a>
									<span class="card__rating">
										<svg viewBox="0 0 24 24">
											<path d="M22,9.67A1,1,0,0,0,21.14,9l-5.69-.83L12.9,3a1,1,0,0,0-1.8,0L8.55,8.16,2.86,9a1,1,0,0,0-.81.68,1,1,0,0,0,.25,1l4.13,4-1,5.68A1,1,0,0,0,6.9,21.44L12,18.77l5.1,2.67a.93.93,0,0,0,.46.12,1,1,0,0,0,.59-.19,1,1,0,0,0,.4-1l-1-5.68,4.13-4A1,1,0,0,0,22,9.67Zm-6.15,4a1,1,0,0,0-.29.88l.72,4.2-3.76-2a1.06,1.06,0,0,0-.94,0l-3.76,2,.72-4.2a1,1,0,0,0-.29-.88l-3-3,4.21-.61a1,1,0,0,0,.76-.55L12,5.7l1.88,3.82a1,1,0,0,0,.76.55l4.21.61Z"/></svg>
										</span>
									<h3 class="card__title"><a href="details.php?id=<?php echo htmlspecialchars($films[$i]->id_film); ?>"><?php echo $films[$i]->titre; ?></a></h3>
									<ul class="card__list">
										<li><?php echo $films[$i]->realisateur_nom; ?></li>
										<li><?php echo $films[$i]->tags_noms; ?></li>
										<li><?php echo $films[$i]->annee; ?></li>
									</ul>
								</div>
							<?php endfor; ?> 
						</div>

						<button class="section__nav section__nav--cards section__nav--prev" data-nav="#popular" type="button"><svg width="17" height="15" viewBox="0 0 17 15" fill="none"><path d="M1.25 7.72559L16.25 7.72559" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M7.2998 1.70124L1.2498 7.72524L7.2998 13.7502" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
						<button class="section__nav section__nav--cards section__nav--next" data-nav="#popular" type="button"><svg width="17" height="15" viewBox="0 0 17 15" fill="none"><path d="M15.75 7.72559L0.75 7.72559" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M9.7002 1.70124L15.7502 7.72524L9.7002 13.7502" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end popular -->
	
<!-- Récupère le contenu du buffer (et le vide) -->
<?php $content=ob_get_clean() ?>
<!-- Utilisation du contenu bufferisé -->
<?php Template::render($content) ?>