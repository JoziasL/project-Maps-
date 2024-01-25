<?php
// Verbinding maken met de database (vervang deze waarden met jouw gegevens)
$conn = mysqli_connect("localhost", "root", "root", "maps");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Ontvang de gegevens van het formulier
$titel = mysqli_real_escape_string($conn, $_POST['titel']);
$beschrijving = mysqli_real_escape_string($conn, $_POST['beschrijving']);
$categorie = mysqli_real_escape_string($conn, $_POST['categorie']);
$breedtegraad = $_POST['breedtegraad'];
$lengtegraad = $_POST['lengtegraad'];

// Voeg de klachtgegevens toe aan de database
$query = "INSERT INTO klachten (titel, beschrijving, breedtegraad, lengtegraad, categorie) VALUES ('$titel', '$beschrijving', '$breedtegraad', '$lengtegraad', '$categorie')";

if (mysqli_query($conn, $query)) {
    // Klacht succesvol toegevoegd aan de database
    session_start();
    $_SESSION['success'] = 1;
    header("Location: index.php");
} else {
    // Fout bij het toevoegen van de klacht
    session_start();
    $_SESSION['success'] = 0;
    $_SESSION['error_message'] = mysqli_error($conn);
    header("Location: index.php");
}

// Sluit de databaseverbinding
mysqli_close($conn);
?>