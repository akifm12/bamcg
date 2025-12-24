<?php
$targetDir = __DIR__ . "/../uploads/";

if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
}

if (!empty($_FILES['file']['name'])) {
    $fileName = time() . "_" . basename($_FILES['file']['name']);
    $targetFile = $targetDir . $fileName;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
        echo json_encode([
            'location' => "/uploads/" . $fileName
        ]);
    } else {
        http_response_code(400);
    }
}
?>
