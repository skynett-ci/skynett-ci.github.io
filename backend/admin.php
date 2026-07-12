<?php
session_start();
date_default_timezone_set('Africa/Abidjan');

// --- CONFIGURATION DES ACCES (GARE => MOT DE PASSE) ---
$utilisateurs = [
    "ADJAME" => "adjame2026",
    "ODIENE" => "odiene2026",
    "ADMIN"  => "skynet2026" // Mot de passe global pour vous
];

// --- LOGIQUE DE CONNEXION ---
if (isset($_POST['login'])) {
    $gare = $_POST['gare'];
    $mdp = $_POST['mdp'];
    if (isset($utilisateurs[$gare]) && $utilisateurs[$gare] == $mdp) {
        $_SESSION['gare'] = $gare; // Connexion réussie, on retient la gare
        header("Location: admin.php"); // On recharge la page pour afficher le tableau
        exit();
    } else {
        $erreur = "Mot de passe incorrect pour cette gare.";
    }
}

// --- LOGIQUE DE DECONNEXION ---
if (isset($_GET['logout'])) {
    session_destroy(); // On détruit la session
    header("Location: admin.php"); // On retourne au login
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>sKynEt Tech - Administration Gares</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background-color: #f4f4f9; }
        h1 { color: #333; }
        .container { max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .login-box { text-align: center; margin-top: 50px; }
        select, input, button { padding: 10px; margin: 5px; width: 80%; max-width: 300px; display: block; margin-left: auto; margin-right: auto; }
        button { background-color: #28a745; color: white; border: none; cursor: pointer; border-radius: 4px; }
        button:hover { background-color: #218838; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #007bff; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .erreur { color: red; text-align: center; }
        .logout { float: right; text-decoration: none; color: #555; }
    </style>
</head>
<body>

<div class="container">
    <?php if (!isset($_SESSION['gare'])): ?>
        <!-- FORMULAIRE DE CONNEXION -->
        <div class="login-box">
            <h1>🔐 sKynEt Tech</h1>
            <h2>Administration des Gares</h2>
            <?php if (isset($erreur)) echo "<p class='erreur'>$erreur</p>"; ?>
            <form method="post">
                <select name="gare">
                    <option value="ADJAME">Gare Adjamé</option>
                    <option value="ODIENE">Gare Odienné</option>
                    <option value="ADMIN">Super Admin sKynEt</option>
                </select>
                <input type="password" name="mdp" placeholder="Mot de passe" required>
                <button type="submit" name="login">Connexion</button>
            </form>
        </div>
    <?php else: ?>
        <!-- TABLEAU DE BORD -->
        <a href="?logout=1" class="logout">🚪 Déconnexion</a>
        <h1>📊 Tableau de Bord : <?php echo $_SESSION['gare']; ?></h1>
        <hr>
        <table>
            <thead>
                <tr><th>Date et Heure</th><th>Gare</th><th>Montant (FCFA)</th></tr>
            </thead>
            <tbody>
                <?php
                $fichier_clotures = "clotures_journalieres.csv";
                if (file_exists($fichier_clotures)) {
                    // On lit le fichier et on inverse pour avoir les dernières lignes en haut
                    $lignes = file($fichier_clotures, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                    $lignes_inversees = array_reverse($lignes);
                    
                    foreach($lignes_inversees as $ligne) {
                        $donnees = explode(";", $ligne); // Sépare les données par le point-virgule
                        
                        // Sécurité : on vérifie que la ligne est complète (Date, Gare, Montant)
                        if (count($donnees) == 3) {
                            // On filtre selon la gare connectée (Sauf si c'est l'admin global)
                            if ($_SESSION['gare'] == "ADMIN" || $donnees[1] == $_SESSION['gare']) {
                                echo "<tr>
                                        <td>{$donnees[0]}</td>
                                        <td>{$donnees[1]}</td>
                                        <td style='font-weight:bold; color: #28a745;'>".number_format($donnees[2], 0, ',', ' ')."</td>
                                      </tr>";
                            }
                        }
                    }
                } else {
                    echo "<tr><td colspan='3' style='text-align:center;'>Aucune clôture enregistrée pour le moment.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>

