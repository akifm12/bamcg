<?php
include "includes/header.php";
require_once "database.php";

// Get the blog post
if (!isset($_GET['id'])) {
    die("Missing post ID");
}

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE id = :id");
$stmt->execute([":id" => $id]);
$post = $stmt->fetch();

if (!$post) {
    die("Post not found");
}

// Update logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'];
    $slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $title));
    $excerpt = $_POST['excerpt'];
    $category = $_POST['category'];
    $image = $_POST['image'];
    $content = $_POST['content'];
    $is_published = isset($_POST['is_published']) ? 1 : 0;

    $update = $pdo->prepare("
        UPDATE blog_posts 
        SET title = :title,
            slug = :slug,
            excerpt = :excerpt,
            category = :category,
            image = :image,
            content = :content,
            is_published = :is_published
        WHERE id = :id
    ");

    $update->execute([
        ":title" => $title,
        ":slug" => $slug,
        ":excerpt" => $excerpt,
        ":category" => $category,
        ":image" => $image,
        ":content" => $content,
        ":is_published" => $is_published,
        ":id" => $id
    ]);

    header("Location: blog_list.php");
    exit;
}
	$categories = $pdo->query("SELECT * FROM blog_categories ORDER BY name ASC")->fetchAll();
?>

<div class="container mx-auto px-6 py-10 text-white">

    <h1 class="text-3xl font-bold mb-6">Edit Blog Post</h1>

    <form method="POST">

		<label class="block mb-2">Category</label>
		<select name="category_id" required 
				class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded mb-4">
			<option value="">Select Category</option>

			<?php foreach ($categories as $cat): ?>
				<option value="<?= $cat['id']; ?>"
				<?= (isset($post) && $post['category_id'] == $cat['id']) ? 'selected' : '' ?>>
					<?= htmlspecialchars($cat['name']); ?>
				</option>
			<?php endforeach; ?>

		</select>
        <label class="block mb-2">Title</label>
        <input type="text" name="title" value="<?= htmlspecialchars($post['title']); ?>" required
               class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded mb-4">

        <label class="block mb-2">Excerpt</label>
        <textarea name="excerpt"
                  class="w-full bg-gray-900 border border-gray-700 rounded px-4 py-2 mb-4"><?= htmlspecialchars($post['excerpt']); ?></textarea>

        <label class="block mb-2">Category</label>
        <input type="text" name="category" value="<?= htmlspecialchars($post['category']); ?>"
               class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded mb-4">

        <label class="block mb-2">Featured Image URL</label>
        <input type="text" name="image" value="<?= htmlspecialchars($post['image']); ?>"
               class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded mb-4">

        <?php if ($post['image']): ?>
            <img src="<?= $post['image']; ?>" class="w-48 rounded-lg mb-4 border border-gray-700">
        <?php endif; ?>

        <label class="block mb-2">Content</label>
        <textarea id="editor" name="content"
                  class="w-full bg-gray-900 border border-gray-700 rounded px-4 py-2"><?= htmlspecialchars($post['content']); ?></textarea>

        <label class="flex items-center gap-2 mt-4">
            <input type="checkbox" name="is_published" <?= $post['is_published'] ? "checked" : "" ?>>
            <span>Published</span>
        </label>

        <button class="mt-6 px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg">Update Post</button>

    </form>
</div>

<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js"></script>
<script>
    tinymce.init({ 
        selector:'#editor', 
        height: 450,
        plugins: 'lists link image table code',
        toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright | bullist numlist | link | code'
    });
</script>
