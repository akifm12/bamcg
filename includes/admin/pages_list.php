<?php
require_once "../core/auth.php";
require_once "../core/db.php";
admin_required();

$stmt = $pdo->query("SELECT * FROM pages ORDER BY menu_order ASC, created_at DESC");
$pages = $stmt->fetchAll();

include "includes/admin_header.php";
?>

<h1 class="text-3xl font-bold mb-8">Manage Pages</h1>

<a href="add_page.php" class="px-5 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg mb-4 inline-block">+ Add New Page</a>

<table class="min-w-full bg-gray-900 rounded-lg overflow-hidden text-gray-200">
    <thead>
        <tr class="bg-gray-800">
            <th class="p-4 text-left">Title</th>
            <th class="p-4">Slug</th>
            <th class="p-4">Menu</th>
            <th class="p-4">Status</th>
            <th class="p-4">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($pages as $p): ?>
        <tr class="border-b border-gray-800 hover:bg-gray-850">
            <td class="p-4"><?= htmlspecialchars($p['title']) ?></td>
            <td class="p-4 text-blue-400"><?= $p['slug'] ?></td>
            <td class="p-4">
                <?= $p['show_in_menu'] ? "<span class='text-green-400'>Shown</span>" : "<span class='text-gray-500'>Hidden</span>" ?>
            </td>
            <td class="p-4">
                <?= $p['is_published'] ? "<span class='text-green-400'>Published</span>" : "<span class='text-gray-500'>Draft</span>" ?>
            </td>
            <td class="p-4 space-x-4">
                <a href="edit_page.php?id=<?= $p['id'] ?>" class="text-blue-400 hover:text-blue-300">Edit</a>
                <a href="delete_page.php?id=<?= $p['id'] ?>" onclick="return confirm('Delete this page?')" class="text-red-400 hover:text-red-300">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include "includes/admin_footer.php"; ?>
