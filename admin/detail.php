<?php
require("connecte.php");

$nomProduit = isset($_GET['id']) ? urldecode($_GET['id']) : '';

$sql = "SELECT * FROM produit WHERE nom = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nomProduit);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<h1>" . htmlspecialchars($nomProduit) . "</h1>";
    echo "<table border='1' style='width:100%; text-align:left; border-collapse:collapse;'>
            <tr>
                <th>Photo</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Description</th>
                <th>Tailles disponibles</th>
                <th>Actions</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        $LienImage = !empty($row['photo1']) ? "../images/" . basename($row['photo1']) : "../images/default.jpg";

        // Récupérer les tailles disponibles pour ce produit
        $sqlTailles = "SELECT taille, quantite FROM produit_taille WHERE produit_id = ?";
        $stmtTailles = $conn->prepare($sqlTailles);
        $stmtTailles->bind_param("i", $row['id']);
        $stmtTailles->execute();
        $resultTailles = $stmtTailles->get_result();

        // Construire l'affichage des tailles
        $taillesDisponibles = "";
        if ($resultTailles->num_rows > 0) {
            while ($rowTaille = $resultTailles->fetch_assoc()) {
                $taillesDisponibles .= htmlspecialchars($rowTaille['taille']) . " (" . htmlspecialchars($rowTaille['quantite']) . ")<br>";
            }
        } else {
            $taillesDisponibles = "Aucune taille disponible";
        }

        echo "<tr>
                <td><img src='$LienImage' alt='Image produit' style='width:100px; height:auto;'></td>
                <td>" . htmlspecialchars($row['prix']) . " usd</td>
                <td>" . htmlspecialchars($row['quantite']) . "</td>
                <td>" . htmlspecialchars($row['description']) . "</td>
                <td>" . $taillesDisponibles . "</td>
                <td>
                    <a href='dashboard.php?page=detail2&id=" . htmlspecialchars($row['id']) . "'>Modifier Quantité</a>
                </td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "Aucune variante trouvée.";
}

$conn->close();
?>
