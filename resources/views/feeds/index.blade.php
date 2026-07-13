<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-farm-green leading-tight">
            {{ __('Pakan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-farm-cream min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="mb-4 px-4 py-2 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 px-4 py-2 bg-red-100 border border-red-400 text-red-700 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-farm-green">{{ __('Daftar Pakan') }}</h3>
                        <div class="flex gap-2">
                            @can('create', App\Models\Feed::class)
                                <a href="{{ route('feeds.create') }}" class="inline-flex items-center px-4 py-2 bg-farm-green border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-800 focus:bg-green-800 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-farm-green focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('Tambah Pakan') }}
                                </a>
                            @endcan
                            @can('create', App\Models\FeedStockLog::class)
                                <a href="{{ route('feed-stock-logs.create') }}" class="inline-flex items-center px-4 py-2 bg-white border border-farm-green rounded-md font-semibold text-xs text-farm-green uppercase tracking-widest hover:bg-farm-cream focus:bg-farm-cream active:bg-farm-cream focus:outline-none focus:ring-2 focus:ring-farm-green focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('Log Stok') }}
                                </a>
                            @endcan
                        </div>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-farm-green">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('Nama') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('Satuan') }}</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-white uppercase tracking-wider">{{ __('Stok Saat Ini') }}</th>
                                @can('viewAny', App\Models\Farm::class)
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('Farm') }}</th>
                                @endcan
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($feeds as $feed)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $feed->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $feed->unit }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <span class="px-2 py-1 rounded text-xs font-medium {{ $feed->current_stock <= 0 ? 'bg-red-100 text-red-800' : ($feed->current_stock < 10 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                            {{ number_format($feed->current_stock, 2) }}
                                        </span>
                                    </td>
                                    @can('viewAny', App\Models\Farm::class)
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $feed->farm?->name ?: '-' }}</td>
                                    @endcan
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('feeds.edit', $feed) }}" class="text-farm-brown hover:text-yellow-900 mr-3">{{ __('Edit') }}</a>
                                        <form action="{{ route('feeds.destroy', $feed) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('{{ __('Are you sure you want to delete this feed?') }}')">{{ __('Delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">{{ __('Tidak ada pakan ditemukan.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $feeds->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
