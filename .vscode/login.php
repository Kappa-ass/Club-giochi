<?php
session_start();
require_once '../config/database.php'; // Assicurati di configurare il file per la connessione al DB

// Controlla se il form è stato inviato
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Verifica che i campi non siano vuoti
    if (!empty($username) && !empty($password)) {
        // Prepara la query per verificare l'utente
        $query = "SELECT id, username, password, role FROM users WHERE username = :username";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica se l'utente esiste e la password è corretta
        if ($user && password_verify($password, $user['password'])) {
            // Imposta i dati dell'utente nella sessione
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Reindirizza in base al ruolo
            if ($user['role'] === 'Curatore') {
                header('Location: admin_dashboard.php');
            } else {
                header('Location: user_dashboard.php');
            }
            exit;
        } else {
            $error = "Credenziali non valide.";
        }
    } else {
        $error = "Per favore, compila tutti i campi.";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Club Giochi</title>
</head>
<body>
    <h1>Login</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Login</button>
    </form>
</body>
</html>