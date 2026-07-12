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

// --- LOGIQUE D'AJOUT DE CLÔTURE ---
if (isset($_POST['ajouter_cloture'])) {
    $gare = $_POST['gare_saisie'];
    $montant = $_POST['montant_saisie'];
    $date = date("d/m/Y H:i");
    $ligne = $date . ";" . $montant . "\n";
    file_put_contents("clotures_" . $gare . ".csv", $ligne, FILE_APPEND);
    $message = "Clôture enregistrée pour $gare !";
}

// --- LOGIQUE DE NAVIGATION ---
if (isset($_POST['choisir_gare'])) { $_SESSION['gare_selectionnee'] = $_POST['gare']; }
if (isset($_GET['reset_gare'])) { unset($_SESSION['gare_selectionnee']); }
if (isset($_GET['logout'])) { session_destroy(); header("Location: login.php"); exit(); }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Administration sKynEt Tech</title>
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
        <?php if(isset($message)) echo "<p style='color:green;'>$message</p>"; ?>

        <?php if (!isset($_SESSION['gare_selectionnee'])): ?>
            <form method="post">
                <select name="gare">
                    <?php foreach($compagnies[$_SESSION['compagnie']]['gares'] as $g) echo "<option value='$g'>$g</option>"; ?>
                </select>
                <button type="submit" name="choisir_gare">Accéder au tableau</button>
            </form>
            <a href="?logout=1">Déconnexion</a>
        <?php else: ?>
            <h2>Gare : <?php echo $_SESSION['gare_selectionnee']; ?></h2>
            <a href="?reset_gare=1">← Changer de gare</a>

            <!-- Formulaire d'ajout rapide -->
            <form method="post" style="border-top: 2px solid #ccc; margin-top:20px; padding-top:10px;">
                <h3>Ajouter une clôture</h3>
                <input type="hidden" name="gare_saisie" value="<?php echo $_SESSION['gare_selectionnee']; ?>">
                <input type="number" name="montant_saisie" placeholder="Montant (FCFA)" required>
                <button type="submit" name="ajouter_cloture">Valider la clôture</button>
            </form>

            <!-- Tableau d'affichage -->
            <table>
                <tr><th>DATE</th><th>MONTANT</th></tr>
                <?php
                $fichier = "clotures_" . $_SESSION['gare_selectionnee'] . ".csv";
                if (file_exists($fichier)) {
                    foreach(array_reverse(file($fichier)) as $l) {
                        $d = explode(";", $l);
                        echo "<tr><td>{$d[0]}</td><td>{$d[1]}</td></tr>";
                    }
                }
                ?>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
