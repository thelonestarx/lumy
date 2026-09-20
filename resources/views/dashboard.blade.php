<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMONAT - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Chart.js Tambahan untuk merender grafik -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body x-data="{ sidebarOpen: true }" class="bg-slate-100 flex h-screen font-sans">

    <!-- Sidebar Kiri -->
    <aside :class="sidebarOpen ? 'w-64 p-6' : 'w-20 p-4'" class="bg-blue-900 text-white flex flex-col justify-between transition-all duration-300 ease-in-out shrink-0">
        <div>
            <!-- Logo & Nama Aplikasi -->
            <div class="flex items-center gap-3 mb-10 overflow-hidden whitespace-nowrap">
                <img src="{{ asset('img/logo-putih.png') }}" alt="Logo SIMONAT" class="w-9 h-9 object-contain">
                <h1 x-show="sidebarOpen" x-transition.opacity class="text-2xl font-bold tracking-wider">
                    SIMONAT
                </h1>
            </div>

            <!-- Navigasi Menu Sidebar -->
            <nav class="space-y-2">
                <!-- Menu Dashboard -->
                <a href="{{ route('dashboard') }}"
                    :class="sidebarOpen ? 'justify-start' : 'justify-center'"
                    class="flex items-center gap-3 p-3 rounded-xl font-medium transition-all {{ request()->routeIs('dashboard') ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-800/60 hover:text-white' }}"
                    title="Dashboard">
                    <i class="fa-solid fa-house text-lg"></i>
                    <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap">Dashboard</span>
                </a>

                <!-- Menu Monitoring -->
                <a href="{{ route('monitoring') }}"
                    :class="sidebarOpen ? 'justify-start' : 'justify-center'"
                    class="flex items-center gap-3 p-3 rounded-xl font-medium transition-all {{ request()->routeIs('monitoring') ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-800/60 hover:text-white' }}"
                    title="Monitoring">
                    <i class="fa-solid fa-chart-line text-lg"></i>
                    <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap">Monitoring</span>
                </a>

                <!-- Menu Pakan (PASTIKAN HREF ROUTE PAKAN DISINI) -->
                <a href="{{ route('pakan') }}"
                    :class="sidebarOpen ? 'justify-start' : 'justify-center'"
                    class="flex items-center gap-3 p-3 rounded-xl font-medium transition-all {{ request()->routeIs('pakan') ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-800/60 hover:text-white' }}"
                    title="Pakan">
                    <i class="fa-solid fa-fish text-lg"></i>
                    <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap">Pakan</span>
                </a>

                <!-- Menu Device -->
                <a href="{{ route('device') }}"
                    :class="sidebarOpen ? 'justify-start' : 'justify-center'"
                    class="flex items-center gap-3 p-3 hover:bg-blue-800/60 rounded-xl font-medium text-blue-200 hover:text-white transition-all"
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
            <button @click="sidebarOpen = !sidebarOpen" class="text-2xl text-slate-600 hover:text-blue-900 focus:outline-none transition">
                <i class="fa-solid fa-bars"></i>
            </button>

            <!-- Profile Dropdown -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center gap-3 focus:outline-none hover:opacity-80 transition">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-900 font-bold">
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

                <div x-show="open"
                    @click.outside="open = false"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 py-2 z-50">

                    <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                        <i class="fa-regular fa-id-badge text-slate-400"></i> Lihat Profil
                    </a>

                    <div class="border-t border-slate-100 my-1"></div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium">
                            <i class="fa-solid fa-right-from-bracket"></i> Keluar / Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Greeting -->
        <h2 class="text-2xl font-bold text-slate-800">
            Selamat Datang, Gemilang! 👋
        </h2>
        <p class="text-slate-500 mb-6">
            Berikut kondisi kolam Anda saat ini.
        </p>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            <!-- Kolom Kiri & Tengah: Status + Grafik -->
            <div class="xl:col-span-2 space-y-6">

                <!-- Status Parameter Air -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                    <h3 class="font-bold text-slate-800 text-lg mb-4">
                        Kondisi Air Kolam
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                        <!-- Card 1: Suhu -->
                        <div class="bg-slate-50/80 border border-slate-200/60 rounded-xl p-4 flex flex-col justify-between hover:border-blue-200 transition">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                    Suhu Air
                                </span>
                                <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-900 flex items-center justify-center">
                                    <i class="fa-solid fa-temperature-three-quarters text-sm"></i>
                                </div>
                            </div>
                            <div>
                                <p class="text-3xl font-extrabold text-slate-800 tracking-tight mb-2">
                                    29.4 <span class="text-lg font-semibold text-slate-500">°C</span>
                                </p>
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200/60 text-xs font-medium">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    Normal
                                </div>
                            </div>
                        </div>

                        <!-- Card 2: pH -->
                        <div class="bg-slate-50/80 border border-slate-200/60 rounded-xl p-4 flex flex-col justify-between hover:border-blue-200 transition">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                    Tingkat pH
                                </span>
                                <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-900 flex items-center justify-center">
                                    <i class="fa-solid fa-droplet text-sm"></i>
                                </div>
                            </div>
                            <div>
                                <p class="text-3xl font-extrabold text-slate-800 tracking-tight mb-2">
                                    7.4
                                </p>
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 border border-amber-200/60 text-xs font-medium">
                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                    Waspada
                                </div>
                            </div>
                        </div>

                        <!-- Card 3: Kekeruhan -->
                        <div class="bg-slate-50/80 border border-slate-200/60 rounded-xl p-4 flex flex-col justify-between hover:border-blue-200 transition">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                    Kekeruhan
                                </span>
                                <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-900 flex items-center justify-center">
                                    <i class="fa-solid fa-water text-sm"></i>
                                </div>
                            </div>
                            <div>
                                <p class="text-3xl font-extrabold text-slate-800 tracking-tight mb-2">
                                    29 <span class="text-lg font-semibold text-slate-500">NTU</span>
                                </p>
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-rose-50 text-rose-700 border border-rose-200/60 text-xs font-medium">
                                    <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>
                                    Darurat
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Grafik Air Kolam Dashboard -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-slate-800 text-lg">
                            Grafik Kondisi Air Kolam
                        </h3>
                        <select class="border border-slate-200 rounded-lg text-sm px-3 py-1.5 text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                            <option>Hari</option>
                            <option>Bulan</option>
                            <option>Tahun</option>
                        </select>
                    </div>

                    <!-- Tempat Menggambar Grafik (Menggantikan Area Grafik sebelumnya) -->
                    <div class="h-64 w-full">
                        <canvas id="dashboardChart"></canvas>
                    </div>
                </div>

            </div>

            <!-- Kolom Kanan: Notifikasi -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 h-fit">
                <h3 class="font-bold text-slate-800 text-lg mb-4 flex items-center gap-2">
                    <i class="fa-regular fa-bell text-blue-900"></i> Notifikasi Terbaru
                </h3>

                <div class="space-y-4 text-sm">
                    <div class="border-b border-slate-100 pb-3">
                        <p class="font-semibold text-rose-600">
                            Kekeruhan Tinggi
                        </p>
                        <p class="text-xs text-slate-600 mt-1">
                            Nilai NTU melebihi ambang batas normal.
                        </p>
                    </div>

                    <div class="border-b border-slate-100 pb-3">
                        <p class="font-semibold text-blue-600">
                            Rekomendasi Pakan
                        </p>
                        <p class="text-xs text-slate-600 mt-1">
                            Jadwal pemberian pakan jam 16:00.
                        </p>
                    </div>

                    <div class="border-b border-slate-100 pb-3">
                        <p class="font-semibold text-amber-600">
                            pH Tingkat Waspada
                        </p>
                        <p class="text-xs text-slate-600 mt-1">
                            Periksa kualitas sirkulasi air kolam.
                        </p>
                    </div>
                </div>
            </div>

        </div>

    </main>

    <!-- Script Chart.js -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('dashboardChart').getContext('2d');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00'],
                    datasets: [{
                            label: 'Suhu (°C)',
                            data: [27.5, 28.0, 28.5, 29.0, 29.8, 29.4],
                            borderColor: '#3b82f6', // Biru
                            backgroundColor: 'rgba(59, 130, 246, 0.08)',
                            tension: 0.4,
                            fill: true
                        },
                        {
                            label: 'pH Air',
                            data: [7.0, 7.1, 7.1, 7.2, 7.5, 7.4],
                            borderColor: '#f59e0b', // Amber/Kuning
                            backgroundColor: 'transparent',
                            tension: 0.4
                        },
                        {
                            label: 'Kekeruhan (NTU)',
                            data: [10, 11, 12, 15, 22, 29],
                            borderColor: '#f43f5e', // Merah
                            backgroundColor: 'transparent',
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                boxWidth: 8
                            }
                        }
                    },
                    scales: {
                        y: {
                            grid: {
                                color: '#f1f5f9'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>