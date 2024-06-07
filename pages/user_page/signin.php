<?php

use moovie\moovieUser\Login;
use moovie\moovieUser\Template;

require_once "../../config.php" ;

require_once $GLOBALS['PHP_DIR'] ."class/Autoloader.php";


Autoloader::register();


ob_start();

 session_start() ;  

    $className= new Login();

    if (isset($_POST['login']) && isset($_POST['password'])) {
       $username= $_POST['login'];
       $password = $_POST['password'];

       $verif=$className->valiform($username,$password);

       if ($verif['correcte']) {
		$_SESSION['user'] = $verif['msg'];
        header("Location:".$GLOBALS['IMG']."index.php");
        echo "<div style='color:red'>" .$verif['msg']."</div>" ;
        exit();
   
       }else{
        echo "<div style='color:red'>" .$verif['error']."</div>" ;
        $className->generateLoginForm();
       }
    }else {
        $className->generateLoginForm();
    }


?>

<!-- Récupère le contenu du buffer (et le vide) -->
<?php $content=ob_get_clean() ?>
<!-- Utilisation du contenu bufferisé -->
<?php Template::render($content) ?>