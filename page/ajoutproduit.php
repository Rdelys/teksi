<br> <br>
<br> <br>
<br> 
<?php
require("connecte.php"); 
$monprix = $_GET["monprix"];
$prod = $_GET["prod"];
$quantite = $_GET["quantite"];

echo'<h1 style="font-size: 20px; color: #ff6600; text-align: center; font-weight: bold; margin: 0;">
                  Votre Commande : Caddy
                </h1>';

  $sql2 = "SELECT id, nom, prix, photo1 FROM produit WHERE id IN ($prod)";
        $result2 = $conn->query($sql2);

        // Vérifier si des produits sont trouvés
        if ($result2->num_rows > 0) {
            // Début du tableau HTML
            echo '<table border="2" width="60%"  bgcolor="white">
                    <tr bgcolor="gray">
                      
                        <td>Nom</td>
                        <td>Image</td>
                        <td>Quantité</td>
                        <td>Prix</td>
                    </tr>  ';

            // Afficher chaque produit
            while ($row2 = $result2->fetch_assoc()) {
                $Zid = $row2['id'];
                $Znom = $row2['nom'];
                $Zphoto = $row2['photo1'];
                
			}
$ztotal = $monprix*$quantite ; 
$Laphoto = '<img src="images/' . $Zphoto . '" width="50" height="50" style="border-radius: 70%;">';
		
	print("<tr> <br> <td>    $Znom </td> 	<td>  $Laphoto	</td>  <td> $quantite </td>  <td> $ztotal </td> </tr> </table> <br> "); 
	
}

?>
