<?php
session_start();

// Controleer of de gebruiker is ingelogd als admin
if (isset($_SESSION['admin']) && $_SESSION['admin']) {
    // Verwijder alle sessievariabelen
    session_unset();

    // Vernietig de sessie
    session_destroy();

    // Stuur de gebruiker terug naar de loginpagina
    header("Location: login.php");
    exit();
} else {
    // Als de gebruiker niet is ingelogd als admin, stuur ze dan naar de loginpagina
    header("Location: login.php");
    exit();
}
?>


