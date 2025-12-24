<?php
require_once __DIR__ . "/../core/db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Blue Arrow Management Consultants</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Tailwind config -->
<script src="https://cdn.tailwindcss.com?plugins=typography"></script>
<script>tailwind.config = {darkMode: 'class'}</script>

<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- AOS -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    AOS.init({
        duration: 800,
        once: true,
        easing: "ease-out-cubic"
    });
});
</script>

<!-- Alpine -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body
  x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }"
  x-init="$watch('darkMode', v => localStorage.setItem('theme', v ? 'dark' : 'light'))"
  :class="{ 'dark': darkMode }"
  class="bg-gray-50 text-gray-900 dark:bg-gray-950 dark:text-white transition-colors duration-300"
>

<!-- ================= NAVBAR ================= -->
<nav
  x-data="{ open: false }"
  class="fixed top-0 left-0 right-0 z-50
         bg-white dark:bg-gray-900
         border-b border-gray-200 dark:border-gray-800"
>
  <div class="container mx-auto px-6 py-4 flex items-center justify-between">

    <!-- LOGO -->
    <a href="<?= BASE_URL ?>" class="flex items-center gap-3 group">
        <img src="<?= BASE_URL ?>images/logosvg.svg" class="h-10" alt="BAMC Logo">
        <span class="text-xl md:text-2xl font-semibold
                     text-gray-900 dark:text-white
                     group-hover:text-blue-600 dark:group-hover:text-blue-400
                     transition">
            Blue Arrow Management Consultants
        </span>
    </a>

    <!-- DESKTOP MENU -->
    <div class="hidden md:flex items-center gap-8 font-medium">

        <a href="<?= BASE_URL ?>" class="nav-link text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-white">
            Home
        </a>

        <a href="<?= BASE_URL ?>page.php?slug=about" class="nav-link text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-white">
            About
        </a>

        <a href="<?= BASE_URL ?>blogs.php" class="nav-link text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-white">
            Blog
        </a>

        <a href="<?= BASE_URL ?>regulations.php" class="nav-link text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-white">
            Regulations
        </a>

        <!-- CONTACT CTA -->
        <a href="<?= BASE_URL ?>contact.php"
           class="ml-4 px-6 py-2 rounded-lg
                  bg-blue-600 hover:bg-blue-700
                  text-white font-semibold transition shadow-md">
            Contact
        </a>

        <!-- THEME TOGGLE -->
        <button
          @click="darkMode = !darkMode"
          class="ml-2 p-2 rounded-lg
                 bg-gray-200 hover:bg-gray-300
                 dark:bg-gray-800 dark:hover:bg-gray-700
                 transition"
          aria-label="Toggle theme"
        >
            <i class="fa-solid fa-moon text-gray-800 dark:hidden"></i>
            <i class="fa-solid fa-sun text-yellow-400 hidden dark:block"></i>
        </button>
    </div>
  </div>
<!-- MOBILE MENU TOGGLE -->
<button
  @click="open = !open"
  class="md:hidden text-gray-700 dark:text-gray-300 text-2xl"
>
    <i class="fa-solid" :class="open ? 'fa-xmark' : 'fa-bars'"></i>
</button>

  <!-- MOBILE MENU -->
  <div
    x-show="open"
    x-transition
    class="md:hidden
           bg-white dark:bg-gray-900
           border-t border-gray-200 dark:border-gray-800
           px-6 pb-6 space-y-4"
  >
    <a href="<?= BASE_URL ?>" class="block text-gray-700 dark:text-gray-300">Home</a>
    <a href="<?= BASE_URL ?>page.php?slug=about" class="block text-gray-700 dark:text-gray-300">About</a>
    <a href="<?= BASE_URL ?>blogs.php" class="block text-gray-700 dark:text-gray-300">Blog</a>
    <a href="<?= BASE_URL ?>regulations.php" class="block text-gray-700 dark:text-gray-300">Regulations</a>

    <a href="<?= BASE_URL ?>contact.php"
       class="block mt-3 px-4 py-3 rounded-lg
              bg-blue-600 hover:bg-blue-700
              text-white font-semibold text-center">
        Contact
    </a>
	<button
  @click="darkMode = !darkMode"
  class="mt-4 w-full flex items-center justify-center gap-3
         px-4 py-3 rounded-lg
         bg-gray-200 hover:bg-gray-300
         dark:bg-gray-800 dark:hover:bg-gray-700
         transition"
>
    <i class="fa-solid fa-moon text-gray-800 dark:hidden"></i>
    <i class="fa-solid fa-sun text-yellow-400 hidden dark:block"></i>
    <span class="font-semibold text-gray-800 dark:text-white">
        Toggle Theme
    </span>
</button>

  </div>
</nav>

<!-- NAVBAR SPACER -->
<div class="h-20"></div>

<!-- LINK UNDERLINE EFFECT -->
<style>
.nav-link {
    position: relative;
}
.nav-link::after {
    content: "";
    position: absolute;
    bottom: -4px;
    left: 0;
    height: 2px;
    width: 0%;
    background-color: rgba(96, 165, 250, 0.9);
    transition: width 0.3s ease;
}
.nav-link:hover::after {
    width: 100%;
}
</style>
