<?php 
include "includes/header.php";
require_once "core/db.php";

// Validate slug
if (!isset($_GET['slug'])) {
    die("Blog post not found.");
}

$slug = $_GET['slug'];

// Fetch blog post
$stmt = $pdo->prepare("SELECT * FROM blogs WHERE slug = :slug LIMIT 1");
$stmt->execute([":slug" => $slug]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    die("Blog post not found.");
}
?>

<!-- ============================= -->
<!-- HERO IMAGE -->
<!-- ============================= -->
<section class="relative w-full h-72 md:h-96 overflow-hidden
               bg-gray-200 dark:bg-gray-900">

    <?php if ($post['thumbnail']): ?>
        <img src="uploads/blogs/<?= htmlspecialchars($post['thumbnail']) ?>" 
             class="absolute inset-0 w-full h-full object-cover opacity-70">
    <?php else: ?>
        <div class="w-full h-full 
                    bg-gradient-to-br 
                    from-gray-200 to-gray-300
                    dark:from-gray-800 dark:to-gray-900"></div>
    <?php endif; ?>

    <!-- Overlay -->
    <div class="absolute inset-0 bg-white/70 dark:bg-black/50"></div>

    <!-- Title -->
    <div class="relative z-10 h-full flex items-center justify-center text-center px-6">
        <h1 class="text-4xl md:text-6xl font-extrabold 
                   text-gray-900 dark:text-white
                   drop-shadow-lg">
            <?= htmlspecialchars($post['title']) ?>
        </h1>
    </div>
</section>

<!-- ============================= -->
<!-- BLOG CONTENT -->
<!-- ============================= -->
<section class="py-16 
               bg-gray-50 dark:bg-gray-950
               text-gray-800 dark:text-gray-200">

    <div class="max-w-6xl mx-auto px-6">

        <!-- Meta -->
        <div class="text-center mb-12">
            <div class="text-gray-500 dark:text-gray-400 text-sm">
                Published on <?= date("F j, Y", strtotime($post['created_at'])) ?>
            </div>
        </div>

        <!-- Content -->
        <article
            class="prose prose-lg max-w-none mx-auto leading-relaxed
                   prose-gray dark:prose-invert
                   columns-1 lg:columns-2 gap-12
                   [&>h2]:break-inside-avoid
                   [&>h3]:break-inside-avoid
                   [&>ul]:break-inside-avoid"
            data-aos="fade-up"
            data-aos-duration="800"
        >
            <?= $post['content'] ?>
        </article>

        <!-- Divider -->
        <div class="border-b 
                    border-gray-300 dark:border-gray-700 
                    my-16"></div>

        <!-- Back Button -->
        <div class="text-center">
            <a href="blogs.php" 
               class="inline-block px-6 py-3 rounded-lg font-semibold transition
                      bg-gray-200 hover:bg-gray-300 text-gray-800
                      dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-white">
                ← Back to Blog
            </a>
        </div>

    </div>
</section>

<?php include "includes/footer.php"; ?>
