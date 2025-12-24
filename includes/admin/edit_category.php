<?php
include "includes/header.php";
require_once "database.php";

if (!isset($_GET['id'])) die("Missing category ID");

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM blog_categories WHERE id = :id");
$stmt->execute([":id" => $id]);
$cat = $stmt->fetch();

if (!$cat) die("Category not found.");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $name));

    $update = $pdo->prepare("UPDATE blog_categories SET name=:name, slug=:slug WHERE id=:id");
    $update->execute([
        ":name" => $name,
        ":slug" => $slug,
        ":id" => $id
    ]);

    header("Location: categories_list.php");
    exit;
}
?>

<div class="container mx-auto px-6 py-10 text-white">
    
    <h1 class="text-3xl font-bold mb-6">Edit Category</h1>

    <form method="POST">

        <label class="block mb-2">Category Name</label>
        <input type="text" name="name" value="<?= htmlspecialchars($cat['name']) ?>" required
               class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded mb-4">

        <button class="mt-4 px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg">Save Changes</button>

    </form>
</div>
