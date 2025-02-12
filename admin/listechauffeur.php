<?php
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

// Requête pour récupérer les chauffeurs sans l'état
$sql = "SELECT id, nom, prenom, telephone FROM chauffeur";
$result = $conn->query($sql);

// Affichage des chauffeurs
if ($result->num_rows > 0) {
    echo "<table border='0' width='100%'>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Téléphone</th>
                <th>Action</th>
            
            </tr>";
    
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["nom"] . "</td>
                <td>" . $row["prenom"] . "</td>
                <td>" . $row["telephone"] . "</td>
                <td>
                    <a href='dashboard.php?page=voir_chauffeur&id=" . $row["id"] . "'>Plus</a> |
                    <a href='dashboard.php?page=modifier_chauffeur&id=" . $row["id"] . "'>Modifier</a> | 
                    <a href='dashboard.php?page=activer&id=" . $row["id"] . "'> Activer </a> | 
                    <a href='dashboard.php?page=desactiver&id=" . $row["id"] . "'> desactiver  </a>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Aucun chauffeur trouvé.";
}

$conn->close();
?>
