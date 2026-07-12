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
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa; margin: 0; color: #333; }
    
    /* Top Bar */
    .top-bar { background-color: #003366; color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    
    /* Nav Icons */
    .nav-icons { background: white; padding: 15px; display: flex; justify-content: space-around; border-bottom: 3px solid #007bff; }
    .nav-icons div { text-align: center; font-size: 13px; font-weight: 600; color: #555; cursor: pointer; }
    .nav-icons div:hover { color: #007bff; }

    /* Content Card */
    .content { background: white; margin: 20px auto; padding: 25px; max-width: 900px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    
    /* Form */
    input[type="date"] { padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
    button { padding: 8px 20px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
    button:hover { background-color: #0056b3; }

    /* Table Pro */
    table { width: 100%; border-collapse: separate; border-spacing: 0; margin-top: 20px; }
    th { background-color: #f8f9fa; color: #333; padding: 15px; border-bottom: 2px solid #dee2e6; text-transform: uppercase; font-size: 12px; }
    td { padding: 15px; border-bottom: 1px solid #eee; }
    tr:hover { background-color: #f1f7ff; }
    .total-row { background-color: #003366 !important; color: white; font-weight: bold; }
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
    <div class="tab active">Point Courrier</div>
</div>

<div class="content">
    <h3>Point des recettes courrier</h3>
    <form method="post">
    Période du <input type="date" name="debut" value="<?php echo date('Y-m-d'); ?>"> 
    au <input type="date" name="fin" value="<?php echo date('Y-m-d'); ?>">
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
