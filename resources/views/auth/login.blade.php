<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Manajemen Kajian</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased min-h-screen flex items-center justify-center relative overflow-hidden bg-slate-900">

    <!-- Premium Background -->
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[50%] bg-emerald-500/30 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-20%] right-[-10%] w-[50%] h-[50%] bg-teal-500/30 rounded-full blur-[120px]"></div>
    </div>

    <!-- Login Container -->
    <div class="w-full max-w-md px-4 relative z-10">
        <div class="bg-white/10 backdrop-blur-xl border border-white/20 shadow-2xl rounded-3xl p-8 sm:p-10">
            
            <!-- Logo & Title -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-500 mb-4 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight">Kajian<span class="text-emerald-400">App</span></h1>
                <p class="text-slate-300 mt-2 text-sm">Masuk ke panel admin</p>
            </div>

            <!-- Quote -->
            <div class="mb-8 p-4 bg-white/5 rounded-xl border border-white/10 text-center">
                <p class="text-xs font-medium text-slate-300 italic">
                    “Barangsiapa keluar untuk menuntut ilmu, maka ia berada di jalan Allah...” <br>
                    <span class="text-emerald-400 font-bold mt-1 inline-block">(HR. Tirmidzi)</span>
                </p>
            </div>

            @if(session('status'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-500/20 border border-emerald-500/50 text-sm font-medium text-emerald-200 text-center">
                    {{ session('status') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-500/20 border border-red-500/50 text-sm text-red-200">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-300 mb-1.5">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                        <input id="email" type="email" name="email" required autofocus
                            class="block w-full pl-11 rounded-xl border border-white/20 bg-white/5 text-white placeholder-slate-400 focus:border-emerald-500 focus:ring-emerald-500 transition-colors py-3 shadow-inner">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-300 mb-1.5">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input id="password" type="password" name="password" required
                            class="block w-full pl-11 rounded-xl border border-white/20 bg-white/5 text-white placeholder-slate-400 focus:border-emerald-500 focus:ring-emerald-500 transition-colors py-3 shadow-inner">
                    </div>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <label class="flex items-center group cursor-pointer">
                        <div class="relative flex items-center justify-center w-5 h-5 rounded border border-white/30 bg-white/5 group-hover:border-emerald-400 transition-colors">
                            <input type="checkbox" name="remember" class="opacity-0 absolute inset-0 cursor-pointer w-full h-full peer">
                            <svg class="w-3 h-3 text-emerald-400 opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="ml-2 text-sm text-slate-300 group-hover:text-white transition-colors">Ingat saya</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm font-medium text-emerald-400 hover:text-emerald-300 hover:underline transition-colors">
                        Lupa Password?
                    </a>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full flex justify-center py-3.5 px-4 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 transform active:scale-95">
                        Masuk Sekarang
                    </button>
                </div>
            </form>
        </div>
        
        <p class="text-center text-slate-500 text-xs mt-8 font-medium">
            &copy; {{ date('Y') }} Sistem Manajemen Kajian.
        </p>
    </div>

</body>
</html>
