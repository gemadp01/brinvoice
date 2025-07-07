<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex {{ $formats->isEmpty() || session('status') ? 'justify-between' : 'justify-end' }} items-center">
                    @if( $formats->isEmpty() )
                    <p class="text-gray-500 dark:text-gray-400 text-center">Anda belum memiliki format invoice. Silakan buat format baru.</p>
                    @endif
                    @if( session('status') )
                    <p class="text-gray-500 dark:text-gray-400 text-center">{{ session('status') }}</p>
                    @endif
                    <a href="{{ route('formats.create') }}" class="inline-flex items-center px-4 py-2 text-sm bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 duration-300">
                        {{ __('Buat Format Baru') }}
                    </a>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 mt-6">
                    @foreach($formats as $format)
                        <a href="{{ route('formats.edit', $format->slug) }}" class="bg-white dark:bg-gray-800 rounded-lg border border-gray-700 shadow p-4 duration-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $format->name }}</h3>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
