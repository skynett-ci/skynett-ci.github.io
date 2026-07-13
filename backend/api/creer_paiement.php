<?php
// Clé API Wave - Mettez votre clé complète ici
$apiKey = 'VOTRE_CLE_COMPLETE_SANS_POINTS_DE_SUSPENSION'; 

$url = 'https://api.wave.com/v1/checkout/sessions';

// CORRECTION : On décode ce qui vient du formulaire "json" envoyé par WinDev
$data_input = json_decode($_POST['json'], true);
$montant = $data_input['montant'] ?? '0';

$data = [
    "amount" => $montant,
    "currency" => "XOF",
    "error_url" => "https://skynett-ci-github-io.onrender.com/backend/api/error.php",
    "success_url" => "https://skynett-ci-github-io.onrender.com/backend/api/success.php"
];

// ... le reste de votre code avec curl_init, etc.

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
