<?php
require "db.php";
if(!empty(filter_input(INPUT_POST, 'k_ime') && filter_input(INPUT_POST, 'k_lozinka1') && filter_input(INPUT_POST, 'k_lozinka2') && filter_input(INPUT_POST, 'k_email') && filter_input(INPUT_POST, 'k_tip'))){

    $k_ime = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'k_ime'));
    $k_lozinka1 = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'k_lozinka1'));
    $k_lozinka2 = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'k_lozinka2'));
    $k_email= mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'k_email'));
    $k_tip = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'k_tip'));

   
$upit = "SELECT * FROM korisnici WHERE ime_prezime='$k_ime'";
    $rez = mysqli_query($conn,$upit);


    if(mysqli_num_rows($rez)==0){

        $upit1 = "INSERT INTO korisnici (ime_prezime,lozinka,email,tip_korisnika) 
                  VALUES ('$k_ime','$k_lozinka1','$k_email','$k_tip')";
        $rez1 = mysqli_query($conn,$upit1);

       
        if($rez1){
            echo '<script> alert("Uspesno ste kreirali nalog") </script>';
           header("refresh:0.2, url = prijava.html");
        }
    }
   
    else{
        print "Unesite drugo ime!";
    }
}
?>
