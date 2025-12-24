<?php
include "includes/header.php";
require_once "admin/database.php";

$slug = $_GET['slug'] ?? '';

$stmt = $pdo->prepare("
    SELECT p.*, c.name AS category_name, c.slug AS category_slug 
    FROM blog_posts p
    LEFT JOIN blog_categories c ON c.id = p.category_id
    WHERE p.slug = :slug AND p.is_published = 1
");
$stmt->execute([":slug" => $slug]);
$post = $stmt->fetch();

if (!$post) {
    echo "<section class='container mx-auto py-20 text-center'><h1 class='text-4xl text-white'>Post Not Found</h1></section>";
    include "includes/footer.php";
    exit;
}

// Increase view count
$pdo->prepare("UPDATE blog_posts SET views = views + 1 WHERE id = :id")->execute([":id" => $post['id']]);

// Sidebar data
$categories = $pdo->query("SELECT * FROM blog_categories ORDER BY name ASC")->fetchAll();
$recent = $pdo->query("SELECT * FROM blog_posts WHERE is_published=1 ORDER BY created_at DESC LIMIT 5")->fetchAll();

// Related posts
$related = $pdo->prepare("
    SELECT * FROM blog_posts 
    WHERE category_id = :cat AND id != :id AND is_published=1
    ORDER BY created_at DESC LIMIT 3
");
$related->execute([":cat" => $post['category_id'], ":id" => $post['id']]);
$related_posts = $related->fetchAll();
?>

<section class="py-20 bg-gray-900 text-center">
    <h1 class="text-5xl font-bold text-white mb-3"><?= htmlspecialchars($post['title']) ?></h1>
    <p class="text-gray-400"><?= date("F d, Y", strtotime($post['created_at'])) ?></p>
</section>

<div class="container mx-auto px-6 py-16 grid grid-cols-1 md:grid-cols-3 gap-10">

    <!-- LEFT: Post content -->
    <div class="md:col-span-2">
        
        <?php if ($post['image']): ?>
            <img src="<?= $post['image']; ?>" class="w-full rounded-xl mb-10 shadow-xl">
        <?php endif; ?>

        <article class="prose prose-invert max-w-none leading-relaxed
                        prose-headings:text-white prose-p:text-gray-300 
                        prose-li:text-gray-300 prose-strong:text-blue-400">
            <?= $post['content']; ?>
        </article>

        <!-- RELATED POSTS -->
        <?php if ($related_posts): ?>
        <h3 class="text-2xl font-bold text-white mt-16 mb-6">Related Posts</h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php foreach ($related_posts as $rp): ?>
                <a href="blog_post.php?slug=<?= $rp['slug'] ?>" class="bg-gray-800 border border-gray-700 rounded-xl p-4 hover:border-blue-500 transition">
                    <h4 class="text-lg font-semibold text-white"><?= htmlspecialchars($rp['title']) ?></h4>
                </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </div>

    <!-- RIGHT: Sidebar -->
    <aside class="space-y-10">

        <!-- Categories -->
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-6">
            <h3 class="text-xl font-bold mb-4 text-white">Categories</h3>
            <?php foreach ($categories as $cat): ?>
                <div class="mb-2">
                    <a href="/blog.php?category=<?= $cat['slug']; ?>" 
                       class="text-gray-300 hover:text-blue-400">
                       <?= htmlspecialchars($cat['name']) ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Recent -->
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-6">
            <h3 class="text-xl font-bold mb-4 text-white">Recent Posts</h3>
            <?php foreach ($recent as $rp): ?>
                <div class="mb-3">
                    <a href="blog_post.php?slug=<?= $rp['slug'] ?>" class="text-gray-300 hover:text-blue-400">
                        <?= htmlspecialchars($rp['title']); ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

    </aside>

</div>

<?php include "includes/footer.php"; ?>
