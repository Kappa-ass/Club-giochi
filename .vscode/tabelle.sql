-- Tabella Soci
CREATE TABLE Soci (
    ID_Socio INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(100) NOT NULL,
    Cognome VARCHAR(100) NOT NULL,
    Data_Iscrizione DATE NOT NULL,
    Ultimo_Pagamento DATE,
    Grado ENUM('Giocatore Regolare', 'Giocatore Donatore', 'Curatore') DEFAULT 'Giocatore Regolare',
    Anni_Senza_Pagamento INT DEFAULT 0
);

-- Tabella Giochi
CREATE TABLE Giochi (
    ID_Gioco INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(100) NOT NULL,
    Data_Acquisto DATE NOT NULL,
    Donato_Da INT,
    FOREIGN KEY (Donato_Da) REFERENCES Soci(ID_Socio),
    Copie_Disponibili INT DEFAULT 3
);

-- Tabella Prestiti
CREATE TABLE Prestiti (
    ID_Prestito INT AUTO_INCREMENT PRIMARY KEY,
    ID_Socio INT NOT NULL,
    ID_Gioco INT NOT NULL,
    Data_Prestito DATE NOT NULL,
    Data_Restituzione DATE,
    FOREIGN KEY (ID_Socio) REFERENCES Soci(ID_Socio),
    FOREIGN KEY (ID_Gioco) REFERENCES Giochi(ID_Gioco)
);

-- Tabella Incontri
CREATE TABLE Incontri (
    ID_Incontro INT AUTO_INCREMENT PRIMARY KEY,
    Data_Incontro DATE NOT NULL
);

-- Tabella Partecipanti
CREATE TABLE Partecipanti (
    ID_Partecipante INT AUTO_INCREMENT PRIMARY KEY,
    ID_Incontro INT NOT NULL,
    ID_Socio INT NOT NULL,
    FOREIGN KEY (ID_Incontro) REFERENCES Incontri(ID_Incontro),
    FOREIGN KEY (ID_Socio) REFERENCES Soci(ID_Socio)
);

-- Tabella Vincitori
CREATE TABLE Vincitori (
    ID_Vincitore INT AUTO_INCREMENT PRIMARY KEY,
    ID_Incontro INT NOT NULL,
    ID_Socio INT NOT NULL,
    FOREIGN KEY (ID_Incontro) REFERENCES Incontri(ID_Incontro),
    FOREIGN KEY (ID_Socio) REFERENCES Soci(ID_Socio)
);