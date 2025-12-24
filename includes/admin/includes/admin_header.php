<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Panel - Blue Arrow</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<!-- Alpine.js (state + slide over logic) -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<!-- SortableJS for drag and drop -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.13.0/Sortable.min.js"></script>

</head>

<body class="bg-gray-950 text-white flex">

<!-- SIDEBAR -->
<aside class="w-64 bg-gray-900 h-screen fixed left-0 top-0 border-r border-gray-800">
    <div class="p-6 flex items-center gap-3 border-b border-gray-800">
        <i class="fa-solid fa-shield-halved text-blue-400 text-2xl"></i>
        <h1 class="text-xl font-bold">Admin Panel</h1>
    </div>

<nav class="p-4 space-y-2 text-gray-300">

    <!-- Dashboard -->
    <a href="dashboard.php"
       class="flex items-center gap-3 p-3 rounded hover:bg-gray-800 transition">
        <i class="fa-solid fa-gauge"></i>
        Dashboard
    </a>
	<a href="leads_list.php" class="flex items-center gap-3 p-3 rounded hover:bg-gray-800 transition">
        <i class="fa-solid fa-gauge"></i>
		Leads
	</a>



    <!-- CONTENT SECTION LABEL -->
    <div class="mt-6 mb-2 px-3 text-xs uppercase tracking-wider text-gray-500">
        Content
    </div>
	

	 <!-- PAGES -->
<!-- SITE PAGES (COLLAPSIBLE) -->
<div x-data="{ open: false }" class="mt-4">

    <!-- TOGGLE -->
    <button 
        @click="open = !open"
        class="w-full flex items-center justify-between px-3 py-2 
               text-gray-400 font-semibold hover:bg-gray-800 rounded transition"
    >
        <div class="flex items-center gap-3">
            <i class="fa-solid fa-file-lines"></i>
            Site Pages
        </div>

        <i 
            class="fa-solid fa-chevron-down text-sm transition-transform"
            :class="{ 'rotate-180': open }"
        ></i>
    </button>

    <!-- SUB MENU -->
    <div 
        x-show="open"
        x-transition
        class="mt-1 space-y-1"
        style="display: none;"
    >
        <a href="pages_list.php"
           class="block pl-10 pr-3 py-2 rounded hover:bg-gray-800 transition">
            Manage Pages
        </a>

        <a href="add_page.php"
           class="block pl-10 pr-3 py-2 rounded hover:bg-gray-800 transition">
            Add Page
        </a>
    </div>
</div>

		
<!-- BLOGS (COLLAPSIBLE) -->
<div x-data="{ open: false }" class="mt-4">

    <!-- TOGGLE -->
    <button 
        @click="open = !open"
        class="w-full flex items-center justify-between px-3 py-2 
               text-gray-400 font-semibold hover:bg-gray-800 rounded transition"
    >
        <div class="flex items-center gap-3">
            <i class="fa-solid fa-blog"></i>
            Blogs
        </div>

        <i 
            class="fa-solid fa-chevron-down text-sm transition-transform"
            :class="{ 'rotate-180': open }"
        ></i>
    </button>

    <!-- SUB MENU -->
    <div 
        x-show="open"
        x-transition
        class="mt-1 space-y-1"
        style="display: none;"
    >
        <a href="blog_list.php"
           class="block pl-10 pr-3 py-2 rounded hover:bg-gray-800 transition">
            All Blogs
        </a>

        <a href="blog_add.php"
           class="block pl-10 pr-3 py-2 rounded hover:bg-gray-800 transition">
            Add New Blog
        </a>
    </div>

</div>

	

	
	
	
	

<!-- REGULATIONS (COLLAPSIBLE) -->
<div x-data="{ open: false }" class="mt-4">

    <!-- HEADER / TOGGLE -->
    <button 
        @click="open = !open"
        class="w-full flex items-center justify-between px-3 py-2 
               text-gray-400 font-semibold hover:bg-gray-800 rounded transition"
    >
        <div class="flex items-center gap-3">
            <i class="fa-solid fa-scale-balanced"></i>
            Regulations
        </div>

        <i 
            class="fa-solid fa-chevron-down text-sm transition-transform"
            :class="{ 'rotate-180': open }"
        ></i>
    </button>

    <!-- SUB MENU -->
    <div 
        x-show="open"
        x-transition
        class="mt-1 space-y-1"
        style="display: none;"
    >
        <a href="regulations_list.php"
           class="block pl-10 pr-3 py-2 rounded hover:bg-gray-800 transition">
            All Regulations
        </a>

        <a href="add_regulation.php"
           class="block pl-10 pr-3 py-2 rounded hover:bg-gray-800 transition">
            Add New Regulation
        </a>
    </div>

</div>


    <!-- LOGOUT -->
    <div class="mt-6 border-t border-gray-800 pt-4">
        <a href="logout.php"
           class="flex items-center gap-3 p-3 rounded text-red-400 hover:bg-gray-800 transition">
            <i class="fa-solid fa-right-from-bracket"></i>
            Logout
        </a>
    </div>

</nav>

</aside>

<!-- MAIN CONTENT -->
<main class="ml-64 p-10 w-full">
