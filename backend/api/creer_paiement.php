<?php
// Clé API Wave - À garder absolument secrète
$apiKey = 'wave_sn_prod_YhUNb9d...i4bA6'; 

$url = 'https://api.wave.com/v1/checkout/sessions';

// Récupération du montant envoyé par WinDev Mobile
$montant = $_POST['montant'] ?? '0';

$data = [
    "amount" => $montant,
    "currency" => "XOF",
    "error_url" => "https://skynett-ci-github-io.onrender.com/api/error.php",
    "success_url" => "https://skynett-ci-github-io.onrender.com/api/success.php"
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $apiKey,
    'Content-Type: application/json'
]);

$response = curl_exec($ch);
curl_close($ch);

// Renvoi du résultat vers WinDev
echo $response;
?>
