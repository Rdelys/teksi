
<?php

// error_reporting(E_ALL);
// ini_set("display_errors", 1);

// Récupérer les paramètres envoyés par l'URL
$monprix = $_GET["monprix"];
$prod = $_GET["prod"];
$quantite = $_GET["quantite"];

// print("<br><br><br><br><br>");

// Créer un tableau associatif pour le nouveau produit
$newProduct = [
    "idproduit" => $prod,
    "quantite" => $quantite,
    "prix" => $monprix
];

// Vérifier si le cookie 'caddy' existe déjà
if (isset($_COOKIE['caddy'])) {
    // Décoder le cookie 'caddy' pour obtenir les produits existants
    $caddyData = json_decode($_COOKIE['caddy'], true);
} else {
    // Si le cookie n'existe pas, initialiser un tableau vide
    $caddyData = [];
}

// Ajouter le nouveau produit au tableau
$caddyData[] = $newProduct;

// Sauvegarder les données du caddy dans le cookie
setcookie("caddy", json_encode($caddyData), time() + 86400, "/");

// print(" <br>  <br> <br> <br> <br> <br> vous avez ajouter ce produit a votre coddy $prod  <br>"); 

require("ajoutproduit.php"); 

require("panier2.php"); 
?>

