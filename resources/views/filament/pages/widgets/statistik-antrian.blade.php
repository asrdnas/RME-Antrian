<x-filament-widgets::widget>
    <x-filament::card>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold">Statistik Antrian</h2>

            {{-- Filter Poli --}}
            <select id="filter-poli" class="border rounded-lg px-2 py-1 text-sm dark:bg-gray-800 dark:text-white">
                <option value="all">Semua Poli</option>
                <option value="Umum">Umum</option>
                <option value="Gilut">Gigi & Mulut</option>
            </select>
        </div>

        <canvas id="antrianChart" height="120"></canvas>
    </x-filament::card>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('antrianChart').getContext('2d');

        let chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Harian', 'Mingguan', 'Bulanan'],
                datasets: [{
                    label: 'Jumlah Antrian',
                    data: @json(app(\App\Filament\Widgets\StatistikAntrian::class)->getData()),
                    backgroundColor: ['#f472b6', '#60a5fa', '#34d399'],
                    borderRadius: 12,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Event filter poli
        document.getElementById('filter-poli').addEventListener('change', async (e) => {
            const poli = e.target.value;

            const response = await fetch(`/api/statistik-antrian?pelayanan=${poli}`);
            const data = await response.json();

            chart.data.datasets[0].data = [data.harian, data.mingguan, data.bulanan];
            chart.update();
        });
    </script>
</x-filament-widgets::widget>
