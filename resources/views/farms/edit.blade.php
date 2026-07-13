<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-farm-green leading-tight">
            {{ __('Edit Farm') }}: {{ $farm->name }}
        </h2>
    </x-slot>

    <div class="py-12 bg-farm-cream min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-farm-brown/20">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('farms.update', $farm) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Farm Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $farm->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="location" :value="__('Location')" />
                            <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location', $farm->location)" />
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </div>

                        @can('update', $farm)
                            @if (Auth::user()->isSuperAdmin())
                                <div class="mb-4">
                                    <x-input-label for="owner_id" :value="__('Owner')" />
                                    <select id="owner_id" name="owner_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-farm-green focus:ring-farm-green">
                                        <option value="">-- {{ __('No owner assigned') }} --</option>
                                        @foreach (\App\Models\User::all() as $user)
                                            <option value="{{ $user->id }}" {{ old('owner_id', $farm->owner_id) == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('owner_id')" class="mt-2" />
                                </div>
                            @endif
                        @endcan

                        <div class="flex items-center gap-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-farm-green border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-farm-green/80 focus:outline-none focus:ring-2 focus:ring-farm-green focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Update') }}
                            </button>
                            @if (Auth::user()->isSuperAdmin())
                                <a href="{{ route('farms.index') }}" class="text-farm-brown hover:text-farm-brown/70 font-medium">{{ __('Cancel') }}</a>
                            @else
                                <a href="{{ route('dashboard') }}" class="text-farm-brown hover:text-farm-brown/70 font-medium">{{ __('Cancel') }}</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
