<?php
require("connecte.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Vérifier si l'action correspond à la mise à jour
    if (isset($_POST['page']) && $_POST['page'] === 'detail2') {
        // Récupérer et valider les données du formulaire
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $quantite = isset($_POST['quantite']) ? intval($_POST['quantite']) : 0;

        if ($id > 0 && $quantite >= 0) {
            // Préparer et exécuter la requête d'UPDATE
            $stmt = $conn->prepare("UPDATE produit SET quantite = ? WHERE id = ?");
            $stmt->bind_param("ii", $quantite, $id);

            if ($stmt->execute()) {
                echo "<p>Produit mis à jour avec succès.</p>";
            } else {
                echo "<p>Erreur lors de la mise à jour : " . htmlspecialchars($conn->error) . "</p>";
            }

            $stmt->close();
        } else {
            echo "<p>Erreur : données invalides.</p>";
        }
    }
}

// Validation de l'ID pour la lecture
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Préparer la requête pour récupérer les informations du produit
    $stmt = $conn->prepare("SELECT * FROM produit WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $quantite = htmlspecialchars($row['quantite']);
    } else {
        echo "<p>Produit introuvable.</p>";
        $quantite = '';
    }

    $stmt->close();
} else {
    echo "<p>ID de produit invalide.</p>";
    $quantite = '';
}
?>

<!-- Formulaire de mise à jour -->
<form method="post" action="">
    <input type="hidden" name="page" value="detail2">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <table border="2" width="80%">
        <tr>
            <td>Quantité</td>
            <td>
                <input 
                    type="number" 
                    name="quantite" 
                    value="<?php echo $quantite; ?>" 
                    min="0" 
                    step="1" 
                    required>
            </td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="Mettre à jour"></td>
        </tr>
    </table>
</form>
