<?php
try {
    // Connessione al database
    $dsn = 'mysql:host=localhost;dbname=club_giochi;charset=utf8mb4';
    $username = 'root';
    $password = '';
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    $pdo = new PDO($dsn, $username, $password, $options);

    // Creazione delle tabelle
    $queries = [
        // Tabella Soci
        "CREATE TABLE IF NOT EXISTS soci (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(100) NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            grado ENUM('Giocatore Regolare', 'Giocatore Donatore', 'Curatore') NOT NULL,
            ultimo_versamento DATE,
            anni_senza_versamento INT DEFAULT 0
        )",

        // Tabella Giochi
        "CREATE TABLE IF NOT EXISTS giochi (
            id INT AUTO_INCREMENT PRIMARY KEY,
            titolo VARCHAR(255) NOT NULL,
            copie_disponibili INT DEFAULT 0,
            data_acquisto DATE,
            donato_da INT,
            FOREIGN KEY (donato_da) REFERENCES soci(id) ON DELETE SET NULL
        )",

        // Tabella Prestiti
        "CREATE TABLE IF NOT EXISTS prestiti (
            id INT AUTO_INCREMENT PRIMARY KEY,
            socio_id INT NOT NULL,
            gioco_id INT NOT NULL,
            data_prestito DATE NOT NULL,
            data_restituzione DATE,
            FOREIGN KEY (socio_id) REFERENCES soci(id) ON DELETE CASCADE,
            FOREIGN KEY (gioco_id) REFERENCES giochi(id) ON DELETE CASCADE
        )",

        // Tabella Incontri
        "CREATE TABLE IF NOT EXISTS incontri (
            id INT AUTO_INCREMENT PRIMARY KEY,
            data_incontro DATE NOT NULL
        )",

        // Tabella Partecipanti
        "CREATE TABLE IF NOT EXISTS partecipanti (
            incontro_id INT NOT NULL,
            socio_id INT NOT NULL,
            PRIMARY KEY (incontro_id, socio_id),
            FOREIGN KEY (incontro_id) REFERENCES incontri(id) ON DELETE CASCADE,
            FOREIGN KEY (socio_id) REFERENCES soci(id) ON DELETE CASCADE
        )",

        // Tabella Vincitori
        "CREATE TABLE IF NOT EXISTS vincitori (
            incontro_id INT NOT NULL,
            socio_id INT NOT NULL,
            PRIMARY KEY (incontro_id, socio_id),
            FOREIGN KEY (incontro_id) REFERENCES incontri(id) ON DELETE CASCADE,
            FOREIGN KEY (socio_id) REFERENCES soci(id) ON DELETE CASCADE
        )"
    ];

    foreach ($queries as $query) {
        $pdo->exec($query);
    }

    echo "Database e tabelle creati con successo!";
} catch (PDOException $e) {
    echo "Errore: " . $e->getMessage();
}