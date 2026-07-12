<?php
session_start();
// Vos données de compagnies
$compagnies = [
    "AMT" => [
        "mdp" => "amt2026",
        "gares" => ["ADJAME", "ODIENE", "BOUAKE"]
    ]
];

// Gestion de la connexion
if (isset($_POST['login'])) {
    if (isset($compagnies[$_POST['compagnie']]) && $compagnies[$_POST['compagnie']]['mdp'] == $_POST['mdp']) {
        $_SESSION['compagnie'] = $_POST['compagnie'];
    }
}
// Gestion de la sélection de gare
if (isset($_POST['choisir_gare'])) {
    $_SESSION['gare_selectionnee'] = $_POST['gare'];
}
?>

<!-- ÉTAPE 1 : Si pas de compagnie connectée -->
<?php if (!isset($_SESSION['compagnie'])): ?>
    <form method="post">
        <input type="text" name="compagnie" placeholder="Nom Compagnie" required>
        <input type="password" name="mdp" placeholder="Mot de passe" required>
        <button type="submit" name="login">Connexion Compagnie</button>
    </form>

<!-- ÉTAPE 2 : Compagnie connectée, mais pas de gare choisie -->
<?php elseif (!isset($_SESSION['gare_selectionnee'])): ?>
    <h2>Bonjour <?php echo $_SESSION['compagnie']; ?>, quelle gare consulter ?</h2>
    <form method="post">
        <select name="gare">
            <?php foreach($compagnies[$_SESSION['compagnie']]['gares'] as $g) echo "<option>$g</option>"; ?>
        </select>
        <button type="submit" name="choisir_gare">Accéder à la gare</button>
    </form>

<!-- ÉTAPE 3 : Gare choisie, on affiche les données -->
<?php else: ?>
    <h1>Gare : <?php echo $_SESSION['gare_selectionnee']; ?></h1>
    <a href="?reset_gare=1">Changer de gare</a>
    <!-- Ici votre tableau qui filtre sur $_SESSION['gare_selectionnee'] -->
<?php endif; ?>
