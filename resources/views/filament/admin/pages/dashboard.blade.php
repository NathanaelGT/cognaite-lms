<x-filament::page>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        @foreach ([['Total Pengguna', $this->userCount], ['Total Batch', $this->batchCount], ['Batch Diselesaikan', $this->completedBatchCount]] as [$label, $value])
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-sm text-gray-500">{{ $label }}</h3>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($value) }}</p>
            </div>
        @endforeach
    </div>

    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h3 class="text-sm text-gray-500 mb-4">Filter Rentang Tanggal</h3>
        <div class="flex flex-col md:flex-row gap-4">
            <x-filament::input
                type="date"
                wire:model.defer="start_date"
                label="Tanggal Mulai"
                x-data
                x-on:change="$refs.end_date.min = $el.value"
            />
            <x-filament::input
                x-ref="end_date"
                type="date"
                wire:model.defer="end_date"
                label="Tanggal Selesai"
                min="{{ $start_date }}"
            />
            <x-filament::button wire:click="applyFilters" color="primary">
                Terapkan
            </x-filament::button>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h3 class="text-sm text-gray-500 mb-4">Chart Penjualan Harian</h3>
        <canvas id="salesChart" height="100"></canvas>
    </div>

    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h3 class="text-sm text-gray-500 mb-4">Batch Terpopuler</h3>
        <canvas id="popularBatchChart" height="100"></canvas>
    </div>

    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h3 class="text-sm text-gray-500 mb-4">Transaksi Terbaru</h3>
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-2 text-left font-medium text-gray-500">Nama</th>
                <th class="px-4 py-2 text-left font-medium text-gray-500">Batch</th>
                <th class="px-4 py-2 text-left font-medium text-gray-500">Harga</th>
                <th class="px-4 py-2 text-left font-medium text-gray-500">Status</th>
                <th class="px-4 py-2 text-left font-medium text-gray-500">Tanggal</th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($latestTransactions as $trx)
                <tr>
                    <td class="px-4 py-2">{{ $trx['user']['name'] ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $trx['batch']['name'] ?? '-' }}</td>
                    <td class="px-4 py-2">Rp {{ number_format($trx['price']) }}</td>
                    <td class="px-4 py-2">{{ $trx['status'] ?? '-' }}</td>
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($trx['created_at'])->format('d M Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-gray-400 py-4">Belum ada transaksi</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            new Chart(document.getElementById('salesChart').getContext('2d'), {
                type: 'line',
                data: {
                    labels: {!! json_encode(collect($this->salesChartData)->pluck('x')) !!},
                    datasets: [{
                        label: 'Pendapatan',
                        data: {!! json_encode(collect($this->salesChartData)->pluck('y')) !!},
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true, ticks: { callback: v => 'Rp ' + new Intl.NumberFormat('id-ID').format(v) } },
                        x: { title: { display: true, text: 'Tanggal' } }
                    }
                }
            });

            new Chart(document.getElementById('popularBatchChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode(collect($this->popularBatches)->pluck('name')) !!},
                    datasets: [{
                        label: 'Jumlah Peserta',
                        data: {!! json_encode(collect($this->popularBatches)->pluck('users_count')) !!},
                        backgroundColor: '#10b981',
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true, precision: 0, ticks: { stepSize: 1 } }
                    }
                }
            });
        </script>
    @endpush
</x-filament::page>
