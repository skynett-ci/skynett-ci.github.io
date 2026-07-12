<?php
session_start();
date_default_timezone_set('Africa/Abidjan');

// Redirection si non connecté
if (!isset($_SESSION['compagnie'])) { header("Location: login.php"); exit(); }

// --- CONFIGURATION ---
$compagnies = [
    "AMT" => ["gares" => ["ADJAME", "ODIENE", "BOUAKE", "ABOBO", "SIANSOBA"]],
    "SKYNET" => ["gares" => ["AGENCE_A", "AGENCE_B"]]
];

if (isset($_GET['logout'])) { session_destroy(); header("Location: login.php"); exit(); }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>sKynEt Tech - Dashboard</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f4f4; margin: 0; }
        .top-bar { background-color: #007bff; color: white; padding: 10px; display: flex; justify-content: space-between; }
        .nav-icons { background: white; padding: 10px; display: flex; justify-content: space-around; border-bottom: 2px solid #007bff; }
        .nav-icons div { text-align: center; font-size: 12px; }
        .tabs { display: flex; margin-top: 10px; padding: 0 10px; }
        .tab { padding: 10px 20px; background: #ddd; margin-right: 5px; cursor: pointer; }
        .tab.active { background: #f39c12; color: white; }
        .content { background: white; margin: 10px; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #e9ecef; }
    </style>
</head>
<body>

<div class="top-bar">
    <span><strong><?php echo $_SESSION['compagnie']; ?></strong></span>
    <a href="?logout=1" style="color:white;">Déconnexion</a>
</div>

<div class="nav-icons">
    <div>🏠<br>Accueil</div>
    <div>🏢<br>Gares</div>
    <div>📊<br>Finance</div>
    <div>⚙️<br>Admin</div>
</div>

<div class="tabs">
    <div class="tab">Recettes</div>
    <div class="tab">Dépenses</div>
    <div class="tab active">Point Courrier</div>
</div>

<div class="content">
    <h3>Point des recettes courrier</h3>
    <form method="post">
        Période du <input type="date" name="debut"> au <input type="date" name="fin">
        <button type="submit">Soumettre</button>
    </form>

    <table>
        <thead>
            <tr><th>N°</th><th>Agences</th><th>Montant</th></tr>
        </thead>
        <tbody>
            <?php 
            $i = 1;
            foreach($compagnies[$_SESSION['compagnie']]['gares'] as $g) {
                echo "<tr><td>$i</td><td>$g</td><td>0</td></tr>";
                $i++;
            }
            ?>
            <tr><td colspan="2"><strong>Totaux</strong></td><td><strong>0</strong></td></tr>
        </tbody>
    </table>
</div>

</body>
</html>
