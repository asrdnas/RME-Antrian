<x-filament-panels::page>
    {{-- Selamat Datang --}}
    <div class="mb-8 animate-bounce-in">
        <h1 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 relative inline-block">
            👋
            <span class="typing-text text-primary-600 dark:text-primary-400">
                Selamat Datang, {{ auth()->user()->name }}
            </span>
        </h1>
        <p class="mt-1 text-gray-500 dark:text-gray-400">
            Semoga harimu menyenangkan 🚀
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Total Antrian Umum --}}
        <div
            class="relative overflow-hidden rounded-2xl shadow-lg transition hover:scale-[1.05] hover:shadow-2xl
                   bg-gradient-to-r from-pink-400 via-purple-400 to-indigo-400
                   dark:from-pink-600 dark:via-purple-700 dark:to-indigo-700
                   p-6 animate-fade-glow"
        >
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-white">Antrian Umum Hari Ini</h2>
                    <p class="text-4xl font-extrabold mt-3 text-white drop-shadow-lg">
                        {{ \App\Models\Antrian::whereDate('created_at', today())->where('pelayanan', 'Umum')->count() }}
                    </p>
                </div>
                <div class="p-4 bg-white/30 dark:bg-black/30 rounded-xl backdrop-blur-sm">
                    <x-heroicon-o-queue-list class="w-10 h-10 text-white" />
                </div>
            </div>
        </div>

        {{-- Total Antrian Gilut --}}
        <div
            class="relative overflow-hidden rounded-2xl shadow-lg transition hover:scale-[1.05] hover:shadow-2xl
                   bg-gradient-to-r from-yellow-400 via-orange-400 to-red-400
                   dark:from-yellow-600 dark:via-orange-700 dark:to-red-700
                   p-6 animate-fade-glow delay-200"
        >
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-white">Antrian Gilut Hari Ini</h2>
                    <p class="text-4xl font-extrabold mt-3 text-white drop-shadow-lg">
                        {{ \App\Models\Antrian::whereDate('created_at', today())->where('pelayanan', 'Gilut')->count() }}
                    </p>
                </div>
                <div class="p-4 bg-white/30 dark:bg-black/30 rounded-xl backdrop-blur-sm">
                    <x-heroicon-o-queue-list class="w-10 h-10 text-white" />
                </div>
            </div>
        </div>

        {{-- Total Pasien --}}

        <div
            class="relative overflow-hidden rounded-2xl shadow-lg transition hover:scale-[1.05] hover:shadow-2xl
                   bg-gradient-to-r from-emerald-400 via-teal-400 to-cyan-400
                   dark:from-emerald-600 dark:via-teal-700 dark:to-cyan-700
                   p-6 animate-fade-glow delay-400"
        >
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-white">Total Pasien</h2>
                    <p class="text-4xl font-extrabold mt-3 text-white drop-shadow-lg">
                        {{ \App\Models\Patient::where('status_validasi', 'approved')->count() }}
                    </p>
                </div>
                <div class="p-4 bg-white/30 dark:bg-black/30 rounded-xl backdrop-blur-sm">
                    <x-heroicon-o-users class="w-10 h-10 text-white" />
                </div>
            </div>
        </div>
    </div>

    {{-- Grafik dan Statistik --}}
<x-filament-panels::page>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @livewire(\App\Filament\Widgets\StatistikAntrian::class)
        @livewire(\App\Filament\Widgets\TrenAntrianBulanan::class)
    </div>
</x-filament-panels::page>



    {{-- Custom Animations --}}
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
    </style>
</x-filament-panels::page>
