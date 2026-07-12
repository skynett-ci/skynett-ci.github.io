<h3>Liste des Compagnies</h3>
    <table>
        <thead>
            <tr><th>Compagnie</th><th>Mot de passe</th><th>Action</th></tr>
        </thead>
        <tbody>
            <?php foreach($compagnies as $nom => $data): ?>
            <tr>
                <form method="post" action="admin_skynet.php">
                    <td>
                        <input type="text" name="nom_comp_edit" value="<?php echo htmlspecialchars($nom); ?>" readonly style="border:none; background:transparent; font-weight:bold;">
                    </td>
                    <td>
                        <input type="text" name="mdp_comp_edit" value="<?php echo htmlspecialchars($data['mdp']); ?>">
                    </td>
                    <td>
                        <button type="submit" name="modifier_comp" style="background:#27ae60; padding:5px 10px; cursor:pointer;">Modifier</button>
                        <button type="submit" name="supp_comp" onclick="return confirm('Supprimer ?');" style="background:#e74c3c; padding:5px 10px; cursor:pointer;">Supprimer</button>
                        <input type="hidden" name="nom_supp" value="<?php echo htmlspecialchars($nom); ?>">
                    </td>
                </form>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
