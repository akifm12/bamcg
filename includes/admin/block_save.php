<?php
require_once "../core/db.php";

$id = $_POST['id'] ?? null;  // null means add
$type = $_POST['type'];

$data = $_POST;
unset($data['id'], $data['type']);


// --- FILE HANDLING ---
if (!empty($_FILES['background_image']['name'])) {
    $fileName = time() . "_" . $_FILES['background_image']['name'];
    move_uploaded_file($_FILES['background_image']['tmp_name'], "../uploads/" . $fileName);
    $data['background_image'] = $fileName;
}

if (!empty($_FILES['image']['name'])) {
    $fileName = time() . "_" . $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $fileName);
    $data['image'] = $fileName;
}

if (!empty($_FILES['images']['name'][0])) {
    $imgs = [];
    foreach ($_FILES['images']['name'] as $i => $f) {
        $fileName = time() . "_" . $f;
        move_uploaded_file($_FILES['images']['tmp_name'][$i], "../uploads/" . $fileName);
        $imgs[] = $fileName;
    }
    $data['images'] = $imgs;
}

$json = json_encode($data);

// ADD NEW BLOCK
if (!$id) {
    $page_id = $_GET['page_id'];
    $stmt = $pdo->prepare("INSERT INTO page_blocks (page_id, block_type, block_data, sort_order) 
                           VALUES (?, ?, ?, 999)");
    $stmt->execute([$page_id, $type, $json]);
    exit("ok");
}

// EDIT EXISTING BLOCK
$stmt = $pdo->prepare("UPDATE page_blocks SET block_data=? WHERE id=?");
$stmt->execute([$json, $id]);

echo "ok";
