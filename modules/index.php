<?php

require_once "../database/connexion.php";

$sql = "
    SELECT
        m.id,
        m.intitule,
        m.volume_horaire,
        m.semestre,
        f.intitule AS formation
    FROM modules m
    JOIN formations f ON m.formation_id = f.id
    ORDER BY f.intitule, m.semestre, m.intitule
";

$modules = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modules · Campus Atlas</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<header class="nav">
    <div class="nav-inner">
        <a class="logo" href="../index.php"><span class="logo-dot"></span>Campus Atlas</a>
        <nav>
            <a href="../index.php">Accueil</a>
            <a href="../formations/index.php">Formations</a>
            <a href="../etudiants/index.php">Étudiants</a>
            <a href="../modules/index.php" class="on">Modules</a>
        </nav>
    </div>
</header>
<main class="wrap">

<div class="head">
    <div>
        <h1>Modules</h1>
        <p>Les enseignements de chaque formation.</p>
    </div>
    <a class="btn" href="create.php">+ Nouveau module</a>
</div>

<div class="card"><div class="table-wrap">
<table>
    <thead>
        <tr>
            <th>ID</th><th>Module</th><th>Volume</th><th>Semestre</th>
            <th>Formation</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($modules as $m) { ?>
        <tr>
            <td class="num"><?php echo $m["id"]; ?></td>
            <td><strong><?php echo htmlspecialchars($m["intitule"]); ?></strong></td>
            <td><?php echo $m["volume_horaire"]; ?> h</td>
            <td>S<?php echo $m["semestre"]; ?></td>
            <td><span class="tag"><?php echo htmlspecialchars($m["formation"]); ?></span></td>
            <td class="actions">
                <a href="edit.php?id=<?php echo $m["id"]; ?>">Modifier</a>
                <a class="del" href="delete.php?id=<?php echo $m["id"]; ?>"
                   onclick="return confirm('Supprimer ce module ?');">Supprimer</a>
            </td>
        </tr>
    <?php } ?>
    <?php if (!$modules) { ?>
        <tr><td colspan="6" class="empty">Aucun module enregistré.</td></tr>
    <?php } ?>
    </tbody>
</table>
</div></div>

<?php ?>
</main>

</body>
</html>

