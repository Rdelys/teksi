<?php
$prod = $_GET["prod"];
if (isset($_COOKIE['caddy'])) {
	// print("<br> <br> ***** existe deja ***** "); 
}
?>

<div class="content">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?php
            // Connexion à la base de données
            require("connecte.php");

            $sql = "SELECT * FROM produit WHERE id = $prod";
            $result = $conn->query($sql);

            if ($result === false) {
                echo "<p>Erreur lors de la requête : " . $conn->error . "</p>";
            } elseif ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Récupération des champs photo et vidéo
                     $productData = $row;
                    $mediaFields = ['photo1', 'photo2', 'photo3', 'video1', 'video2', 'video3'];
                    foreach ($mediaFields as $field) {
                        if (!empty($row[$field])) {
                            $media = htmlspecialchars($row[$field]);
                            if (strpos($field, 'photo') !== false) {
                                // Afficher une image si c'est une photo
                                echo '<div class="swiper-slide">
                                    <img src="images/' . $media . '" alt="Produit" class="slider-image">
                                </div>';
                            } elseif (strpos($field, 'video') !== false) {
                                // Afficher une vidéo si c'est une vidéo
                                echo '<div class="swiper-slide">
                                    <video controls class="slider-video">
                                        <source src="videos/' . $media . '" type="video/mp4">
                                        Votre navigateur ne supporte pas la lecture de vidéos.
                                    </video>
                                </div>';
                            }
                        }
                    }
                }
            } else {
                echo "<p>Aucun produit trouvé.</p>";
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



<table border="0" align="left" width="100%">
<tr>
<td width="70%" style="font-size: 14px; text-align: left;"> 
    <?php echo htmlspecialchars($productData['nom'] ?? 'nom'); ?> &nbsp;
</td>
<td width="30%" style="font-size: 16px; text-align: left;">  
    <?php echo "<b>Prix: " . htmlspecialchars($productData['prix'] ?? 'N/A') . " USD</b> "; ?> 
    &nbsp;&nbsp; &nbsp; &nbsp; 
  <br>  <font size="2"> Frais de livraison 5000 fc </font> 
  <br> Quantité 
  
  
  <select id="choix" name="choix" required
    style="width: 40%; 
           padding: 5px; 
           border: 1px solid #ccc; 
           border-radius: 10px; 
           background-color: #f9f9f9; 
           font-size: 14px;">
    <option value="1" disabled selected> 1 </option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
    
</select>
</td>
</tr>
</table>





<br>

<br>
<table border="0" align="left" width="100%">
<tr>
<td align="left" style="font-size: 14px; color :#505050 ; text-align: left; padding: 10px;">
<br>
<?php echo htmlspecialchars($productData['description'] ?? ''); ?>
</td>
</tr>
</table>




 <table border="0" align="left" width="100%">
        <tr>
            <td align="left" style="font-size: 14px; color: green; text-align: left; padding: 10px;">
                <b>Les engagements de Teksi-shop</b><br>
                <span style="font-size:12px;">
                    &nbsp;&nbsp;&nbsp;&nbsp;- Livraison rapide en moins de 5 heures<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;- Livraison partout à Kinshasa<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;- Nos produits sont garantis 5 jours <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;- Paiement à la livraison <br>
                </span>
            </td>
        </tr>
    </table>


<br><br>
<table border="0" width="90%" align="center">
<tr>
<td width="50%">
 
    
    
    <a href="https://wa.me/33659763677?text=<?php echo urlencode($defaultMessage); ?>" 
   style="display: inline-block; width: 150px; background-color: #25D366; color: white; padding: 10px; text-align: center; text-decoration: none; border-radius: 5px; font-family: Arial, sans-serif; font-size: 12px;">
   <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" style="width: 20px; height: 10px; vertical-align: middle; margin-right: 8px;">
   Contactez-nous
</a>

</td>


<td width="40%">


<a id="livraison-btn" 
  
   <a href="index-vide.php?page=precommande&prod=<?php echo $productData['id'] ?? ''; ?>&monprix=<?php echo $productData['prix'] ?? ''; ?>" 
   style="display: inline-block; width: 150px; background-color: #007BFF; color: white; font-size: 12px; font-weight: bold; text-align: center; text-decoration: none; padding: 10px 20px; border-radius: 5px; border: 1px solid #0056b3;">
   Faites vous livrer
</a>


</td>
</tr>
</table>

<br>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const livraisonBtn = document.getElementById('livraison-btn');
        const choixSelect = document.getElementById('choix');

        livraisonBtn.addEventListener('click', (e) => {
            e.preventDefault(); // Empêche la redirection immédiate
            const selectedQuantite = choixSelect.value;

            if (!selectedQuantite) {
                alert('Veuillez sélectionner une quantité avant de continuer.');
                return;
            }

            const prodId = "<?php echo $productData['id'] ?? ''; ?>";
            const prix = "<?php echo $productData['prix'] ?? ''; ?>";

            // Redirection avec la quantité incluse dans l'URL
            window.location.href = `index-vide.php?page=precommande&prod=${prodId}&monprix=${prix}&quantite=${selectedQuantite}`;
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        const swiper = new Swiper('.swiper-container', {
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    });
</script>
<br> <br> <br> <br>
<br> <br> <br> <br>
