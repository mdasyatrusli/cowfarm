<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-farm-green leading-tight">
            {{ __('Edit Transaction') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-farm-cream min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('transactions.update', $transaction) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="type" :value="__('Tipe Transaksi')" />
                            <select id="type" name="type" class="border-gray-300 focus:border-farm-green focus:ring-farm-green rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="">{{ __('Select Type') }}</option>
                                <option value="income" {{ old('type', $transaction->type) === 'income' ? 'selected' : '' }}>Pemasukan</option>
                                <option value="expense" {{ old('type', $transaction->type) === 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="category" :value="__('Category')" />
                            <input
                                list="category-suggestions"
                                id="category"
                                class="border-gray-300 focus:border-farm-green focus:ring-farm-green rounded-md shadow-sm block mt-1 w-full"
                                type="text"
                                name="category"
                                value="{{ old('category', $transaction->category) }}"
                                required
                                placeholder="{{ __('e.g. Penjualan Susu') }}"
                            />
                            <datalist id="category-suggestions">
                                <option value="Penjualan Susu">
                                <option value="Penjualan Sapi">
                                <option value="Pembelian Pakan">
                                <option value="Biaya Kesehatan">
                                <option value="Gaji Staff">
                                <option value="Lainnya">
                            </datalist>
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="amount" :value="__('Amount (Rp)')" />
                            <x-text-input
                                id="amount"
                                class="block mt-1 w-full focus:border-farm-green focus:ring-farm-green"
                                type="number"
                                step="0.01"
                                min="0.01"
                                name="amount"
                                :value="old('amount', $transaction->amount)"
                                required
                                placeholder="{{ __('e.g. 500000') }}"
                            />
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea
                                id="description"
                                name="description"
                                rows="4"
                                class="border-gray-300 focus:border-farm-green focus:ring-farm-green rounded-md shadow-sm block mt-1 w-full"
                                placeholder="{{ __('Optional notes about this transaction') }}"
                            >{{ old('description', $transaction->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="transaction_date" :value="__('Transaction Date')" />
                            <x-text-input
                                id="transaction_date"
                                class="block mt-1 w-full focus:border-farm-green focus:ring-farm-green"
                                type="date"
                                name="transaction_date"
                                :value="old('transaction_date', $transaction->transaction_date->format('Y-m-d'))"
                                required
                            />
                            <x-input-error :messages="$errors->get('transaction_date')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('transactions.index') }}" class="text-sm text-farm-brown hover:text-yellow-900 mr-4">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-farm-green border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-800 focus:bg-green-800 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-farm-green focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Update Transaction') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
