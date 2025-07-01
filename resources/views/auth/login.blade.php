<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Kajian</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-b from-green-100 to-green-400 min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
        <h1 class="text-2xl font-bold text-center text-green-700 mb-2">Masuk ke Sistem Kajian</h1>
        <p class="text-sm text-gray-500 text-center mb-6 italic">
            “Barangsiapa keluar untuk menuntut ilmu, maka ia berada di jalan Allah...” <br><span class="text-xs">(HR. Tirmidzi)</span>
        </p>

        @if(session('status'))
            <div class="mb-4 text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 text-sm text-red-600">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" type="email" name="email" required autofocus
                    class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-green-500 focus:border-green-500">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" type="password" name="password" required
                    class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-green-500 focus:border-green-500">
            </div>

            <div class="flex items-center justify-between mb-4">
                <label class="flex items-center text-sm text-gray-600">
                    <input type="checkbox" name="remember" class="mr-2 rounded border-gray-300 text-green-600 shadow-sm">
                    Ingat saya
                </label>
                <a href="{{ route('password.request') }}" class="text-sm text-green-700 hover:underline">
                    Lupa Password?
                </a>
            </div>

            <button type="submit"
                class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
                Masuk
            </button>
        </form>
    </div>

</body>
</html>
