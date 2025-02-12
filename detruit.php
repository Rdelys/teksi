<?php
// Vérifie si le cookie existe
if (isset($_COOKIE['caddy'])) {
    // Détruit le cookie en définissant une date d'expiration passée
    setcookie('caddy', '', time() - 3600, '/');
}

// Redirige vers index.php
header('Location: index.php');
exit();
?>
