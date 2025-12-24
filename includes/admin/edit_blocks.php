<?php
require_once "../core/auth.php";
require_once "../core/db.php";
admin_required();

$page_id = $_GET['page_id'] ?? null;
if (!$page_id) die("Missing page ID.");

$stmt = $pdo->prepare("SELECT * FROM pages WHERE id=?");
$stmt->execute([$page_id]);
$page = $stmt->fetch();

if (!$page) die("Page not found.");

include "includes/admin_header.php";

// Fetch blocks
$blocks = $pdo->prepare("SELECT * FROM page_blocks WHERE page_id=? ORDER BY sort_order ASC");
$blocks->execute([$page_id]);
$blocks = $blocks->fetchAll();
?>

<div 
    x-data="blockBuilder()"
    class="relative">

    <!-- PAGE TITLE -->
    <h1 class="text-3xl font-bold mb-6">
        Editing Blocks for: 
        <span class="text-blue-400"><?= htmlspecialchars($page['title']) ?></span>
    </h1>

    <!-- BLOCK LIST -->
    <div id="blockList" class="space-y-4">

        <?php foreach ($blocks as $block): ?>
        <div 
            class="bg-gray-900 border border-gray-800 rounded-xl p-5 flex items-center justify-between shadow"
            data-id="<?= $block['id'] ?>"
        >
            <!-- Drag Handle -->
            <div class="cursor-move text-gray-500 mr-3">☰</div>

            <!-- Preview -->
            <div class="flex-1">
                <div class="text-gray-300 font-semibold">
                    <?= strtoupper($block['block_type']) ?> BLOCK
                </div>
                <div class="text-gray-500 text-sm">
                    ID: <?= $block['id'] ?>
                </div>
            </div>

            <!-- Actions -->
            <div class="space-x-3">
                <button 
                    @click="openPanel('edit', <?= $block['id'] ?>, null)"
                    class="text-blue-400 hover:text-blue-300">
                    Edit
                </button>

                <button 
                    class="text-red-400 hover:text-red-300"
                    onclick="if(confirm('Delete block?')) window.location='block_delete.php?id=<?= $block['id'] ?>&page_id=<?= $page_id ?>';">
                    Delete
                </button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- ADD BLOCK BUTTON -->
    <div class="mt-6">
        <button 
            @click="openPanel('add', null, null)"
            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg">
            + Add Block
        </button>
    </div>

    <!-- BACKDROP -->
    <div 
        x-show="panelOpen"
        x-transition.opacity
        class="fixed inset-0 bg-black/50 backdrop-blur-sm"
        @click="closePanel()"
        style="display:none;">
    </div>

    <!-- SLIDE-OVER PANEL -->
    <div 
        x-show="panelOpen"
        x-transition:enter="transform transition ease-in-out duration-300"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transform transition ease-in-out duration-300"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed top-0 right-0 w-full max-w-md h-full bg-gray-900 border-l border-gray-800 shadow-xl p-8 z-50 overflow-y-auto"
        style="display:none;"
    >
        <h2 class="text-2xl font-bold mb-6" x-text="panelTitle"></h2>

        <!-- AJAX LOADED FORM -->
        <div id="blockFormContainer" class="text-gray-300"></div>

        <div class="mt-6 flex justify-between">
            <button @click="closePanel()" class="px-4 py-2 bg-gray-800 rounded-lg">Cancel</button>
        </div>
    </div>

</div>

<script>
function blockBuilder() {
    return {
        panelOpen: false,
        panelTitle: "",
        mode: "",
        page_id: <?= $page_id ?>,

        openPanel(action, blockId = null, type = null) {
            this.panelOpen = true;

            if (action === "add") {
                this.panelTitle = "Add Block";
                this.loadForm("block_add.php?page_id=" + this.page_id);
            } 
            else {
                this.panelTitle = "Edit Block";
                this.loadForm("block_edit.php?id=" + blockId);
            }
        },

        closePanel() {
            this.panelOpen = false;
        },

        loadForm(url) {
            fetch(url)
                .then(res => res.text())
                .then(html => {
                    document.getElementById("blockFormContainer").innerHTML = html;
                });
        }
    }
}

// DRAG & DROP SORTING
Sortable.create(blockList, {
    handle: '.cursor-move',
    animation: 150,
    onEnd: function(evt){
        const items = Array.from(document.querySelectorAll('#blockList [data-id]'))
                           .map((el, index) => ({ id: el.dataset.id, order: index }));

        fetch('block_reorder.php?page_id=<?= $page_id ?>', {
            method: 'POST',
            headers: { 'Content-Type':'application/json' },
            body: JSON.stringify(items)
        });
    }
});
</script>

<?php include "includes/admin_footer.php"; ?>
