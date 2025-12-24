<section class="py-16 mb-12">
    <div class="grid md:grid-cols-2 gap-10 items-center">

        <div>
            <h2 class="text-3xl font-bold mb-4"><?= $data['title'] ?></h2>
            <p class="text-gray-400 leading-relaxed"><?= nl2br($data['text']) ?></p>
        </div>

        <?php if (!empty($data['image'])): ?>
            <img src="/uploads/<?= $data['image'] ?>" class="rounded-lg shadow">
        <?php endif; ?>
    </div>
</section>
