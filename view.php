<?php
require_once "core/db.php";

// GET PAGE BY SLUG
$slug = $_GET['page'] ?? null;

if (!$slug) {
    die("No page specified.");
}

$stmt = $pdo->prepare("SELECT * FROM pages WHERE slug=? AND is_published=1 LIMIT 1");
$stmt->execute([$slug]);
$page = $stmt->fetch();

if (!$page) {
    http_response_code(404);
    die("Page not found.");
}

// FETCH BLOCKS
$blocks = $pdo->prepare("SELECT * FROM page_blocks WHERE page_id=? ORDER BY sort_order ASC");
$blocks->execute([$page['id']]);
$blocks = $blocks->fetchAll();

// SEO
$meta_title = $page['meta_title'] ?: $page['title'];
$meta_desc  = $page['meta_description'] ?: "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($meta_title) ?></title>
<meta name="description" content="<?= htmlspecialchars($meta_desc) ?>">
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-950 text-gray-200">

<?php include "includes/header.php"; ?>

<!-- PAGE HEADER (Optional) -->
<section class="py-16 bg-gray-900 mb-12">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl md:text-5xl font-bold"><?= htmlspecialchars($page['title']) ?></h1>
    </div>
</section>

<!-- MAIN CONTENT WRAPPER -->
<div class="container mx-auto px-4">

<?php if (empty($blocks)): ?>

    <p class="text-gray-500">This page has no content yet.</p>

<?php else: ?>

    <?php foreach ($blocks as $block): ?>
        <?php
            $type = $block['block_type'];
            $data = json_decode($block['block_data'], true);

            $blockFile = "views/blocks/" . $type . ".php";

            if (file_exists($blockFile)) {
                include $blockFile;
            } else {
                echo "<p class='text-red-400'>Missing block template: $type.php</p>";
            }
        ?>
    <?php endforeach; ?>

<?php endif; ?>

</div> <!-- container -->

<?php include "includes/footer.php"; ?>

</body>
</html>
