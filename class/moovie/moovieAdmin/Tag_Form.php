<?php

namespace moovie\moovieAdmin;

use moovie\moovieAdmin\TagDB;

use Exception;

class Tag_Form
{
    private $tdb ;
    public function generateForm_Tag(){ ?>
        <!-- main content -->
            <main class="main">
                <div class="container-fluid">
                    <div class="row">
                        <!-- main title -->
                        <div class="col-12">
                            <div class="main__title">
                                <h2>Ajout tag</h2>
                            </div>
                        </div>
                        <!-- end main title -->

                        <!-- form -->
                        <div class="col-12">
                            <form action="<?php echo $GLOBALS['PAGES']; ?>/admin_page/addgenre.php" class="form" id="form_tag" enctype="multipart/form-data" method="POST">
                                <div class="row">                                    
                                    <div class="col-12 col-md-7 form__content">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form__group">
                                                    <input type="text" class="form__input" placeholder="Tag" name="nameTag" id="nameTag">
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
                // Vérification du formulaire
                const form = document.getElementById("form_tag");
                const fields = {
                    titre: document.getElementById("nameTag")
                };
                form.addEventListener('submit', (ev) => {

                    Object.keys(fields).forEach(key => {
                        const field = fields[key];
                        const errorField = document.getElementById(`error-${key}`);
                        errorField.textContent = "";

                        if (field.value.trim() === "") {
                            ev.preventDefault();
                            field.classList.add("error");
                            errorField.textContent = "Ce champ est requis.";
                        }
                    });

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

    public function editForm_Tag($id){
        $this->tdb = new TagDB();
        $tag = $this->tdb->getTagById($id);
        ?>
        <!-- main content -->
        <main class="main">
            <div class="container-fluid">
                <div class="row">
                    <!-- main title -->
                    <div class="col-12">
                        <div class="main__title">
                            <h2>Modifier tag</h2>
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
                                                    <form id="form_tag" action="editGenre.php?id=<?php echo htmlspecialchars($tag->id_tag ?? ''); ?>" class="form" method="POST">
                                                        <div class="row">
                                                        
                                                            <div class="col-12 col-md-7 form__content">
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="form__group">
                                                                            <input type="text" class="form__input" placeholder="Nom Tag" name="nom" id="nameTag" value="<?php echo htmlspecialchars($tag->nom ?? ''); ?>">
                                                                            <span class="error-message" id="error-titre"></span>
                                                                        
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
                // Vérification du formulaire
                const form = document.getElementById("form_tag");
                const fields = {
                    titre: document.getElementById("nameTag")
                };

                form.addEventListener('submit', (ev) => {
                    let hasError = false;

                    Object.keys(fields).forEach(key => {
                        const field = fields[key];
                        const errorField = document.getElementById(`error-${key}`);
                        errorField.textContent = "";

                        if (field.value.trim() === "") {
                            ev.preventDefault();
                            field.classList.add("error");
                            errorField.textContent = "Ce champ est requis.";
                            hasError = true;
                        }else{
                            ev.preventDefault();
                            field.classList.add("error");
                            errorField.textContent = "Ce tag existe déjà ...";
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
    
    public function handleFormSubmission($data){
        if ($this->tdb === null) {
            $this->tdb = new TagDB();
        }
        $this->tdb->registerTags($data);
        header("Location:". $GLOBALS['PAGES']."/admin_page/genre.php");
        exit();
    }
}
    