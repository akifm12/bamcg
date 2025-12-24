<?php
require_once "../includes/db.php";
require_once "../core/auth.php";
admin_required();
include 'includes/admin_header.php'; 
/* =========================
   LEAD COUNTS
========================= */

// Total leads
$totalLeads = $pdo->query("
    SELECT 
        (SELECT COUNT(*) FROM leads) +
        (SELECT COUNT(*) FROM contact_leads)
")->fetchColumn();

// Leads last 7 days
$recentLeads = $pdo->query("
    SELECT COUNT(*) FROM (
        SELECT created_at FROM leads
        UNION ALL
        SELECT created_at FROM contact_leads
    ) t
    WHERE created_at >= NOW() - INTERVAL 7 DAY
")->fetchColumn();

// Lead source split
$wizardLeads = $pdo->query("SELECT COUNT(*) FROM leads")->fetchColumn();
$contactLeads = $pdo->query("SELECT COUNT(*) FROM contact_leads")->fetchColumn();

// Blogs count
$blogCount = 0;
try {
    $blogCount = $pdo->query("SELECT COUNT(*) FROM blogs")->fetchColumn();
} catch (Exception $e) {}

// Last lead timestamp
$lastLead = $pdo->query("
    SELECT created_at FROM (
        SELECT created_at FROM leads
        UNION ALL
        SELECT created_at FROM contact_leads
    ) t
    ORDER BY created_at DESC
    LIMIT 1
")->fetchColumn();
?>



<div class="container mx-auto px-6 py-10">

    <h1 class="text-4xl font-bold text-white mb-6">Admin Dashboard</h1>

    <div class="grid md:grid-cols-3 gap-6">

        <a href="pages_list.php" class="bg-gray-800 p-8 rounded-xl hover:bg-gray-700 transition">
            <h2 class="text-2xl text-blue-400 font-bold mb-2">Manage Pages</h2>
            <p class="text-gray-400">View, edit, or delete existing pages.</p>
        </a>

        <a href="add_page.php" class="bg-gray-800 p-8 rounded-xl hover:bg-gray-700 transition">
            <h2 class="text-2xl text-blue-400 font-bold mb-2">Add New Page</h2>
            <p class="text-gray-400">Create a new dynamic page.</p>
        </a>
        <a href="pages_list.php" class="bg-gray-800 p-8 rounded-xl hover:bg-gray-700 transition">
            <h2 class="text-2xl text-blue-400 font-bold mb-2">Manage Pages</h2>
            <p class="text-gray-400">View, edit, or delete existing pages.</p>
        </a>

        <a href="add_page.php" class="bg-gray-800 p-8 rounded-xl hover:bg-gray-700 transition">
            <h2 class="text-2xl text-blue-400 font-bold mb-2">Add New Page</h2>
            <p class="text-gray-400">Create a new dynamic page.</p>
        </a>
        <a href="logout.php" class="bg-gray-800 p-8 rounded-xl hover:bg-gray-700 transition">
            <h2 class="text-2xl text-blue-400 font-bold mb-2">Logout</h2>
            <p class="text-gray-400">Exit admin panel securely.</p>
        </a>

    </div>

</div>

<?php include 'includes/admin_footer.php'; ?>
