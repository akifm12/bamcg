<section class="py-16 mb-12">
    <h2 class="text-3xl font-bold mb-8"><?= $data['title'] ?></h2>

    <div class="space-y-4">

        <?php for ($i=1; $i<=3; $i++): ?>
            <?php if (!empty($data["q{$i}"])): ?>
            <details class="bg-gray-900 p-5 rounded-lg border border-gray-800">
                <summary class="font-semibold cursor-pointer"><?= $data["q{$i}"] ?></summary>
                <p class="text-gray-400 mt-2"><?= nl2br($data["a{$i}"]) ?></p>
            </details>
            <?php endif; ?>
        <?php endfor; ?>

    </div>
</section>
