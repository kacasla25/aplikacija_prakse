<?php
session_start();
require __DIR__ . "/../db.php";

if (!isset($_SESSION['id_korisnik']) || $_SESSION['tip_korisnika'] != 'firma') {
    header("Location: ../prijava.html");
    exit;
}

$id_firme = $_SESSION['id_korisnik'];

$upit = "SELECT * FROM paketi";
$rez = mysqli_query($conn, $upit);
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>Paketi</title>
    <link rel="stylesheet" href="../css/style-paketi.css" />
</head>
<body>

<h2>Izaberite paket</h2>

<?php
if(mysqli_num_rows($rez) > 0){
    while($paket = mysqli_fetch_assoc($rez)){
        print "<div>";
        print "<h3>{$paket['naziv']}</h3>";
        print "<p>{$paket['opis']}</p>";
        print "<p>Oglasi: {$paket['broj_oglasa']}, VIP: {$paket['broj_vip']}</p>";
        print "<p>Cena: {$paket['cena']} €</p>";
        print "<form action='kupovina.php' method='POST'>";
        print "<input type='hidden' name='id_paketa' value='{$paket['id_paket']}'>";
        print "<button type='submit'>Kupi paket</button>";
        print "</form>";
        print "</div><hr>";
    }
} else {
    print "<p>Nema dostupnih paketa.</p>";
}?>

</body>
</html>
