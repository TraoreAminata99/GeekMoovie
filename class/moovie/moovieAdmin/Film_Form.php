<?php

namespace moovie\moovieAdmin;

use Exception;

use moovie\moovieAdmin\FilmDB;
use moovie\moovieAdmin\RealisateurDB;
use moovie\moovieAdmin\ActeurDB;
use moovie\moovieAdmin\TagDB;

class Film_Form
{
    private $fdb ;

    public function generateFilm_Form(){
        // Récupérer les réalisateurs depuis la base de données
        $realisateurs = new RealisateurDB();
        $real = $realisateurs->getAllRealisateur();
        // Récupérer les acteurs depuis la base de données
        $acteurs = new ActeurDB();
        $act = $acteurs->getAllActeur();
        // Récupérer les genres depuis la base de données
        $genre = new TagDB();
        $gen = $genre->getAllTag();
        ?>
    
        <!-- main content -->
        <main class="main">
            <div class="container-fluid">
                <div class="row">
                    <!-- main title -->
                    <div class="col-12">
                        <div class="main__title">
                            <h2>Ajout Film</h2>
                        </div>
                    </div>
                    <!-- end main title -->
        
                    <!-- form -->
                    <div class="col-12">
                        <form id="film_form" action="<?php echo $GLOBALS['PAGES']; ?>/admin_page/addfilm.php" method="POST" class="form" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-12 col-md-5 form__cover">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-12">
                                            <div class="form__img">
                                                <label for="form__img-upload">Image film</label>
                                                <input id="form__img-upload" name="affiche" type="file" accept=".png, .jpg, .jpeg">
                                                <img id="form__img" src="#" alt="">
                                                <span class="error-message" id="error-affiche"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
        
                                <div class="col-12 col-md-7 form__content">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form__group">
                                                <input type="text" class="form__input" placeholder="Nom film" name="titre" id="titre">
                                                <span class="error-message" id="error-titre"></span>
                                            </div>
                                        </div>
        
                                        <div class="col-12">
                                            <div class="form__group">
                                                <textarea type="text" id="text" name="synopsis" class="form__textarea" placeholder="Description"></textarea>
                                                <span class="error-message" id="error-synopsis"></span>
                                            </div>
                                        </div>
        
                                        <div class="col-12 col-sm-6 col-lg-4">
                                            <div class="form__group">
                                                <input type="date" name="date_sortie" class="form__input" placeholder="Date de sortie" id="date">
                                                <span class="error-message" id="error-date"></span>
                                            </div>
                                        </div>
        
                                        <div class="col-12 col-sm-6 col-lg-4">
                                            <div class="form__group">
                                                <input type="time" name="min_film" class="form__input" placeholder="Durée du film" id="min_film">
                                                <span class="error-message" id="error-min_film"></span>
                                            </div>
                                        </div>
        
                                        <div class="col-12 col-sm-6 col-lg-4">
                                            <div class="form__group">
                                                <select name="nameReal" class="js-example-basic-single" id="realisateur">
                                                    <option value="">Sélectionner un réalisateur</option>
                                                    <?php foreach ($real as $realisateur): ?>
                                                        <option value="<?php echo htmlspecialchars($realisateur->nom); ?>">
                                                            <?php echo htmlspecialchars($realisateur->nom); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <span class="error-message" id="error-realisateur"></span>
                                            </div>
                                        </div>
        
                                        <div class="col-12 col-lg-6">
                                            <div class="form__group">
                                                <select name="acteurs[]" class="js-example-basic-multiple" id="acteur" multiple="multiple">
                                                    <?php foreach($act as $acteur): ?>
                                                        <option value="<?php echo htmlspecialchars($acteur->nom); ?>">
                                                            <?php echo htmlspecialchars($acteur->nom); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <span class="error-message" id="error-acteur"></span>
                                            </div>
                                        </div>
        
                                        <div class="col-12 col-lg-6">
                                            <div class="form__group">
                                                <select name="tags[]" class="js-example-basic-multiple" id="genre" multiple="multiple">
                                                    <?php foreach($gen as $genres): ?>
                                                        <option value="<?php echo htmlspecialchars($genres->nom); ?>">
                                                            <?php echo htmlspecialchars($genres->nom); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <span class="error-message" id="error-genre"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
        
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12">
                                            <button type="submit" class="form__btn">Ajouter</button>
                                        </div>
                                    </div>
                                </div>
        
                            </div>
                        </form>
                    </div>
                    <!-- end form -->
                </div>
            </div>
        </main>
        <!-- end main content -->
    
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Prévisualisation de l'image
                const preview = document.getElementById("form__img");
                const reader = new FileReader();
        
                reader.onload = (e) => {
                    preview.src = e.target.result;
                };
        
                const fileInput = document.getElementById("form__img-upload");
                fileInput.addEventListener('change', () => {
                    const file = fileInput.files[0];
        
                    if (file && file.type.startsWith('image/')) {
                        reader.readAsDataURL(file);
                        document.getElementById('error-affiche').textContent = "";
                    } else {
                        preview.src = "";
                        document.getElementById('error-affiche').textContent = "Veuillez sélectionner une image valide.";
                    }
                });
        
                // Vérification du formulaire
                const form = document.getElementById("film_form");
                const fields = {
                    titre: document.getElementById("titre"),
                    synopsis: document.getElementById("text"),
                    date: document.getElementById("date"),
                    min_film: document.getElementById("min_film"),
                    nameReal: document.getElementById("realisateur"),
                    acteurs: document.getElementById("acteur"),
                    tags: document.getElementById("genre")
                };
        
                form.addEventListener('submit', (ev) => {
                    let hasError = false;
        
                    Object.keys(fields).forEach(key => {
                        const field = fields[key];
                        const errorField = document.getElementById(`error-${key}`);
                        errorField.textContent = "";
                        
                        if (key === 'acteurs' || key === 'tags') {
                            if (field.selectedOptions.length === 0) {
                                ev.preventDefault();
                                field.classList.add("error");
                                errorField.textContent = "Ce champ est requis.";
                                hasError = true;
                            }
                        } else if (field.value.trim() === "") {
                            ev.preventDefault();
                            field.classList.add("error");
                            errorField.textContent = "Ce champ est requis.";
                            hasError = true;
                        }
                    });
        
                    if (hasError) {
                        alert("Veuillez remplir tous les champs requis.");
                    }
                });
        
                Object.keys(fields).forEach(key => {
                    const field = fields[key];
                    field.addEventListener('input', () => {
                        field.classList.remove("error");
                        const errorField = document.getElementById(`error-${key}`);
                        errorField.textContent = "";
                    });
                });
            });
        </script>
        
    <?php
    }
    
   
    
    public function editForm_Film($id, $errors = [], $data = []) {
        $this->fdb = new FilmDB();
        $film = $this->fdb->getFilmById($id);
    
        $realisateurs = new RealisateurDB();
        $real = $realisateurs->getAllRealisateur();
    
        $acteurs = new ActeurDB();
        $act = $acteurs->getAllActeur();
    
        $genre = new TagDB();
        $gen = $genre->getAllTag();
    
        $data = array_merge((array)$film, $data);
    
        ?>
        <!-- main content -->
        <main class="main">
            <div class="container-fluid">
                <div class="row">
                    <!-- main title -->
                    <div class="col-12">
                        <div class="main__title">
                            <h2>Modifier Film</h2>
                        </div>
                    </div>
                    <!-- end main title -->
    
                    <!-- content tabs -->
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-labelledby="1-tab">
                            <div class="col-12">
                                <div class="sign__wrap">
                                    <div class="row">
                                        <div class="col-12 col-lg-12">
                                            <!-- form -->
                                            <div class="col-12">
                                                <form id="film_form" action="editfilm.php?id=<?php echo htmlspecialchars($film->id_film ?? ''); ?>" method="POST" class="form" enctype="multipart/form-data">
                                                    <div class="row">
                                                        <div class="col-12 col-md-5 form__cover">
                                                            <div class="row">
                                                                <div class="col-12 col-sm-6 col-md-12">
                                                                    <div class="form__img">
                                                                        <label for="form__img-upload">Image film</label>
                                                                        <input id="form__img-upload" name="affiche" type="file" accept=".png, .jpg, .jpeg">
                                                                        <img id="form__img" src="/pages/admin_page/<?php echo htmlspecialchars($film->affiche ?? ''); ?>" alt=" ">
                                                                        <span class="error-message" id="error-affiche"><?php echo htmlspecialchars($errors['affiche'] ?? ''); ?></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
    
                                                        <div class="col-12 col-md-7 form__content">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="form__group">
                                                                        <input type="text" class="form__input" placeholder="Nom film" name="titre" id="titre" value="<?php echo htmlspecialchars($film->titre ?? ''); ?>">
                                                                        <span class="error-message" id="error-titre"><?php echo htmlspecialchars($errors['titre'] ?? ''); ?></span>
                                                                    </div>
                                                                </div>
    
                                                                <div class="col-12">
                                                                    <div class="form__group">
                                                                        <textarea type="text" id="synopsis" name="synopsis" class="form__textarea" placeholder="Description"><?php echo htmlspecialchars($film->synopsis ?? ''); ?></textarea>
                                                                        <span class="error-message" id="error-synopsis"><?php echo htmlspecialchars($errors['synopsis'] ?? ''); ?></span>
                                                                    </div>
                                                                </div>
    
                                                                <div class="col-12 col-sm-6 col-lg-4">
                                                                    <div class="form__group">
                                                                        <input type="date" name="date_sortie" class="form__input" placeholder="Date de sortie" id="date" value="<?php echo htmlspecialchars($film->annee ?? ''); ?>">
                                                                        <span class="error-message" id="error-date"><?php echo htmlspecialchars($errors['date_sortie'] ?? ''); ?></span>
                                                                    </div>
                                                                </div>
    
                                                                <div class="col-12 col-sm-6 col-lg-4">
                                                                    <div class="form__group">
                                                                        <input type="time" name="min_film" class="form__input" placeholder="Durée du film (minutes)" id="min_film" value="<?php echo htmlspecialchars($film->heure ?? ''); ?>">
                                                                        <span class="error-message" id="error-min_film"><?php echo htmlspecialchars($errors['min_film'] ?? ''); ?></span>
                                                                    </div>
                                                                </div>
    
                                                                <div class="col-12 col-sm-6 col-lg-4">
                                                                    <div class="form__group">
                                                                        <select name="id_real" class="form__input" id="realisateur">
                                                                            <option value="">Sélectionner un réalisateur</option>
                                                                            <?php foreach ($real as $realisateur): ?>
                                                                                <option value="<?php echo htmlspecialchars($realisateur->id_real); ?>" <?php echo ($data['id_real'] == $realisateur->id_real) ? 'selected' : ''; ?>>
                                                                                    <?php echo htmlspecialchars($realisateur->nom); ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                        <span class="error-message" id="error-realisateur"><?php echo htmlspecialchars($errors['id_real'] ?? ''); ?></span>
                                                                    </div>
                                                                </div>
    
                                                                <div class="col-12 col-lg-6">
                                                                    <div class="form__group">
                                                                        <select name="acteurs[]" class="form__input" id="acteur" multiple="multiple">
                                                                            <?php foreach ($act as $acteur): ?>
                                                                                <option value="<?php echo htmlspecialchars($acteur->id_act); ?>" <?php echo in_array($acteur->id_act, $data['acteurs']) ? 'selected' : ''; ?>>
                                                                                    <?php echo htmlspecialchars($acteur->nom); ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                        <span class="error-message" id="error-acteur"><?php echo htmlspecialchars($errors['acteurs'] ?? ''); ?></span>
                                                                    </div>
                                                                </div>
    
                                                                <div class="col-12 col-lg-6">
                                                                    <div class="form__group">
                                                                        <select name="tags[]" class="form__input" id="genre" multiple="multiple">
                                                                            <?php foreach ($gen as $genres): ?>
                                                                                <option value="<?php echo htmlspecialchars($genres->id_tag); ?>" <?php echo in_array($genres->id_tag, $data['tags']) ? 'selected' : ''; ?>>
                                                                                    <?php echo htmlspecialchars($genres->nom); ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                        <span class="error-message" id="error-genre"><?php echo htmlspecialchars($errors['tags'] ?? ''); ?></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <button type="submit" class="form__btn">Modifier</button>
                                                                </div>
                                                            </div>
                                                        </div>
    
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- end form -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                    </div>
                    <!-- end content tabs -->
                </div>
            </div>
        </main>
        <!-- end main content -->
    
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Prévisualisation de l'image
                const preview = document.getElementById("form__img");
                const reader = new FileReader();
    
                reader.onload = (e) => {
                    preview.src = e.target.result;
                };
    
                const fileInput = document.getElementById("form__img-upload");
                fileInput.addEventListener('change', () => {
                    const file = fileInput.files[0];
    
                    if (file && file.type.startsWith('image/')) {
                        reader.readAsDataURL(file);
                        document.getElementById('error-affiche').textContent = "";
                    } else {
                        preview.src = "";
                        document.getElementById('error-affiche').textContent = "Veuillez sélectionner une image valide.";
                    }
                });
    
                // Vérification du formulaire
                const form = document.getElementById("film_form");
                const fields = {
                    titre: document.getElementById("titre"),
                    synopsis: document.getElementById("synopsis"),
                    date: document.getElementById("date"),
                    min_film: document.getElementById("min_film"),
                    id_real: document.getElementById("realisateur"),
                    acteurs: document.getElementById("acteur"),
                    tags: document.getElementById("genre")
                };
    
                form.addEventListener('submit', (ev) => {
                    let hasError = false;
    
                    Object.keys(fields).forEach(key => {
                        const field = fields[key];
                        const errorField = document.getElementById(`error-${key}`);
                        errorField.textContent = "";
    
                        if ((key === 'acteurs' || key === 'tags') && field.selectedOptions.length === 0) {
                            ev.preventDefault();
                            field.classList.add("error");
                            errorField.textContent = "Ce champ est requis.";
                            hasError = true;
                        } else if (field.value.trim() === "") {
                            ev.preventDefault();
                            field.classList.add("error");
                            errorField.textContent = "Ce champ est requis.";
                            hasError = true;
                        }
                    });
    
                    if (hasError) {
                        alert("Veuillez remplir tous les champs requis.");
                    }
                });
    
                Object.keys(fields).forEach(key => {
                    const field = fields[key];
                    field.addEventListener('input', () => {
                        field.classList.remove("error");
                        const errorField = document.getElementById(`error-${key}`);
                        errorField.textContent = "";
                    });
                });
            });
        </script>
    
        <?php
    }
    

    /**
     * @throws Exception
     */
    public function handleFormSubmission($data)
    {
        if ($this->fdb === null) {
            $this->fdb = new FilmDB();
        }
        $this->fdb->insertFilm($data);
        header("Location: ". $GLOBALS['PAGES']."/admin_page/film.php");
        exit();
    }
    
}