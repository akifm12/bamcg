<?php
require_once "../core/auth.php";
require_once "../core/db.php";
admin_required();

$stmt = $pdo->query("SELECT * FROM pages ORDER BY created_at DESC");
$pages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'includes/admin_header.php'; ?>

<div class="container mx-auto px-6 py-10">
    <h1 class="text-3xl font-bold text-white mb-6">Manage Pages</h1>

    <a href="add_page.php" class="mb-4 inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
        + Add New Page
    </a>

    <table class="min-w-full bg-gray-900 text-gray-300 rounded-lg overflow-hidden">
        <thead>
            <tr class="bg-gray-800 text-left">
                <th class="p-4">Title</th>
                <th class="p-4">Slug</th>
                <th class="p-4">Status</th>
                <th class="p-4">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pages as $p): ?>
            <tr class="border-b border-gray-700">
                <td class="p-4"><?= htmlspecialchars($p['title']) ?></td>
                <td class="p-4 text-blue-400">/<?= $p['slug'] ?></td>
                <td class="p-4"><?= $p['is_published'] ? "Published" : "Draft" ?></td>
                <td class="p-4">
                    <a href="edit_page.php?id=<?= $p['id'] ?>" class="text-blue-400 mr-4">Edit</a>
                    <a href="delete_page.php?id=<?= $p['id'] ?>" class="text-red-400"
                        onclick="return confirm('Delete this page?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<?php include 'includes/admin_footer.php'; ?>
