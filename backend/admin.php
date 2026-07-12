<?php
session_start();
date_default_timezone_set('Africa/Abidjan');

// Redirection si non connecté
if (!isset($_SESSION['compagnie'])) { header("Location: login.php"); exit(); }

// --- CONFIGURATION ---
$compagnies = [
    "AMT" => ["gares" => ["ADJAME", "ODIENE", "BOUAKE"]],
    "SKYNET" => ["gares" => ["AGENCE_A", "AGENCE_B"]]
];

if (isset($_POST['choisir_gare'])) { $_SESSION['gare_selectionnee'] = $_POST['gare']; }
if (isset($_GET['reset_gare'])) { unset($_SESSION['gare_selectionnee']); }
if (isset($_GET['logout'])) { session_destroy(); header("Location: login.php"); exit(); }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tableau de bord PDG</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background: #f4f4f4; }
        .box { background: white; padding: 20px; max-width: 500px; margin: auto; }
        input, select, button { width: 100%; padding: 10px; margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
    </style>
</head>
<body>
    <div class="box">
        <h1>Compagnie : <?php echo $_SESSION['compagnie']; ?></h1>
        
        <?php if (!isset($_SESSION['gare_selectionnee'])): ?>
            <form method="post">
                <select name="gare">
                    <?php foreach($compagnies[$_SESSION['compagnie']]['gares'] as $g) echo "<option value='$g'>$g</option>"; ?>
                </select>
                <button type="submit" name="choisir_gare">Accéder au tableau de bord</button>
            </form>
            <a href="?logout=1">Déconnexion</a>
            
        <?php else: ?>
            <h2>Gare : <?php echo $_SESSION['gare_selectionnee']; ?></h2>
            <a href="?reset_gare=1">← Changer de gare</a>
            
            <form method="post">
                <label>Filtrer par date :</label>
                <input type="date" name="date_filtre" value="<?php echo $_POST['date_filtre'] ?? date('Y-m-d'); ?>">
                <button type="submit">OK</button>
            </form>

            <table>
                <tr><th>DATE</th><th>MONTANT (FCFA)</th></tr>
                <?php
                $date_choisie = isset($_POST['date_filtre']) ? date("d/m/Y", strtotime($_POST['date_filtre'])) : date("d/m/Y");
                $fichier = "clotures_" . $_SESSION['gare_selectionnee'] . ".csv";
                if (file_exists($fichier)) {
                    $lignes = array_reverse(file($fichier));
                    foreach($lignes as $l) {
                        $d = explode(";", $l);
                        if(count($d) >= 2 && strpos($d[0], $date_choisie) !== false) {
                            echo "<tr><td>{$d[0]}</td><td>{$d[1]}</td></tr>";
                        }
                    }
                } else { echo "<tr><td colspan='2'>Aucune donnée.</td></tr>"; }
                ?>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
