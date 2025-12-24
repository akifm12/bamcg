<?php
include "includes/header.php";
require_once "database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $name));

    $stmt = $pdo->prepare("INSERT INTO blog_categories (name, slug) VALUES (:name, :slug)");
    $stmt->execute([":name" => $name, ":slug" => $slug]);

    header("Location: categories_list.php");
    exit;
}
?>

<div class="container mx-auto px-6 py-10 text-white">

    <h1 class="text-3xl font-bold mb-6">Add Category</h1>

    <form method="POST">

        <label class="block mb-2">Category Name</label>
        <input type="text" name="name" required
               class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded mb-4">

        <button class="mt-4 px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg">Create Category</button>

    </form>
</div>
