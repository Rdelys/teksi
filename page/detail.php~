<?php
print(" <br> <br>*************** ");

print(" page detail "); 


require("connecte.php"); 

print(" <br> id $id ");
// Requête pour récupérer les données de la table "produit"
$sql = "SELECT * FROM produit where id ='$id' ";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
    // Accéder aux colonnes spécifiques de la ligne actuelle
    $nom = $row['nom'];
    $description = $row['description'];
    $prix = $row['prix'];
    $photo1 = $row['photo1'];
    $photo2 = $row['photo2'];
    $photo3 = $row['photo2'];
    $video1 = $row['video1'];
    $video2 = $row['video2'];
    
    }
    
$hauteur_voulue="300"; 

?>

<table border="0" width="100%">
<tr>
<td align="center">  
<?php

echo '
<img src="images/' . $photo1 . '" alt="' . $nom . '" style="height: ' . $hauteur_voulue . 'px;">
';

?>

 </td>

</tr>

<tr>
<td>  
<font size="2">
<center>

TOZO LIVRER EN EXPRESS PARTOUT A KINSHASA <br>
</center>

</font>


<?php
print(" nom  $nom"); 


?>

 </td>

</tr>




</table>