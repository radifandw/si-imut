<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Si-IMUT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="min-h-screen flex">

    {{-- Kiri: Foto + Branding --}}
    <div class="hidden lg:flex lg:w-3/5 relative flex-col justify-between p-10"
         style="background: url('/images/pantai.jpg') center/cover no-repeat;">

        {{-- Overlay gelap --}}
        <div class="absolute inset-0 bg-black/40"></div>

        {{-- Konten atas: Nama sistem --}}
        <div class="relative z-10">
            <div class="flex items-center gap-3 mb-2">
                <img src="/images/logo-bkpsdm.png" alt="BKPSDM" class="h-14 w-14 object-contain">
                <div>
                    <h1 class="text-white text-2xl font-bold tracking-wide">Si-IMUT</h1>
                    <p class="text-white/80 text-xs">Situbondo Integrated Mutasi</p>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-white font-semibold text-lg leading-snug">Badan Kepegawaian dan Pengembangan<br>Sumber Daya Manusia</p>
                <p class="text-white/80 text-sm">Kabupaten Situbondo</p>
            </div>
        </div>

        {{-- Konten bawah: Tagline + Logo --}}
        <div class="relative z-10">
            <p class="text-white/60 text-xs mb-4 italic">"Mewujudkan Tata Kelola ASN Situbondo Naik Kelas"</p>
            <div class="flex items-center gap-4">
                <img src="/images/logo-berakhlak.png" alt="BerAKHLAK" class="h-10 object-contain brightness-0 invert">
                <img src="/images/logo-naikkelas.png" alt="Naik Kelas" class="h-10 object-contain">
            </div>
        </div>
    </div>

    {{-- Kanan: Form Login --}}
    <div class="w-full lg:w-2/5 flex items-center justify-center bg-gray-50 p-8">
        <div class="w-full max-w-sm">
            <div class="text-center mb-8">
                <p class="text-gray-500 text-sm font-medium uppercase tracking-widest">MASUK</p>
                <p class="text-gray-400 text-xs mt-1">Masukkan Data Akun Anda</p>
            </div>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded-lg mb-5">
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                @csrf
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="fas fa-user text-sm"></i></span>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 bg-white"
                           placeholder="Email">
                </div>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="fas fa-lock text-sm"></i></span>
                    <input type="password" name="password" required
                           class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 bg-white"
                           placeholder="Password">
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="rounded border-gray-300 text-orange-500">
                    <label for="remember" class="ml-2 text-sm text-gray-500">Ingatkan saya</label>
                </div>
                <button type="submit"
                        class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 rounded-lg transition text-sm tracking-wide uppercase">
                    Login
                </button>
            </form>

            {{-- Logo bawah --}}
            <div class="mt-10 flex items-center justify-center gap-4 lg:hidden">
                <img src="/images/logo-berakhlak.png" alt="BerAKHLAK" class="h-8 object-contain">
                <img src="/images/logo-naikkelas.png" alt="Naik Kelas" class="h-8 object-contain">
            </div>

            <p class="text-center text-gray-300 text-xs mt-8">© {{ date('Y') }} Si-IMUT — BKPSDM Kabupaten Situbondo</p>
        </div>
    </div>

</body>
</html> 