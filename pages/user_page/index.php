<?php

use moovie\moovieAdmin\FilmDB;
use moovie\moovieAdmin\TagDB;
use moovie\moovieUser\Film;
use moovie\moovieUser\Template;

require_once "../../config.php";
session_start();
require_once $GLOBALS['PHP_DIR'] . "class/Autoloader.php";


Autoloader::register();

$filmDB = new FilmDB();
$films = $filmDB->getAllFilms();

$tagDB = new TagDB();
$tags = $tagDB->getAllTag();

$filmUser = new Film();
$filmRomance = $filmUser->getFilm_TagRomance();
$filmAction = $filmUser->getFilm_TagAction();
$filmManga = $filmUser->getFilm_TagManga();

$listeVu = $filmDB->listeVU();

ob_start();

?>

<!-- home -->
<div id="myCarousel" class="carousel slide" data-ride="carousel">
	<div class="carousel-inner">
		<div class="item active">
			<img src="<?php echo $GLOBALS['IMG_DIR']; ?>home/film.jpeg" alt="acceuil">
		</div>

	</div>
</div>

<!-- end home -->

<!-- Recommandation -->
<div class="home home--static">
	<div class="text" style="text-align: center; color: white; font-size: 30px;margin-top: -20px;">Recommandation</div>
	<br>
	<div class="home__carousel owl-carousel" id="geek-hero">
		<?php for ($i = 0; $i < min(7, count($films)); $i++) : ?>

			<div class="home__card">
				<a href="details.php?id=<?php echo htmlspecialchars($films[$i]->id_film); ?>">
					<img src="<?php echo $GLOBALS['IMG']; ?><?php echo $films[$i]->affiche; ?>" alt="">
				</a>
				<div>
					<h2>  <?php echo $films[$i]->titre; ?></h2>
					<ul>
						<li>
							<?php echo $films[$i]->vu ? 'Vu' : 'Non vu'; ?>
						</li>
						<li><?php echo $films[$i]->tags_noms; ?></li>
						<li><?php echo $films[$i]->heure; ?></li>
					</ul>
				</div>
				<button class="home__add <?php echo $films[$i]->vu ? 'home__add--seen' : ''; ?>" type="button" data-film-id="<?php echo htmlspecialchars($films[$i]->id_film); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M21 3L9 15l-5-5 1.41-1.42L9 12.17 19.59 2.58 21 3z"/>
                    </svg>
                </button>

			</form>
			</div>
		<?php endfor; ?>
	</div>

	<button class="home__nav home__nav--prev" data-nav="#geek-hero" type="button"></button>
	<button class="home__nav home__nav--next" data-nav="#geek-hero" type="button"></button>
</div>
<!-- end Recommandation -->


<!-- Famille Favorite -->
<section class="section section--head section--head-fixed">
	<a href="genre.php" class="voir"><b>Voir plus</b></a>
	<div class="container">
		<div class="row">
			<div class="col-12 col-xl-6">
				<h1 class="section__title section__title--head"><b>Famille </b> Moovie Favorites</h1>
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
						<?php for ($i = 0; $i < count($listeVu); $i++) : ?>
							<div class="interview">
								<a href="details.php?id=<?php echo htmlspecialchars($listeVu[$i]->id_film); ?>" class="interview__cover">
									<img src="<?php echo $GLOBALS['IMG']; ?><?= $listeVu[$i]->affiche; ?>" alt="">
									<span>
										<svg width="22" height="22" viewBox="0 0 22 22" fill="none">
											<path fill-rule="evenodd" clip-rule="evenodd" d="M11 1C16.5228 1 21 5.47716 21 11C21 16.5228 16.5228 21 11 21C5.47716 21 1 16.5228 1 11C1 5.47716 5.47716 1 11 1Z" stroke-linecap="round" stroke-linejoin="round" />
											<path fill-rule="evenodd" clip-rule="evenodd" d="M14.0501 11.4669C13.3211 12.2529 11.3371 13.5829 10.3221 14.0099C10.1601 14.0779 9.74711 14.2219 9.65811 14.2239C9.46911 14.2299 9.28711 14.1239 9.19911 13.9539C9.16511 13.8879 9.06511 13.4569 9.03311 13.2649C8.93811 12.6809 8.88911 11.7739 8.89011 10.8619C8.88911 9.90489 8.94211 8.95489 9.04811 8.37689C9.07611 8.22089 9.15811 7.86189 9.18211 7.80389C9.22711 7.69589 9.30911 7.61089 9.40811 7.55789C9.48411 7.51689 9.57111 7.49489 9.65811 7.49789C9.74711 7.49989 10.1091 7.62689 10.2331 7.67589C11.2111 8.05589 13.2801 9.43389 14.0401 10.2439C14.1081 10.3169 14.2951 10.5129 14.3261 10.5529C14.3971 10.6429 14.4321 10.7519 14.4321 10.8619C14.4321 10.9639 14.4011 11.0679 14.3371 11.1549C14.3041 11.1999 14.1131 11.3999 14.0501 11.4669Z" stroke-linecap="round" stroke-linejoin="round" />
										</svg>
										<?= $listeVu[$i]->min_film ?>
									</span>
								</a>
								<h4 class="interview__title">
									<a href="details.php?id=<?php echo htmlspecialchars($listeVu[$i]->id_film); ?>"><?= $listeVu[$i]->titre ?></a>
								</h4>
							</div>
						<?php endfor ?>
					</div>

					<!-- <button class="section__nav section__nav--interview section__nav--prev" data-nav="#geek" type="button"><svg width="17" height="15" viewBox="0 0 17 15" fill="none"><path d="M1.25 7.72559L16.25 7.72559" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M7.2998 1.70124L1.2498 7.72524L7.2998 13.7502" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
						<button class="section__nav section__nav--interview section__nav--next" data-nav="#geek" type="button"><svg width="17" height="15" viewBox="0 0 17 15" fill="none"><path d="M15.75 7.72559L0.75 7.72559" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M9.7002 1.70124L15.7502 7.72524L9.7002 13.7502" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></button> -->
				</div>
			</div>
		</div>
	</div>
</section>
<!-- end Famille Favorite -->

<!-- Romance -->
<section class="section section--head section--head-fixed" style="margin-top: -60px;">
	<a href="genre.php?tag=romance" class="voir"><b>Voir plus</b></a>
	<div class="container">
		<div class="row">
			<div class="col-12 col-xl-6">
				<h1 class="section__title section__title--head"><b>Romance </b>Moovie</h1>
			</div>
		</div>
	</div>

</section>
<section class="section" style="margin-top: -80px;">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="section__carousel-wrap">
					<div class="section__interview owl-carousel" id="geek">
						<?php for ($i = 0; $i < min(7, count($filmRomance)); $i++) : ?>
							<div class="interview">
								<a href="details.php?id=<?php echo htmlspecialchars($filmRomance[$i]->id_film); ?>" class="interview__cover">
									<img src="<?php echo $GLOBALS['IMG']; ?><?php echo $filmRomance[$i]->affiche; ?>" alt="">
									<span>
										<svg width="22" height="22" viewBox="0 0 22 22" fill="none">
											<path fill-rule="evenodd" clip-rule="evenodd" d="M11 1C16.5228 1 21 5.47716 21 11C21 16.5228 16.5228 21 11 21C5.47716 21 1 16.5228 1 11C1 5.47716 5.47716 1 11 1Z" stroke-linecap="round" stroke-linejoin="round" />
											<path fill-rule="evenodd" clip-rule="evenodd" d="M14.0501 11.4669C13.3211 12.2529 11.3371 13.5829 10.3221 14.0099C10.1601 14.0779 9.74711 14.2219 9.65811 14.2239C9.46911 14.2299 9.28711 14.1239 9.19911 13.9539C9.16511 13.8879 9.06511 13.4569 9.03311 13.2649C8.93811 12.6809 8.88911 11.7739 8.89011 10.8619C8.88911 9.90489 8.94211 8.95489 9.04811 8.37689C9.07611 8.22089 9.15811 7.86189 9.18211 7.80389C9.22711 7.69589 9.30911 7.61089 9.40811 7.55789C9.48411 7.51689 9.57111 7.49489 9.65811 7.49789C9.74711 7.49989 10.1091 7.62689 10.2331 7.67589C11.2111 8.05589 13.2801 9.43389 14.0401 10.2439C14.1081 10.3169 14.2951 10.5129 14.3261 10.5529C14.3971 10.6429 14.4321 10.7519 14.4321 10.8619C14.4321 10.9639 14.4011 11.0679 14.3371 11.1549C14.3041 11.1999 14.1131 11.3999 14.0501 11.4669Z" stroke-linecap="round" stroke-linejoin="round" />
										</svg>
										<?php echo $filmRomance[$i]->min_film; ?>
									</span>
								</a>
								<h4 class="interview__title">
									<a href="details.php?id=<?php echo htmlspecialchars($filmRomance[$i]->id_film); ?>"><?php echo $filmRomance[$i]->titre; ?></a>
								</h4>
							</div>
						<?php endfor; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- end Romance -->

<!-- Action -->
<section class="section section--head section--head-fixed" style="margin-top: -60px;">
	<a href="genre.php?tag=action" class="voir"><b>Voir plus</b></a>
	<div class="container">
		<div class="row">
			<div class="col-12 col-xl-6">
				<h1 class="section__title section__title--head"><b>Action </b>Moovie</h1>
			</div>
		</div>
	</div>
</section>
<section class="section" style="margin-top: -80px;">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="section__carousel-wrap">
					<div class="section__interview owl-carousel" id="geek">
						<?php for ($i = 0; $i < min(7, count($filmAction)); $i++) : ?>
							<div class="interview">
								<a href="details.php?id=<?php echo htmlspecialchars($filmAction[$i]->id_film); ?>" class="interview__cover">
									<img src="<?php echo $GLOBALS['IMG']; ?><?php echo $filmAction[$i]->affiche; ?>" alt="">
									<span>
										<svg width="22" height="22" viewBox="0 0 22 22" fill="none">
											<path fill-rule="evenodd" clip-rule="evenodd" d="M11 1C16.5228 1 21 5.47716 21 11C21 16.5228 16.5228 21 11 21C5.47716 21 1 16.5228 1 11C1 5.47716 5.47716 1 11 1Z" stroke-linecap="round" stroke-linejoin="round" />
											<path fill-rule="evenodd" clip-rule="evenodd" d="M14.0501 11.4669C13.3211 12.2529 11.3371 13.5829 10.3221 14.0099C10.1601 14.0779 9.74711 14.2219 9.65811 14.2239C9.46911 14.2299 9.28711 14.1239 9.19911 13.9539C9.16511 13.8879 9.06511 13.4569 9.03311 13.2649C8.93811 12.6809 8.88911 11.7739 8.89011 10.8619C8.88911 9.90489 8.94211 8.95489 9.04811 8.37689C9.07611 8.22089 9.15811 7.86189 9.18211 7.80389C9.22711 7.69589 9.30911 7.61089 9.40811 7.55789C9.48411 7.51689 9.57111 7.49489 9.65811 7.49789C9.74711 7.49989 10.1091 7.62689 10.2331 7.67589C11.2111 8.05589 13.2801 9.43389 14.0401 10.2439C14.1081 10.3169 14.2951 10.5129 14.3261 10.5529C14.3971 10.6429 14.4321 10.7519 14.4321 10.8619C14.4321 10.9639 14.4011 11.0679 14.3371 11.1549C14.3041 11.1999 14.1131 11.3999 14.0501 11.4669Z" stroke-linecap="round" stroke-linejoin="round" />
										</svg>
										<?php echo $filmAction[$i]->min_film; ?>
									</span>
								</a>
								<h4 class="interview__title">
									<a href="details.php?id=<?php echo htmlspecialchars($filmAction[$i]->id_film); ?>"><?php echo $filmAction[$i]->titre; ?></a>
								</h4>
							</div>
						<?php endfor; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- end Action -->

<!-- Manga -->
<section class="section section--head section--head-fixed" style="margin-top: -60px;">
	<a href="genre.php?tag=action" class="voir"><b>Voir plus</b></a>
	<div class="container">
		<div class="row">
			<div class="col-12 col-xl-6">
				<h1 class="section__title section__title--head"><b>Manga </b>Moovie</h1>
			</div>


		</div>
	</div>
</section>
<section class="section" style="margin-top: -80px;">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="section__carousel-wrap">
					<div class="section__interview owl-carousel" id="geek">
						<?php for ($i = 0; $i < min(7, count($filmManga)); $i++) : ?>
							<div class="interview">
								<a href="details.php?id=<?php echo htmlspecialchars($filmManga[$i]->id_film); ?>" class="interview__cover">
									<img src="<?php echo $GLOBALS['IMG']; ?><?php echo $filmManga[$i]->affiche; ?>" alt="">
									<span>
										<svg width="22" height="22" viewBox="0 0 22 22" fill="none">
											<path fill-rule="evenodd" clip-rule="evenodd" d="M11 1C16.5228 1 21 5.47716 21 11C21 16.5228 16.5228 21 11 21C5.47716 21 1 16.5228 1 11C1 5.47716 5.47716 1 11 1Z" stroke-linecap="round" stroke-linejoin="round" />
											<path fill-rule="evenodd" clip-rule="evenodd" d="M14.0501 11.4669C13.3211 12.2529 11.3371 13.5829 10.3221 14.0099C10.1601 14.0779 9.74711 14.2219 9.65811 14.2239C9.46911 14.2299 9.28711 14.1239 9.19911 13.9539C9.16511 13.8879 9.06511 13.4569 9.03311 13.2649C8.93811 12.6809 8.88911 11.7739 8.89011 10.8619C8.88911 9.90489 8.94211 8.95489 9.04811 8.37689C9.07611 8.22089 9.15811 7.86189 9.18211 7.80389C9.22711 7.69589 9.30911 7.61089 9.40811 7.55789C9.48411 7.51689 9.57111 7.49489 9.65811 7.49789C9.74711 7.49989 10.1091 7.62689 10.2331 7.67589C11.2111 8.05589 13.2801 9.43389 14.0401 10.2439C14.1081 10.3169 14.2951 10.5129 14.3261 10.5529C14.3971 10.6429 14.4321 10.7519 14.4321 10.8619C14.4321 10.9639 14.4011 11.0679 14.3371 11.1549C14.3041 11.1999 14.1131 11.3999 14.0501 11.4669Z" stroke-linecap="round" stroke-linejoin="round" />
										</svg>
										<?php echo $filmManga[$i]->min_film; ?>
									</span>
								</a>
								<h4 class="interview__title">
									<a href="details.php?id=<?php echo htmlspecialchars($filmManga[$i]->id_film); ?>"><?php echo $filmManga[$i]->titre; ?></a>
								</h4>
							</div>
						<?php endfor; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- end Manga -->

<script>
	document.addEventListener('DOMContentLoaded', function () {
		document.querySelectorAll('.home__add').forEach(button => {
			button.addEventListener('click', function () {
				const filmId = this.getAttribute('data-film-id');

				fetch('update_vu.php', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json'
					},
					body: JSON.stringify({ id_film: filmId })
				})
				.then(response => response.json())
				.then(data => {
					if (data.success) {
						this.classList.add('home__add--seen');
					} else {
						alert('Erreur lors de la mise à jour.');
					}
				})
				.catch(error => console.error('Erreur:', error));
			});
		});
	});
</script>


<!-- Récupère le contenu du buffer (et le vide) -->
<?php $content = ob_get_clean() ?>
<!-- Utilisation du contenu bufferisé -->
<?php Template::render($content) ?>