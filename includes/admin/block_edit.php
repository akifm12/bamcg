<?php
require_once "../core/db.php";

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM page_blocks WHERE id=?");
$stmt->execute([$id]);
$block = $stmt->fetch();

if (!$block) {
    echo "<div class='text-red-400'>Block not found.</div>";
    exit;
}

$type = $block['block_type'];
$data = json_decode($block['block_data'], true);
?>

<form id="blockEditForm" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?= $id ?>">
<input type="hidden" name="type" value="<?= $type ?>">

<?php if ($type === "hero"): ?>

    <label class="block mb-2">Title</label>
    <input name="title" value="<?= $data['title'] ?? '' ?>" class="w-full p-3 bg-gray-800 rounded mb-4">

    <label class="block mb-2">Subtitle</label>
    <input name="subtitle" value="<?= $data['subtitle'] ?? '' ?>" class="w-full p-3 bg-gray-800 rounded mb-4">

    <label class="block mb-2">Button Text</label>
    <input name="button_text" value="<?= $data['button_text'] ?? '' ?>" class="w-full p-3 bg-gray-800 rounded mb-4">

    <label class="block mb-2">Button Link</label>
    <input name="button_link" value="<?= $data['button_link'] ?? '' ?>" class="w-full p-3 bg-gray-800 rounded mb-4">

    <label class="block mb-2">Background Image</label>
    <input type="file" name="background_image" class="w-full">

    <?php if (!empty($data['background_image'])): ?>
        <img src="/uploads/<?= $data['background_image'] ?>" class="w-32 mt-3 rounded">
    <?php endif; ?>

<?php elseif ($type === "text"): ?>

    <label class="block mb-2">Text Content</label>
    <textarea name="content" rows="8" class="w-full p-3 bg-gray-800 rounded"><?= $data['content'] ?? '' ?></textarea>

<?php elseif ($type === "text_image"): ?>

    <label class="block mb-2">Title</label>
    <input name="title" value="<?= $data['title'] ?? '' ?>" class="w-full p-3 bg-gray-800 rounded mb-4">

    <label class="block mb-2">Text</label>
    <textarea name="text" rows="6" class="w-full p-3 bg-gray-800 rounded mb-4"><?= $data['text'] ?? '' ?></textarea>

    <label class="block mb-2">Image</label>
    <input type="file" name="image">
    <?php if (!empty($data['image'])): ?>
        <img src="/uploads/<?= $data['image'] ?>" class="w-32 mt-3 rounded">
    <?php endif; ?>

<?php elseif ($type === "features"): ?>

    <label class="block mb-2">Section Title</label>
    <input name="title" value="<?= $data['title'] ?>" class="w-full p-3 bg-gray-800 rounded mb-4">

    <label class="block mb-2">Subtitle</label>
    <input name="subtitle" value="<?= $data['subtitle'] ?>" class="w-full p-3 bg-gray-800 rounded mb-4">

    <?php for ($i=1; $i<=3; $i++): ?>
        <div class="mb-4 p-4 bg-gray-800 rounded">
            <label>Feature <?= $i ?> Title</label>
            <input name="f<?= $i ?>_title" value="<?= $data["f$i" . "_title"] ?? '' ?>" class="w-full p-2 bg-gray-700 rounded mb-2">

            <label>Feature <?= $i ?> Icon</label>
            <input name="f<?= $i ?>_icon" value="<?= $data["f$i" . "_icon"] ?? '' ?>" class="w-full p-2 bg-gray-700 rounded mb-2">

            <label>Feature <?= $i ?> Description</label>
            <textarea name="f<?= $i ?>_desc" rows="2" class="w-full p-2 bg-gray-700 rounded"><?= $data["f$i" . "_desc"] ?? '' ?></textarea>
        </div>
    <?php endfor; ?>

<?php elseif ($type === "faq"): ?>

    <label class="block mb-2">Section Title</label>
    <input name="title" value="<?= $data['title'] ?>" class="w-full p-3 bg-gray-800 rounded mb-4">

    <?php for ($i=1; $i<=3; $i++): ?>
        <div class="mb-4 p-4 bg-gray-800 rounded">
            <label>Question <?= $i ?></label>
            <input name="q<?= $i ?>" value="<?= $data["q$i"] ?? '' ?>" class="w-full p-2 bg-gray-700 rounded mb-2">

            <label>Answer <?= $i ?></label>
            <textarea name="a<?= $i ?>" rows="2" class="w-full p-2 bg-gray-700 rounded"><?= $data["a$i"] ?? '' ?></textarea>
        </div>
    <?php endfor; ?>

<?php elseif ($type === "cta"): ?>

    <label class="block mb-2">Title</label>
    <input name="title" value="<?= $data['title'] ?>" class="w-full p-3 bg-gray-800 rounded mb-4">

    <label class="block mb-2">Subtitle</label>
    <input name="subtitle" value="<?= $data['subtitle'] ?>" class="w-full p-3 bg-gray-800 rounded mb-4">

    <label class="block mb-2">Button Text</label>
    <input name="button_text" value="<?= $data['button_text'] ?>" class="w-full p-3 bg-gray-800 rounded mb-4">

    <label class="block mb-2">Button Link</label>
    <input name="button_link" value="<?= $data['button_link'] ?>" class="w-full p-3 bg-gray-800 rounded mb-4">

<?php elseif ($type === "gallery"): ?>

    <label class="block mb-2">Images</label>
    <input type="file" name="images[]" multiple>
    
    <?php if (!empty($data['images'])): ?>
        <div class="grid grid-cols-3 gap-2 mt-3">
            <?php foreach ($data['images'] as $img): ?>
                <img src="/uploads/<?= $img ?>" class="w-24 rounded">
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

<?php elseif ($type === "html"): ?>

    <label class="block mb-2">Custom HTML</label>
    <textarea name="html" rows="10" class="w-full p-3 bg-gray-800 rounded"><?= $data['html'] ?></textarea>

<?php endif; ?>

<button 
    type="button"
    onclick="saveBlockEdit()"
    class="mt-6 w-full bg-blue-600 hover:bg-blue-700 py-3 rounded-lg text-white">
    Save Changes
</button>

</form>

<script>
function saveBlockEdit() {
    const form = document.getElementById('blockEditForm');
    let data = new FormData(form);

    fetch("block_save.php", {
        method: "POST",
        body: data
    })
    .then(r => r.text())
    .then(res => {
        window.location.reload();
    });
}
</script>
