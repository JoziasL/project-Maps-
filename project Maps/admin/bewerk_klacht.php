<?php
session_start();

// Controleer of de gebruiker is ingelogd als admin
if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header("Location: login.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "root", "maps");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Controleer of een klacht-id is meegegeven in de querystring
if (isset($_GET['id'])) {
    $klacht_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Haal de klachtgegevens op
    $klacht_query = "SELECT * FROM klachten WHERE id = $klacht_id";
    $klacht_result = mysqli_query($conn, $klacht_query);

    if ($klacht_result && mysqli_num_rows($klacht_result) > 0) {
        $klacht = mysqli_fetch_assoc($klacht_result);
    } else {
        echo "Klacht niet gevonden.";
        exit();
    }
} else {
    echo "Klacht-id ontbreekt.";
    exit();
}

// Verwerk het bewerken van de klacht
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titel = mysqli_real_escape_string($conn, $_POST['titel']);
    $beschrijving = mysqli_real_escape_string($conn, $_POST['beschrijving']);
    // Voeg andere formuliergegevens toe...

    $bewerk_query = "UPDATE klachten SET titel = '$titel', beschrijving = '$beschrijving' WHERE id = $klacht_id";

    if (mysqli_query($conn, $bewerk_query)) {
        header("Location: admin-index.php");
        exit();
    } else {
        echo "Fout bij het bewerken van de klacht: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bewerk Klacht</title>
    <link rel="stylesheet" href="../stylesheet.css">
</head>

<body>
<div class="container">
    <h1>Bewerk Klacht</h1>

    <form action="" method="post">
        <label for="titel">Titel:</label>
        <input type="text" id="titel" name="titel" value="<?php echo $klacht['titel']; ?>" required><br>

        <label for="beschrijving">Beschrijving:</label>
        <textarea id="beschrijving" name="beschrijving" required><?php echo $klacht['beschrijving']; ?></textarea><br>

        <!-- Voeg andere formulierelementen toe... -->

        <input type="submit" value="Bewerken">
    </form>
</div>
</body>

</html>
