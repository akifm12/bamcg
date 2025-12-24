<?php
require_once "../core/db.php";
// Fetch categories
$categories = $pdo->query("SELECT * FROM regulation_categories ORDER BY name ASC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'];
    $slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $title));
    $summary = $_POST['summary'];
    $content = $_POST['content'];
    $category_id = $_POST['category_id'];

    // PDF Upload
    $pdf_link = null;

    if (!empty($_FILES['pdf']['name'])) {
        
        $fileName = time() . "_" . basename($_FILES['pdf']['name']);
        $targetPath = "../uploads/regulations/" . $fileName;

        if (move_uploaded_file($_FILES['pdf']['tmp_name'], $targetPath)) {
            $pdf_link = "uploads/regulations/" . $fileName;
        }
    }

    // Insert into DB
    $stmt = $pdo->prepare("
        INSERT INTO regulations (title, slug, summary, content, category_id, pdf_link)
        VALUES (:title, :slug, :summary, :content, :cat, :pdf)
    ");

    $stmt->execute([
        ":title" => $title,
        ":slug" => $slug,
        ":summary" => $summary,
        ":content" => $content,
        ":cat" => $category_id,
        ":pdf" => $pdf_link
    ]);

    header("Location: regulations_list.php");
    exit;
}
include "includes/admin_header.php";
?>

<div class="container mx-auto px-6 py-10 text-white">

    <h1 class="text-3xl font-bold mb-6">Add Regulation</h1>

    <form method="POST" enctype="multipart/form-data">

        <label class="block mb-2">Title</label>
        <input type="text" name="title" required
               class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded mb-4">

        <label class="block mb-2">Category</label>
        <select name="category_id" required
                class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded mb-4">
            <option value="">Select Category</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id']; ?>"><?= htmlspecialchars($cat['name']); ?></option>
            <?php endforeach; ?>
        </select>

        <label class="block mb-2">Summary</label>
        <textarea name="summary" rows="3"
                  class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded mb-4"></textarea>

        <label class="block mb-2">PDF File</label>
        <input type="file" name="pdf" accept="application/pdf"
               class="w-full bg-gray-900 border border-gray-700 rounded mb-4 p-3">

        <label class="block mb-2">Full Content (optional)</label>
        <textarea id="editor" name="content"
                  class="w-full bg-gray-900 border border-gray-700 rounded px-4 py-2 mb-6"></textarea>

        <button class="px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg">
            Save Regulation
        </button>

    </form>
</div>

<script src="https://cdn.tiny.cloud/1/v6x6j9pup89xawa9rwdfshynwrj82i1bpzwqq6ksyyexkdot/tinymce/6/tinymce.min.js"></script>
<script>
tinymce.init({
    selector:'#editor',
    height: 400,
    plugins: 'lists link image table code',
    toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | code'
});
</script>
