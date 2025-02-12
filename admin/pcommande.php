<?php

ini_set('display_errors', 1);  // Affiche les erreurs à l'écran
error_reporting(E_ALL);   


$servername = "146.59.227.113";
$username = "TshivTony";
$password = "TsTon2023nc";
$dbname = "teksi";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Recherche Ajax pour les suggestions
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $stmt = $conn->prepare("SELECT id, nom, photo1 FROM produit WHERE nom LIKE ? LIMIT 5");
    $search_param = "%" . $search . "%";
    $stmt->bind_param("s", $search_param);
    $stmt->execute();
    $result = $stmt->get_result();

    $suggestions = [];
    while ($row = $result->fetch_assoc()) {
        $suggestions[] = [
            'id' => $row['id'],
            'nom' => $row['nom'],
            'photo' => "../images/" . $row['photo1']
        ];
    }
    echo json_encode($suggestions);
    exit;
}


$jours_semaine = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
    $mois_annee = [
        1 => 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 
        'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
    ];
    
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Commande</title>
    <style>
	
        .photo-preview {
            display: inline-block;
            margin-left: 10px;
            width: 50px;
            height: 50px;
            border: 1px solid #ccc;
            background-size: cover;
            background-position: center;
        }
        .suggestions {
            border: 1px solid #ccc;
            max-height: 150px;
            overflow-y: auto;
            position: absolute;
            background-color: white;
            width: 250px;
            z-index: 1000;
        }
        .suggestions div {
            padding: 8px;
            cursor: pointer;
        }
        .suggestions div:hover {
            background-color: #f0f0f0;
        }
        
        
        
        
        
        
          .navbar {
        overflow: hidden;
        background-color: #333;
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 1000;
    }

    .navbar a {
        float: left;
        display: block;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
    }

    .navbar a:hover {
        background-color: #ddd;
        color: black;
    }

    .navbar a.active {
        background-color: #04AA6D;
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
        .navbar.responsive {
            position: relative;
        }
        .navbar.responsive a.icon {
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

    body {
        margin-top: 50px; /* Pour laisser un espace pour le menu */
    }
    
    
        
        
        
        
        
        
        
        
        
        
        
        
    </style>
</head>
<body>
	
	
	<div class="navbar" id="myNavbar">
    <a href="#" class="active">Dashboard</a>
    <a href="dashboard.php?page=ajouter">Ajouter</a>
    <a href="dashboard.php?page=Liste">Liste Stock</a>
    <a href="dashboard.php?page=Mesvente">Mes Ventes</a>
    <a href="dashboard.php?page=commande">Nos Commande</a>
    <a href="pcommande.php">Poster une commande</a>
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
        &#9776;
    </a>
</div>



<?php
if(isset($_GET['id1'])) {
$page = isset($_GET['page']) ? $_GET['page'] : '';
$commande1 = isset($_GET['commande1']) ? $_GET['commande1'] : '';
$id1 = isset($_GET['id1']) ? $_GET['id1'] : '';
$commande2 = isset($_GET['commande2']) ? $_GET['commande2'] : '';
$id2 = isset($_GET['id2']) ? $_GET['id2'] : '';
$livraison_jour = isset($_GET['livraison_jour']) ? $_GET['livraison_jour'] : '';
$livraison_heure = isset($_GET['livraison_heure']) ? $_GET['livraison_heure'] : '';
$adresse = isset($_GET['adresse']) ? $_GET['adresse'] : '';
$reference = isset($_GET['reference']) ? $_GET['reference'] : '';
$nomclient = isset($_GET['nomclient']) ? $_GET['nomclient'] : '';
$telephone = isset($_GET['telephone']) ? $_GET['telephone'] : '';

$remarque = isset($_GET['remarque']) ? $_GET['remarque'] : '';

$quantite1 = isset($_GET['quantite1']) ? $_GET['quantite1'] : '';
$quantite2 = isset($_GET['quantite2']) ? $_GET['quantite2'] : '';

print(" <br> <center> <b>  Commande Enregistré  quantite1 $quantite1 </b>  </center>"); 

require("connecte.php"); 



$datecommande = date('Y-m-d H:i:s'); // Format: '2025-01-09 08:00:00'

// ID client (vous pouvez ajouter une logique pour récupérer l'ID client si nécessaire)
$idclient = 1; // Remplacer par la logique appropriée

// Création de la requête SQL pour insérer les données
$sql = "INSERT INTO commande (idproduit, quantite, phone, adresse, nom, livraisonjour, livraisonheur, datecommande, idclient)
        VALUES ('$id1','$quantite1', '$telephone','$adresse', '$nomclient', '$livraison_jour', '$livraison_heure', '$datecommande', '$idclient')";

print("<br> sql $sql <br> "); 


if(isset($id2)){
$sql1 = "INSERT INTO commande (idproduit, quantite, phone, adresse, nom, livraisonjour, livraisonheur, datecommande, idclient)
        VALUES ('$id2','$quantite2', '$telephone','$adresse', '$nomclient', '$livraison_jour', '$livraison_heure', '$datecommande', '$idclient')";

if ($conn->query($sql1) === TRUE) {
    echo "Nouvelle commande insérée avec succès";
}
	
	
}


// Exécution de la requête
if ($conn->query($sql) === TRUE) {
    echo "Nouvelle commande insérée avec succès";
} else {
    echo "Erreur : " . $sql . "<br>" . $conn->error;
}



} else {

?>
	
	
    <form method="get">
		
		<input type="hidden" name="page" value="pcommande"> 
        <table border="0" width="100%">
            <tr>
                <td width="5%"> </td>
                <td>
                    <input type="text" id="commande1" name="commande1" size="18" placeholder="votre commande 1" oninput="searchProduct(this, 'preview1')" autocomplete="off" required >
                    <input type="hidden" id="id1" name="id1">
                    <div id="preview1" class="photo-preview"></div>
                    <div id="suggestions1" class="suggestions"></div>
                   <br>
                    
                    <select name="quantite1" id="quantite1">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						</select>
						
						<br>
                    
                    
                </td>
            </tr>
            <tr>
                <td> </td>
                <td>
                    <input type="text" id="commande2" name="commande2" size="18" placeholder="votre commande 2" oninput="searchProduct(this, 'preview2')" autocomplete="off">
                   <input type="hidden" id="id2" name="id2">
                    <div id="preview2" class="photo-preview"></div>
                    <div id="suggestions2" class="suggestions"></div>
                    <br>
                       
                       <select name="quantite2" id="quantite1">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						</select>
                </td>
            </tr>
            <!-- Autres champs du formulaire -->
        </table>
        
        
 <table border="0" width="100%">

<tr>
<td width="5%">  </td>
<td> 
	 <br>
<select id="livraison_jour" name="livraison_jour" required>
            <option value="" disabled selected>Choisissez le jour de la livraison</option>
            <?php
            // Générer les 7 prochains jours
            for ($i = 0; $i < 7; $i++) {
                $date = strtotime("+$i day");
                $jour_nom = $jours_semaine[date('w', $date)]; // Nom du jour
                $jour = date('d', $date);                   // Numéro du jour
                $mois = $mois_annee[date('n', $date)];       // Nom du mois
                $annee = date('Y', $date);                  // Année
                $date_formattee = "$jour_nom  $jour $mois $annee";
                echo "<option value='$date_formattee'>$date_formattee</option>";
            }
            ?>
        </select>
        <br>
  <select id="livraison_heure" name="livraison_heure" required>
            <option value="" disabled selected>Choisissez l'heure de la livraison</option>
            <?php
            for ($heure = 6; $heure < 20; $heure++) {
                for ($minute = 0; $minute < 60; $minute += 30) {
                    $heure_formatte = sprintf("%02d", $heure);
                    $minute_formatte = sprintf("%02d", $minute);
                    echo "<option value='$heure_formatte:$minute_formatte'>$heure_formatte:$minute_formatte</option>";
                }
            }
            ?>
        </select>

</td>
</td>

<tr>
<td>  </td>
<td><input type="text" name="adresse" size="30" placeholder="Votre adresse" required> </td>
</td>

<tr>
<td> </td>
<td>  <input type="text" name="reference" size="30" placeholder="Reference Adresse"> </td>
</td>




<tr>
<td> </td>
<td> <input type="text" name="nomclient" size="30" placeholder="Nom client">  </td>
</td>

<tr>
<td>  </td>
<td> <input type="text" name="telephone" size="12"  placeholder="telephone" required> </td>
</td>


<tr>
<td> </td>
<td> 

<textarea name="remarque" rows="5" cols="40" placeholder="Écrivez votre remarque ici..."></textarea>
</td>
</td>



</table>       
        
        
        
        
        
        
        
        
        
        
        
        
        <input type="submit" value="Envoyer">
    </form>

<script>


function searchProduct(input, previewId) {
    const query = input.value;
    const previewDiv = document.getElementById(previewId);
    const suggestionsDiv = document.getElementById('suggestions' + previewId.slice(-1));
    const hiddenInput = document.getElementById('id' + previewId.slice(-1)); // ID caché

    if (query.length < 2) {
        suggestionsDiv.innerHTML = '';
        previewDiv.style.backgroundImage = '';
        hiddenInput.value = ''; // Vider le champ caché
        return;
    }

    fetch(`?search=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            suggestionsDiv.innerHTML = '';
            if (data.length > 0) {
                data.forEach(item => {
                    const suggestionItem = document.createElement('div');
                    suggestionItem.textContent = item.nom;
                    suggestionItem.onclick = function () {
                        input.value = item.nom;
                        hiddenInput.value = item.id; // Assigner l'ID caché
                        previewDiv.style.backgroundImage = `url('${item.photo}')`;
                        suggestionsDiv.innerHTML = ''; // Vider les suggestions
                    };
                    suggestionsDiv.appendChild(suggestionItem);
                });
            }
        })
        .catch(error => console.error('Erreur:', error));
}



</script>

    
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

 
    
</body>
</html>

<?php
    }

     ?>
