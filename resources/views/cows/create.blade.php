<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-farm-green leading-tight">
            {{ __('Tambah Sapi') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-farm-cream min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-farm-brown/20">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('cows.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="tag_number" :value="__('Nomor Tag')" />
                            <x-text-input id="tag_number" class="block mt-1 w-full" type="text" name="tag_number" :value="old('tag_number')" required autofocus />
                            <x-input-error :messages="$errors->get('tag_number')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nama (opsional)')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="breed_id" :value="__('Ras')" />
                            <select id="breed_id" name="breed_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-farm-green focus:ring-farm-green" required>
                                <option value="">{{ __('-- Select Breed --') }}</option>
                                @foreach (\App\Models\Breed::orderBy('name')->get() as $breedOption)
                                    <option value="{{ $breedOption->id }}" {{ old('breed_id') == $breedOption->id ? 'selected' : '' }}>
                                        {{ $breedOption->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('breed_id')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="gender" :value="__('Gender')" />
                            <select id="gender" name="gender" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-farm-green focus:ring-farm-green" required>
                                <option value="">{{ __('-- Select Gender --') }}</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Jantan</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Betina</option>
                            </select>
                            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="birth_date" :value="__('Tanggal Lahir (opsional)')" />
                            <x-text-input id="birth_date" class="block mt-1 w-full" type="date" name="birth_date" :value="old('birth_date')" />
                            <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-farm-green focus:ring-farm-green" required>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                <option value="sold" {{ old('status') == 'sold' ? 'selected' : '' }}>{{ __('Sold') }}</option>
                                <option value="dead" {{ old('status') == 'dead' ? 'selected' : '' }}>{{ __('Dead') }}</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-farm-green border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-farm-green/80 focus:outline-none focus:ring-2 focus:ring-farm-green focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Save') }}
                            </button>
                            <a href="{{ route('cows.index') }}" class="text-farm-brown hover:text-farm-brown/70 font-medium">{{ __('Cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
