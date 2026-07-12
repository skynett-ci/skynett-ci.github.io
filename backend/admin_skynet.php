<?php
session_start();
// Sécurité : Uniquement accessible par SKYNET TECH
if ($_SESSION['compagnie'] !== 'SKYNET') { header("Location: admin.php"); exit(); }

$fichier_json = 'compagnies.json';
$compagnies = json_decode(file_get_contents($fichier_json), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. AJOUTER UNE COMPAGNIE
    if (isset($_POST['ajout_comp'])) {
        $nom = strtoupper(trim($_POST['nom_comp']));
        $mdp = trim($_POST['mdp_comp']);
        if (!isset($compagnies[$nom]) && $nom != '') {
            $compagnies[$nom] = ["mdp" => $mdp, "gares" => []];
            file_put_contents($fichier_json, json_encode($compagnies, JSON_PRETTY_PRINT));
        }
    }
    
    // 2. MODIFIER LE MOT DE PASSE (Nouveau !)
    if (isset($_POST['modifier_comp'])) {
        $nom = $_POST['nom_comp_edit'];
        $nouveau_mdp = trim($_POST['mdp_comp_edit']);
        if (isset($compagnies[$nom])) {
            $compagnies[$nom]['mdp'] = $nouveau_mdp;
            file_put_contents($fichier_json, json_encode($compagnies, JSON_PRETTY_PRINT));
        }
    }

    // 3. SUPPRIMER UNE COMPAGNIE
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
        input, button { width: 100%; padding: 10px; margin: 5px 0; border-radius: 6px; border: 1px solid #ccc; box-sizing: border-box; }
        button { background: var(--accent); color: white; border: none; font-weight: bold; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #eee; padding: 10px; text-align: left; vertical-align: middle; }
        th { background: var(--primary); color: white; }
    </style>
</head>
<body>
<div class="content">
    <h2>⚙️ Administration sKynEt Tech</h2>
    <a href="admin.php" style="color:var(--primary); text-decoration:none; font-weight:bold;">← Retour Dashboard</a>
    
    <div style="margin-top:20px; margin-bottom: 30px;">
        <h3>Ajouter une Compagnie</h3>
        <form method="post" style="display: flex; gap: 10px;">
            <input type="text" name="nom_comp" placeholder="Nom Compagnie" required>
            <input type="text" name="mdp_comp" placeholder="Mot de passe" required>
            <button type="submit" name="ajout_comp" style="width: auto; padding: 10px 20px;">Ajouter</button>
        </form>
    </div>

    <h3>Liste des Compagnies</h3>
    <table>
        <thead>
            <tr><th>Compagnie</th><th>Mot de passe</th><th>Action</th></tr>
        </thead>
        <tbody>
            <?php foreach($compagnies as $nom => $data): ?>
            <tr>
                <form method="post">
                    <!-- Le nom de la compagnie ne peut pas être modifié (readonly) -->
                    <td><input type="text" name="nom_comp_edit" value="<?php echo $nom; ?>" readonly style="background:#f9f9f9; border:none; outline:none; font-weight:bold;"></td>
                    
                    <!-- Le mot de passe peut être modifié -->
                    <td><input type="text" name="mdp_comp_edit" value="<?php echo $data['mdp']; ?>"></td>
                    
                    <td style="display: flex; gap: 5px;">
                        <button type="submit" name="modifier_comp" style="background:#27ae60; width:auto; padding: 8px 12px;">Modifier</button>
                        <button type="submit" name="supp_comp" style="background:#e74c3c; width:auto; padding: 8px 12px;" onclick="return confirm('Voulez-vous vraiment supprimer cette compagnie ?');">Supprimer</button>
                        <input type="hidden" name="nom_supp" value="<?php echo $nom; ?>">
                    </td>
                </form>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
