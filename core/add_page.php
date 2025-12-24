<?php
require_once "../core/auth.php";
require_once "../core/db.php";
admin_required();

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $slug  = strtolower(trim(str_replace(" ", "-", $_POST['slug'])));
    $content = $_POST['content'];
    $publish = isset($_POST['publish']) ? 1 : 0;

    $stmt = $pdo->prepare("INSERT INTO pages (title, slug, content, is_published) VALUES (?, ?, ?, ?)");
    $stmt->execute([$title, $slug, $content, $publish]);

    $msg = "Page created successfully!";
}
?>

<?php include 'includes/admin_header.php'; ?>

<div class="container mx-auto px-6 py-10">

<h1 class="text-3xl font-bold text-white mb-6">Add New Page</h1>

<?php if ($msg): ?>
    <p class="text-green-400 mb-4"><?= $msg ?></p>
<?php endif; ?>

<form method="POST">

    <label class="block text-gray-300 mb-2">Page Title</label>
    <input name="title" class="w-full p-3 bg-gray-800 text-white rounded mb-4">

    <label class="block text-gray-300 mb-2">Slug (URL)</label>
    <input name="slug" class="w-full p-3 bg-gray-800 text-white rounded mb-4">

    <label class="block text-gray-300 mb-2">Content (HTML allowed)</label>
    <textarea name="content" rows="10" class="w-full p-3 bg-gray-800 text-white rounded mb-4"></textarea>

    <label class="text-gray-300 flex items-center gap-2 mb-4">
        <input type="checkbox" name="publish" checked> Publish Page
    </label>

    <button class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
        Save Page
    </button>

</form>

</div>

<?php include 'includes/admin_footer.php'; ?>
