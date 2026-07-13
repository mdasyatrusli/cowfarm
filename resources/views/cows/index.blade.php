<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-farm-green leading-tight">
            {{ __('Cows') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-farm-cream min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-farm-brown/20">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="mb-4 px-4 py-2 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-farm-green">{{ __('Semua Sapi') }}</h3>
                        @can('create', App\Models\Cow::class)
                            <a href="{{ route('cows.create') }}" class="inline-flex items-center px-4 py-2 bg-farm-green border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-farm-green/80 focus:outline-none focus:ring-2 focus:ring-farm-green focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Tambah Sapi') }}
                            </a>
                        @endcan
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-farm-green">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('Nomor Tag') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('Nama') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('Ras') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('Jenis Kelamin') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('Status') }}</th>
                                    @can('viewAny', App\Models\Farm::class)
                                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('Farm') }}</th>
                                    @endcan
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('Aksi') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($cows as $cow)
                                    <tr class="hover:bg-farm-cream/50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-farm-green">{{ $cow->tag_number }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $cow->name ?: '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $cow->breed->name ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap capitalize text-gray-700">{{ $cow->gender == 'male' ? 'Jantan' : 'Betina' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $statusColors = [
                                                    'active' => 'bg-green-100 text-green-800',
                                                    'sold' => 'bg-yellow-100 text-yellow-800',
                                                    'dead' => 'bg-red-100 text-red-800',
                                                ];
                                            @endphp
                                            <span class="px-2 py-1 rounded text-xs font-medium {{ $statusColors[$cow->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ ucfirst($cow->status) }}
                                            </span>
                                        </td>
                                        @can('viewAny', App\Models\Farm::class)
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $cow->farm?->name ?: '-' }}</td>
                                        @endcan
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('cows.edit', $cow) }}" class="text-farm-brown hover:text-farm-brown/70 mr-3 font-medium">{{ __('Edit') }}</a>
                                            <form action="{{ route('cows.destroy', $cow) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('{{ __('Are you sure you want to delete this cow?') }}')">{{ __('Delete') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">{{ __('No cows found.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $cows->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
