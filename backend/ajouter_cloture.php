<?php
date_default_timezone_set('Africa/Abidjan');

$gare = $_POST['gare'];
$montant = $_POST['montant'];
$date = date("d/m/Y H:i");

// Création d'un fichier spécifique par gare
$nom_fichier = "clotures_" . $gare . ".csv";

$ligne = $date . ";" . $montant . "\n";

file_put_contents($nom_fichier, $ligne, FILE_APPEND);

echo "OK";
?>
