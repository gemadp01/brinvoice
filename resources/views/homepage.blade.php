<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-100 dark:bg-gray-900">

    <header class="w-full h-24 dark:bg-gray-800 mx-auto">
        <nav x-data="{ open: false }" class="max-w-5xl mx-auto h-full flex justify-between items-center">

            <div class="w-full flex justify-between items-center ms-6">
                <a href="{{ route('dashboard') }}" class="flex items-center">
                    <img src="{{ asset('storage/main-logo/brinvoice.png') }}" class="w-12" alt="">
                    <h1 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">Brinvoice.</h1>
                </a>

                <div class="hidden sm:block sm:space-x-3 sm:mr-4">
                    <x-secondary-button>
                        <a href="{{ route('login') }}">Login</a>
                    </x-secondary-button>
                    <x-primary-button>
                        <a href="{{ route('register') }}">Daftar</a>
                    </x-primary-button>
                </div>
                <!-- Settings Dropdown -->
                @if(auth()->user())
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('dashboard')">
                                {{ __('Dashboard') }}
                            </x-dropdown-link>
                                <x-dropdown-link :href="route('profile.edit')" class="border-t border-gray-200 dark:border-gray-600">
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
                @endif

                <!-- Hamburger -->
                <div class="flex items-center sm:hidden relative">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <!-- Responsive Navigation Menu -->
                <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden absolute right-4 top-[68px] bg-gray-700 rounded-md ">
                    <div class="pt-2 pb-3 space-y-1">
                        <x-responsive-nav-link :href="route('login')">
                            {{ __('Login') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('register')">
                            {{ __('Daftar') }}
                        </x-responsive-nav-link>
                    </div>
                    @if(auth()->user())
                    <div class="pt-2 pb-3 space-y-1">
                        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-responsive-nav-link>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
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
                    @endif
                </div>
            </div>

        </nav>
    </header>

    <!-- Hero Section -->
    <section class="py-20 px-6 text-center">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-gray-800 dark:text-gray-200 text-4xl font-bold mb-4">Buat & Kirim Invoice Profesional Dalam Hitungan Detik</h1>
            <p class="text-lg text-gray-500 mb-6">
                Sesuaikan brand, pilih format invoice, unduh PDF, dan kirim ke email pelanggan. Tanpa ribet.
            </p>
            <div class="flex justify-center gap-4">
                <x-primary-button>
                    <a href="{{ route('register') }}" class="py-3 px-6 text-base">Coba Gratis Sekarang</a>
                </x-primary-button>
            </div>
        </div>
    </section>

    <!-- Fitur Section -->
    <section class="py-20 dark:bg-gray-800 px-6">
        <div class="max-w-5xl mx-auto text-center grid md:grid-cols-2 gap-12">
            <div class="md:col-span-2">
                <h1 class="text-gray-800 dark:text-gray-200 text-4xl font-bold">Features</h1>
            </div>
            <div>
                <h2 class="text-gray-800 dark:text-gray-200 text-2xl font-semibold mb-4">🔧 Custom Brand / Usaha</h2>
                <p class="text-gray-800 dark:text-gray-400">Tambahkan logo, nama usaha, dan kontak di invoice Anda secara profesional.</p>
            </div>
            <div>
                <h2 class="text-gray-800 dark:text-gray-200 text-2xl font-semibold mb-4">🧾 Custom Format Invoice</h2>
                <p class="text-gray-800 dark:text-gray-400">Satu brand bisa punya banyak template: penjualan, layanan, dan lainnya.</p>
            </div>
            <div>
                <h2 class="text-gray-800 dark:text-gray-200 text-2xl font-semibold mb-4">📄 Generate PDF</h2>
                <p class="text-gray-800 dark:text-gray-400">Invoice langsung bisa diunduh dalam format PDF siap cetak atau kirim.</p>
            </div>
            <div>
                <h2 class="text-gray-800 dark:text-gray-200 text-2xl font-semibold mb-4">📩 Kirim via Email</h2>
                <p class="text-gray-800 dark:text-gray-400">Kirim invoice langsung ke pelanggan, tanpa perlu buka email manual.</p>
            </div>
        </div>
    </section>

    <!-- Demo Screenshot Section -->
    <section class="py-20 px-6">
        <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-gray-800 dark:text-gray-200 text-3xl font-bold mb-6">Lihat Tampilan Invoice Anda</h2>
        <p class="text-gray-800 dark:text-gray-400 mb-8">Berbagai format, desain bersih, dan mudah digunakan.</p>
        <div class="w-full bg-gray-200 h-64 rounded-xl flex items-center justify-center text-gray-500">
            (Gambar demo invoice di sini)
        </div>
        </div>
    </section>

    <!-- Testimoni -->
    <section class="py-20 bg-gray-800 px-6">
        <div class="max-w-3xl mx-auto text-center">
        <blockquote class="text-xl italic text-gray-800 dark:text-gray-200 mb-4">“Sekarang ngirim invoice ke klien jadi 5x lebih cepat. Tampilan juga lebih profesional.”</blockquote>
        <p class="text-gray-800 dark:text-gray-400">— Rizky, Freelancer Desain</p>
        </div>
    </section>

    <!-- CTA Akhir -->
    <section class="py-20 text-center px-6">
        <div class="max-w-xl mx-auto">
        <h2 class="text-3xl font-bold mb-4 text-gray-800 dark:text-gray-200">Siap Buat Invoice Profesional?</h2>
        <p class="mb-6 text-gray-800 dark:text-gray-400">Mulai gratis hari ini dan kirim invoice pertama Anda hanya dalam hitungan menit.</p>
        <x-secondary-button>
            <a href="{{ route('register') }}" class="py-3 px-6 text-base">Daftar Gratis Sekarang</a>
        </x-secondary-button>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-10 px-6 bg-gray-800 text-gray-800 dark:text-gray-500 text-center">
        <p class="text-sm">© 2025 – Made with ❤️ by Gema Dodi Pranata</p>
    </footer>

    </body>
</html>
