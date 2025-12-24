<?php
require_once "../core/db.php";
include "includes/admin_header.php";

/*
|--------------------------------------------------------------------------
| COMBINED LEADS QUERY
|--------------------------------------------------------------------------
| - Normalizes both tables into same column structure
| - Adds a source label
*/
$sql = "
    SELECT 
        id,
        company,
        name,
        email,
        phone,
        industry,
        'Wizard / Quick Lead' AS source,
        created_at
    FROM leads

    UNION ALL

    SELECT 
        id,
        company,
        name,
        email,
        phone,
        industry,
        'Contact Page' AS source,
        created_at
    FROM contact_leads

    ORDER BY created_at DESC
";

$stmt = $pdo->query($sql);
$leads = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1 class="text-3xl font-bold mb-6">All Leads</h1>

<div class="bg-gray-900 border border-gray-800 rounded-xl overflow-x-auto">

    <table class="w-full text-sm text-left">
        <thead class="bg-gray-800 text-gray-300 uppercase text-xs">
            <tr>
                <th class="px-4 py-3">Date</th>
                <th class="px-4 py-3">Company</th>
                <th class="px-4 py-3">Name</th>
                <th class="px-4 py-3">Email</th>
                <th class="px-4 py-3">Phone</th>
                <th class="px-4 py-3">Industry</th>
                <th class="px-4 py-3">Source</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-800">

            <?php if (empty($leads)): ?>
                <tr>
                    <td colspan="7" class="px-4 py-6 text-center text-gray-400">
                        No leads found.
                    </td>
                </tr>
            <?php endif; ?>

            <?php foreach ($leads as $lead): ?>
                <tr class="hover:bg-gray-800/50 transition">
                    <td class="px-4 py-3 text-gray-400">
                        <?= date("d M Y, H:i", strtotime($lead["created_at"])) ?>
                    </td>
                    <td class="px-4 py-3 font-medium text-white">
                        <?= htmlspecialchars($lead["company"] ?? "-") ?>
                    </td>
                    <td class="px-4 py-3 text-gray-200">
                        <?= htmlspecialchars($lead["name"] ?? "-") ?>
                    </td>
                    <td class="px-4 py-3 text-blue-400">
                        <a href="mailto:<?= htmlspecialchars($lead["email"]) ?>">
                            <?= htmlspecialchars($lead["email"]) ?>
                        </a>
                    </td>
                    <td class="px-4 py-3 text-gray-300">
                        <?= htmlspecialchars($lead["phone"] ?? "-") ?>
                    </td>
                    <td class="px-4 py-3 text-gray-300">
                        <?= htmlspecialchars($lead["industry"] ?? "-") ?>
                    </td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded text-xs font-semibold
                            <?= $lead["source"] === 'Contact Page'
                                ? 'bg-green-600/20 text-green-400'
                                : 'bg-blue-600/20 text-blue-400' ?>">
                            <?= $lead["source"] ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>

</div>

<?php include "includes/admin_footer.php"; ?>
