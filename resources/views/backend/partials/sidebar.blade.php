<!-- SIDEBAR -->
<aside class="w-64 glass-sidebar text-white flex-shrink-0 hidden md:flex flex-col border-r border-slate-800">
    <div class="p-6 border-b border-slate-800 flex items-center gap-3">
        <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
            <i class="fas fa-bolt text-white"></i>
        </div>
        <span class="text-xl font-bold tracking-tight">Logo</span>
    </div>
    
    <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-4 mb-2">Main Menu</p>
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white shadow-lg shadow-indigo-500/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
            <i class="fas fa-th-large w-5"></i>
            <span class="font-medium text-sm">Dashboard</span>
        </a>
        
        <a href="{{ route('admin.users') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.users') ? 'bg-primary text-white shadow-lg shadow-indigo-500/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
            <i class="fas fa-users w-5"></i>
            <span class="font-medium text-sm">Users</span>
            <span class="ml-auto bg-slate-800 text-[10px] py-0.5 px-2 rounded-full border border-slate-700">API</span>
        </a>

        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-4 mt-8 mb-2">Settings</p>
        <a href="{{ route('admin.mail-settings') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.mail-settings') ? 'bg-primary text-white shadow-lg shadow-indigo-500/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
            <i class="fas fa-envelope-open-text w-5"></i>
            <span class="font-medium text-sm">Mail Settings</span>
        </a>
    </nav>
    <div class="p-4 border-t border-slate-800">
        <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-900 border border-slate-800">
            <div class="w-10 h-10 rounded-full bg-slate-700 flex items-center justify-center text-slate-300 font-bold">
                {{ strtoupper(substr(Auth::guard('admin')->user()->name ?? 'A', 0, 1)) }}
            </div>
            <div class="flex-1 overflow-hidden">
                <p class="text-sm font-semibold truncate">{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</p>
                <p class="text-[10px] text-slate-500 uppercase font-bold">{{ Auth::guard('admin')->user()->role ?? 'Superadmin' }}</p>
            </div>
        </div>
        <form action="{{ route('admin.logout') }}" method="POST" class="mt-3">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-red-400 hover:bg-red-500/10 transition-all">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </button>
        </form>
    </div>
</aside>
