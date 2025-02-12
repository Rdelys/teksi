<?php
require("connecte.php"); 

// Vérifiez que l'ID est passé en paramètre
if (!isset($_GET['prod']) || empty($_GET['prod'])) {
    die("ID du produit manquant.");
}

$id = intval($_GET['prod']); // Sécurisation de l'entrée utilisateur

// Requête pour récupérer les données de la table "produit"
$sql = "SELECT * FROM produit WHERE id = '$id'";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    die("Produit introuvable.");
}

while ($row = $result->fetch_assoc()) {
    $nom = $row['nom'];
    $description = $row['description'];
    $prix = $row['prix'];
    $photo1 = $row['photo1'];
    $photo2 = $row['photo2'];
    $photo3 = $row['photo3'];
    $video1 = $row['video1'];
    $video2 = $row['video2'];
}

$defaultMessage = "Bonjour, le produit " . $nom . " m'intéresse beaucoup.";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($nom); ?></title>
    <style>
        .slider-container {
            position: relative;
            width: 100%;
            max-width: 600px;
            margin: auto;
            overflow: hidden;
        }

        .slider {
            display: flex;
            transition: transform 0.5s ease-in-out;
            overflow: hidden;
        }

        .slider-image {
            flex-shrink: 0;
            width: 100%;
            height: auto;
        }

        .slider-controls button {
            position: absolute;
            top: 50%;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px;
            transform: translateY(-50%);
            z-index: 1000;
        }

        .slider-controls button:nth-child(1) {
            left: 10px;
        }

        .slider-controls button:nth-child(2) {
            right: 10px;
        }
    </style>
</head>
<body>

<h1><?php echo htmlspecialchars($nom); ?></h1>
<p><?php echo htmlspecialchars($description); ?></p>
<p>Prix : <?php echo htmlspecialchars($prix); ?> €</p>

<div class="slider-container">
    <div class="slider">
        <?php if (!empty($photo1)) : ?>
            <img src="images/<?php echo htmlspecialchars($photo1); ?>" alt="Image 1" class="slider-image">
        <?php endif; ?>
        <?php if (!empty($photo2)) : ?>
            <img src="images/<?php echo htmlspecialchars($photo2); ?>" alt="Image 2" class="slider-image">
        <?php endif; ?>
        <?php if (!empty($photo3)) : ?>
            <img src="images/<?php echo htmlspecialchars($photo3); ?>" alt="Image 3" class="slider-image">
        <?php endif; ?>
    </div>
    <div class="slider-controls">
        <button onclick="moveSlide(-1)">&#10094;</button>
        <button onclick="moveSlide(1)">&#10095;</button>
    </div>
</div>

<script>
let currentSlide = 0;

function moveSlide(direction) {
    const slider = document.querySelector(".slider");
    const slides = document.querySelectorAll(".slider-image");
    const totalSlides = slides.length;

    // Calcul de la largeur d'une image
    const slideWidth = slides[0].clientWidth;

    // Mise à jour de l'index du slide
    currentSlide = (currentSlide + direction + totalSlides) % totalSlides;

    // Déplacement du slider
    slider.style.transform = `translateX(-${currentSlide * slideWidth}px)`;
}

// Gestion du swipe tactile
let startX = 0;
let endX = 0;

document.querySelector(".slider-container").addEventListener("touchstart", (e) => {
    startX = e.touches[0].clientX;
});

document.querySelector(".slider-container").addEventListener("touchend", (e) => {
    endX = e.changedTouches[0].clientX;
    handleSwipe();
});

function handleSwipe() {
    if (startX - endX > 50) {
        moveSlide(1); // Swipe gauche
    } else if (endX - startX > 50) {
        moveSlide(-1); // Swipe droite
    }
}
</script>

</body>
</html>
