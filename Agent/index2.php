<?php
// Connexion à la base de données
$servername = "146.59.227.113";
$username = "TshivTony";
$password = "TsTon2023nc";
$dbname = "teksi";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer les paramètres avec sécurité
$Monstatus = isset($_GET['status']) ? intval($_GET['status']) : null;
$MyorderId = isset($_GET['orderId']) ? intval($_GET['orderId']) : null;
$MyUserid = isset($_GET['userId']) ? intval($_GET['userId']) : null;

if ($Monstatus === 1 && $MyorderId) { // "1" correspond à "Livré"
    // Récupérer l'id du produit associé à la commande
    $sql = "SELECT idproduit FROM commande WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $MyorderId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $idproduit = $row['idproduit'];

        // Mettre à jour l'état de la commande
        $updateCommande = "UPDATE commande SET etatcommande = 'vente', dateVente = NOW() WHERE id = ?";
        $stmt2 = $conn->prepare($updateCommande);
        $stmt2->bind_param("i", $MyorderId);
        $stmt2->execute();


        if ($stmt2->affected_rows > 0) { 
            // Diminuer le stock du produit concerné
            $updateStock = "UPDATE stock SET nombre = nombre - 1 WHERE id = ? AND nombre > 0";
            $stmt3 = $conn->prepare($updateStock);
            $stmt3->bind_param("i", $idproduit);
            $stmt3->execute();

            if ($stmt3->affected_rows > 0) {
                echo "Commande validée et stock mis à jour.";
            } else {
                echo "Stock insuffisant ou erreur de mise à jour.";
            }
        } else {
            echo "Erreur de mise à jour de la commande.";
        }
    } else {
        echo "Commande non trouvée.";
    }
}

// Affichage des statuts
$statusLabels = [
    2 => "Refusé",
    3 => "Ne répond pas",
    4 => "Reporté",
    5 => "Annulé"
];

echo "<br> Monstatus: $Monstatus - MyorderId: $MyorderId - MyUserid: $MyUserid";

if ($Monstatus == 1) {
    echo "<br><b>Vente</b>";
} elseif (isset($statusLabels[$Monstatus])) {
    echo "<br><b>{$statusLabels[$Monstatus]}</b>";
}

$conn->close();
?>
