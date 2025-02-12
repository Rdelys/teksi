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
    width: 50%;                 /* Ajuste la taille de l'image */
    max-width: 150px;           /* Largeur maximale pour éviter une image trop grande */
    height: auto;               /* Maintient les proportions de l'image */
}

.header p {
    margin-top: 10px;           /* Ajoute un petit espacement au-dessus du texte */
    font-size: 14px;            /* Ajuste la taille du texte pour mobile */
}
    
        
        

        .content {
            padding: 0;
            margin: 0;
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
            width: 90%;
            height: 200px;
            border: 0;
            border-radius: 15px;
            padding: 5px;
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
    height: 250px;                 /* Conserve les proportions */
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


 
        
    </style>
</head>
<body>
    <div class="header">
        <img src="../images/logo.png" width="50%" alt="Logo">
        <p>TOZO LIVRER EN EXPRESS PARTOUT À KINSHASA</p>
    </div>

    <div class="content">
		
		
		<tr>
                <td> 
					
                
                 </td>
            
            </tr>
		
		
		
		

<?php
$id = $_GET["prod"];  
$mapage = $_GET["page"];
$prodid = $_GET["prod"];
$mapage = "page/".$mapage.".php";

if (file_exists($mapage)) {
    require($mapage);
   
    
} else {   
  
  
   }    
    

       
       
?>	



    </div>
 
 <script>
    const swiper = new Swiper('.swiper-container', {
        slidesPerView: 1,            // Nombre d'images visibles par page
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
                slidesPerView: 1,   // Afficher 2 images
                spaceBetween: 5,    // Moins d'espace
            },
            480: {                  // Pour les mobiles de taille moyenne
                slidesPerView: 1,   // Afficher 3 images
                spaceBetween: 10,
            }
        }
    });
</script>

<?php
require("../monbas.php"); 

?>


</body>
</html>
