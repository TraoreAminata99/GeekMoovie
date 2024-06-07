    <!-- header -->
	<?php
		$logged = isset($_SESSION['user']) ;
	?>

	<header class="header header--static">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="header__content">
						<button class="header__menu" type="button">
							<span></span>
							<span></span>
							<span></span>
						</button>

						<a href="index.php" class="header__logo">
                        <img src="<?php echo $GLOBALS['IMG_DIR']; ?>/logo.png" alt="GeekMoovieLogo">
						</a>

						<ul class="header__nav" >
							<li class="header__nav-item  ">
								<a class="header__nav-link active" href="index.php">Accueil </a>
							</li>
							
							<li class="header__nav-item">
								<a class="header__nav-link" href="catalog.php">Catalogue  </a>
							</li>
							
							<li class="header__nav-item">
								<a class="header__nav-link" href="acteur.php">Acteurs</a>
							</li>
							<li class="header__nav-item">
								<a class="header__nav-link" href="realisateur.php">Réalisateurs</a>
							</li>
						</ul>

						<div class="header__actions">
								<form action="search.php" class="header__form" method="GET">
									<input class="header__form-input" type="text" name="search" placeholder="je recherche...">
									<button class="header__form-btn" type="submit">
										<svg viewBox="0 0 24 24">
											<path d="M21.71,20.29,18,16.61A9,9,0,1,0,16.61,18l3.68,3.68a1,1,0,0,0,1.42,0A1,1,0,0,0,21.71,20.29ZM11,18a7,7,0,1,1,7-7A7,7,0,0,1,11,18Z"/>
										</svg>
									</button>
								</form>
						

							<!-- bouton search pour le format mobile -->
							<button class="header__search" type="button">
								<svg viewBox="0 0 24 24"><path d="M21.71,20.29,18,16.61A9,9,0,1,0,16.61,18l3.68,3.68a1,1,0,0,0,1.42,0A1,1,0,0,0,21.71,20.29ZM11,18a7,7,0,1,1,7-7A7,7,0,0,1,11,18Z"/></svg>
							</button>

							<?php if ($logged) {?>
								<a href="<?php echo $GLOBALS['IMG']; ?>index.php" class="header__user">
								<span>Admin</span>
								<svg viewBox="0 0 24 24"><path d="M20,12a1,1,0,0,0-1-1H11.41l2.3-2.29a1,1,0,1,0-1.42-1.42l-4,4a1,1,0,0,0-.21.33,1,1,0,0,0,0,.76,1,1,0,0,0,.21.33l4,4a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42L11.41,13H19A1,1,0,0,0,20,12ZM17,2H7A3,3,0,0,0,4,5V19a3,3,0,0,0,3,3H17a3,3,0,0,0,3-3V16a1,1,0,0,0-2,0v3a1,1,0,0,1-1,1H7a1,1,0,0,1-1-1V5A1,1,0,0,1,7,4H17a1,1,0,0,1,1,1V8a1,1,0,0,0,2,0V5A3,3,0,0,0,17,2Z"/></svg>
							    </a>
								<?php
								} else{
									?>
									<a href="signin.php" class="header__user">
									<span>Connexion</span>
									<svg viewBox="0 0 24 24"><path d="M20,12a1,1,0,0,0-1-1H11.41l2.3-2.29a1,1,0,1,0-1.42-1.42l-4,4a1,1,0,0,0-.21.33,1,1,0,0,0,0,.76,1,1,0,0,0,.21.33l4,4a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42L11.41,13H19A1,1,0,0,0,20,12ZM17,2H7A3,3,0,0,0,4,5V19a3,3,0,0,0,3,3H17a3,3,0,0,0,3-3V16a1,1,0,0,0-2,0v3a1,1,0,0,1-1,1H7a1,1,0,0,1-1-1V5A1,1,0,0,1,7,4H17a1,1,0,0,1,1,1V8a1,1,0,0,0,2,0V5A3,3,0,0,0,17,2Z"/></svg>
									</a>
								<?php } 
							?>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- end header -->