<?php
session_start();
if ($_SESSION['compagnie'] !== 'SKYNET') { header("Location: admin.php"); exit(); }

$fichier_json = 'compagnies.json';

// 1. Vérifier si le fichier existe avant de tenter de le lire
if (file_exists($fichier_json)) {
    $contenu = file_get_contents($fichier_json);
    $compagnies = json_decode($contenu, true);
    
    // 2. Si le décodage échoue (JSON invalide), on initialise un tableau vide
    if ($compagnies === null) {
        $compagnies = [];
    }
} else {
    // Si le fichier n'existe pas, on crée un tableau vide
    $compagnies = [];
}

// ... le reste de votre code
?>
