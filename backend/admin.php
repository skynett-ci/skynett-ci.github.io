<?php
session_start();
date_default_timezone_set('Africa/Abidjan');

// Redirection si non connecté
if (!isset($_SESSION['compagnie'])) { header("Location: login.php"); exit(); }

// --- CONFIGURATION DYNAMIQUE ---
$fichier_json = 'compagnies.json';
// Vérifie si le fichier existe, sinon affiche une erreur
if (!file_exists($fichier_json)) { die("Erreur : Fichier de configuration manquant."); }
$compagnies = json_decode(file_get_contents($fichier_json), true);

// Sécurité : si la compagnie n'existe plus dans le JSON, on déconnecte
if (!isset($compagnies[$_SESSION['compagnie']])) { session_destroy(); header("Location: login.php"); exit(); }

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
            --primary: #003366; --accent: #f39c12; --bg: #f4f7f6; --text: #2c3e50;
        }
        body { font-family: 'Segoe UI', sans-serif; background-color: var(--bg); margin: 0; color: var(--text); }
        
        .top-bar { background: linear-gradient(90deg, #003366 0%, #0056b3 100%); color: white; padding: 15px 25px; display: flex; justify-content: space-between; align-items: center; }
        
        .nav-icons { background: white; padding: 15px; display: flex; justify-content: space-around; border-bottom: 3px solid var(--accent); }
        .nav-icons a { text-decoration: none; color: var(--primary); text-align: center; font-size: 13px; font-weight: 600; cursor: pointer; }

        .content { background: white; margin: 20px auto; padding: 25px; max-width: 900px; border-radius: 12px; box-shadow: 0 8px 16px rgba(0,0,0,0.1); }
        
        button { padding: 10px 25px; background-color: var(--accent); color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; }
        
        table { width: 100%; border-collapse: separate; border-spacing: 0; margin-top: 20px; border-radius: 8px; overflow: hidden; }
        th { background-color: var(--primary); color: white; padding: 15px; text-transform: uppercase; font-size: 12px; }
        td { padding: 15px; border-bottom: 1px solid #edf2f7; }
        .total-row { background-color: var(--primary) !important; color: white; font-weight: bold; }
    </style>
</head>
<body>

<div class="top-bar">
    <span><strong><?php echo $_SESSION['compagnie']; ?></strong></span>
    <a href="?logout=1" style="color:white; text-decoration:none;">Déconnexion</a>
</div>

<div class="nav-icons">
    <a href="admin.php" style="text-decoration:none; color:inherit;"><div>🏠<br>Accueil</div></a>
    <div>🏢<br>Gares</div>
    <div>📊<br>Finance</div>

    <!-- CODE CORRIGÉ POUR LE BOUTON ADMIN -->
    <?php if($_SESSION['compagnie'] === 'SKYNET'): ?>
        <a href="admin_skynet.php" style="text-decoration:none; color:inherit;">
            <div style="cursor:pointer; color: var(--primary);">⚙️<br>Admin</div>
        </a>
    <?php else: ?>
        <div style="opacity:0.3; cursor:not-allowed;">⚙️<br>Admin</div>
    <?php endif; ?>
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
            // Utilise la liste des gares dynamique du JSON
            foreach($compagnies[$_SESSION['compagnie']]['gares'] as $g) {
                echo "<tr><td>$i</td><td>$g</td><td>0 <small>C</small></td></tr>";
                $i++;
            }
            ?>
            <tr class="total-row"><td colspan="2" style="text-align:right;">Totaux</td><td>0 C</td></tr>
        </tbody>
    </table>
</div>

</body>
</html>
