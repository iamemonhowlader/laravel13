@extends('backend.layouts.master')

@section('title', 'Mail Settings')
@section('page-title', 'SMTP Configuration')

@section('content')

<div class="max-w-4xl mx-auto">
    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-2xl flex items-center gap-3 animate-bounce">
        <i class="fas fa-check-circle"></i>
        <span class="text-sm font-bold">{{ session('success') }}</span>
    </div>
    @endif

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-50">
            <h3 class="text-xl font-bold text-slate-800">Email Server Settings</h3>
            <p class="text-slate-400 text-sm mt-1 font-medium">Update your SMTP credentials to enable email delivery.</p>
        </div>

        <form action="{{ route('admin.mail-settings.update') }}" method="POST" class="p-8 space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Mailer -->
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-500 uppercase tracking-widest">Mail Mailer</label>
                    <input type="text" name="MAIL_MAILER" value="{{ $settings['MAIL_MAILER'] }}" 
                        class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none font-medium">
                </div>

                <!-- Host -->
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-500 uppercase tracking-widest">Mail Host</label>
                    <input type="text" name="MAIL_HOST" value="{{ $settings['MAIL_HOST'] }}" 
                        class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none font-medium">
                </div>

                <!-- Port -->
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-500 uppercase tracking-widest">Mail Port</label>
                    <input type="text" name="MAIL_PORT" value="{{ $settings['MAIL_PORT'] }}" 
                        class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none font-medium">
                </div>

                <!-- Encryption -->
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-500 uppercase tracking-widest">Encryption (tls/ssl)</label>
                    <input type="text" name="MAIL_ENCRYPTION" value="{{ $settings['MAIL_ENCRYPTION'] }}" 
                        class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none font-medium">
                </div>

                <!-- Username -->
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-500 uppercase tracking-widest">Username</label>
                    <input type="text" name="MAIL_USERNAME" value="{{ $settings['MAIL_USERNAME'] }}" 
                        class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none font-medium">
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-500 uppercase tracking-widest">Password</label>
                    <input type="password" name="MAIL_PASSWORD" value="{{ $settings['MAIL_PASSWORD'] }}" 
                        class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none font-medium">
                </div>

                <!-- From Address -->
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-500 uppercase tracking-widest">From Email</label>
                    <input type="email" name="MAIL_FROM_ADDRESS" value="{{ $settings['MAIL_FROM_ADDRESS'] }}" 
                        class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none font-medium">
                </div>

                <!-- From Name -->
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-500 uppercase tracking-widest">From Name</label>
                    <input type="text" name="MAIL_FROM_NAME" value="{{ $settings['MAIL_FROM_NAME'] }}" 
                        class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none font-medium">
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 rounded-2xl shadow-xl shadow-indigo-100 transition-all flex items-center justify-center gap-2">
                    <i class="fas fa-save"></i>
                    Update Configuration
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
