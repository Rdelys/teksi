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

// Requête SQL pour grouper les produits par nom
$sql = "SELECT nom, 
               MIN(id) as id, 
               MIN(photo1) as photo1, 
               SUM(quantite) as quantite_totale, 
               MIN(prix) as prix, 
               GROUP_CONCAT(description SEPARATOR ', ') as descriptions
        FROM produit
        GROUP BY nom";

$result = $conn->query($sql);

echo "<table border='0' style='width:100%; text-align:left; border-collapse:collapse;'> 
        <tr>
            <th style='color:black; font-size:12px;'>Photo</th>
            <th style='color:black; font-size:12px;'>Prix</th>
            <th style='color:black; font-size:12px;'>Quantité</th>
            <th style='color:black; font-size:12px;'>Description</th>
            <th style='color:black; font-size:12px;'>Actions</th>
        </tr>";

while ($row = $result->fetch_assoc()) {
    $monImage = $row['photo1']; 
    $LienImage = basename($monImage);
    $LienImage2 = "../images/".$LienImage; 

    echo "<tr>
            <td><img src='" . $LienImage2 . "' alt='Image produit' style='width:100px; height:auto;'></td>
            <td align='center'>" . htmlspecialchars($row['prix']) . " usd</td>
            <td align='center'>" . htmlspecialchars($row['quantite_totale']) . "</td>
            <td style='color:black; font-size:10px;'>" . htmlspecialchars($row['descriptions']) . "</td>
            <td style='color:black; font-size:10px;'>
                <a href='dashboard.php?page=detail2&id=" . htmlspecialchars($row['id']) . "'> Modifier Quantité </a>
                <br><br>
                <a href='dashboard.php?page=detail&id=" . htmlspecialchars($row['id']) . "'>En savoir plus</a>
            </td>
          </tr>";
}

echo "</table>";

// Fermeture de la connexion
$conn->close();

?>
