<?php
require("connecte.php"); // Inclusion de la connexion à la base

// Récupérer toutes les ventes
$query = "SELECT * FROM ventes ORDER BY date DESC";
$ventes = $conn->query($query);

// Récupérer les produits les plus vendus sur différentes périodes
function getTopVentes($conn, $interval) {
    $query = "SELECT nomproduit, SUM(nombre) AS total_vendu
              FROM ventes 
              WHERE date >= DATE_SUB(NOW(), INTERVAL $interval)
              GROUP BY nomproduit
              ORDER BY total_vendu DESC
              LIMIT 5";
    return $conn->query($query);
}

$top7 = getTopVentes($conn, '7 DAY');
$top30 = getTopVentes($conn, '30 DAY');
$topDay = getTopVentes($conn, '1 DAY');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Ventes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 0;
            color: #333;
        }
        h2, h3 {
            text-align: center;
            color: #222;
        }
        .table-container {
            overflow-x: auto;
            margin-top: 20px;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #343a40;
            color: white;
        }
        .top-products {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        .top-products div {
            width: 30%;
            min-width: 250px;
            padding: 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .list-group {
            list-style-type: none;
            padding: 0;
        }
        .list-group-item {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            background: white;
        }
        .list-group-item:last-child {
            border-bottom: none;
        }
        @media (max-width: 768px) {
            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
            .top-products {
                flex-direction: column;
                align-items: center;
            }
            .top-products div {
                width: 80%;
                margin-bottom: 15px;
            }
        }
    </style>
</head>
<body>
    <h2>Liste des ventes</h2>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Client</th>
                    <th>Numéro</th>
                    <th>Livreur</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $ventes->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nomproduit']) ?></td>
                        <td><?= htmlspecialchars($row['nombre']) ?></td>
                        <td><?= htmlspecialchars($row['client']) ?></td>
                        <td><?= htmlspecialchars($row['numero']) ?></td>
                        <td><?= htmlspecialchars($row['livreur']) ?></td>
                        <td><?= htmlspecialchars($row['date']) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <h3>Produits les plus vendus</h3>
    <div class="top-products">
        <div>
            <h5>Les 7 derniers jours</h5>
            <ul class="list-group">
                <?php while ($row = $top7->fetch_assoc()) { ?>
                    <li class="list-group-item"> <?= $row['nomproduit'] ?> (<?= $row['total_vendu'] ?>) </li>
                <?php } ?>
            </ul>
        </div>
        <div>
            <h5>Les 30 derniers jours</h5>
            <ul class="list-group">
                <?php while ($row = $top30->fetch_assoc()) { ?>
                    <li class="list-group-item"> <?= $row['nomproduit'] ?> (<?= $row['total_vendu'] ?>) </li>
                <?php } ?>
            </ul>
        </div>
        <div>
            <h5>Aujourd'hui</h5>
            <ul class="list-group">
                <?php while ($row = $topDay->fetch_assoc()) { ?>
                    <li class="list-group-item"> <?= $row['nomproduit'] ?> (<?= $row['total_vendu'] ?>) </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</body>
</html>
