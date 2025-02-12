<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produit</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            text-align: center;
        }
        .container {
            width: 90%;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
      
        
         .logo {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            height: auto;
        }
        
        h1 {
            color: #333;
            font-size: 20px;
        }
        p {
            color: #555;
            font-size: 16px;
        }
        .product-img {
            width: 100%;
            max-width: 200px;
            border-radius: 10px;
            margin-top: 10px;
        }
        .info {
            text-align: left;
            margin-top: 20px;
            padding: 10px;
            background: #eef1f4;
            border-radius: 10px;
        }
        
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 5px 10px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #0056b3;
        } 
        
    </style>
</head>
<body>
    <div class="container">
      
          <img src="../images/logo.png" alt="Logo" class="logo">
        <br>
        <a href="index.php" class="btn">Retour à l'accueil</a>
        <?php
        require("connecte.php");
        $MyId = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $myproduit = isset($_GET['idproduit']) ? intval($_GET['idproduit']) : 0;
        
        $sql = "SELECT nom, prix, description, photo1, photo2 FROM produit WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $myproduit);
            $stmt->execute();
            $result = $stmt->get_result();
            $produit = $result->fetch_assoc();
            
            if ($produit) {
                echo "<h1>" . htmlspecialchars($produit['nom']) . "</h1>";
                echo "<p><strong>Prix :</strong> " . htmlspecialchars($produit['prix']) . " €</p>";
                echo "<p class='info'><strong>Description :</strong> " . htmlspecialchars($produit['description']) . "</p>";
                
                if ($produit['photo1']) {
                    echo "<img src='../images/" . htmlspecialchars($produit['photo1']) . "' class='product-img' alt='Produit Image 1'>";
                }
                if ($produit['photo2']) {
                    echo "<img src='../images/" . htmlspecialchars($produit['photo2']) . "' class='product-img' alt='Produit Image 2'>";
                }
            } else {
                echo "<p>Aucun produit trouvé.</p>";
            }
            $stmt->close();
        }
        
        $sql2 = "SELECT adresse, phone, quantite FROM commande WHERE id = ?";
        $stmt2 = $conn->prepare($sql2);
        if ($stmt2) {
            $stmt2->bind_param("i", $MyId);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            $macommande = $result2->fetch_assoc();
            
            if ($macommande) {
                echo "<div class='info'>";
                echo "<p><strong>Adresse :</strong> " . htmlspecialchars($macommande['adresse']) . "</p>";
                echo "<p><strong>Téléphone :</strong> " . htmlspecialchars($macommande['phone']) . "</p>";
                echo "<p><strong>Quantité :</strong> " . htmlspecialchars($macommande['quantite']) . "</p>";
                echo "</div>";
            }
            $stmt2->close();
        }
        ?>
    </div>
     <a href="index.php" class="btn">Retour à l'accueil</a>
    
</body>
</html>
