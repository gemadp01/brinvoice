<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Buat Invoice ' . $format->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if( session('status') )
            <div class="p-2 sm:p-4 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <p class="text-gray-500 dark:text-gray-400 text-center">{{ session('status') }}</p>
            </div>
            @endif
            <form method="post" action="{{ route('invoices.update', $invoice->invoice_code) }}" class="space-y-6 w-full">
                @csrf
                @method('put')
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">

                    {{-- tanggal cetak --}}
                    <div class="flex justify-end text-black dark:text-white mb-6">
                        <p class="text-xs text-end italic">Tanggal Cetak : {{ now()->translatedFormat('d/m/Y, H.i') }}</p>
                    </div>

                    {{-- header logo & invoice code --}}
                    <div class="flex justify-between items-start text-black dark:text-white mb-6">
                        <img src="{{ asset('storage/' . auth()->user()->brand_logo_path) }}"
                            alt="{{ auth()->user()->brand_name }}" class="h-16">
                        <div class="self-start">
                            <p class="text-base text-end font-bold">INVOICE</p>
                            <p class="text-sm text-end text-indigo-600">{{ $invoice->invoice_code }}</p>
                        </div>
                    </div>

                    {{-- pengirim dan penerima --}}
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                        {{-- pengirim --}}
                        <div>
                            <div>
                                <p class="text-base font-semibold text-black dark:text-white">{{ $format->sender_title }}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-4 items-center mt-2">
                                <div>
                                    <p class="text-base text-black dark:text-white">{{ $format->sender_label }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 dark:text-gray-400">: <span class="text-black dark:text-white font-semibold">{{ auth()->user()->brand_name }}</span></p>
                                </div>
                            </div>
                        </div>

                        {{-- penerima --}}
                        <div>
                            <div>
                                <p class="text-base font-semibold text-black dark:text-white">{{ $format->receiver_title }}</p>
                            </div>
                            <div class="grid grid-cols-5 gap-4 items-start mt-2">
                                <div class="col-span-2">
                                    <p class="text-base text-black dark:text-white">{{ $format->receiver_label }}</p>
                                </div>
                                <div class="col-span-3">
                                    <x-text-input id="receiver" name="receiver" type="text" class="py-1 w-full" :value="old('receiver', $invoice->receiver)" required placeholder="Isi nama {{ strtolower($format->receiver_label) }}" autofocus autocomplete="receiver"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('receiver')" />
                                    <x-text-input id="receiver_email" name="receiver_email" type="email" class="py-1 w-full" :value="old('receiver_email', $invoice->receiver_email)" required placeholder="Isi email {{ strtolower($format->receiver_label) }}" autofocus autocomplete="receiver_email"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('receiver_email')" />
                                </div>
                            </div>
                            <div class="grid grid-cols-5 gap-4 items-center mt-2">
                                <div class="col-span-2">
                                    <p class="text-base text-black dark:text-white">{{ $format->invoice_date_label }}</p>
                                </div>
                                <div class="col-span-3">
                                    <x-text-input id="invoice_date" name="invoice_date" type="date" class="py-1 w-full" :value="old('invoice_date', $invoice->invoice_date->format('Y-m-d'))" required autofocus autocomplete="invoice_date"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('invoice_date')" />
                                </div>
                            </div>
                            <div class="grid grid-cols-5 gap-4 items-start mt-2">
                                <div class="col-span-2">
                                    <p class="text-base text-black dark:text-white">{{ $format->invoice_address_label }}</p>
                                </div>
                                <div class="col-span-3">
                                    <x-textarea id="invoice_address" name="invoice_address" type="text" class="mt-1 block w-full" autofocus autocomplete="invoice_address" :value="old('invoice_address', $invoice->invoice_address)" placeholder="Isi alamat {{ strtolower($format->invoice_address) }}" />
                                    <x-input-error class="mt-2" :messages="$errors->get('invoice_address')" />
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- tabel --}}
                    <div class="grid grid-cols-12 gap-4 items-center mt-2 border-y py-2 border-gray-900 dark:border-gray-600">
                        <div class="col-span-5">
                            <p class="text-base font-semibold text-black dark:text-white">{{ $format->item_label }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-base font-semibold text-black dark:text-white text-end">{{ $format->quantity_label }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-base font-semibold text-black dark:text-white text-end">{{ $format->price_label }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-base font-semibold text-black dark:text-white text-end">{{ $format->price_total_label }}</p>
                        </div>
                    </div>

                    {{-- items --}}
                    <div id="item-list" class="edit-invoice">
                        <div class="item-row grid grid-cols-12 gap-4 py-2 border-b border-gray-200 dark:border-gray-700 {{ $invoice->items->count() > 0 ? 'hidden' : '' }}" id="item-template">
                            <div class="col-span-5">
                                <x-text-input id="name" name="name[]" type="text" class="py-1 w-full" :value="old('name', '')"  autofocus autocomplete="name" placeholder="Isi nama {{ strtolower($format->item_label) }}"/>
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>
                            <div class="col-span-2">
                                <x-text-input name="quantity[]" type="number" class="py-1 w-full quantity" :value="old('quantity')"  autofocus autocomplete="quantity" placeholder="Isi {{ strtolower($format->quantity_label) }}"/>
                                <x-input-error class="mt-2" :messages="$errors->get('quantity')" />
                            </div>
                            <div class="col-span-2">
                                <x-text-input-prefix prefix="Rp" name="price[]" type="number" class="py-1 w-full price" :value="old('price')"  placeholder="Isi {{ strtolower($format->price_label) }}" autofocus autocomplete="price"/>
                                <x-input-error class="mt-2" :messages="$errors->get('price')" />
                            </div>
                            <div class="col-span-2">
                                <x-text-input-prefix prefix="Rp" type="text" class="py-1 w-full item_price_total" :value="0" autofocus disabled/>
                            </div>
                            <div class="col-span-1 flex justify-end">
                                <button type="button" class="remove-item-btn text-red-500 hover:text-red-700 dark:hover:text-red-400 p-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        </div>

                        @foreach($invoice->items as $item)
                        <div class="item-row grid grid-cols-12 gap-4 py-2 border-b border-gray-200 dark:border-gray-700">
                            <div class="col-span-5">
                                <x-text-input id="name" name="name[]" type="text" class="py-1 w-full" :value="old('name', $item->name)" required autofocus autocomplete="name" placeholder="Isi nama {{ strtolower($format->item_label) }}"/>
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>
                            <div class="col-span-2">
                                <x-text-input name="quantity[]" type="number" class="py-1 w-full quantity" :value="old('quantity', $item->quantity)" required autofocus autocomplete="quantity" placeholder="Isi {{ strtolower($format->quantity_label) }}"/>
                                <x-input-error class="mt-2" :messages="$errors->get('quantity')" />
                            </div>
                            <div class="col-span-2">
                                <x-text-input-prefix prefix="Rp" name="price[]" type="number" class="py-1 w-full price" :value="old('price', $item->price)" required placeholder="Isi {{ strtolower($format->price_label) }}" autofocus autocomplete="price"/>
                                <x-input-error class="mt-2" :messages="$errors->get('price')" />
                            </div>
                            <div class="col-span-2">
                                <x-text-input-prefix prefix="Rp" type="text" class="py-1 w-full item_price_total" :value=" $item->quantity * $item->price" autofocus disabled/>
                            </div>
                            <div class="col-span-1 flex justify-end">
                                <button type="button" class="remove-item-btn text-red-500 hover:text-red-700 dark:hover:text-red-400 p-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="grid grid-cols-10 gap-4 py-2 border-b border-gray-200 dark:border-gray-700">
                        <div class="col-span-5">
                            <p class="text-base font-medium text-indigo-600 cursor-pointer" id="add-item">+ tambah item</p>
                        </div>
                    </div>

                    {{-- footer total --}}
                    <div class="grid grid-cols-2 gap-4 py-2 border-b border-gray-200 dark:border-gray-700">
                        <div class="col-start-2 col-span-1">

                            {{-- subtotal --}}
                            <div class="grid grid-cols-10 gap-4 items-center border-b border-gray-200 dark:border-gray-700 py-2">
                                <div class="col-span-6">
                                    <p class="text-base font-semibold text-black dark:text-white">{{ $format->subtotal_label }}</p>
                                </div>
                                <div class="col-span-4">
                                    <x-text-input-prefix disabled prefix="Rp" id="subtotal" type="text" class="py-1 w-full" :value="$invoice->subtotal" placeholder="Isi {{ strtolower($format->subtotal_label) }}" autofocus autocomplete="subtotal"/>
                                </div>
                            </div>

                            {{-- additional --}}
                            <div class="grid grid-cols-10 gap-x-4 gap-y-1 items-center border-b border-gray-200 dark:border-gray-700 py-2">
                                {{-- diskon --}}
                                @if( $format->discount_label )
                                <div class="col-span-6">
                                    <p class="text-base text-black dark:text-white">{{ $format->discount_label }}</p>
                                </div>
                                <div class="col-span-4">
                                    <x-text-input-prefix prefix="-Rp" id="discount" name="discount" type="number" class="py-1 w-full" :value="old('discount', $invoice->discount)" placeholder="Isi {{ strtolower($format->discount_label) }}" autofocus autocomplete="discount"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('discount')" />
                                </div>
                                @endif

                                {{-- ongkos kirim --}}
                                @if( $format->shipment_label )
                                <div class="col-span-6">
                                    <p class="text-base text-black dark:text-white">{{ $format->shipment_label }}</p>
                                </div>
                                <div class="col-span-4">
                                    <x-text-input-prefix prefix="Rp" id="shipment" name="shipment" type="number" class="py-1 w-full" :value="old('shipment', $invoice->shipment)" placeholder="Isi {{ strtolower($format->shipment_label) }}" autofocus autocomplete="shipment"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('shipment')" />
                                </div>
                                @endif

                                {{-- biaya pajak --}}
                                @if( $format->tax_label )
                                <div class="col-span-6">
                                    <p class="text-base text-black dark:text-white">{{ $format->tax_label }}</p>
                                </div>
                                <div class="col-span-4">
                                    <x-text-input-prefix prefix="Rp" id="tax" name="tax" type="number" class="py-1 w-full" :value="old('tax', $invoice->tax)" placeholder="Isi {{ strtolower($format->tax_label) }}" autofocus autocomplete="tax"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('tax')" />
                                </div>
                                @endif

                                {{-- biaya pelayanan --}}
                                @if( $format->service_label )
                                <div class="col-span-6">
                                    <p class="text-base text-black dark:text-white">{{ $format->service_label }}</p>
                                </div>
                                <div class="col-span-4">
                                    <x-text-input-prefix prefix="Rp" id="service" name="service" type="number" class="py-1 w-full" :value="old('service', $invoice->service)" placeholder="Isi {{ strtolower($format->service_label) }}" autofocus autocomplete="service"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('service')" />
                                </div>
                                @endif
                            </div>

                            {{-- subtotal --}}
                            <div class="grid grid-cols-10 gap-4 items-center py-2">
                                <div class="col-span-6">
                                    <p class="text-base font-semibold text-black dark:text-white">{{ $format->bill_total_label }}</p>
                                </div>
                                <div class="col-span-4">
                                    <x-text-input-prefix disabled prefix="Rp" id="bill_total" type="text" class="py-1 w-full" :value="$invoice->bill_total" placeholder="Isi {{ strtolower($format->bill_total_label) }}" autofocus autocomplete="bill_total"/>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- payment --}}
                    <div class="grid grid-cols-2 gap-4 py-2 mb-6">
                        <div class="col-start-2 col-span-1">
                            <div>
                                <p class="text-base text-black dark:text-white">{{ $format->payment_method_label }}</p>
                            </div>
                            <div>
                                <p class="text-base text-black dark:text-white">{{ $format->payment_method_name }}</p>
                            </div>
                            <div>
                                <p class="text-base text-black dark:text-white">{{ $format->payment_method_number }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- terakhir diupdate --}}
                    <p class="text-xs italic text-black dark:text-white">Terakhir diupdate: {{ $invoice->updated_at->translatedFormat('d/m/Y, H.i') }} WIB</p>


                </div>
                <div class="flex items-center gap-4 mt-6">
                    <x-primary-button>{{ __('Simpan Perubahan Invoice') }}</x-primary-button>
                </div>
            </form>
            <hr class="my-5">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-full">
                    <section class="space-y-6">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Kirim Email Invoice') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Pastikan data sudah benar dan terbarui sebelum mengirimkan invoice ke email') }}
                            </p>
                        </header>
                        {{-- <form action="{{ route('invoices.send', $invoice->invoice_code) }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-600  focus:bg-indigo-600 active:bg-indigo-700   focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Kirim Email ke {{ $invoice->receiver }}</button>
                        </form> --}}
                    </section>
                </div>
            </div>
            <hr class="my-5">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-full">
                    <section class="space-y-6">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Hapus Invoice') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Setelah invoice terhapus, informasi invoice beserta semua items akan ikut terhapus dan tidak bisa dikembalikan.') }}
                            </p>
                        </header>

                        <x-danger-button
                            x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-delete-invoice')"
                        >{{ __('Hapus Invoice') }}</x-danger-button>

                        <x-modal name="confirm-delete-invoice" focusable>
                            <form method="post" action="{{ route('invoices.destroy', $invoice->invoice_code) }}" class="p-6">
                                @csrf
                                @method('delete')

                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Apakah anda yakin akan menghapus invoice ini?') }}
                                </h2>

                                <div class="mt-6 flex justify-end">
                                    <x-secondary-button x-on:click="$dispatch('close')">
                                        {{ __('Batal') }}
                                    </x-secondary-button>

                                    <x-danger-button class="ms-3">
                                        {{ __('Hapus format Invoice') }}
                                    </x-danger-button>
                                </div>
                            </form>
                        </x-modal>
                    </section>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const itemList = document.getElementById('item-list')
            const addItemButton = document.getElementById('add-item')
            const itemTemplate = document.getElementById('item-template').cloneNode(true)
            const calculationWrapper = document.querySelector('.col-start-2')

            itemTemplate.removeAttribute('id')

            function updateRowTotal(row) {
                const quantityInput = row.querySelector('.quantity')
                const priceInput = row.querySelector('.price')
                const totalInput = row.querySelector('.item_price_total')
                const quantity = parseFloat(quantityInput.value) || 0
                const price = parseFloat(priceInput.value) || 0
                const total = quantity * price
                totalInput.value = total.toLocaleString('id-ID')
            }

            function updateGrandTotals() {
                let subtotal = 0
                const allItemTotals = itemList.querySelectorAll('.item_price_total')

                allItemTotals.forEach(function(itemTotal) {
                    const value = parseFloat(itemTotal.value.replace(/\./g, '')) || 0
                    subtotal += value
                })

                const subtotalInput = document.getElementById('subtotal')
                if (subtotalInput) {
                    subtotalInput.value = subtotal.toLocaleString('id-ID')
                }

                const discountInput = document.getElementById('discount')
                const shipmentInput = document.getElementById('shipment')
                const taxInput = document.getElementById('tax')
                const serviceInput = document.getElementById('service')
                const bilTotalInput = document.getElementById('bill_total')

                const discount = discountInput ? parseFloat(discountInput.value) || 0 : 0
                const shipment = shipmentInput ? parseFloat(shipmentInput.value) || 0 : 0
                const tax = taxInput ? parseFloat(taxInput.value) || 0 : 0
                const service = serviceInput ? parseFloat(serviceInput.value) || 0 : 0

                const grandTotal = subtotal - discount + shipment + tax + service

                if (billTotalInput) {
                    billTotalInput.value = grandTotal.toLocaleString('id-ID')
                }
            }

            addItemButton.addEventListener('click', function() {
                const newItemRow = itemTemplate.cloneNode(true)
                newItemRow.classList.remove('hidden');
                itemList.appendChild(newItemRow);
                updateGrandTotals();
            })

            itemList.addEventListener('click', function(e) {
                if (e.target.closest('.remove-item-btn')) {
                    e.target.closest('.item-row').remove()
                    updateGrandTotals()
                }
            })

            itemList.addEventListener('input', function(e) {
                if (e.target.matches('.quantity, .price')) {
                    const currentRow = e.target.closest('.item-row')
                    updateRowTotal(currentRow)
                    updateGrandTotals()
                }
            })

            calculationWrapper.addEventListener('input', function(e) {
                if(e.target.matches('#discount, #shipment, #tax, #service')) {
                    updateGrandTotals()
                }
            })

            updateGrandTotals()
        })
    </script>
    @endpush
</x-app-layout>
