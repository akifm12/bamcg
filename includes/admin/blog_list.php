<?php 
session_start();
require_once "../core/db.php"; 

include "includes/admin_header.php";

$stmt = $pdo->query("SELECT id, title, slug, created_at, thumbnail FROM blogs ORDER BY created_at DESC");
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="container mx-auto px-6 py-10">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Blog Posts</h1>
        <a href="blog_add.php" 
           class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
           Add New Post
        </a>
    </div>

    <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-gray-700 text-gray-300">
                    <th class="py-3">Thumbnail</th>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($blogs as $b): ?>
                <tr class="border-b border-gray-800">
                    <td class="py-3">
                        <?php if ($b['thumbnail']): ?>
                            <img src="../uploads/blogs/<?= $b['thumbnail'] ?>" class="h-12 rounded">
                        <?php else: ?>
                            <div class="h-12 w-12 bg-gray-700 rounded"></div>
                        <?php endif; ?>
                    </td>

                    <td class="text-white"><?= htmlspecialchars($b['title']) ?></td>
                    <td class="text-gray-400"><?= htmlspecialchars($b['slug']) ?></td>
                    <td class="text-gray-400"><?= date("M j, Y", strtotime($b["created_at"])) ?></td>

                    <td>
                        <a href="blog_edit.php?id=<?= $b['id'] ?>" 
                           class="text-blue-400 hover:text-blue-300 mr-4">Edit</a>

                        <a href="blog_delete.php?id=<?= $b['id'] ?>"
                           onclick="return confirm('Delete this post?')"
                           class="text-red-400 hover:text-red-300">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>

                <?php if (count($blogs) === 0): ?>
                <tr>
                    <td colspan="5" class="text-center text-gray-400 py-6">
                        No blog posts found.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


