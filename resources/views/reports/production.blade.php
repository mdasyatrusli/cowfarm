<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Produksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Form -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('reports.production') }}" class="flex flex-wrap items-end gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dari</label>
                            <input type="date" name="start_date" id="start_date" value="{{ $startDate }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sampai</label>
                            <input type="date" name="end_date" id="end_date" value="{{ $endDate }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        @if ($farms->isNotEmpty())
                            <div>
                                <label for="farm_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Farm</label>
                                <select name="farm_id" id="farm_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Semua Farm</option>
                                    @foreach ($farms as $farm)
                                        <option value="{{ $farm->id }}" @selected(request('farm_id') == $farm->id)>
                                            {{ $farm->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Filter
                            </button>
                        </div>
                        <div>
                            <a href="{{ route('reports.production.pdf') . '?' . request()->getQueryString() }}"
                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Export PDF
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Produksi Susu</p>
                        <p class="mt-1 text-2xl font-semibold text-indigo-600 dark:text-indigo-400">
                            {{ number_format($totalMilkLiters, 2, ',', '.') }} L
                        </p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Biaya Kesehatan</p>
                        <p class="mt-1 text-2xl font-semibold text-red-600 dark:text-red-400">
                            Rp {{ number_format($totalHealthCost, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Sapi Aktif</p>
                        <p class="mt-1 text-2xl font-semibold text-green-600 dark:text-green-400">
                            {{ $totalActiveCows }} Ekor
                        </p>
                    </div>
                </div>
            </div>

            <!-- Chart: Daily Milk Production Trend -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Tren Produksi Susu Harian</h3>
                    @if (count($chartDates) > 0)
                        <div class="space-y-1">
                            @php
                                $maxVol = max($chartVolumes) > 0 ? max($chartVolumes) : 1;
                            @endphp
                            @foreach ($chartDates as $i => $date)
                                @php
                                    $pct = ($chartVolumes[$i] / $maxVol) * 100;
                                @endphp
                                <div class="flex items-center gap-2 py-0.5">
                                    <span class="w-20 text-xs text-gray-600 dark:text-gray-400">{{ $date }}</span>
                                    <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-5">
                                        <div class="bg-indigo-500 h-5 rounded-full" style="width: {{ $pct }}%"></div>
                                    </div>
                                    <span class="w-24 text-right text-xs font-medium text-gray-700 dark:text-gray-300">
                                        {{ number_format($chartVolumes[$i], 1, ',', '.') }} L
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">Tidak ada data untuk periode ini.</p>
                    @endif
                </div>
            </div>

            <!-- Table: Cows per Breed -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Populasi Sapi per Jenis (Breed)</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jenis</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($cowsPerBreed as $breed)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $breed->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-900 dark:text-gray-100">
                                            {{ $breed->cows_count }} ekor
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                            Belum ada data breed sapi.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="bg-gray-100 dark:bg-gray-600">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-gray-100">
                                        TOTAL
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-right text-gray-900 dark:text-gray-100">
                                        {{ $cowsPerBreed->sum('cows_count') }} ekor
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
