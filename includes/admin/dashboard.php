<?php
require_once "../core/auth.php";
admin_required();
include "includes/admin_header.php";
?>

<h1 class="text-4xl font-bold mb-8">Dashboard</h1>

<div class="grid md:grid-cols-3 gap-6">
    <a href="pages_list.php" class="bg-gray-900 p-8 rounded-xl hover:bg-gray-800 transition shadow">
        <h2 class="text-xl font-bold text-blue-400 mb-2">Manage Pages</h2>
        <p class="text-gray-400">Create, edit and manage CMS pages.</p>
    </a>

    <a href="add_page.php" class="bg-gray-900 p-8 rounded-xl hover:bg-gray-800 transition shadow">
        <h2 class="text-xl font-bold text-blue-400 mb-2">Add New Page</h2>
        <p class="text-gray-400">Create a new dynamic CMS page.</p>
    </a>
</div>

<?php include "includes/admin_footer.php"; ?>
