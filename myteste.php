<?php
$servername = "51.210.150.164";  // Remplace par l'IP de ton serveur
$username = "admin";  // L'utilisateur MariaDB
$password = "admin123";  // Le mot de passe
$dbname = "3cx_integration";  // Le nom de la base de données

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}
echo "Connexion réussie ee!";


// Requête SQL pour insérer des données dans la table 'call_logs'
$sql = "INSERT INTO call_logs (caller, callee, start_time, duration, status) 
        VALUES ('1234567890', '0987654321', '2025-02-05 14:00:00', 300, 'completed')";

// Exécuter la requête d'insertion
if ($conn->query($sql) === TRUE) {
    echo "Nouveau record inséré avec succès !<br>";
} else {
    echo "Erreur : " . $sql . "<br>" . $conn->error;
}

// Vérifier si l'insertion a eu lieu
$check_sql = "SELECT * FROM call_logs ORDER BY id DESC LIMIT 1"; // Récupérer la dernière ligne insérée
$result = $conn->query($check_sql);

// Vérifier s'il y a des résultats
if ($result->num_rows > 0) {
    // Afficher les données de la dernière ligne insérée
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"] . " - Caller: " . $row["caller"] . " - Callee: " . $row["callee"] . " - Start Time: " . $row["start_time"] . " - Duration: " . $row["duration"] . " - Status: " . $row["status"] . " - Created At: " . $row["created_at"] . "<br>";
    }
} else {
    echo "Aucune donnée trouvée dans la table.";
}


// Fermer la connexion
$conn->close();
?>
