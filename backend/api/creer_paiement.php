<?php
// Clé API Wave - Remplacez par votre clé complète (sans les ...)
$apiKey = 'VOTRE_CLE_COMPLETE_ICI'; 

$url = 'https://api.wave.com/v1/checkout/sessions';

// Récupération du montant envoyé par WinDev Mobile en format JSON
$data_input = json_decode(file_get_contents('php://input'), true);
$montant = $data_input['montant'] ?? '0';

$data = [
    "amount" => $montant,
    "currency" => "XOF",
    // Assurez-vous que le chemin /backend/api/ est bien présent si vos fichiers sont dans ce dossier
    "error_url" => "https://skynett-ci-github-io.onrender.com/backend/api/error.php",
    "success_url" => "https://skynett-ci-github-io.onrender.com/backend/api/success.php"
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
