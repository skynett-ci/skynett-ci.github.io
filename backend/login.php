<?php
session_start();
$compagnies = [
    "AMT" => ["mdp" => "amt2026", "gares" => ["ADJAME", "ODIENE", "BOUAKE", "ABOBO", "SIANSOBA"]],
    "SKYNET" => ["mdp" => "sky2026", "gares" => ["AGENCE_A", "AGENCE_B"]]
];

if (isset($_POST['login'])) {
    $comp = $_POST['compagnie'];
    if (isset($compagnies[$comp]) && $compagnies[$comp]['mdp'] == $_POST['mdp']) {
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion sKynEt Tech</title>
    <style>
        :root {
            --primary: #003366;
            --accent: #f39c12;
            --bg: #eef2f7;
        }
        body { 
            font-family: 'Segoe UI', sans-serif; 
            background: var(--bg); 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            margin: 0; 
        }
        .box { 
            background: white; 
            padding: 40px; 
            width: 100%; 
            max-width: 350px; 
            border-radius: 15px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.1); 
            text-align: center;
        }
        h3 { color: var(--primary); margin-bottom: 25px; }
        input { 
            width: 100%; 
            padding: 12px; 
            margin: 10px 0; 
            border: 1px solid #ddd; 
            border-radius: 8px; 
            box-sizing: border-box; 
        }
        button { 
            width: 100%; 
            padding: 12px; 
            background: var(--primary); 
            color: white; 
            border: none; 
            border-radius: 8px; 
            cursor: pointer; 
            font-weight: bold; 
            margin-top: 15px;
            transition: background 0.3s;
        }
        button:hover { background: #0056b3; }
        .logo { font-size: 24px; font-weight: bold; color: var(--primary); margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="box">
        <div class="logo">sKynEt Tech</div>
        <h3>Espace Direction</h3>
        <?php if(isset($erreur)) echo "<p style='color:red; font-size: 14px;'>$erreur</p>"; ?>
        <form method="post">
            <input type="text" name="compagnie" placeholder="Nom de la Compagnie" required>
            <input type="password" name="mdp" placeholder="Mot de passe" required>
            <button type="submit" name="login">SE CONNECTER</button>
        </form>
    </div>
</body>
</html>
