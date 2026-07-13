<?php
// On récupère les données envoyées par WINDEV
$data_input = json_decode($_POST['json'], true);
$montant = $data_input['montant'] ?? '0';

// SIMULATION : Si la clé n'est pas encore là, on simule une réponse JSON propre
$apiKey = 'VOTRE_CLE_COMPLETE_SANS_POINTS_DE_SUSPENSION';

if ($apiKey === 'VOTRE_CLE_COMPLETE_SANS_POINTS_DE_SUSPENSION') {
    // On fabrique une fausse réponse au format JSON attendu par WINDEV
    $simulation = [
        "id" => "fake_session_123",
        "amount" => $montant,
        "checkout_url" => "https://skynett-ci-github-io.onrender.com/backend/api/success.php" 
    ];
    
    header('Content-Type: application/json');
    echo json_encode($simulation);
    exit; // On arrête le script ici pour le test
}

// Le reste de votre code réel (s'exécutera quand vous changerez la clé)
$url = 'https://api.wave.com/v1/checkout/sessions';
$data = [
    "amount" => $montant,
    "currency" => "XOF",
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

echo $response;
?>
