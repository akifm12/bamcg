<?php
require_once "database.php";

if (!isset($_GET['id'])) {
    die("Missing post ID");
}

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM blog_posts WHERE id = :id");
$stmt->execute([":id" => $id]);

header("Location: blog_list.php");
exit;
