<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-farm-green leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-farm-cream min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                {{-- Total Cows (Active) --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-farm-brown/20">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-farm-green/10 rounded-md p-3">
                                <svg class="h-8 w-8 text-farm-green" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">{{ __('Active Cows') }}</p>
                                <p class="text-2xl font-semibold text-farm-green">{{ $totalCowsActive }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Cows (All) --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-farm-brown/20">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-farm-brown/10 rounded-md p-3">
                                <svg class="h-8 w-8 text-farm-brown" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">{{ __('Total Cows') }}</p>
                                <p class="text-2xl font-semibold text-farm-brown">{{ $totalCowsAll }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Health Records This Month --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-farm-brown/20">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-100 rounded-md p-3">
                                <svg class="h-8 w-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5 0h7.5m-7.5 0l-1 3m-1.5-3h.375c.621 0 1.125-.504 1.125-1.125V12m-3 0h.375c.621 0 1.125-.504 1.125-1.125V8.25c0-.621-.504-1.125-1.125-1.125H5.625c-.621 0-1.125.504-1.125 1.125v2.625c0 .621.504 1.125 1.125 1.125H6" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">{{ __('Health Records') }}</p>
                                <p class="text-sm text-gray-400">{{ __('this month') }}</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $healthRecordsThisMonth }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Milk Volume This Month --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-farm-brown/20">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-farm-green/10 rounded-md p-3">
                                <svg class="h-8 w-8 text-farm-green" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">{{ __('Milk Volume') }}</p>
                                <p class="text-sm text-gray-400">{{ __('this month') }}</p>
                                <p class="text-2xl font-semibold text-farm-green">{{ number_format($milkVolumeThisMonth, 1) }} <span class="text-sm font-normal text-gray-500">L</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                {{-- Milk Production Chart --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-farm-brown/20">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-farm-green mb-4">{{ __('Milk Production — Last 7 Days') }}</h3>
                        <canvas id="milkChart" height="200"></canvas>
                    </div>
                </div>

                {{-- Recent Health Records --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-farm-brown/20">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-farm-green mb-4">{{ __('Recent Health Records') }}</h3>

                        @if($recentHealthRecords->isEmpty())
                            <p class="text-sm text-gray-500">{{ __('No health records yet.') }}</p>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 text-sm">
                                    <thead>
                                        <tr class="bg-farm-green">
                                            <th class="px-3 py-2 text-left font-medium text-white uppercase tracking-wider">{{ __('Date') }}</th>
                                            <th class="px-3 py-2 text-left font-medium text-white uppercase tracking-wider">{{ __('Cow') }}</th>
                                            <th class="px-3 py-2 text-left font-medium text-white uppercase tracking-wider">{{ __('Diagnosis') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($recentHealthRecords as $record)
                                            <tr class="hover:bg-farm-cream/50 transition-colors">
                                                <td class="px-3 py-2 whitespace-nowrap text-gray-900">{{ $record->record_date->format('d M Y') }}</td>
                                                <td class="px-3 py-2 whitespace-nowrap text-gray-900">
                                                    @if($record->cow)
                                                        {{ $record->cow->tag_number }} — {{ $record->cow->name }}
                                                    @else
                                                        <span class="text-gray-400 italic">{{ __('Unknown') }}</span>
                                                    @endif
                                                </td>
                                                <td class="px-3 py-2 whitespace-nowrap text-gray-600">{{ Str::limit($record->diagnosis, 30) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('milkChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: '{{ __("Milk Volume (L)") }}',
                    data: @json($chartData),
                    borderColor: '#145a32',
                    backgroundColor: 'rgba(20, 90, 50, 0.1)',
                    fill: true,
                    tension: 0.3,
                    pointBackgroundColor: '#145a32',
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value + ' L';
                            }
                        }
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>
