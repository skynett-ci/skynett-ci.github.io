<?php
// Récupérer le contenu envoyé par Wave
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if ($data && $data['status'] == 'completed') {
    // Ici, vous faites la connexion à votre base HFSQL 
    // ou vous envoyez une requête à une API de votre application WinDev
    // pour marquer le paiement comme "PAYE" dans la table PAIEMENTS
    echo "Paiement validé avec succès";
}
?>
