
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMONAT - Device</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- FontAwesome Icons -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Alpine.js -->
    <script defer
        src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body x-data="{ sidebarOpen: true }"
    class="bg-slate-100 flex h-screen font-sans antialiased">

    <!-- Sidebar Kiri -->
    <aside
        :class="sidebarOpen ? 'w-64 p-6' : 'w-20 p-4'"
        class="bg-blue-900 text-white flex flex-col justify-between transition-all duration-300 ease-in-out shrink-0">

        <div>

            <!-- Logo & Nama Aplikasi -->
            <div class="flex items-center gap-3 mb-10 overflow-hidden whitespace-nowrap">

                <img src="{{ asset('img/logo-putih.png') }}"
                    alt="Logo SIMONAT"
                    class="w-9 h-9 object-contain">

                <h1 x-show="sidebarOpen"
                    x-transition.opacity
                    class="text-2xl font-bold tracking-wider">
                    SIMONAT
                </h1>

            </div>


            <!-- Navigasi Menu Sidebar -->
            <nav class="space-y-2">

                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}"
                    :class="sidebarOpen ? 'justify-start' : 'justify-center'"
                    class="flex items-center gap-3 p-3 rounded-xl font-medium transition-all
                    {{ request()->routeIs('dashboard')
                        ? 'bg-blue-800 text-white'
                        : 'text-blue-200 hover:bg-blue-800/60 hover:text-white' }}"
                    title="Dashboard">

                    <i class="fa-solid fa-house text-lg"></i>

                    <span x-show="sidebarOpen"
                        x-transition.opacity
                        class="whitespace-nowrap">
                        Dashboard
                    </span>

                </a>


                <!-- Monitoring -->
                <a href="{{ route('monitoring') }}"
                    :class="sidebarOpen ? 'justify-start' : 'justify-center'"
                    class="flex items-center gap-3 p-3 rounded-xl font-medium transition-all
                    {{ request()->routeIs('monitoring')
                        ? 'bg-blue-800 text-white'
                        : 'text-blue-200 hover:bg-blue-800/60 hover:text-white' }}"
                    title="Monitoring">

                    <i class="fa-solid fa-chart-line text-lg"></i>

                    <span x-show="sidebarOpen"
                        x-transition.opacity
                        class="whitespace-nowrap">
                        Monitoring
                    </span>

                </a>


                <!-- Pakan -->
                <a href="{{ route('pakan') }}"
                    :class="sidebarOpen ? 'justify-start' : 'justify-center'"
                    class="flex items-center gap-3 p-3 rounded-xl font-medium transition-all
                    {{ request()->routeIs('pakan')
                        ? 'bg-blue-800 text-white'
                        : 'text-blue-200 hover:bg-blue-800/60 hover:text-white' }}"
                    title="Pakan">

                    <i class="fa-solid fa-fish text-lg"></i>

                    <span x-show="sidebarOpen"
                        x-transition.opacity
                        class="whitespace-nowrap">
                        Pakan
                    </span>

                </a>


                <!-- Device -->
                <a href="{{ route('device') }}"
                    :class="sidebarOpen ? 'justify-start' : 'justify-center'"
                    class="flex items-center gap-3 p-3 rounded-xl font-medium transition-all
                    {{ request()->routeIs('device')
                        ? 'bg-blue-800 text-white'
                        : 'text-blue-200 hover:bg-blue-800/60 hover:text-white' }}"
                    title="Device">

                    <i class="fa-solid fa-hard-drive text-lg"></i>

                    <span x-show="sidebarOpen"
                        x-transition.opacity
                        class="whitespace-nowrap">
                        Device
                    </span>

                </a>

            </nav>

        </div>

    </aside>


    <!-- Konten Utama -->
    <main class="flex-1 p-8 overflow-y-auto">

        <!-- Header -->
        <header class="flex justify-between items-center mb-6">

            <!-- Tombol Sidebar -->
            <button
                @click="sidebarOpen = !sidebarOpen"
                class="text-2xl text-slate-600 hover:text-blue-900 focus:outline-none transition">

                <i class="fa-solid fa-bars"></i>

            </button>


            <!-- Profile -->
            <div x-data="{ open: false }" class="relative">

                <button
                    @click="open = !open"
                    class="flex items-center gap-3 focus:outline-none hover:opacity-80 transition">

                    <div
                        class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-900 font-bold">

                        <i class="fa-solid fa-user"></i>

                    </div>


                    <div class="text-left">

                        <p class="font-bold text-sm leading-tight text-slate-800">
                            Gemilang
                        </p>

                        <p class="text-xs text-slate-500">
                            Pembudidaya
                        </p>

                    </div>


                    <i class="fa-solid fa-chevron-down text-xs text-slate-400 ml-1"></i>

                </button>


                <!-- Dropdown Profile -->
                <div
                    x-show="open"
                    @click.outside="open = false"
                    x-transition
                    class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 py-2 z-50">

                    <a href="#"
                        class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">

                        <i class="fa-regular fa-id-badge text-slate-400"></i>
                        Lihat Profil

                    </a>


                    <div class="border-t border-slate-100 my-1"></div>


                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit"
                            class="w-full text-left flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium">

                            <i class="fa-solid fa-right-from-bracket"></i>
                            Keluar / Logout

                        </button>

                    </form>

                </div>

            </div>

        </header>


        <!-- Judul Halaman -->
        <div class="mb-8 text-center">

            <h2 class="text-2xl font-bold text-slate-800">
                Device
            </h2>

            <p class="text-slate-500 text-sm mt-1">
                Informasi perangkat SIMONAT yang terhubung.
            </p>

        </div>


        <!-- Device Cards -->
        <div class="flex justify-center">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full max-w-4xl">


                <!-- ========================= -->
                <!-- DEVICE 1 -->
                <!-- ========================= -->
                <div
                    class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">

                    <!-- Header Device -->
                    <div class="flex items-center justify-between pb-5 border-b border-slate-100">

                        <div class="flex items-center gap-4">

                            <div
                                class="w-11 h-11 rounded-xl bg-blue-100 text-blue-900 flex items-center justify-center">

                                <i class="fa-solid fa-microchip text-lg"></i>

                            </div>


                            <div>

                                <h3 class="font-bold text-slate-800">
                                    SIMONAT
                                </h3>

                                <p class="text-xs text-slate-500">
                                    Device 001
                                </p>

                            </div>

                        </div>


                        <!-- Status Hidup -->
                        <span
                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full
                            bg-emerald-50 text-emerald-700 border border-emerald-200
                            text-xs font-semibold">

                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>

                            Hidup

                        </span>

                    </div>


                    <!-- Informasi -->
                    <div class="space-y-4 mt-5">

                        <!-- ID Device -->
                        <div>

                            <p class="text-xs font-semibold text-slate-500 mb-1">
                                ID DEVICE
                            </p>

                            <p class="font-bold text-slate-800">
                                SIMONAT-001
                            </p>

                        </div>


                        <!-- Nama Device -->
                        <div>

                            <p class="text-xs font-semibold text-slate-500 mb-1">
                                NAMA DEVICE
                            </p>

                            <p class="font-bold text-slate-800">
                                SIMONAT
                            </p>

                        </div>


                        <!-- Lokasi -->
                        <div>

                            <p class="text-xs font-semibold text-slate-500 mb-1">
                                LOKASI
                            </p>

                            <p class="font-bold text-slate-800 flex items-center gap-2">

                                <i class="fa-solid fa-location-dot text-blue-900"></i>

                                Kolam ATP IPB

                            </p>

                        </div>

                    </div>


                    <!-- Status -->
                    <div
                        class="mt-5 p-3.5 bg-emerald-50 border border-emerald-200 rounded-xl
                        flex items-center gap-3">

                        <div
                            class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700
                            flex items-center justify-center">

                            <i class="fa-solid fa-power-off text-sm"></i>

                        </div>

                        <div>

                            <p class="text-xs text-slate-500">
                                Status Perangkat
                            </p>

                            <p class="text-sm font-bold text-emerald-700">
                                Perangkat Hidup
                            </p>

                        </div>

                    </div>

                </div>



                <!-- ========================= -->
                <!-- DEVICE 2 -->
                <!-- ========================= -->
                <div
                    class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">

                    <!-- Header Device -->
                    <div class="flex items-center justify-between pb-5 border-b border-slate-100">

                        <div class="flex items-center gap-4">

                            <div
                                class="w-11 h-11 rounded-xl bg-blue-100 text-blue-900 flex items-center justify-center">

                                <i class="fa-solid fa-microchip text-lg"></i>

                            </div>


                            <div>

                                <h3 class="font-bold text-slate-800">
                                    SIMONAT
                                </h3>

                                <p class="text-xs text-slate-500">
                                    Device 002
                                </p>

                            </div>

                        </div>


                        <!-- Status Mati -->
                        <span
                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full
                            bg-rose-50 text-rose-700 border border-rose-200
                            text-xs font-semibold">

                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>

                            Mati

                        </span>

                    </div>


                    <!-- Informasi -->
                    <div class="space-y-4 mt-5">

                        <!-- ID Device -->
                        <div>

                            <p class="text-xs font-semibold text-slate-500 mb-1">
                                ID DEVICE
                            </p>

                            <p class="font-bold text-slate-800">
                                SIMONAT-002
                            </p>

                        </div>


                        <!-- Nama Device -->
                        <div>

                            <p class="text-xs font-semibold text-slate-500 mb-1">
                                NAMA DEVICE
                            </p>

                            <p class="font-bold text-slate-800">
                                SIMONAT
                            </p>

                        </div>


                        <!-- Lokasi -->
                        <div>

                            <p class="text-xs font-semibold text-slate-500 mb-1">
                                LOKASI
                            </p>

                            <p class="font-bold text-slate-800 flex items-center gap-2">

                                <i class="fa-solid fa-location-dot text-blue-900"></i>

                                Kolam ATP IPB

                            </p>

                        </div>

                    </div>


                    <!-- Status -->
                    <div
                        class="mt-5 p-3.5 bg-rose-50 border border-rose-200 rounded-xl
                        flex items-center gap-3">

                        <div
                            class="w-8 h-8 rounded-lg bg-rose-100 text-rose-700
                            flex items-center justify-center">

                            <i class="fa-solid fa-power-off text-sm"></i>

                        </div>

                        <div>

                            <p class="text-xs text-slate-500">
                                Status Perangkat
                            </p>

                            <p class="text-sm font-bold text-rose-700">
                                Perangkat Mati
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </main>

</body>

</html>
