<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-6 sm:-my-px sm:ms-8 sm:flex sm:items-center">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="whitespace-nowrap">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    {{-- Super Admin only: Peternakan (unchanged) --}}
                    @can('viewAny', App\Models\Farm::class)
                        <x-nav-link :href="route('farms.index')" :active="request()->routeIs('farms.*')" class="whitespace-nowrap">
                            {{ __('Peternakan') }}
                        </x-nav-link>
                    @endcan

                    {{-- Data Operasional dropdown (Sapi, Kesehatan, Produksi Susu, Pakan, Catatan Pakan) --}}
                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-farm-green hover:bg-farm-cream focus:outline-none transition ease-in-out duration-150 whitespace-nowrap {{ request()->routeIs(['cows.*','health-records.*','milk-records.*','feeds.*','feed-records.*']) ? 'text-farm-green' : '' }}">
                                    <div>{{ __('Data Operasional') }}</div>

                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('cows.index')" :active="request()->routeIs('cows.*')" class="whitespace-nowrap">
                                    {{ __('Sapi') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('health-records.index')" :active="request()->routeIs('health-records.*')" class="whitespace-nowrap">
                                    {{ __('Kesehatan') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('milk-records.index')" :active="request()->routeIs('milk-records.*')" class="whitespace-nowrap">
                                    {{ __('Produksi Susu') }}
                                </x-dropdown-link>
                                @can('viewAny', App\Models\Feed::class)
                                    <x-dropdown-link :href="route('feeds.index')" :active="request()->routeIs('feeds.*')" class="whitespace-nowrap">
                                        {{ __('Pakan') }}
                                    </x-dropdown-link>
                                @endcan
                                @can('viewAny', App\Models\FeedRecord::class)
                                    <x-dropdown-link :href="route('feed-records.index')" :active="request()->routeIs('feed-records.*')" class="whitespace-nowrap">
                                        {{ __('Catatan Pakan') }}
                                    </x-dropdown-link>
                                @endcan
                            </x-slot>
                        </x-dropdown>
                    </div>

                    {{-- Manajemen dropdown (Peternakan Saya, Jenis, Staf) --}}
                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-farm-green hover:bg-farm-cream focus:outline-none transition ease-in-out duration-150 whitespace-nowrap {{ request()->routeIs(['my-farm','breeds.*','staff.*']) ? 'text-farm-green' : '' }}">
                                    <div>{{ __('Manajemen') }}</div>

                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                @cannot('viewAny', App\Models\Farm::class)
                                    <x-dropdown-link :href="route('my-farm')" :active="request()->routeIs('my-farm')" class="whitespace-nowrap">
                                        {{ __('Peternakan Saya') }}
                                    </x-dropdown-link>
                                @endcannot
                                @can('viewAny', App\Models\Breed::class)
                                    <x-dropdown-link :href="route('breeds.index')" :active="request()->routeIs('breeds.*')" class="whitespace-nowrap">
                                        {{ __('Jenis') }}
                                    </x-dropdown-link>
                                @endcan
                                @if(Auth::user()->isAdminFarm())
                                    <x-dropdown-link :href="route('staff.index')" :active="request()->routeIs('staff.*')" class="whitespace-nowrap">
                                        {{ __('Staf') }}
                                    </x-dropdown-link>
                                @endif
                            </x-slot>
                        </x-dropdown>
                    </div>

                    {{-- Transaksi (direct) --}}
                    @can('viewAny', App\Models\Transaction::class)
                        <x-nav-link :href="route('transactions.index')" :active="request()->routeIs('transactions.*')" class="whitespace-nowrap">
                            {{ __('Transaksi') }}
                        </x-nav-link>
                    @endcan

                    {{-- Reports dropdown (unchanged) --}}
                    @can('viewAny', App\Models\Report::class)
                        <div class="hidden sm:flex sm:items-center">
                            <x-dropdown align="left" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150 whitespace-nowrap">
                                        <div>{{ __('Laporan') }}</div>

                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('reports.financial')" :active="request()->routeIs('reports.financial')" class="whitespace-nowrap">
                                        {{ __('Laporan Keuangan') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('reports.production')" :active="request()->routeIs('reports.production')" class="whitespace-nowrap">
                                        {{ __('Laporan Produksi') }}
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endcan
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="whitespace-nowrap">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            {{-- Super Admin only: Peternakan (unchanged) --}}
            @can('viewAny', App\Models\Farm::class)
                <x-responsive-nav-link :href="route('farms.index')" :active="request()->routeIs('farms.*')" class="whitespace-nowrap">
                    {{ __('Peternakan') }}
                </x-responsive-nav-link>
            @endcan
        </div>

        {{-- Data Operasional section --}}
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-farm-green">{{ __('Data Operasional') }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('cows.index')" :active="request()->routeIs('cows.*')" class="whitespace-nowrap">
                    {{ __('Sapi') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('health-records.index')" :active="request()->routeIs('health-records.*')" class="whitespace-nowrap">
                    {{ __('Kesehatan') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('milk-records.index')" :active="request()->routeIs('milk-records.*')" class="whitespace-nowrap">
                    {{ __('Produksi Susu') }}
                </x-responsive-nav-link>
                @can('viewAny', App\Models\Feed::class)
                    <x-responsive-nav-link :href="route('feeds.index')" :active="request()->routeIs('feeds.*')" class="whitespace-nowrap">
                        {{ __('Pakan') }}
                    </x-responsive-nav-link>
                @endcan
                @can('viewAny', App\Models\FeedRecord::class)
                    <x-responsive-nav-link :href="route('feed-records.index')" :active="request()->routeIs('feed-records.*')" class="whitespace-nowrap">
                        {{ __('Catatan Pakan') }}
                    </x-responsive-nav-link>
                @endcan
            </div>
        </div>

        {{-- Manajemen section --}}
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-farm-green">{{ __('Manajemen') }}</div>
            </div>

            <div class="mt-3 space-y-1">
                @cannot('viewAny', App\Models\Farm::class)
                    <x-responsive-nav-link :href="route('my-farm')" :active="request()->routeIs('my-farm')" class="whitespace-nowrap">
                        {{ __('Peternakan Saya') }}
                    </x-responsive-nav-link>
                @endcannot
                @can('viewAny', App\Models\Breed::class)
                    <x-responsive-nav-link :href="route('breeds.index')" :active="request()->routeIs('breeds.*')" class="whitespace-nowrap">
                        {{ __('Jenis') }}
                    </x-responsive-nav-link>
                @endcan
                @if(Auth::user()->isAdminFarm())
                    <x-responsive-nav-link :href="route('staff.index')" :active="request()->routeIs('staff.*')" class="whitespace-nowrap">
                        {{ __('Staf') }}
                    </x-responsive-nav-link>
                @endif
            </div>
        </div>

        {{-- Transaksi (direct) --}}
        @can('viewAny', App\Models\Transaction::class)
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('transactions.index')" :active="request()->routeIs('transactions.*')" class="whitespace-nowrap">
                        {{ __('Transaksi') }}
                    </x-responsive-nav-link>
                </div>
            </div>
        @endcan

        {{-- Reports section (unchanged) --}}
        @can('viewAny', App\Models\Report::class)
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ __('Laporan') }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('reports.financial')" :active="request()->routeIs('reports.financial')" class="whitespace-nowrap">
                    {{ __('Laporan Keuangan') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('reports.production')" :active="request()->routeIs('reports.production')" class="whitespace-nowrap">
                    {{ __('Laporan Produksi') }}
                </x-responsive-nav-link>
            </div>
        </div>
        @endcan

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>