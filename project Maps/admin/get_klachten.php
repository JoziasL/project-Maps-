<?php
$conn = mysqli_connect("localhost", "root", "root", "maps");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query om alle klachten op te halen
$query = "SELECT * FROM klachten";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Maak een array om klachtgegevens op te slaan
$klachten = array();

// Loop door de resultaten en voeg elke klacht toe aan de array
while ($row = mysqli_fetch_assoc($result)) {
    $klacht = array(
        'id' => $row['id'],
        'titel' => $row['titel'],
        'beschrijving' => $row['beschrijving'],
        'locatie' => array((float)$row['breedtegraad'], (float)$row['lengtegraad']),
        'categorie' => $row['categorie'],
        'datum_tijd' => $row['datum_tijd']
    );

    $klachten[] = $klacht;
}

// Zet de array om naar JSON en retourneer het
echo json_encode($klachten);

// Sluit de databaseverbinding
mysqli_close($conn);
?>
