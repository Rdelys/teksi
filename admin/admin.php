<?php
// Connexion à la base de données
$servername = "146.59.227.113";
$username = "TshivTony";
$password = "TsTon2023nc";
$dbname = "teksi";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer le chiffre d'affaires journalier
$sql_chiffre_affaire_journalier = "SELECT SUM(prix) AS total_journalier FROM commande WHERE etatcommande = 'vente' AND DATE(dateVente) = CURDATE()";
$result_journalier = $conn->query($sql_chiffre_affaire_journalier);
$row_journalier = $result_journalier->fetch_assoc();
$chiffre_affaire_journalier = $row_journalier ? $row_journalier['total_journalier'] : 0;

// Récupérer le chiffre d'affaires des 7 derniers jours
$sql_chiffre_affaire_7_jours = "SELECT SUM(prix) AS total_7_jours FROM commande WHERE etatcommande = 'vente' AND dateVente > NOW() - INTERVAL 7 DAY";
$result_7_jours = $conn->query($sql_chiffre_affaire_7_jours);
$row_7_jours = $result_7_jours->fetch_assoc();
$chiffre_affaire_7_jours = $row_7_jours ? $row_7_jours['total_7_jours'] : 0;

// Récupérer le chiffre d'affaires du mois en cours
$sql_chiffre_affaire_mois = "SELECT SUM(prix) AS total_mois FROM commande WHERE etatcommande = 'vente' AND MONTH(dateVente) = MONTH(CURDATE())";
$result_mois = $conn->query($sql_chiffre_affaire_mois);
$row_mois = $result_mois->fetch_assoc();
$chiffre_affaire_mois = $row_mois ? $row_mois['total_mois'] : 0;

// Récupérer le chiffre d'affaires des 6 derniers mois
$sql_chiffre_affaire_6_mois = "SELECT SUM(prix) AS total_6_mois FROM commande WHERE etatcommande = 'vente' AND dateVente > NOW() - INTERVAL 6 MONTH";
$result_6_mois = $conn->query($sql_chiffre_affaire_6_mois);
$row_6_mois = $result_6_mois->fetch_assoc();
$chiffre_affaire_6_mois = $row_6_mois ? $row_6_mois['total_6_mois'] : 0;

// Meilleure vente mensuelle (produit le plus vendu ce mois)
$sql_meilleure_vente_mois = "SELECT idproduit, SUM(quantite) AS total_quantite FROM commande WHERE etatcommande = 'vente' AND MONTH(dateVente) = MONTH(CURDATE()) GROUP BY idproduit ORDER BY total_quantite DESC LIMIT 1";
$result_meilleure_vente_mois = $conn->query($sql_meilleure_vente_mois);
$row_meilleure_vente_mois = $result_meilleure_vente_mois->fetch_assoc();
$meilleure_vente_mois = $row_meilleure_vente_mois ? $row_meilleure_vente_mois['idproduit'] : 'Aucune vente';

// Meilleure vente de la semaine (produit le plus vendu cette semaine)
$sql_meilleure_vente_semaine = "SELECT idproduit, SUM(quantite) AS total_quantite FROM commande WHERE etatcommande = 'vente' AND WEEK(dateVente) = WEEK(CURDATE()) GROUP BY idproduit ORDER BY total_quantite DESC LIMIT 1";
$result_meilleure_vente_semaine = $conn->query($sql_meilleure_vente_semaine);
$row_meilleure_vente_semaine = $result_meilleure_vente_semaine->fetch_assoc();
$meilleure_vente_semaine = $row_meilleure_vente_semaine ? $row_meilleure_vente_semaine['idproduit'] : 'Aucune vente';

// Meilleure vente de la journée (produit le plus vendu aujourd'hui)
$sql_meilleure_vente_jour = "SELECT idproduit, SUM(quantite) AS total_quantite FROM commande WHERE etatcommande = 'vente' AND DATE(dateVente) = CURDATE() GROUP BY idproduit ORDER BY total_quantite DESC LIMIT 1";
$result_meilleure_vente_jour = $conn->query($sql_meilleure_vente_jour);
$row_meilleure_vente_jour = $result_meilleure_vente_jour->fetch_assoc();
$meilleure_vente_jour = $row_meilleure_vente_jour ? $row_meilleure_vente_jour['idproduit'] : 'Aucune vente';

// Top 5 des produits les plus vendus cette semaine
$sql_top_5_semaine = "SELECT idproduit, SUM(quantite) AS total_quantite FROM commande WHERE etatcommande = 'vente' AND WEEK(dateVente) = WEEK(CURDATE()) GROUP BY idproduit ORDER BY total_quantite DESC LIMIT 5";
$result_top_5_semaine = $conn->query($sql_top_5_semaine);

// Flop 5 des produits les moins vendus cette semaine
$sql_flop_5_semaine = "SELECT idproduit, SUM(quantite) AS total_quantite FROM commande WHERE etatcommande = 'vente' AND WEEK(dateVente) = WEEK(CURDATE()) GROUP BY idproduit ORDER BY total_quantite ASC LIMIT 5";
$result_flop_5_semaine = $conn->query($sql_flop_5_semaine);
?>

<!-- Affichage des résultats -->
<div style="text-align: center; font-size: 24px; font-weight: bold; color: #333;">
    Admin Generale
</div>

<table border="0" align="center" width="88%" style="border-collapse: collapse; border: 0px solid #444; border-radius: 30px; overflow: hidden;">
    <tr style="background-color: #f9f9f9;">
        <td width="50%" style="font-size: 15px; color: #555;">&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; Chiffre d'affaire Journalier</td>
        <td style="font-size: 12px; color: #555;"><?php echo $chiffre_affaire_journalier; ?>USD</td>
    </tr>
    <tr style="background-color: #eaeaea;">
        <td style="font-size: 15px; color: #555;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Chiffre d'affaire 7 derniers jours</td>
        <td style="font-size: 12px; color: #555;"><?php echo $chiffre_affaire_7_jours; ?>USD</td>
    </tr>
    <tr style="background-color: #f9f9f9;">
        <td style="font-size: 15px; color: #555;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Chiffre d'affaire du mois en cours</td>
        <td style="font-size: 12px; color: #555;"><?php echo $chiffre_affaire_mois; ?>USD</td>
    </tr>
    <tr style="background-color: #eaeaea;">
        <td style="font-size: 15px; color: #555;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Chiffre d'affaire des 6 derniers mois</td>
        <td style="font-size: 12px; color: #555;"><?php echo $chiffre_affaire_6_mois; ?>USD</td>
    </tr>
    <tr style="background-color: #f9f9f9;">
        <td style="font-size: 15px; color: #555;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Meilleure vente mensuelle</td>
        <td style="font-size: 12px; color: #555;"><?php echo $meilleure_vente_mois; ?></td>
    </tr>
    <tr style="background-color: #eaeaea;">
        <td style="font-size: 15px; color: #555;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Meilleure vente de la semaine</td>
        <td style="font-size: 12px; color: #555;"><?php echo $meilleure_vente_semaine; ?></td>
    </tr>
    <tr style="background-color: #f9f9f9;">
        <td style="font-size: 15px; color: #555;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Meilleure vente de la journée</td>
        <td style="font-size: 12px; color: #555;"><?php echo $meilleure_vente_jour; ?></td>
    </tr>
</table>

<br>
<table border="2" align="center" width="80%" style="border-collapse: collapse; border: 0px solid #444; border-radius: 10px; overflow: hidden;">
    <tr><td>Top 5 des meilleures ventes de la semaine</td></tr>
    <?php while ($row_top = $result_top_5_semaine->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row_top['idproduit']; ?> - Quantité: <?php echo $row_top['total_quantite']; ?></td>
        </tr>
    <?php } ?>
    <tr><td>Flop 5 des produits les moins vendus cette semaine</td></tr>
    <?php while ($row_flop = $result_flop_5_semaine->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row_flop['idproduit']; ?> - Quantité: <?php echo $row_flop['total_quantite']; ?></td>
        </tr>
    <?php } ?>
</table>

<?php
$conn->close();
?>
