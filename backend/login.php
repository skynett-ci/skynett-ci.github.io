<?php
session_start();
// --- CONFIGURATION DES COMPAGNIES ---
$compagnies = [
    "AMT" => ["mdp" => "amt2026", "gares" => ["ADJAME", "ODIENE", "BOUAKE"]],
    "SKYNET" => ["mdp" => "sky2026", "gares" => ["AGENCE_A", "AGENCE_B"]]
];

if (isset($_POST['login'])) {
    $comp = $_POST['compagnie'];
    if (isset($compagnies[$comp]) && $compagnies[$comp]['mdp'] == $_POST['mdp']) {
        $_SESSION['compagnie'] = $comp;
        header("Location: admin.php"); // Redirige vers le tableau de bord
        exit();
    } else {
        $erreur = "Identifiants incorrects.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion - sKynEt Tech</title>
    <style>
        body { font-family: sans-serif; background: #f0f0f0; display: flex; justify-content: center; padding-top: 50px; }
        .box { background: white; padding: 20px; width: 300px; box-shadow: 0 2px 5px rgba(0,0,0,0.2); }
        input { width: 100%; padding: 10px; margin: 10px 0; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #0056b3; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <div class="box">
        <h3>CONNEXION COMPAGNIE</h3>
        <?php if(isset($erreur)) echo "<p style='color:red;'>$erreur</p>"; ?>
        <form method="post">
            <input type="text" name="compagnie" placeholder="Nom Compagnie" required>
            <input type="password" name="mdp" placeholder="Mot de passe" required>
            <button type="submit" name="login">Se connecter</button>
        </form>
    </div>
</body>
</html>
