<?php

require_once "../database/connexion.php";

// JOIN : afficher l'intitulé de la formation et non son identifiant
$sql = "
    SELECT
        e.id,
        e.nom,
        e.prenom,
        e.email,
        f.intitule AS formation
    FROM etudiants e
    JOIN formations f ON e.formation_id = f.id
    ORDER BY e.nom, e.prenom
";

$etudiants = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Étudiants · Campus Atlas</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<header class="nav">
    <div class="nav-inner">
        <a class="logo" href="../index.php"><span class="logo-dot"></span>Campus Atlas</a>
        <nav>
            <a href="../index.php">Accueil</a>
            <a href="../formations/index.php">Formations</a>
            <a href="../etudiants/index.php" class="on">Étudiants</a>
            <a href="../modules/index.php">Modules</a>
        </nav>
    </div>
</header>
<main class="wrap">

<div class="head">
    <div>
        <h1>Étudiants</h1>
        <p>Les inscrits et leur formation.</p>
    </div>
    <a class="btn" href="create.php">+ Nouvel étudiant</a>
</div>

<div class="card"><div class="table-wrap">
<table>
    <thead>
        <tr>
            <th>ID</th><th>Étudiant</th><th>Email</th>
            <th>Formation</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($etudiants as $e) { ?>
        <tr>
            <td class="num"><?php echo $e["id"]; ?></td>
            <td><strong><?php echo htmlspecialchars($e["prenom"] . " " . $e["nom"]); ?></strong></td>
            <td><?php echo htmlspecialchars($e["email"]); ?></td>
            <td><span class="tag"><?php echo htmlspecialchars($e["formation"]); ?></span></td>
            <td class="actions">
                <a href="edit.php?id=<?php echo $e["id"]; ?>">Modifier</a>
                <a class="del" href="delete.php?id=<?php echo $e["id"]; ?>"
                   onclick="return confirm('Supprimer cet étudiant ?');">Supprimer</a>
            </td>
        </tr>
    <?php } ?>
    <?php if (!$etudiants) { ?>
        <tr><td colspan="5" class="empty">Aucun étudiant enregistré.</td></tr>
    <?php } ?>
    </tbody>
</table>
</div></div>

<?php ?>
</main>

</body>
</html>

