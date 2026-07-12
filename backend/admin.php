<?php
session_start();
date_default_timezone_set('Africa/Abidjan');

// --- CONFIGURATION ---
$compagnies = [
    "AMT" => [
        "mdp" => "amt2026",
        "gares" => ["ADJAME", "ODIENE", "BOUAKE"]
    ],
    "SKYNET" => [
        "mdp" => "sky2026",
        "gares" => ["AGENCE_A", "AGENCE_B"]
    ]
];

// --- LOGIQUE DE NAVIGATION ---
if (isset($_POST['login'])) {
    if (isset($compagnies[$_POST['compagnie']]) && $compagnies[$_POST['compagnie']]['mdp'] == $_POST['mdp']) {
        $_SESSION['compagnie'] = $_POST['compagnie'];
    }
}
if (isset($_POST['choisir_gare'])) {
    $_SESSION['gare_selectionnee'] = $_POST['gare'];
}
if (isset($_GET['reset_gare'])) { unset($_SESSION['gare_selectionnee']); }
if (isset($_GET['logout'])) { session_destroy(); header("Location: admin.php"); exit(); }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>sKynEt Tech - Dashboard PDG</title>
    <style>
        body { font-family: sans-serif; background-color: #f0f0f0; margin: 0; }
        .header { background-color: #0056b3; color: white; padding: 15px; font-weight: bold; }
        .login-header { background-color: #f39c12; color: white; padding: 15px; font-weight: bold; }
        .container { max-width: 500px; margin: 20px auto; background: white; box-shadow: 0 2px 5px rgba(0,0,0,0.2); padding-bottom: 20px; }
        .form-group { padding: 20px; }
        input, select { width: 100%; padding: 10px; margin: 10px 0; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background-color: #0056b3; color: white; border: none; cursor: pointer; }
        table { width: 90%; margin: 20px auto; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>

<div class="header">sKynEt Tech</div>

<div class="container">
    <?php if (!isset($_SESSION['compagnie'])): ?>
        <div class="login-header">CONNEXION COMPAGNIE</div>
        <form method="post" class="form-group">
            <input type="text" name="compagnie" placeholder="Nom Compagnie" required>
            <input type="password" name="mdp" placeholder="Mot de passe" required>
            <button type="submit" name="login">Connecter</button>
        </form>

    <?php elseif (!isset($_SESSION['gare_selectionnee'])): ?>
        <div class="login-header">CHOIX DE LA GARE</div>
        <form method="post" class="form-group">
            <select name="gare">
                <?php foreach($compagnies[$_SESSION['compagnie']]['gares'] as $g) echo "<option value='$g'>$g</option>"; ?>
            </select>
            <button type="submit" name="choisir_gare">Accéder au tableau de bord</button>
            <a href="?logout=1" style="display:block; margin-top:15px; text-align:center;">Déconnexion</a>
        </form>

    <?php else: ?>
        <div class="login-header">TABLEAU DE BORD : <?php echo $_SESSION['gare_selectionnee']; ?></div>
        <div class="form-group">
            <a href="?reset_gare=1">← Changer de gare</a>
            
            <form method="post" style="margin-top:15px;">
                <label>Filtrer par date :</label>
                <input type="date" name="date_filtre" value="<?php echo $_POST['date_filtre'] ?? date('Y-m-d'); ?>">
                <button type="submit" name="filtrer">OK</button>
            </form>

            <table>
                <tr><th>DATE</th><th>GARE</th><th>MONTANT (FCFA)</th></tr>
                <?php
                $date_choisie = isset($_POST['date_filtre']) ? date("d/m/Y", strtotime($_POST['date_filtre'])) : date("d/m/Y");
                $fichier = "clotures_" . $_SESSION['gare_selectionnee'] . ".csv";
                
                if (file_exists($fichier)) {
                    $lignes = array_reverse(file($fichier));
                    foreach($lignes as $l) {
                        $d = explode(";", $l);
                        if(count($d) >= 2 && strpos($d[0], $date_choisie) !== false) {
                            echo "<tr><td>{$d[0]}</td><td>{$_SESSION['gare_selectionnee']}</td><td>{$d[1]}</td></tr>";
                        }
                    }
                } else {
                    echo "<tr><td colspan='3'>Aucune donnée trouvée.</td></tr>";
                }
                ?>
            </table>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
