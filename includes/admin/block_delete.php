<?php
require_once "../core/db.php";

$id = $_GET['id'];
$page_id = $_GET['page_id'];

$pdo->prepare("DELETE FROM page_blocks WHERE id=?")->execute([$id]);

header("Location: edit_blocks.php?page_id=".$page_id);
exit;
