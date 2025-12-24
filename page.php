<?php 
include "includes/header.php";
require_once "core/db.php";

$slug = $_GET['slug'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM pages WHERE slug = :slug AND is_published = 1");
$stmt->execute([":slug" => $slug]);
$page = $stmt->fetch();

if (!$page) {
    echo "<section class='container mx-auto py-20 text-center text-gray-300'>
            <h1 class='text-4xl font-bold mb-4'>Page Not Found</h1>
            <p>The page you are looking for does not exist.</p>
          </section>";
    include "includes/footer.php";
    exit;
}
?>

<!-- =============================== -->
<!-- HERO SECTION -->
<!-- =============================== -->
<section class="relative py-32 overflow-hidden bg-gradient-to-br from-blue-700/40 via-gray-900 to-gray-950">

    <!-- Glow Elements -->
    <div class="absolute top-10 left-10 w-72 h-72 bg-blue-600/20 blur-3xl rounded-full"></div>
    <div class="absolute bottom-10 right-10 w-72 h-72 bg-purple-600/20 blur-3xl rounded-full"></div>

    <!-- Decorative Trace Line -->
    <svg class="absolute inset-0 opacity-20 pointer-events-none"
         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="none" stroke="#60A5FA" stroke-width="2"
              d="M0,64 C240,160 480,0 720,96 C960,192 1200,96 1440,160" />
    </svg>

    <div class="relative container mx-auto px-6 text-center">
        <h1 class="text-5xl md:text-6xl font-extrabold text-white mb-6 drop-shadow-xl">
            <?= htmlspecialchars($page['title']); ?>
        </h1>

        <p class="text-gray-300 max-w-2xl mx-auto text-lg">
            A modern approach to compliance, risk management & regulatory alignment.
        </p>
    </div>
</section>

<!-- =============================== -->
<!-- VALUE PILLARS SECTION -->
<!-- =============================== -->
<section class="py-20 container mx-auto px-6">
    <h2 class="text-center text-3xl md:text-4xl font-bold text-white mb-12">
        Our Core Values
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

        <div class="p-8 bg-gray-800 rounded-xl border border-gray-700 text-center hover:border-blue-500 transition">
            <div class="text-blue-400 text-5xl mb-4">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <h3 class="text-xl font-semibold text-white mb-2">Integrity</h3>
            <p class="text-gray-400">We operate with transparency and high ethical standards.</p>
        </div>

        <div class="p-8 bg-gray-800 rounded-xl border border-gray-700 text-center hover:border-blue-500 transition">
            <div class="text-blue-400 text-5xl mb-4">
                <i class="fa-solid fa-chart-line"></i>
            </div>
            <h3 class="text-xl font-semibold text-white mb-2">Expertise</h3>
            <p class="text-gray-400">Decades of combined regulatory and industry experience.</p>
        </div>

        <div class="p-8 bg-gray-800 rounded-xl border border-gray-700 text-center hover:border-blue-500 transition">
            <div class="text-blue-400 text-5xl mb-4">
                <i class="fa-solid fa-lightbulb"></i>
            </div>
            <h3 class="text-xl font-semibold text-white mb-2">Innovation</h3>
            <p class="text-gray-400">AI-driven tools for screening, onboarding, and automation.</p>
        </div>

    </div>
</section>

<!-- =============================== -->
<!-- WHY CHOOSE US SECTION -->
<!-- =============================== -->
<section class="py-20 bg-gray-900 border-y border-gray-800">
    <div class="container mx-auto px-6">

        <h2 class="text-center text-3xl md:text-4xl font-bold text-white mb-12">
            Why Choose Blue Arrow?
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

            <div class="p-8 bg-gray-800 rounded-xl border border-gray-700 hover:border-blue-500 transition">
                <div class="text-blue-400 text-5xl mb-4">
                    <i class="fa-solid fa-user-tie"></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-3">Regulatory Expertise</h3>
                <p class="text-gray-400">
                    Experience with CBUAE, FIU, MOE, VARA and other UAE regulators.
                </p>
            </div>

            <div class="p-8 bg-gray-800 rounded-xl border border-gray-700 hover:border-blue-500 transition">
                <div class="text-blue-400 text-5xl mb-4">
                    <i class="fa-solid fa-arrows-spin"></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-3">End-to-End Support</h3>
                <p class="text-gray-400">
                    Onboarding, screening, AML audits, MLRO — we cover the full lifecycle.
                </p>
            </div>

            <div class="p-8 bg-gray-800 rounded-xl border border-gray-700 hover:border-blue-500 transition">
                <div class="text-blue-400 text-5xl mb-4">
                    <i class="fa-solid fa-robot"></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-3">AI-Powered Compliance</h3>
                <p class="text-gray-400">
                    Automating what slows businesses down — safely and efficiently.
                </p>
            </div>

        </div>

    </div>
</section>

<!-- =============================== -->
<!-- DYNAMIC CONTENT (STABLE VERSION) -->
<!-- =============================== -->
<section class="container mx-auto px-6 py-16 text-gray-200 max-w-4xl">

    <article class="prose prose-invert max-w-none leading-relaxed
                    prose-headings:text-white 
                    prose-p:text-gray-300 
                    prose-li:text-gray-300 
                    prose-strong:text-blue-400">
        
        <?= $page['content']; ?>

    </article>

</section>

<?php include "includes/footer.php"; ?>
