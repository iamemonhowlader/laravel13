@extends('backend.layouts.master')

@section('title', 'Dashboard')
@section('page-title', 'Overview')

@section('content')

<!-- Statistics Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center">
                <i class="fas fa-users text-xl"></i>
            </div>
            <span class="text-xs font-bold text-emerald-500 bg-emerald-50 px-2 py-1 rounded-lg">+12%</span>
        </div>
        <h3 class="text-slate-500 text-sm font-semibold uppercase tracking-wider">Total Users</h3>
        <p class="text-3xl font-black text-slate-900 mt-1">{{ number_format($stats['total_users']) }}</p>
    </div>

    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center">
                <i class="fas fa-user-plus text-xl"></i>
            </div>
            <span class="text-xs font-bold text-slate-400 bg-slate-50 px-2 py-1 rounded-lg">Today</span>
        </div>
        <h3 class="text-slate-500 text-sm font-semibold uppercase tracking-wider">New Signups</h3>
        <p class="text-3xl font-black text-slate-900 mt-1">{{ $stats['new_users_today'] }}</p>
    </div>

    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center">
                <i class="fas fa-shield-alt text-xl"></i>
            </div>
            <span class="text-xs font-bold text-amber-500 bg-amber-50 px-2 py-1 rounded-lg">Active</span>
        </div>
        <h3 class="text-slate-500 text-sm font-semibold uppercase tracking-wider">OTPs Sent</h3>
        <p class="text-3xl font-black text-slate-900 mt-1">{{ number_format($stats['total_otps']) }}</p>
    </div>

    <div class="bg-slate-900 p-6 rounded-3xl border border-slate-800 shadow-xl shadow-slate-200">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white/10 text-white rounded-2xl flex items-center justify-center border border-white/10">
                <i class="fas fa-fingerprint text-xl"></i>
            </div>
            <div class="flex -space-x-2">
                <div class="w-6 h-6 rounded-full border-2 border-slate-900 bg-indigo-500"></div>
                <div class="w-6 h-6 rounded-full border-2 border-slate-900 bg-rose-500"></div>
            </div>
        </div>
        <h3 class="text-slate-400 text-sm font-semibold uppercase tracking-wider">Auth Driver</h3>
        <p class="text-3xl font-black text-white mt-1">JWT <span class="text-indigo-400 text-sm font-normal">v2.3</span></p>
    </div>

</div>

<!-- Recent Users & API Info -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Table -->
    <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-50 flex items-center justify-between">
            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                <i class="fas fa-history text-indigo-500"></i>
                Recent Activities
            </h3>
            <a href="{{ route('admin.users') }}" class="text-xs font-bold text-indigo-600 hover:underline">View All Users</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">User</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">Email</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-4 text-right text-[10px] font-bold text-slate-400 uppercase tracking-widest">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($recent_users as $user)
                    <tr class="hover:bg-slate-50/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xs">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <span class="text-sm font-bold text-slate-700">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500 font-medium">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                ACTIVE
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button class="p-2 text-slate-400 hover:text-indigo-600 transition-colors"><i class="fas fa-ellipsis-h text-xs"></i></button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-400 font-medium italic">No recent users found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- API Reference Sidebar -->
    <div class="space-y-6">
        <div class="bg-indigo-600 p-6 rounded-3xl shadow-xl shadow-indigo-100 relative overflow-hidden group">
            <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-white/10 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
            <h3 class="text-white font-bold mb-4 flex items-center gap-2">
                <i class="fas fa-plug text-indigo-200"></i>
                API Endpoints
            </h3>
            <div class="space-y-3">
                <div class="p-3 bg-white/10 rounded-2xl border border-white/10 flex items-center justify-between">
                    <span class="text-[10px] font-black text-indigo-100 bg-white/20 px-2 py-0.5 rounded">POST</span>
                    <span class="text-[11px] text-white font-mono truncate ml-2">/api/auth/login</span>
                </div>
                <div class="p-3 bg-white/10 rounded-2xl border border-white/10 flex items-center justify-between">
                    <span class="text-[10px] font-black text-emerald-100 bg-emerald-500/20 px-2 py-0.5 rounded">GET</span>
                    <span class="text-[11px] text-white font-mono truncate ml-2">/api/auth/me</span>
                </div>
                <p class="text-[10px] text-indigo-200 mt-4 font-medium italic text-center underline">Full documentation in routes/api/auth.php</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                <i class="fas fa-server text-emerald-500"></i>
                System Status
            </h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between text-xs">
                    <span class="text-slate-500 font-medium">Laravel Version</span>
                    <span class="font-bold text-slate-900">v13.8.0</span>
                </div>
                <div class="flex items-center justify-between text-xs">
                    <span class="text-slate-500 font-medium">Database</span>
                    <span class="font-bold text-slate-900">SQLite</span>
                </div>
                <div class="w-full bg-slate-100 h-1.5 rounded-full mt-4 overflow-hidden">
                    <div class="bg-indigo-600 h-full w-[85%] rounded-full"></div>
                </div>
                <p class="text-[10px] text-slate-400 font-bold text-center">85% Server Health</p>
            </div>
        </div>
    </div>

</div>

@endsection
