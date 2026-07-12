<?php
// Désactiver les erreurs affichées pour éviter de casser les redirections
ini_set('display_errors', 0);
session_start();

// Sécurité
if (!isset($_SESSION['compagnie']) || $_SESSION['compagnie'] !== 'SKYNET') { 
    header("Location: admin.php"); 
    exit(); 
}

$fichier_json = 'compagnies.json';

// Tenter de charger les données
$compagnies = [];
if (file_exists($fichier_json) && is_readable($fichier_json)) {
    $data = file_get_contents($fichier_json);
    $compagnies = json_decode($data, true) ?? [];
}

// Traitement des formulaires
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['ajout_comp'])) {
        $nom = strtoupper(trim($_POST['nom_comp']));
        $mdp = trim($_POST['mdp_comp']);
        if ($nom != '' && !isset($compagnies[$nom])) {
            $compagnies[$nom] = ["mdp" => $mdp, "gares" => []];
            @file_put_contents($fichier_json, json_encode($compagnies, JSON_PRETTY_PRINT));
        }
    }
    if (isset($_POST['modifier_comp'])) {
        $nom = $_POST['nom_comp_edit'];
        $compagnies[$nom]['mdp'] = trim($_POST['mdp_comp_edit']);
        @file_put_contents($fichier_json, json_encode($compagnies, JSON_PRETTY_PRINT));
    }
    if (isset($_POST['supp_comp'])) {
        unset($compagnies[$_POST['nom_supp']]);
        @file_put_contents($fichier_json, json_encode($compagnies, JSON_PRETTY_PRINT));
    }
    header("Location: admin_skynet.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin sKynEt</title>
    <style>
        body { font-family: sans-serif; background: #f4f7f6; padding: 20px; }
        .content { max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        td, th { padding: 10px; border: 1px solid #ddd; }
    </style>
</head>
<body>
<div class="content">
    <h2>Administration sKynEt</h2>
    <a href="admin.php">← Retour</a>
    
    <form method="post" style="margin-top:20px;">
        <input type="text" name="nom_comp" placeholder="Nom Compagnie" required>
        <input type="text" name="mdp_comp" placeholder="Mot de passe" required>
        <button type="submit" name="ajout_comp" style="background:#f39c12; color:white; border:none; padding:8px;">Ajouter</button>
    </form>

    <table>
        <tr><th>Compagnie</th><th>MDP</th><th>Action</th></tr>
        <?php foreach($compagnies as $nom => $data): ?>
        <tr>
            <form method="post">
                <td><input type="text" name="nom_comp_edit" value="<?php echo htmlspecialchars($nom); ?>" readonly></td>
                <td><input type="text" name="mdp_comp_edit" value="<?php echo htmlspecialchars($data['mdp']); ?>"></td>
                <td>
                    <button type="submit" name="modifier_comp" style="background:#27ae60; color:white; border:none;">Modifier</button>
                    <button type="submit" name="supp_comp" style="background:#e74c3c; color:white; border:none;">Suppr.</button>
                    <input type="hidden" name="nom_supp" value="<?php echo htmlspecialchars($nom); ?>">
                </td>
            </form>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>
