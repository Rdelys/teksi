<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Contact</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        form {
            width: 80%;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="text"], textarea, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 15px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<br><br>
<br><br>
<?php
    $monprix = $_GET["monprix"] ?? '';
    $prod = $_GET["prod"] ?? '';

    // Tableaux personnalisés pour les jours et mois en français
    $jours_semaine = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
    $mois_annee = [
        1 => 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 
        'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
    ];
?>
    <form action="index-vide.php" method="get">
        <input type="hidden" id="page" name="page" value="traitement">
        <input type="hidden" id="monprix" name="monprix" value="<?php echo htmlspecialchars($monprix); ?>">
        <input type="hidden" id="produit" name="produit" value="<?php echo htmlspecialchars($prod); ?>">

        <label for="telephone">Téléphone :</label>
        <input type="text" id="telephone" name="telephone" required>

        <label for="adresse">Adresse :</label>
        <textarea id="adresse" name="adresse" rows="4" required></textarea>

        <label for="livraison_jour">Quand souhaitez-vous être livré ?</label>
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
                $date_formattee = "$jour_nom $jour $mois $annee";
                echo "<option value='$date_formattee'>$date_formattee</option>";
            }
            ?>
        </select>

        <label for="livraison_heure">À quelle heure souhaitez-vous être livré ?</label>
        <select id="livraison_heure" name="livraison_heure" required>
            <option value="" disabled selected>Choisissez l'heure de la livraison</option>
            <?php
            for ($heure = 9; $heure < 19; $heure++) {
                for ($minute = 0; $minute < 60; $minute += 30) {
                    $heure_formatte = sprintf("%02d", $heure);
                    $minute_formatte = sprintf("%02d", $minute);
                    echo "<option value='$heure_formatte:$minute_formatte'>$heure_formatte:$minute_formatte</option>";
                }
            }
            ?>
        </select>

        <input type="submit" value="Envoyer">
    </form>
</body>
</html>

    
    
    
    
</body>
</html>
