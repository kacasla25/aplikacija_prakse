<?php
session_start();
require __DIR__ . "/../db.php";

if (!isset($_SESSION['id_korisnik'])) {
    header("Location: ../prijava.html");
    exit;
}

$id = $_SESSION['id_korisnik'];

$upit = "SELECT * FROM firma WHERE id_korisnik = $id";
$rez = mysqli_query($conn, $upit);

while($row = mysqli_fetch_array($rez)){
    $ime_firme = $row['ime_firme'];
    $maticni_broj = $row['maticni_broj'];
    $br_oglasa = $row['br_preostalih_oglasa'];
}
$upit2 = "SELECT * FROM oglasi 
          WHERE maticni_broj = '$maticni_broj'
          ORDER BY datum_objave DESC";

$rez2 = mysqli_query($conn, $upit2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="../css/style-fpocetna.css" />
</head>

<body>
    
<h2>Dobrodošli, <?php echo $ime_firme; ?></h2>

<hr>

<h3>Status paketa</h3>
<?php
if($br_oglasa > 0){
    print "<p style='color:green'>Imate aktivan paket</p>";
    print "<p>Preostali oglasi: $br_oglasa</p>";
}
else{
    print "<p style='color:red'>Nemate aktivan paket</p>";
    print "<a href='paketi.php'>Kupi paket</a>";
}

?>
<hr>
<h3>Moji oglasi</h3>
<a href="dodaj_oglas.php">+ Dodaj novi oglas</a>

<?php 
if(mysqli_num_rows($rez2) > 0){
    print  "<table border='1'>
        <tr>
            <th>Naziv</th>
            <th>Opis</th>
            <th>Lokacija</th>
            <th>Model rada</th>
            <th>Datum isteka</th>
            <th>Akcija</th>
        </tr>";

        while($oglas = mysqli_fetch_assoc($rez2)){
      print  "<tr>
            <td>{$oglas['naziv']}</td>
            <td>{$oglas['opis']}</td>
           <td>{$oglas['lokacija']}</td>
            <td>{$oglas['model_rada']}</td>
           <td>{$oglas['datum_isteka']}</td>
            <td>
  <form action='prijave_oglasa.php' method='POST'>
    <input type='hidden' name='id_oglas' value='{$oglas['id_oglas']}'>
    <button type='submit'style='background:none;border:none;color:black;cursor:pointer;padding:0;font-size:inherit;'>Prijave</button>
  </form>
  <br>
  <a href='izmeni_oglas.php?id={$oglas['id_oglas']}'>Izmeni</a> |
  <a href='obrisi_oglas.php?id={$oglas['id_oglas']}'>Obriši</a>
            </td>
        </tr>";
        }
        print "</table>";
}
    else{
    print "<p>Nemate nijedan oglas.</p>";
    }
    ?>


<hr>

<a href="../prijava.html">Logout</a>
</body>
</html>