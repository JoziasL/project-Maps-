<?php
session_start();

$conn = mysqli_connect("localhost", "root", "root", "maps");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gebruikersnaam = $_POST["gebruikersnaam"];
    $wachtwoord = password_hash($_POST["wachtwoord"], PASSWORD_DEFAULT);
    $beveiligingscode_gebruiker = $_POST["beveiligingscode"];

    // Controleer of de ingevoerde beveiligingscode overeenkomt met de vooraf ingestelde waarde
    $vooraf_ingestelde_beveiligingscode = "1234";
    if ($beveiligingscode_gebruiker !== $vooraf_ingestelde_beveiligingscode) {
        $foutmelding = "Ongeldige beveiligingscode";
    } else {
        $query = "INSERT INTO gebruikers (gebruikersnaam, wachtwoord, beveiligingscode) 
                  VALUES ('$gebruikersnaam', '$wachtwoord', '$beveiligingscode_gebruiker')";

        if (mysqli_query($conn, $query)) {
            $_SESSION['admin'] = true;
            header("Location: admin-index.php");
            exit();
        } else {
            $foutmelding = "Registratiefout: " . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registratie</title>
    <link rel="stylesheet" href="../stylesheet.css">
</head>
<body>
<div class="container">
    <h1>Registratie</h1>

    <?php
    if (isset($foutmelding)) {
        echo '<p class="error-message">' . $foutmelding . '</p>';
    }
    ?>

    <form method="post" action="">
        <label for="gebruikersnaam">Gebruikersnaam:</label>
        <input type="text" name="gebruikersnaam" required>

        <label for="wachtwoord">Wachtwoord:</label>
        <input type="password" name="wachtwoord" required>

        <label for="beveiligingscode">Beveiligingscode (vier cijfers):</label>
        <input type="text" name="beveiligingscode" required>

        <input type="submit" value="Registreren">
    </form>
</div>
</body>
</html>
