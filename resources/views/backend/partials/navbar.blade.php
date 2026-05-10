<!-- TOPBAR -->
<header class="h-16 flex items-center justify-between px-8 bg-white border-b border-slate-200">
    <div class="flex items-center gap-4">
        <button class="md:hidden text-slate-600"><i class="fas fa-bars"></i></button>
        <h2 class="text-lg font-bold text-slate-800">@yield('page-title', 'Overview')</h2>
    </div>
    
    <div class="flex items-center gap-4">
        <div class="relative hidden sm:block">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                <i class="fas fa-search text-xs"></i>
            </span>
            <input type="text" class="block w-64 pl-10 pr-3 py-1.5 bg-slate-100 border-none rounded-lg text-sm focus:ring-2 focus:ring-primary/20" placeholder="Search anything...">
        </div>
        <button class="w-10 h-10 flex items-center justify-center rounded-full text-slate-500 hover:bg-slate-100 transition-all relative">
            <i class="far fa-bell"></i>
            <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 border-2 border-white rounded-full"></span>
        </button>
    </div>
</header>
