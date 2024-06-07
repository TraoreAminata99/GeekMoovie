<?php

namespace moovie\moovieAdmin;

use Exception;

use moovie\moovieAdmin\ActeurDB;

class Acteur_Form
{
    private $adb ;

    public function generateForm_Act(){ ?>
      
        <!-- main content -->
        <main class="main">
            <div class="container-fluid">
                <div class="row">
                    <!-- main title -->
                    <div class="col-12">
                        <div class="main__title">
                            <h2>Ajout Acteur</h2>
                        </div>
                    </div>
                    <!-- end main title -->

                    <!-- form -->
                    <div class="col-12">
                        <form action="<?php echo $GLOBALS['PAGES']; ?>/admin_page/addAct.php" class="form" enctype="multipart/form-data" id="act_form" method="POST">
                            <div class="row">
                                <div class="col-12 col-md-5 form__cover">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-12">
                                            <div class="form__img">
                                                <label for="form__img-upload">Image Acteur</label>
                                                <input id="form__img-upload" name="pictureActeur" type="file" accept=".png, .jpg, .jpeg">
                                                <img id="form__img" src="" alt=" ">
                                                <span class="error-message" id="error-affiche"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-7 form__content">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form__group">
                                                <input type="text" class="form__input" placeholder="Nom Acteur" name="nameActeur" id="nameActeur">
                                                <span class="error-message" id="error-titre"></span>
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
                    } else {
                        preview.src = "";
                        alert("Veuillez remplir tous les champs requis.");
                    }
                });

                // Vérification du formulaire
                const form = document.getElementById("act_form");
                const fields = {
                    titre: document.getElementById("nameActeur")
                };
                
                //alert(actExist);
                form.addEventListener('submit', (ev) => {
                    //let hasError = false;

                    Object.keys(fields).forEach(key => {
                        const field = fields[key];
                        const errorField = document.getElementById(`error-${key}`);
                        errorField.textContent = "";
                        if (field.value.trim() === "") {
                            ev.preventDefault();
                            field.classList.add("error");
                            errorField.textContent = "Ce champ est requis.";
                            actExist = false;
                        // }else if(actExist){
                        //     ev.preventDefault();
                        //     field.classList.add("error");
                        //     errorField.textContent = "Cet acteur existe déjà ...";
                        }
                    });                    
                });

                Object.keys(fields).forEach(key => {
                    const field = fields[key];
                    field.addEventListener('input', () => {
                        field.classList.remove("error");
                    });
                });
            });
        </script>
    <?php
    }


    public function editForm_Act($id){
        $this->adb = new ActeurDB();
        $act = $this->adb->getActeurById($id);
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
                                                        <form id="act_form" action="editAct.php?id=<?php echo htmlspecialchars($act->id_act ?? ''); ?>" class="form" enctype="multipart/form-data" method="POST">
                                                            <div class="row">
                                                                <div class="col-12 col-md-5 form__cover">
                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-6 col-md-12">
                                                                            <div class="form__img">
                                                                                <label for="form__img-upload">Image Réalisateur</label>
                                                                                <input id="form__img-upload" value="" name="photo" type="file" accept=".png, .jpg, .jpeg">
                                                                                <img id="form__img" src="/pages/admin_page/<?php echo htmlspecialchars($act->photo ?? ' '); ?>" alt=" ">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                    
                                                                <div class="col-12 col-md-7 form__content">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <div class="form__group">
                                                                                <input type="text" id="nameActeur" class="form__input" placeholder="Nom acteur" name="nom" value="<?php echo htmlspecialchars($act->nom?? ''); ?>">
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
                    } else {
                        preview.src = "";
                        alert("Veuillez remplir tous les champs requis.");
                    }
                });

                // Vérification du formulaire
                const form = document.getElementById("act_form");
                const fields = {
                    titre: document.getElementById("nameActeur")
                };

                form.addEventListener('submit', (ev) => {
                    let hasError = false;

                    Object.keys(fields).forEach(key => {
                        const field = fields[key];
                        if (field.value.trim() === "") {
                            ev.preventDefault();
                            field.classList.add("error");
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
                    });
                });
            });
        </script>
    <?php }

    /**
     * @throws Exception
     */
    
    public function handleFormSubmission($data){

        if ($this->adb  === null) {
            $this->adb  = new ActeurDB();
        }
        $this->adb ->registerActor($data);
        header("Location:".$GLOBALS['PAGES']."/admin_page/acteur.php");
        exit();
    }
}
    