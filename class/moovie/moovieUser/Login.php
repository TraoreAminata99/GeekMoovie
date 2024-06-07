<?php
namespace moovie\moovieUser;

class Login{
    public function generateLoginForm():void{?>
        <!-- sign in -->
        <div class="sign section--full-bg" data-bg="">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="sign__content">
                            <form action="signin.php" class="sign__form" method="post">
                                <a href="index.php" class="sign__logo">
                                <img src="<?php echo $GLOBALS['IMG_DIR']; ?>/logo.png" alt="">
                                </a>
                                <div class="sign__group">
                                    <input type="text" class="sign__input" placeholder="Email" name="login">
                                </div>

                                <div class="sign__group">
                                    <input type="password" class="sign__input" placeholder="Password" name="password">
                                </div>
                                
                                <button class="sign__btn" type="submit">Connexion</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	   <!-- end sign in -->
    <?php
    }

    public function valiform(string $username,string $passeword){
        $nom="adminGeekMoovie@gmail.com";
        $motpasse="GeekCode2024";

        $reponse =[
            'correcte'=>false,
            'msg'=>null,
            'error'=>null,
        ];
        
       if (empty($username)) {
            $reponse['error']="l'email est vide";
       }elseif (empty($passeword)) {
            $reponse['error']="le passeword est vide";
       }elseif ($username===$nom && $passeword===$motpasse) {
        $reponse['correcte']=true;
        $reponse['msg']="Admin";
       }else{
        $reponse['error']="Authentification faible";
       }

       return $reponse;
    }
}



?>