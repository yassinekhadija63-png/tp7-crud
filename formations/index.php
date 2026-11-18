<?php

require_once "../database/connexion.php";

// Nombre d'étudiants et de modules par formation (LEFT JOIN + sous-requêtes)
$sql = "
    SELECT
        f.id,
        f.intitule,
        f.duree_mois,
        f.tarif,
        (SELECT COUNT(*) FROM etudiants e WHERE e.formation_id = f.id) AS nb_etudiants,
        (SELECT COUNT(*) FROM modules m WHERE m.formation_id = f.id) AS nb_modules
    FROM formations f
    ORDER BY f.intitule
";

$formations = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Formations · Campus Atlas</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<header class="nav">
    <div class="nav-inner">
        <a class="logo" href="../index.php"><span class="logo-dot"></span>Campus Atlas</a>
        <nav>
            <a href="../index.php">Accueil</a>
            <a href="../formations/index.php" class="on">Formations</a>
            <a href="../etudiants/index.php">Étudiants</a>
            <a href="../modules/index.php">Modules</a>
        </nav>
    </div>
</header>
<main class="wrap">

<div class="head">
    <div>
        <h1>Formations</h1>
        <p>Les cursus proposés par le centre.</p>
    </div>
    <a class="btn" href="create.php">+ Nouvelle formation</a>
</div>

<?php if (isset($_GET["erreur"])) { ?>
    <div class="alert err">Suppression impossible : cette formation contient encore des étudiants ou des modules.</div>
<?php } ?>

<div class="card"><div class="table-wrap">
<table>
    <thead>
        <tr>
            <th>ID</th><th>Intitulé</th><th>Durée</th><th>Tarif</th>
            <th>Étudiants</th><th>Modules</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($formations as $f) { ?>
        <tr>
            <td class="num"><?php echo $f["id"]; ?></td>
            <td><strong><?php echo htmlspecialchars($f["intitule"]); ?></strong></td>
            <td><?php echo $f["duree_mois"]; ?> mois</td>
            <td><?php echo number_format($f["tarif"], 2, ",", " "); ?> DH</td>
            <td><span class="tag"><?php echo $f["nb_etudiants"]; ?></span></td>
            <td><span class="tag"><?php echo $f["nb_modules"]; ?></span></td>
            <td class="actions">
                <a href="edit.php?id=<?php echo $f["id"]; ?>">Modifier</a>
                <a class="del" href="delete.php?id=<?php echo $f["id"]; ?>"
                   onclick="return confirm('Supprimer cette formation ?');">Supprimer</a>
            </td>
        </tr>
    <?php } ?>
    <?php if (!$formations) { ?>
        <tr><td colspan="7" class="empty">Aucune formation enregistrée.</td></tr>
    <?php } ?>
    </tbody>
</table>
</div></div>

<?php ?>
</main>

</body>
</html>

