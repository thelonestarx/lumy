
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMONAT - Device</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- FontAwesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Alpine.js -->
    <script defer
        src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body
    x-data="{ sidebarOpen: window.innerWidth >= 768 }"
    class="min-h-screen overflow-x-hidden bg-slate-100 font-sans antialiased">

    <!-- Overlay Sidebar untuk HP -->
    <div
        x-show="sidebarOpen"
        x-transition.opacity
        @click="sidebarOpen = false"
        class="fixed inset-0 z-30 bg-black/40 md:hidden"
        style="display: none;">
    </div>

    <!-- Layout Utama -->
    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside
            :class="sidebarOpen
                ? 'fixed inset-y-0 left-0 z-40 w-64 p-4 translate-x-0 md:static md:p-6'
                : 'fixed inset-y-0 left-0 z-40 w-64 p-4 -translate-x-full md:static md:w-20 md:p-4 md:translate-x-0'"
            class="flex shrink-0 flex-col justify-between overflow-hidden
                   bg-blue-900 text-white
                   transition-all duration-300 ease-in-out">

            <div>

                <!-- Logo -->
                <div class="mb-10 flex items-center gap-3 overflow-hidden whitespace-nowrap">

                    <img
                        src="{{ asset('img/logo-putih.png') }}"
                        alt="Logo SIMONAT"
                        class="h-9 w-9 shrink-0 object-contain">

                    <h1
                        x-show="sidebarOpen"
                        x-transition.opacity
                        class="text-2xl font-bold tracking-wider">
                        SIMONAT
                    </h1>

                </div>

                <!-- Navigasi -->
                <nav class="space-y-2">

                    <!-- Dashboard -->
                    <a
                        href="{{ route('dashboard') }}"
                        @click="if (window.innerWidth < 768) sidebarOpen = false"
                        :class="sidebarOpen ? 'justify-start' : 'justify-center'"
                        class="flex items-center gap-3 rounded-xl p-3 font-medium transition-all
                        {{ request()->routeIs('dashboard')
                            ? 'bg-blue-800 text-white'
                            : 'text-blue-200 hover:bg-blue-800/60 hover:text-white' }}"
                        title="Dashboard">

                        <i class="fa-solid fa-house shrink-0 text-lg"></i>

                        <span
                            x-show="sidebarOpen"
                            x-transition.opacity
                            class="whitespace-nowrap">
                            Dashboard
                        </span>

                    </a>

                    <!-- Monitoring -->
                    <a
                        href="{{ route('monitoring') }}"
                        @click="if (window.innerWidth < 768) sidebarOpen = false"
                        :class="sidebarOpen ? 'justify-start' : 'justify-center'"
                        class="flex items-center gap-3 rounded-xl p-3 font-medium transition-all
                        {{ request()->routeIs('monitoring')
                            ? 'bg-blue-800 text-white'
                            : 'text-blue-200 hover:bg-blue-800/60 hover:text-white' }}"
                        title="Monitoring">

                        <i class="fa-solid fa-chart-line shrink-0 text-lg"></i>

                        <span
                            x-show="sidebarOpen"
                            x-transition.opacity
                            class="whitespace-nowrap">
                            Monitoring
                        </span>

                    </a>

                    <!-- Pakan -->
                    <a
                        href="{{ route('pakan') }}"
                        @click="if (window.innerWidth < 768) sidebarOpen = false"
                        :class="sidebarOpen ? 'justify-start' : 'justify-center'"
                        class="flex items-center gap-3 rounded-xl p-3 font-medium transition-all
                        {{ request()->routeIs('pakan')
                            ? 'bg-blue-800 text-white'
                            : 'text-blue-200 hover:bg-blue-800/60 hover:text-white' }}"
                        title="Pakan">

                        <i class="fa-solid fa-fish shrink-0 text-lg"></i>

                        <span
                            x-show="sidebarOpen"
                            x-transition.opacity
                            class="whitespace-nowrap">
                            Pakan
                        </span>

                    </a>

                    <!-- Device -->
                    <a
                        href="{{ route('device') }}"
                        @click="if (window.innerWidth < 768) sidebarOpen = false"
                        :class="sidebarOpen ? 'justify-start' : 'justify-center'"
                        class="flex items-center gap-3 rounded-xl p-3 font-medium transition-all
                        {{ request()->routeIs('device')
                            ? 'bg-blue-800 text-white'
                            : 'text-blue-200 hover:bg-blue-800/60 hover:text-white' }}"
                        title="Device">

                        <i class="fa-solid fa-hard-drive shrink-0 text-lg"></i>

                        <span
                            x-show="sidebarOpen"
                            x-transition.opacity
                            class="whitespace-nowrap">
                            Device
                        </span>

                    </a>

                </nav>
            </div>

        </aside>

        <!-- Konten Utama -->
        <main class="min-w-0 flex-1 p-4 sm:p-6 lg:p-8">

            <!-- Header -->
            <header class="mb-6 flex items-center justify-between gap-3">

                <!-- Tombol Sidebar -->
                <button
                    type="button"
                    @click="sidebarOpen = !sidebarOpen"
                    aria-label="Buka atau tutup menu navigasi"
                    class="shrink-0 rounded-lg p-2 text-2xl text-slate-600
                           transition hover:bg-slate-200 hover:text-blue-900
                           focus:outline-none focus:ring-2 focus:ring-blue-500">

                    <i class="fa-solid fa-bars"></i>

                </button>

                <!-- Profil -->
                <div x-data="{ open: false }" class="relative">

                    <button
                        type="button"
                        @click="open = !open"
                        :aria-expanded="open"
                        class="flex items-center gap-2 rounded-xl p-1
                               transition hover:bg-slate-200 sm:gap-3">

                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center
                                   rounded-full bg-blue-100 font-bold text-blue-900">

                            <i class="fa-solid fa-user"></i>

                        </div>

                        <div class="hidden text-left sm:block">

                            <p class="text-sm font-bold leading-tight text-slate-800">
                                Gemilang
                            </p>

                            <p class="text-xs text-slate-500">
                                Pembudidaya
                            </p>

                        </div>

                        <i class="fa-solid fa-chevron-down ml-1 text-xs text-slate-400"></i>

                    </button>

                    <!-- Dropdown Profil -->
                    <div
                        x-show="open"
                        @click.outside="open = false"
                        @keydown.escape.window="open = false"
                        x-transition
                        class="absolute right-0 z-50 mt-2 w-48 rounded-xl
                               border border-slate-100 bg-white py-2 shadow-lg"
                        style="display: none;">

                        <a
                            href="#"
                            class="flex items-center gap-2 px-4 py-2 text-sm
                                   text-slate-700 hover:bg-slate-50">

                            <i class="fa-regular fa-id-badge text-slate-400"></i>
                            Lihat Profil

                        </a>

                        <div class="my-1 border-t border-slate-100"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button
                                type="submit"
                                class="flex w-full items-center gap-2 px-4 py-2
                                       text-left text-sm font-medium text-red-600
                                       hover:bg-red-50">

                                <i class="fa-solid fa-right-from-bracket"></i>
                                Keluar / Logout

                            </button>

                        </form>

                    </div>

                </div>

            </header>

            <!-- Judul Halaman -->
            <section class="mb-6 text-center sm:mb-8">

                <h2 class="text-xl font-bold text-slate-800 sm:text-2xl">
                    Device
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Informasi perangkat SIMONAT yang terhubung.
                </p>

            </section>

            <!-- Daftar Device -->
            <section class="mx-auto grid w-full max-w-5xl
                            grid-cols-1 gap-4 sm:gap-6 lg:grid-cols-2">

                <!-- DEVICE 001 -->
                <article
                    class="min-w-0 rounded-2xl border border-slate-100
                           bg-white p-4 shadow-sm sm:p-6">

                    <!-- Header Device -->
                    <div
                        class="flex flex-wrap items-center justify-between
                               gap-3 border-b border-slate-100 pb-5">

                        <div class="flex min-w-0 items-center gap-3 sm:gap-4">

                            <div
                                class="flex h-11 w-11 shrink-0 items-center
                                       justify-center rounded-xl bg-blue-100
                                       text-blue-900">

                                <i class="fa-solid fa-microchip text-lg"></i>

                            </div>

                            <div class="min-w-0">

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
                            class="inline-flex shrink-0 items-center gap-1.5
                                   rounded-full border border-emerald-200
                                   bg-emerald-50 px-2.5 py-1
                                   text-xs font-semibold text-emerald-700">

                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                            Hidup

                        </span>

                    </div>

                    <!-- Informasi Device -->
                    <div class="mt-5 space-y-4">

                        <div>
                            <p class="mb-1 text-xs font-semibold text-slate-500">
                                ID DEVICE
                            </p>

                            <p class="break-words font-bold text-slate-800">
                                SIMONAT-001
                            </p>
                        </div>

                        <div>
                            <p class="mb-1 text-xs font-semibold text-slate-500">
                                NAMA DEVICE
                            </p>

                            <p class="font-bold text-slate-800">
                                SIMONAT
                            </p>
                        </div>

                        <div>
                            <p class="mb-1 text-xs font-semibold text-slate-500">
                                LOKASI
                            </p>

                            <p class="flex items-start gap-2 font-bold text-slate-800">

                                <i class="fa-solid fa-location-dot mt-1 shrink-0 text-blue-900"></i>

                                <span>Kolam ATP IPB</span>

                            </p>
                        </div>

                    </div>

                    <!-- Status Perangkat -->
                    <div
                        class="mt-5 flex items-center gap-3 rounded-xl
                               border border-emerald-200 bg-emerald-50 p-3.5">

                        <div
                            class="flex h-8 w-8 shrink-0 items-center justify-center
                                   rounded-lg bg-emerald-100 text-emerald-700">

                            <i class="fa-solid fa-power-off text-sm"></i>

                        </div>

                        <div class="min-w-0">

                            <p class="text-xs text-slate-500">
                                Status Perangkat
                            </p>

                            <p class="text-sm font-bold text-emerald-700">
                                Perangkat Hidup
                            </p>

                        </div>

                    </div>

                </article>

                <!-- DEVICE 002 -->
                <article
                    class="min-w-0 rounded-2xl border border-slate-100
                           bg-white p-4 shadow-sm sm:p-6">

                    <!-- Header Device -->
                    <div
                        class="flex flex-wrap items-center justify-between
                               gap-3 border-b border-slate-100 pb-5">

                        <div class="flex min-w-0 items-center gap-3 sm:gap-4">

                            <div
                                class="flex h-11 w-11 shrink-0 items-center
                                       justify-center rounded-xl bg-blue-100
                                       text-blue-900">

                                <i class="fa-solid fa-microchip text-lg"></i>

                            </div>

                            <div class="min-w-0">

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
                            class="inline-flex shrink-0 items-center gap-1.5
                                   rounded-full border border-rose-200
                                   bg-rose-50 px-2.5 py-1
                                   text-xs font-semibold text-rose-700">

                            <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>
                            Mati

                        </span>

                    </div>

                    <!-- Informasi Device -->
                    <div class="mt-5 space-y-4">

                        <div>
                            <p class="mb-1 text-xs font-semibold text-slate-500">
                                ID DEVICE
                            </p>

                            <p class="break-words font-bold text-slate-800">
                                SIMONAT-002
                            </p>
                        </div>

                        <div>
                            <p class="mb-1 text-xs font-semibold text-slate-500">
                                NAMA DEVICE
                            </p>

                            <p class="font-bold text-slate-800">
                                SIMONAT
                            </p>
                        </div>

                        <div>
                            <p class="mb-1 text-xs font-semibold text-slate-500">
                                LOKASI
                            </p>

                            <p class="flex items-start gap-2 font-bold text-slate-800">

                                <i class="fa-solid fa-location-dot mt-1 shrink-0 text-blue-900"></i>

                                <span>Kolam ATP IPB</span>

                            </p>
                        </div>

                    </div>

                    <!-- Status Perangkat -->
                    <div
                        class="mt-5 flex items-center gap-3 rounded-xl
                               border border-rose-200 bg-rose-50 p-3.5">

                        <div
                            class="flex h-8 w-8 shrink-0 items-center justify-center
                                   rounded-lg bg-rose-100 text-rose-700">

                            <i class="fa-solid fa-power-off text-sm"></i>

                        </div>

                        <div class="min-w-0">

                            <p class="text-xs text-slate-500">
                                Status Perangkat
                            </p>

                            <p class="text-sm font-bold text-rose-700">
                                Perangkat Mati
                            </p>

                        </div>

                    </div>

                </article>

            </section>

        </main>

    </div>

</body>

</html>
