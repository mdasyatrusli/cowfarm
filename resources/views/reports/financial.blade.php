<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Keuangan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Form -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('reports.financial') }}" class="flex flex-wrap items-end gap-4">
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
                            <a href="{{ route('reports.financial.pdf') . '?' . request()->getQueryString() }}"
                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Export PDF
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pendapatan</p>
                        <p class="mt-1 text-2xl font-semibold text-green-600 dark:text-green-400">
                            Rp {{ number_format($totalIncome, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Biaya</p>
                        <p class="mt-1 text-2xl font-semibold text-red-600 dark:text-red-400">
                            Rp {{ number_format($totalExpense, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Biaya Kesehatan</p>
                        <p class="mt-1 text-2xl font-semibold text-yellow-600 dark:text-yellow-400">
                            Rp {{ number_format($healthCostTotal, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Laba / Rugi</p>
                        <p class="mt-1 text-2xl font-semibold {{ $profitLoss >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                            Rp {{ number_format($profitLoss, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Chart: Income vs Expense (bar chart via CSS) -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Pendapatan vs Biaya per Bulan</h3>
                    @if (count($chartMonths) > 0)
                        <div class="space-y-2">
                            @foreach ($chartMonths as $i => $month)
                                @php
                                    $maxVal = max(max($chartIncome), max($chartExpense), 1);
                                    $incomePct = $maxVal > 0 ? ($chartIncome[$i] / $maxVal) * 100 : 0;
                                    $expensePct = $maxVal > 0 ? ($chartExpense[$i] / $maxVal) * 100 : 0;
                                @endphp
                                <div class="flex items-center gap-2">
                                    <span class="w-20 text-xs text-gray-600 dark:text-gray-400">{{ $month }}</span>
                                    <div class="flex-1 space-y-1">
                                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4">
                                            <div class="bg-green-500 h-4 rounded-full" style="width: {{ $incomePct }}%"></div>
                                        </div>
                                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4">
                                            <div class="bg-red-500 h-4 rounded-full" style="width: {{ $expensePct }}%"></div>
                                        </div>
                                    </div>
                                    <div class="w-28 text-right text-xs">
                                        <span class="text-green-600 dark:text-green-400">Rp {{ number_format($chartIncome[$i], 0, ',', '.') }}</span>
                                        /
                                        <span class="text-red-600 dark:text-red-400">Rp {{ number_format($chartExpense[$i], 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">Tidak ada data untuk periode ini.</p>
                    @endif
                </div>
            </div>

            <!-- Category Breakdown Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Rincian per Kategori</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kategori</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pendapatan</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Biaya</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Selisih</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($transactionCategories as $cat)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $cat->category }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-green-600 dark:text-green-400">
                                            Rp {{ number_format($cat->total_income, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-red-600 dark:text-red-400">
                                            Rp {{ number_format($cat->total_expense, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right {{ ($cat->total_income - $cat->total_expense) >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            Rp {{ number_format($cat->total_income - $cat->total_expense, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                            Belum ada transaksi.
                                        </td>
                                    </tr>
                                @endforelse
                                <!-- Health cost row -->
                                @if ($healthCostTotal > 0)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            Kesehatan (biaya langsung)
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-green-600 dark:text-green-400">
                                            Rp 0
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-red-600 dark:text-red-400">
                                            Rp {{ number_format($healthCostTotal, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-red-600 dark:text-red-400">
                                            -Rp {{ number_format($healthCostTotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            <tfoot class="bg-gray-100 dark:bg-gray-600">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-gray-100">
                                        TOTAL
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-right text-green-600 dark:text-green-400">
                                        Rp {{ number_format($totalIncome, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-right text-red-600 dark:text-red-400">
                                        Rp {{ number_format($totalExpense, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-right {{ $profitLoss >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                        Rp {{ number_format($profitLoss, 0, ',', '.') }}
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
