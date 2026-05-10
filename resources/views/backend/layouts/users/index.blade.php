@extends('backend.layouts.master')

@section('title', 'Users')
@section('page-title', 'User Management')

@section('content')

<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    
    <!-- Table Header with Search -->
    <div class="p-6 border-b border-slate-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h3 class="font-bold text-slate-800 text-lg">Platform Users</h3>
            <p class="text-slate-400 text-sm font-medium">Manage and monitor all API users.</p>
        </div>
        
        <form method="GET" action="{{ route('admin.users') }}" class="flex items-center gap-2">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                    <i class="fas fa-search text-xs"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" 
                    class="block w-full md:w-64 pl-9 pr-3 py-2 bg-slate-100 border-none rounded-xl text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none" 
                    placeholder="Search name or email...">
            </div>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl text-sm font-bold transition-all shadow-lg shadow-indigo-100">
                Filter
            </button>
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50">
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">ID</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">User Profile</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Email Status</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Joined Date</th>
                    <th class="px-6 py-4 text-right text-[10px] font-bold text-slate-400 uppercase tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($users as $user)
                <tr class="hover:bg-slate-50/30 transition-colors">
                    <td class="px-6 py-4 text-xs font-mono text-slate-400">#{{ $user->id }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 text-white flex items-center justify-center font-bold shadow-md shadow-indigo-100">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ $user->name }}</p>
                                <p class="text-xs text-slate-500 font-medium">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($user->email_verified_at)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-emerald-50 text-emerald-600 text-[10px] font-black">
                                <i class="fas fa-check-double"></i> VERIFIED
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-amber-50 text-amber-600 text-[10px] font-black">
                                <i class="fas fa-clock"></i> PENDING
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-500 font-medium">
                        {{ $user->created_at->format('M d, Y') }}
                        <span class="block text-[10px] text-slate-400">{{ $user->created_at->diffForHumans() }}</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-100 text-slate-500 hover:bg-indigo-600 hover:text-white transition-all">
                                <i class="fas fa-edit text-[10px]"></i>
                            </button>
                            <form action="{{ route('admin.users.delete', $user) }}" method="POST" onsubmit="return confirm('Archive this user?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-600 hover:text-white transition-all">
                                    <i class="fas fa-trash-alt text-[10px]"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-20 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4 text-slate-200 text-3xl">
                                <i class="fas fa-users-slash"></i>
                            </div>
                            <h4 class="text-slate-900 font-bold">No users found</h4>
                            <p class="text-slate-400 text-sm mt-1">Try adjusting your search criteria.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
    <div class="p-6 bg-slate-50 border-t border-slate-100">
        {{ $users->links() }}
    </div>
    @endif
</div>

@endsection

@push('scripts')
<style>
    /* Pagination Overrides for Tailwind */
    .pagination { @apply flex items-center gap-1; }
    .page-item .page-link { @apply w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-slate-200 text-slate-600 text-xs font-bold transition-all hover:border-indigo-600 hover:text-indigo-600; }
    .page-item.active .page-link { @apply bg-indigo-600 border-indigo-600 text-white shadow-lg shadow-indigo-100; }
</style>
@endpush
