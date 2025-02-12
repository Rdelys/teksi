<?php
require("connecte.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $prix = isset($_POST['prix']) ? floatval($_POST['prix']) : 0;
    $quantite = isset($_POST['quantite']) ? intval($_POST['quantite']) : 0;

    if ($id > 0) {
        // Mettre à jour le produit (prix et quantité)
        $stmt = $conn->prepare("UPDATE produit SET prix = ?, quantite = ? WHERE id = ?");
        $stmt->bind_param("dii", $prix, $quantite, $id);
        $stmt->execute();
        $stmt->close();

        // Mettre à jour les tailles
        if (!empty($_POST['tailles'])) {
            foreach ($_POST['tailles'] as $taille_id => $taille_quantite) {
                $taille_quantite = intval($taille_quantite);
                $stmt = $conn->prepare("UPDATE produit_taille SET quantite = ? WHERE id = ?");
                $stmt->bind_param("ii", $taille_quantite, $taille_id);
                $stmt->execute();
                $stmt->close();
            }
        }

        echo "<p>Mise à jour réussie.</p>";
    } else {
        echo "<p>Erreur : données invalides.</p>";
    }
}

// Récupérer les informations du produit
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id > 0) {
    $stmt = $conn->prepare("SELECT * FROM produit WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $prix = htmlspecialchars($row['prix']);
        $quantite = htmlspecialchars($row['quantite']);
    } else {
        echo "<p>Produit introuvable.</p>";
        exit;
    }
    $stmt->close();

    // Récupérer les tailles associées
    $stmt = $conn->prepare("SELECT id, taille, quantite FROM produit_taille WHERE produit_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultTailles = $stmt->get_result();
    $tailles = [];

    while ($rowTaille = $resultTailles->fetch_assoc()) {
        $tailles[] = $rowTaille;
    }
    $stmt->close();
} else {
    echo "<p>ID de produit invalide.</p>";
    exit;
}
?>

<!-- Formulaire de mise à jour -->
<form method="post" action="">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <table border="2" width="80%">
        <tr>
            <td>Prix (USD)</td>
            <td>
                <input type="number" name="prix" value="<?php echo $prix; ?>" min="0" step="0.01" required>
            </td>
        </tr>
        <tr>
            <td>Quantité</td>
            <td>
                <input type="number" name="quantite" value="<?php echo $quantite; ?>" min="0" step="1" required>
            </td>
        </tr>
        <?php if (!empty($tailles)): ?>
            <tr>
                <td>Tailles Disponibles</td>
                <td>
                    <?php foreach ($tailles as $taille): ?>
                        <label>
                            <?php echo htmlspecialchars($taille['taille']); ?>
                            <input type="number" name="tailles[<?php echo $taille['id']; ?>]" value="<?php echo $taille['quantite']; ?>" min="0" step="1">
                        </label>
                        <br>
                    <?php endforeach; ?>
                </td>
            </tr>
        <?php endif; ?>
        <tr>
            <td></td>
            <td><input type="submit" value="Mettre à jour"></td>
        </tr>
    </table>
</form>
