<?php
session_start();
require __DIR__ . "/../db.php";

if(!isset($_SESSION['id_korisnik'])){
    header("Location: ../prijava.html");
    exit;
}

$id_firma = $_SESSION['id_korisnik'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_oglas'])) {
    $id_oglas = mysqli_real_escape_string($conn, $_POST['id_oglas']);
} else {
    echo "Neispravan oglas!";
    exit;
}


$upit_oglas = "SELECT * FROM oglasi WHERE id_oglas = $id_oglas AND maticni_broj = 
    (SELECT maticni_broj FROM firma WHERE id_korisnik = $id_firma)";
$rez_oglas = mysqli_query($conn, $upit_oglas);
if(mysqli_num_rows($rez_oglas) == 0){
    echo "Oglas ne postoji ili ne pripada vašoj firmi!";
    exit;
}
$oglas = mysqli_fetch_assoc($rez_oglas);

$upit_prijave = "SELECT p.*, k.ime_prezime
                FROM prijava p
                JOIN korisnici k ON p.id_korisnik = k.id_korisnik
                WHERE p.id_oglas = $id_oglas
                ORDER BY p.datum_prijave DESC";
$rez_prijave = mysqli_query($conn, $upit_prijave);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="../css/style-fpocetna.css">
</head>
<body>

<h2>Prijave za oglase</h2>
<a href="pocetna.php">Nazad</a>
<hr>

<?php if(mysqli_num_rows($rez_prijave) > 0): ?>
<table border="1">
    <tr>
        <th>Kandidat</th>
        <th>Status</th>
        <th>Datum prijave</th>
        <th>CV</th>
        <th>Procesi</th>
    </tr>
    <?php while($prijava = mysqli_fetch_assoc($rez_prijave)): ?>
        <?php $id_prijava = $prijava['id_prijava']; ?>
    <tr>
        <td><?php echo $prijava['ime_prezime']; ?></td>
        <td><?php echo $prijava['status']; ?></td>
        <td><?php echo $prijava['datum_prijave']; ?></td>
        <td>
            <?php if(!empty($prijava['cv'])): ?>
                <a href="<?php echo $prijava['cv']; ?>" target="_blank">Pregledaj CV</a>
            <?php else: ?>
                -
            <?php endif; ?>
        </td>
        <td>
<form action="dodaj_proces.php" method="POST">
    <input type="hidden" name="id_prijava" value="<?php echo $id_prijava; ?>">

    <select name="proces" required>
        <option value="">Proces</option>
        <option value="HR intervju">HR intervju</option>
        <option value="Tehnički intervju">Tehnički intervju</option>
        <option value="Finalni razgovor">Finalni razgovor</option>
    </select>

    <select name="rezultat">
        <option value="U toku">U toku</option>
        <option value="Prošao">Prošao</option>
        <option value="Nije prošao">Nije prošao</option>
    </select>
<br>
    <textarea name="opis" placeholder="Dodajte opis..." rows="2" cols="30"></textarea>
    <br>
    <button type="submit">Dodaj</button>
</form>
</td>
    </tr>
    <?php endwhile; ?>
</table>
<?php else: ?>
<p>Nema prijava za ovaj oglas.</p>
<?php endif; ?>

</body>
</html>
