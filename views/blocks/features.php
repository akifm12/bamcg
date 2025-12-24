<section class="py-16 mb-12">
    <h2 class="text-3xl font-bold mb-4"><?= $data['title'] ?></h2>
    <p class="text-gray-400 mb-10"><?= $data['subtitle'] ?></p>

    <div class="grid md:grid-cols-3 gap-8">

        <?php for ($i=1; $i<=3; $i++): ?>
            <?php if (!empty($data["f{$i}_title"])): ?>
            <div class="p-6 bg-gray-900 rounded-xl border border-gray-800">
                <i class="<?= $data["f{$i}_icon"] ?> text-blue-400 text-4xl mb-4"></i>
                <h3 class="text-xl font-semibold mb-2"><?= $data["f{$i}_title"] ?></h3>
                <p class="text-gray-400"><?= $data["f{$i}_desc"] ?></p>
            </div>
            <?php endif; ?>
        <?php endfor; ?>

    </div>
</section>
