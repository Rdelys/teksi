<?php
$idchauffeur = "4";

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

// Définir la locale en français pour la date
setlocale(LC_TIME, 'fr_FR.UTF-8');
$dateDuJour = strftime('%A %d %B %Y'); // Format "Lundi 13 Janvier 2025"

// Débogage
// echo "Date du jour : $dateDuJour<br>";
// echo "ID Chauffeur : $idchauffeur<br>";

// Requête SQL pour récupérer les commandes du jour attribuées au chauffeur
$sql = "SELECT id,adresse, livraisonjour, livraisonheur, idproduit, prix, nom 
        FROM commande 
        WHERE attributionchauffeur = ? 
          AND livraisonjour = ? 
        ORDER BY STR_TO_DATE(livraisonheur, '%H:%i') ASC";

// Préparation de la requête
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Erreur de préparation de la requête : " . $conn->error);
}

$stmt->bind_param("is", $idchauffeur, $dateDuJour);

// Exécution de la requête
if ($stmt->execute()) {
  //  echo "Requête exécutée avec succès.<br>";
} else {
    die("Erreur lors de l'exécution de la requête : " . $stmt->error);
}

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commandes du Jour</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        }
        .logo {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            height: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        select {
            width: 100%;
            padding: 5px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        @media (max-width: 600px) {
            th, td {
                padding: 4px;
                font-size: 14px;
            }
            select {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="../images/logo.png" alt="Logo" class="logo">

        <?php
        // Affichage du tableau des commandes
        echo '<table>';
        echo '<tr>  
                <th>Adresse</th>
                <th>Jour de livraison</th>
                <th>Heure de livraison</th>
                <th>ID Produit</th>
                <th>Prix</th>
                <th> Detail</th>
                <th>Statut</th>
              </tr>';

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
				
				
				$MyId = $row['id'];
				$IdProduit = $row['idproduit'];
				
				print("MyId  $MyId "); 
				
                echo '<tr>  
                        <td>' . htmlspecialchars($row['adresse']) . '</td>
                        <td>' . htmlspecialchars($row['livraisonjour']) . '</td>
                        <td>' . htmlspecialchars($row['livraisonheur']) . '</td>
                        <td>' . htmlspecialchars($row['idproduit']) . '</td>
                        <td>' . htmlspecialchars($row['prix']) . '</td>
                         
                          
                           <td><a href="mondetail.php?id=' . htmlspecialchars($MyId) . '&idproduit=' . htmlspecialchars($IdProduit) . '">voir</a></td>
                          
                        <td>
                        <form id="statusForm">
                        
                            <select name="chauffeur" id="pet-select"   onchange="redirectToPage(this)" >
                                <option value="0" selected >Choisir</option>
                                <option value="1">Livré</option>
                                <option value="2">Refusé le produit</option>
                                <option value="3">Ne répond pas</option>
                                <option value="4">Reporté autre jour</option>
                                <option value="5">Annulé le rendez-vous</option>
                            </select>
                            <input type="hidden" id="orderId" value="12345">
							<input type="hidden" id="userId" value="67890">
						</form>
                        </td>
                      </tr>';
            }
        } else {
            echo '<tr><td colspan="7">Aucune commande trouvée pour aujourd\'hui.</td></tr>';
        }

        echo '</table>';

        // Fermeture de la connexion
        $stmt->close();
        $conn->close();
        ?>
    </div>
    
    <script>
function redirectToPage(select) {
    let value = select.value;
    if (value !== "0") { // Vérifier que l'utilisateur ne choisit pas "Choisir"
        let orderId = document.getElementById("orderId").value;
        let userId = document.getElementById("userId").value;
        
        // Construire l'URL avec les paramètres
        let url = "index2.php?status=" + value + "&orderId=" + orderId + "&userId=" + userId;

        // Redirection vers index2.php avec les paramètres
        window.location.href = url;
    }
}
</script>
    
</body>
</html>
