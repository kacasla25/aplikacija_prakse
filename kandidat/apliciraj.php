<?php
session_start();
require __DIR__ . "/../db.php";

if(!isset($_SESSION['id_korisnik'])){
    header("Location: ../prijava.html");
    exit;
}

$id_korisnik = $_SESSION['id_korisnik'];

if(isset($_POST['id_oglas']) && !empty($_POST['id_oglas'])){
    $id_oglas = mysqli_real_escape_string($conn, $_POST['id_oglas']);
    $cv_link = mysqli_real_escape_string($conn, $_POST['cv_link']);

    $upit = "SELECT * FROM prijava WHERE id_korisnik = $id_korisnik AND id_oglas = $id_oglas";
    $rez = mysqli_query($conn, $upit);


    if(mysqli_num_rows($rez) > 0){
        echo '<script>alert("Već ste aplicirali za ovu praksu!")</script>';
        exit();
    }else{
        $insert = "INSERT INTO prijava (id_korisnik, id_oglas, status, cv) 
           VALUES ($id_korisnik, $id_oglas, 'Na čekanju', '$cv_path')";
           $rez_insert=mysqli_query($conn, $insert);
    }
    if($insert){
    header("Location: pocetna.php");
    exit();
    } else {
    echo "Greška prilikom apliciranja: " . mysqli_error($conn);
}
}
?>
