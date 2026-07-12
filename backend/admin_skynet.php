<?php
session_start();
if ($_SESSION['compagnie'] !== 'SKYNET TECH') { header("Location: admin.php"); exit(); }

$fichier_json = 'compagnies.json';
$compagnies = json_decode(file_get_contents($fichier_json), true);

// Traitement des actions d'administration
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // AJOUTER UNE COMPAGNIE
    if (isset($_POST['ajout_comp'])) {
        $nom = strtoupper(trim($_POST['nom_comp']));
        $mdp = trim($_POST['mdp_comp']);
        if (!isset($compagnies[$nom])) {
            $compagnies[$nom] = ["mdp" => $mdp, "gares" => []];
            file_put_contents($fichier_json, json_encode($compagnies, JSON_PRETTY_PRINT));
        }
    }
    // SUPPRIMER UNE COMPAGNIE
    if (isset($_POST['supprimer_comp'])) {
        unset($compagnies[$_POST['nom_supp']]);
        file_put_contents($fichier_json, json_encode($compagnies, JSON_PRETTY_PRINT));
    }
}
?>
<!-- Ajoutez ici le HTML avec le même style que admin.php pour la gestion -->
