<?php

use moovie\moovieUser\Template;

require_once "../../config.php";
session_start() ; 
	require_once $GLOBALS['PHP_DIR'] ."class/Autoloader.php";
	Autoloader::register();

	use moovie\moovieAdmin\FilmDB;
	$logged = isset($_SESSION['user']) ;

	$film = new FilmDB();
    $listeFilms=[];

	if(isset($_GET)){
        if(!empty($_GET['search'])){
        $listeFilms = $film->rechercher($_GET['search']);
        $_SESSION['listeFilms'] = $listeFilms;
        }
        else if(isset($_GET['date_filter']) and isset($_SESSION['listeFilms'])){
            $listeFilms = $_SESSION['listeFilms'];
            $idListe = array_column($listeFilms, 'id_film');
            //var_dump($_GET['date']);
            $listeFilms = $film->filtre($idListe,$_GET['date_filter'], $_GET['date']);
            //var_dump($listeFilms);
        }
	}

Autoloader::register();

ob_start();

?>

<?php if (empty($listeFilms)) {
    echo " <div style=color:red;text-align:center;>Aucun résultat trouvé pour votre recherche ... </div> ";
} else {?>

<form action="search.php" class="header__form" method="GET" style="margin-top: 20px; display: flex; justify-content: center; margin-left: 40%; background-color: transparent;">
    
    
    <!-- Select for choosing the type of date filter -->
    <select name="date_filter" id="date_filter" class="header__form-input" style="margin-right: 10px;color:white">
        <option value="msg">-- Filtrer par date --</option>
        <option value="before">Avant une date</option>
        <option value="after">Après une date</option>
        <option value="exact">Date exacte</option>
    </select>
    
    <!-- Date input field, initially hidden -->
    <input type="date" name="date" id="date_input" class="header__form-input" style="display: none; margin-right: 10px;">
    
    <!-- Submit button -->
    <button class="header__form-btn" type="submit">
        <svg viewBox="0 0 24 24">
            <path d="M21.71,20.29,18,16.61A9,9,0,1,0,16.61,18l3.68,3.68a1,1,0,0,0,1.42,0A1,1,0,0,0,21.71,20.29ZM11,18a7,7,0,1,1,7-7A7,7,0,0,1,11,18Z"/>
        </svg>
    </button>
</form>


    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div id="geek">
                        <?php for($i = 0; $i < count($listeFilms); $i++) : ?>
                            <div class="interview">
                                <a  href="details.php?id=<?php echo htmlspecialchars($listeFilms[$i]->id_film); ?>" class="interview__cover">
                                    <img  src="<?php echo $GLOBALS['IMG']; ?><?= $listeFilms[$i]->affiche ?>" alt="" style="height:260px; width: 400px">
                                    <span>
                                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11 1C16.5228 1 21 5.47716 21 11C21 16.5228 16.5228 21 11 21C5.47716 21 1 16.5228 1 11C1 5.47716 5.47716 1 11 1Z" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M14.0501 11.4669C13.3211 12.2529 11.3371 13.5829 10.3221 14.0099C10.1601 14.0779 9.74711 14.2219 9.65811 14.2239C9.46911 14.2299 9.28711 14.1239 9.19911 13.9539C9.16511 13.8879 9.06511 13.4569 9.03311 13.2649C8.93811 12.6809 8.88911 11.7739 8.89011 10.8619C8.88911 9.90489 8.94211 8.95489 9.04811 8.37689C9.07611 8.22089 9.15811 7.86189 9.18211 7.80389C9.22711 7.69589 9.30911 7.61089 9.40811 7.55789C9.48411 7.51689 9.57111 7.49489 9.65811 7.49789C9.74711 7.49989 10.1091 7.62689 10.2331 7.67589C11.2111 8.05589 13.2801 9.43389 14.0401 10.2439C14.1081 10.3169 14.2951 10.5129 14.3261 10.5529C14.3971 10.6429 14.4321 10.7519 14.4321 10.8619C14.4321 10.9639 14.4011 11.0679 14.3371 11.1549C14.3041 11.1999 14.1131 11.3999 14.0501 11.4669Z" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg> 
                                        <?= $listeFilms[$i]->heure ?>
                                    </span>
                                </a>
                                <h4 class="interview__title">
                                    <a href="details.php?id=<?php echo htmlspecialchars($listeFilms[$i]->id_film); ?>" ><?= $listeFilms[$i]->titre ?></a> 
                                </h4>
                            </div>
                        <?php endfor ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php }
 ?>


<script>
    document.getElementById('date_filter').addEventListener('change', function() {
        var dateInput = document.getElementById('date_input');
        if (this.value === 'before' || this.value === 'after' || this.value === 'exact') {
            console.log("okk");
            dateInput.style.display = 'block';
        } else {
           
            dateInput.style.display = 'none';
        }
    });
</script>


<!-- Récupère le contenu du buffer (et le vide) -->
<?php $content=ob_get_clean() ?>
<!-- Utilisation du contenu bufferisé -->
<?php Template::render($content) ?>