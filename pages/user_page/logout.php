<?php
session_start();


session_destroy();

header("Location:../user_page/index.php");
exit;
?>