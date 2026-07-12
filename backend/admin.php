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
    :root {
        --primary: #003366;      /* Bleu profond pro */
        --accent: #f39c12;       /* Orange ambre élégant */
        --bg: #f4f7f6;           /* Gris très clair */
        --text: #2c3e50;         /* Gris foncé */
    }

    body { font-family: 'Segoe UI', sans-serif; background-color: var(--bg); margin: 0; color: var(--text); }
    
    /* Top Bar avec dégradé */
    .top-bar { 
        background: linear-gradient(90deg, #003366 0%, #0056b3 100%); 
        color: white; padding: 15px 25px; display: flex; justify-content: space-between; align-items: center; 
    }
    
    /* Icônes de navigation */
    .nav-icons { background: white; padding: 15px; display: flex; justify-content: space-around; border-bottom: 3px solid var(--accent); }
    .nav-icons div { text-align: center; font-size: 13px; font-weight: 600; color: var(--primary); cursor: pointer; }

    /* Carte de contenu */
    .content { background: white; margin: 20px auto; padding: 25px; max-width: 900px; border-radius: 12px; box-shadow: 0 8px 16px rgba(0,0,0,0.1); }
    
    /* Boutons et Inputs */
    button { padding: 10px 25px; background-color: var(--accent); color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; }
    button:hover { background-color: #d68910; }

    /* Tableau Élégant */
    table { width: 100%; border-collapse: separate; border-spacing: 0; margin-top: 20px; border-radius: 8px; overflow: hidden; }
    th { background-color: var(--primary); color: white; padding: 15px; text-transform: uppercase; font-size: 12px; }
    td { padding: 15px; border-bottom: 1px solid #edf2f7; }
    tr:nth-child(even) { background-color: #f9f9f9; }
    tr:hover { background-color: #f1f7ff; }

    /* Ligne Totaux */
    .total-row { background-color: var(--primary) !important; color: white; font-weight: bold; }
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
