<section class="py-20 mb-12 text-center bg-blue-700 rounded-xl text-white">
    <h2 class="text-4xl font-bold mb-4"><?= $data['title'] ?></h2>
    <p class="text-xl mb-6"><?= $data['subtitle'] ?></p>

    <a href="<?= $data['button_link'] ?>" 
       class="inline-block bg-gray-900 px-8 py-3 rounded-lg hover:bg-black">
       <?= $data['button_text'] ?>
    </a>
</section>
