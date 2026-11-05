@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <!-- Header with Glassmorphism Effect -->
    <div class="mb-6 sm:mb-8 bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl shadow-xl p-4 sm:p-6 text-white">
        <div class="flex items-center space-x-3 sm:space-x-4">
            <div class="p-2 sm:p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                <iconify-icon icon="mdi:cog" width="24" height="24" class="sm:w-8 sm:h-8"></iconify-icon>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold">Pengaturan Akun</h1>
                <p class="text-blue-100 text-xs sm:text-sm mt-0.5 sm:mt-1">Kelola informasi profil dan keamanan akun Anda</p>
            </div>
        </div>
    </div>

    <!-- Flash Notification Container - Fixed Top Right -->
    <div id="notification-container" class="fixed top-5 right-5 z-50 space-y-3 w-96 max-w-full pointer-events-none">
        @if(session('success'))
        <div class="notification success-notification pointer-events-auto transform transition-all duration-500 translate-x-0 opacity-100" role="alert">
            <div class="bg-gradient-to-r from-green-500/95 to-green-600/95 backdrop-blur-sm text-white p-4 rounded-xl shadow-2xl border border-green-400/30 flex items-start gap-3">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                        <iconify-icon icon="mdi:check-circle" width="20" height="20" class="text-white"></iconify-icon>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-white">Berhasil!</p>
                    <p class="text-sm text-white/90 mt-0.5">{{ session('success') }}</p>
                </div>
                <button onclick="dismissNotification(this)" class="flex-shrink-0 text-white/70 hover:text-white transition-colors">
                    <iconify-icon icon="mdi:close" width="18" height="18"></iconify-icon>
                </button>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="notification error-notification pointer-events-auto transform transition-all duration-500 translate-x-0 opacity-100" role="alert">
            <div class="bg-gradient-to-r from-red-500/95 to-red-600/95 backdrop-blur-sm text-white p-4 rounded-xl shadow-2xl border border-red-400/30 flex items-start gap-3">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                        <iconify-icon icon="mdi:alert-circle" width="20" height="20" class="text-white"></iconify-icon>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-white">Error!</p>
                    <p class="text-sm text-white/90 mt-0.5">{{ session('error') }}</p>
                </div>
                <button onclick="dismissNotification(this)" class="flex-shrink-0 text-white/70 hover:text-white transition-colors">
                    <iconify-icon icon="mdi:close" width="18" height="18"></iconify-icon>
                </button>
            </div>
        </div>
        @endif

        @if ($errors->any())
        <div class="notification error-notification pointer-events-auto transform transition-all duration-500 translate-x-0 opacity-100" role="alert">
            <div class="bg-gradient-to-r from-red-500/95 to-red-600/95 backdrop-blur-sm text-white p-4 rounded-xl shadow-2xl border border-red-400/30">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                            <iconify-icon icon="mdi:alert" width="20" height="20" class="text-white"></iconify-icon>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-white">Terdapat {{ $errors->count() }} kesalahan</p>
                        <p class="text-sm text-white/90 mt-1">Silakan periksa kembali form Anda</p>
                    </div>
                    <button onclick="dismissNotification(this)" class="flex-shrink-0 text-white/70 hover:text-white transition-colors">
                        <iconify-icon icon="mdi:close" width="18" height="18"></iconify-icon>
                    </button>
                </div>
                
                <!-- Detail errors (collapsible) -->
                <div class="mt-3 pt-3 border-t border-white/20">
                    <button onclick="toggleErrorDetails(this)" class="flex items-center gap-1 text-white/80 hover:text-white text-sm mb-2">
                        <iconify-icon icon="mdi:chevron-down" width="16" height="16" class="transform transition-transform"></iconify-icon>
                        <span>Lihat detail kesalahan</span>
                    </button>
                    <div class="error-details hidden space-y-1">
                        @foreach ($errors->all() as $error)
                        <div class="text-sm text-white/90 bg-red-500/20 p-2 rounded-lg flex items-start gap-2">
                            <iconify-icon icon="mdi:circle-small" width="16" height="16" class="flex-shrink-0 mt-0.5"></iconify-icon>
                            <span>{{ $error }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Hidden notifications template -->
    <div id="notification-template-success" class="hidden">
        <div class="bg-gradient-to-r from-green-500/95 to-green-600/95 backdrop-blur-sm text-white p-4 rounded-xl shadow-2xl border border-green-400/30 flex items-start gap-3">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                    <iconify-icon icon="mdi:check-circle" width="20" height="20" class="text-white"></iconify-icon>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-white">Berhasil!</p>
                <p class="text-sm text-white/90 mt-0.5 message-placeholder"></p>
            </div>
            <button onclick="dismissNotification(this)" class="flex-shrink-0 text-white/70 hover:text-white transition-colors">
                <iconify-icon icon="mdi:close" width="18" height="18"></iconify-icon>
            </button>
        </div>
    </div>

    <div id="notification-template-error" class="hidden">
        <div class="bg-gradient-to-r from-red-500/95 to-red-600/95 backdrop-blur-sm text-white p-4 rounded-xl shadow-2xl border border-red-400/30 flex items-start gap-3">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                    <iconify-icon icon="mdi:alert-circle" width="20" height="20" class="text-white"></iconify-icon>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-white">Error!</p>
                <p class="text-sm text-white/90 mt-0.5 message-placeholder"></p>
            </div>
            <button onclick="dismissNotification(this)" class="flex-shrink-0 text-white/70 hover:text-white transition-colors">
                <iconify-icon icon="mdi:close" width="18" height="18"></iconify-icon>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
        <!-- Profile Info Section (2 kolom di desktop) -->
        <div class="lg:col-span-2 space-y-4 sm:space-y-6">
            <!-- Informasi Profil Card -->
            <div class="bg-gradient-to-br from-slate-800/90 to-slate-900/90 rounded-2xl border border-slate-700/50 shadow-xl backdrop-blur-sm overflow-hidden hover:border-blue-500/50 transition-all duration-300">
                <div class="p-4 sm:p-6 border-b border-slate-700/50 bg-slate-900/30">
                    <div class="flex items-center gap-2">
                        <div class="p-2 bg-blue-500/10 rounded-lg">
                            <iconify-icon icon="mdi:account-circle" width="20" height="20" class="text-blue-400 sm:w-6 sm:h-6"></iconify-icon>
                        </div>
                        <h2 class="text-lg sm:text-xl font-bold text-white">Informasi Profil</h2>
                    </div>
                </div>
                
                <form action="{{ route('settings.update') }}" method="POST" class="p-4 sm:p-6 space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 gap-4">
                        <!-- Name Field -->
                        <div class="space-y-2" id="field-name">
                            <label class="block text-slate-300 text-sm font-medium flex items-center gap-1">
                                <iconify-icon icon="mdi:account" width="16" height="16"></iconify-icon>
                                Nama Akun <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                    class="w-full bg-slate-700 border border-slate-600 rounded-xl pl-4 pr-10 py-3 text-white placeholder-slate-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500">
                                    <iconify-icon icon="mdi:account" width="16" height="16"></iconify-icon>
                                </span>
                            </div>
                            @error('name') <p class="text-red-400 text-xs mt-1 flex items-center gap-1"><iconify-icon icon="mdi:alert-circle" width="12" height="12"></iconify-icon>{{ $message }}</p> @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="space-y-2" id="field-email">
                            <label class="block text-slate-300 text-sm font-medium flex items-center gap-1">
                                <iconify-icon icon="mdi:email" width="16" height="16"></iconify-icon>
                                Alamat Email <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                    class="w-full bg-slate-700 border border-slate-600 rounded-xl pl-4 pr-10 py-3 text-white placeholder-slate-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500">
                                    <iconify-icon icon="mdi:email" width="16" height="16"></iconify-icon>
                                </span>
                            </div>
                            @error('email') <p class="text-red-400 text-xs mt-1 flex items-center gap-1"><iconify-icon icon="mdi:alert-circle" width="12" height="12"></iconify-icon>{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="pt-4 flex flex-col sm:flex-row justify-end gap-3">
                        <button type="reset" class="order-2 sm:order-1 px-6 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-xl transition-all duration-300 text-sm font-medium">
                            Reset
                        </button>
                        <button type="submit" class="order-1 sm:order-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-2.5 rounded-xl font-semibold flex items-center justify-center gap-2 transition-all duration-300 shadow-lg shadow-blue-900/20 text-sm">
                            <iconify-icon icon="mdi:content-save" width="18" height="18"></iconify-icon>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Password & Keamanan Card -->
            <div class="bg-gradient-to-br from-slate-800/90 to-slate-900/90 rounded-2xl border border-slate-700/50 shadow-xl backdrop-blur-sm overflow-hidden hover:border-yellow-500/50 transition-all duration-300">
                <div class="p-4 sm:p-6 border-b border-slate-700/50 bg-slate-900/30">
                    <div class="flex items-center gap-2">
                        <div class="p-2 bg-yellow-500/10 rounded-lg">
                            <iconify-icon icon="mdi:lock" width="20" height="20" class="text-yellow-400 sm:w-6 sm:h-6"></iconify-icon>
                        </div>
                        <h2 class="text-lg sm:text-xl font-bold text-white">Keamanan & Password</h2>
                    </div>
                </div>
                
                <form action="{{ route('settings.update') }}" method="POST" class="p-4 sm:p-6 space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <!-- Hidden fields to keep name/email if only updating password -->
                    <input type="hidden" name="name" value="{{ $user->name }}">
                    <input type="hidden" name="email" value="{{ $user->email }}">

                    <div class="space-y-4">
                        <!-- Current Password -->
                        <div class="space-y-2" id="field-current_password">
                            <label class="block text-slate-300 text-sm font-medium flex items-center gap-1">
                                <iconify-icon icon="mdi:lock-outline" width="16" height="16"></iconify-icon>
                                Password Saat Ini <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" name="current_password" id="current_password" placeholder="Masukkan password lama"
                                    class="w-full bg-slate-700 border border-slate-600 rounded-xl pl-4 pr-10 py-3 text-white placeholder-slate-400 focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition text-sm">
                                <button type="button" onclick="togglePassword('current_password', 'eye-current')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-white">
                                    <iconify-icon id="eye-current" icon="mdi:eye-outline" width="18" height="18"></iconify-icon>
                                </button>
                            </div>
                            @error('current_password') <p class="text-red-400 text-xs mt-1 flex items-center gap-1"><iconify-icon icon="mdi:alert-circle" width="12" height="12"></iconify-icon>{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- New Password -->
                            <div class="space-y-2" id="field-new_password">
                                <label class="block text-slate-300 text-sm font-medium flex items-center gap-1">
                                    <iconify-icon icon="mdi:lock-plus" width="16" height="16"></iconify-icon>
                                    Password Baru
                                </label>
                                <div class="relative">
                                    <input type="password" name="new_password" id="new_password" placeholder="Minimal 6 karakter"
                                        class="w-full bg-slate-700 border border-slate-600 rounded-xl pl-4 pr-10 py-3 text-white placeholder-slate-400 focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition text-sm">
                                    <button type="button" onclick="togglePassword('new_password', 'eye-new')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-white">
                                        <iconify-icon id="eye-new" icon="mdi:eye-outline" width="18" height="18"></iconify-icon>
                                    </button>
                                </div>
                                @error('new_password') <p class="text-red-400 text-xs mt-1 flex items-center gap-1"><iconify-icon icon="mdi:alert-circle" width="12" height="12"></iconify-icon>{{ $message }}</p> @enderror
                            </div>
                            
                            <!-- Confirm New Password -->
                            <div class="space-y-2" id="field-new_password_confirmation">
                                <label class="block text-slate-300 text-sm font-medium flex items-center gap-1">
                                    <iconify-icon icon="mdi:lock-check" width="16" height="16"></iconify-icon>
                                    Konfirmasi Password Baru
                                </label>
                                <div class="relative">
                                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" placeholder="Ulangi password baru"
                                        class="w-full bg-slate-700 border border-slate-600 rounded-xl pl-4 pr-10 py-3 text-white placeholder-slate-400 focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition text-sm">
                                    <button type="button" onclick="togglePassword('new_password_confirmation', 'eye-confirm')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-white">
                                        <iconify-icon id="eye-confirm" icon="mdi:eye-outline" width="18" height="18"></iconify-icon>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Password Strength Indicator -->
                        <div id="password-strength" class="hidden">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-xs text-slate-400">Kekuatan Password:</span>
                                <span id="strength-text" class="text-xs font-medium"></span>
                            </div>
                            <div class="flex gap-1 h-1">
                                <div id="strength-bar-1" class="flex-1 rounded-full bg-slate-600 transition-all"></div>
                                <div id="strength-bar-2" class="flex-1 rounded-full bg-slate-600 transition-all"></div>
                                <div id="strength-bar-3" class="flex-1 rounded-full bg-slate-600 transition-all"></div>
                            </div>
                        </div>

                        <!-- Password Tips -->
                        <div class="bg-blue-500/5 border border-blue-500/20 rounded-lg p-3 flex items-start gap-2">
                            <iconify-icon icon="mdi:lightbulb" width="16" height="16" class="text-blue-400 flex-shrink-0 mt-0.5"></iconify-icon>
                            <p class="text-slate-400 text-xs">
                                Gunakan minimal 6 karakter dengan kombinasi huruf besar, huruf kecil, angka, dan simbol untuk password yang kuat.
                            </p>
                        </div>
                    </div>

                    <div class="pt-4 flex flex-col sm:flex-row justify-end gap-3">
                        <button type="reset" class="order-2 sm:order-1 px-6 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-xl transition-all duration-300 text-sm font-medium">
                            Reset
                        </button>
                        <button type="submit" class="order-1 sm:order-2 bg-gradient-to-r from-yellow-600 to-yellow-700 hover:from-yellow-700 hover:to-yellow-800 text-white px-6 py-2.5 rounded-xl font-semibold flex items-center justify-center gap-2 transition-all duration-300 shadow-lg shadow-yellow-900/20 text-sm">
                            <iconify-icon icon="mdi:key-variant" width="18" height="18"></iconify-icon>
                            Update Password
                        </button>
                    </div>
                </form>
            </div>

            <!-- Aktivitas Terakhir (optional) -->
            <div class="bg-gradient-to-br from-slate-800/90 to-slate-900/90 rounded-2xl border border-slate-700/50 shadow-xl backdrop-blur-sm overflow-hidden hover:border-purple-500/50 transition-all duration-300">
                <div class="p-4 sm:p-6 border-b border-slate-700/50 bg-slate-900/30">
                    <div class="flex items-center gap-2">
                        <div class="p-2 bg-purple-500/10 rounded-lg">
                            <iconify-icon icon="mdi:history" width="20" height="20" class="text-purple-400 sm:w-6 sm:h-6"></iconify-icon>
                        </div>
                        <h2 class="text-lg sm:text-xl font-bold text-white">Aktivitas Terakhir</h2>
                    </div>
                </div>
                <div class="p-4 sm:p-6">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-green-500/10 rounded-lg">
                                    <iconify-icon icon="mdi:login" width="16" height="16" class="text-green-400"></iconify-icon>
                                </div>
                                <div>
                                    <p class="text-white text-sm">Login Terakhir</p>
                                    <p class="text-slate-400 text-xs">{{ $lastLogin ?? $user->updated_at->locale('id')->translatedFormat('d F Y H:i:s') }}</p>
                                </div>
                            </div>
                            <span class="text-xs bg-green-500/20 text-green-400 px-2 py-1 rounded-full">Online</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-blue-500/10 rounded-lg">
                                <iconify-icon icon="mdi:map-marker" width="16" height="16" class="text-blue-400"></iconify-icon>
                            </div>
                            <div>
                                <p class="text-white text-sm">IP Terakhir</p>
                                <p class="text-slate-400 text-xs">{{ $lastIp ?? request()->ip() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Info (1 kolom di desktop) -->
        <div class="space-y-4 sm:space-y-6">
            <!-- Status Akun Card -->
            <div class="bg-gradient-to-br from-blue-600/20 to-purple-600/20 rounded-2xl p-4 sm:p-6 border border-blue-500/20 shadow-xl backdrop-blur-sm hover:border-blue-500/40 transition-all duration-300">
                <div class="flex items-center gap-2 mb-4">
                    <div class="p-2 bg-blue-500/10 rounded-lg">
                        <iconify-icon icon="mdi:shield-account" width="20" height="20" class="text-blue-400"></iconify-icon>
                    </div>
                    <h3 class="text-lg font-bold text-white">Status Akun</h3>
                </div>
                
                <div class="space-y-4">
                    <!-- Role -->
                    <div class="flex items-center justify-between p-3 bg-slate-800/50 rounded-xl border border-slate-700/50">
                        <span class="text-slate-400 text-sm flex items-center gap-2">
                            <iconify-icon icon="mdi:badge-account" width="16" height="16"></iconify-icon>
                            Role
                        </span>
                        <span class="bg-blue-500/20 text-blue-400 text-xs font-bold px-3 py-1.5 rounded-full uppercase border border-blue-500/30">
                            {{ $user->role }}
                        </span>
                    </div>

                    <!-- Terdaftar Sejak -->
                    <div class="flex items-center justify-between p-3 bg-slate-800/50 rounded-xl border border-slate-700/50">
                        <span class="text-slate-400 text-sm flex items-center gap-2">
                            <iconify-icon icon="mdi:calendar" width="16" height="16"></iconify-icon>
                            Terdaftar Sejak
                        </span>
                        <span class="text-white text-sm">{{ $user->created_at->locale('id')->translatedFormat('d M Y') }}</span>
                    </div>

                    <!-- Email Terverifikasi -->
                    <div class="flex items-center justify-between p-3 bg-slate-800/50 rounded-xl border border-slate-700/50">
                        <span class="text-slate-400 text-sm flex items-center gap-2">
                            <iconify-icon icon="mdi:email-check" width="16" height="16"></iconify-icon>
                            Email Verifikasi
                        </span>
                        @if($user->email_verified_at)
                        <span class="flex items-center gap-1 text-green-400 text-sm">
                            <iconify-icon icon="mdi:check-circle" width="16" height="16"></iconify-icon>
                            Terverifikasi
                        </span>
                        @else
                        <span class="flex items-center gap-1 text-yellow-400 text-sm">
                            <iconify-icon icon="mdi:alert-circle" width="16" height="16"></iconify-icon>
                            Belum Verifikasi
                        </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="bg-gradient-to-br from-slate-800/90 to-slate-900/90 rounded-2xl p-4 sm:p-6 border border-slate-700/50 shadow-xl backdrop-blur-sm">
                <div class="flex items-center gap-2 mb-4">
                    <div class="p-2 bg-green-500/10 rounded-lg">
                        <iconify-icon icon="mdi:flash" width="20" height="20" class="text-green-400"></iconify-icon>
                    </div>
                    <h3 class="text-lg font-bold text-white">Aksi Cepat</h3>
                </div>
                
                <div class="space-y-2">
                    <a href="/logs" class="flex items-center gap-3 p-3 bg-slate-700/30 hover:bg-slate-700/50 rounded-xl transition-all duration-300 group">
                        <div class="p-2 bg-purple-500/10 rounded-lg group-hover:bg-purple-500/20 transition-colors">
                            <iconify-icon icon="mdi:history" width="18" height="18" class="text-purple-400"></iconify-icon>
                        </div>
                        <span class="text-white text-sm flex-1">Lihat Log Aktivitas</span>
                        <iconify-icon icon="mdi:chevron-right" width="18" height="18" class="text-slate-500 group-hover:text-white transition-colors"></iconify-icon>
                    </a>
                    
                    <a href="/biodata" class="flex items-center gap-3 p-3 bg-slate-700/30 hover:bg-slate-700/50 rounded-xl transition-all duration-300 group">
                        <div class="p-2 bg-blue-500/10 rounded-lg group-hover:bg-blue-500/20 transition-colors">
                            <iconify-icon icon="mdi:account-details" width="18" height="18" class="text-blue-400"></iconify-icon>
                        </div>
                        <span class="text-white text-sm flex-1">Lihat Biodata</span>
                        <iconify-icon icon="mdi:chevron-right" width="18" height="18" class="text-slate-500 group-hover:text-white transition-colors"></iconify-icon>
                    </a>
                    
                    <a href="/pembayaran" class="flex items-center gap-3 p-3 bg-slate-700/30 hover:bg-slate-700/50 rounded-xl transition-all duration-300 group">
                        <div class="p-2 bg-green-500/10 rounded-lg group-hover:bg-green-500/20 transition-colors">
                            <iconify-icon icon="mdi:cash" width="18" height="18" class="text-green-400"></iconify-icon>
                        </div>
                        <span class="text-white text-sm flex-1">Cek Tagihan</span>
                        <iconify-icon icon="mdi:chevron-right" width="18" height="18" class="text-slate-500 group-hover:text-white transition-colors"></iconify-icon>
                    </a>
                </div>
            </div>

            <!-- Security Tips Card -->
            <div class="bg-gradient-to-br from-yellow-600/10 to-orange-600/10 rounded-2xl p-4 sm:p-6 border border-yellow-500/20 shadow-xl backdrop-blur-sm">
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-yellow-500/10 rounded-lg">
                        <iconify-icon icon="mdi:shield-lock" width="20" height="20" class="text-yellow-400"></iconify-icon>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold text-sm mb-1">Tips Keamanan</h4>
                        <ul class="text-slate-400 text-xs space-y-1 list-disc list-inside">
                            <li>Ganti password secara berkala</li>
                            <li>Jangan gunakan password yang sama</li>
                            <li>Aktifkan verifikasi 2 langkah</li>
                            <li>Logout setelah selesai menggunakan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

<style>
    /* Notification Styles */
    .notification {
        transform: translateX(100%);
        opacity: 0;
        transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        position: relative;
        overflow: hidden;
    }

    .notification::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, rgba(255,255,255,0.5), rgba(255,255,255,0.8));
        animation: progress 5s linear forwards;
    }

    @keyframes progress {
        0% { width: 100%; }
        100% { width: 0%; }
    }

    .notification:hover::after {
        animation-play-state: paused;
    }

    .notification + .notification {
        margin-top: 0.75rem;
    }

    @media (max-width: 640px) {
        #notification-container {
            width: calc(100% - 2rem);
            right: 1rem;
            left: 1rem;
            top: 1rem;
        }
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-slideDown { animation: slideDown 0.3s ease-out; }

    /* Card hover effects */
    .bg-gradient-to-br {
        transition: all 0.3s ease;
    }

    .bg-gradient-to-br:hover {
        transform: translateY(-2px);
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #1f2937;
    }

    ::-webkit-scrollbar-thumb {
        background: #4b5563;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #6b7280;
    }

    /* Input focus styles */
    input:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
    }

    /* Password strength bar animations */
    #strength-bar-1, #strength-bar-2, #strength-bar-3 {
        transition: all 0.3s ease;
    }
</style>

<script>
    // Notification System
    document.addEventListener('DOMContentLoaded', function() {
        const notifications = document.querySelectorAll('.notification');
        notifications.forEach((notification, index) => {
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
                notification.style.opacity = '1';
            }, index * 100);
            
            setTimeout(() => {
                dismissNotification(notification.querySelector('button'));
            }, 5000 + (index * 100));
        });

        // Password strength checker
        const newPassword = document.getElementById('new_password');
        if (newPassword) {
            newPassword.addEventListener('input', checkPasswordStrength);
        }
    });

    // Function to dismiss notification
    function dismissNotification(button) {
        const notification = button.closest('.notification');
        if (notification) {
            notification.style.transform = 'translateX(100%)';
            notification.style.opacity = '0';
            setTimeout(() => {
                notification.remove();
            }, 500);
        }
    }

    // Function to show custom notification
    function showNotification(message, type = 'success') {
        const container = document.getElementById('notification-container');
        const template = document.getElementById(`notification-template-${type}`);
        
        if (template && container) {
            const notification = template.cloneNode(true);
            notification.id = '';
            notification.classList.remove('hidden');
            notification.classList.add('notification');
            
            const messageEl = notification.querySelector('.message-placeholder');
            if (messageEl) {
                messageEl.textContent = message;
            }
            
            container.appendChild(notification);
            
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
                notification.style.opacity = '1';
            }, 10);
            
            setTimeout(() => {
                dismissNotification(notification.querySelector('button'));
            }, 5000);
        }
    }

    // Function to toggle error details
    function toggleErrorDetails(button) {
        const details = button.closest('.bg-gradient-to-r').querySelector('.error-details');
        const icon = button.querySelector('iconify-icon');
        
        if (details) {
            if (details.classList.contains('hidden')) {
                details.classList.remove('hidden');
                icon.setAttribute('icon', 'mdi:chevron-up');
            } else {
                details.classList.add('hidden');
                icon.setAttribute('icon', 'mdi:chevron-down');
            }
        }
    }

    // Toggle password visibility
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.setAttribute('icon', 'mdi:eye-off-outline');
        } else {
            input.type = 'password';
            icon.setAttribute('icon', 'mdi:eye-outline');
        }
    }

    // Password strength checker
    function checkPasswordStrength() {
        const password = document.getElementById('new_password').value;
        const strengthContainer = document.getElementById('password-strength');
        const strengthText = document.getElementById('strength-text');
        const bar1 = document.getElementById('strength-bar-1');
        const bar2 = document.getElementById('strength-bar-2');
        const bar3 = document.getElementById('strength-bar-3');
        
        if (password.length === 0) {
            strengthContainer.classList.add('hidden');
            return;
        }
        
        strengthContainer.classList.remove('hidden');
        
        // Reset bars
        bar1.className = 'flex-1 rounded-full bg-slate-600';
        bar2.className = 'flex-1 rounded-full bg-slate-600';
        bar3.className = 'flex-1 rounded-full bg-slate-600';
        
        let strength = 0;
        
        // Check length
        if (password.length >= 6) strength += 1;
        if (password.length >= 8) strength += 1;
        
        // Check for uppercase
        if (/[A-Z]/.test(password)) strength += 1;
        
        // Check for lowercase
        if (/[a-z]/.test(password)) strength += 1;
        
        // Check for numbers
        if (/[0-9]/.test(password)) strength += 1;
        
        // Check for special characters
        if (/[^A-Za-z0-9]/.test(password)) strength += 1;
        
        // Determine strength level
        if (strength <= 2) {
            strengthText.textContent = 'Lemah';
            strengthText.className = 'text-xs font-medium text-red-400';
            bar1.className = 'flex-1 rounded-full bg-red-500';
            bar2.className = 'flex-1 rounded-full bg-slate-600';
            bar3.className = 'flex-1 rounded-full bg-slate-600';
        } else if (strength <= 4) {
            strengthText.textContent = 'Sedang';
            strengthText.className = 'text-xs font-medium text-yellow-400';
            bar1.className = 'flex-1 rounded-full bg-yellow-500';
            bar2.className = 'flex-1 rounded-full bg-yellow-500';
            bar3.className = 'flex-1 rounded-full bg-slate-600';
        } else {
            strengthText.textContent = 'Kuat';
            strengthText.className = 'text-xs font-medium text-green-400';
            bar1.className = 'flex-1 rounded-full bg-green-500';
            bar2.className = 'flex-1 rounded-full bg-green-500';
            bar3.className = 'flex-1 rounded-full bg-green-500';
        }
    }

    // Keyboard shortcut to dismiss all notifications (ESC key)
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const notifications = document.querySelectorAll('.notification');
            notifications.forEach(notification => {
                dismissNotification(notification.querySelector('button'));
            });
        }
    });

    // Confirm before reset
    document.querySelectorAll('button[type="reset"]').forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Apakah Anda yakin ingin mereset form?')) {
                e.preventDefault();
            }
        });
    });
</script>
@endsection