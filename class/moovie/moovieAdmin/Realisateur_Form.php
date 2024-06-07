<?php

namespace moovie\moovieAdmin;

use Exception;

use moovie\moovieAdmin\RealisateurDB;

class Realisateur_Form
{
    private $rdb ;


    public function generateForm_Real(){ ?>
        	<!-- main content -->
	<main class="main">
		<div class="container-fluid">
			<div class="row">
				<!-- main title -->
				<div class="col-12">
					<div class="main__title">
						<h2>Ajout Réalisateur</h2>
					</div>
				</div>
				<!-- end main title -->

				<!-- form -->
				<div class="col-12">
					<form action="<?php echo $GLOBALS['PAGES']; ?>/admin_page/addReali.php" class="form" id="real_form" enctype="multipart/form-data" method="POST">
						<div class="row">
							<div class="col-12 col-md-5 form__cover">
								<div class="row">
									<div class="col-12 col-sm-6 col-md-12">
										<div class="form__img">
											<label for="form__img-upload">Image Réalisateur</label>
											<input id="form__img-upload" name="pictureReal" type="file" accept=".png, .jpg, .jpeg">
											<img id="form__img" src="#" alt=" ">
                                            <span class="error-message" id="error-affiche"></span>
										</div>
									</div>
								</div>
							</div>

							<div class="col-12 col-md-7 form__content">
								<div class="row">
									<div class="col-12">
										<div class="form__group">
											<input type="text" class="form__input" placeholder="Nom Realisateur" name="nameReal" id="nameReal">
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
                const form = document.getElementById("real_form");
                const fields = {
                    titre: document.getElementById("nameReal")
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


    public function editForm_Real($id){
      
        $this->rdb = new RealisateurDB();
        $real = $this->rdb->getRealisateurById($id);
        ?>
        <!-- main content -->
        <main class="main">
            <div class="container-fluid">
                <div class="row">
                    <!-- main title -->
                    <div class="col-12">
                        <div class="main__title">
                            <h2>Modifier Réalisateur</h2>
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
                                                    <form id="real_form" action="editReal.php?id=<?php echo htmlspecialchars($real->id_real ?? ''); ?>" class="form" enctype="multipart/form-data" method="POST">
                                                        <div class="row">
                                                            <div class="col-12 col-md-5 form__cover">
                                                                <div class="row">
                                                                    <div class="col-12 col-sm-6 col-md-12">
                                                                        <div class="form__img">
                                                                            <label for="form__img-upload">Image Réalisateur</label>
                                                                            <input id="form__img-upload" value="" name="photo" type="file" accept=".png, .jpg, .jpeg">
                                                                            <img id="form__img" src="/pages/admin_page/<?php echo htmlspecialchars($real->photo ?? ''); ?>" alt=" ">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                
                                                            <div class="col-12 col-md-7 form__content">
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="form__group">
                                                                            <input type="text" id="nameReal" class="form__input" placeholder="Nom Realisateur" name="nom" value="<?php echo htmlspecialchars($real->nom?? ''); ?>">
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
                    const form = document.getElementById("real_form");
                    const fields = {
                        titre: document.getElementById("nameReal")
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
    <?php 
    }

      
    /**
     * @throws Exception
     */
    
    public function handleFormSubmission($data){

        if ($this->rdb  === null) {
            $this->rdb  = new RealisateurDB();
        }
        $this->rdb ->registerDirector($data);
        header("Location:". $GLOBALS['PAGES']."/admin_page/realisateur.php");
        exit();
    }

}
    