<?php
require_once "../core/auth.php";
require_once "../core/db.php";
admin_required();

if (!isset($_GET['id'])) {
    die("Missing ID.");
}

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM pages WHERE id = ?");
$stmt->execute([$id]);

header("Location: pages_list.php");
exit;
?>
