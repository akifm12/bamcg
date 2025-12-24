<?php
require_once "../core/db.php";

if (!isset($_GET['id'])) die("Missing regulation ID");
$id = $_GET['id'];

// Fetch regulation
$stmt = $pdo->prepare("SELECT * FROM regulations WHERE id=:id");
$stmt->execute([":id" => $id]);
$reg = $stmt->fetch();

if (!$reg) die("Regulation not found");

// Fetch categories
$categories = $pdo->query("SELECT * FROM regulation_categories ORDER BY name ASC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'];
    $slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $title));
    $summary = $_POST['summary'];
    $content = $_POST['content'];
    $category_id = $_POST['category_id'];

    $pdf_link = $reg['pdf_link'];

    if (!empty($_FILES['pdf']['name'])) {

        $fileName = time() . "_" . basename($_FILES['pdf']['name']);
        $targetPath = "../uploads/regulations/" . $fileName;

        if (move_uploaded_file($_FILES['pdf']['tmp_name'], $targetPath)) {
            $pdf_link = "/uploads/regulations/" . $fileName;
        }
    }

    $update = $pdo->prepare("
        UPDATE regulations 
        SET title=:title, slug=:slug, summary=:summary, content=:content, 
            category_id=:cat, pdf_link=:pdf 
        WHERE id=:id
    ");

    $update->execute([
        ":title" => $title,
        ":slug" => $slug,
        ":summary" => $summary,
        ":content" => $content,
        ":cat" => $category_id,
        ":pdf" => $pdf_link,
        ":id" => $id
    ]);

    header("Location: regulations_list.php");
    exit;
}
include "includes/admin_header.php";
?>

<div class="container mx-auto px-6 py-10 text-white">

    <h1 class="text-3xl font-bold mb-6">Edit Regulation</h1>

    <form method="POST" enctype="multipart/form-data">

        <label class="block mb-2">Title</label>
        <input type="text" name="title" 
               value="<?= htmlspecialchars($reg['title']) ?>" required
               class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded mb-4">

        <label class="block mb-2">Category</label>
        <select name="category_id" required
                class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded mb-4">
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id']; ?>"
                    <?= $reg['category_id']==$cat['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label class="block mb-2">Summary</label>
        <textarea name="summary" rows="3"
                  class="w-full bg-gray-900 border border-gray-700 rounded px-4 py-2 mb-4"><?= htmlspecialchars($reg['summary']); ?></textarea>

        <label class="block mb-2">Uploaded PDF</label>
        <?php if ($reg['pdf_link']): ?>
            <a href="..<?= $reg['pdf_link'] ?>" target="_blank" class="text-blue-400 underline">View Current PDF</a>
        <?php else: ?>
            <p class="text-gray-400">No PDF uploaded</p>
        <?php endif; ?>

        <label class="block mb-2 mt-4">Upload New PDF (optional)</label>
        <input type="file" name="pdf" accept="application/pdf"
               class="w-full bg-gray-900 border border-gray-700 rounded mb-4 p-3">

        <label class="block mb-2">Full Content</label>
        <textarea id="editor" name="content"
                  class="w-full bg-gray-900 border border-gray-700 rounded px-4 py-2 mb-6"><?= $reg['content']; ?></textarea>

        <button class="px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg">
            Save Changes
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
