<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-farm-green leading-tight">
            {{ __('Edit Feed') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-farm-cream min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('feeds.update', $feed) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Feed Name')" />
                            <x-text-input id="name" class="block mt-1 w-full focus:border-farm-green focus:ring-farm-green" type="text" name="name" :value="old('name', $feed->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="unit" :value="__('Unit')" />
                            <x-text-input id="unit" class="block mt-1 w-full focus:border-farm-green focus:ring-farm-green" type="text" name="unit" :value="old('unit', $feed->unit)" required placeholder="{{ __('e.g. kg, sack, liter') }}" />
                            <x-input-error :messages="$errors->get('unit')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('feeds.index') }}" class="text-sm text-farm-brown hover:text-yellow-900 mr-4">{{ __('Cancel') }}</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-farm-green border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-800 focus:bg-green-800 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-farm-green focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Update Feed') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
