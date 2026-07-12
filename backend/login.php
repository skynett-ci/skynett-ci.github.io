<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

$fichier_json = 'compagnies.json';
$compagnies = [];

if (file_exists($fichier_json)) {
    $contenu = file_get_contents($fichier_json);
    $data = json_decode($contenu, true);
    if (is_array($data)) { $compagnies = $data; }
}

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
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion sKynEt Tech</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: #eef2f7; 
            margin: 0; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
        }
        .box { 
            background: white; 
            padding: 30px; 
            border-radius: 15px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.1); 
            width: 90%; /* S'adapte à la largeur */
            max-width: 400px; /* Ne dépasse pas 400px sur PC */
            text-align: center;
        }
        h2 { color: #003366; margin-bottom: 20px; }
        input { 
            width: 100%; 
            padding: 15px; /* Plus confortable pour le tactile */
            margin: 10px 0; 
            border: 1px solid #ddd; 
            border-radius: 8px; 
            box-sizing: border-box; /* Important pour ne pas dépasser */
            font-size: 16px; /* Empêche le zoom automatique sur iPhone */
        }
        button { 
            width: 100%; 
            padding: 15px; 
            background: #003366; 
            color: white; 
            border: none; 
            border-radius: 8px; 
            cursor: pointer; 
            font-weight: bold;
            font-size: 16px;
            margin-top: 10px;
        }
        @media (max-width: 480px) {
            .box { padding: 20px; }
            h2 { font-size: 20px; }
        }
    </style>
</head>
<body>
    <div class="box">
        <h2>sKynEt Tech</h2>
        <?php if(isset($erreur)) echo "<p style='color:red; font-size: 14px;'>$erreur</p>"; ?>
        <form method="post">
            <input type="text" name="compagnie" placeholder="Nom Compagnie" required>
            <input type="password" name="mdp" placeholder="Mot de passe" required>
            <button type="submit" name="login">SE CONNECTER</button>
        </form>
    </div>
</body>
</html>
