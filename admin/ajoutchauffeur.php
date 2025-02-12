<?php
// Paramètres de connexion à la base de données
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

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['nom'], $_GET['prenom'], $_GET['adresse'], $_GET['datenaissance'], $_GET['telephone'])) {
    // Récupérer les données du formulaire
    $nom = $_GET['nom'];
    $prenom = $_GET['prenom'];
    $adresse = $_GET['adresse'];
    $datenaissance = $_GET['datenaissance'];
    $telephone = $_GET['telephone'];
   



$stmt = $conn->prepare("INSERT INTO chauffeur (nom, prenom, adresse, datenaissance, telephone) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nom, $prenom, $adresse, $datenaissance, $telephone);

    // Exécuter la requête
    if ($stmt->execute()) {
        echo "Chauffeur ajouté avec succès!";
                echo " <br> <div style='text-align: center; font-size: 30px; color: green;'>Chauffeur ajouté avec succès!</div> <br> <br> ";
    } else {
        echo "Erreur: " . $stmt->error;
    }
    $stmt->close();
}









?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Chauffeur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 60%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            color: #555;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .form-group input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Formulaire d'ajout de Chauffeur</h2>
    <form action="dashboard.php" method="get">
		
		            <input type="hidden"  name="page" value="ajoutchauffeur">
		
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" required>
        </div>

        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" id="prenom" name="prenom" >
        </div>

        <div class="form-group">
            <label for="adresse">Adresse</label>
            <input type="text" id="adresse" name="adresse" required>
        </div>

        <div class="form-group">
            <label for="datenaissance">Date de naissance</label>
            <input type="date" id="datenaissance" name="datenaissance" required>
        </div>

        <div class="form-group">
            <label for="telephone">Téléphone</label>
            <input type="text" id="telephone" name="telephone" required>
        </div>


        <div class="form-group">
            <input type="submit" value="Enregistrer">
        </div>
    </form>
</div>

</body>
</html>

<?php
// Fermer la connexion à la base de données
$conn->close();
?>
