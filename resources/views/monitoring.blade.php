<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMONAT - Real-time Monitoring</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Chart.js untuk Grafik Interaktif -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>

<body x-data="{ sidebarOpen: window.innerWidth >= 768 }"
    class="bg-slate-100 h-screen flex font-sans antialiased overflow-x-hidden">

    <!-- Backdrop gelap untuk sidebar di HP (klik untuk menutup) -->
    <div x-show="sidebarOpen"
        @click="sidebarOpen = false"
        x-transition.opacity
        class="fixed inset-0 z-30 bg-slate-900/50 md:hidden"
        x-cloak></div>

    <!-- Sidebar Kiri: overlay di HP, menempel di kiri pada laptop -->
    <aside
        :class="sidebarOpen
            ? 'translate-x-0 w-64 p-6'
            : '-translate-x-full w-64 p-6 md:translate-x-0 md:w-20 md:p-4'"
        class="fixed inset-y-0 left-0 z-40 md:static md:z-auto bg-blue-900 text-white flex flex-col justify-between transition-all duration-300 ease-in-out shrink-0 overflow-hidden overflow-y-auto">
        <div>

            <!-- Logo & Nama Aplikasi -->
            <div class="flex items-center gap-3 mb-10 overflow-hidden whitespace-nowrap">
                <img src="{{ asset('img/logo-putih.png') }}" alt="Logo SIMONAT" class="w-9 h-9 object-contain shrink-0">

                <h1 x-show="sidebarOpen" x-transition.opacity class="text-2xl font-bold tracking-wider">
                    SIMONAT
                </h1>
            </div>

            <!-- Navigasi Menu -->
            <nav class="space-y-2">

                <a href="{{ route('dashboard') }}"
                    :class="sidebarOpen ? 'justify-start' : 'justify-center'"
                    class="flex items-center gap-3 p-3 hover:bg-blue-800/60 rounded-xl font-medium text-blue-200 hover:text-white transition-all"
                    title="Dashboard">

                    <i class="fa-solid fa-house text-lg"></i>

                    <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap">
                        Dashboard
                    </span>
                </a>

                <a href="{{ route('monitoring') }}"
                    :class="sidebarOpen ? 'justify-start' : 'justify-center'"
                    class="flex items-center gap-3 bg-blue-800 text-white p-3 rounded-xl font-medium transition-all"
                    title="Monitoring">

                    <i class="fa-solid fa-chart-line text-lg"></i>

                    <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap">
                        Monitoring
                    </span>
                </a>

                <a href="{{ route('pakan') }}"
                    :class="sidebarOpen ? 'justify-start' : 'justify-center'"
                    class="flex items-center gap-3 p-3 rounded-xl font-medium transition-all {{ request()->routeIs('pakan') ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-800/60 hover:text-white' }}"
                    title="Pakan">

                    <i class="fa-solid fa-fish text-lg"></i>

                    <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap">
                        Pakan
                    </span>
                </a>

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
    <main class="flex-1 min-w-0 p-4 sm:p-6 lg:p-8 overflow-y-auto">

        <!-- Header -->
        <header class="flex justify-between items-center gap-3 mb-6">

            <button @click="sidebarOpen = !sidebarOpen"
                class="text-2xl text-slate-600 hover:text-blue-900 focus:outline-none transition">
                <i class="fa-solid fa-bars"></i>
            </button>

            <!-- Profile Dropdown -->
            <div x-data="{ open: false }" class="relative">

                <button @click="open = !open"
                    class="flex items-center gap-3 focus:outline-none hover:opacity-80 transition">

                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-900 font-bold shrink-0">
                        <i class="fa-solid fa-user"></i>
                    </div>

                    <!-- Nama & peran disembunyikan di layar sangat kecil -->
                    <div class="text-left hidden sm:block">
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
                    x-cloak
                    class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 py-2 z-50">

                    <!-- Info profil muncul di dropdown khusus HP -->
                    <div class="sm:hidden px-4 py-2 border-b border-slate-100 mb-1">
                        <p class="font-bold text-sm text-slate-800">Gemilang</p>
                        <p class="text-xs text-slate-500">Pembudidaya</p>
                    </div>

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


        <!-- Title Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">

            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-slate-800">
                    Monitoring Kualitas Air (Real-Time)
                </h2>

                <p class="text-slate-500 text-sm sm:text-base mt-1">
                    Pantau kondisi grafik parametrik air kolam budidaya secara berkala.
                </p>
            </div>

            <!-- Live Status Indicator -->
            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg text-xs font-semibold w-fit">

                <span class="relative flex h-2.5 w-2.5 shrink-0">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                </span>

                Sensor Terhubung (ESP32 Live)
            </div>

        </div>


        <!-- Card Parameter Air -->
        <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-slate-100 mb-4 sm:mb-6">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 sm:gap-3 mb-4">

                <div>
                    <h3 class="font-bold text-slate-800 text-base sm:text-lg">
                        Kondisi Air Kolam
                    </h3>

                    <p class="text-xs text-slate-500 mt-1">
                        Data parameter air yang terbaca oleh sensor secara real-time.
                    </p>
                </div>

                <span class="text-xs text-slate-400 shrink-0">
                    Update terakhir: 13:00 WIB
                </span>

            </div>


            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <!-- Card 1: Suhu -->
                <div class="bg-slate-50/80 border border-slate-200/60 rounded-xl p-4 flex flex-col justify-between hover:border-blue-200 hover:shadow-sm transition">

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
                            29.4
                            <span class="text-lg font-semibold text-slate-500">
                                °C
                            </span>
                        </p>

                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200/60 text-xs font-medium">

                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                            Normal
                        </div>

                    </div>

                </div>


                <!-- Card 2: pH -->
                <div class="bg-slate-50/80 border border-slate-200/60 rounded-xl p-4 flex flex-col justify-between hover:border-blue-200 hover:shadow-sm transition">

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
                <div class="bg-slate-50/80 border border-slate-200/60 rounded-xl p-4 flex flex-col justify-between hover:border-blue-200 hover:shadow-sm transition">

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
                            29
                            <span class="text-lg font-semibold text-slate-500">
                                NTU
                            </span>
                        </p>

                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-rose-50 text-rose-700 border border-rose-200/60 text-xs font-medium">

                            <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>

                            Darurat
                        </div>

                    </div>

                </div>

            </div>
        </div>


        <!-- Section Grafik Utama -->
        <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-slate-100 mb-4 sm:mb-6">

            <div class="flex flex-col xl:flex-row xl:justify-between xl:items-center mb-6 gap-4">

                <div>
                    <h3 class="font-bold text-slate-800 text-base sm:text-lg">
                        Grafik Tren Parameter Air
                    </h3>

                    <p class="text-xs text-slate-500 mt-1">
                        Perubahan nilai parameter air berdasarkan waktu.
                    </p>
                </div>


                <!-- Filter Parameter & Filter Waktu -->
                <div class="flex flex-col sm:flex-row sm:items-center gap-3 w-full xl:w-auto">

                    <select class="w-full sm:w-auto border border-slate-200 rounded-lg text-sm px-3 py-1.5 text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500/20">

                        <option>Semua Parameter</option>
                        <option>Suhu (°C)</option>
                        <option>pH Air</option>
                        <option>Kekeruhan (NTU)</option>

                    </select>


                    <div class="flex w-full sm:w-auto bg-slate-100 p-1 rounded-lg text-xs font-semibold text-slate-600">

                        <button class="flex-1 sm:flex-none px-3 py-1 rounded-md bg-white shadow-sm text-blue-900 whitespace-nowrap">
                            1 Hari
                        </button>

                        <button class="flex-1 sm:flex-none px-3 py-1 rounded-md hover:text-slate-900 whitespace-nowrap">
                            1 Minggu
                        </button>

                        <button class="flex-1 sm:flex-none px-3 py-1 rounded-md hover:text-slate-900 whitespace-nowrap">
                            1 Bulan
                        </button>

                    </div>

                </div>
            </div>


            <!-- Canvas Grafik -->
            <div class="h-64 sm:h-80 w-full relative">
                <canvas id="monitoringChart"></canvas>
            </div>

        </div>


        <!-- Tabel Riwayat Data Log Sensor -->
        <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-slate-100">

            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-4">

                <div>
                    <h3 class="font-bold text-slate-800 text-base sm:text-lg">
                        Riwayat Pembacaan Sensor
                    </h3>

                    <p class="text-xs text-slate-500 mt-1">
                        Data hasil pembacaan sensor yang tersimpan.
                    </p>
                </div>

                <button class="text-xs font-semibold text-blue-900 hover:underline flex items-center gap-1 w-fit">
                    <i class="fa-solid fa-download"></i>
                    Unduh Data Log
                </button>

            </div>


            <!-- Tabel bisa digeser horizontal di HP -->
            <div class="overflow-x-auto">

                <table class="w-full text-left text-sm text-slate-600 min-w-[600px]">

                    <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-semibold border-b border-slate-100">

                        <tr>

                            <th class="py-3 px-4">
                                Waktu
                            </th>

                            <th class="py-3 px-4">
                                Suhu (°C)
                            </th>

                            <th class="py-3 px-4">
                                Tingkat pH
                            </th>

                            <th class="py-3 px-4">
                                Kekeruhan (NTU)
                            </th>

                            <th class="py-3 px-4">
                                Status
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @foreach($historyLogs as $log)

                        <tr class="hover:bg-slate-50/80 transition">

                            <td class="py-3 px-4 font-medium text-slate-800 whitespace-nowrap">
                                {{ $log['time'] }}
                            </td>

                            <td class="py-3 px-4 whitespace-nowrap">
                                {{ $log['suhu'] }} °C
                            </td>

                            <td class="py-3 px-4">
                                {{ $log['ph'] }}
                            </td>

                            <td class="py-3 px-4 whitespace-nowrap">
                                {{ $log['turbidity'] }} NTU
                            </td>

                            <td class="py-3 px-4">

                                @if($log['status'] == 'Normal')

                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                    Normal
                                </span>

                                @elseif($log['status'] == 'Waspada')

                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-600 border border-amber-200">
                                    Waspada
                                </span>

                                @else

                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-600 border border-rose-200">
                                    Darurat
                                </span>

                                @endif

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </main>


    <!-- Script Chart.js untuk Menggambar Grafik -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const ctx = document.getElementById('monitoringChart').getContext('2d');

            new Chart(ctx, {

                type: 'line',

                data: {

                    labels: ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00'],

                    datasets: [

                        {
                            label: 'Suhu (°C)',
                            data: [27.5, 28.0, 28.5, 29.0, 29.8, 29.4],
                            borderColor: '#3b82f6', // Blue
                            backgroundColor: 'rgba(59, 130, 246, 0.05)',
                            tension: 0.4,
                            fill: true
                        },

                        {
                            label: 'pH Air',
                            data: [7.0, 7.1, 7.1, 7.2, 7.5, 7.4],
                            borderColor: '#f59e0b', // Amber
                            backgroundColor: 'transparent',
                            tension: 0.4
                        },

                        {
                            label: 'Kekeruhan (NTU)',
                            data: [10, 11, 12, 15, 22, 29],
                            borderColor: '#f43f5e', // Rose
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