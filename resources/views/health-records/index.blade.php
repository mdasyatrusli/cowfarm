<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-farm-green leading-tight">
            {{ __('Health Records') }}
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
                        <h3 class="text-lg font-semibold text-farm-green">{{ __('Semua Kesehatan') }}</h3>
                        @can('create', App\Models\HealthRecord::class)
                            <a href="{{ route('health-records.create') }}" class="inline-flex items-center px-4 py-2 bg-farm-green border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-800 focus:bg-green-800 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-farm-green focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Tambah Kesehatan') }}
                            </a>
                        @endcan
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-farm-green">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('Tanggal') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('Sapi') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('Diagnosis') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('Dokter Hewan') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('Biaya') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($healthRecords as $record)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $record->record_date->format('Y-m-d') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $record->cow?->tag_number ?: '-' }}</td>
                                    <td class="px-6 py-4">{{ Str::limit($record->diagnosis, 50) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $record->vet_name ?: '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $record->cost ? number_format($record->cost, 2) : '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('health-records.edit', $record) }}" class="text-farm-brown hover:text-yellow-900 mr-3">{{ __('Edit') }}</a>
                                        <form action="{{ route('health-records.destroy', $record) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('{{ __('Are you sure?') }}')">{{ __('Delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">{{ __('No health records found.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $healthRecords->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
