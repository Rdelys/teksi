<?php
$servername = "146.59.227.113";
$username = "TshivTony";
$password = "TsTon2023nc";
$dbname = "teksi";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $chauffeur_id = $_GET['id'];
    
    // Requête pour récupérer les informations du chauffeur
    $sql = "SELECT * FROM chauffeur WHERE id = $chauffeur_id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // Récupérer les données du chauffeur
        $chauffeur = $result->fetch_assoc();
        echo "<h2>Détails du Chauffeur</h2>";
        echo "<p><strong>Nom:</strong> " . $chauffeur['nom'] . "</p>";
        echo "<p><strong>Prénom:</strong> " . $chauffeur['prenom'] . "</p>";
        echo "<p><strong>Téléphone:</strong> " . $chauffeur['telephone'] . "</p>";
        echo "<p><strong>Adresse:</strong> " . $chauffeur['adresse'] . "</p>";
        echo "<p><strong>Date de naissance:</strong> " . $chauffeur['datenaissance'] . "</p>";
        echo "<a href='modifier_chauffeur.php?id=" . $chauffeur['id'] . "'>Modifier les informations</a>";
    } else {
        echo "Chauffeur introuvable.";
    }
} else {
    echo "Aucun chauffeur spécifié.";
}

$conn->close();
?>
