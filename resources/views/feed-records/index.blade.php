<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-farm-green leading-tight">
            {{ __('Catatan Pakan') }}
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

                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-farm-green">{{ __('Semua Catatan Pakan') }}</h3>
                        @can('create', App\Models\FeedRecord::class)
                            <a href="{{ route('feed-records.create') }}" class="inline-flex items-center px-4 py-2 bg-farm-green border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-800 focus:bg-green-800 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-farm-green focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Tambah Catatan Pakan') }}
                            </a>
                        @endcan
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-farm-green">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('Tanggal') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('Sapi') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('Pakan') }}</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-white uppercase tracking-wider">{{ __('Jumlah') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($feedRecords as $record)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $record->record_date->format('Y-m-d') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $record->cow?->tag_number ?: '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $record->feed?->name ?: '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        {{ number_format($record->quantity, 2) }} {{ $record->feed?->unit ?? '' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('feed-records.edit', $record) }}" class="text-farm-brown hover:text-yellow-900 mr-3">{{ __('Edit') }}</a>
                                        <form action="{{ route('feed-records.destroy', $record) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('{{ __('Are you sure?') }}')">{{ __('Delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">{{ __('Tidak ada catatan pakan ditemukan.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $feedRecords->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
