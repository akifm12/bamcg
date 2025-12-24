<?php
include "includes/header.php";
require_once "database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $title));
    $excerpt = $_POST['excerpt'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $image = $_POST['image']; // you can upgrade later to file upload

    $stmt = $pdo->prepare("INSERT INTO blog_posts (title, slug, excerpt, content, category, image) 
                           VALUES (:title, :slug, :excerpt, :content, :category, :image)");
    $stmt->execute([
        ':title' => $title,
        ':slug' => $slug,
        ':excerpt' => $excerpt,
        ':content' => $content,
        ':category' => $category,
        ':image' => $image
    ]);

    header("Location: blog_list.php");
}
?>

<div class="container mx-auto px-6 py-10 text-white">

    <h1 class="text-3xl font-bold mb-6">Add New Blog Post</h1>

    <form method="POST">

        <label class="block mb-2">Title</label>
        <input type="text" name="title" required class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded mb-4">

        <label class="block mb-2">Excerpt</label>
        <textarea name="excerpt" class="w-full bg-gray-900 border border-gray-700 rounded px-4 py-2 mb-4"></textarea>

        <label class="block mb-2">Category</label>
        <input type="text" name="category" class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded mb-4">

        <label class="block mb-2">Featured Image URL</label>
        <input type="text" name="image" class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded mb-4">

        <label class="block mb-2">Content</label>
        <textarea id="editor" name="content" class="w-full bg-gray-900 border border-gray-700 rounded px-4 py-2"></textarea>

        <button class="mt-6 px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg">Publish</button>
    </form>
</div>

<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js"></script>
<script>
    tinymce.init({ selector:'#editor', height: 400, plugins: 'lists link image table code', toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist' });
</script>
