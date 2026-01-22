<?php
session_start();
require __DIR__ . "/db.php";

if(!empty(filter_input(INPUT_POST, 'k_ime') && filter_input(INPUT_POST, 'k_lozinka'))){

    $k_ime = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'k_ime'));
    $k_lozinka = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'k_lozinka'));

       $upit = "SELECT * 
             FROM korisnici 
             WHERE ime_prezime = '$k_ime'
             AND lozinka = '$k_lozinka'";

    $rez = mysqli_query($conn, $upit);

    if (mysqli_num_rows($rez) == 1) {

        $row = mysqli_fetch_assoc($rez);

            $_SESSION['id_korisnik'] = $row['id_korisnik'];
            $_SESSION['tip_korisnika'] = $row['tip_korisnika'];

            if ($row['tip_korisnika'] == 'firma') {
                $id_korisnik = $row['id_korisnik'];
                $checkFirma = mysqli_query($conn, "SELECT * FROM firma WHERE id_korisnik = $id_korisnik");
                if (mysqli_num_rows($checkFirma) > 0) {
                    header("Location: firma/pocetna.php");
                } else {
                    header("Location: firma/forma.html");
                }
                exit;
            }
            else {
                header("Location: kandidat/pocetna.php");
            } 
            exit();

        } else {
            echo "Pogrešna lozinka ili korisnicko ime";
        }

    } else {
        echo "Korisnik ne postoji";
    }

?>