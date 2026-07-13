<?php
// Charger le fichier JSON
$fichier = 'compagnies.json';
$data = json_decode(file_get_contents($fichier), true);

// Action AJOUTER Compagnie
if (isset($_POST['btn_ajouter'])) {
    $compagnie = $_POST['nom_compagnie'];
    $data[$compagnie] = [
        "mdp" => $_POST['mdp'],
        "gares" => explode(",", $_POST['gares'])
    ];
    file_put_contents($fichier, json_encode($data, JSON_PRETTY_PRINT));
}

// Action SUPPRIMER (via un lien)
if (isset($_GET['supprimer'])) {
    unset($data[$_GET['supprimer']]);
    file_put_contents($fichier, json_encode($data, JSON_PRETTY_PRINT));
}
?>

<!-- Affichage du TABLEAU comme sur votre schéma -->
<table>
    <tr><th>Compagnie</th><th>Gares</th><th>Actions</th></tr>
    <?php foreach ($data as $nom => $infos): ?>
    <tr>
        <td><?= $nom ?></td>
        <td><?= implode(", ", $infos['gares']) ?></td>
        <td>
            <a href="?supprimer=<?= $nom ?>">Supprimer</a>
            <button>Modifier</button>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
