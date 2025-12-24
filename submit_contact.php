<?php
require_once "core/db.php";

$stmt = $pdo->prepare("
    INSERT INTO contact_leads
    (company, name, email, phone, industry, created_at)
    VALUES (?, ?, ?, ?, ?, NOW())
");

$stmt->execute([
    $_POST['company'],
    $_POST['name'],
    $_POST['email'],
    $_POST['phone'],
    $_POST['industry']
]);

header("Location: thankyou.php");
exit;
