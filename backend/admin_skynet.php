<?php
session_start();
if ($_SESSION['compagnie'] !== 'SKYNET') { header("Location: admin.php"); exit(); }

// --- CORRECTION : ON LIT LE FICHIER JSON ICI ---
$fichier_json = 'compagnies.json';
$compagnies = [];

if (file_exists($fichier_json)) {
    $contenu = file_get_contents($fichier_json);
    $compagnies = json_decode($contenu, true) ?? [];
}
// ------------------------------------------------
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Gestion Automatique - sKynEt Tech</title>
    <style>
        body { font-family: sans-serif; background: #f4f7f6; padding: 20px; }
        .content { max-width: 800px; margin: auto; background: white; padding: 25px; border-radius: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #003366; color: white; }
    </style>
</head>
<body>
<div class="content">
    <h2>⚙️ Administration (Lecture automatique)</h2>
    <p>Le tableau ci-dessous lit directement les données du fichier <b>compagnies.json</b>.</p>
    
    <table>
        <tr><th>Compagnie</th><th>Mot de passe</th></tr>
        <?php foreach($compagnies as $nom => $data): ?>
        <tr>
            <td><?php echo htmlspecialchars($nom); ?></td>
            <td><?php echo htmlspecialchars($data['mdp']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="admin.php">← Retour Dashboard</a>
</div>
</body>
</html>
