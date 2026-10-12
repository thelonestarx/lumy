<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMONAT - Manajemen Penjadwalan Pakan</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body x-data="{ 
    sidebarOpen: true,
    // Form Parameter Ikan & Calculation Logic
    jumlahIkan: 500,
    jenisIkan: 'nila_hitam',
    fasePertumbuhan: 'pembesaran',
    beratRataRata: 150,
    frekuensiHari: 3,
    
    // Auto Calculate Feeding Rates (FR%)
    get feedingRate() {
        if (this.fasePertumbuhan === 'benih') return 0.05; // 5% biomassa
        if (this.fasePertumbuhan === 'pembesaran') return 0.03; // 3% biomassa
        return 0.02; // Panen 2% biomassa
    },
    
    get totalBiomassKg() {
        return ((this.jumlahIkan * this.beratRataRata) / 1000).toFixed(1);
    },

    get targetHarianGram() {
        return Math.round((this.jumlahIkan * (this.beratRataRata / 1000)) * this.feedingRate * 1000);
    },

    get targetPorsiGram() {
        return Math.round(this.targetHarianGram / (this.frekuensiHari || 1));
    },

    // Stok Pakan & Feeder State
    stokPakanPersen: 78,
    stokPakanKg: 7.8,
    autoFeedingEnabled: true,
    isDispensing: false,

    // Notification toast
    showToast: false,
    toastMessage: '',

    // Master Jadwal Sesi (Format HH:mm)
    jadwalSesi: {
        1: '07:00',
        2: '12:00',
        3: '16:00',
        4: '20:00'
    },

    // Menghitung selisih jam laptop dengan jadwal web
    getHitungMundur(sesiNum) {
        const targetTimeStr = this.jadwalSesi[sesiNum];
        if (!targetTimeStr) return '';

        const now = new Date();
        const [hours, minutes] = targetTimeStr.split(':').map(Number);
        
        const target = new Date();
        target.setHours(hours, minutes, 0, 0);

        const diffMs = target - now;

        if (diffMs <= 0) {
            return 'Jadwal sudah lewat / sedang berlangsung';
        }

        const diffMinutes = Math.floor(diffMs / (1000 * 60));
        const jam = Math.floor(diffMinutes / 60);
        const menit = diffMinutes % 60;

        if (jam > 0) {
            return `${jam} jam ${menit} menit lagi`;
        }
        return `${menit} menit lagi`;
    },

    // Method untuk memicu Toast Status Sesi
    tampilkanStatusJadwal(sesiNum) {
        const sisaWaktu = this.getHitungMundur(sesiNum);
        this.toastMessage = `Sesi ${sesiNum} masih menunggu jadwal pemberian pakan (${sisaWaktu}).`;
        this.showToast = true;
        setTimeout(() => { this.showToast = false; }, 4000);
    },

    triggerFeedNow() {
        this.isDispensing = true;
        setTimeout(() => {
            this.isDispensing = false;
            this.toastMessage = 'Pakan sebesar ' + this.targetPorsiGram + 'g berhasil dilontarkan!';
            this.showToast = true;
            setTimeout(() => { this.showToast = false; }, 4000);
        }, 2500);
    },

    saveFeedingConfig() {
        this.toastMessage = 'Data pemberian pakan berhasil disimpan dan disinkronkan ke ESP32!';
        this.showToast = true;
        setTimeout(() => { this.showToast = false; }, 4000);
    }
}" class="bg-slate-100 flex h-screen font-sans antialiased">

    <!-- Contoh Tombol Pemanggilan di HTML -->
    <!--
    <button 
        x-show="sesi >= 3" 
        @click="tampilkanStatusJadwal(sesi)" 
        class="px-3 py-1.5 inline-flex items-center justify-center rounded-lg bg-emerald-50 text-emerald-500 hover:bg-emerald-100 hover:text-emerald-600 transition text-xs font-semibold" 
        title="Lihat status jadwal">
        Lihat
    </button>
    -->

    <!-- Toast Notification Banner -->
    <div x-show="showToast"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-2"
        class="fixed bottom-5 right-5 z-50 bg-slate-900 text-white px-5 py-3 rounded-xl shadow-2xl flex items-center gap-3 border border-slate-700">
        <i class="fa-solid fa-circle-check text-emerald-400 text-lg"></i>
        <span x-text="toastMessage" class="text-sm font-medium"></span>
    </div>

    <!-- Sidebar Navigation -->
    <aside :class="sidebarOpen ? 'w-64 p-6' : 'w-20 p-4'" class="bg-blue-900 text-white flex flex-col justify-between transition-all duration-300 ease-in-out shrink-0">
        <div>
            <!-- Logo & Brand Header -->
            <div class="flex items-center gap-3 mb-10 overflow-hidden whitespace-nowrap">
                <img src="{{ asset('img/logo-putih.png') }}" onerror="this.src='https://placehold.co/40x40/1e3a8a/ffffff?text=S'" alt="Logo SIMONAT" class="w-9 h-9 object-contain">
                <h1 x-show="sidebarOpen" x-transition.opacity class="text-2xl font-bold tracking-wider">
                    SIMONAT
                </h1>
            </div>

            <!-- Navigation Links -->
            <nav class="space-y-2">
                <a href="{{ route('dashboard') }}" :class="sidebarOpen ? 'justify-start' : 'justify-center'" class="flex items-center gap-3 p-3 hover:bg-blue-800/60 rounded-xl font-medium text-blue-200 hover:text-white transition-all" title="Dashboard">
                    <i class="fa-solid fa-house text-lg"></i>
                    <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap">
                        Dashboard
                    </span>
                </a>

                <a href="{{ route('monitoring') }}" :class="sidebarOpen ? 'justify-start' : 'justify-center'" class="flex items-center gap-3 p-3 hover:bg-blue-800/60 rounded-xl font-medium text-blue-200 hover:text-white transition-all" title="Monitoring">
                    <i class="fa-solid fa-chart-line text-lg"></i>
                    <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap">
                        Monitoring
                    </span>
                </a>

                <a href="{{ route('pakan') }}" :class="sidebarOpen ? 'justify-start' : 'justify-center'" class="flex items-center gap-3 bg-blue-800 text-white p-3 rounded-xl font-medium transition-all shadow-sm" title="Pakan">
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

        <!-- Sidebar Footer Status -->
        <div x-show="sidebarOpen" class="bg-blue-950/60 p-3.5 rounded-xl border border-blue-800/50 text-xs">
            <p class="text-blue-300 font-semibold mb-1"><i class="fa-solid fa-microchip text-emerald-400 mr-1"></i> ESP32 Feeder</p>
            <p class="text-slate-400">Status: <span class="text-emerald-400 font-medium">Online (LoadCell Active)</span></p>
        </div>
    </aside>

    <!-- Main Content Container -->
    <main class="flex-1 p-8 overflow-y-auto">

        <!-- Header Bar -->
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
                            Pembudidaya ATP IPB
                        </p>
                    </div>
                    <i class="fa-solid fa-chevron-down text-xs text-slate-400 ml-1"></i>
                </button>

                <div x-show="open" @click.outside="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 py-2 z-50">
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

        <!-- Page Title -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-slate-800">
                <center> Manajemen dan Penjadwalan Pakan </center>
            </h2>
        </div>

        <!-- Section 1: Parameter & Threshold Pakan Calculation Card -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 mb-6">
            <div class="flex items-center justify-center border-b border-slate-100 pb-4 mb-5 text-center w-full">
                <div class="w-full flex flex-col items-center justify-center">
                    <h3 class="font-bold text-slate-800 text-lg flex items-center justify-center gap-2">
                        Manajemen Pemberian Pakan
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5 text-center">Sesuaikan manajemen pemberian pakan sesuai kondisi ikan pada kolam budidaya.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Input Controls -->
                <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <!-- Jumlah Ikan -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-2">Jumlah Ikan pada kolam</label>
                        <div class="relative">
                            <input type="number"
                                min="1"
                                x-model.number="jumlahIkan"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            <span class="absolute right-3 top-2.5 text-xs text-slate-400 font-medium">ekor</span>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Masukkan jumlah ikan yang ada di kolam</p>
                    </div>

                    <!-- Jenis Ikan -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-2">Jenis Ikan</label>
                        <select x-model="jenisIkan"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            <option value="nila_hitam">Ikan Nila Hitam</option>
                            <option value="nila_merah">Ikan Nila Merah</option>
                        </select>
                        <p class="text-[11px] text-slate-400 mt-1">Jenis ikan yang dibudidaya.</p>
                    </div>

                    <!-- Tahap Pertumbuhan -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-2">Tahap Pertumbuhan Ikan</label>
                        <select x-model="fasePertumbuhan"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            <option value="benih">Benih</option>
                            <option value="pembesaran">Pembesaran</option>
                        </select>
                        <p class="text-[11px] text-slate-400 mt-1">Pilih tahap pertumbuhan ikan saat ini</p>
                    </div>

                    <!-- Rata-rata Berat Ikan -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-2">Rata-rata Berat Ikan di kolam</label>
                        <div class="relative">
                            <input type="number"
                                min="1"
                                x-model.number="beratRataRata"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            <span class="absolute right-3 top-2.5 text-xs text-slate-400 font-medium">gram/ekor</span>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Masukkan berat rata-rata ikan berdasarkan hasil penimbangan sampel.</p>
                    </div>

                    <!-- Frekuensi Pemberian Pakan -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-2">
                            Frekuensi Pemberian Pakan
                        </label>

                        <select
                            x-model.number="frekuensiHari"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            <option value="1">1 kali sehari</option>
                            <option value="2">2 kali sehari</option>
                            <option value="3">3 kali sehari</option>
                            <option value="4">4 kali sehari</option>
                        </select>

                        <p class="text-[11px] text-slate-400 mt-1">
                            Pilih berapa kali pakan diberikan dalam sehari.
                        </p>
                    </div>

                    <!-- Pilih Device -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-2">
                            Pilih Device
                        </label>

                        <select
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            <option>Device 001 - SIMONAT</option>
                        </select>

                        <p class="text-[11px] text-slate-400 mt-1">
                            Pilih device yang terhubung dengan kolam budidaya.
                        </p>
                    </div>

                </div>

                <!-- Calculated Summary Box -->
                <div class="bg-slate-50 border border-slate-200/80 rounded-xl p-4 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <span class="text-xs font-bold text-blue-900 uppercase tracking-wide">
                                    Rekomendasi Pemberian Pakan
                                </span>
                                <p class="text-[11px] text-slate-400 mt-1">
                                    Rekomendasi berdasarkan data ikan yang anda masukkan
                                </p>
                            </div>
                            <i class="fa-solid fa-calculator text-blue-900"></i>
                        </div>

                        <div class="space-y-3 mb-4">
                            <div class="flex justify-between items-center text-xs text-slate-600">
                                <span>Estimasi Total Biomassa:</span>
                                <span class="font-bold text-slate-800" x-text="totalBiomassKg + ' kg'"></span>
                            </div>

                            <div class="flex justify-between items-center text-xs text-slate-600">
                                <span>Rekomendasi Pakan Harian:</span>
                                <span class="font-bold text-emerald-600" x-text="targetHarianGram + ' gram/hari'"></span>
                            </div>

                            <div class="border-t border-slate-200 pt-2 flex justify-between items-center">
                                <span class="text-xs font-bold text-slate-800">
                                    Pakan per Pemberian:
                                </span>
                                <span
                                    class="text-base font-extrabold text-blue-900"
                                    x-text="targetPorsiGram + ' gram'">
                                </span>
                            </div>

                            <div class="flex justify-between items-center text-xs text-slate-600">
                                <span>Frekuensi Pemberian:</span>
                                <span
                                    class="font-bold text-slate-800"
                                    x-text="frekuensiHari + ' kali sehari'">
                                </span>
                            </div>
                        </div>
                    </div>

                    <button @click="saveFeedingConfig()"
                        class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-2 rounded-lg text-xs font-semibold transition flex items-center justify-center gap-1.5 shadow-sm">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Data
                    </button>
                </div>
            </div>
        </div>

        <!-- Section 2: Stok Pakan & Pengaturan Otomatisasi Feeder -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-6">

            <!-- Feed Inventory (Ultrasonic & Loadcell Sensor) -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                            <i class="fa-solid fa-boxes-stacked text-blue-900"></i> Stok Pakan Wadah
                        </h3>
                        <span class="text-xs text-slate-400">Sensor Ultrasonik</span>
                    </div>

                    <div class="flex items-center gap-5 my-2">
                        <!-- Progress Bar Visual -->
                        <div class="w-16 h-28 bg-slate-100 border border-slate-200 rounded-xl overflow-hidden relative flex flex-col justify-end p-1">
                            <div class="w-full bg-blue-600 rounded-lg transition-all duration-500" :style="'height: ' + stokPakanPersen + '%'"></div>
                        </div>

                        <div>
                            <p class="text-3xl font-extrabold text-slate-800 tracking-tight" x-text="stokPakanPersen + '%'"></p>
                            <p class="text-xs font-semibold text-slate-500 mt-1">Sisa pakan ± <span x-text="stokPakanKg"></span> kg</p>
                            <div class="mt-3 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-medium">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Stok Cukup
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-slate-100 text-xs text-slate-500 flex justify-between items-center">
                    <span>Daya Tampung Maks: 10 kg</span>
                    <button class="text-blue-900 font-semibold hover:underline"><i class="fa-solid fa-arrows-rotate mr-1"></i> Kalibrasi</button>
                </div>
            </div>

            <!-- Side-by-Side: Pengaturan Otomatisasi Feeder + Beri Pakan Sekarang -->
            <div class="xl:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-slate-800 text-lg mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-gears text-blue-900"></i> Pengaturan Otomatisasi Feeder
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <!-- Panel 1: Toggle Pemberian Pakan Otomatis -->
                        <div class="p-4 border border-slate-200/80 rounded-xl bg-slate-50/60 flex items-start justify-between">
                            <div class="pr-3">
                                <p class="font-bold text-slate-800 text-sm">Pemberian Pakan Otomatis</p>
                                <p class="text-xs text-slate-500 mt-1">Mengaktifkan katup servo dan motor DC melontarkan pakan sesuai jadwal.</p>
                            </div>
                            <!-- Switch Button -->
                            <button @click="autoFeedingEnabled = !autoFeedingEnabled"
                                :class="autoFeedingEnabled ? 'bg-blue-900' : 'bg-slate-300'"
                                class="w-12 h-6 rounded-full p-1 transition duration-200 ease-in-out shrink-0 focus:outline-none">
                                <div :class="autoFeedingEnabled ? 'translate-x-6' : 'translate-x-0'" class="w-4 h-4 rounded-full bg-white transition duration-200 ease-in-out"></div>
                            </button>
                        </div>

                        <!-- Panel 2: Tombol Beri Pakan Sekarang (Disamping Switch) -->
                        <div class="p-4 border border-slate-200/80 rounded-xl bg-blue-50/40 flex flex-col justify-between">
                            <div>
                                <p class="font-bold text-slate-800 text-sm">Beri Pakan Manual</p>
                                <p class="text-xs text-slate-500 mt-1">Lontarkan pakan instan sebesar <span class="font-bold text-blue-900" x-text="targetPorsiGram + 'g'"></span> ke kolam saat ini.</p>
                            </div>
                            <button @click="triggerFeedNow()"
                                :disabled="isDispensing"
                                class="mt-3 w-full bg-blue-900 hover:bg-blue-800 text-white py-2 px-4 rounded-xl text-xs font-semibold shadow-sm transition flex items-center justify-center gap-2 active:scale-95 disabled:opacity-50">
                                <i x-show="!isDispensing" class="fa-solid fa-paper-plane"></i>
                                <i x-show="isDispensing" class="fa-solid fa-circle-notch animate-spin"></i>
                                <span x-text="isDispensing ? 'Melontarkan Pakan...' : 'Beri Pakan Sekarang'"></span>
                            </button>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <!-- Section 3: Schedule Table & Feed Consumption History -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            <!-- Schedule List Table -->
            <div class="xl:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="font-bold text-slate-800 text-lg">Jadwal Pemberian Pakan Harian</h3>
                        <p class="text-xs text-slate-500">Eksekusi servo & timbangan load cell secara otomatis.</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-semibold border-b border-slate-100">
                            <tr>
                                <th class="py-3 px-4">Sesi</th>
                                <th class="py-3 px-4">Waktu</th>
                                <th class="py-3 px-4">Target Dosis</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">

                            <template x-for="sesi in frekuensiHari" :key="sesi">
                                <tr class="hover:bg-slate-50/80 transition">

                                    <td class="py-3.5 px-4 font-bold text-slate-800">
                                        <span x-text="'Sesi ' + sesi"></span>
                                    </td>

                                    <td class="py-3.5 px-4 font-medium text-slate-700">

                                        <span x-show="sesi === 1">
                                            08:00 WIB
                                        </span>

                                        <span x-show="sesi === 2">
                                            12:30 WIB
                                        </span>

                                        <span x-show="sesi === 3">
                                            16:00 WIB
                                        </span>

                                        <span x-show="sesi === 4">
                                            19:00 WIB
                                        </span>

                                    </td>

                                    <td class="py-3.5 px-4 font-semibold text-blue-900"
                                        x-text="targetPorsiGram + ' g'">
                                    </td>

                                    <td class="py-3.5 px-4">

                                        <span
                                            x-show="sesi < 3"
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-600 border border-emerald-200">

                                            <i class="fa-solid fa-check"></i>

                                            Selesai

                                        </span>

                                        <span
                                            x-show="sesi >= 3"
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-600 border border-amber-200">

                                            <i class="fa-regular fa-clock"></i>

                                            Mendatang

                                        </span>

                                    </td>

                                    <td class="py-3.5 px-4 text-center">

                                        <button
                                            x-show="sesi < 3"
                                            @click="toastMessage = 'Sesi ' + sesi + ' telah dikonfirmasi selesai!'; showToast = true; setTimeout(() => { showToast = false; }, 3000)"
                                            class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-emerald-50 text-emerald-500 hover:bg-emerald-100 hover:text-emerald-600 transition"
                                            title="Konfirmasi pemberian pakan selesai">

                                            <i class="fa-solid fa-circle-check"></i>

                                        </button>

                                        <button
                                            x-show="sesi >= 3"
                                            @click="tampilkanStatusJadwal(sesi)"
                                            class="px-3 py-1.5 inline-flex items-center justify-center rounded-lg bg-emerald-50 text-emerald-500 hover:bg-emerald-100 hover:text-emerald-600 transition text-xs font-semibold"
                                            title="Lihat status jadwal">
                                            Lihat
                                        </button>

                                    </td>

                                </tr>
                            </template>

                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Feed Consumption Chart Card -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-slate-800 text-lg mb-1">Riwayat Konsumsi Pakan</h3>
                    <p class="text-xs text-slate-500 mb-4">Total pakan terdistribusi 7 hari terakhir (kg).</p>
                    <div class="h-48 w-full">
                        <canvas id="feedHistoryChart"></canvas>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 text-center">
                    <p class="text-xs text-slate-500">Rata-rata konsumsi harian: <span class="font-bold text-slate-800">2.25 kg</span></p>
                </div>
            </div>

        </div>

    </main>

    <!-- Script Chart.js -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('feedHistoryChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                    datasets: [{
                        label: 'Pakan (kg)',
                        data: [2.1, 2.25, 2.3, 2.15, 2.25, 2.4, 2.25],
                        backgroundColor: '#1e3a8a',
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            grid: {
                                color: '#f1f5f9'
                            },
                            ticks: {
                                font: {
                                    size: 10
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 10
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>

</body>

</html>