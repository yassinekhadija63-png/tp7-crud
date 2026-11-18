<?php

require_once "../database/connexion.php";

if (!isset($_GET["id"])) {
    die("ID manquant.");
}

$id = $_GET["id"];

// Relations : on refuse de supprimer une formation qui a encore
// des étudiants ou des modules rattachés.
$sql = "
    SELECT
        (SELECT COUNT(*) FROM etudiants WHERE formation_id = :id1)
      + (SELECT COUNT(*) FROM modules   WHERE formation_id = :id2)
";

$statement = $pdo->prepare($sql);
$statement->execute(["id1" => $id, "id2" => $id]);

if ($statement->fetchColumn() > 0) {
    header("Location: index.php?erreur=liee");
    exit;
}

$statement = $pdo->prepare("DELETE FROM formations WHERE id = :id");
$statement->execute(["id" => $id]);

header("Location: index.php");
exit;
