<?php
session_start();
// Vos données de compagnies
$compagnies = [
    "AMT" => [
        "mdp" => "amt2026",
        "gares" => ["ADJAME", "ODIENE", "BOUAKE"]
    ]
];

// Gestion de la connexion
if (isset($_POST['login'])) {
    if (isset($compagnies[$_POST['compagnie']]) && $compagnies[$_POST['compagnie']]['mdp'] == $_POST['mdp']) {
        $_SESSION['compagnie'] = $_POST['compagnie'];
    }
}
// Gestion de la sélection de gare
if (isset($_POST['choisir_gare'])) {
    $_SESSION['gare_selectionnee'] = $_POST['gare'];
}
?>
