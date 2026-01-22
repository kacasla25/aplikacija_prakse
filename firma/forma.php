<?php
session_start();
require __DIR__ . "/../db.php";
if (!isset($_SESSION['id_korisnik'])) {
    header("Location: ../prijava.html");
    exit;
}

$id_korisnik = $_SESSION['id_korisnik'];

if(isset($_POST['ime_firme'], $_POST['maticni_broj'],$_POST['email_kontakt'])){
    
    $ime_firme = mysqli_real_escape_string($conn, $_POST['ime_firme']);
    $maticni_broj = mysqli_real_escape_string($conn, $_POST['maticni_broj']);
    $email_kontakt = mysqli_real_escape_string($conn, $_POST['email_kontakt']);
}
$provera = "SELECT id_korisnik FROM firma WHERE id_korisnik = $id_korisnik";
$rez = mysqli_query($conn, $provera);

if (mysqli_num_rows($rez) > 0) {
    header("Location: pocetna.php");
    exit;
}
$insert = "INSERT INTO firma 
(maticni_broj, id_korisnik, ime_firme, email_kontakt, br_preostalih_oglasa, br_preostalih_vip)
VALUES
('$maticni_broj', $id_korisnik, '$ime_firme', '$email_kontakt', 0, 0)";

if(mysqli_query($conn, $insert)){
        header("Location: pocetna.php");
        exit;
    }
else{
    echo "<p>Svi podaci su obavezni.</p>";
    echo "<a href='forma.php'>Nazad</a>";
}
?>

