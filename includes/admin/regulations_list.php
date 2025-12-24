<?php
include "includes/admin_header.php";
require_once "../core/db.php";

$stmt = $pdo->query("
    SELECT r.*, c.name AS category_name
    FROM regulations r
    LEFT JOIN regulation_categories c ON c.id = r.category_id
    ORDER BY r.created_at DESC
");
$regs = $stmt->fetchAll();
?>

<div class="container mx-auto px-6 py-10 text-white">

    <div class="flex justify-between mb-6">
        <h1 class="text-3xl font-bold">Regulations</h1>
        <a href="add_regulation.php" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg">Add Regulation</a>
    </div>

    <table class="w-full text-left border border-gray-700">
        <tr class="bg-gray-800">
            <th class="p-3">Title</th>
            <th class="p-3">Category</th>
            <th class="p-3">PDF</th>
            <th class="p-3">Actions</th>
        </tr>
        <?php foreach ($regs as $r): ?>
        <tr class="border-b border-gray-700">
            <td class="p-3"><?= htmlspecialchars($r['title']); ?></td>
            <td class="p-3 text-gray-300"><?= htmlspecialchars($r['category_name']); ?></td>
            <td class="p-3">
                <?php if ($r['pdf_link']): ?>
				   <a href="..<?= $r['pdf_link']; ?>" class="text-blue-400" target="_blank">View</a> 
				<?php else: ?>
                    <span class="text-gray-500">No PDF</span>
                <?php endif; ?>
            </td>
            <td class="p-3 flex gap-4">
                <a href="edit_regulation.php?id=<?= $r['id']; ?>" class="text-blue-400">Edit</a>
                <a href="delete_regulation.php?id=<?= $r['id']; ?>" class="text-red-400"
                   onclick="return confirm('Are you sure you want to delete this regulation?');">
                   Delete
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
