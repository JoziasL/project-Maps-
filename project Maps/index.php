
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klachtenformulier</title>
    <link rel="stylesheet" type="text/css" href="stylesheet.css" />
    <link rel="icon" href="data:,">
</head>

<body>
<div class="topnav">
    <a <?php if(basename($_SERVER['PHP_SELF']) == 'index.php') echo 'class="active"'; ?> href="index.php">Home</a>
    <a <?php if(basename($_SERVER['PHP_SELF']) == 'admin.php') echo 'class="active"'; ?> href="admin/admin-index.php">Admin</a>
</div>

<?php
session_start();
if (isset($_SESSION['success']) && $_SESSION['success'] == 1) {
    echo '<div class="success-message">';
    echo 'Het klachtenformulier is succesvol ingediend!';
    echo '<span class="close-btn" onclick="this.parentElement.style.display=\'none\'">&times;</span>';
    echo '</div>';
    $_SESSION['success'] = null;
}
?>

<h1>Klachtenformulier</h1>

<form action="process_form.php" method="post" enctype="multipart/form-data">
    <label for="titel">Titel:</label>
    <input type="text" id="titel" name="titel" required><br>

    <label for="beschrijving">Beschrijving:</label>
    <textarea id="beschrijving" name="beschrijving" required></textarea><br>

    <button type="button" onclick="getGeolocation()">Deel mijn locatie</button>
    <input type="hidden" id="breedtegraad" name="breedtegraad">
    <input type="hidden" id="lengtegraad" name="lengtegraad">

    <div id="locatie-melding"></div>

    <label for="categorie">Categorie:</label>
    <input type="text" id="categorie" name="categorie" required><br>

    <label for="foto">Foto toevoegen:</label>
    <input type="file" id="foto" name="foto" accept="image/*"><br>

    <input type="submit" value="Indienen">
</form>

<script src="script.js"></script>
</body>

</html>
