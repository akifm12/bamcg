<?php
require_once "core/db.php";

$company_name = $_POST['company_name'] ?? '';
$email        = $_POST['email'] ?? '';
$phone        = $_POST['phone'] ?? '';
$industry     = $_POST['industry'] ?? '';
$license_type = $_POST['license_type'] ?? '';
$emirate      = $_POST['emirate'] ?? '';
$services     = isset($_POST['services']) ? implode(", ", $_POST['services']) : '';
$comments     = $_POST['comments'] ?? '';

$stmt = $pdo->prepare("
    INSERT INTO inquiries 
    (company_name, email, phone, industry, license_type, emirate, services, comments, created_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
");
$stmt->execute([
    $company_name, $email, $phone, 
    $industry, $license_type, $emirate, 
    $services, $comments
]);

header("Location: thank-you.php");
exit;
