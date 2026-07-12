<?php
session_start();

// --- CORRECTION : ON CHARGE LE JSON ---
$fichier_json = 'compagnies.json';
$compagnies = [];

if (file_exists($fichier_json)) {
    $data = file_get_contents($fichier_json);
    $compagnies = json_decode($data, true) ?? [];
}
// --------------------------------------

if (isset($_POST['login'])) {
    $comp = strtoupper(trim($_POST['compagnie'])); 
    
    // Vérification dans le tableau chargé depuis le JSON
    if (isset($compagnies[$comp]) && $compagnies[$comp]['mdp'] == $_POST['mdp']) {
        $_SESSION['compagnie'] = $comp;
        header("Location: admin.php");
        exit();
    } else {
        $erreur = "Identifiants incorrects.";
    }
}
?>
