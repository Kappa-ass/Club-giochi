<?php
// dashboard.php

session_start();

// Check if the user is logged in and has the role of "Curatore"
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'Curatore') {
    echo "Accesso negato. Solo i Curatori possono accedere a questa pagina.";
    exit;
}

// Database connection
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

// Fetch all games from the database
$query = "SELECT * FROM giochi";
$stmt = $pdo->query($query);
$games = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Giochi</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Dashboard Giochi</h1>
    <p>Benvenuto, Curatore! Qui puoi gestire i giochi del Club.</p>

    <h2>Elenco Giochi</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Data Acquisto/Donazione</th>
                <th>Donato da</th>
                <th>Copie Disponibili</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($games as $game): ?>
                <tr>
                    <td><?= htmlspecialchars($game['id']) ?></td>
                    <td><?= htmlspecialchars($game['nome']) ?></td>
                    <td><?= htmlspecialchars($game['data_acquisto_donazione']) ?></td>
                    <td><?= htmlspecialchars($game['donato_da'] ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($game['copie_disponibili']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Aggiungi Nuovo Gioco</h2>
    <form action="aggiungi_gioco.php" method="post">
        <label for="nome">Nome del Gioco:</label>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="data_acquisto_donazione">Data Acquisto/Donazione:</label>
        <input type="date" id="data_acquisto_donazione" name="data_acquisto_donazione" required><br><br>

        <label for="donato_da">Donato da (ID Socio, opzionale):</label>
        <input type="text" id="donato_da" name="donato_da"><br><br>

        <label for="copie_disponibili">Numero di Copie:</label>
        <input type="number" id="copie_disponibili" name="copie_disponibili" min="1" max="3" required><br><br>

        <button type="submit">Aggiungi Gioco</button>
    </form>
</body>
</html>