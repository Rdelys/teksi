<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // L'utilisateur n'est pas connecté, le rediriger vers la page de login
    header('Location: index.php');
    exit();
}

error_reporting(E_ALL);

// Activer l'affichage des erreurs
ini_set('display_errors', 1);

// Désactiver la mise en cache des erreurs
ini_set('display_startup_errors', 1);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f0f0f0;
        }
        .navbar {
            overflow: hidden;
            background-color: #333;
        }
        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
        .navbar a.active {
            background-color: #4CAF50;
            color: white;
        }
        .navbar .icon {
            display: none;
        }
        @media screen and (max-width: 600px) {
            .navbar a:not(:first-child) {
                display: none;
            }
            .navbar a.icon {
                float: right;
                display: block;
            }
        }
        @media screen and (max-width: 600px) {
            .navbar.responsive {position: relative;}
            .navbar.responsive .icon {
                position: absolute;
                right: 0;
                top: 0;
            }
            .navbar.responsive a {
                float: none;
                display: block;
                text-align: left;
            }
        }
        .content {
            padding: 20px;
        }
        .dashboard-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            margin: auto;
        }
        
        button {
            padding: 15px 30px;
            font-size: 18px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
        
        
    
    
     input[type="file"] {
            opacity: 0;
            position: absolute;
        }
        .file-label {
            display: inline-block;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }
    
    </style>
</head>
<body>


<?php

require("menu.php");
?>



<script>
function myFunction() {
    var x = document.getElementById("myNavbar");
    if (x.className === "navbar") {
        x.className += " responsive";
    } else {
        x.className = "navbar";
    }
}
</script>

<?php

$pagesAutorisees = ["ajouter","myproduct","Liste2","transferer","Liste","detail","commande","detail2","pcommande","admin","transferer","Mesvente","ajoutchauffeur","listechauffeur","modifier_chauffeur","voir_chauffeur"]; 

// print(" **** mapage1  $mapage ***  "); 
$mapage = isset($_GET["page"]) ? $_GET["page"] : null;
$mapageNew = $mapage.".php"; 
// print(" mapageNew $mapageNew"); 
// require("mapageNew"); 

if (in_array($mapage, $pagesAutorisees)) {
    $mapageNew = $mapage . ".php";
    
    // Inclure la page autorisée
    require($mapageNew);
} else {
    // Page non autorisée ou invalide
    print("Page non trouvée ou non autorisée.");
    // Optionnel : inclure une page par défaut ou afficher une erreur
   //  require("404.php");
}


?>


</body>
</html>
