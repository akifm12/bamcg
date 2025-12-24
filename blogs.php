<?php 
include "includes/header.php";	
require_once "core/db.php";

// Fetch all blog posts
$stmt = $pdo->query("SELECT id, title, slug, content, thumbnail, created_at 
                     FROM blogs ORDER BY created_at DESC");
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="py-24 
               bg-gray-50 dark:bg-gray-950 
               border-t border-gray-200 dark:border-gray-800">
    <div class="container mx-auto px-6">

        <!-- PAGE TITLE -->
        <h1 class="text-4xl font-bold mb-4 
                   text-gray-900 dark:text-white">
            Compliance, Automation & Regulatory Insights
        </h1>

        <p class="text-gray-600 dark:text-gray-300 
                  mb-12 max-w-2xl">
            Insights, compliance guides, and regulatory updates for UAE-regulated businesses.
        </p>

        <?php if (count($blogs) === 0): ?>
            <div class="text-gray-500 dark:text-gray-400 text-lg">
                No blog posts available yet.
            </div>
        <?php endif; ?>

        <!-- BLOG GRID -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
            <?php foreach ($blogs as $b): ?>

                <a href="blog.php?slug=<?= urlencode($b['slug']) ?>"
                   class="group block rounded-xl overflow-hidden transition
                          bg-white dark:bg-gray-900
                          border border-gray-200 dark:border-gray-800
                          hover:border-blue-500
                          hover:shadow-xl dark:hover:shadow-blue-500/10">

                    <!-- Thumbnail -->
                    <?php if ($b['thumbnail']): ?>
                        <img src="uploads/blogs/<?= $b['thumbnail'] ?>" 
                             class="w-full h-48 object-cover 
                                    group-hover:opacity-90 transition">
                    <?php else: ?>
                        <div class="w-full h-48 
                                    bg-gray-200 dark:bg-gray-800"></div>
                    <?php endif; ?>

                    <div class="p-6">

                        <!-- Title -->
                        <h3 class="text-xl font-bold mb-2
                                   text-gray-900 dark:text-white
                                   group-hover:text-blue-600 dark:group-hover:text-blue-400
                                   transition">
                            <?= htmlspecialchars($b['title']) ?>
                        </h3>

                        <!-- Excerpt -->
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                            <?= htmlspecialchars(substr(strip_tags($b['content']), 0, 120)) ?>...
                        </p>

                        <!-- CTA -->
                        <div class="text-blue-600 dark:text-blue-400 
                                    font-semibold text-sm">
                            Read More →
                        </div>

                    </div>
                </a>

            <?php endforeach; ?>
        </div>

    </div>
</section>

<?php include "includes/footer.php"; ?>
