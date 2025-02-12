<?php
$currentPage = isset($_GET['page']) ? $_GET['page'] : ''; 


function getIcon($page, $currentPage, $icons, $alias) {
    if ($page === $currentPage || (isset($alias[$page]) && in_array($currentPage, $alias[$page]))) {
        return $icons[$page]['active'];
    }
    return $icons[$page]['default'];
}



$icons = [
    'accueil' => ['default' => 'image2/icn.png', 'active' => 'icons2/livre.png'],
    'recherche' => ['default' => 'image2/icn2.png', 'active' => 'icons2/assiette.png'],
    'mon compte' => ['default' => 'image2/icn3.png', 'active' => 'icons2/fine.png'],
    'panier' => ['default' => 'image2/icn4.png', 'active' => 'icons2/i-poids.png'],
     
];

?>
  

<div class="footer-menu">
    <a href="index.php">Accueil</a>
    <a href="#products">Recherche</a>
    <a href="#contact">vous</a>
    <a href="index-vide1.php?page=panier "> panier</a>
</div>    
