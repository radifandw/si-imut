<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — SI-IMUT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="min-h-screen bg-gradient-to-br from-orange-500 via-orange-600 to-orange-800 flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        {{-- Logo --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-2xl shadow-lg mb-4">
                <span class="text-orange-600 font-extrabold text-xl">SI</span>
            </div>
            <h1 class="text-white text-2xl font-bold">SI-IMUT</h1>
            <p class="text-orange-200 text-sm mt-1">Sistem Informasi Mutasi ASN</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <h2 class="text-gray-800 font-semibold text-lg mb-6">Masuk ke Sistem</h2>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded-lg mb-5">
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="fas fa-envelope text-sm"></i></span>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                               placeholder="email@instansi.go.id">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="fas fa-lock text-sm"></i></span>
                        <input type="password" name="password" required
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                               placeholder="••••••••">
                    </div>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="rounded border-gray-300 text-blue-600">
                    <label for="remember" class="ml-2 text-sm text-gray-600">Ingat saya</label>
                </div>
                <button type="submit"
                        class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2.5 rounded-lg transition text-sm shadow">
                    <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                </button>
            </form>

            {{-- Demo accounts --}}
            <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-100">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Akun Demo</p>
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-gray-600"><i class="fas fa-user-shield text-orange-500 mr-1"></i><strong>Admin:</strong></span>
                        <code class="bg-white border px-2 py-1 rounded text-gray-700">admin@siimut.id / admin123</code>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-gray-600"><i class="fas fa-user text-green-500 mr-1"></i><strong>User:</strong></span>
                        <code class="bg-white border px-2 py-1 rounded text-gray-700">user@siimut.id / user123</code>
                    </div>
                </div>
            </div>
        </div>

        <p class="text-center text-orange-200 text-xs mt-6">© {{ date('Y') }} SI-IMUT — Kabupaten</p>
    </div>
</body>
</html>
