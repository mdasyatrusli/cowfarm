<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-farm-green leading-tight">
            {{ __('Tambah Pakan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-farm-cream min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('feeds.store') }}">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nama Pakan')" />
                            <x-text-input id="name" class="block mt-1 w-full focus:border-farm-green focus:ring-farm-green" type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="unit" :value="__('Satuan')" />
                            <x-text-input id="unit" class="block mt-1 w-full focus:border-farm-green focus:ring-farm-green" type="text" name="unit" :value="old('unit')" required placeholder="{{ __('e.g. kg, sack, liter') }}" />
                            <x-input-error :messages="$errors->get('unit')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="initial_stock" :value="__('Stok Awal')" />
                            <x-text-input id="initial_stock" class="block mt-1 w-full focus:border-farm-green focus:ring-farm-green" type="number" step="0.01" min="0" name="initial_stock" :value="old('initial_stock', 0)" />
                            <x-input-error :messages="$errors->get('initial_stock')" class="mt-2" />
                            <p class="text-sm text-gray-500 mt-1">{{ __('Tetapkan jumlah stok awal untuk pakan ini. Stok dapat disesuaikan kembali melalui Riwayat Stok.') }}</p>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('feeds.index') }}" class="text-sm text-farm-brown hover:text-yellow-900 mr-4">{{ __('Cancel') }}</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-farm-green border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-800 focus:bg-green-800 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-farm-green focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Simpan') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
