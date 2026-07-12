<?php
date_default_timezone_set('Africa/Abidjan');

// On récupère les infos envoyées par l'application WinDev
$gare = $_POST['gare'];
$montant = $_POST['montant'];
$date = date("d/m/Y H:i");

// Création d'un nom de fichier spécifique pour la gare
// Cela permet au fichier admin.php de trouver les données de la bonne gare
$nom_fichier = "clotures_" . $gare . ".csv";

// Format : Date;Montant
$ligne = $date . ";" . $montant . "\n";

// On écrit dans le fichier spécifique à cette gare
file_put_contents($nom_fichier, $ligne, FILE_APPEND);

echo "OK";
?>
