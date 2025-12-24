<?php
require_once "database.php";

if (!isset($_GET['id'])) die("Missing regulation ID");

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM regulations WHERE id = :id");
$stmt->execute([":id" => $id]);

header("Location: regulations_list.php");
exit;
