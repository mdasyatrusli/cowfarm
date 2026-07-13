<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Riwayat Stok') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('feed-stock-logs.store') }}">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="feed_id" :value="__('Pakan')" />
                            <select id="feed_id" name="feed_id" class="block mt-1 w-full border-gray-300 focus:border-farm-green focus:ring-farm-green rounded-md shadow-sm" required>
                                <option value="">{{ __('Pilih pakan...') }}</option>
                                @foreach ($feeds as $feed)
                                    <option value="{{ $feed->id }}" {{ old('feed_id') == $feed->id ? 'selected' : '' }}>
                                        {{ $feed->name }} ({{ __('Stock') }}: {{ number_format($feed->current_stock, 2) }} {{ $feed->unit }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('feed_id')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="type" :value="__('Tipe')" />
                            <select id="type" name="type" class="block mt-1 w-full border-gray-300 focus:border-farm-green focus:ring-farm-green rounded-md shadow-sm" required>
                                <option value="in" {{ old('type') == 'in' ? 'selected' : '' }}>{{ __('Stok Masuk (tambah)') }}</option>
                                <option value="out" {{ old('type') == 'out' ? 'selected' : '' }}>{{ __('Stok Keluar (kurang)') }}</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="quantity" :value="__('Jumlah')" />
                            <x-text-input id="quantity" class="block mt-1 w-full focus:border-farm-green focus:ring-farm-green" type="number" step="0.01" min="0.01" name="quantity" :value="old('quantity')" required />
                            <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="log_date" :value="__('Tanggal')" />
                            <x-text-input id="log_date" class="block mt-1 w-full focus:border-farm-green focus:ring-farm-green" type="date" name="log_date" :value="old('log_date', date('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('log_date')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="note" :value="__('Catatan (opsional)')" />
                            <textarea id="note" name="note" class="block mt-1 w-full border-gray-300 focus:border-farm-green focus:ring-farm-green rounded-md shadow-sm" rows="2">{{ old('note') }}</textarea>
                            <x-input-error :messages="$errors->get('note')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('feeds.index') }}" class="text-sm text-farm-brown hover:text-yellow-900 mr-4">{{ __('Cancel') }}</a>
                            <x-primary-button class="bg-farm-green hover:bg-green-800">
                                {{ __('Simpan Riwayat Stok') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
