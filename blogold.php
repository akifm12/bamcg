<?php
include "includes/header.php";
require_once "core/db.php";

// ============================================
// FETCH FILTERS / SEARCH
// ============================================
$category_filter = $_GET['category'] ?? null;
$search = $_GET['search'] ?? null;
$page = max(1, intval($_GET['page'] ?? 1));
$perPage = 6;
$offset = ($page - 1) * $perPage;

// ============================================
// SIDEBAR DATA
// ============================================
$categories = $pdo->query("SELECT * FROM blog_categories ORDER BY name ASC")->fetchAll();
$recent_posts = $pdo->query("SELECT * FROM blog_posts WHERE is_published=1 ORDER BY created_at DESC LIMIT 5")->fetchAll();
$popular_posts = $pdo->query("SELECT * FROM blog_posts WHERE is_published=1 ORDER BY views DESC LIMIT 5")->fetchAll();

// ============================================
// FEATURED POST
// ============================================
$featured = $pdo->query("SELECT * FROM blog_posts WHERE is_published=1 ORDER BY created_at DESC LIMIT 1")->fetch();

// ============================================
// BUILD BLOG QUERY
// ============================================

$sql = "SELECT SQL_CALC_FOUND_ROWS p.*, c.name AS category_name 
        FROM blog_posts p 
        LEFT JOIN blog_categories c ON c.id = p.category_id 
        WHERE p.is_published = 1";

$params = [];

if ($category_filter) {
    $sql .= " AND c.slug = :category_slug";
    $params[':category_slug'] = $category_filter;
}

if ($search) {
    $sql .= " AND (p.title LIKE :search OR p.excerpt LIKE :search OR p.content LIKE :search)";
    $params[':search'] = "%" . $search . "%";
}

$sql .= " ORDER BY p.created_at DESC LIMIT $offset, $perPage";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$posts = $stmt->fetchAll();

$totalRows = $pdo->query("SELECT FOUND_ROWS()")->fetchColumn();
$totalPages = ceil($totalRows / $perPage);
?>

<!-- ============================== -->
<!-- BLOG HERO -->
<!-- ============================== -->
<section class="py-20 bg-gray-900 text-center border-b border-gray-800">
    <h1 class="text-5xl font-bold text-white mb-4">Insights & Updates</h1>
    <p class="text-gray-400 text-lg">Expert commentary, regulatory updates, and compliance insights.</p>
</section>

<!-- ============================== -->
<!-- MAIN CONTENT WITH SIDEBAR -->
<!-- ============================== -->
<div class="container mx-auto px-6 py-16 grid grid-cols-1 md:grid-cols-3 gap-10">

    <!-- ======================== -->
    <!-- LEFT COLUMN (BLOG LIST) -->
    <!-- ======================== -->
    <div class="md:col-span-2 space-y-10">

        <!-- SEARCH BAR -->
        <form method="GET" class="mb-6">
            <input type="text" name="search" placeholder="Search articles..."
                  
				              htmlspecialchars($post['excerpt'] ?? '');
                   class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white">
        </form>

        <!-- FEATURED POST -->
        <?php if ($page == 1 && !$category_filter && !$search && $featured): ?>
        <div class="bg-gray-800 border border-gray-700 rounded-xl overflow-hidden">
            
            <?php if ($featured['image']): ?>
                <img src="<?= $featured['image'] ?>" class="w-full h-72 object-cover">
            <?php endif; ?>
            
            <div class="p-6">
                <span class="text-blue-400 text-sm font-semibold"><?= $featured['category_name'] ?></span>
                <h2 class="text-3xl font-bold text-white mt-2 mb-4">
                    <?= htmlspecialchars($featured['title']) ?>
                </h2>
                <p class="text-gray-400 mb-4"><?= htmlspecialchars($featured['excerpt']) ?></p>
                <a href="blog_post.php?slug=<?= $featured['slug'] ?>" class="text-blue-400 hover:underline">
                    Read More →
                </a>
            </div>
        </div>
        <?php endif; ?>

        <!-- BLOG POSTS GRID -->
        <?php foreach ($posts as $post): ?>
            <div class="bg-gray-800 border border-gray-700 rounded-xl overflow-hidden hover:border-blue-500 transition">

                <?php if ($post['image']): ?>
                    <img src="<?= $post['image'] ?>" class="w-full h-48 object-cover">
                <?php endif; ?>

                <div class="p-6">
                    <span class="text-blue-400 text-sm"><?= $post['category_name'] ?></span>
                    <h3 class="text-xl font-semibold mt-1 mb-2">
                        <a href="blog_post.php?slug=<?= $post['slug'] ?>" class="hover:text-blue-400">
                            <?= htmlspecialchars($post['title'] ?? '') ?>
                        </a>
                    </h3>
                    <p class="text-gray-400 text-sm mb-4"><?= htmlspecialchars($post['excerpt'] ?? ''); ?></p>
                    <a href="blog_post.php?slug=<?= $post['slug'] ?>" class="text-blue-400 hover:underline">Read More →</a>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- PAGINATION -->
        <div class="flex justify-center mt-10 gap-3">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>" class="px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg hover:bg-gray-700">Prev</a>
            <?php endif; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1 ?>" class="px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg hover:bg-gray-700">Next</a>
            <?php endif; ?>
        </div>

    </div>

    <!-- ======================== -->
    <!-- RIGHT SIDEBAR -->
    <!-- ======================== -->
    <aside class="space-y-10">

        <!-- Search -->
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-6">
            <h3 class="text-xl font-bold mb-4 text-white">Search</h3>
            <form>
                <input type="text" name="search" placeholder="Search..."
                       class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg text-white">
            </form>
        </div>

        <!-- Categories -->
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-6">
            <h3 class="text-xl font-bold mb-4 text-white">Categories</h3>

            <?php foreach ($categories as $cat): ?>
                <div class="mb-2">
                    <a href="?category=<?= $cat['slug'] ?>" class="text-gray-300 hover:text-blue-400">
                        <?= htmlspecialchars($cat['name']) ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Recent Posts -->
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-6">
            <h3 class="text-xl font-bold mb-4 text-white">Recent Posts</h3>

            <?php foreach ($recent_posts as $rp): ?>
                <div class="mb-4">
                    <a href="blog_post.php?slug=<?= $rp['slug'] ?>" class="text-gray-300 hover:text-blue-400">
                        <?= htmlspecialchars($rp['title']) ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Popular Posts -->
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-6">
            <h3 class="text-xl font-bold mb-4 text-white">Popular Posts</h3>

            <?php foreach ($popular_posts as $pp): ?>
                <div class="mb-4">
                    <a href="blog_post.php?slug=<?= $pp['slug'] ?>" class="text-gray-300 hover:text-blue-400">
                        <?= htmlspecialchars($pp['title']) ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

    </aside>

</div>

<?php include "includes/footer.php"; ?>
