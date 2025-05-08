<?php
// register.php

// Connessione al database
$dsn = 'mysql:host=localhost;dbname=club_giochi;charset=utf8mb4';
$username = 'root';
$password = '';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $db = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die("Connessione al database fallita: " . $e->getMessage());
}

// Funzione per registrare un nuovo socio
function registraSocio($db, $nome, $email, $ruolo) {
    $query = "INSERT INTO soci (nome, email, ruolo, data_iscrizione) VALUES (:name, :email, :role, NOW())";
    $stmt = $db->prepare($query);
    $stmt->execute([
        ':name' => $nome,
        ':email' => $email,
        ':role' => $ruolo,
    ]);
    return $db->lastInsertId();
}

// Funzione per registrare un nuovo gioco
function registraGioco($db, $titolo, $dataAcquisto, $idDonatore = null) {
}
   