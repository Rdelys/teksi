<?php

// Vérification du cookie shopTeksi
if (isset($_COOKIE['shopTeksi']) && $_COOKIE['shopTeksi'] === "1") {
    // echo "<h1 style='color: orange; text-align: center;'>Bienvenue, utilisateur actif !</h1>";
    // Continuer l'application
} else {
    // Si le formulaire est soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nom = $conn->real_escape_string($_POST['nom']);
        $prenom = $conn->real_escape_string($_POST['prenom']);
        $telephonep = $conn->real_escape_string($_POST['telephonep']);
        $adresse = $conn->real_escape_string($_POST['adresse']);
        $email = $conn->real_escape_string($_POST['email']);

        // Insérer les données dans la table identite
        $sql = "INSERT INTO identite (nom, prenom, telephonep, adresse, email) 
                VALUES ('$nom', '$prenom', '$telephonep', '$adresse', '$email')";

        if ($conn->query($sql) === TRUE) {
            // Définir le cookie shopTeksi avec une durée illimitée
            setcookie("shopTeksi", "1", time() + (10 * 365 * 24 * 60 * 60), "/");
            ?>
            
                  <center> <img src="images/logo.png" width="50%" alt="Logo"></center> 
                  <br>
                  <br>
            <?php
            echo "<h3 style='color: orange; text-align: center;'>Inscription réussie. Bienvenue !</h3>";
            
          
         
            
            echo "<div style='text-align: center; margin-top: 24px;'>
        <a href='index.php' style='text-decoration: none; font-size: 24px; color: blue; font-weight: bold;'>Suivant</a>
      </div>";
            
          require("monbas2.php");   
        } else {
            echo "Erreur : " . $sql . "<br>" . $conn->error;
        }
    } else {
        // Afficher le formulaire d'inscription
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Inscription</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f9f3e8;
                    color: #333;
                    margin: 0;
                    padding: 0;
                }
                .container {
                    max-width: 350px;
                    margin: 50px auto;
                    background: #fff;
                    border-radius: 10px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    padding: 20px;
                    text-align: center;
                }
                .logo {
                    margin-bottom: 20px;
                }
                input[type="text"], input[type="email"], input[type="tel"] {
                    width: 100%;
                    padding: 10px;
                    margin: 10px 0;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                }
                button {
                    background-color: orange;
                    color: white;
                    border: none;
                    padding: 10px 20px;
                    font-size: 16px;
                    border-radius: 5px;
                    cursor: pointer;
                }
                button:hover {
                    background-color: #e69500;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="logo">
                    <img src="images/logo.png" width="70%" alt="Logo">
                </div>
                <h2 style="color: orange;">Inscrivez-vous pour continuer</h2>
                <form method="POST" action="">
                    <input type="text" name="nom" placeholder="Nom" required>
                    <input type="text" name="prenom" placeholder="Prénom" required>
                    <input type="tel" name="telephonep" placeholder="Téléphone" required>
                    <input type="text" name="adresse" placeholder="Adresse" required>
                    <input type="email" name="email" placeholder="Email"  >
                    <button type="submit">S'inscrire</button>
                </form>
            </div>
        </body>
        </html>
        <?php
    }
}

// Fermer la connexion
$conn->close();
?>
