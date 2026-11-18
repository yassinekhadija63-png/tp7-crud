<?php

require_once "../database/connexion.php";

if (!isset($_GET["id"])) {
    die("ID manquant.");
}

$id = $_GET["id"];

$statement = $pdo->prepare("SELECT * FROM etudiants WHERE id = :id");
$statement->execute(["id" => $id]);
$etudiant = $statement->fetch(PDO::FETCH_ASSOC);

if (!$etudiant) {
    die("Étudiant introuvable.");
}

$formations = $pdo
    ->query("SELECT id, intitule FROM formations ORDER BY intitule")
    ->fetchAll(PDO::FETCH_ASSOC);

$erreur = "";

if (
    isset($_POST["nom"])
    && isset($_POST["prenom"])
    && isset($_POST["email"])
    && isset($_POST["formation_id"])
) {

    $sql = "
        UPDATE etudiants
        SET
            nom = :nom,
            prenom = :prenom,
            email = :email,
            formation_id = :formation_id
        WHERE id = :id
    ";

    try {
        $statement = $pdo->prepare($sql);
        $statement->execute([
            "nom"              => trim($_POST["nom"]),
            "prenom"           => trim($_POST["prenom"]),
            "email"            => trim($_POST["email"]),
            "formation_id"     => $_POST["formation_id"],
            "id"               => $id
        ]);

        header("Location: index.php");
        exit;
    } catch (PDOException $ex) {
        $erreur = "Modification impossible : cet email est peut-être déjà utilisé.";
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier un étudiant · Campus Atlas</title>
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

<div class="head"><div><h1>Modifier l'étudiant</h1><p>Mettez à jour la fiche de l'étudiant.</p></div></div>

<?php if ($erreur) { ?><div class="alert err"><?php echo htmlspecialchars($erreur); ?></div><?php } ?>

<form method="POST" class="card form">
    <div class="row2">
        <div class="field">
            <label for="prenom">Prénom</label>
            <input type="text" id="prenom" name="prenom" maxlength="80"
                   value="<?php echo htmlspecialchars($etudiant["prenom"]); ?>" required>
        </div>
        <div class="field">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" maxlength="80"
                   value="<?php echo htmlspecialchars($etudiant["nom"]); ?>" required>
        </div>
    </div>

    <div class="field">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" maxlength="150"
               value="<?php echo htmlspecialchars($etudiant["email"]); ?>" required>
    </div>

    <div class="field">
        <label for="formation_id">Formation</label>
        <select id="formation_id" name="formation_id" required>
            <?php foreach ($formations as $f) { ?>
                <option value="<?php echo $f["id"]; ?>"
                    <?php echo ($f["id"] == $etudiant["formation_id"]) ? "selected" : ""; ?>>
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

