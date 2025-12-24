<?php 
include "includes/header.php";
require_once "core/db.php"; // adjust if needed

$slug = $_GET['slug'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM pages WHERE slug = :slug AND is_published = 1");
$stmt->execute([":slug" => $slug]);
$page = $stmt->fetch();

if (!$page) {
    echo "<div class='container mx-auto py-20 text-center text-gray-300'>
            <h1 class='text-4xl font-bold mb-4'>Page Not Found</h1>
            <p>The page you are looking for does not exist.</p>
          </div>";
    include "includes/footer.php";
    exit;
}
?>

<section class="container mx-auto px-6 py-20 text-gray-200 max-w-4xl">
    
    <h1 class="text-5xl font-bold text-white mb-8">
        <?= htmlspecialchars($page['title']); ?>
    </h1>

    <article class="prose prose-invert max-w-none leading-relaxed">
        <?= $page['content']; ?>
    </article>

</section>

<?php include "../includes/footer.php"; ?>
