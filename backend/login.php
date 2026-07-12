<?php
// Force l'affichage des erreurs pour voir ce qui bloque
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

// 1. Chargement sécurisé du fichier JSON
$fichier_json = 'compagnies.json';
$compagnies = [];

if (file_exists($fichier_json)) {
    $contenu = file_get_contents($fichier_json);
    $data = json_decode($contenu, true);
    if (is_array($data)) {
        $compagnies = $data;
    }
}

// 2. Traitement de la connexion
if (isset($_POST['login'])) {
    $comp = strtoupper(trim($_POST['compagnie']));
    $mdp = trim($_POST['mdp']);

    if (isset($compagnies[$comp]) && $compagnies[$comp]['mdp'] === $mdp) {
        $_SESSION['compagnie'] = $comp;
        header("Location: admin.php");
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
    <title>Connexion sKynEt Tech</title>
    <style>
        body { font-family: sans-serif; background: #eef2f7; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .box { background: white; padding: 40px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 300px; text-align: center; }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #003366; color: white; border: none; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="box">
        <h2>sKynEt Tech</h2>
        <?php if(isset($erreur)) echo "<p style='color:red;'>$erreur</p>"; ?>
        <form method="post">
            <input type="text" name="compagnie" placeholder="Nom Compagnie" required>
            <input type="password" name="mdp" placeholder="Mot de passe" required>
            <button type="submit" name="login">SE CONNECTER</button>
        </form>
    </div>
</body>
</html>
