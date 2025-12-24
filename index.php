<?php include "includes/header.php"; ?>

<!-- ============================= -->
<!-- ALPINE UNIFIED CONTROLLER -->
<!-- ============================= -->
<script>
function appState() {
    return {
        modals: {
            getStarted: false,
            service: null,
            wizard: false
        },

        openService(name) {
            this.modals.service = name;
        },
        closeService() {
            this.modals.service = null;
        },

        inquiry: {
            company: "",
            email: "",
            phone: "",
            industry: "",
            license_type: "",
            emirate: "",
            services: [],
            comments: ""
        },
        openInquiry() {
            this.modals.getStarted = true;
        },
        closeInquiry() {
            this.modals.getStarted = false;
        },

        wizard: {
            step: 1,
            industry: null,
            regulator: null,
            limitedRequirements: [],
            lead: { name:"", email:"", phone:"", company:"", comments:"" }
        },

        industries: {
            bullion: "Precious Metals / Stones Trading",
            capital_markets: "Capital Markets / Prop Trading",
            real_estate: "Real Estate",
            virtual_assets: "Virtual Assets / Crypto",
            accounting: "Accounting / Audit",
            dnfbp: "Company Service Provider"
        },

        regulators: {
            moe: "Ministry of Economy (MOE)",
            dfsa: "DFSA",
            fsra: "FSRA",
            vara: "VARA",
            sca: "SCA",
            unsure: "Not Sure"
        },

        allRequirements: {
            bullion: ["KYC/KYB onboarding framework","GoAML Registration","AML/CFT Policy Development","Annual AML Training"],
            virtual_assets: ["Enhanced KYC & Blockchain AML","Travel Rule Readiness","Risk-Based Approach Implementation","Transaction Monitoring Setup"],
            real_estate: ["Customer Due Diligence","Suspicious Activity Detection","AML/CFT Staff Training","Risk Assessment Documentation"],
            accounting: ["Client Due Diligence","Compliance Risk Assessment","AML/CFT Internal Policies","Training & Audit Support"]
        },

        startWizard() {
            this.modals.wizard = true;
            this.wizard.step = 1;
        },
        closeWizard() {
            this.modals.wizard = false;
        },
        selectIndustry(ind) {
            this.wizard.industry = ind;
            this.wizard.step = 2;
        },
        selectRegulator(reg) {
            this.wizard.regulator = reg;
            let reqs = this.allRequirements[this.wizard.industry] ?? [];
            this.wizard.limitedRequirements = reqs.slice(0,3).concat(["+ additional requirements apply"]);
            this.wizard.step = 3;
        },
        backWizard() {
            if (this.wizard.step > 1) this.wizard.step--;
        },
        async submitWizardLead() {
            await fetch("submit_lead.php", {
                method: "POST",
                headers: {"Content-Type":"application/json"},
                body: JSON.stringify({...this.wizard.lead, industry:this.wizard.industry, regulator:this.wizard.regulator})
            });
            this.wizard.step = 5;
        }
    }
}
</script>


<body>
<div x-data="appState()" x-cloak class="bg-white text-gray-900 dark:bg-gray-950 dark:text-white transition-colors duration-300">

<!-- ============================= -->
<!-- HERO SECTION -->
<!-- ============================= -->
<section class="relative flex items-center py-40 overflow-hidden">

    <div class="absolute inset-0 bg-gradient-to-br from-blue-700/30 via-gray-900/40 to-gray-950/70"></div>

    <img src="https://images.unsplash.com/photo-1556741533-f6acd647d2fb"
         class="absolute inset-0 w-full h-full object-cover opacity-10">

    <div class="relative z-10 container mx-auto px-6 max-w-4xl">
        <h1 class="text-4xl md:text-6xl font-extrabold mb-6 text-white">
            Compliance. Simplified. Automated.
        </h1>

        <p class="text-lg md:text-xl text-gray-200 mb-10">
            AI-powered AML, KYC/KYB, document verification, and regulatory support tailored for UAE businesses.
        </p>

        <div class="flex gap-4">
            <button @click="startWizard()"
                    class="px-6 py-3 bg-blue-700 hover:bg-blue-800 rounded-lg text-white font-semibold">
                Do I need Regulatory Support
            </button>
            <a href="#services"
               class="px-6 py-3 bg-blue-700 hover:bg-blue-800 rounded-lg text-white font-semibold">
                Glance at our Services
            </a>
        </div>
    </div>
</section>

<!-- ============================= -->
<!-- SERVICES -->
<!-- ============================= -->
<section id="services" class="py-24 container mx-auto px-6">
<?php
$services = [
    ["AML Compliance","fa-shield-halved","Frameworks aligned with UAE AML law."],
    ["KYC/KYB Screening","fa-id-card","Identity verification & sanctions screening."],
    ["Document Verification","fa-file-shield","OCR + human-reviewed validation."],
    ["Policies & Procedures","fa-book","Custom regulatory documentation packages."],
    ["Risk Assessment","fa-chart-line","Business-wide AML risk scoring."],
    ["Independent AML Audit","fa-magnifying-glass-chart","Mandatory annual AML audits."],
    ["Outsourced MLRO","fa-user-shield","Fully outsourced MLRO services."],
    ["Professional Training","fa-chalkboard-user","Certified AML/KYC training programs."]
];

$serviceDetails = [
    "AML Compliance" => [
        "desc" => "End-to-end AML/CFT frameworks aligned with UAE Federal AML Law, MOE, FIU, VARA and FATF.",
        "points" => [
            "AML/CFT Policies & Procedures",
            "Business-wide risk assessment (BWRA)",
            "Sanctions & PEP screening framework",
            "goAML registration & reporting",
            "Regulatory inspection readiness"
        ]
    ],
    "KYC/KYB Screening" => [
        "desc" => "Hybrid AI-assisted and manual KYC/KYB screening solutions for regulated onboarding.",
        "points" => [
            "Individual & corporate KYC",
            "UBO identification & verification",
            "Sanctions & adverse media screening",
            "Risk scoring models",
            "Ongoing monitoring support"
        ]
    ],
    "Document Verification" => [
        "desc" => "Secure OCR-based document verification with compliance review.",
        "points" => [
            "Passport & Emirates ID verification",
            "Trade license & corporate documents",
            "Invoice & POA verification",
            "Expiry & tampering detection"
        ]
    ],
    "Policies & Procedures" => [
        "desc" => "Tailored compliance manuals based on regulator and business activity.",
        "points" => [
            "AML/CFT policy manuals",
            "CDD & EDD procedures",
            "Record keeping policies",
            "Internal governance frameworks"
        ]
    ],
    "Risk Assessment" => [
        "desc" => "Comprehensive AML/CFT risk assessment frameworks.",
        "points" => [
            "Customer risk scoring",
            "Country & product risk analysis",
            "Residual risk evaluation",
            "Audit-ready documentation"
        ]
    ],
    "Independent AML Audit" => [
        "desc" => "Mandatory annual AML audits for regulated entities.",
        "points" => [
            "AML framework review",
            "KYC/KYB process audit",
            "Sanctions screening assessment",
            "Corrective action report"
        ]
    ],
    "Outsourced MLRO" => [
        "desc" => "Professional MLRO services without full-time hiring.",
        "points" => [
            "Transaction & onboarding monitoring",
            "STR/SAR filing",
            "Regulatory liaison",
            "Ongoing compliance oversight"
        ]
    ],
    "Professional Training" => [
        "desc" => "Certified AML & compliance training programs.",
        "points" => [
            "AML/CFT foundations",
            "KYC & onboarding training",
            "Sanctions & red flags",
            "Compliance certification"
        ]
    ]
];
?>

    <h2 class="text-4xl font-bold mb-4">Our Services</h2>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <?php foreach ($services as $s): ?>
        <div @click="openService('<?= $s[0] ?>')"
             class="p-6 bg-white dark:bg-gray-850 border rounded-xl text-center cursor-pointer hover:border-blue-500">
            <i class="fa-solid <?= $s[1] ?> text-blue-500 text-4xl mb-3"></i>
            <h3 class="font-semibold"><?= $s[0] ?></h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2"><?= $s[2] ?></p>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ============================= -->
<!-- BLOG PREVIEW -->
<!-- ============================= -->
<section class="py-24 bg-gray-100 dark:bg-gray-900">
    <div class="container mx-auto px-6">
        <h2 class="text-4xl font-bold mb-12 text-gray-900 dark:text-white">
            Latest Insights & Compliance Updates
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <?php
            try {
                $blogs = $pdo->query("SELECT title, slug, content, created_at FROM blogs ORDER BY created_at DESC LIMIT 3")->fetchAll();
            } catch(Exception $e) { $blogs = []; }

            foreach ($blogs as $b):
                $excerpt = substr(strip_tags($b["content"]),0,120)."...";
            ?>
            <div class="bg-white dark:bg-gray-850 border border-gray-200 dark:border-gray-700 rounded-xl p-6">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-3"><?= $b["title"] ?></h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4"><?= $excerpt ?></p>
                <a href="/blog.php?slug=<?= $b['slug'] ?>" class="text-blue-500 font-semibold">Read More →</a>
            </div>
            <?php endforeach; ?>
        </div>
		
		        <!-- View All -->
        <div class="text-center mt-14">
            <a href="<?= BASE_URL ?>blogs.php"
               class="px-10 py-3 bg-white dark:bg-gray-800
                      border border-gray-300 dark:border-gray-700
                      rounded-lg text-gray-800 dark:text-gray-200
                      font-semibold hover:border-blue-500 transition">
                View All Posts
            </a>
        </div>
		
		
    </div>
</section>


<!-- ============================= -->
<!-- REGULATIONS PREVIEW -->
<!-- ============================= -->
<section class="py-24 bg-gray-100 dark:bg-gray-900">
    <div class="container mx-auto px-6">

        <h2 class="text-4xl font-bold mb-4 text-gray-900 dark:text-white">
            Key Regulations & Guidance
        </h2>

        <p class="text-gray-600 dark:text-gray-300 mb-12 max-w-2xl">
            Official UAE regulations, circulars, and regulatory guidance relevant to your business.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

            <?php
            try {
                $regulations = $pdo->query("
                    SELECT title, slug, summary, created_at
                    FROM regulations
                    WHERE is_published = 1
                    ORDER BY created_at DESC
                    LIMIT 3
                ")->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                $regulations = [];
            }
            ?>

            <?php foreach ($regulations as $r): ?>
                <div class="bg-white dark:bg-gray-850
                            border border-gray-200 dark:border-gray-700
                            rounded-xl p-6 hover:border-blue-500 transition">

                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                        <?= htmlspecialchars($r['title']) ?>
                    </h3>

                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                        <?= htmlspecialchars(substr(strip_tags($r['summary']), 0, 120)) ?>…
                    </p>

                    <p class="text-xs text-gray-500 dark:text-gray-500 mb-4">
                        <?= date("F j, Y", strtotime($r['created_at'])) ?>
                    </p>

                    <a href="<?= BASE_URL ?>regulation.php?slug=<?= urlencode($r['slug']) ?>"
                       class="text-blue-600 dark:text-blue-400 font-semibold text-sm">
                        View Regulation →
                    </a>
                </div>
            <?php endforeach; ?>

            <?php if (empty($regulations)): ?>
                <p class="text-gray-500 dark:text-gray-400">
                    No regulations published yet.
                </p>
            <?php endif; ?>

        </div>

        <!-- View All -->
        <div class="text-center mt-14">
            <a href="<?= BASE_URL ?>regulations.php"
               class="px-10 py-3 bg-white dark:bg-gray-800
                      border border-gray-300 dark:border-gray-700
                      rounded-lg text-gray-800 dark:text-gray-200
                      font-semibold hover:border-blue-500 transition">
                View All Regulations
            </a>
        </div>

    </div>
</section>


<!-- ============================= -->
<!-- SERVICE MODALS -->
<!-- ============================= -->
<?php foreach ($serviceDetails as $title => $detail): ?>
<div x-show="modals.service === '<?= $title ?>'"
     x-transition
     class="fixed inset-0 z-[90] flex items-center justify-center px-4">

    <div @click="closeService()" class="absolute inset-0 bg-black/70"></div>

    <div class="relative bg-white dark:bg-gray-900 border rounded-2xl p-8 max-w-3xl w-full">
        <h2 class="text-2xl font-bold mb-4"><?= $title ?></h2>

        <p class="mb-6 text-gray-700 dark:text-gray-300"><?= $detail['desc'] ?></p>

        <ul class="space-y-2 mb-6">
            <?php foreach ($detail['points'] as $p): ?>
            <li class="flex gap-2">
                <i class="fa-solid fa-check text-green-500 mt-1"></i>
                <span><?= $p ?></span>
            </li>
            <?php endforeach; ?>
        </ul>

            <button @click="startWizard()"
                    class="px-6 py-3 bg-blue-700 hover:bg-blue-800 rounded-lg text-white font-semibold">
                Get Started
            </button>
    </div>
</div>
<?php endforeach; ?>

<!-- ============================= -->
<!-- COMPLIANCE WIZARD -->
<!-- ============================= -->
<div x-show="modals.wizard" x-transition class="fixed inset-0 z-[100] flex items-center justify-center px-4">
    <div @click="closeWizard()" class="absolute inset-0 bg-black/70"></div>
    <div class="relative bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700
                rounded-2xl p-8 max-w-3xl w-full">

        <template x-if="wizard.step === 1">
            <div>
                <h2 class="text-2xl font-bold mb-6">Which industry are you in?</h2>
                <template x-for="(label,key) in industries">
                    <button @click="selectIndustry(key)"
                            class="block w-full mb-3 p-3 border rounded-lg">
                        <span x-text="label"></span>
                    </button>
                </template>
            </div>
        </template>

        <template x-if="wizard.step === 2">
            <div>
                <h2 class="text-2xl font-bold mb-6">Who is your regulator?</h2>
                <template x-for="(label,key) in regulators">
                    <button @click="selectRegulator(key)"
                            class="block w-full mb-3 p-3 border rounded-lg">
                        <span x-text="label"></span>
                    </button>
                </template>
                <button @click="backWizard()" class="mt-4 text-blue-500">&larr; Back</button>
            </div>
        </template>

        <template x-if="wizard.step === 3">
            <div>
                <h2 class="text-2xl font-bold mb-4">Preliminary Requirements</h2>
                <ul class="mb-6">
                    <template x-for="r in wizard.limitedRequirements">
                        <li x-text="r"></li>
                    </template>
                </ul>
                <button @click="wizard.step=4" class="bg-blue-600 text-white px-6 py-3 rounded-lg">
                    Continue
                </button>
            </div>
        </template>

        <template x-if="wizard.step === 4">
            <div>
                <h2 class="text-2xl font-bold mb-4">Your Details</h2>
                <form @submit.prevent="submitWizardLead()">
                    <input x-model="wizard.lead.name" placeholder="Name" class="w-full mb-3 p-3 border rounded">
                    <input x-model="wizard.lead.email" placeholder="Email" class="w-full mb-3 p-3 border rounded">
                    <button class="bg-green-600 text-white px-6 py-3 rounded-lg">Submit</button>
                </form>
            </div>
        </template>

        <template x-if="wizard.step === 5">
            <div class="text-center">
                <h2 class="text-2xl font-bold mb-4">Thank You</h2>
                <button @click="closeWizard()" class="bg-blue-600 text-white px-6 py-3 rounded-lg">
                    Close
                </button>
            </div>
        </template>
    </div>
</div>
</div>
<?php include "includes/footer.php"; ?>
</body>
</html>
