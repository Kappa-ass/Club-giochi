<?php
// logout.php

session_start();

// Distruggi tutti i dati della sessione
session_unset();
session_destroy();

// Reindirizza alla pagina di login o alla homepage
header("Location: /login.php");
exit();
?>