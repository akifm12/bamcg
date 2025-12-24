<?php
require_once "../core/auth.php";
require_once "../core/db.php";
admin_required();

$msg = "";

// Fetch categories
$cats = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'];
    $slug = strtolower(trim(str_replace(" ", "-", $_POST['slug'])));
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $category_id = $_POST['category_id'] ?: null;
    $content = $_POST['content'];
    $show_in_menu = isset($_POST['show_in_menu']) ? 1 : 0;
    $menu_order = $_POST['menu_order'] ?: 0;
    $publish = isset($_POST['publish']) ? 1 : 0;

    // Featured Image
    $featuredImage = null;
    if (!empty($_FILES['featured_image']['name'])) {
        $fileName = time() . "_" . $_FILES['featured_image']['name'];
        move_uploaded_file($_FILES['featured_image']['tmp_name'], "../uploads/" . $fileName);
        $featuredImage = $fileName;
    }

    $stmt = $pdo->prepare("
        INSERT INTO pages (title, slug, featured_image, category_id, meta_title, meta_description,
                           content, show_in_menu, menu_order, is_published)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([$title, $slug, $featuredImage, $category_id, $meta_title, $meta_description,
                    $content, $show_in_menu, $menu_order, $publish]);

    $msg = "Page created successfully!";
}

include "includes/admin_header.php";
?>

<h1 class="text-3xl font-bold mb-8">Add New Page</h1>

<?php if ($msg): ?>
<p class="text-green-400 mb-4"><?= $msg ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">

    <label class="block mb-2 text-gray-300">Page Title</label>
    <input name="title" class="w-full p-3 bg-gray-800 rounded mb-4 text-white">

    <label class="block mb-2 text-gray-300">Slug (URL)</label>
    <input name="slug" class="w-full p-3 bg-gray-800 rounded mb-4 text-white">

    <!-- Featured Image -->
    <label class="block mb-2 text-gray-300">Featured Image</label>
    <input type="file" name="featured_image" class="mb-4">

    <!-- Category -->
    <label class="block mb-2 text-gray-300">Category</label>
    <select name="category_id" class="w-full p-3 bg-gray-800 rounded mb-4">
        <option value="">— None —</option>
        <?php foreach ($cats as $c): ?>
        <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
        <?php endforeach; ?>
    </select>

    <!-- SEO -->
    <label class="block mb-2 text-gray-300">Meta Title</label>
    <input name="meta_title" class="w-full p-3 bg-gray-800 rounded mb-4">

    <label class="block mb-2 text-gray-300">Meta Description</label>
    <textarea name="meta_description" rows="3" class="w-full p-3 bg-gray-800 rounded mb-4"></textarea>

    <!-- Content -->
    <label class="block mb-2 text-gray-300">Content</label>
    <textarea name="content" rows="12" class="w-full p-3 bg-gray-800 rounded mb-4"></textarea>

    <!-- Menu Builder -->
    <label class="inline-flex items-center mb-4">
        <input type="checkbox" name="show_in_menu" class="mr-2"> Show in main menu
    </label>

    <label class="block mb-2 text-gray-300">Menu Order</label>
    <input name="menu_order" type="number" class="w-full p-3 bg-gray-800 rounded mb-4" value="0">

    <!-- Publish -->
    <label class="inline-flex items-center mb-6">
        <input type="checkbox" name="publish" checked class="mr-2"> Publish Now
    </label>

    <button class="px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg">Save Page</button>
</form>

<!-- TinyMCE -->
<script src="https://cdn.tiny.cloud/1/v6x6j9pup89xawa9rwdfshynwrj82i1bpzwqq6ksyyexkdot/tinymce/6/tinymce.min.js"></script>
<script>
tinymce.init({
    selector: 'textarea[name="content"]',
    height: 500,
    skin: "oxide-dark",
    content_css: "dark",
    plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount',
    toolbar: 'undo redo | blocks fontsize | bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table | link image media | code fullscreen',
    automatic_uploads: true,
    images_upload_url: 'upload_image.php',
    images_upload_credentials: true,
    branding: false
});
</script>

<?php include "includes/admin_footer.php"; ?>
