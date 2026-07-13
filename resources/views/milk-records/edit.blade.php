<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-farm-green leading-tight">
            {{ __('Edit Produksi Susu') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-farm-cream min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('milk-records.update', $milkRecord) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Cow -->
                        <div class="mb-4">
                            <label for="cow_id" class="block text-sm font-medium text-gray-700">{{ __('Cow') }}</label>
                            <select name="cow_id" id="cow_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-farm-green focus:ring-farm-green">
                                <option value="">{{ __('-- Select Cow --') }}</option>
                                @foreach ($cows as $cow)
                                    <option value="{{ $cow->id }}" {{ old('cow_id', $milkRecord->cow_id) == $cow->id ? 'selected' : '' }}>
                                        {{ $cow->tag_number }} - {{ $cow->breed->name ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cow_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Record Date -->
                        <div class="mb-4">
                            <label for="record_date" class="block text-sm font-medium text-gray-700">{{ __('Record Date') }}</label>
                            <input type="date" name="record_date" id="record_date" value="{{ old('record_date', $milkRecord->record_date->format('Y-m-d')) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-farm-green focus:ring-farm-green">
                            @error('record_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Session -->
                        <div class="mb-4">
                            <label for="session" class="block text-sm font-medium text-gray-700">{{ __('Session') }}</label>
                            <select name="session" id="session" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-farm-green focus:ring-farm-green">
                                <option value="pagi" {{ old('session', $milkRecord->session) == 'pagi' ? 'selected' : '' }}>{{ __('Morning') }}</option>
                                <option value="sore" {{ old('session', $milkRecord->session) == 'sore' ? 'selected' : '' }}>{{ __('Afternoon') }}</option>
                            </select>
                            @error('session')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Volume -->
                        <div class="mb-4">
                            <label for="volume_liters" class="block text-sm font-medium text-gray-700">{{ __('Volume (Liters)') }}</label>
                            <input type="number" step="0.01" min="0" name="volume_liters" id="volume_liters" value="{{ old('volume_liters', $milkRecord->volume_liters) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-farm-green focus:ring-farm-green">
                            @error('volume_liters')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('milk-records.index') }}" class="inline-flex items-center px-4 py-2 bg-farm-brown text-white rounded hover:bg-yellow-900 mr-2">{{ __('Cancel') }}</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-farm-green border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-800 focus:bg-green-800 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-farm-green focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Update') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
