<?php
session_start();
date_default_timezone_set('Africa/Abidjan');

$utilisateurs = ["ADJAME" => "adjame2026", "ODIENE" => "odiene2026", "ADMIN" => "skynet2026"];

if (isset($_POST['login'])) {
    if (isset($utilisateurs[$_POST['gare']]) && $utilisateurs[$_POST['gare']] == $_POST['mdp']) {
        $_SESSION['gare'] = $_POST['gare'];
        header("Location: admin.php"); exit();
    }
}
if (isset($_GET['logout'])) { session_destroy(); header("Location: admin.php"); exit(); }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>sKynEt Tech - Connexion</title>
    <style>
        body { font-family: sans-serif; background-color: #f0f0f0; margin: 0; padding: 0; }
        .header { background-color: #0056b3; color: white; padding: 15px; font-weight: bold; font-size: 1.2em; }
        .container { display: flex; justify-content: center; margin-top: 40px; padding: 10px; }
        .login-box { background: white; width: 100%; max-width: 400px; box-shadow: 0 2px 5px rgba(0,0,0,0.2); }
        .login-header { background-color: #f39c12; color: white; padding: 15px; font-weight: bold; }
        .form-group { padding: 20px; }
        label { display: block; margin-bottom: 5px; font-size: 0.9em; }
        input, select { width: 100%; padding: 8px; margin-bottom: 15px; border: 1px solid #ccc; box-sizing: border-box; }
        button { background-color: #0056b3; color: white; border: none; padding: 10px 20px; cursor: pointer; }
    </style>
</head>
<body>

<?php if (!isset($_SESSION['gare'])): ?>
    <div class="header">sKynEt Tech</div>
    <div class="container">
        <div class="login-box">
            <div class="login-header">CONNEXION A VOTRE COMPTE</div>
            <form method="post" class="form-group">
                <label>Compte (Gare)</label>
                <select name="gare"><option value="ADJAME">Adjamé</option><option value="ODIENE">Odienné</option></select>
                <label>Nom d'utilisateur (Identifiant)</label>
                <input type="text" name="user" required>
                <label>Mot de passe</label>
                <input type="password" name="mdp" required>
                <button type="submit" name="login">Connecter</button>
            </form>
        </div>
    </div>
<?php else: ?>
    <!-- Votre code de tableau de bord reste ici -->
    <div style="padding:20px;">
        <h1>Dashboard : <?php echo $_SESSION['gare']; ?></h1>
        <a href="?logout=1">Déconnexion</a>
    </div>
<?php endif; ?>

</body>
</html>
