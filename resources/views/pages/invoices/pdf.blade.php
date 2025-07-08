<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $invoice->invoice_code }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        {{-- <link rel="stylesheet" href="{{ public_path('build/assets/app.css') }}"> --}}
    </head>
    <body class="font-sans antialiased">
        <main>
            <div class="p-24 bg-white">
                {{-- tanggal cetak --}}
                <div class="flex justify-end text-black mb-6">
                    <p class="text-xs text-end italic">Tanggal Cetak : {{ now()->translatedFormat('d/m/Y, H.i') }}</p>
                </div>

                {{-- header logo & invoice code --}}
                <div class="flex justify-between items-start text-black mb-6">
                    <img src="{{ public_path('storage/' . $invoice->user->brand_logo_path) }}" alt="{{ $invoice->user->brand_name }}" class="h-16">
                    <div class="self-start">
                        <p class="text-base text-end font-bold">INVOICE</p>
                        <p class="text-sm text-end text-indigo-600">{{ $invoice->invoice_code }}</p>
                    </div>
                </div>

                {{-- pengirim dan penerima --}}
                <div class="grid grid-cols-2 gap-6 mb-6">
                    {{-- pengirim --}}
                    <div>
                        <div>
                            <p class="text-base font-semibold text-black">{{ $invoice->invoice_formats->sender_title }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4 items-center mt-2">
                            <div>
                                <p class="text-base text-black">{{ $invoice->invoice_formats->sender_label }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">: <span class="text-black font-semibold">{{ $invoice->user->brand_name }}</span></p>
                            </div>
                        </div>
                    </div>

                    {{-- penerima --}}
                    <div>
                        <div>
                            <p class="text-base font-semibold text-black">{{ $invoice->invoice_formats->receiver_title }}</p>
                        </div>
                        <div class="grid grid-cols-5 gap-4 items-start mt-2">
                            <div class="col-span-2">
                                <p class="text-base text-black">{{ $invoice->invoice_formats->receiver_label }}</p>
                            </div>
                            <div class="col-span-3">
                                <p class="text-base font-semibold text-black">
                                    {{ $invoice->receiver }}
                                    (<span class="font-normal">{{ $invoice->receiver_email }}</span>)
                                </p>
                            </div>
                        </div>
                        <div class="grid grid-cols-5 gap-4 items-center mt-2">
                            <div class="col-span-2">
                                <p class="text-base text-black">{{ $invoice->invoice_formats->invoice_date_label }}</p>
                            </div>
                            <div class="col-span-3">
                                <p class="text-base font-semibold text-black">
                                    {{ $invoice->invoice_date->translatedFormat('d F Y') }}
                                </p>
                            </div>
                        </div>
                        <div class="grid grid-cols-5 gap-4 items-start mt-2">
                            <div class="col-span-2">
                                <p class="text-base text-black">{{ $invoice->invoice_formats->invoice_address_label }}</p>
                            </div>
                            <div class="col-span-3">
                                <p class="text-base text-black">
                                    {{ $invoice->invoice_address }}
                                </p>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- tabel --}}
                <div class="grid grid-cols-11 gap-4 items-center mt-2 border-y py-2 border-gray-900">
                    <div class="col-span-4">
                        <p class="text-base font-semibold text-black">{{ $invoice->invoice_formats->item_label }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-base font-semibold text-black text-end">{{ $invoice->invoice_formats->quantity_label }}</p>
                    </div>
                    <div class="col-span-3">
                        <p class="text-base font-semibold text-black text-end">{{ $invoice->invoice_formats->price_label }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-base font-semibold text-black text-end">{{ $invoice->invoice_formats->price_total_label }}</p>
                    </div>
                </div>

                {{-- items --}}
                <div id="item-list" class="edit-invoice">
                    @foreach($invoice->items as $item)
                    <div class="item-row grid grid-cols-11 gap-4 py-2 border-b border-gray-200">
                        <div class="col-span-4 text-indigo-600 font-semibold">{{ $item->name }}</div>
                        <div class="col-span-2 text-end">{{ $item->quantity }}</div>
                        <div class="col-span-3 text-end">Rp{{ number_format($item->price, 0, ',', '.') }}</div>
                        <div class="col-span-2 text-end">Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</div>
                    </div>
                    @endforeach
                </div>

                {{-- footer total --}}
                <div class="grid grid-cols-2 gap-4 py-2">
                    <div class="col-start-2 col-span-1">

                        {{-- subtotal --}}
                        <div class="grid grid-cols-10 gap-4 border-b border-gray-200 py-2">
                            <div class="col-span-6">
                                <p class="text-base font-semibold text-black">{{ $invoice->invoice_formats->subtotal_label }}</p>
                            </div>
                            <div class="col-span-4 font-semibold text-end">Rp{{ number_format($invoice->subtotal, 0, ',', '.') }}</div>
                        </div>

                        {{-- additional --}}
                        <div class="grid grid-cols-10 gap-4 border-b border-gray-200 py-2">
                            {{-- diskon --}}
                            @if( $invoice->invoice_formats->discount_label )
                            <div class="col-span-6">
                                <p class="text-base text-black">{{ $invoice->invoice_formats->discount_label }}</p>
                            </div>
                            <div class="col-span-4 text-end">Rp{{ number_format($invoice->discount, 0, ',', '.') }}</div>
                            @endif

                            {{-- ongkos kirim --}}
                            @if( $invoice->invoice_formats->shipment_label )
                            <div class="col-span-7">
                                <p class="text-base text-black">{{ $invoice->invoice_formats->shipment_label }}</p>
                            </div>
                            <div class="col-span-3 text-end">Rp{{ number_format($invoice->shipment, 0, ',', '.') }}</div>
                            @endif

                            {{-- biaya pajak --}}
                            @if( $invoice->invoice_formats->tax_label )
                            <div class="col-span-7">
                                <p class="text-base text-black">{{ $invoice->invoice_formats->tax_label }}</p>
                            </div>
                            <div class="col-span-3 text-end">Rp{{ number_format($invoice->tax, 0, ',', '.') }}</div>
                            @endif

                            {{-- biaya pelayanan --}}
                            @if( $invoice->invoice_formats->service_label )
                            <div class="col-span-7">
                                <p class="text-base text-black">{{ $invoice->invoice_formats->service_label }}</p>
                            </div>
                            <div class="col-span-3 text-end">Rp{{ number_format($invoice->service, 0, ',', '.') }}</div>
                            @endif
                        </div>

                        {{-- subtotal --}}
                        <div class="grid grid-cols-10 gap-4 items-center py-2 border-b border-gray-200">
                            <div class="col-span-6">
                                <p class="text-base font-semibold text-black">{{ $invoice->invoice_formats->bil_total_label }}</p>
                            </div>
                            <div class="col-span-4 font-semibold text-end">Rp{{ number_format($invoice->bil_total, 0, ',', '.') }}</div>
                        </div>

                    </div>
                </div>

                {{-- payment --}}
                <div class="grid grid-cols-2 gap-4 py-2 mb-6">
                    <div class="col-start-2 col-span-1">
                        <div>
                            <p class="text-base text-black">{{ $invoice->invoice_formats->payment_method_label }}</p>
                        </div>
                        <div>
                            <p class="text-base text-black">{{ $invoice->invoice_formats->payment_method_name }}</p>
                        </div>
                        <div>
                            <p class="text-base text-black">{{ $invoice->invoice_formats->payment_method_number }}</p>
                        </div>
                    </div>
                </div>

                {{-- terakhir diupdate --}}
                <p class="text-xs italic text-black text-start">Terakhir diupdate: {{ $invoice->updated_at->translatedFormat('d/m/Y, H.i') }} WIB</p>


            </div>
        </main>
    </body>
</html>
