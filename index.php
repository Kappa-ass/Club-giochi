<?php
// index.php - Pagina principale del Club Giochi

session_start();

// Funzione per verificare se l'utente è un curatore
function isCurator() {
	return isset($_SESSION['role']) && $_SESSION['role'] === 'curator';
}

// Funzione per verificare se l'utente è loggato
function isLoggedIn() {
	return isset($_SESSION['user_id']);
}

// Messaggio di benvenuto
echo "<h1>Benvenuto al Club Giochi</h1>";

// Se l'utente è loggato, mostra le opzioni
if (isLoggedIn()) {
	echo "<p>Ciao, " . htmlspecialchars($_SESSION['username']) . "!</p>";
	echo "<ul>";

	// Opzioni per tutti i soci
	echo "<li><a href='check_subscription.php'>Verifica iscrizioni annuali</a></li>";
	echo "<li><a href='donated_games.php'>Visualizza giochi donati</a></li>";
	echo "<li><a href='borrow_game.php'>Segna un gioco preso in prestito</a></li>";

	// Opzioni aggiuntive per i curatori
	if (isCurator()) {
		echo "<li><a href='register_user.php'>Registra Socio</a></li>";
		echo "<li><a href='registrazione_gioco.php'>Registra nuovo Gioco</a></li>";
		echo "<li><a href='record_meeting.php'>Registra un Incontro</a></li>";
		echo "<li><a href='return_game.php'>Segnala restituzione di un gioco</a></li>";
	}

	echo "</ul>";
	echo "<p><a href='logout.php'>Logout</a></p>";
} else {
	// Se l'utente non è loggato, mostra il link per il login
	echo "<p><a href='login.php'>Accedi</a> o <a href='register.php'>Registrati</a> per iniziare.</p>";
}
?>