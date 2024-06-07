<?php

use moovie\moovieAdmin\ActeurDB;
use moovie\moovieAdmin\FilmDB;
use moovie\moovieAdmin\RealisateurDB;
use moovie\moovieAdmin\TagDB;
use moovie\moovieAdmin\Template;
use moovie\moovieUser\Login;

require_once "../../config.php" ;
session_start() ;  
require_once $GLOBALS['PHP_DIR'] ."class/Autoloader.php";


Autoloader::register();


$logged = isset($_SESSION['user']) ;

 ob_start();
 $filmDB = new FilmDB();
 $films = $filmDB->getAllFilms();

 $tagDB = new TagDB();
 $tag = $tagDB->getAllTag();


 $actDB = new ActeurDB();
 $tabAct = $actDB->getFilm_Acteur();
 $numberOfActor;
 if (is_array($tabAct))
	$numberOfActor = count($tabAct);
 else
	$numberOfActor = 0;
 //var_dump(($actDB->getActeurById($tabAct[0])));
 

$realDB = new RealisateurDB();
$real = $realDB->getFilm_Real();
//var_dump($real);

 if ($logged) { ?>
	<!-- main content -->
	<main class="main">
		<div class="container-fluid">
			<div class="row">
				<!-- main title -->
				<div class="col-12">
					<div class="main__title">
						<h2>Admin</h2>

						<a href="<?php echo $GLOBALS['PAGESUser']; ?>logout.php" class="main__title-link">Logout</a>
					</div>
				</div>
				<!-- end main title -->

				<!-- stats film -->
				<div class="col-12 col-sm-6 col-xl-3">
					<div class="stats">
						<span>Film enregistré</span>
						<p> <?php echo count($films); ?></p>
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21,2h-1.586L18,4.414,16.586,3H15.414L14,4.414,12.586,3H11.414L10,4.414,8.586,3H7.414L6,4.414,4.586,3H3c-0.553,0-1,0.447-1,1v16c0,0.553,0.447,1,1,1h18c0.553,0,1-0.447,1-1V3C22,2.447,21.553,2,21,2z M15.5,4.5L17,6h-1.5L14,4.5H15.5z M12.5,4.5L14,6h-1.5L11,4.5H12.5z M9.5,4.5L11,6H9.5L7.5,4.5H9.5z M6.5,4.5L8,6H6.5L4.5,4.5H6.5z M20,19H4v-8h16V19z M20,10H4V9h16V10z"/>
                        </svg>                  
					</div>
				</div>
				<!-- end stats film-->

				<!-- stats genre -->
				<div class="col-12 col-sm-6 col-xl-3">
					<div class="stats">
						<span>Tag enregistré</span>
						<p><?php echo count($tag); ?></p>
						<svg viewBox="0 0 24 24"><path d="M10,13H4a1,1,0,0,0-1,1v6a1,1,0,0,0,1,1h6a1,1,0,0,0,1-1V14A1,1,0,0,0,10,13ZM9,19H5V15H9ZM20,3H14a1,1,0,0,0-1,1v6a1,1,0,0,0,1,1h6a1,1,0,0,0,1-1V4A1,1,0,0,0,20,3ZM19,9H15V5h4Zm1,7H18V14a1,1,0,0,0-2,0v2H14a1,1,0,0,0,0,2h2v2a1,1,0,0,0,2,0V18h2a1,1,0,0,0,0-2ZM10,3H4A1,1,0,0,0,3,4v6a1,1,0,0,0,1,1h6a1,1,0,0,0,1-1V4A1,1,0,0,0,10,3ZM9,9H5V5H9Z"/></svg>
					</div>
				</div>
				<!-- end stats genre-->

				<!-- stats acteur-->
				<div class="col-12 col-sm-6 col-xl-3">
					<div class="stats">
						<span>Acteur enregistré</span>
						<p><?php echo $numberOfActor; ?></p>
                        <svg viewBox="0 0 24 24">
                            <path d="M12.3,12.22A4.92,4.92,0,0,0,14,8.5a5,5,0,0,0-10,0,4.92,4.92,0,0,0,1.7,3.72A8,8,0,0,0,1,19.5a1,1,0,0,0,2,0,6,6,0,0,1,12,0,1,1,0,0,0,2,0A8,8,0,0,0,12.3,12.22ZM9,11.5a3,3,0,1,1,3-3A3,3,0,0,1,9,11.5Zm9.74.32A5,5,0,0,0,15,3.5a1,1,0,0,0,0,2,3,3,0,0,1,3,3,3,3,0,0,1-1.5,2.59,1,1,0,0,0-.5.84,1,1,0,0,0,.45.86l.39.26.13.07a7,7,0,0,1,4,6.38,1,1,0,0,0,2,0A9,9,0,0,0,18.74,11.82Z"/>
                        </svg> 
					</div>
				</div>
				<!-- end stats acteur-->

				<!-- stats realisateur-->
				<div class="col-12 col-sm-6 col-xl-3">
					<div class="stats">
						<span>Realisateur enregistré</span>
						<p><?php echo count($real); ?></p>
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                            <path d="M21 3H7.2L6.27 1.2C6.08.8 5.64.5 5.17.5H3c-.55 0-1 .45-1 1s.45 1 1 1h1.17L6 5H3C2.45 5 2 5.45 2 6s.45 1 1 1h3.73L7.2 7.5H5.5l-1-1H3.7c-.44 0-.8.36-.8.8v2.4c0 .44.36.8.8.8h1.7l.95 3.17-4.25 4.25c-.29.29-.45.68-.45 1.09v1.25c0 .83.67 1.5 1.5 1.5h1.25c.41 0 .8-.16 1.09-.45l4.25-4.25L14.83 20h2.67c.44 0 .8-.36.8-.8V16.5h1.7c.44 0 .8-.36.8-.8v-2.4c0-.44-.36-.8-.8-.8H20l-1.5-5.5H21c.55 0 1-.45 1-1s-.45-1-1-1h-3.73L15 3.5h5.83C21.55 3.5 22 3.05 22 2.5s-.45-1-1-1h-5.83L15 3.5H9.83l1.3 2.5H17l1.5 5.5H3.83L2 6.5H1.17c-.44 0-.8-.36-.8-.8V3.7c0-.44.36-.8.8-.8H3.7L2 1.17C2.5 1.5 3 .5 3 .5h5.2l1.3 2.5H21c.55 0 1-.45 1-1s-.45-1-1-1zm0 0V20h-2v1h-1v-1H4v1H3v-1H1V3.5h.83L1 2.5h1.7c.44 0 .8.36.8.8v2.4c0 .44-.36.8-.8.8H1.17L2 6.5H3v2h2V6.5h14v2h2V3.5h.83L22 2.5h1v-1h1v1z"/>
                        </svg>   
					</div>
				</div>
				<!-- end stats realisateur-->

				<!-- dashbox film -->
				<div class="col-12 col-xl-6">
					<div class="dashbox">
						<div class="dashbox__title">
							<h3>
                                <svg viewBox="0 0 24 24">
                                    <path d="M12,6a1,1,0,0,0-1,1V17a1,1,0,0,0,2,0V7A1,1,0,0,0,12,6ZM7,12a1,1,0,0,0-1,1v4a1,1,0,0,0,2,0V13A1,1,0,0,0,7,12Zm10-2a1,1,0,0,0-1,1v6a1,1,0,0,0,2,0V11A1,1,0,0,0,17,10Zm2-8H5A3,3,0,0,0,2,5V19a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V5A3,3,0,0,0,19,2Zm1,17a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V5A1,1,0,0,1,5,4H19a1,1,0,0,1,1,1Z"/>
                                </svg> 
                                Film
                            </h3>

							<div class="dashbox__wrap">
								<a class="dashbox__more" href="film.php">Voir plus</a>
							</div>
						</div>

						<div class="dashbox__table-wrap dashbox__table-wrap--1">
							<table class="main__table main__table--dash">
								<thead>
									<tr>
										<th>ID</th>
										<th>NOM</th>
										<th>Genre</th>
										<th>REALISATEUR</th>
									</tr>
								</thead>
								<tbody>
									<?php for ($i = 0; $i < min(5, count($films)); $i++) : ?>
										<tr>
											<td>
												<div class="main__table-text"><?php echo $films[$i]->id_film; ?></div>
											</td>
											<td>
												<div class="main__table-text"><a href="index.php#"><?php echo $films[$i]->titre; ?></a></div>
											</td>
											<td>
												<div class="main__table-text"><?php echo $films[$i]->tags_noms; ?></div>
											</td>
											<td>
												<div class="main__table-text"><?php echo $films[$i]->realisateur_nom; ?></div>
											</td>
										</tr>
									<?php endfor; ?> 
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<!-- end dashbox film -->

				<!-- dashbox genre -->
				<div class="col-12 col-xl-6">
					<div class="dashbox">
						<div class="dashbox__title">
							<h3>
                                <svg viewBox="0 0 24 24">
                                    <path d="M10,13H3a1,1,0,0,0-1,1v7a1,1,0,0,0,1,1h7a1,1,0,0,0,1-1V14A1,1,0,0,0,10,13ZM9,20H4V15H9ZM21,2H14a1,1,0,0,0-1,1v7a1,1,0,0,0,1,1h7a1,1,0,0,0,1-1V3A1,1,0,0,0,21,2ZM20,9H15V4h5Zm1,4H14a1,1,0,0,0-1,1v7a1,1,0,0,0,1,1h7a1,1,0,0,0,1-1V14A1,1,0,0,0,21,13Zm-1,7H15V15h5ZM10,2H3A1,1,0,0,0,2,3v7a1,1,0,0,0,1,1h7a1,1,0,0,0,1-1V3A1,1,0,0,0,10,2ZM9,9H4V4H9Z"/>
                                </svg> 
                                Genre
                            </h3>

							<div class="dashbox__wrap">
								<a class="dashbox__more" href="genre.php">Voir plus</a>
							</div>
						</div>

						<div class="dashbox__table-wrap dashbox__table-wrap--2">
							<table class="main__table main__table--dash">
								<thead>
									<tr>
										<th>ID</th>
										<th>NOM</th>
									</tr>
								</thead>
								<tbody>
									<?php for ($i = 0; $i < min(5, count($tag)); $i++) : ?>
										<tr>
											<td>
												
												<div class="main__table-text"><?php echo $tag[$i]->id_tag; ?></div>
											</td>
											<td>
												<div class="main__table-text"><a href="index.php#"><?php echo $tag[$i]->nom; ?></a></div>
											</td>	
										</tr>
									<?php endfor; ?> 
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<!-- end dashbox genre -->

				<!-- dashbox acteur -->
				<div class="col-12 col-xl-6">
					<div class="dashbox">
						<div class="dashbox__title">
							<h3>
                                <svg viewBox="0 0 24 24">
                                    <path d="M12.3,12.22A4.92,4.92,0,0,0,14,8.5a5,5,0,0,0-10,0,4.92,4.92,0,0,0,1.7,3.72A8,8,0,0,0,1,19.5a1,1,0,0,0,2,0,6,6,0,0,1,12,0,1,1,0,0,0,2,0A8,8,0,0,0,12.3,12.22ZM9,11.5a3,3,0,1,1,3-3A3,3,0,0,1,9,11.5Zm9.74.32A5,5,0,0,0,15,3.5a1,1,0,0,0,0,2,3,3,0,0,1,3,3,3,3,0,0,1-1.5,2.59,1,1,0,0,0-.5.84,1,1,0,0,0,.45.86l.39.26.13.07a7,7,0,0,1,4,6.38,1,1,0,0,0,2,0A9,9,0,0,0,18.74,11.82Z"/>
                                </svg> 
                                Acteur
                            </h3>

							<div class="dashbox__wrap">
								<a class="dashbox__more" href="users.php">Voir plus</a>
							</div>
						</div>

						<div class="dashbox__table-wrap dashbox__table-wrap--3">
							<table class="main__table main__table--dash">
								<thead>
									<tr>
										<th>ID</th>
										<th>NOM</th>
										<th>FILM JOUER</th>
									</tr>
								</thead>
								<tbody>
									<?php for ($i = 0; $i < min(5,$numberOfActor); $i++) : ?>
										<tr>
											<td>
												<div class="main__table-text"><?php echo ($actDB->getActeurById(($tabAct[$i])))->id_act; ?></div>
											</td>
											<td>
												<div class="main__table-text"><a href="index.php#"><?php echo ($actDB->getActeurById(($tabAct[$i])))->nom; ?></a></div>
											</td>
											<td>
												<div class='main__table-text main__table-text--grey'>
													<?php 
														$afficheFilm = "";
														$films = ($filmDB->getFilmsByActeur($tabAct[$i]));
														for($j = 0; $j < min(5,count($films)) -1; $j++){
															$afficheFilm .=  $films[$j]->titre . ", ";
														}
														echo $afficheFilm . $films[count($films)-1]->titre;
													?>
												</div>
											</td>
											
										</tr>
									<?php endfor; ?> 
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<!-- end dashbox acteur-->

				<!-- dashbox Réalisateur-->
				<div class="col-12 col-xl-6">
					<div class="dashbox">
						<div class="dashbox__title">
							<h3>
                                <svg viewBox="0 0 24 24">
                                    <path d="M22,9.67A1,1,0,0,0,21.14,9l-5.69-.83L12.9,3a1,1,0,0,0-1.8,0L8.55,8.16,2.86,9a1,1,0,0,0-.81.68,1,1,0,0,0,.25,1l4.13,4-1,5.68A1,1,0,0,0,6.9,21.44L12,18.77l5.1,2.67a.93.93,0,0,0,.46.12,1,1,0,0,0,.59-.19,1,1,0,0,0,.4-1l-1-5.68,4.13-4A1,1,0,0,0,22,9.67Zm-6.15,4a1,1,0,0,0-.29.88l.72,4.2-3.76-2a1.06,1.06,0,0,0-.94,0l-3.76,2,.72-4.2a1,1,0,0,0-.29-.88l-3-3,4.21-.61a1,1,0,0,0,.76-.55L12,5.7l1.88,3.82a1,1,0,0,0,.76.55l4.21.61Z"/>
                                </svg>
                               Réalisateur
                            </h3>

							<div class="dashbox__wrap">
								<a class="dashbox__more" href="realisateur.php">Voir plus</a>
							</div>
						</div>

						<div class="dashbox__table-wrap dashbox__table-wrap--4">
							<table class="main__table main__table--dash">
								<thead>
									<tr>
										<th>ID</th>
										<th>NOM</th>
										<th>FILM REALISER</th>
									</tr>
								</thead>
								<tbody>
									<?php for ($i = 0; $i < min(5, count($real)); $i++) : ?>
										<tr>
											<td>
												<div class="main__table-text"><?php echo $real[$i] ; ?></div>
											</td>
											<td>
												<div class="main__table-text"><a href="index.php#"><?php echo ($realDB->getRealisateurById($real[$i]))->nom; ?></a></div>
											</td>
											<td>
												<div class="main__table-text">
													<?php
														$filmR = "";
														$i;
														$j;
														 for($i = 0; $i < count($real); $i++){
															$filmReal = $filmDB->getFilmsByDirector($real[$i]);
															for($j = 0; $j < count($filmReal)-1; $j++){
																echo $filmReal[$j]->titre . ", ";
																if($i == count($real)-1 and $j == count($filmReal)-2)
																	echo $filmReal[$j+1]->titre;
															}

														}
														
													?>
												</div>
											</td>
											
										</tr>
									<?php endfor; ?> 
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<!-- end dashbox -->
			</div>
		</div>
	</main>
	<!-- end main content -->
 <?php } else {
	header("Location: ".$GLOBALS['PAGESUser']. "signin.php");
	exit();
 }
 
 
 ?>
 


<!-- Récupère le contenu du buffer (et le vide) -->
<?php $content=ob_get_clean() ?>
<!-- Utilisation du contenu bufferisé -->
<?php Template::render($content) ?>