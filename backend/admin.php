<?php
session_start();
if (!isset($_SESSION['compagnie'])) { header("Location: login.php"); exit(); }

$compagnies = [
    "AMT" => ["gares" => ["ADJAME", "ODIENE", "BOUAKE"]],
    "SKYNET" => ["gares" => ["AGENCE_A", "AGENCE_B"]]
];

if (isset($_POST['choisir_gare'])) { $_SESSION['gare_selectionnee'] = $_POST['gare']; }
if (isset($_GET['logout'])) { session_destroy(); header("Location: login.php"); exit(); }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tableau de bord</title>
</head>
<body>
    <h1>Compagnie : <?php echo $_SESSION['compagnie']; ?></h1>
    
    <?php if (!isset($_SESSION['gare_selectionnee'])): ?>
        <form method="post">
            <select name="gare">
                <?php foreach($compagnies[$_SESSION['compagnie']]['gares'] as $g) echo "<option value='$g'>$g</option>"; ?>
            </select>
            <button type="submit" name="choisir_gare">Accéder à la gare</button>
        </form>
        <a href="?logout=1">Déconnexion</a>
    <?php else: ?>
        <h2>Gare : <?php echo $_SESSION['gare_selectionnee']; ?></h2>
        <a href="?reset_gare=1">Changer de gare</a>
        <!-- Ici votre logique de filtre par date et affichage tableau -->
    <?php endif; ?>
</body>
</html>
