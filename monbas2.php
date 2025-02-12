<?php
// Définir la page actuelle (avec sécurité contre les caractères indésirables)
$currentPage = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : ''; 

// Fonction pour obtenir l'icône correcte
function getIcon($page, $currentPage, $icons, $alias) {
    if ($page === $currentPage || (isset($alias[$page]) && in_array($currentPage, $alias[$page]))) {
        return $icons[$page]['active'];
    }
    return $icons[$page]['default'];
}

// Définition des icônes pour chaque page
$icons = [
    'accueil' => ['default' => 'image2/accueil.png', 'active' => 'image2/accueil-clic.png'],
    'recherche' => ['default' => 'image2/recherche.png', 'active' => 'image2/recherche-clic.png'],
    'mon compte' => ['default' => 'image2/moi.png', 'active' => 'image2/moi-clic.png'],
    'panier' => ['default' => 'image2/panier.png', 'active' => 'image2/panier-clic.png'],
];

// Alias pour des pages similaires
$alias = [
    'accueil' => ['home', 'index'],
    'recherche' => ['search'],
    'mon compte' => ['account', 'profile'],
    'panier' => ['cart'],
];
?>

<div class="footer-menu">
    <a href="index.php?page=accueil">
        <img src="<?= getIcon('accueil', $currentPage, $icons, $alias); ?>" > Accueil
    </a>
    <a href="index.php?page=recherche">
        <img src="<?= getIcon('recherche', $currentPage, $icons, $alias); ?>" > Recherche
    </a>
    <a href="index-vide1.php?page=compte">
        <img src="<?= getIcon('mon compte', $currentPage, $icons, $alias); ?>" > Vous
    </a>
    <a href="index-vide1.php?page=panier">
        <img src="<?= getIcon('panier', $currentPage, $icons, $alias); ?>" > Panier
    </a>
</div>

<style>
.footer-menu {
    display: flex;
    justify-content: space-around;
    background-color: black;
    padding: 10px 0;
    position: fixed;
    bottom: 0;
    width: 100%;
    box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
}

.footer-menu a {
    text-decoration: none;
    text-align: center;
    font-size: 14px;
    color: #333;
}

.footer-menu img {
    display: block;
    margin: 0 auto 5px;
    width: 34px;
    height: 34px;
}
</style>
