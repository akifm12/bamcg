<?php
session_start();
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Temporary login (upgrade later)
    if ($username === "admin" && $password === "password123") {
        $_SESSION['admin'] = true;
        header("Location: dashboard.php");
        exit;
    }

    $error = "Invalid login credentials.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Admin Login</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-950 text-white flex items-center justify-center min-h-screen">

<div class="bg-gray-900 p-10 rounded-xl shadow-xl w-full max-w-md">
    <h1 class="text-3xl font-bold text-center mb-6">Admin Login</h1>

    <?php if ($error): ?>
        <p class="text-red-400 mb-4 text-center"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST">
        <label class="block mb-2">Username</label>
        <input type="text" name="username" class="w-full p-3 bg-gray-800 rounded mb-4 text-white">

        <label class="block mb-2">Password</label>
        <input type="password" name="password" class="w-full p-3 bg-gray-800 rounded mb-6 text-white">

        <button class="w-full bg-blue-600 hover:bg-blue-700 py-3 rounded-lg">Login</button>
    </form>
</div>

</body>
</html>
