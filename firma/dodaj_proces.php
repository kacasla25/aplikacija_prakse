<?php
require "../db.php";

$id_prijava = $_POST['id_prijava'];
$proces = $_POST['proces'];
$rezultat = $_POST['rezultat'];
$opis = $_POST['opis'];
mysqli_query($conn,
    "INSERT INTO proces (id_prijava, proces, rezultat, opis, datum_procesa)
     VALUES ('$id_prijava', '$proces', '$rezultat', '$opis', NOW())"
);

header("Location: pocetna.php");
?>
