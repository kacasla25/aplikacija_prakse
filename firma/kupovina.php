<?php
session_start();
require __DIR__ . "/../db.php";

if (!isset($_SESSION['id_korisnik']) || $_SESSION['tip_korisnika'] != 'firma') {
    header("Location: ../prijava.html");
    exit;
}

$id_firme = $_SESSION['id_korisnik'];

if (isset($_POST['id_paketa']) && !empty($_POST['id_paketa'])) {
        $id_paketa = $_POST['id_paketa'];
        $upit_firma="SELECT maticni_broj, br_preostalih_oglasa, br_preostalih_vip FROM firma WHERE id_korisnik = $id_firme";
        $rez_firme = mysqli_query($conn, $upit_firma);
        $firma = mysqli_fetch_assoc($rez_firme);
        $maticni_broj = $firma['maticni_broj'];

$upit_paket="SELECT * FROM paketi WHERE id_paket = $id_paketa";
    $rez = mysqli_query($conn, $upit_paket);
    $paket = mysqli_fetch_assoc($rez);


    if ($paket) {
        $novi_oglasi = $firma['br_preostalih_oglasa'] + $paket['broj_oglasa'];
        $novi_vip = $firma['br_preostalih_vip'] + $paket['broj_vip'];

$azuriranje="UPDATE firma 
SET br_preostalih_oglasa = $novi_oglasi, 
br_preostalih_vip = $novi_vip 
WHERE id_korisnik = $id_firme";
mysqli_query($conn, $azuriranje);

$uplata="INSERT INTO uplata (maticni_broj, id_paket, datum_uplate) 
VALUES ('$maticni_broj', $id_paketa, NOW())";
mysqli_query($conn, $uplata);
header("Location: pocetna.php");
exit;
} else {
    echo "Niste izabrali paket.";
}}
?>