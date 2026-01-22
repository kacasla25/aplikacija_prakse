<?php
session_start();
require __DIR__ . "/../db.php";

if (!isset($_SESSION['id_korisnik']) || $_SESSION['tip_korisnika'] != 'firma') {
    header("Location: ../prijava.html");
    exit;
}

$id_firma = $_SESSION['id_korisnik'];

$upit_firma = "SELECT maticni_broj FROM firma WHERE id_korisnik = $id_firma";
$rez_firma = mysqli_query($conn, $upit_firma);
$firma = mysqli_fetch_assoc($rez_firma);
$maticni_broj = $firma['maticni_broj'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $naziv = mysqli_real_escape_string($conn, $_POST['naziv']);
    $opis = mysqli_real_escape_string($conn, $_POST['opis']);
    $lokacija = mysqli_real_escape_string($conn, $_POST['lokacija']);
    $model_rada = mysqli_real_escape_string($conn, $_POST['model_rada']);
    $datum_isteka = $_POST['datum_isteka'];
    $datum_pocetka_prakse = $_POST['datum_pocetka_prakse'];
    $trajanje_prakse = mysqli_real_escape_string($conn, $_POST['trajanje_prakse']);
    $vestine = mysqli_real_escape_string($conn, $_POST['vestine']);

    $insert = "INSERT INTO oglasi 
            (naziv, opis, lokacija, model_rada, datum_isteka, datum_pocetka_prakse, trajanje_prakse, vestine, maticni_broj)
            VALUES
            ('$naziv', '$opis', '$lokacija', '$model_rada', '$datum_isteka', '$datum_pocetka_prakse', '$trajanje_prakse', '$vestine', $maticni_broj)";

    if (mysqli_query($conn, $insert)) {
        header("Location: pocetna.php");
        mysqli_query($conn, "UPDATE firma SET br_preostalih_oglasa = br_preostalih_oglasa - 1 WHERE maticni_broj = '$maticni_broj'");
    } else {
        echo "Greška: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style-oglas.css" />

</head>
<body>

    <form action="" method="POST">
        <h2>Okači novi oglas</h2>
        <label>Naziv oglasa:</label><br>
        <input type="text" name="naziv" required><br><br>

        <label>Opis:</label><br>
        <textarea name="opis" rows="5" required></textarea><br><br>

        <label>Lokacija:</label><br>
        <input type="text" name="lokacija" required><br><br>

        <label>Model rada:</label><br>
        <select name="model_rada" required>
            <option value="" disabled selected>Izaberite opciju</option>
            <option value="fizički">Fizički</option>
            <option value="remote">Remote</option>
            <option value="hibrid">Hibrid</option>
        </select><br><br>

        <label>Datum isteka oglasa:</label><br>
        <input type="date" name="datum_isteka"><br><br>

        <label>Datum početka prakse:</label><br>
        <input type="date" name="datum_pocetka_prakse"><br><br>

        <label>Trajanje prakse:</label><br>
        <input type="text" name="trajanje_prakse" placeholder="npr. 2 meseca"><br><br>

        <label>Veštine:</label><br>
        <textarea name="vestine" rows="3" placeholder="npr. PHP, HTML, CSS"></textarea><br><br>

        <button type="submit">Dodaj oglas</button>
    </form>
</body>
</html>
