<?php
// Paramètres de connexion
require("connecte.php"); 

$uploadDir = "/var/www/teksi/images/";

// https://teksi.allo-teksi.xyz/images/images1.png

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Échapper les valeurs pour éviter les injections SQL
    $nom = $conn->real_escape_string($_POST['nom']);
    $description = $conn->real_escape_string(substr($_POST['description'], 0, 250));
    $prix = $conn->real_escape_string($_POST['prix']);
    $quantite = (int)$_POST['quantite'];

    // Gestion des fichiers
    $photo1 = isset($_FILES['photo1']['name']) && !empty($_FILES['photo1']['name']) ? $uploadDir . basename($_FILES['photo1']['name']) : null;
    $photo2 = isset($_FILES['photo2']['name']) && !empty($_FILES['photo2']['name']) ? $uploadDir . basename($_FILES['photo2']['name']) : null;
    $photo3 = isset($_FILES['photo3']['name']) && !empty($_FILES['photo3']['name']) ? $uploadDir . basename($_FILES['photo3']['name']) : null;
    $video1 = isset($_FILES['video1']['name']) && !empty($_FILES['video1']['name']) ? $uploadDir . basename($_FILES['video1']['name']) : null;
    $video2 = isset($_FILES['video2']['name']) && !empty($_FILES['video2']['name']) ? $uploadDir . basename($_FILES['video2']['name']) : null;

    // Déplacer les fichiers téléchargés
    if ($photo1 && !move_uploaded_file($_FILES['photo1']['tmp_name'], $photo1)) {
        echo "Erreur lors du téléchargement de la photo 1.";
    }
    if ($photo2 && !move_uploaded_file($_FILES['photo2']['tmp_name'], $photo2)) {
        echo "Erreur lors du téléchargement de la photo 2.";
    }
    if ($photo3 && !move_uploaded_file($_FILES['photo3']['tmp_name'], $photo3)) {
        echo "Erreur lors du téléchargement de la photo 3.";
    }
    if ($video1 && !move_uploaded_file($_FILES['video1']['tmp_name'], $video1)) {
        echo "Erreur lors du téléchargement de la vidéo 1.";
    }
    if ($video2 && !move_uploaded_file($_FILES['video2']['tmp_name'], $video2)) {
        echo "Erreur lors du téléchargement de la vidéo 2.";
    }

    // Insertion du produit dans la table 'produit'
    $sqlProduit = "INSERT INTO produit (nom, description, prix, photo1, photo2, photo3, video1, video2, quantite) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtProduit = $conn->prepare($sqlProduit);
    $stmtProduit->bind_param("ssdsssssi", $nom, $description, $prix, $photo1, $photo2, $photo3, $video1, $video2, $quantite);

    if ($stmtProduit->execute()) {
        // Récupérer l'ID du produit inséré
        $produit_id = $conn->insert_id;

        // Si des tailles ont été envoyées, insérer dans 'produit_taille'
        if (!empty($_POST['taille']) && is_array($_POST['taille']) && is_array($_POST['quantite_taille'])) {
            $tailles = $_POST['taille']; // Tableau des tailles
            $quantites = $_POST['quantite_taille']; // Tableau des quantités

            // Vérifier que les deux tableaux ont la même taille
            if (count($tailles) === count($quantites)) {
                $sqlTaille = "INSERT INTO produit_taille (produit_id, taille, quantite) VALUES (?, ?, ?)";
                $stmtTaille = $conn->prepare($sqlTaille);

                // Boucle pour insérer chaque taille et quantité
                foreach ($tailles as $index => $taille) {
                    $quantiteTaille = (int)$quantites[$index];
                    $stmtTaille->bind_param("isi", $produit_id, $taille, $quantiteTaille);
                    $stmtTaille->execute();
                }

                $stmtTaille->close();
            } else {
                echo "Erreur : Le nombre de tailles et de quantités ne correspond pas.";
            }
        }

        echo "Produit ajouté avec succès !";
    } else {
        echo "Erreur lors de l'insertion du produit : " . $conn->error;
    }

    // Fermeture de la connexion
    $stmtProduit->close();
    $conn->close();
}

/*
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $conn->real_escape_string($_POST['nom']);
    $description = $conn->real_escape_string(substr($_POST['description'], 0, 250));
    $quantite = (int)$_POST['quantite'];
    $prix = $conn->real_escape_string($_POST['prix']);
    
    // Vérifiez si les fichiers existent avant de les traiter
    $photo1 = isset($_FILES['photo1']['name']) && !empty($_FILES['photo1']['name']) ? $uploadDir . basename($_FILES['photo1']['name']) : null;
    $photo2 = isset($_FILES['photo2']['name']) && !empty($_FILES['photo2']['name']) ? $uploadDir . basename($_FILES['photo2']['name']) : null;
    $photo3 = isset($_FILES['photo3']['name']) && !empty($_FILES['photo3']['name']) ? $uploadDir . basename($_FILES['photo3']['name']) : null;
    $video1 = isset($_FILES['video1']['name']) && !empty($_FILES['video1']['name']) ? $uploadDir . basename($_FILES['video1']['name']) : null;
    $video2 = isset($_FILES['video2']['name']) && !empty($_FILES['video2']['name']) ? $uploadDir . basename($_FILES['video2']['name']) : null;

    // Déplacez les fichiers si présents
    if ($photo1 && !move_uploaded_file($_FILES['photo1']['tmp_name'], $photo1)) {
        echo "Erreur lors du téléchargement de la photo 1.";
    }
    if ($photo2 && !move_uploaded_file($_FILES['photo2']['tmp_name'], $photo2)) {
        echo "Erreur lors du téléchargement de la photo 2.";
    }
    if ($photo3 && !move_uploaded_file($_FILES['photo3']['tmp_name'], $photo3)) {
        echo "Erreur lors du téléchargement de la photo 3.";
    }
    if ($video1 && !move_uploaded_file($_FILES['video1']['tmp_name'], $video1)) {
        echo "Erreur lors du téléchargement de la vidéo 1.";
    }
    if ($video2 && !move_uploaded_file($_FILES['video2']['tmp_name'], $video2)) {
        echo "Erreur lors du téléchargement de la vidéo 2.";
    }

    // Insertion dans la base de données
    
	/*
	$sql = "INSERT INTO produit (nom, description, prix, photo1, photo2, photo3, video1, video2, quantite)
            VALUES ('$nom', '$description', '$prix', '$photo1', '$photo2', '$photo3', '$video1', '$video2', $quantite)";
    
    if ($conn->query($sql) === TRUE) {
        echo "Produit ajouté avec succès !";
    } else {
        echo "Erreur : " . $sql . "<br>" . $conn->error;
    }
	
	*/
	
	
	
 // Insertion dans la table produit
   /* $sqlProduit = "INSERT INTO produit (nom, description, prix, photo1, photo2, photo3, video1, video2, quantite) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmtProduit = $conn->prepare($sqlProduit);
    $stmtProduit->bind_param("ssdsssssi", $nom, $description, $prix, $photo1, $photo2, $photo3, $video1, $video2, $quantite);

    if($stmtProduit->execute()) {
        $produit_id = $conn->insert_id; // Récupération de l'ID du produit inséré

        // Récupération des tailles et quantités (si plusieurs tailles sont envoyées sous forme de tableau)
       
       
      // if (!empty($_POST['taille']) && is_array($_POST['taille']) && is_array($_POST['quantite_taille'])) {
   
/*    if (!empty($_POST['taille'])) {
    $tailles = $_POST['taille']; // Tableau des tailles
    $quantites = $_POST['quantite_taille']; // Tableau des quantités associées
    $Myquantite = $_POST['quantite']; // Tableau des quantités associées

    // Vérification que les deux tableaux ont la même taille
 
        $sqlTaille = "INSERT INTO produit_taille (produit_id, taille, quantite) VALUES (?, ?, ?)";
        $stmtTaille = $conn->prepare($sqlTaille);

print("<br> ********** <br> ******* sqlTaille $sqlTaille -  <br> quantites  $quantites -<br> taille $tailles  - quantiteTaille $quantiteTaille <br> Myquantite $Myquantite  <br>  - produit_id $produit_id<br>  ******** <br>"); 
       
          //  $quantiteTaille = (int)$quantites[$key];
            $stmtTaille->bind_param("isi", $produit_id, $taille, $Myquantite);
          //  $stmtTaille->execute();
        

        $stmtTaille->close();
    } else {
        echo "Erreur : Nombre de tailles et de quantités ne correspond pas.";
    }

       
       
       /*
       
        if (!empty($_POST['taille'])) {
            $tailles = $_POST['taille']; // Tableau des tailles
            $quantites = $_POST['quantite_taille']; // Tableau des quantités associées
            $Myquantites = $_POST['quantite']; // Tableau des quantités associées

print(" <br> ************** <br>  tailles $tailles quantites $quantites   produit_taille produit_taille  - Myquantites $Myquantites  <br> *************  <br> ");
 
 print("  <br> ***** <br>  tailles  $tailles <br> quantites $quantites  <br>  **************  <br>   "); 
 
            // Préparation de l'insertion dans produit_taille
            $sqlTaille = "INSERT INTO produit_taille (produit_id, taille, quantite) VALUES (?, ?, ?)";
            $stmtTaille = $conn->prepare($sqlTaille);       
             // $stmtTaille->bind_param("isi", $produit_id, $taille, $quantiteTaille);
                $stmtTaille->bind_param("isi", $produit_id, $taille, $Myquantites);
                $stmtTaille->execute();
       

            $stmtTaille->close();
        }

        echo "Produit et tailles insérés avec succès !";
    } else {
        echo "Erreur lors de l'insertion du produit : " . $conn->error;
    }

    // Fermeture des connexions
    $stmtProduit->close();
    $conn->close();	
	
	
	
	
	
}	
}*/
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un produit</title>
    <style>
    /* Style général pour le conteneur des suggestions */
    #suggestions {
        position: absolute;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-height: 200px;
        overflow-y: auto;
        width: 50%; /* Pour que la suggestion soit alignée avec l'input */
        z-index: 9999;
        display: none; /* Par défaut, les suggestions sont cachées */
        margin-top: 5px; /* Un petit espace entre l'input et les suggestions */
        padding: 10px;
    }

    /* Style pour chaque élément de suggestion */
    #suggestions div {
        padding: 8px;
        font-size: 14px;
        cursor: pointer;
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }

    /* Changer le fond lorsque l'élément est survolé */
    #suggestions div:hover {
        background-color: #f0f0f0;
    }

    /* Option de survol d'une suggestion (lorsque l'utilisateur passe la souris dessus) */
    #suggestions div.selected {
        background-color: #e0e0e0;
    }

    /* Ajouter un léger effet de bordure au champ de recherche */
    #nom {
        padding: 10px;
        width: 50%;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
    }

    #nom:focus {
        border-color: #007BFF; /* Bordure bleue lorsque le champ est sélectionné */
        outline: none;
    }
</style>

</head>
<body>
    <h1>Ajouter un produit</h1>
    <form action="" method="post" enctype="multipart/form-data">
        

 
      
      
   
    <table border="0" width="90%">

        <tr>
        <td width="30%"> <label for="nom">Nom du produit :</label></td>
            <td>
                <input type="text" id="nom" name="nom" required onkeyup="fetchSuggestions()">
                <div id="suggestions" style="border: 1px solid #ccc; max-height: 150px; overflow-y: auto; display: none;"></div>
            </td>
        </tr>  

        <tr>
            <td>  <label for="description">Description :</label></td>
            <td>
				 <textarea id="description" name="description" maxlength="250" required></textarea> 
            
            </td>
        </tr>   

        <tr>
            <td>
                <label for="photo1" class="file-label">Parcourir image</label>
                <input type="file" id="photo1" name="photo1" accept="image/*">
            </td>
            <td>
                <label for="photo2" class="file-label">Parcourir image</label>
                <input type="file" id="photo2" name="photo2" accept="image/*">
            </td>
        </tr>

        <tr>
            <td>
                <label for="photo3" class="file-label">Parcourir image</label>
                <input type="file" id="photo3" name="photo3" accept="image/*">
            </td>
            <td>
                <label for="video2" class="file-label">Parcourir video</label>
                <input type="file" id="video2" name="video2" accept="video/*">
            </td>
        </tr>

<tr>
<td> Produit a taille unique </td>
<td>     

 <form id="statusForm">
                        
							        <select name="maquantite" id="pet-select">

                                <option selected >Choisir</option>
                                <option value="1"  > OUI </option>
                                <option value="2" > NON </option>
	</form>
	
	


</td>

</tr>



        <tr>
  <?php
  
 /* 
  
if($maquantite=='1'){
?>  

		   <td> 
                <label for="quantite">Quantité :</label>
                <input type="number" id="quantite" name="quantite" required>
            </td>
            <td> 
                <label for="prix">Prix :</label>
                <input type="text" id="prix" name="prix" required>
            </td>
<?php
}
if($maquantite=='2'){

?>


 <td> 
                <label for="quantite">Quantité :</label>
                <input type="number" id="quantite" name="quantite" required>
            </td>
            <td> 
                <label for="prix">Prix :</label>
                <input type="text" id="prix" name="prix" required>
				
				
				
				 <label for="prix">Taille  :</label>
                <input type="text" id="taille" name="taille" required>
            </td>

<?php
  }

*/
?>



        </tr>
<tr id="quantite-container"></tr>

    </table>
      

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const selectElement = document.getElementById("pet-select");
        const quantiteContainer = document.getElementById("quantite-container");

        selectElement.addEventListener("change", function () {
            let selectedValue = selectElement.value;
            let content = "";

            if (selectedValue === "1") {
                content = `
                    <td>
                        <label for="quantite">Quantité :</label>
                        <input type="number" id="quantite" name="quantite" required>
                    </td>
                    <td>
                        <label for="prix">Prix :</label>
                        <input type="text" id="prix" name="prix" required>
                    </td>
                `;
            } else if (selectedValue === "2") {
                content = `
                    <td>
                        <label for="quantite">Quantité :</label>
                        <input type="number" id="quantite" name="quantite" required>
                    </td>
                    <td>
                        <label for="prix">Prix :</label>
                        <input type="text" id="prix" name="prix" required>
                        <label for="taille">Taille :</label>
                        <input type="text" id="taille" name="taille" required>
                    </td>
                `;
            }
            
            quantiteContainer.innerHTML = content;
        });
    });


    document.addEventListener("DOMContentLoaded", function () {
        const inputField = document.getElementById("nom");
        const suggestionsDiv = document.getElementById("suggestions");
        
        // Fonction pour obtenir les suggestions via AJAX
        function fetchSuggestions() {
            var input = inputField.value;

            if (input.length > 2) {  // Afficher les suggestions seulement si l'utilisateur tape plus de 2 caractères
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'search_products.php?q=' + input, true);
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        var suggestions = JSON.parse(xhr.responseText);
                        suggestionsDiv.innerHTML = ''; // Réinitialiser les suggestions

                        if (suggestions.length > 0) {
                            suggestionsDiv.style.display = 'block'; // Afficher la liste des suggestions
                            suggestions.forEach(function (suggestion) {
                                var div = document.createElement('div');
                                div.innerHTML = suggestion;
                                div.classList.add('suggestion-item'); // Ajout de la classe pour le style

                                // Fonction au clic
                                div.onclick = function () {
                                    inputField.value = suggestion;
                                    suggestionsDiv.style.display = 'none'; // Masquer les suggestions après sélection
                                };

                                // Ajout de l'élément à la liste des suggestions
                                suggestionsDiv.appendChild(div);
                            });
                        } else {
                            suggestionsDiv.style.display = 'none'; // Cacher la liste si aucune suggestion
                        }
                    }
                };
                xhr.send();
            } else {
                suggestionsDiv.style.display = 'none'; // Cacher les suggestions si moins de 3 caractères
            }
        }

        // Ajouter un événement pour détecter quand l'utilisateur tape dans le champ
        inputField.addEventListener('keyup', fetchSuggestions);

        // Ajouter un événement de survol pour surligner les éléments de suggestion
        suggestionsDiv.addEventListener('mouseover', function (event) {
            if (event.target && event.target.nodeName === "DIV") {
                // Retirer la classe 'selected' de tous les éléments
                let items = suggestionsDiv.querySelectorAll('div');
                items.forEach(item => item.classList.remove('selected'));

                // Ajouter la classe 'selected' à l'élément survolé
                event.target.classList.add('selected');
            }
        });

        // Ajouter un événement pour sélectionner une suggestion au clic
        suggestionsDiv.addEventListener('click', function (event) {
            if (event.target && event.target.nodeName === "DIV") {
                inputField.value = event.target.innerHTML;
                suggestionsDiv.style.display = 'none';
            }
        });
    });
</script>

      
      

      <center> 

        <button type="submit">Ajouter le produit</button>
        </center>
    </form>
</body>
</html>
