<?php
date_default_timezone_set('Africa/Abidjan');

// On récupère les infos envoyées par l'application WinDev
$gare = $_POST['gare'];
$montant = $_POST['montant'];
$date = date("d/m/Y H:i"); // Date et heure de clôture sur le serveur

// On prépare la ligne à enregistrer dans le fichier CSV
// Format : Date;Gare;Montant
$ligne = $date . ";" . $gare . ";" . $montant . "\n";

// On écrit dans le fichier (le 'FILE_APPEND' ajoute à la fin sans écraser)
file_put_contents("clotures_journalieres.csv", $ligne, FILE_APPEND);

echo "OK"; // Réponse envoyée à l'application WinDev pour confirmer la réception
?>
