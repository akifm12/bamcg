<?php
session_start();
require_once "../core/db.php";

$id = $_GET["id"];

$stmt = $pdo->prepare("SELECT thumbnail FROM blogs WHERE id = ?");
$stmt->execute([$id]);
$blog = $stmt->fetch();

if ($blog && $blog["thumbnail"] && file_exists("../uploads/blogs/" . $blog["thumbnail"])) {
    unlink("../uploads/blogs/" . $blog["thumbnail"]);
}

$stmt = $pdo->prepare("DELETE FROM blogs WHERE id = ?");
$stmt->execute([$id]);

header("Location: blog_list.php");
exit;
