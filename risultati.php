<?php
session_start();
if (isset($_GET['reset'])) {
    session_unset();
    session_destroy();
    header("Location: risultati.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = $_POST["date"];
    $voto = intval($_POST["rating"]);
    if (!isset($_SESSION["num_invio"])) {
        $_SESSION["num_invio"] = 0;
        $_SESSION["voti"] = [];
        $_SESSION["ultima_data"] = "";
    }
    $_SESSION["num_invio"]++;
    $_SESSION["voti"][] = $voto;
    $_SESSION["ultima_data"] = $data;
}
$num_invio = $_SESSION["num_invio"] ?? 0;
$voti = $_SESSION["voti"] ?? [];
$ultima_data = $_SESSION["ultima_data"] ?? "";
$media_voti = $num_invio > 0 ? array_sum($voti) / $num_invio : 0;
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Risultati delle Recensioni</title>
</head>
<body>
    <h1>Risultati delle Recensioni</h1>
    <table border="1">
        <tr>
            <th>Numero di invii</th>
            <th>Ultima data inviata</th>
        </tr>
        <tr>
            <td><?php echo $num_invio; ?></td>
            <td><?php echo htmlspecialchars($ultima_data); ?></td>
        </tr>
    </table>
    <h2>Voti delle recensioni:</h2>
    <ul>
        <?php foreach ($voti as $voto): ?>
            <li><?php echo htmlspecialchars($voto); ?></li>
        <?php endforeach; ?>
    </ul>
    <h3>Media dei voti: <?php echo number_format($media_voti, 2); ?></h3>
    <p><a href="presentazione.html">Torna alla pagina di inserimento</a></p>
    <p><a href="risultati.php?reset=true">Resetta i dati</a></p>
</body>
</html>