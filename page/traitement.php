<br> <br> <br> <br> <br>
<br> <br> <br> <br> <br>

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Récupérer les données du cookie
$cookieData = json_decode($_COOKIE['caddy'], true);

// Informations de connexion
/*$servername = "146.59.227.113";
$username = "TshivTony";
$password = "TsTon2023nc";
$dbname = "teksi";*/

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "teksi";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Récupérer les données du formulaire
$nom = htmlspecialchars($_GET['nom'] ?? '');
$telephone = htmlspecialchars($_GET['telephone'] ?? '');
$adresse = htmlspecialchars($_GET['adresse'] ?? '');
$livraison_jour = htmlspecialchars($_GET['livraison_jour'] ?? '');
$livraison_heure = htmlspecialchars($_GET['livraison_heure'] ?? '');
$monprix = htmlspecialchars($_GET['monprix'] ?? '');

if (!is_numeric($monprix) || $monprix === '') {
    die("Erreur : le prix est invalide ou manquant.");
}

// Formatage de la date de commande
$datecommande = date('Y-m-d H:i:s');

// Préparer la requête pour éviter les injections SQL
$stmt = $conn->prepare("INSERT INTO commande (idproduit, quantite, prix, adresse, nom, datecommande, livraisonheur, livraisonjour, phone) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
if ($stmt === false) {
    die("Erreur de préparation de la requête : " . $conn->error);
}

// Lier les paramètres et insérer chaque produit
foreach ($cookieData as $product) {
    $idProduit = intval($product['idproduit']);
    $quantite = intval($product['quantite']);
    
    // Lier les paramètres pour ce produit
    $stmt->bind_param(
        "iisssssss", 
        $idProduit, 
        $quantite, 
        $monprix, 
        $adresse, 
        $nom, 
        $datecommande, 
        $livraison_heure, 
        $livraison_jour, 
        $telephone
    );
    
    // Exécuter la requête
    if (!$stmt->execute()) {
        echo "Erreur lors de l'insertion du produit ID $idProduit : " . $stmt->error . "<br>";
    }
}

// Fermer la requête et la connexion
$stmt->close();
$conn->close();

// Message de confirmation
echo '<div style="text-align: left; color: orange; font-size: 24px; font-weight: bold; margin-top: 20px;">
        Votre commande a bien été enregistrée. <br> <br> Nous vous contacterons rapidement.
      </div>';
?>


