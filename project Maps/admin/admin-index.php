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

// Simpele query om alle klachten op te halen
$alle_klachten_query = "SELECT * FROM klachten";
$alle_klachten_result = mysqli_query($conn, $alle_klachten_query);

// Query om de 5 meest recente klachten op te halen
$recente_klachten_query = "SELECT * FROM klachten ORDER BY datum_tijd DESC LIMIT 5";
$recente_klachten_result = mysqli_query($conn, $recente_klachten_query);
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../leaflet.css" />
    <script src="../leaflet.js"></script>
    <link rel="stylesheet" href="../stylesheet.css">
    <div class="topnav">
        <a <?php if(basename($_SERVER['PHP_SELF']) == 'index.php') echo 'class="active"'; ?> href="../index.php">Home</a>
        <a <?php if(basename($_SERVER['PHP_SELF']) == 'maps.php') echo 'class="active"'; ?> href="../maps.php">Maps</a>
        <a <?php if(basename($_SERVER['PHP_SELF']) == 'contact.php') echo 'class="active"'; ?> href="../contact.php">Contact</a>
        <a <?php if(basename($_SERVER['PHP_SELF']) == 'admin-index.php') echo 'class="active"'; ?> href="admin-index.php">Admin</a>
        <div style="float: right;">
            <a href="logout.php">Logout</a>
        </div>
    </div>
    <style>
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            margin-bottom: 10px;
            position: relative;
        }

        .close-btn {
            position: absolute;
            top: 5px;
            right: 10px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>

<body>
<div class="container">
    <h1>Admin Dashboard</h1>

    <!-- Connected Successfully melding -->
    <div class="success-message">
        Connected Successfully
        <span class="close-btn" onclick="this.parentElement.style.display='none'">&times;</span>
    </div>

    <!-- Alle klachten -->
    <h2>Alle Klachten</h2>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Titel</th>
            <th>Beschrijving</th>
            <th>Locatie</th>
            <th>Categorie</th>
            <th>Datum/Tijd</th>
            <th>Bewerken</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($alle_klachten_result)) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['titel']}</td>";
            echo "<td>{$row['beschrijving']}</td>";
            echo "<td>[{$row['breedtegraad']}, {$row['lengtegraad']}]</td>"; // Toon locatiegegevens
            echo "<td>{$row['categorie']}</td>";
            echo "<td>{$row['datum_tijd']}</td>";
            echo "<td><a href='bewerk_klacht.php?id={$row['id']}'>Bewerken</a></td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>

    <!-- 5 meest recente klachten -->
    <h2>5 Meest Recente Klachten</h2>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Titel</th>
            <th>Beschrijving</th>
            <th>Locatie</th>
            <th>Categorie</th>
            <th>Datum/Tijd</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($recente_klachten_result)) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['titel']}</td>";
            echo "<td>{$row['beschrijving']}</td>";
            echo "<td>[{$row['breedtegraad']}, {$row['lengtegraad']}]</td>"; // Toon locatiegegevens
            echo "<td>{$row['categorie']}</td>";
            echo "<td>{$row['datum_tijd']}</td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<div id="map" style="height: 500px;"></div>
<script>
    // Initialisatie van de kaart met Leaflet
    var map = L.map('map').setView([0, 0], 2); // Stel het startpunt en het zoomniveau in

    // Toevoegen van de OpenStreetMap-laag
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Haal klachtengegevens op en voeg markers toe aan de kaart
    fetch('get_klachten.php')
        .then(response => response.json())
        .then(klachten => {
            klachten.forEach(klacht => {
                var locatie = klacht.locatie; // Bijv. [51.505, -0.09]
                var titel = klacht.titel;

                L.marker(locatie).addTo(map)
                    .bindPopup(titel); // Toon titel in de pop-up
            });
        })
        .catch(error => console.error('Fout bij het ophalen van klachtgegevens:', error));
</script>

</body>
</html>
