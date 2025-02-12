<?php

$Myquantite="0"; 
$total="0"; 

// print("<br> <br> <br> <br><br> <br> <br> ");

// print(" <br> <br><br> <br> <br> ");

// print(" Votre Commande <br><br>");
  /*  echo'<h1 style="font-size: 24px; color: #ff6600; text-align: center; font-weight: bold; margin: 0;">
                  Votre Commande : Caddy
                </h1>';
     */
                
// Connexion à la base de données
/*$servername = "146.59.227.113";
$username = "TshivTony";
$password = "TsTon2023nc";
$dbname = "teksi";*/

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "teksi";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Vérifier si le cookie 'caddy' existe
if (isset($_COOKIE['caddy'])) {
    // Décoder les données du cookie 'caddy'
    $cookieData = json_decode($_COOKIE['caddy'], true);

    // Créer un tableau pour stocker les IDs des produits et les quantités associées
    $productQuantities = [];

    // Extraire les IDs des produits et les quantités dans le cookie
    foreach ($cookieData as $product) {
        $productQuantities[$product['idproduit']] = $product['quantite']; // Associer l'ID à sa quantité
    }

    // Créer un tableau pour les IDs de produits
    $productIds = array_keys($productQuantities); // Récupérer les IDs des produits avec quantité

    // Vérifier si des IDs ont été récupérés
    if (count($productIds) > 0) {
        // Convertir les IDs en une chaîne pour la requête SQL (en évitant les risques d'injection SQL)
        $ids = implode(",", array_map('intval', $productIds));

        // Requête SQL pour récupérer les produits dont les ID sont dans le cookie
        $sql = "SELECT id, nom, prix, photo1 FROM produit WHERE id IN ($ids)";
        $result = $conn->query($sql);

        // Vérifier si des produits sont trouvés
        if ($result->num_rows > 0) {
            // Début du tableau HTML
            echo '<table border="0" width="60%" bgcolor="white">
                    <tr>
                      
                        <td>Nom</td>
                        <td>Image</td>
                        <td>Quantité</td>
                        <td>Prix</td>
                    </tr>';

            // Afficher chaque produit
            while ($row = $result->fetch_assoc()) {
                $productId = $row['id'];
                $quantite = isset($productQuantities[$productId]) ? $productQuantities[$productId] : 0; // Récupérer la quantité correspondante

                // Affichage des données du produit
                echo '<tr>
                        
                        <td>' . $row['nom'] . '</td>
                        <td>
                            <img src="images/' . $row['photo1'] . '" width="50" height="50" style="border-radius: 70%;">
                        </td>
                        <td>' . $quantite . '</td> <!-- Afficher la quantité spécifique au produit -->
                        <td>' . $row['prix'] . ' USD</td>
                    </tr>';
                    
               $total += $row['prix']; 
               $Myquantite += $quantite;    
            }

            // Fin du tableau HTML
            echo '</table>';
        } else {
            echo "Aucun produit trouvé pour les IDs dans le cookie.";
        }
    } else {
      //  echo "Aucun ID de produit trouvé dans le cookie.";
      $ab="1"; 
      
    }
} else {
    echo "<br>Le cookie 'caddy' n'est pas encore défini.";
}

// Fermer la connexion
$conn->close();



if ($ab !== "1") {
	
/*	
?>




<table border="0 " width="60%"   bgcolor="white">
<tr>
<td> Total </td>
<td>  </td>
<td>  </td>
<td> <?php  print("$Myquantite"); ?> </td>

<td> <?php print(" $total");   ?> USD </td>

</tr>

</table>
<?php
*/


}


?>


<br>
<center>  Faites vous livrer vos produits en cliquant </center>
<center> 
	<br>
 <a href="index-vide.php?page=commandez&prod=<?php echo $productData['id'] ?? ''; ?>&monprix=<?php echo $total; ?>" 
   style="display: inline-block; width: 200px; background-color: red; color: white; font-size: 14px; font-weight: bold; text-align: center; text-decoration: none; padding: 10px 20px; border-radius: 5px; border: 1px solid #0056b3;">
   Faites vous livrer
</a>
 </center>
 
 
 
 
 
 
<br> 
<center> 
	<br>
 <a href="detruit.php" 
   style="display: inline-block; width: 200px; background-color: green; color: white; font-size: 14px; font-weight: bold; text-align: center; text-decoration: none; padding: 10px 20px; border-radius: 5px; border: 1px solid #0056b3;">
   Videz votre Caddy
</a>
 </center>
