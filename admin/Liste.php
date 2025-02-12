<?php
// print(" Liste "); 

require("connecte.php");


// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Requête pour récupérer les produits actifs
$sql = "SELECT id, photo1, prix, quantite, description FROM produit ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
   
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
        if ($monImage !== null && $monImage !== '') {
            $LienImage = basename($monImage); 
            $LienImage2 = "../images/" . $LienImage;
        } else {
            $LienImage2 = "../images/default.jpg"; // Image par défaut si aucune image n'est disponible
        }
 
         
         
		// print("monImage LienImage2   $LienImage2 <br>  "); 
		
        echo "<tr>
                <td><img src='" . $LienImage2 . "' alt='Image produit' style='width:100px; height:auto;'></td>
                <td align='center'>" . htmlspecialchars($row['prix']) . " usd</td>
                <td align='center'>" . htmlspecialchars($row['quantite']) . "</td>
                
                <td style='color:black; font-size:10px;'>" . htmlspecialchars($row['description']) . "</td>

                
                <td style='color:black; font-size:10px;' >
                
                
                <a href='dashboard.php?page=detail2&id=" . htmlspecialchars($row['id']) . "'> Modifier Quantite </a>
                <br>
                <br>
                <a href='dashboard.php?page=detail&id=" . htmlspecialchars($row['id']) . "'>En savoir plus</a>
                
                
                </td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "Aucun produit trouvé.";
}

// Fermer la connexion
$conn->close();

?>
