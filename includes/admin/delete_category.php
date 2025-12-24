<?php
require_once "database.php";

if (!isset($_GET['id'])) die("Missing category ID");

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM blog_categories WHERE id = :id");
$stmt->execute([":id" => $id]);

header("Location: categories_list.php");
exit;
