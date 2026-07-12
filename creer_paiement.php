<?php
// On indique au serveur que l'on envoie du JSON
header('Content-Type: application/json');

// Vos données de paiement
$data = [
    "id" => "test_123",
    "checkout_url" => "https://pay.wave.com/m/M_ci_dbe-JFInO8Of/c/ci/"
];

// On affiche le JSON proprement
echo json_encode($data);
?>
