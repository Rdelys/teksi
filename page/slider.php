
<div class="content">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?php
            // Connexion à la base de données
            require("connecte.php");

            $sql = "SELECT * FROM produit WHERE promo = 1";
            $result = $conn->query($sql);

            if ($result === false) {
                echo "<p>Erreur lors de la requête : " . $conn->error . "</p>";
            } elseif ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $photo1 = isset($row["photo1"]) ? htmlspecialchars($row["photo1"]) : "default-image.jpg";
                       $Myid = isset($row["id"])  ? htmlspecialchars($row["id"]) : "monId";
                    $nom = isset($row["nom"]) ? htmlspecialchars($row["nom"]) : "Produit";
                    $prix = isset($row["prix"]) ? htmlspecialchars($row["prix"]) : "Produit";
                   
                 
          
    
  
   
   echo '<div class="swiper-slide">
    <a href="index-vide1.php?page=' . urlencode('detail3') . '&prod=' . urlencode($Myid) . '">
        <img src="images/' . htmlspecialchars($photo1, ENT_QUOTES, 'UTF-8') . '" alt="' . htmlspecialchars($nom, ENT_QUOTES, 'UTF-8') . '" class="slider-image">
    </a>
    
    
     <div class="image-info" style="display: flex; flex-direction: column; align-items: center; margin-top: 5px;">
        <p class="image-price" style="font-size: 12px; color: orange; font-weight: bold; margin: 0; margin-left: auto; margin-right: auto;">' . htmlspecialchars($prix, ENT_QUOTES, 'UTF-8') . ' €</p>
    </div>
    
</div>'; 
    
        
                    
                }
            } else {
                echo "<p>Aucun produit en promotion trouvé.</p>";
            }
            ?>
            

        </div>
        <!-- Boutons de navigation (facultatifs) -->
          <!-- 
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        -->
        

    </div>

</div>
