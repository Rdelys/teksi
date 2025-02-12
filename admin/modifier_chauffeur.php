<?php
$servername = "146.59.227.113";
$username = "TshivTony";
$password = "TsTon2023nc";
$dbname = "teksi";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $chauffeur_id = $_GET['id'];
    
    // Requête pour récupérer les informations actuelles du chauffeur
    $sql = "SELECT * FROM chauffeur WHERE id = $chauffeur_id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // Récupérer les données du chauffeur
        $chauffeur = $result->fetch_assoc();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Récupérer les nouvelles valeurs du formulaire
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $telephone = $_POST['telephone'];
            $adresse = $_POST['adresse'];
            $datenaissance = $_POST['datenaissance'];

            // Mettre à jour les informations dans la base de données
            $update_sql = "UPDATE chauffeur SET 
                nom = '$nom', 
                prenom = '$prenom', 
                telephone = '$telephone', 
                adresse = '$adresse', 
                datenaissance = '$datenaissance' 
                WHERE id = $chauffeur_id";
            
            if ($conn->query($update_sql) === TRUE) {
                echo "Informations mises à jour avec succès.";
            } else {
                echo "Erreur lors de la mise à jour : " . $conn->error;
            }
        }
        
        echo "<h2>Modifier les informations du chauffeur</h2>";
        echo "<form method='POST'>
                <label for='nom'>Nom:</label>
                <input type='text' id='nom' name='nom' value='" . $chauffeur['nom'] . "' required><br><br>
                
                <label for='prenom'>Prénom:</label>
                <input type='text' id='prenom' name='prenom' value='" . $chauffeur['prenom'] . "' required><br><br>
                
                <label for='telephone'>Téléphone:</label>
                <input type='text' id='telephone' name='telephone' value='" . $chauffeur['telephone'] . "' required><br><br>
                
                <label for='adresse'>Adresse:</label>
                <input type='text' id='adresse' name='adresse' value='" . $chauffeur['adresse'] . "' required><br><br>
                
                <label for='datenaissance'>Date de naissance:</label>
                <input type='text' id='datenaissance' name='datenaissance' value='" . $chauffeur['datenaissance'] . "' required><br><br>
                
                <button type='submit'>Mettre à jour</button>
              </form>";
    } else {
        echo "Chauffeur introuvable.";
    }
} else {
    echo "Aucun chauffeur spécifié.";
}

$conn->close();
?>
