<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);


    $id = $_GET["id"];  
      $mapage = $_GET["page"];
      $prodid = $_GET["prod"];
      
   // print(" <br> <br> <br> <br> <br> id $id mapage $mapage prodid $prodid ");
    
    $mapage = "page/".$mapage.".php";   
    

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page avec moteur de recherche fixe</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Style pour supprimer la ligne sous le lien */
        a {
            text-decoration: none;
        }
    </style>
    
</head>
<body>


    <div class="header">
    <center>
    <?php
    $hauteur="50";
    
    ?>
    <img src="images/logo.png" alt="Produit 2" style="height: <?php echo $hauteur; ?>px;">
    <br>
    
    </center>
    
    <br>
        <input type="text" placeholder="Recherche...">
        <button>Rechercher</button>
        <br>
        <br>
     
<table border="0" align="center" width="100%">
<tr>
<td> <a href="index.php">  <font size="5" color="red">  <b>&lt;</b> </a> </font> </td>
<td>  <center> <font size="2"> TOZO LIVRER EN EXPRESS PARTOUT A KINSHASA </font> </center> </td>
</tr>
</table>      
          
    </div>


<?php
require("connecte.php");

// if ($_SERVER["REQUEST_METHOD"] == "GET") {


    $id = $_GET["prod"];  
      $mapage = $_GET["page"];
      $prodid = $_GET["prod"];
      
  //  print(" <br> <br> <br> <br> <br> id $id mapage $mapage prodid $prodid ");
    
 $mapage = "page/".$mapage.".php";
     
if (file_exists($mapage)) {
    require($mapage);
// print(" page present mapage $mapage id  $id");    
    
} else {   
   // print(" page absent mapage $mapage ");
   }    
    
/*
 }
*/
 
 
?>

    <div class="content">
        <!-- Votre contenu ici -->
        
      <br> <br> 
      
      <?php
      $hauteur_voulue="150";
      
      ?>
      
      
      
      
      
          </h1>
    </div>
</body>
</html>




