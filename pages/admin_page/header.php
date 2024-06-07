
	<!-- header -->
	<header class="header">
		<div class="header__content">
			<!-- header logo -->
			<a href="index.php" class="header__logo">
                  <img src="<?php echo $GLOBALS['IMG_DIR']; ?>/logo.png" alt="GeekMoovie">
			</a>
			<!-- end header logo -->

			<!-- header menu btn -->
			<button class="header__btn" type="button">
				<span></span>
				<span></span>
				<span></span>
			</button>
			<!-- end header menu btn -->
		</div>
	</header>
	<!-- end header -->

	<!-- sidebar -->
	<div class="sidebar">
		<!-- sidebar logo -->
		<a href="index.php" class="sidebar__logo">
           <img src="<?php echo $GLOBALS['IMG_DIR']; ?>/logo.png" alt="GeekMoovie">
		</a>
		<!-- end sidebar logo -->
		
		<!-- sidebar user -->
		<div class="sidebar__user">
			<div class="sidebar__user-img">
            <img src="<?php echo $GLOBALS['IMG_DIR']; ?>/user.svg" alt="admin-user">
			</div>

			<div class="sidebar__user-title">
				<span>Admin</span>
				<p>login</p>
			</div>
		</div>
		<!-- end sidebar user -->

		<!-- sidebar nav -->
		<ul class="sidebar__nav">
			<li class="sidebar__nav-item">
				<a href="index.php" class="sidebar__nav-link sidebar__nav-link--active">
                    <svg viewBox="0 0 24 24">
                        <path d="M20,8h0L14,2.74a3,3,0,0,0-4,0L4,8a3,3,0,0,0-1,2.26V19a3,3,0,0,0,3,3H18a3,3,0,0,0,3-3V10.25A3,3,0,0,0,20,8ZM14,20H10V15a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1Zm5-1a1,1,0,0,1-1,1H16V15a3,3,0,0,0-3-3H11a3,3,0,0,0-3,3v5H6a1,1,0,0,1-1-1V10.25a1,1,0,0,1,.34-.75l6-5.25a1,1,0,0,1,1.32,0l6,5.25a1,1,0,0,1,.34.75Z"/>
                    </svg> 
                    <span>Tableau de bord</span>
                </a>
			</li>

            <li class="sidebar__nav-item">
				<a href="film.php" class="sidebar__nav-link">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21,2h-1.586L18,4.414,16.586,3H15.414L14,4.414,12.586,3H11.414L10,4.414,8.586,3H7.414L6,4.414,4.586,3H3c-0.553,0-1,0.447-1,1v16c0,0.553,0.447,1,1,1h18c0.553,0,1-0.447,1-1V3C22,2.447,21.553,2,21,2z M15.5,4.5L17,6h-1.5L14,4.5H15.5z M12.5,4.5L14,6h-1.5L11,4.5H12.5z M9.5,4.5L11,6H9.5L7.5,4.5H9.5z M6.5,4.5L8,6H6.5L4.5,4.5H6.5z M20,19H4v-8h16V19z M20,10H4V9h16V10z"/>
                    </svg>
                    
                    <span>Films</span>
                </a>
			</li>
			<li class="sidebar__nav-item">
				<a href="genre.php" class="sidebar__nav-link">
                    <svg viewBox="0 0 24 24">
                        <path d="M10,13H3a1,1,0,0,0-1,1v7a1,1,0,0,0,1,1h7a1,1,0,0,0,1-1V14A1,1,0,0,0,10,13ZM9,20H4V15H9ZM21,2H14a1,1,0,0,0-1,1v7a1,1,0,0,0,1,1h7a1,1,0,0,0,1-1V3A1,1,0,0,0,21,2ZM20,9H15V4h5Zm1,4H14a1,1,0,0,0-1,1v7a1,1,0,0,0,1,1h7a1,1,0,0,0,1-1V14A1,1,0,0,0,21,13Zm-1,7H15V15h5ZM10,2H3A1,1,0,0,0,2,3v7a1,1,0,0,0,1,1h7a1,1,0,0,0,1-1V3A1,1,0,0,0,10,2ZM9,9H4V4H9Z"/>
                    </svg> 
                    <span>Tags</span>
                </a>
			</li>

            <li class="sidebar__nav-item">
				<a href="acteur.php" class="sidebar__nav-link">
                    <svg viewBox="0 0 24 24">
                        <path d="M12.3,12.22A4.92,4.92,0,0,0,14,8.5a5,5,0,0,0-10,0,4.92,4.92,0,0,0,1.7,3.72A8,8,0,0,0,1,19.5a1,1,0,0,0,2,0,6,6,0,0,1,12,0,1,1,0,0,0,2,0A8,8,0,0,0,12.3,12.22ZM9,11.5a3,3,0,1,1,3-3A3,3,0,0,1,9,11.5Zm9.74.32A5,5,0,0,0,15,3.5a1,1,0,0,0,0,2,3,3,0,0,1,3,3,3,3,0,0,1-1.5,2.59,1,1,0,0,0-.5.84,1,1,0,0,0,.45.86l.39.26.13.07a7,7,0,0,1,4,6.38,1,1,0,0,0,2,0A9,9,0,0,0,18.74,11.82Z"/>
                    </svg> 
                    <span>Acteur</span>
                </a>
			</li>


			<li class="sidebar__nav-item">
				<a href="realisateur.php" class="sidebar__nav-link">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                        <path d="M21 3H7.2L6.27 1.2C6.08.8 5.64.5 5.17.5H3c-.55 0-1 .45-1 1s.45 1 1 1h1.17L6 5H3C2.45 5 2 5.45 2 6s.45 1 1 1h3.73L7.2 7.5H5.5l-1-1H3.7c-.44 0-.8.36-.8.8v2.4c0 .44.36.8.8.8h1.7l.95 3.17-4.25 4.25c-.29.29-.45.68-.45 1.09v1.25c0 .83.67 1.5 1.5 1.5h1.25c.41 0 .8-.16 1.09-.45l4.25-4.25L14.83 20h2.67c.44 0 .8-.36.8-.8V16.5h1.7c.44 0 .8-.36.8-.8v-2.4c0-.44-.36-.8-.8-.8H20l-1.5-5.5H21c.55 0 1-.45 1-1s-.45-1-1-1h-3.73L15 3.5h5.83C21.55 3.5 22 3.05 22 2.5s-.45-1-1-1h-5.83L15 3.5H9.83l1.3 2.5H17l1.5 5.5H3.83L2 6.5H1.17c-.44 0-.8-.36-.8-.8V3.7c0-.44.36-.8.8-.8H3.7L2 1.17C2.5 1.5 3 .5 3 .5h5.2l1.3 2.5H21c.55 0 1-.45 1-1s-.45-1-1-1zm0 0V20h-2v1h-1v-1H4v1H3v-1H1V3.5h.83L1 2.5h1.7c.44 0 .8.36.8.8v2.4c0 .44-.36.8-.8.8H1.17L2 6.5H3v2h2V6.5h14v2h2V3.5h.83L22 2.5h1v-1h1v1z"/>
                    </svg>                    
                    <span>Realisateur</span>
                </a>
			</li>

			<li class="sidebar__nav-item">
				<a href="<?php echo $GLOBALS['PAGESUser']; ?>index.php" class="sidebar__nav-link">
                    <svg viewBox="0 0 24 24">
                        <path d="M17,11H9.41l3.3-3.29a1,1,0,1,0-1.42-1.42l-5,5a1,1,0,0,0-.21.33,1,1,0,0,0,0,.76,1,1,0,0,0,.21.33l5,5a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42L9.41,13H17a1,1,0,0,0,0-2Z"/>
                    </svg> 
                    <span>Retour Accueil</span>
                </a>
			</li>
		</ul>
		<!-- end sidebar nav -->
	</div>
	<!-- end sidebar -->
