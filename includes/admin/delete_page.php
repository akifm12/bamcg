<?php
require_once "../core/auth.php";
require_once "../core/db.php";
admin_required();

$id = $_GET['id'] ?? null;
if (!$id) die("Missing ID.");

$stmt = $pdo->prepare("DELETE FROM pages WHERE id = ?");
$stmt->execute([$id]);

header("Location: pages_list.php");
exit;
