<?php
require("connecte.php"); 

$id = intval($_GET['id']); // Sécuriser l'ID
$sql = "SELECT * FROM produit WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<h1>" . htmlspecialchars($row['nom']) . "</h1>";

    // Vérifier et afficher les photos si elles existent
    if (!empty($row['photo1'])) {
        echo "<img src='../images/" . htmlspecialchars($row['photo1']) . "' style='width:200px; height:auto;'><br>";
    }
    if (!empty($row['photo2'])) {
        echo "<img src='../images/" . htmlspecialchars($row['photo2']) . "' style='width:200px; height:auto;'><br>";
    }
    if (!empty($row['photo3'])) {
        echo "<img src='../images/" . htmlspecialchars($row['photo3']) . "' style='width:200px; height:auto;'><br>";
    }

    // Afficher les autres informations
    echo "<p><strong>Prix :</strong> " . htmlspecialchars($row['prix']) . "</p>";
    echo "<p><strong>Quantité :</strong> " . htmlspecialchars($row['quantite']) . "</p>";
    echo "<p><strong>Description :</strong> " . htmlspecialchars($row['description']) . "</p>";
} else {
    echo "Produit non trouvé.";
}

$conn->close();
?>
