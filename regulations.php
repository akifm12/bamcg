<?php
include "includes/header.php";
require_once "core/db.php";

// ============================================
// FILTERS & SEARCH
// ============================================
$category_filter = $_GET['category'] ?? null;
$search = $_GET['search'] ?? null;
$page = max(1, intval($_GET['page'] ?? 1));
$perPage = 6;
$offset = ($page - 1) * $perPage;

// ============================================
// SIDEBAR DATA
// ============================================
$categories = $pdo->query("SELECT * FROM regulation_categories ORDER BY name ASC")->fetchAll();
$recent_regs = $pdo->query("SELECT * FROM regulations WHERE is_published=1 ORDER BY created_at DESC LIMIT 5")->fetchAll();
$popular_regs = $pdo->query("SELECT * FROM regulations WHERE is_published=1 ORDER BY views DESC LIMIT 5")->fetchAll();

// ============================================
// MAIN QUERY
// ============================================
$sql = "SELECT SQL_CALC_FOUND_ROWS r.*, c.name AS category_name, c.slug AS cat_slug
        FROM regulations r
        LEFT JOIN regulation_categories c ON c.id = r.category_id
        WHERE r.is_published = 1";

$params = [];

if ($category_filter) {
    $sql .= " AND c.slug = :category_slug";
    $params[':category_slug'] = $category_filter;
}

if ($search) {
    $sql .= " AND (r.title LIKE :search OR r.summary LIKE :search OR r.content LIKE :search)";
    $params[':search'] = '%' . $search . '%';
}

$sql .= " ORDER BY r.created_at DESC LIMIT $offset, $perPage";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$regs = $stmt->fetchAll();

$totalRows = $pdo->query("SELECT FOUND_ROWS()")->fetchColumn();
$totalPages = ceil($totalRows / $perPage);
?>

<!-- ============================== -->
<!-- HERO SECTION -->
<!-- ============================== -->
<section class="py-20 text-center border-b
               bg-gray-100 text-gray-900 border-gray-200
               dark:bg-gray-900 dark:text-white dark:border-gray-800">

    <h1 class="text-5xl font-bold mb-4">
        UAE Regulations & Guidance
    </h1>

    <p class="text-gray-600 dark:text-gray-400 text-lg max-w-3xl mx-auto">
        A centralized library of AML/CFT rules, circulars, advisories, and reporting requirements.
    </p>
</section>

<!-- ============================== -->
<!-- MAIN CONTENT WITH SIDEBAR -->
<!-- ============================== -->
<div class="container mx-auto px-6 py-16 grid grid-cols-1 md:grid-cols-3 gap-10">

    <!-- ======================== -->
    <!-- LEFT: REGULATION LIST -->
    <!-- ======================== -->
    <div class="md:col-span-2 space-y-8">

        <!-- SEARCH BAR -->
        <form class="mb-6">
            <input
                type="text"
                name="search"
                placeholder="Search regulations..."
                value="<?= htmlspecialchars($search ?? '') ?>"
                class="w-full px-4 py-3 rounded-lg border outline-none
                       bg-white text-gray-900 border-gray-300
                       dark:bg-gray-800 dark:text-white dark:border-gray-700
                       focus:ring-2 focus:ring-blue-500"
            >
        </form>

        <!-- REGULATION CARDS -->
        <?php foreach ($regs as $r): ?>
            <div
                class="rounded-xl p-6 transition
                       bg-white border border-gray-200 hover:border-blue-500 shadow-sm
                       dark:bg-gray-800 dark:border-gray-700"
            >

                <span class="text-blue-600 dark:text-blue-400 text-sm font-semibold">
                    <?= htmlspecialchars($r['category_name'] ?? '') ?>
                </span>

                <h3 class="text-2xl font-bold mt-2 mb-3
                           text-gray-900 dark:text-white">
                    <a href="regulation.php?slug=<?= $r['slug'] ?>"
                       class="hover:text-blue-600 dark:hover:text-blue-400">
                        <?= htmlspecialchars($r['title'] ?? '') ?>
                    </a>
                </h3>

                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                    <?= htmlspecialchars($r['summary'] ?? '') ?>
                </p>

                <a href="regulation.php?slug=<?= $r['slug'] ?>"
                   class="text-blue-600 dark:text-blue-400 font-semibold hover:underline">
                    View Regulation →
                </a>

            </div>
        <?php endforeach; ?>

        <!-- IF EMPTY -->
        <?php if (!$regs): ?>
            <p class="text-gray-600 dark:text-gray-400 text-lg">
                No regulations found.
            </p>
        <?php endif; ?>

        <!-- PAGINATION -->
        <div class="flex justify-center mt-10 gap-3">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>"
                   class="px-4 py-2 rounded-lg transition
                          bg-gray-200 hover:bg-gray-300 text-gray-800
                          dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-white">
                    Prev
                </a>
            <?php endif; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1 ?>"
                   class="px-4 py-2 rounded-lg transition
                          bg-gray-200 hover:bg-gray-300 text-gray-800
                          dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-white">
                    Next
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- ======================== -->
    <!-- RIGHT: SIDEBAR -->
    <!-- ======================== -->
    <aside class="space-y-10">

        <!-- Categories -->
        <div class="rounded-xl p-6
                    bg-white border border-gray-200
                    dark:bg-gray-800 dark:border-gray-700">
            <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">
                Categories
            </h3>

            <?php foreach ($categories as $cat): ?>
                <div class="mb-2">
                    <a href="?category=<?= $cat['slug'] ?>"
                       class="text-gray-700 hover:text-blue-600
                              dark:text-gray-300 dark:hover:text-blue-400">
                        <?= htmlspecialchars($cat['name']) ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Recent Regulations -->
        <div class="rounded-xl p-6
                    bg-white border border-gray-200
                    dark:bg-gray-800 dark:border-gray-700">
            <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">
                Recent Updates
            </h3>

            <?php foreach ($recent_regs as $rr): ?>
                <div class="mb-3">
                    <a href="regulation.php?slug=<?= $rr['slug'] ?>"
                       class="text-gray-700 hover:text-blue-600
                              dark:text-gray-300 dark:hover:text-blue-400">
                        <?= htmlspecialchars($rr['title']) ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Popular Regulations -->
        <div class="rounded-xl p-6
                    bg-white border border-gray-200
                    dark:bg-gray-800 dark:border-gray-700">
            <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">
                Popular
            </h3>

            <?php foreach ($popular_regs as $pr): ?>
                <div class="mb-3">
                    <a href="regulation.php?slug=<?= $pr['slug'] ?>"
                       class="text-gray-700 hover:text-blue-600
                              dark:text-gray-300 dark:hover:text-blue-400">
                        <?= htmlspecialchars($pr['title']) ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

    </aside>

</div>

<?php include "includes/footer.php"; ?>
