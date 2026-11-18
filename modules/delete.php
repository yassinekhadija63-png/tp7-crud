<?php

require_once "../database/connexion.php";

if (!isset($_GET["id"])) {
    die("ID manquant.");
}

$id = $_GET["id"];

$statement = $pdo->prepare("DELETE FROM modules WHERE id = :id");
$statement->execute(["id" => $id]);

header("Location: index.php");
exit;
