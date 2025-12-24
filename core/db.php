<?php
/* ================================
   DATABASE CONNECTION
   ================================ */

try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=bamcg;charset=utf8mb4",
        "root",
        "",
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

/* ================================
   BASE URL DETECTION
   Works on:
   ✔ localhost/bamcg/
   ✔ localhost/
   ✔ production domains
   ✔ subfolders
   ================================ */

$https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host  = $_SERVER['HTTP_HOST'];

// Get the folder where the project resides.
// Example: /bamcg/
$scriptFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';

// Combine into final base URL
define("BASE_URL", $https . $host . $scriptFolder);

/* ================================
   ROOT PATH (optional helper)
   Example: C:/laragon/www/bamcg/
   ================================ */

define("ROOT_PATH", rtrim($_SERVER['DOCUMENT_ROOT'] . $scriptFolder, '/\\') . '/');
?>
