<?php
// 1. Activer l'affichage des erreurs pour détecter le problème
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

// 2. Sécurité : Accès restreint à SKYNET
if (!isset($_SESSION['compagnie']) || $_SESSION['compagnie'] !== 'SKYNET') { 
    header("Location: admin.php"); 
    exit(); 
}

$fichier_json = 'compagnies.json';

// 3. Charger les données en toute sécurité
$compagnies = [];
if (file_exists($fichier_json)) {
    $data = file_get_contents($fichier_json);
    $compagnies = json_decode($data, true);
    if ($compagnies === null) $compagnies = [];
}

// 4. Traitement des actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['ajout_comp'])) {
        $nom = strtoupper(trim($_POST['nom_comp']));
        $mdp = trim($_POST['mdp_comp']);
        if ($nom != '' && !isset($compagnies[$nom])) {
            $compagnies[$nom] = ["mdp" => $mdp, "gares" => []];
            file_put_contents($fichier_json, json_encode($compagnies, JSON_PRETTY_PRINT));
        }
    }
    if (isset($_POST['modifier_comp'])) {
        $nom = $_POST['nom_comp_edit'];
        $compagnies[$nom]['mdp'] = trim($_POST['mdp_comp_edit']);
        file_put_contents($fichier_json, json_encode($compagnies, JSON_PRETTY_PRINT));
    }
    if (isset($_POST['supp_comp'])) {
        unset($compagnies[$_POST['nom_supp']]);
        file_put_contents($fichier_json, json_encode($compagnies, JSON_PRETTY_PRINT));
    }
    // Recharger la page pour vider le POST et éviter les doublons
    header("Location: admin_skynet.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Administration sKynEt</title>
    <style>
        body { font-family: sans-serif; background: #f4f7f6; padding: 20px; }
        .content { max-width: 800px; margin: auto; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        input { padding: 8px; margin: 5px; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 8px 15px; cursor: pointer; border: none; border-radius: 4px; color: white; }
    </style>
</head>
<body>
<div class="content">
    <h2>⚙️ Administration sKynEt</h2>
    <a href="admin.php">← Retour Dashboard</a>

    <div style="margin-top:20px;">
        <h3>Ajouter une Compagnie</h3>
        <form method="post">
            <input type="text" name="nom_comp" placeholder="Nom" required>
            <input type="text" name="mdp_comp" placeholder="Mot de passe" required>
            <button type="submit" name="ajout_comp" style="background:#f39c12;">Ajouter</button>
        </form>
    </div>

    <h3>Liste des Compagnies</h3>
    <table style="width:100%; border-collapse: collapse;">
        <tr><th>Compagnie</th><th>Mot de passe</th><th>Action</th></tr>
        <?php foreach($compagnies as $nom => $data): ?>
        <tr>
            <form method="post">
                <td><input type="text" name="nom_comp_edit" value="<?php echo htmlspecialchars($nom); ?>" readonly></td>
                <td><input type="text" name="mdp_comp_edit" value="<?php echo htmlspecialchars($data['mdp']); ?>"></td>
                <td>
                    <button type="submit" name="modifier_comp" style="background:#27ae60;">Modifier</button>
                    <button type="submit" name="supp_comp" style="background:#e74c3c;" onclick="return confirm('Confirmer ?');">Supprimer</button>
                    <input type="hidden" name="nom_supp" value="<?php echo htmlspecialchars($nom); ?>">
                </td>
            </form>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>
