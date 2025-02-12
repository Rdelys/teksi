<?php
require('connecte.php'); // Assurez-vous que le fichier de connexion est inclus

// Vérifiez si le paramètre 'q' est passé en GET
if (isset($_GET['q']) && !empty($_GET['q'])) {
    $searchQuery = $conn->real_escape_string($_GET['q']); // Échapper la valeur pour éviter les injections SQL

    // Requête SQL pour récupérer les produits similaires
    $sql = "SELECT nomProduit FROM mesproduits WHERE nomProduit LIKE ? LIMIT 10"; // Limite à 10 résultats
    $stmt = $conn->prepare($sql);
    $searchPattern = "%" . $searchQuery . "%";
    $stmt->bind_param("s", $searchPattern);
    
    // Exécutez la requête
    $stmt->execute();
    $result = $stmt->get_result();
    
    $suggestions = [];
    
    // Récupérer les résultats
    while ($row = $result->fetch_assoc()) {
        $suggestions[] = $row['nomProduit'];
    }
    
    // Retourner les résultats sous forme de JSON
    echo json_encode($suggestions);
    
    // Fermer la connexion
    $stmt->close();
    $conn->close();
}
?>
