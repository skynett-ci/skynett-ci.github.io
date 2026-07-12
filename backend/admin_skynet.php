<?php
session_start();
if ($_SESSION['compagnie'] !== 'SKYNET') { header("Location: admin.php"); exit(); }

// LISTE EN DUR (Modifiez cette liste directement dans le code pour ajouter vos compagnies)
$compagnies = [
    "AMT" => ["mdp" => "amt2026", "gares" => ["ADJAME", "ODIENE", "BOUAKE", "ABOBO", "SIANSOBA"]],
    "SKYNET" => ["mdp" => "sky2026", "gares" => ["AGENCE_A", "AGENCE_B"]],
    "SAIID" => ["mdp" => "1234", "gares" => ["abobo","adjame"]] // Ajoutez vos lignes ici
];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Gestion Directe - sKynEt Tech</title>
    <style>
        body { font-family: sans-serif; background: #f4f7f6; padding: 20px; }
        .content { max-width: 800px; margin: auto; background: white; padding: 25px; border-radius: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
    </style>
</head>
<body>
<div class="content">
    <h2>⚙️ Administration (Mode Manuel)</h2>
    <p>Pour ajouter une compagnie, modifiez le tableau <code>$compagnies</code> dans le fichier <b>admin_skynet.php</b>.</p>
    
    <table>
        <tr><th>Compagnie</th><th>Mot de passe</th></tr>
        <?php foreach($compagnies as $nom => $data): ?>
        <tr>
            <td><?php echo $nom; ?></td>
            <td><?php echo $data['mdp']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="admin.php">← Retour Dashboard</a>
</div>
</body>
</html>
