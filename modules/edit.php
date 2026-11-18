<?php

require_once "../database/connexion.php";

if (!isset($_GET["id"])) {
    die("ID manquant.");
}

$id = $_GET["id"];

$statement = $pdo->prepare("SELECT * FROM modules WHERE id = :id");
$statement->execute(["id" => $id]);
$module = $statement->fetch(PDO::FETCH_ASSOC);

if (!$module) {
    die("Module introuvable.");
}

$formations = $pdo
    ->query("SELECT id, intitule FROM formations ORDER BY intitule")
    ->fetchAll(PDO::FETCH_ASSOC);

if (
    isset($_POST["intitule"])
    && isset($_POST["volume_horaire"])
    && isset($_POST["semestre"])
    && isset($_POST["formation_id"])
) {

    $sql = "
        UPDATE modules
        SET
            intitule = :intitule,
            volume_horaire = :volume_horaire,
            semestre = :semestre,
            formation_id = :formation_id
        WHERE id = :id
    ";

    $statement = $pdo->prepare($sql);

    $statement->execute([
        "intitule"       => trim($_POST["intitule"]),
        "volume_horaire" => $_POST["volume_horaire"],
        "semestre"       => $_POST["semestre"],
        "formation_id"   => $_POST["formation_id"],
        "id"             => $id
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
    <title>Modifier un module · Campus Atlas</title>
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

<div class="head"><div><h1>Modifier le module</h1><p>Mettez à jour l'enseignement.</p></div></div>

<form method="POST" class="card form">
    <div class="field">
        <label for="intitule">Intitulé</label>
        <input type="text" id="intitule" name="intitule" maxlength="120"
               value="<?php echo htmlspecialchars($module["intitule"]); ?>" required>
    </div>

    <div class="row2">
        <div class="field">
            <label for="volume_horaire">Volume horaire (h)</label>
            <input type="number" id="volume_horaire" name="volume_horaire" min="1"
                   value="<?php echo htmlspecialchars($module["volume_horaire"]); ?>" required>
        </div>
        <div class="field">
            <label for="semestre">Semestre</label>
            <input type="number" id="semestre" name="semestre" min="1" max="8"
                   value="<?php echo htmlspecialchars($module["semestre"]); ?>" required>
        </div>
    </div>

    <div class="field">
        <label for="formation_id">Formation</label>
        <select id="formation_id" name="formation_id" required>
            <?php foreach ($formations as $f) { ?>
                <option value="<?php echo $f["id"]; ?>"
                    <?php echo ($f["id"] == $module["formation_id"]) ? "selected" : ""; ?>>
                    <?php echo htmlspecialchars($f["intitule"]); ?>
                </option>
            <?php } ?>
        </select>
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

