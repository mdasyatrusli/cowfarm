<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-farm-green leading-tight">
            {{ __('Edit Feed Record') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-farm-cream min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('feed-records.update', $feedRecord) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="cow_id" :value="__('Cow')" />
                            <select id="cow_id" name="cow_id" class="block mt-1 w-full border-gray-300 focus:border-farm-green focus:ring-farm-green rounded-md shadow-sm" required>
                                <option value="">{{ __('Select cow...') }}</option>
                                @foreach ($cows as $cow)
                                    <option value="{{ $cow->id }}" {{ old('cow_id', $feedRecord->cow_id) == $cow->id ? 'selected' : '' }}>
                                        {{ $cow->tag_number }} @if($cow->name)({{ $cow->name }})@endif
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('cow_id')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="feed_id" :value="__('Feed')" />
                            <select id="feed_id" name="feed_id" class="block mt-1 w-full border-gray-300 focus:border-farm-green focus:ring-farm-green rounded-md shadow-sm" required>
                                <option value="">{{ __('Select feed...') }}</option>
                                @foreach ($feeds as $feed)
                                    <option value="{{ $feed->id }}" {{ old('feed_id', $feedRecord->feed_id) == $feed->id ? 'selected' : '' }}>
                                        {{ $feed->name }} ({{ __('Stock') }}: {{ number_format($feed->current_stock, 2) }} {{ $feed->unit }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('feed_id')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="quantity" :value="__('Quantity')" />
                            <x-text-input id="quantity" class="block mt-1 w-full focus:border-farm-green focus:ring-farm-green" type="number" step="0.01" min="0.01" name="quantity" :value="old('quantity', $feedRecord->quantity)" required />
                            <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="record_date" :value="__('Date')" />
                            <x-text-input id="record_date" class="block mt-1 w-full focus:border-farm-green focus:ring-farm-green" type="date" name="record_date" :value="old('record_date', $feedRecord->record_date->format('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('record_date')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('feed-records.index') }}" class="text-sm text-farm-brown hover:text-yellow-900 mr-4">{{ __('Cancel') }}</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-farm-green border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-800 focus:bg-green-800 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-farm-green focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Update Feed Record') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
