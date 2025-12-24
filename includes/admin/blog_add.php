<?php 
session_start();
require_once "../core/db.php"; 
include "includes/admin_header.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = trim($_POST["title"]);
    $slug = strtolower(trim(preg_replace("/[^a-z0-9]+/i", "-", $title), "-"));
    $content = $_POST["content"];

    $thumbnailName = null;

    if (!empty($_FILES["thumbnail"]["name"])) {
        $ext = pathinfo($_FILES["thumbnail"]["name"], PATHINFO_EXTENSION);
        $thumbnailName = time() . "_" . rand(1000,9999) . "." . $ext;
        move_uploaded_file($_FILES["thumbnail"]["tmp_name"], "../uploads/blogs/" . $thumbnailName);
    }

    $stmt = $pdo->prepare("
        INSERT INTO blogs (title, slug, content, thumbnail)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->execute([$title, $slug, $content, $thumbnailName]);

    $success = "Blog post created successfully.";
}
?>

<!-- ============================= -->
<!-- TINYMCE -->
<!-- ============================= -->
<script src="https://cdn.tiny.cloud/1/v6x6j9pup89xawa9rwdfshynwrj82i1bpzwqq6ksyyexkdot/tinymce/6/tinymce.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    tinymce.init({
        selector: 'textarea[name="content"]',
        height: 400,
        menubar: false,
        branding: false,
        plugins: 'lists link table code',
        toolbar: `
            undo redo |
            formatselect |
            bold italic underline |
            bullist numlist |
            link table |
            code
        `,
        content_style: `
            body {
                font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont;
                font-size: 15px;
            }
        `
    });

    // 🔴 CRITICAL: sync editor content before submit
    const form = document.querySelector("form");
    form.addEventListener("submit", function () {
        tinymce.triggerSave();
    });

});
</script>

<div class="container mx-auto px-6 py-10">
    <h1 class="text-3xl font-bold mb-6">Add New Blog Post</h1>

    <?php if ($success): ?>
        <div class="p-4 bg-green-700 text-white rounded mb-6">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" class="space-y-6">

        <!-- TITLE -->
        <div>
            <label class="block text-gray-300 mb-2">Title</label>
            <input type="text"
                   name="title"
                   required
                   class="w-full bg-gray-800 border border-gray-700 px-4 py-3 rounded text-white">
        </div>

        <!-- THUMBNAIL -->
        <div>
            <label class="block text-gray-300 mb-2">Thumbnail (optional)</label>
            <input type="file"
                   name="thumbnail"
                   accept="image/*"
                   class="text-gray-300">
        </div>

        <!-- CONTENT -->
        <div>
            <label class="block text-gray-300 mb-2">Content</label>
            <textarea name="content"
                      rows="12"
                      required
                      class="w-full bg-gray-800 border border-gray-700 px-4 py-3 rounded text-white">
            </textarea>
        </div>

        <!-- SUBMIT -->
        <button type="submit"
                class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold">
            Publish Post
        </button>

    </form>
</div>
