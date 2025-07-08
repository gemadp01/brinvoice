<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Invoice') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <h2 class="text-lg font-medium text-black dark:text-white mb-4">
                    {{ __('Buat Invoice Baru') }}
                </h2>

                <form action="{{ route('invoices.create' ) }}" method="GET">
                    <label for="invoice_format" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pilih Format Invoice</label>
                    <div class="flex w-full">

                        <select id="invoice_format" name="invoice_format" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-800  dark:text-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm rounded-l-md rounded-r-none py-2 px-3" required>
                            <option value="" disabled selected>Pilih salah satu...</option>
                            @foreach ($invoiceFormats as $format)
                            <option value="{{ $format->slug }}">{{ $format->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class=" flex-shrink-0 inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold border border-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 rounded-r-md  rounded-l-none -ml-px">Buat Sekarang</button>
                    </div>
                </form>
            </div>
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex justify-between">
                    <h2 class="text-lg font-medium text-black dark:text-white mb-4">
                        {{ __('Daftar Invoice') }}
                    </h2>
                    @if( session('status') )
                    <p class="text-gray-500 dark:text-gray-400 text-center">{{ session('status') }}</p>
                    @endif
                </div>
                @if( $invoices->isEmpty() )
                <p class="text-gray-500 dark:text-gray-400 text-center">Anda belum memiliki invoice. Silakan buat baru.</p>
                @else
                <div class="flex flex-col">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                        <div class="overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                            <thead>
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Kode Invoice</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Customer/Client</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Tanggal Invoice</th>
                                    <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase dark:text-neutral-500"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoices as $invoice)
                                <tr class="odd:bg-white even:bg-gray-100 dark:odd:bg-neutral-900 dark:even:bg-neutral-800">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">{{ $invoice->invoice_code }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">{{ $invoice->receiver }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">{{ $invoice->invoice_date->translatedFormat('d/m/Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        <a href="{{ route('invoices.edit', $invoice->invoice_code) }}" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-hidden focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400 dark:focus:text-blue-400 me-2">
                                            Detail / Ubah
                                        </a>
                                        |
                                        <a href="{{ route('invoices.pdf', $invoice->invoice_code) }}" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-indigo-600 hover:text-indigo-800 focus:outline-hidden focus:text-indigo-800 disabled:opacity-50 disabled:pointer-events-none dark:text-indigo-500 dark:hover:text-indigo-400 dark:focus:text-indigo-400 ms-2">
                                            Lihat PDF
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
