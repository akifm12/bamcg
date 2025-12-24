<?php
require_once "core/db.php";  // your DB path

$data = json_decode(file_get_contents("php://input"), true);

$stmt = $pdo->prepare("
    INSERT INTO leads (name, email, phone, company, industry, regulator, comments)
    VALUES (:name, :email, :phone, :company, :industry, :regulator, :comments)
");

$stmt->execute([
    ":name" => $data['name'],
    ":email" => $data['email'],
    ":phone" => $data['phone'],
    ":company" => $data['company'],
    ":industry" => $data['industry'],
    ":regulator" => $data['regulator'],
    ":comments" => $data['comments'],
]);

// Send email
$to = "akif@bluearrow.ae";
$subject = "New Compliance Lead from Website";

$message = "
New Lead Submission:

Name: {$data['name']}
Email: {$data['email']}
Phone: {$data['phone']}
Company: {$data['company']}
Industry: {$data['industry']}
Regulator: {$data['regulator']}
Comments: {$data['comments']}
";

$headers = "From: noreply@bluearrow.ae";

mail($to, $subject, $message, $headers);

echo json_encode(["success" => true]);
?>
