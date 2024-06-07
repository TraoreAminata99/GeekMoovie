<?php

namespace moovie\moovieAdmin;

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

            <!-- CSS -->
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap-reboot.min.css">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap-grid.min.css">
            <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

            <link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['CSS_DIR']; ?>admin.css">

            <!-- Favicons -->
            <link rel="icon" type="image/png" href="<?php echo $GLOBALS['IMGICON_DIR']; ?>icon.png" sizes="32x32">
            <title>Admin-GeekMoovie</title>

        </head>
        <body>

            <?php include $GLOBALS['PHP_DIR']."pages/admin_page/header.php"; ?>

           
            <?php echo $content ?> 

            <!-- JS -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/smooth-scrollbar/8.6.3/smooth-scrollbar.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
            
            <script type="text/javascript" src="<?php echo $GLOBALS['JS_DIR']; ?>admin.js"></script>

        </body>
        </html>

        <?php
    }
}
