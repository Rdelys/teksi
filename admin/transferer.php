<?php
print(" trabsferer.php"); 

// Paramètres de connexion
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

// Vérifier si les paramètres sont passés par GET
if (isset($_GET['idcommande']) && isset($_GET['chauffeur'])) {
    // Récupérer les paramètres GET
    $idcommande = intval($_GET['idcommande']);  // Assurer la sécurité en convertissant en entier
    $chauffeur = intval($_GET['chauffeur']);    // Assurer la sécurité en convertissant en entier

    // Mettre à jour la table commande avec le chauffeur attribué
    $sql = "UPDATE commande SET attributionchauffeur = ? WHERE id = ?";

    // Préparer et exécuter la requête
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ii", $chauffeur, $idcommande);
        $stmt->execute();

        // Vérifier si la mise à jour a été effectuée
        if ($stmt->affected_rows > 0) {
            // Si la mise à jour est réussie, rediriger vers la page dashboard
            header("Location: dashboard.php?page=commande");
            exit;  // Assurez-vous que le script s'arrête après la redirection
        } else {
            echo "Aucune mise à jour effectuée.";
        }

        // Fermer la requête
        $stmt->close();
    } else {
        echo "Erreur de requête : " . $conn->error;
    }
} else {
    echo "Paramètres manquants.";
}

// Fermer la connexion
$conn->close();
?>


