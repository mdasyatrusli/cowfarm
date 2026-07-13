<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-farm-green leading-tight">
            {{ __('Breeds') }}
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
                        <h3 class="text-lg font-semibold text-farm-green">{{ __('Semua Jenis') }}</h3>
                        @can('create', App\Models\Breed::class)
                            <a href="{{ route('breeds.create') }}" class="inline-flex items-center px-4 py-2 bg-farm-green border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-800 focus:bg-green-800 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-farm-green focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('+ Add Breed') }}
                            </a>
                        @endcan
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-farm-green">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('Name') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('Description') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($breeds as $breed)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $breed->name }}</td>
                                    <td class="px-6 py-4 align-top">{{ $breed->description ?: '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @can('update', $breed)
                                            <a href="{{ route('breeds.edit', $breed) }}" class="text-farm-brown hover:text-yellow-900 mr-3">{{ __('Edit') }}</a>
                                        @endcan
                                        @can('delete', $breed)
                                            <form action="{{ route('breeds.destroy', $breed) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('{{ __('Are you sure you want to delete this breed?') }}')">{{ __('Delete') }}</button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">{{ __('No breeds found.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $breeds->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
