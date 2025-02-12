<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Connexion à la base de données
require("connecte.php"); 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page avec moteur de recherche fixe</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="header">
        <center>
            <?php $hauteur = "50"; ?>
            <img src="images/logo.png" alt="Logo" style="height: <?php echo $hauteur; ?>px;">
            <br>
        </center>
        <input type="text" placeholder="Recherche...">
        <button>Rechercher</button>
        <br><br>
        <font size="2" color="black">
            <center>TOZO LIVRER EN EXPRESS PARTOUT A KINSHASA</center>
        </font>
    </div>

    <div class="content">
        <?php
        $hauteur_voulue = "150";

        // Requête pour récupérer les produits
        $sql = "SELECT * FROM produit";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<table border="0" width="100%">';

            // Initialiser un compteur de colonnes
            $colCounter = 0;

            // Parcourir chaque produit
            while ($row = $result->fetch_assoc()) {
                if ($colCounter % 2 == 0) {
                    // Démarrer une nouvelle ligne pour chaque paire de produits
                    if ($colCounter > 0) {
                        echo '</tr>';
                    }
                    echo '<tr>';
                }

                $id = $row["id"];
                $nom = $row["nom"];
                $description = $row["description"];
                $prix = $row["prix"];
                $photo1 = $row["photo1"];
                
                echo '
                <td align="center">
                    <a href="index-vide.php?page=detail&prod=' . $id . '">
                        <img src="images/' . $photo1 . '" alt="' . $nom . '" style="height: ' . $hauteur_voulue . 'px;">
                    </a>
                    <br>
                    <font size="2">' . $nom . '</font>
                    &nbsp;
                    <font size="2">' . $prix . ' USD</font>
                    <br>
                    <font size="2"> Plus d info </font> <br>
                     <br>
                </td>';
                
                $colCounter++;
            }
            
            // Fermer la dernière ligne si nécessaire
            if ($colCounter % 2 != 0) {
                echo '<td></td></tr>';
            } else {
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo "Aucun produit trouvé.";
        }

        // Fermeture de la connexion
        $conn->close();
        ?>
    </div>
</body>
</html>
