<?php

require_once "database/connexion.php";

$compteurs = [
    "formations" => $pdo->query("SELECT COUNT(*) FROM formations")->fetchColumn(),
    "etudiants"  => $pdo->query("SELECT COUNT(*) FROM etudiants")->fetchColumn(),
    "modules"    => $pdo->query("SELECT COUNT(*) FROM modules")->fetchColumn(),
];

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Accueil · Campus Atlas</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="nav">
    <div class="nav-inner">
        <a class="logo" href="index.php"><span class="logo-dot"></span>Campus Atlas</a>
        <nav>
            <a href="index.php" class="on">Accueil</a>
            <a href="formations/index.php">Formations</a>
            <a href="etudiants/index.php">Étudiants</a>
            <a href="modules/index.php">Modules</a>
        </nav>
    </div>
</header>
<main class="wrap">

<section class="hero">
    <h1>Centre de formation</h1>
    <p>Pilotez vos formations, vos étudiants et vos modules depuis un seul espace de gestion.</p>
</section>

<section class="grid3">
    <div class="card space">
        <div class="count"><?php echo $compteurs["formations"]; ?></div>
        <h2>Formations</h2>
        <p>Les cursus proposés par le centre, leur durée et leur tarif.</p>
        <a class="btn" href="formations/index.php">Gérer les formations</a>
    </div>

    <div class="card space">
        <div class="count"><?php echo $compteurs["etudiants"]; ?></div>
        <h2>Étudiants</h2>
        <p>Les inscrits, chacun rattaché à une formation.</p>
        <a class="btn" href="etudiants/index.php">Gérer les étudiants</a>
    </div>

    <div class="card space">
        <div class="count"><?php echo $compteurs["modules"]; ?></div>
        <h2>Modules</h2>
        <p>Les enseignements qui composent chaque formation.</p>
        <a class="btn" href="modules/index.php">Gérer les modules</a>
    </div>
</section>

<?php ?>
</main>

</body>
</html>

