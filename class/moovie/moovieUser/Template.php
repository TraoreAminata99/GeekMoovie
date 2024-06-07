<?php

namespace moovie\moovieUser;

class Template
{
    public static function render(string $content) : void
    {
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap-reboot.min.css">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap-grid.min.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
            <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
              <!-- CSS -->
              <link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['CSS_DIR']; ?>main.css">

            <!-- <link rel="stylesheet" type="text/css" href="../../../assets/css/main.css"> -->
           
            <title>GeekMoovie</title>

            <!-- Favicons -->
            <link rel="icon" type="image/png" href="<?php echo $GLOBALS['IMGICON_DIR']; ?>icon.png" sizes="32x32">
        </head>

        <body>

           <?php include $GLOBALS['PHP_DIR']."pages/user_page/header.php"; ?>

           
                <?php echo $content ?> 
           
            <?php include $GLOBALS['PHP_DIR']."pages/user_page/footer.php"; ?>

            <!-- JS -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
            
            <script type="text/javascript" src="<?php echo $GLOBALS['JS_DIR']; ?>main.js"></script>
            <!-- <script type="text/javascript" src="../../../assets/js/main.js"></script>  -->


        </body>
        </html>

        <?php
    }
}
