<?php
session_start();

$conn = mysqli_connect("localhost", "root", "root", "maps");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gebruikersnaam = $_POST["gebruikersnaam"];
    $wachtwoord = $_POST["wachtwoord"];

    $query = "SELECT id, wachtwoord FROM gebruikers WHERE gebruikersnaam = '$gebruikersnaam'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($wachtwoord, $row["wachtwoord"])) {
            $_SESSION['admin'] = true;
            header("Location: admin-index.php");
            exit();
        } else {
            $foutmelding = "Ongeldige inloggegevens";
        }
    } else {
        $foutmelding = "Databasefout: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" type="text/css" href="../stylesheet.css" />

    <div class="topnav">
        <a <?php if(basename($_SERVER['PHP_SELF']) == 'index.php') echo 'class="active"'; ?> href="../index.php">Home</a>
        <a <?php if(basename($_SERVER['PHP_SELF']) == 'maps.php') echo 'class="active"'; ?> href="../maps.php">Maps</a>
        <a <?php if(basename($_SERVER['PHP_SELF']) == 'contact.php') echo 'class="active"'; ?> href="../contact.php">Contact</a>
        <a <?php if(basename($_SERVER['PHP_SELF']) == 'admin-index.php' || basename($_SERVER['PHP_SELF']) == 'login.php') echo 'class="active"'; ?> href="admin-index.php">Admin</a>

    </div>

</head>
<body>
<h1>Admin Login</h1>

<?php
if (isset($foutmelding)) {
    echo '<p style="color: red;">' . $foutmelding . '</p>';
}
?>

<form method="post" action="">
    Gebruikersnaam: <input type="text" name="gebruikersnaam" required><br>
    Wachtwoord: <input type="password" name="wachtwoord" required><br>
    <input type="submit" value="Inloggen">

    <!-- Link naar registratiepagina -->
    <p>Nog geen account? <a href="register.php">Registreer hier</a>.</p>
</form>


</body>
</html>