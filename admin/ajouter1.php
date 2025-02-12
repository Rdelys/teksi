<?php
// Paramètres de connexion
require("connecte.php"); 

$uploadDir = "uploads/"; // Définir le dossier d'upload

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $nom = $conn->real_escape_string($_POST['nom']);
    $description = $conn->real_escape_string(substr($_POST['description'], 0, 250));
    $quantite = intval($_POST['quantite']);
    $prix = floatval($_POST['prix']);
    $taille = isset($_POST['taille']) ? $conn->real_escape_string($_POST['taille']) : null;

    // Gestion des fichiers
    function uploadFile($file, $uploadDir) {
        if (isset($_FILES[$file]) && $_FILES[$file]['error'] === UPLOAD_ERR_OK) {
            $filePath = $uploadDir . basename($_FILES[$file]['name']);
            if (move_uploaded_file($_FILES[$file]['tmp_name'], $filePath)) {
                return $filePath;
            }
        }
        return null;
    }

    $photo1 = uploadFile('photo1', $uploadDir);
    $photo2 = uploadFile('photo2', $uploadDir);
    $photo3 = uploadFile('photo3', $uploadDir);
    $video1 = uploadFile('video1', $uploadDir);
    $video2 = uploadFile('video2', $uploadDir);

    // Insertion sécurisée avec requête préparée
    $sql = $conn->prepare("INSERT INTO produit (nom, description, prix, photo1, photo2, photo3, video1, video2, quantite, taille) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $sql->bind_param("ssdsssssis", $nom, $description, $prix, $photo1, $photo2, $photo3, $video1, $video2, $quantite, $taille);

    if ($sql->execute()) {
        echo "Produit ajouté avec succès !";
    } else {
        echo "Erreur : " . $sql->error;
    }

    $sql->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un produit</title>
</head>
<body>
    <h1>Ajouter un produit</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <table border="2" width="90%">
            <tr>
                <td width="30%"> <label for="nom">Nom du produit :</label></td>
                <td> <input type="text" id="nom" name="nom" required> </td>
            </tr>   
            <tr>
                <td>  <label for="description">Description :</label></td>
                <td> <textarea id="description" name="description" maxlength="250" required></textarea> </td>
            </tr>   
            <tr>
                <td><label for="photo1">Photo 1 :</label></td>
                <td><input type="file" id="photo1" name="photo1" accept="image/*"></td>
            </tr>
            <tr>
                <td><label for="photo2">Photo 2 :</label></td>
                <td><input type="file" id="photo2" name="photo2" accept="image/*"></td>
            </tr>
            <tr>
                <td><label for="photo3">Photo 3 :</label></td>
                <td><input type="file" id="photo3" name="photo3" accept="image/*"></td>
            </tr>
            <tr>
                <td><label for="video1">Vidéo 1 :</label></td>
                <td><input type="file" id="video1" name="video1" accept="video/*"></td>
            </tr>
            <tr>
                <td><label for="video2">Vidéo 2 :</label></td>
                <td><input type="file" id="video2" name="video2" accept="video/*"></td>
            </tr>
            <tr>
                <td>Produit à taille unique :</td>
                <td>
                    <select name="maquantite" id="pet-select" onchange="toggleSizeField()">
                        <option selected>Choisir</option>
                        <option value="1">OUI</option>
                        <option value="2">NON</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="quantite">Quantité :</label></td>
                <td><input type="number" id="quantite" name="quantite" required></td>
            </tr>
            <tr>
                <td><label for="prix">Prix :</label></td>
                <td><input type="text" id="prix" name="prix" required></td>
            </tr>
            <tr id="tailleRow" style="display: none;">
                <td><label for="taille">Taille :</label></td>
                <td><input type="text" id="taille" name="taille"></td>
            </tr>
        </table>
        <center><button type="submit">Ajouter le produit</button></center>
    </form>

    <script>
        function toggleSizeField() {
            var select = document.getElementById("pet-select");
            var tailleRow = document.getElementById("tailleRow");

            if (select.value === "2") {
                tailleRow.style.display = "table-row";
            } else {
                tailleRow.style.display = "none";
            }
        }
    </script>
</body>
</html>
