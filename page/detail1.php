<?php
print(" <br>*************** ");
print(" page detail "); 

require("connecte.php"); 

$id = $_GET['prod']; // Assurez-vous que l'ID est passé en paramètre dans l'URL
print(" <br> <br><br> id $id ");

// Requête pour récupérer les données de la table "produit"
$sql = "SELECT * FROM produit WHERE id ='$id'";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    // Accéder aux colonnes spécifiques de la ligne actuelle
    $nom = $row['nom'];
    $description = $row['description'];
    $prix = $row['prix'];
    $photo1 = $row['photo1'];
    $photo2 = $row['photo2'];
    $photo3 = $row['photo3']; // Correction ici
    $video1 = $row['video1'];
    $video2 = $row['video2'];
}

$hauteur_voulue = "300";
print(" <br> id $id  $photo1 $photo1  $photo2 $photo2  $photo3 $photo3 ");

?>
<br> <br><br><br><br><br><br>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Swipe Produit</title>
    <style>
        #profile-container {
            width: 100%;
            text-align: center;
        }
        .profile {
            display: none;
        }
        .profile img {
            height: <?php echo $hauteur_voulue; ?>px;
        }
        .profile.active {
            display: block;
        }
    </style>
</head>
<body>
    <div id="profile-container">
        <div class="profile active">
            <img src="images/<?php echo $photo1; ?>" alt="<?php echo $nom; ?>">
        </div>
        <div class="profile">
            <img src="images/<?php echo $photo2; ?>" alt="<?php echo $nom; ?>">
        </div>
        <div class="profile">
            <img src="images/<?php echo $photo3; ?>" alt="<?php echo $nom; ?>">
        </div>
    </div>
    <button id="swipe-left">Swipe Left</button>
    <button id="swipe-right">Swipe Right</button>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let currentProfileIndex = 0;
            const profiles = document.querySelectorAll('.profile');

            function showProfile(index) {
                profiles.forEach((profile, i) => {
                    profile.classList.toggle('active', i === index);
                });
            }

            document.getElementById('swipe-left').addEventListener('click', () => {
                currentProfileIndex = (currentProfileIndex - 1 + profiles.length) % profiles.length;
                showProfile(currentProfileIndex);
            });

            document.getElementById('swipe-right').addEventListener('click', () => {
                currentProfileIndex = (currentProfileIndex + 1) % profiles.length;
                showProfile(currentProfileIndex);
            });

            showProfile(currentProfileIndex);
        });
    </script>
</body>
</html>
