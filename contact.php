<?php include "includes/header.php"; ?>

<section class="relative py-24 bg-gray-950">
    <div class="container mx-auto px-6 max-w-6xl">

        <!-- PAGE HEADER -->
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4">
                Contact Our Compliance Team
            </h1>
            <p class="text-gray-300 max-w-3xl mx-auto text-lg">
                Whether you are unsure about your regulatory obligations or need full-scale compliance support,
                our specialists are here to guide you every step of the way.
            </p>
        </div>

        <!-- GRID -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">

            <!-- LEFT: INFO -->
            <div class="space-y-8">

                <div>
                    <h2 class="text-2xl font-bold text-white mb-3">
                        How We Can Help
                    </h2>
                    <p class="text-gray-300 leading-relaxed">
                        We assist UAE-based and international businesses across AML compliance,
                        KYC/KYB onboarding, regulatory audits, policy development, outsourced MLRO services,
                        and RegTech implementation.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                    <div class="p-5 bg-gray-900 rounded-xl border border-gray-800">
                        <i class="fa-solid fa-scale-balanced text-blue-400 text-2xl mb-3"></i>
                        <h3 class="font-semibold text-white mb-1">Regulatory Guidance</h3>
                        <p class="text-gray-400 text-sm">
                            MOE, CBUAE, VARA, FIU, Free Zone authorities
                        </p>
                    </div>

                    <div class="p-5 bg-gray-900 rounded-xl border border-gray-800">
                        <i class="fa-solid fa-shield-halved text-blue-400 text-2xl mb-3"></i>
                        <h3 class="font-semibold text-white mb-1">AML & Risk</h3>
                        <p class="text-gray-400 text-sm">
                            Policies, audits, training, risk assessments
                        </p>
                    </div>

                    <div class="p-5 bg-gray-900 rounded-xl border border-gray-800">
                        <i class="fa-solid fa-microchip text-blue-400 text-2xl mb-3"></i>
                        <h3 class="font-semibold text-white mb-1">RegTech</h3>
                        <p class="text-gray-400 text-sm">
                            Screening, onboarding & automation tools
                        </p>
                    </div>

                    <div class="p-5 bg-gray-900 rounded-xl border border-gray-800">
                        <i class="fa-solid fa-user-shield text-blue-400 text-2xl mb-3"></i>
                        <h3 class="font-semibold text-white mb-1">Outsourced MLRO</h3>
                        <p class="text-gray-400 text-sm">
                            Ongoing compliance oversight & reporting
                        </p>
                    </div>

                </div>
            </div>

            <!-- RIGHT: CTA CARD -->
            <div class="container mx-auto px-6 max-w-3xl">

        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-white mb-4">
                Contact Us
            </h1>
            <p class="text-gray-300 text-lg">
                Speak with our compliance specialists for tailored regulatory guidance.
            </p>
        </div>

      <!-- RIGHT: CONTACT FORM -->
<div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 shadow-xl">

    <h2 class="text-2xl font-bold text-white mb-2">
        Get in Touch
    </h2>
    <p class="text-gray-400 mb-6 text-sm">
        Share your details and our compliance team will reach out shortly.
    </p>

    <form action="submit_contact.php" method="post"
          class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <!-- Company -->
        <div>
            <label class="block text-xs text-gray-400 mb-1">Company</label>
            <input type="text" name="company" required
                   class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 
                          text-sm text-white focus:border-blue-500 outline-none">
        </div>

        <!-- Name -->
        <div>
            <label class="block text-xs text-gray-400 mb-1">Contact Name</label>
            <input type="text" name="name" required
                   class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 
                          text-sm text-white focus:border-blue-500 outline-none">
        </div>

        <!-- Email -->
        <div>
            <label class="block text-xs text-gray-400 mb-1">Email</label>
            <input type="email" name="email" required
                   class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 
                          text-sm text-white focus:border-blue-500 outline-none">
        </div>

        <!-- Phone -->
        <div>
            <label class="block text-xs text-gray-400 mb-1">Phone</label>
            <input type="text" name="phone" required
                   class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 
                          text-sm text-white focus:border-blue-500 outline-none">
        </div>

        <!-- Industry (FULL WIDTH) -->
        <div class="md:col-span-2">
            <label class="block text-xs text-gray-400 mb-1">Industry</label>
            <select name="industry" required
                    class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 
                           text-sm text-white focus:border-blue-500 outline-none">
                <option value="">Select Industry</option>
                <option>Bullion / Precious Metals</option>
                <option>Capital Markets / Prop Trading</option>
                <option>Real Estate</option>
                <option>Virtual Assets</option>
                <option>Accounting / Audit</option>
                <option>General Trading</option>
            </select>
        </div>

        <!-- Submit -->
        <div class="md:col-span-2 pt-2">
            <button type="submit"
                    class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 
                           text-white text-sm font-semibold rounded-lg transition">
                Submit Inquiry
            </button>
        </div>

    </form>
</div>

        </div>

        </div>
    </div>
</section>

<?php include "includes/footer.php"; ?>
