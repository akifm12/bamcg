<section class="py-16 mb-12">
    <h2 class="text-3xl font-bold mb-8">Gallery</h2>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <?php foreach ($data['images'] as $img): ?>
            <img src="/uploads/<?= $img ?>" class="rounded-lg shadow">
        <?php endforeach; ?>
    </div>
</section>
