<?php

require("connecte.php");

// Récupérer toutes les commandes en cours
$sql1 = "SELECT c.*, p.photo1, p.nom AS produit_nom, i.nom AS client_nom, i.prenom AS client_prenom, i.telephonep AS client_phone 
        FROM commande c
        JOIN produit p ON c.idproduit = p.id
        JOIN identite i ON c.idclient = i.id 
        WHERE c.livraisonjour != '0' AND c.livraisonheur != '0'
        ORDER BY c.livraisonjour, c.livraisonheur";
        
$sql = "SELECT c.*, p.photo1, p.nom AS produit_nom, i.nom AS client_nom, i.prenom AS client_prenom, i.telephonep AS client_phone 
FROM commande c
JOIN produit p ON c.idproduit = p.id
LEFT JOIN identite i ON c.idclient = i.id
ORDER BY c.livraisonjour, c.livraisonheur"; 
        
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr>
            <th>Photo</th>
            <th>Quantité</th>
            <th>Prix Total</th>
            <th>Nom du Client</th>
            <th>Adresse de Livraison</th>
            <th>Heure et Jour de Livraison</th>
            <th>Attribution Livraison</th>
            <th>Annulation</th>
          </tr>";

    while($row = $result->fetch_assoc()) {
        // Calcul du temps restant
        $livraison_datetime = strtotime($row['livraisonjour'] . ' ' . $row['livraisonheur']);
        $current_datetime = time();
        $time_diff = $livraison_datetime - $current_datetime;
        $hours_remaining = floor($time_diff / 3600);
        
        // Déterminer la couleur selon le temps restant
        if ($hours_remaining <= 3) {
            $color = 'red';
        } elseif ($hours_remaining <= 6) {
            $color = 'yellow';
        } else {
            $color = 'green';
        }
           $etat = $row['attributionchauffeur']; 
           if($etat=='0'){
        // Affichage de la ligne dans le tableau
        echo "<tr style='background-color: $color;'>";
        echo "<td><img src='../images/" . $row['photo1'] . "' alt='Produit' width='50'></td>";
        echo "<td>" . $row['quantite'] . "</td>";
        echo "<td>" . $row['prix'] . " usd</td>";
        echo "<td>" . $row['client_nom'] . ' ' . $row['client_prenom'] . "</td>";
        echo "<td>" . $row['adresse'] . "</td>";
        echo "<td>" . $row['livraisonjour'] . " " . $row['livraisonheur'] . "</td>";
       
        echo "<td>";

        // Récupérer les chauffeurs dans la boucle pour chaque commande
        $sql2 = "SELECT id, nom, prenom FROM chauffeur WHERE etat = 'off'";
        $result2 = $conn->query($sql2);

        echo '<form action="dashboard.php" method="GET">
                <input type="hidden" name="page" value="transferer">
                <input type="hidden" value="' . $row['id'] . '" name="idcommande">
                <select name="chauffeur" id="pet-select">
                    <option value="">Sélectionnez un chauffeur</option>';
            
            
        if ($result2->num_rows > 0) {
            while($row2 = $result2->fetch_assoc()) {
                echo '<option value="' . $row2['id'] . '">' . $row2['nom'] . ' ' . $row2['prenom'] . '</option>';
            }
        } else {
            echo '<option value="">Aucun chauffeur disponible</option>';
        }

        echo '</select>
              <button type="submit" style="font-size: 12px; padding: 2px 5px;"> Go </button>
              </form>';

        echo "</td>";
        echo "<td align='center'>  ";
        ?>
        <form action="dashboard.php" method="GET">
			
			<input type="hidden" name="page" value="mycancel">
			<input type="hidden" name="page" value="transferer">
          <button type="submit" style="font-size: 12px; padding: 2px 5px;"> Cancel </button>
          
          </form>
          <br>
          <form action="dashboard.php" method="GET">
			
			<input type="hidden" name="page" value="mycancel">
			<input type="hidden" name="page" value="transferer">
          <button type="submit" style="font-size: 12px; padding: 2px 5px;"> Decaller </button>
          
          </form>
        
        <?php
        echo "</td>"; 
        
        echo "</tr>";
	          }
    }
    echo "</table>";
} else {
    echo "Aucune commande en cours.";
}

$conn->close();
?>

