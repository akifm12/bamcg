<?php
require_once "../core/auth.php";
require_once "../core/db.php";
admin_required();

$id = $_GET['id'] ?? null;
if (!$id) die("Missing page ID.");

$stmt = $pdo->prepare("SELECT * FROM pages WHERE id = ?");
$stmt->execute([$id]);
$page = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$page) die("Page not found.");

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $slug  = strtolower(trim(str_replace(" ", "-", $_POST['slug'])));
    $content = $_POST['content'];
    $publish = isset($_POST['publish']) ? 1 : 0;

    $update = $pdo->prepare("UPDATE pages SET title=?, slug=?, content=?, is_published=? WHERE id=?");
    $update->execute([$title, $slug, $content, $publish, $id]);

    $msg = "Page updated successfully!";
    
    // Refresh page data
    $stmt->execute([$id]);
    $page = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<?php include 'includes/admin_header.php'; ?>

<div class="container mx-auto px-6 py-10">

<h1 class="text-3xl font-bold text-white mb-6">Edit Page</h1>

<?php if ($msg): ?>
    <p class="text-green-400 mb-4"><?= $msg ?></p>
<?php endif; ?>

<form method="POST">

    <label class="block text-gray-300 mb-2">Page Title</label>
    <input name="title" value="<?= htmlspecialchars($page['title']) ?>" 
           class="w-full p-3 bg-gray-800 text-white rounded mb-4">

    <label class="block text-gray-300 mb-2">Slug (URL)</label>
    <input name="slug" value="<?= htmlspecialchars($page['slug']) ?>" 
           class="w-full p-3 bg-gray-800 text-white rounded mb-4">

    <label class="block text-gray-300 mb-2">Content (HTML allowed)</label>
    <textarea name="content" rows="12" 
              class="w-full p-3 bg-gray-800 text-white rounded mb-4"><?= htmlspecialchars($page['content']) ?></textarea>

    <label class="text-gray-300 flex items-center gap-2 mb-4">
        <input type="checkbox" name="publish" <?= $page['is_published'] ? 'checked' : '' ?>> Publish Page
    </label>

    <button class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
        Save Changes
    </button>

</form>

</div>

<?php include 'includes/admin_footer.php'; ?>
