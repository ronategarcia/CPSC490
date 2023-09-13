<!-- Rodrigo Onate
     CPSC 491
     Aobuild project -->
<?php

    session_start();
    session_unset();
    session_destroy();

    header('Location: index.php');
    exit();
?>