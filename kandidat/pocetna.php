<?php
session_start();
require __DIR__ . "/../db.php";

if (!isset($_SESSION['id_korisnik'])) {
    header("Location: ../prijava.html");
    exit;
}

$id_korisnik = $_SESSION['id_korisnik'];

$upit = "SELECT * FROM korisnici WHERE id_korisnik = $id_korisnik";
$rez = mysqli_query($conn, $upit);

$row_kandidat = mysqli_fetch_array($rez);
$ime_prezime = $row_kandidat['ime_prezime'];

$today = date('Y-m-d');
$upit_oglasi = "SELECT o.*,f.ime_firme FROM oglasi o inner join firma f on o.maticni_broj=f.maticni_broj WHERE datum_isteka >= '$today' ORDER BY datum_objave DESC";
$rez_oglasi = mysqli_query($conn, $upit_oglasi);

$upit_prijave = "SELECT p.*, o.naziv naziv_oglasa
    FROM prijava p
    INNER JOIN oglasi o
    ON p.id_oglas = o.id_oglas
    WHERE p.id_korisnik = $id_korisnik
    ORDER BY p.datum_prijave DESC
";

$rez_prijave = mysqli_query($conn, $upit_prijave);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Početna kandidata</title>
  <link rel="stylesheet" href="../css/style-fpocetna.css" />
</head>
<body>
  <h1>Dobrodošli, <?php echo $ime_prezime; ?></h1>

  <hr>

  <h2>Aktivni oglasi</h2>
<?php
 if(mysqli_num_rows($rez_oglasi) > 0){

    print "<table border='1' cellpadding='5'>
            <tr>
                <th>Naziv</th>
                <th>Lokacija</th>
                <th>Model rada</th>
                <th>Opis</th>
                <th>Firma</th>
                <th>Datum isteka</th>
                <th></th>
            </tr>";

    while($oglas = mysqli_fetch_array($rez_oglasi)){

        $upit_provera = "
            SELECT * FROM prijava 
            WHERE id_korisnik = $id_korisnik 
            AND id_oglas = {$oglas['id_oglas']}
        ";
        $rez_provera = mysqli_query($conn, $upit_provera);

        print "<tr>
                <td>{$oglas['naziv']}</td>
                <td>{$oglas['lokacija']}</td>
                <td>{$oglas['model_rada']}</td>
                <td>{$oglas['opis']}</td>
                <td>{$oglas['ime_firme']}</td>
                <td>{$oglas['datum_isteka']}</td>
                <td>";

        if(mysqli_num_rows($rez_provera) == 0){

            print "
                <form action='apliciraj.php' method='POST'>
                    <input type='hidden' name='id_oglas' value='{$oglas['id_oglas']}'>
                    <input type='text' name='cv_link' placeholder='Link do CV-a' required>
                    <br><br>
                    <button type='submit'>Apliciraj</button>
                </form>
            ";
        }
        else{
            print "Već aplicirano";
        }

        print "</td></tr>";
    }

    print "</table>";
}
else{
    print "<p>Nema aktivnih oglasa.</p>";
}

print "<hr>";
?>

  <h2>Moje prijave</h2>
<?php
  $upit_prijave = "SELECT p.*, o.naziv 
    FROM prijava p
    INNER JOIN oglasi o ON p.id_oglas = o.id_oglas
    WHERE p.id_korisnik = $id_korisnik
    ORDER BY p.datum_prijave DESC
";

$rez_prijave = mysqli_query($conn, $upit_prijave);

if(mysqli_num_rows($rez_prijave) > 0){

    print "<table border='1' cellpadding='5'>
            <tr>
                <th>Naziv oglasa</th>
                <th>Datum prijave</th>
                <th>Proces</th>
            </tr>";

    while($prijava = mysqli_fetch_array($rez_prijave)){

        print "<tr>
                <td>{$prijava['naziv']}</td>
                <td>{$prijava['datum_prijave']}</td>";

        print "</td><td>";

        $upit_proces = "
            SELECT * FROM proces 
            WHERE id_prijava = {$prijava['id_prijava']}
            ORDER BY datum_procesa ASC
        ";
        $rez_proces = mysqli_query($conn, $upit_proces);

        if(mysqli_num_rows($rez_proces) > 0){
            while($proces = mysqli_fetch_array($rez_proces)){
           echo $proces['proces'] . " - " . $proces['datum_procesa'] . " - " . $proces['rezultat'] . "<br>";
        }}
        else{
            print "Nema procesa";
        }

        print "</td></tr>";
    }

    print "</table>";
}
else{
    print "<p>Nemate nijednu prijavu.</p>";
}
?>
  <hr>
  <a href="../prijava.html">Logout</a>
</body>
</html>