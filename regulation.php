<?php
include "includes/header.php";
require_once "core/db.php";

$BASE_URL = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');

$slug = $_GET['slug'] ?? '';

$stmt = $pdo->prepare("
    SELECT r.*, c.name AS category_name, c.slug AS category_slug
    FROM regulations r
    LEFT JOIN regulation_categories c ON c.id = r.category_id
    WHERE r.slug = :slug AND r.is_published = 1
");
$stmt->execute([":slug" => $slug]);
$reg = $stmt->fetch();

if (!$reg) {
    echo "
    <section class='py-20 container mx-auto text-center'>
        <h1 class='text-4xl font-bold text-gray-900 dark:text-white'>
            Regulation Not Found
        </h1>
        <p class='text-gray-600 dark:text-gray-400 mt-4'>
            The document you're looking for no longer exists or is unpublished.
        </p>
    </section>";
    include "includes/footer.php";
    exit;
}

// Increase view count
$pdo->prepare("UPDATE regulations SET views = views + 1 WHERE id = :id")
    ->execute([":id" => $reg['id']]);

// Sidebar data
$categories = $pdo->query("SELECT * FROM regulation_categories ORDER BY name ASC")->fetchAll();
$recent_regs = $pdo->query("SELECT * FROM regulations WHERE is_published=1 ORDER BY created_at DESC LIMIT 5")->fetchAll();

// Related
$related_stmt = $pdo->prepare("
    SELECT * FROM regulations
    WHERE category_id = :cid AND id != :id AND is_published=1
    ORDER BY created_at DESC LIMIT 4
");
$related_stmt->execute([
    ":cid" => $reg["category_id"],
    ":id"  => $reg["id"]
]);
$related = $related_stmt->fetchAll();
?>

<!-- ============================== -->
<!-- HERO SECTION -->
<!-- ============================== -->
<section class="py-20 text-center border-b
               bg-gray-100 text-gray-900 border-gray-200
               dark:bg-gray-900 dark:text-white dark:border-gray-800">

    <h1 class="text-4xl md:text-5xl font-bold mb-3">
        <?= htmlspecialchars($reg['title']) ?>
    </h1>

    <p class="text-blue-600 dark:text-blue-400 text-lg font-semibold">
        <?= htmlspecialchars($reg['category_name']) ?>
    </p>

    <p class="text-gray-600 dark:text-gray-400 mt-2">
        <?= date("F d, Y", strtotime($reg['created_at'])) ?>
    </p>
</section>

<!-- ============================== -->
<!-- MAIN LAYOUT -->
<!-- ============================== -->
<div class="container mx-auto px-6 py-16 grid grid-cols-1 md:grid-cols-3 gap-10">

    <!-- ===================== -->
    <!-- LEFT COLUMN -->
    <!-- ===================== -->
    <div class="md:col-span-2 space-y-12">

        <!-- SUMMARY -->
        <?php if ($reg['summary']): ?>
            <div class="rounded-xl p-6
                        bg-white border border-gray-200
                        dark:bg-gray-800 dark:border-gray-700">

                <h2 class="text-2xl font-bold mb-3
                           text-gray-900 dark:text-white">
                    Summary
                </h2>

                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                    <?= nl2br(htmlspecialchars($reg['summary'])) ?>
                </p>
            </div>
        <?php endif; ?>

        <!-- PDF VIEWER -->
        <?php if ($reg['pdf_link']): ?>
            <div class="rounded-xl p-6
                        bg-white border border-gray-200
                        dark:bg-gray-800 dark:border-gray-700">

                <h2 class="text-2xl font-bold mb-4
                           text-gray-900 dark:text-white">
                    Official Document
                </h2>

                <div class="w-full h-[700px] mb-4">
                    <iframe
                        src="<?= BASE_URL . $reg['pdf_link']; ?>"
                        class="w-full h-full rounded-lg border
                               border-gray-300 dark:border-gray-700 bg-white"
                        allowfullscreen>
                    </iframe>
                </div>

                <a href="<?= BASE_URL . $reg['pdf_link']; ?>"
                   download
                   class="inline-block px-6 py-3 rounded-lg font-semibold transition
                          bg-blue-600 hover:bg-blue-700 text-white">
                    Download PDF
                </a>
            </div>
        <?php endif; ?>

        <!-- FULL CONTENT -->
        <?php if ($reg['content']): ?>
            <div
                class="rounded-xl p-6
                       bg-white border border-gray-200
                       dark:bg-gray-800 dark:border-gray-700
                       prose prose-lg max-w-none
                       prose-gray dark:prose-invert">

                <?= $reg['content'] ?>
            </div>
        <?php endif; ?>

        <!-- RELATED REGULATIONS -->
        <?php if ($related): ?>
            <div>
                <h3 class="text-2xl font-bold mb-6
                           text-gray-900 dark:text-white">
                    Related Regulations
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php foreach ($related as $r): ?>
                        <a href="regulation.php?slug=<?= $r['slug'] ?>"
                           class="rounded-xl p-5 transition
                                  bg-white border border-gray-200 hover:border-blue-500
                                  dark:bg-gray-800 dark:border-gray-700">

                            <h4 class="text-lg font-semibold
                                       text-gray-900 dark:text-white">
                                <?= htmlspecialchars($r['title']) ?>
                            </h4>

                            <p class="text-sm mt-1
                                      text-gray-600 dark:text-gray-400">
                                <?= date("F d, Y", strtotime($r['created_at'])) ?>
                            </p>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <!-- ===================== -->
    <!-- RIGHT SIDEBAR -->
    <!-- ===================== -->
    <aside class="space-y-10">

        <!-- CATEGORIES -->
        <div class="rounded-xl p-6
                    bg-white border border-gray-200
                    dark:bg-gray-800 dark:border-gray-700">

            <h3 class="text-xl font-bold mb-4
                       text-gray-900 dark:text-white">
                Categories
            </h3>

            <?php foreach ($categories as $cat): ?>
                <div class="mb-2">
                    <a href="/regulations.php?category=<?= $cat['slug'] ?>"
                       class="text-gray-700 hover:text-blue-600
                              dark:text-gray-300 dark:hover:text-blue-400">
                        <?= htmlspecialchars($cat['name']) ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- RECENT UPDATES -->
        <div class="rounded-xl p-6
                    bg-white border border-gray-200
                    dark:bg-gray-800 dark:border-gray-700">

            <h3 class="text-xl font-bold mb-4
                       text-gray-900 dark:text-white">
                Recent Updates
            </h3>

            <?php foreach ($recent_regs as $rr): ?>
                <div class="mb-3">
                    <a href="regulation.php?slug=<?= $rr['slug']; ?>"
                       class="text-gray-700 hover:text-blue-600
                              dark:text-gray-300 dark:hover:text-blue-400">
                        <?= htmlspecialchars($rr['title']) ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

    </aside>

</div>

<?php include "includes/footer.php"; ?>
