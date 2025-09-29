<x-filament-panels::page>
    {{-- Selamat Datang --}}
    <div class="mb-8 animate-bounce-in">
        <h1 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 relative inline-block">
            <span class="typing-text text-primary-600 dark:text-primary-400">
                Selamat Datang, {{ auth()->user()->name }}
            </span>
        </h1>
        <p class="mt-1 text-gray-500 dark:text-gray-400">
            Semoga harimu menyenangkan 
        </p>
    </div>

    {{-- KARTU STATISTIK (Menggunakan desain perombakan terakhir) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        {{-- Total Antrian Umum --}}
        <div
            class="relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 shadow-xl border-t-4 border-pink-500
                   transition duration-500 transform hover:scale-[1.03] hover:shadow-2xl hover:bg-gray-50 dark:hover:bg-gray-700
                   p-6 flex flex-col items-center text-center animate-fade-glow group"
        >
            <h2 class="text-lg font-bold text-gray-700 dark:text-gray-200 mb-3 uppercase tracking-wider">Antrian Umum Hari Ini</h2>

            {{-- Icon di Tengah --}}
            <div class="p-4 rounded-full bg-pink-100 dark:bg-pink-900/50 shadow-inner group-hover:ring-4 ring-pink-500/50 transition duration-300">
                <x-heroicon-o-queue-list class="w-10 h-10 text-pink-600 dark:text-pink-400" />
            </div>

            {{-- Angka di Bawah --}}
            <p class="text-6xl font-extrabold mt-4 text-pink-700 dark:text-pink-400 drop-shadow-md">
                {{ \App\Models\Antrian::whereDate('created_at', today())->where('pelayanan', 'Umum')->count() }}
            </p>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Total Antrian</p>
        </div>

        {{-- Total Antrian Gilut --}}
        <div
            class="relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 shadow-xl border-t-4 border-orange-500
                   transition duration-500 transform hover:scale-[1.03] hover:shadow-2xl hover:bg-gray-50 dark:hover:bg-gray-700
                   p-6 flex flex-col items-center text-center animate-fade-glow delay-200 group"
        >
            <h2 class="text-lg font-bold text-gray-700 dark:text-gray-200 mb-3 uppercase tracking-wider">Antrian Gilut Hari Ini</h2>

            {{-- Icon di Tengah --}}
            <div class="p-4 rounded-full bg-orange-100 dark:bg-orange-900/50 shadow-inner group-hover:ring-4 ring-orange-500/50 transition duration-300">
                <x-heroicon-o-queue-list class="w-10 h-10 text-orange-600 dark:text-orange-400" />
            </div>

            {{-- Angka di Bawah --}}
            <p class="text-6xl font-extrabold mt-4 text-orange-700 dark:text-orange-400 drop-shadow-md">
                {{ \App\Models\Antrian::whereDate('created_at', today())->where('pelayanan', 'Gilut')->count() }}
            </p>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Total Antrian</p>
        </div>

        {{-- Total Pasien --}}
        <div
            class="relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 shadow-xl border-t-4 border-emerald-500
                   transition duration-500 transform hover:scale-[1.03] hover:shadow-2xl hover:bg-gray-50 dark:hover:bg-gray-700
                   p-6 flex flex-col items-center text-center animate-fade-glow delay-400 group"
        >
            <h2 class="text-lg font-bold text-gray-700 dark:text-gray-200 mb-3 uppercase tracking-wider">Total Pasien Terdaftar</h2>

            {{-- Icon di Tengah --}}
            <div class="p-4 rounded-full bg-emerald-100 dark:bg-emerald-900/50 shadow-inner group-hover:ring-4 ring-emerald-500/50 transition duration-300">
                <x-heroicon-o-user-group class="w-10 h-10 text-emerald-600 dark:text-emerald-400" />
            </div>

            {{-- Angka di Bawah --}}
            <p class="text-6xl font-extrabold mt-4 text-emerald-700 dark:text-emerald-400 drop-shadow-md">
                {{ \App\Models\Patient::where('status_validasi', 'approved')->count() }}
            </p>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Pasien Valid</p>
        </div>
    </div>

    <hr class="mt-8 mb-6 border-gray-200 dark:border-gray-700">

    {{-- Grafik dan Statistik --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Statistik Antrian Hari Ini --}}
        <div class="rounded-xl bg-white dark:bg-gray-800 p-6 shadow-lg border border-gray-100/70 dark:border-gray-700/70">
            <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">Statistik Antrian Harian</h2>
            @livewire(\App\Filament\Widgets\StatistikAntrian::class)
        </div>
        {{-- Tren Antrian Bulanan --}}
        <div class="rounded-xl bg-white dark:bg-gray-800 p-6 shadow-lg border border-gray-100/70 dark:border-gray-700/70">
            <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">Tren Antrian Bulanan</h2>
            @livewire(\App\Filament\Widgets\TrenAntrianBulanan::class)
        </div>
    </div>


    {{-- Custom Animations (TETAP) --}}
    <style>
        /* Bounce masuk */
        @keyframes bounce-in {
            0% { opacity: 0; transform: scale(0.8) translateY(-20px); }
            50% { opacity: 1; transform: scale(1.05) translateY(10px); }
            100% { transform: scale(1) translateY(0); }
        }
        .animate-bounce-in { animation: bounce-in 1s ease-out forwards; }

        /* Typing effect */
        .typing-text {
            display: inline-block;
            white-space: nowrap;
            overflow: hidden;
            border-right: 3px solid currentColor;
            animation: typing 3s steps(30, end), blink 0.8s step-end infinite;
        }
        @keyframes typing {
            from { width: 0; }
            to { width: 100%; }
        }
        @keyframes blink {
            50% { border-color: transparent; }
        }

        /* Fade glow untuk card */
        @keyframes fade-glow {
            0% { opacity: 0; transform: translateY(20px) scale(0.95); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }
        .animate-fade-glow {
            animation: fade-glow 1s ease-out forwards;
        }
        .delay-200 { animation-delay: 0.2s; }
        .delay-400 { animation-delay: 0.4s; }
    </style>
</x-filament-panels::page>