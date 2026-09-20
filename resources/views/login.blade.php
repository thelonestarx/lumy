<div>
    <!-- It is never too late to be what you might have been. - George Eliot -->
</div>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMONAT - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-slate-100 h-screen flex items-center justify-center p-4">

    <!-- Container Utama Split 2 Kolom -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden flex w-full max-w-4xl h-[500px]">

        <!-- Kolom Kiri: Gambar Akuarium -->
        <!-- Kolom Kiri: Gambar Akuarium -->
        <div class="w-1/2 relative hidden md:block">
            <img src="{{ asset('img/ikanwp.png') }}"
                alt="Aquarium"
                class="w-full h-full object-cover">
            <!-- Overlay tipis biar gambar makin soft -->
            <div class="absolute inset-0 bg-blue-900/10"></div>
        </div>

        <!-- Kolom Kanan: Form Login -->
        <div class="w-full md:w-1/2 p-8 flex flex-col justify-between items-center text-center">

            <div class="w-full my-auto max-w-xs">
                <!-- Logo SIMONAT -->
                <div class="flex flex-col items-center mb-8">
                    <!-- Gambar Logo dari public/img/ -->
                    <img src="{{ asset('img/logo-biru.png') }}"
                        alt="Logo SIMONAT"
                        class="w-16 h-16 object-contain mb-2">

                    <h1 class="text-2xl font-black text-blue-900 tracking-wider">SIMONAT</h1>
                </div>

                <!-- Form -->
                <form action="{{ route('dashboard') }}" method="GET" class="space-y-4 text-left">
                    <!-- Input Username -->
                    <div>
                        <label class="block text-xs font-bold text-blue-900 mb-1">Username</label>
                        <div class="flex items-center border-2 border-blue-900 rounded-md overflow-hidden bg-white">
                            <div class="bg-blue-900 text-white p-2.5 px-3">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <input type="text"
                                placeholder="masukan username anda"
                                class="w-full px-3 py-2 text-sm text-slate-700 focus:outline-none placeholder-slate-400">
                        </div>
                    </div>

                    <!-- Input Password -->
                    <div>
                        <label class="block text-xs font-bold text-blue-900 mb-1">Password</label>
                        <div class="flex items-center border-2 border-blue-900 rounded-md overflow-hidden bg-white">
                            <div class="bg-blue-900 text-white p-2.5 px-3">
                                <i class="fa-solid fa-lock"></i>
                            </div>
                            <input type="password"
                                placeholder="masukan password anda"
                                class="w-full px-3 py-2 text-sm text-slate-700 focus:outline-none placeholder-slate-400">
                        </div>
                    </div>

                    <!-- Tombol Login -->
                    <button type="submit"
                        class="w-full bg-blue-900 hover:bg-blue-950 text-white font-bold py-2.5 rounded-md shadow-md transition duration-200 text-sm tracking-wider uppercase mt-2">
                        LOGIN
                    </button>
                </form>
            </div>

            <!-- Footer Copyright -->
            <p class="text-[11px] text-slate-400">
                &copy; 2026 SIMONAT. All Right Reserved
            </p>
        </div>

    </div>

</body>

</html>