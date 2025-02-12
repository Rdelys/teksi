<?php
require("connecte.php");

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Requête pour récupérer les produits groupés par nom
$sql = "SELECT nom, MIN(photo1) AS photo, MIN(prix) AS prix, SUM(quantite) AS quantite 
        FROM produit 
        GROUP BY nom";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='0' style='width:100%; text-align:left; border-collapse:collapse;'>
            <tr>
                <th style='color:black; font-size:12px;'>Photo</th>
                <th style='color:black; font-size:12px;'>Nom</th>
                <th style='color:black; font-size:12px;'>Prix Minimum</th>
                <th style='color:black; font-size:12px;'>Quantité Totale</th>
                <th style='color:black; font-size:12px;'>Actions</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        $monImage = $row['photo']; 
        $LienImage2 = !empty($monImage) ? "../images/" . basename($monImage) : "../images/default.jpg"; 

        echo "<tr>
                <td><img src='$LienImage2' alt='Image produit' style='width:100px; height:auto;'></td>
                <td style='color:black; font-size:12px;'>" . htmlspecialchars($row['nom']) . "</td>
                <td align='center'>" . htmlspecialchars($row['prix']) . " usd</td>
                <td align='center'>" . htmlspecialchars($row['quantite']) . "</td>
                <td>
                    <a href='dashboard.php?page=detail&id=" . urlencode($row['nom']) . "'>Voir les variantes</a>
                </td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "Aucun produit trouvé.";
}

$conn->close();
?>
