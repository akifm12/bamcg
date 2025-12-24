<?php
require_once "../core/db.php";

$items = json_decode(file_get_contents("php://input"), true);

foreach ($items as $item) {
    $pdo->prepare("UPDATE page_blocks SET sort_order=? WHERE id=?")
        ->execute([$item['order'], $item['id']]);
}
