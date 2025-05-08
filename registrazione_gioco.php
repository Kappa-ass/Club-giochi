<?php
// Connessione al database
$host = 'localhost';
$dbname = 'club_giochi';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Errore di connessione al database: " . $e->getMessage());
}

// Funzione per registrare un nuovo gioco
function registraGioco($nomeGioco, $dataAcquisto, $idSocioDonatore = null) {
    global $pdo;

    // Controlla se il gioco è già presente con 3 copie
    $stmt = $pdo->prepare("SELECT COUNT(*) as copie FROM giochi WHERE nome = :nomeGioco");
    $stmt->execute(['nomeGioco' => $nomeGioco]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['copie'] >= 3) {
        return "Il gioco è già presente con 3 copie.";
    }

    // Inserisci il nuovo gioco nel database
    $stmt = $pdo->prepare("INSERT INTO giochi (nome, data_acquisto, id_socio_donatore) VALUES (:nomeGioco, :dataAcquisto, :idSocioDonatore)");
    $stmt->execute([
        'nomeGioco' => $nomeGioco,
        'dataAcquisto' => $dataAcquisto,
        'idSocioDonatore' => $idSocioDonatore
    ]);

    return "Gioco registrato con successo.";
}

// Esempio di utilizzo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomeGioco = $_POST['nome_gioco'];
    $dataAcquisto = $_POST['data_acquisto'];
    $idSocioDonatore = !empty($_POST['id_socio_donatore']) ? $_POST['id_socio_donatore'] : null;

    $messaggio = registraGioco($nomeGioco, $dataAcquisto, $idSocioDonatore);
    echo $messaggio;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione Gioco</title>
</head>
<body>
    <h1>Registrazione Nuovo Gioco</h1>
    <form method="POST" action="">
        <label for="nome_gioco">Nome del Gioco:</label>
        <input type="text" id="nome_gioco" name="nome_gioco" required><br><br>

        <label for="data_acquisto">Data di Acquisto/Donazione:</label>
        <input type="date" id="data_acquisto" name="data_acquisto" required><br><br>

        <label for="id_socio_donatore">ID Socio Donatore (opzionale):</label>
        <input type="number" id="id_socio_donatore" name="id_socio_donatore"><br><br>

        <button type="submit">Registra Gioco</button>
    </form>
</body>
</html>