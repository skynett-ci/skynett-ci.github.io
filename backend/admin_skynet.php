<?php
session_start();
if ($_SESSION['compagnie'] !== 'SKYNET TECH') { header("Location: admin.php"); exit(); }

$fichier_json = 'compagnies.json';
$compagnies = json_decode(file_get_contents($fichier_json), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['ajout_comp'])) {
        $nom = strtoupper(trim($_POST['nom_comp']));
        $mdp = trim($_POST['mdp_comp']);
        if (!isset($compagnies[$nom]) && $nom != '') {
            $compagnies[$nom] = ["mdp" => $mdp, "gares" => []];
            file_put_contents($fichier_json, json_encode($compagnies, JSON_PRETTY_PRINT));
        }
    }
    if (isset($_POST['supp_comp'])) {
        unset($compagnies[$_POST['nom_supp']]);
        file_put_contents($fichier_json, json_encode($compagnies, JSON_PRETTY_PRINT));
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Gestion Compagnies - sKynEt Tech</title>
    <style>
        :root { --primary: #003366; --accent: #f39c12; }
        body { font-family: sans-serif; background: #f4f7f6; padding: 20px; }
        .content { max-width: 800px; margin: auto; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        input, button { width: 100%; padding: 10px; margin: 5px 0; border-radius: 6px; border: 1px solid #ccc; }
        button { background: var(--accent); color: white; border: none; font-weight: bold; cursor: pointer; }
        .comp-item { display: flex; justify-content: space-between; padding: 10px; border-bottom: 1px solid #eee; align-items: center; }
    </style>
</head>
<body>
<div class="content">
    <h2>⚙️ Administration sKynEt Tech</h2>
    <a href="admin.php">← Retour Dashboard</a>
    
    <div style="margin-top:20px;">
        <h3>Ajouter une Compagnie</h3>
        <form method="post">
            <input type="text" name="nom_comp" placeholder="Nom Compagnie" required>
            <input type="text" name="mdp_comp" placeholder="Mot de passe" required>
            <button type="submit" name="ajout_comp">Enregistrer la Compagnie</button>
        </form>
    </div>

    <h3>Compagnies Existantes</h3>
    <?php foreach($compagnies as $nom => $data): ?>
        <div class="comp-item">
            <span><strong><?php echo $nom; ?></strong> (MDP: <?php echo $data['mdp']; ?>)</span>
            <form method="post" onsubmit="return confirm('Supprimer ?');">
                <input type="hidden" name="nom_supp" value="<?php echo $nom; ?>">
                <button type="submit" name="supp_comp" style="background:#e74c3c; width:auto;">Supprimer</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>
