<?php
require_once "../core/db.php";

$page_id = $_GET['page_id'];
$type = $_GET['type'] ?? null;

// If no type selected → show block type selector
if (!$type):
?>

<div class="space-y-4">
    <h3 class="text-lg font-semibold mb-4">Choose Block Type</h3>

    <?php
    $blocks = [
        "hero" => "Hero Block",
        "text" => "Text Block",
        "text_image" => "Text + Image",
        "features" => "Features Grid",
        "faq" => "FAQ Block",
        "cta" => "CTA Section",
        "gallery" => "Gallery",
        "html" => "Custom HTML Block"
    ];
    ?>

    <?php foreach ($blocks as $key => $name): ?>
    <button 
        onclick="loadBlockForm('add', null, '<?= $key ?>')"
        class="w-full text-left px-4 py-3 bg-gray-800 hover:bg-gray-700 rounded-lg">
        <?= $name ?>
    </button>
    <?php endforeach; ?>

</div>

<?php 
exit;
endif;

// Otherwise show form for selected block type
?>

<form method="POST" action="block_add.php?page_id=<?= $page_id ?>&type=<?= $type ?>" enctype="multipart/form-data">

<input type="hidden" name="save" value="1">

<?php if ($type === "hero"): ?>

    <label class="block mb-2">Title</label>
    <input name="title" class="w-full p-3 bg-gray-800 rounded mb-4">

    <label class="block mb-2">Subtitle</label>
    <input name="subtitle" class="w-full p-3 bg-gray-800 rounded mb-4">

    <label class="block mb-2">Button Text</label>
    <input name="button_text" class="w-full p-3 bg-gray-800 rounded mb-4">

    <label class="block mb-2">Button Link</label>
    <input name="button_link" class="w-full p-3 bg-gray-800 rounded mb-4">

    <label class="block mb-2">Background Image</label>
    <input type="file" name="background_image" class="w-full">

<?php elseif ($type === "text"): ?>

    <label class="block mb-2">Text Content</label>
    <textarea name="content" rows="8" class="w-full p-3 bg-gray-800 rounded"></textarea>

<?php elseif ($type === "text_image"): ?>

    <label class="block mb-2">Title</label>
    <input name="title" class="w-full p-3 bg-gray-800 rounded mb-4">

    <label class="block mb-2">Text</label>
    <textarea name="text" rows="6" class="w-full p-3 bg-gray-800 rounded mb-4"></textarea>

    <label class="block mb-2">Image</label>
    <input type="file" name="image" class="w-full">

<?php elseif ($type === "features"): ?>

    <label class="block mb-2">Section Title</label>
    <input name="title" class="w-full p-3 bg-gray-800 rounded mb-4">

    <label class="block mb-2">Subtitle</label>
    <input name="subtitle" class="w-full p-3 bg-gray-800 rounded mb-4">

    <h3 class="font-semibold text-lg mb-2">Features</h3>

    <?php for ($i=1; $i<=3; $i++): ?>
        <div class="mb-4 p-4 bg-gray-800 rounded">
            <label>Feature <?= $i ?> Title</label>
            <input name="f<?= $i ?>_title" class="w-full p-2 bg-gray-700 rounded mb-2">

            <label>Feature <?= $i ?> Icon (FontAwesome class)</label>
            <input name="f<?= $i ?>_icon" class="w-full p-2 bg-gray-700 rounded mb-2">

            <label>Feature <?= $i ?> Description</label>
            <textarea name="f<?= $i ?>_desc" rows="2" class="w-full p-2 bg-gray-700 rounded"></textarea>
        </div>
    <?php endfor; ?>

<?php elseif ($type === "faq"): ?>

    <label class="block mb-2">Section Title</label>
    <input name="title" class="w-full p-3 bg-gray-800 rounded mb-4">

    <?php for ($i=1; $i<=3; $i++): ?>
        <div class="mb-4 p-4 bg-gray-800 rounded">
            <label>Question <?= $i ?></label>
            <input name="q<?= $i ?>" class="w-full p-2 bg-gray-700 rounded mb-2">

            <label>Answer <?= $i ?></label>
            <textarea name="a<?= $i ?>" rows="2" class="w-full p-2 bg-gray-700 rounded"></textarea>
        </div>
    <?php endfor; ?>

<?php elseif ($type === "cta"): ?>

    <label class="block mb-2">Title</label>
    <input name="title" class="w-full p-3 bg-gray-800 rounded mb-4">

    <label class="block mb-2">Subtitle</label>
    <input name="subtitle" class="w-full p-3 bg-gray-800 rounded mb-4">

    <label class="block mb-2">Button Text</label>
    <input name="button_text" class="w-full p-3 bg-gray-800 rounded mb-4">

    <label class="block mb-2">Button Link</label>
    <input name="button_link" class="w-full p-3 bg-gray-800 rounded mb-4">

<?php elseif ($type === "gallery"): ?>

    <label class="block mb-2">Upload Images</label>
    <input type="file" name="images[]" multiple class="w-full">

<?php elseif ($type === "html"): ?>

    <label class="block mb-2">Custom HTML</label>
    <textarea name="html" rows="10" class="w-full p-3 bg-gray-800 rounded"></textarea>

<?php endif; ?>

    <button name="saveBlock" class="mt-6 w-full bg-blue-600 hover:bg-blue-700 py-3 rounded-lg text-white">
        Save Block
    </button>

</form>

<?php
// BLOCK SAVING LOGIC
if (isset($_POST['save'])) {

    $data = $_POST;
    unset($data['save']);

    // Handle image uploads if present
    if (!empty($_FILES['background_image']['name'])) {
        $fileName = time() . "_" . $_FILES['background_image']['name'];
        move_uploaded_file($_FILES['background_image']['tmp_name'], "../uploads/" . $fileName);
        $data['background_image'] = $fileName;
    }

    if (!empty($_FILES['image']['name'])) {
        $fileName = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $fileName);
        $data['image'] = $fileName;
    }

    if (!empty($_FILES['images']['name'][0])) {
        $uploaded = [];
        foreach ($_FILES['images']['name'] as $i=>$img) {
            $fileName = time() . "_" . $img;
            move_uploaded_file($_FILES['images']['tmp_name'][$i], "../uploads/" . $fileName);
            $uploaded[] = $fileName;
        }
        $data['images'] = $uploaded;
    }

    $json = json_encode($data);

    $insert = $pdo->prepare("INSERT INTO page_blocks (page_id, block_type, block_data, sort_order) VALUES (?, ?, ?, 999)");
    $insert->execute([$page_id, $type, $json]);

    echo "<script>window.location.reload();</script>";
}
