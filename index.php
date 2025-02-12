<?php
require("connecte.php"); 

require("index_inscription.php"); 

if (isset($_COOKIE['shopTeksi']) && $_COOKIE['shopTeksi'] === "1") {
    // echo "<h1 style='color: orange; text-align: center;'>Bienvenue, utilisateur actif !</h1>";
    // Continuer l'application

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page avec moteur de recherche fixe</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

     
    .header {
    display: flex;              /* Utilisation de flexbox pour centrer */
    flex-direction: column;     /* Aligner les éléments verticalement */
    align-items: center;        /* Centre horizontalement */
    justify-content: center;    /* Centre verticalement si nécessaire */
    text-align: center;         /* Centrer le texte */
    background-color: #F0972F;  /* Couleur jaune (déjà présente dans ton code) */
    padding: 10px;              /* Espacement interne */
}




.header img {
    width: 100%;                 /* Ajuste la taille de l'image */
    max-width: 250px;           /* Largeur maximale pour éviter une image trop grande */
    height: auto;               /* Maintient les proportions de l'image */
}

.header p {
    margin-top: 10px;           /* Ajoute un petit espacement au-dessus du texte */
    font-size: 14px;            /* Ajuste la taille du texte pour mobile */
}
    
        
        

        .content {
            padding: 0;
            margin: 0;
             background-color: white;
        }


   table {
    width: 100%;
    border-collapse: collapse;
}

td {
    width: 20%; /* Force chaque colonne à 20% */
 
    border: none;
    text-align: center;
    vertical-align: top;
    padding: 5px;
    box-sizing: border-box; /* Inclut les bordures et le padding dans les 20% */
}


    

        .product-image {
            width: 100%;
            height: 200px;
            border: 0;
            border-radius: 15px;
            padding: 1px;
            box-shadow: 0 3px 2px rgba(0, 0, 0, 0.1);
        }


        .product-info {
            font-size: 10px;
            margin-top: 10px;
        }

        .product-price {
            color: #28a745;
            font-weight: bold;
        }
        
      
      
   .content {
    width: 100%;                  /* Le slider prend toute la largeur disponible */
    overflow: hidden;             /* Évite les débordements */
}

.swiper-container {
    width: 100%;                  /* Conteneur adaptatif */
    padding-bottom: 20px;         /* Espacement pour les éléments de navigation */
}

.swiper-slide {
    text-align: center;           /* Centre le contenu de chaque slide */
}

.slider-image {
    width: 100%;                  /* Chaque image occupe la largeur de son conteneur */
    height: 80px;                 /* Conserve les proportions */
    border-radius: 15px;           /* Coins arrondis pour un effet esthétique */
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Ombre légère */
}
   
.footer-menu {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background-color: #F0972F; /* Couleur de fond du menu */
    display: flex;
    justify-content: space-around; /* Espacement égal entre les éléments */
    padding: 10px 0;
    box-shadow: 0px -2px 5px rgba(0, 0, 0, 0.2); /* Ombre pour un effet esthétique */
    z-index: 1000; /* S'assure que le menu est toujours au-dessus */
}

.footer-menu a {
    text-decoration: none;
    color: white; /* Couleur du texte */
    font-size: 14px;
    font-weight: bold;
    text-align: center;
}

.footer-menu a:hover {
    color: black; /* Changer la couleur du lien au survol */
}

.image-info {
    text-align: center;
    margin-top: 5px;
}

.image-title {
    font-size: 14px;
    color: #333;
     text-align: center;
}

.image-price {
    font-size: 16px;
    color: orange;
    font-weight: bold;
}

 
        
    </style>
</head>
<body>
    <div class="header">
        <img src="images/logo.png" width="50%" alt="Logo">
       
      <img src="images/Ecriture_noir.png" width="100%">  
    </div>
    
    <div class="content">
		<br><br> <br>
		<br> <br> 
		
		<tr>
                <td > <font color="black" size="3"> <b>  Top Sélection > </b> <br> </font> </td>
            
            </tr>
		
		<?php
		require("page/slider.php"); 
	
        // Connexion à la base de données
        require("connecte.php");

        $sql = "SELECT * FROM produit";
        $result = $conn->query($sql);

        if ($result === false) {
            echo "<p>Erreur lors de la requête : " . $conn->error . "</p>";
        } elseif ($result->num_rows > 0) {
			
 echo '<table border="0" style="border-collapse: collapse; width: 100%; margin: 0; padding: 0;"> 
        <tr style="padding: 0;"> 
            <td style="padding: 0; margin: 0;"> 
                <h1 style="font-size: 24px; color: #ff6600; text-align: center; font-weight: bold; margin: 0;">
                    Explorez vos centres d\'intérêts
                </h1>
            </td>
        </tr> 
      </table>';
 

 
            echo '<table border="0">';

            $colCounter = 0;

            while ($row = $result->fetch_assoc()) {
                if ($colCounter % 2 == 0) {
                    if ($colCounter > 0) echo '</tr>';
                    echo '<tr>';
                }

                $id = isset($row["id"]) ? $row["id"] : 0;
                $nom = isset($row["nom"]) ? htmlspecialchars($row["nom"]) : "Nom indisponible";
                $prix = isset($row["prix"]) ? htmlspecialchars($row["prix"]) : "Prix non défini";
                $photo1 = isset($row["photo1"]) ? htmlspecialchars($row["photo1"]) : "default-image.jpg";

                echo '<td>
                    <a href="index-vide1.php?page=detail3&prod=' . $id . '">
                        <img src="images/' . $photo1 . '" alt="' . $nom . '" class="product-image">
                    </a>
                    <div class="product-info">
                        <span>' . $nom . '</span> 
                        <span class="product-price">' . $prix . ' USD</span>  
                        <a href="index-vide1.php?page=detail3&prod=' . $id . '">Plus d\'info</a>
                    </div>
                </td>';

                $colCounter++;
            }

            if ($colCounter % 2 != 0) {
                echo '<td></td></tr>';
            }

            echo '</table>';
        } else {
            echo "<p>Aucun produit trouvé dans la base de données.</p>";
        }

        $conn->close();
        ?>
    </div>
 
 <script>
    const swiper = new Swiper('.swiper-container', {
        slidesPerView: 4,            // Nombre d'images visibles par page
        spaceBetween: 10,           // Espace entre les images
        loop: true,                 // Permet un défilement infini
      /*
        navigation: {
            nextEl: '.swiper-button-next', // Bouton pour avancer
            prevEl: '.swiper-button-prev'  // Bouton pour reculer
        },
      */
        breakpoints: {
            // Configurations spécifiques pour différentes tailles d'écran
            320: {                  // Pour les très petits écrans
                slidesPerView: 4,   // Afficher 2 images
                spaceBetween: 5,    // Moins d'espace
            },
            480: {                  // Pour les mobiles de taille moyenne
                slidesPerView: 5,   // Afficher 3 images
                spaceBetween: 10,
            }
        }
    });
</script>

<?php
// require("monbas.php"); 
require("monbas2.php"); 

?>


</body>
</html>

<?php
}
?>
