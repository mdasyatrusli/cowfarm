<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-farm-green leading-tight">
            {{ __('Tambah Kesehatan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-farm-cream min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('health-records.store') }}" method="POST">
                        @csrf

                        <!-- Cow -->
                        <div class="mb-4">
                            <label for="cow_id" class="block text-sm font-medium text-gray-700">{{ __('Sapi') }}</label>
                            <select name="cow_id" id="cow_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-farm-green focus:ring-farm-green">
                                <option value="">{{ __('-- Select Cow --') }}</option>
                                @foreach ($cows as $cow)
                                    <option value="{{ $cow->id }}" {{ old('cow_id') == $cow->id ? 'selected' : '' }}>
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
                            <label for="record_date" class="block text-sm font-medium text-gray-700">{{ __('Tanggal Pencatatan') }}</label>
                            <input type="date" name="record_date" id="record_date" value="{{ old('record_date', date('Y-m-d')) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-farm-green focus:ring-farm-green">
                            @error('record_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Diagnosis -->
                        <div class="mb-4">
                            <label for="diagnosis" class="block text-sm font-medium text-gray-700">{{ __('Diagnosis') }}</label>
                            <input type="text" name="diagnosis" id="diagnosis" value="{{ old('diagnosis') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-farm-green focus:ring-farm-green">
                            @error('diagnosis')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Treatment -->
                        <div class="mb-4">
                            <label for="treatment" class="block text-sm font-medium text-gray-700">{{ __('Penanganan') }}</label>
                            <textarea name="treatment" id="treatment" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-farm-green focus:ring-farm-green">{{ old('treatment') }}</textarea>
                            @error('treatment')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Vet Name -->
                        <div class="mb-4">
                            <label for="vet_name" class="block text-sm font-medium text-gray-700">{{ __('Dokter Hewan') }}</label>
                            <input type="text" name="vet_name" id="vet_name" value="{{ old('vet_name') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-farm-green focus:ring-farm-green">
                            @error('vet_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Cost -->
                        <div class="mb-4">
                            <label for="cost" class="block text-sm font-medium text-gray-700">{{ __('Biaya') }}</label>
                            <input type="number" step="0.01" min="0" name="cost" id="cost" value="{{ old('cost') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-farm-green focus:ring-farm-green">
                            @error('cost')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('health-records.index') }}" class="inline-flex items-center px-4 py-2 bg-farm-brown text-white rounded hover:bg-yellow-900 mr-2">{{ __('Cancel') }}</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-farm-green border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-800 focus:bg-green-800 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-farm-green focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
