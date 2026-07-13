<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-farm-green leading-tight">
                {{ __('Transaksi') }}
            </h2>
            @can('create', App\Models\Transaction::class)
                <a href="{{ route('transactions.create') }}" class="inline-flex items-center px-4 py-2 bg-farm-green border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-800 focus:bg-green-800 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-farm-green focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Tambah Transaksi') }}
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12 bg-farm-cream min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- Filter Section -->
                    <div class="mb-6 p-4 bg-farm-cream rounded-lg">
                        <form method="GET" action="{{ route('transactions.index') }}" class="flex flex-wrap gap-4 items-end">
                            <div class="flex-1 min-w-[200px]">
                                <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                                <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}" class="border-gray-300 focus:border-farm-green focus:ring-farm-green rounded-md shadow-sm w-full">
                            </div>
                            <div class="flex-1 min-w-[200px]">
                                <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                                <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}" class="border-gray-300 focus:border-farm-green focus:ring-farm-green rounded-md shadow-sm w-full">
                            </div>
                            <div class="flex gap-2">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-farm-green border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-800">
                                    Filter
                                </button>
                                @if(request()->hasAny(['date_from', 'date_to']))
                                    <a href="{{ route('transactions.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-farm-green rounded-md font-semibold text-xs text-farm-green uppercase tracking-widest hover:bg-farm-cream">
                                        Bersihkan
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    @if($transactions->isEmpty())
                        <p class="text-gray-500 text-center py-4">Tidak ada transaksi ditemukan.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-farm-green">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tanggal</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tipe</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Kategori</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Jumlah</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Deskripsi</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($transactions as $transaction)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $transaction->transaction_date->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($transaction->type === 'income')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Pemasukan
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        Pengeluaran
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $transaction->category }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                Rp {{ number_format($transaction->amount, 2, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ Str::limit($transaction->description, 50) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex gap-2">
                                                    @can('update', $transaction)
                                                        <a href="{{ route('transactions.edit', $transaction) }}" class="text-farm-brown hover:text-yellow-900">Edit</a>
                                                    @endcan
                                                    @can('delete', $transaction)
                                                        <form method="POST" action="{{ route('transactions.destroy', $transaction) }}" onsubmit="return confirm('Are you sure you want to delete this transaction?');">
                                                            @csrf
                                                            @method('DELETE')
                                                             <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $transactions->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
