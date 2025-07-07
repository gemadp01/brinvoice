@props([
    'disabled' => false,
    'prefix' => null,
])

<div class="flex items-stretch w-full">
    @if ($prefix)
        <span class="flex-shrink-0 inline-flex items-center px-2 py-0 text-base text-gray-500 bg-gray-100 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600">
            {{ $prefix }}
        </span>
    @endif

    <input
        @disabled($disabled)
        {{ $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm text-base' . ($prefix ? 'flex-1 rounded-r-md rounded-l-none' : 'w-full rounded-md')
        ]) }}
    >
</div>
