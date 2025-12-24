<section class="relative flex items-center py-32 mb-12 overflow-hidden">

    <!-- Animated Gradient Background -->
    <div class="absolute inset-0 bg-gradient-to-br from-blue-800/20 via-blue-900/10 to-black"></div>

    <!-- Glowing Orb Effect -->
    <div class="absolute -top-40 -right-40 w-[450px] h-[450px] bg-blue-600/30 rounded-full blur-3xl opacity-40 animate-pulse"></div>

    <?php if (!empty($data['background_image'])): ?>
    <!-- Background Image (Softened) -->
    <div class="absolute inset-0 opacity-10 bg-cover bg-center"
         style="background-image:url('/uploads/<?= $data['background_image'] ?>')"></div>
    <?php endif; ?>

    <!-- Content -->
    <div class="relative z-10 container mx-auto px-4 max-w-4xl">

        <h1 class="text-4xl md:text-6xl font-extrabold leading-tight text-white mb-6">
            <?= nl2br(htmlspecialchars($data['title'])) ?>
        </h1>

        <p class="text-xl md:text-2xl text-gray-300 mb-10 leading-relaxed">
            <?= nl2br(htmlspecialchars($data['subtitle'])) ?>
        </p>

        <div class="flex flex-wrap items-center gap-4">

            <?php if (!empty($data['button_text'])): ?>
            <a href="<?= $data['button_link'] ?>" 
               class="px-8 py-3 rounded-lg text-lg font-semibold 
                      bg-blue-600 hover:bg-blue-700 text-white transition">
               <?= htmlspecialchars($data['button_text']) ?>
            </a>
            <?php endif; ?>

            <a href="#services" 
               class="px-8 py-3 rounded-lg text-lg font-semibold 
                      bg-gray-800 hover:bg-gray-700 text-white transition">
               Learn More
            </a>

        </div>

    </div>

</section>
