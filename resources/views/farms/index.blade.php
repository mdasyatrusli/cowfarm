<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-farm-green leading-tight">
            {{ __('All Farms') }}
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
                        <h3 class="text-lg font-semibold text-farm-green">{{ __('Farms') }}</h3>
                        @can('create', App\Models\Farm::class)
                            <a href="{{ route('farms.create') }}" class="inline-flex items-center px-4 py-2 bg-farm-green border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-farm-green/80 focus:outline-none focus:ring-2 focus:ring-farm-green focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('+ Create Farm') }}
                            </a>
                        @endcan
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-farm-green">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('Name') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('Location') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('Owner') }}</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">{{ __('Users') }}</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">{{ __('Cows') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($farms as $farm)
                                    <tr class="hover:bg-farm-cream/50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-farm-green">{{ $farm->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $farm->location ?: '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $farm->owner?->name ?: '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-gray-700">{{ $farm->users_count }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-gray-700">{{ $farm->cows_count }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('farms.edit', $farm) }}" class="text-farm-brown hover:text-farm-brown/70 mr-3 font-medium">{{ __('Edit') }}</a>
                                            <form action="{{ route('farms.destroy', $farm) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('{{ __('Are you sure you want to delete this farm?') }}')">{{ __('Delete') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">{{ __('No farms found.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $farms->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
