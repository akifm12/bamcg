<?php
include "includes/header.php";
require_once "database.php";

$stmt = $pdo->query("SELECT * FROM blog_categories ORDER BY name ASC");
$categories = $stmt->fetchAll();
?>

<div class="container mx-auto px-6 py-10 text-white">

    <div class="flex justify-between mb-6">
        <h1 class="text-3xl font-bold">Blog Categories</h1>
        <a href="add_category.php" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg">Add Category</a>
    </div>

    <table class="w-full text-left border border-gray-700">
        <tr class="bg-gray-800">
            <th class="p-3">Name</th>
            <th class="p-3">Slug</th>
            <th class="p-3">Actions</th>
        </tr>

        <?php foreach ($categories as $cat): ?>
        <tr class="border-b border-gray-700">
            <td class="p-3"><?= htmlspecialchars($cat['name']) ?></td>
            <td class="p-3 text-gray-400"><?= $cat['slug'] ?></td>
            <td class="p-3 flex gap-3">
                <a href="edit_category.php?id=<?= $cat['id']; ?>" class="text-blue-400">Edit</a>
                <a href="delete_category.php?id=<?= $cat['id']; ?>" class="text-red-400">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

</div>
