<?php

require_once "../database/connexion.php";

if (!isset($_GET["id"])) {
    die("ID manquant.");
}

$id = $_GET["id"];

$statement = $pdo->prepare("SELECT * FROM formations WHERE id = :id");
$statement->execute(["id" => $id]);
$formation = $statement->fetch(PDO::FETCH_ASSOC);

if (!$formation) {
    die("Formation introuvable.");
}

if (
    isset($_POST["intitule"])
    && isset($_POST["duree_mois"])
    && isset($_POST["tarif"])
) {

    $sql = "
        UPDATE formations
        SET
            intitule   = :intitule,
            duree_mois = :duree_mois,
            tarif      = :tarif
        WHERE id = :id
    ";

    $statement = $pdo->prepare($sql);

    $statement->execute([
        "intitule"   => trim($_POST["intitule"]),
        "duree_mois" => $_POST["duree_mois"],
        "tarif"      => $_POST["tarif"],
        "id"         => $id
    ]);

    header("Location: index.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier une formation · Campus Atlas</title>
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

<div class="head"><div><h1>Modifier la formation</h1><p>Mettez à jour les informations du cursus.</p></div></div>

<form method="POST" class="card form">
    <div class="field">
        <label for="intitule">Intitulé</label>
        <input type="text" id="intitule" name="intitule" maxlength="120"
               value="<?php echo htmlspecialchars($formation["intitule"]); ?>" required>
    </div>

    <div class="row2">
        <div class="field">
            <label for="duree_mois">Durée (mois)</label>
            <input type="number" id="duree_mois" name="duree_mois" min="1"
                   value="<?php echo htmlspecialchars($formation["duree_mois"]); ?>" required>
        </div>
        <div class="field">
            <label for="tarif">Tarif (DH)</label>
            <input type="number" id="tarif" name="tarif" step="0.01" min="0"
                   value="<?php echo htmlspecialchars($formation["tarif"]); ?>" required>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn">Mettre à jour</button>
        <a class="btn light" href="index.php">Annuler</a>
    </div>
</form>

<?php ?>
</main>

</body>
</html>

