<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ubah Format Invoice') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="post" action="{{ route('formats.update', $format->slug) }}" class="space-y-6 w-full mb-6">
                @csrf
                @method('put')
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                    <div class="max-full">
                        <h2 class="text-lg font-medium text-black dark:text-white mb-4">
                            {{ __('Nama Format Invoice') }}
                        </h2>
                        <div>
                            <x-input-label for="name" :value="__('* Nama Format Invoice')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                :value="old('name', $format->name)" required autofocus autocomplete="name"
                                placeholder="Isi nama format invoice" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>
                    </div>
                </div>
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                    <div class="max-full">
                        <h2 class="text-lg font-medium text-black dark:text-white">
                            {{ __('Format Label Invoice') }}
                        </h2>
                        <p class="mb-4 text-gray-600 dark:text-gray-400">* (harus diisi)</p>
                        <div class="p-2 sm:p-4 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">

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
                                    <p class="text-sm text-end text-indigo-600">
                                        INV-{{ auth()->user()->brand_slug . '-' . auth()->user()->created_at->format('dmY-His') }}
                                    </p>
                                </div>
                            </div>

                            {{-- pengirim dan penerima --}}
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                                {{-- pengirim --}}
                                <div>
                                    <div>
                                        <span class="text-gray-600 dark:text-gray-400">*</span>
                                        <x-text-input id="sender_title" name="sender_title" type="text" class="py-1 text-base w-80" :value="old('sender_title', $format->sender_title)" required autofocus autocomplete="sender_title"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('sender_title')" />
                                    </div>
                                    <div class="grid grid-cols-2 gap-4 items-center mt-2">
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">*</span>
                                            <x-text-input id="sender_label" name="sender_label" type="text" class="py-1 text-base" :value="old('sender_label', $format->sender_label)" required autofocus autocomplete="name"/>
                                            <x-input-error class="mt-2" :messages="$errors->get('sender_label')" />
                                        </div>
                                        <div>
                                            <p class="text-gray-500 dark:text-gray-400">: <span class="text-black dark:text-white font-semibold">{{ auth()->user()->brand_name }}</span></p>
                                        </div>
                                    </div>
                                </div>

                                {{-- penerima --}}
                                <div>
                                    <div>
                                        <span class="text-gray-600 dark:text-gray-400">*</span>
                                        <x-text-input id="receiver_title" name="receiver_title" type="text" class="py-1 text-base w-80" :value="old('receiver_title', $format->receiver_title)" required />
                                    </div>
                                    <div class="flex gap-4 items-center mt-2">
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">*</span>
                                            <x-text-input id="receiver_label" name="receiver_label" type="text" class="py-1 text-base" :value="old('receiver_label', $format->receiver_label)" required autofocus autocomplete="receiver_label"/>
                                            <x-input-error class="mt-2" :messages="$errors->get('receiver_label')" />
                                        </div>
                                        <div>
                                            <p class="text-gray-500 dark:text-gray-400">: <span class="text-black dark:text-white font-semibold">{{ auth()->user()->name }} ({{ auth()->user()->email }})</span></p>
                                        </div>
                                    </div>
                                    <div class="flex gap-4 items-center mt-2">
                                        <div >
                                            <span class="text-gray-600 dark:text-gray-400">*</span>
                                            <x-text-input id="invoice_date_label" name="invoice_date_label" type="text" class="py-1 text-base" :value="old('invoice_date_label', $format->invoice_date_label)" required autofocus autocomplete="invoice_date_label" />
                                            <x-input-error class="mt-2" :messages="$errors->get('invoice_date_label')" />
                                        </div>
                                        <div>
                                            <p class="text-gray-500 dark:text-gray-400">: <span class="text-black dark:text-white font-semibold">{{ auth()->user()->created_at->translatedFormat('d F Y') }}</span></p>
                                        </div>
                                    </div>
                                    <div class="flex gap-4 items-center mt-2">
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">*</span>
                                            <x-text-input id="invoice_address_label" name="invoice_address_label" type="text" class="py-1 text-base" :value="old('invoice_address_label', $format->invoice_address_label)" required autofocus autocomplete="invoice_address_label" />
                                            <x-input-error class="mt-2" :messages="$errors->get('invoice_address_label')" />
                                        </div>
                                        <div>
                                            <p class="text-gray-500 dark:text-gray-400">: <span class="text-black dark:text-white font-semibold">{{ auth()->user()->address }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- tabel --}}
                            <div class="grid grid-cols-10 gap-4 items-center mt-2 border-y py-2 border-gray-900 dark:border-gray-600">
                                <div class="col-span-5">
                                    <span class="text-gray-600 dark:text-gray-400">*</span>
                                    <x-text-input id="item_label" name="item_label" type="text" class="py-1 text-base w-full" :value="old('item_label', $format->item_label)" required autofocus autocomplete="item_label" />
                                    <x-input-error class="mt-2" :messages="$errors->get('item_label')" />
                                </div>
                                <div class="col-span-1">
                                    <span class="text-gray-600 dark:text-gray-400">*</span>
                                    <x-text-input id="quantity_label" name="quantity_label" type="text" class="py-1 text-base w-full" :value="old('quantity_label', $format->quantity_label)" required autofocus autocomplete="quantity_label" />
                                    <x-input-error class="mt-2" :messages="$errors->get('quantity_label')" />
                                </div>
                                <div class="col-span-2">
                                    <span class="text-gray-600 dark:text-gray-400">*</span>
                                    <x-text-input id="price_label" name="price_label" type="text" class="py-1 text-base w-full" :value="old('price_label', $format->price_label)" required autofocus autocomplete="price_label" />
                                    <x-input-error class="mt-2" :messages="$errors->get('price_label')" />
                                </div>
                                <div class="col-span-2">
                                    <span class="text-gray-600 dark:text-gray-400">*</span>
                                    <x-text-input id="price_total_label" name="price_total_label" type="text" class="py-1 text-base w-full" :value="old('price_total_label', $format->price_total_label)" required autofocus autocomplete="price_total_label" />
                                    <x-input-error class="mt-2" :messages="$errors->get('price_total_label')" />
                                </div>
                            </div>

                            {{-- items --}}
                            <div class="grid grid-cols-10 gap-4 py-2 border-b border-gray-200 dark:border-gray-700">
                                <div class="col-span-5">
                                    <p class="text-base font-semibold text-indigo-600">Item 1</p>
                                </div>
                                <div class="col-span-1">
                                    <p class="text-base text-black dark:text-white text-end">1</p>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-base text-black dark:text-white text-end">Rp10.000</p>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-base text-black dark:text-white text-end">Rp10.000</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-10 gap-4 py-2 border-b border-gray-200 dark:border-gray-700">
                                <div class="col-span-5">
                                    <p class="text-base font-semibold text-indigo-600">Item 2</p>
                                </div>
                                <div class="col-span-1">
                                    <p class="text-base text-black dark:text-white text-end">2</p>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-base text-black dark:text-white text-end">Rp20.000</p>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-base text-black dark:text-white text-end">Rp40.000</p>
                                </div>
                            </div>

                            {{-- footer total --}}
                            <div class="grid grid-cols-2 gap-4 py-2 border-b border-gray-200 dark:border-gray-700">
                                <div class="col-start-2 col-span-1">

                                    {{-- subtotal --}}
                                    <div class="grid grid-cols-10 gap-4 items-center border-b border-gray-200 dark:border-gray-700 py-2">
                                        <div class="col-span-7">
                                            <span class="text-gray-600 dark:text-gray-400">*</span>
                                            <x-text-input id="subtotal_label" name="subtotal_label" type="text" class="py-1 text-base w-80" :value="old('subtotal_label', $format->subtotal_label)" required autofocus autocomplete="subtotal_label" />
                                            <x-input-error class="mt-2" :messages="$errors->get('subtotal_label')" />
                                        </div>
                                        <div class="col-span-3">
                                            <p class="text-base font-semibold text-black dark:text-white text-end">Rp60.000</p>
                                        </div>
                                    </div>

                                    {{-- additional --}}
                                    <div class="grid grid-cols-10 gap-x-4 gap-y-1 items-center border-b border-gray-200 dark:border-gray-700 py-2">
                                        {{-- diskon --}}
                                        <div class="col-span-7">
                                            <x-text-input id="discount_label" name="discount_label" type="text" class="py-1 text-base w-full" :value="old('discount_label', $format->discount_label)" autofocus autocomplete="discount_label" />
                                            <x-input-error class="mt-2" :messages="$errors->get('discount_label')" />
                                        </div>
                                        <div class="col-span-3">
                                            <p class="text-base text-black dark:text-white text-end">- Rp5.000</p>
                                        </div>

                                        {{-- ongkos kirim --}}
                                        <div class="col-span-7">
                                            <x-text-input id="shipment_label" name="shipment_label" type="text" class="py-1 text-base w-full" :value="old('shipment_label', $format->shipment_label)" autofocus autocomplete="shipment_label" />
                                            <x-input-error class="mt-2" :messages="$errors->get('shipment_label')" />
                                        </div>
                                        <div class="col-span-3">
                                            <p class="text-base text-black dark:text-white text-end">Rp15.000</p>
                                        </div>

                                        {{-- biaya pajak --}}
                                        <div class="col-span-7">
                                            <x-text-input id="tax_label" name="tax_label" type="text" class="py-1 text-base w-full" :value="old('tax_label', $format->tax_label)" autofocus autocomplete="tax_label" />
                                            <x-input-error class="mt-2" :messages="$errors->get('tax_label')" />
                                        </div>
                                        <div class="col-span-3">
                                            <p class="text-base text-black dark:text-white text-end">Rp2.000</p>
                                        </div>

                                        {{-- biaya pelayanan --}}
                                        <div class="col-span-7">
                                            <x-text-input id="service_label" name="service_label" type="text" class="py-1 text-base w-full" :value="old('service_label', $format->service_label)" autofocus autocomplete="service_label" />
                                            <x-input-error class="mt-2" :messages="$errors->get('service_label')" />
                                        </div>
                                        <div class="col-span-3">
                                            <p class="text-base text-black dark:text-white text-end">Rp2.000</p>
                                        </div>
                                    </div>

                                    {{-- subtotal --}}
                                    <div class="grid grid-cols-10 gap-4 items-center py-2">
                                        <div class="col-span-7">
                                            <span class="text-gray-600 dark:text-gray-400">*</span>
                                            <x-text-input id="bill_total_label" name="bill_total_label" type="text" class="py-1 text-base w-80" :value="old('bill_total_label', $format->bill_total_label)" required autofocus autocomplete="bill_total_label" />
                                            <x-input-error class="mt-2" :messages="$errors->get('bill_total_label')" />
                                        </div>
                                        <div class="col-span-3">
                                            <p class="text-base font-semibold text-black dark:text-white text-end">Rp74.000</p>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- payment --}}
                            <div class="grid grid-cols-2 gap-4 py-2 mb-6">
                                <div class="col-start-2 col-span-1">
                                    <div>
                                        <span class="text-gray-600 dark:text-gray-400">*</span>
                                        <x-text-input id="payment_method_label" name="payment_method_label" type="text" class="py-1 mb-1 text-base w-80" :value="old('payment_method_label', $format->payment_method_label)" required autofocus autocomplete="payment_method_label" />
                                        <x-input-error class="mt-2" :messages="$errors->get('payment_method_label')" />
                                    </div>
                                    <div>
                                        <span class="text-gray-600 dark:text-gray-400">*</span>
                                        <x-text-input id="payment_method_name" name="payment_method_name" type="text" class="py-1 mb-1 text-base w-64" :value="old('payment_method_name', $format->payment_method_name)" required autofocus autocomplete="payment_method_name" />
                                        <x-input-error class="mt-2" :messages="$errors->get('payment_method_name')" />
                                    </div>
                                    <div>
                                        <span class="text-gray-600 dark:text-gray-400">*</span>
                                        <x-text-input id="payment_method_number" name="payment_method_number" type="text" class="py-1 mb-1 text-base w-64" :value="old('payment_method_number', $format->payment_method_number)" required autofocus autocomplete="payment_method_number" />
                                        <x-input-error class="mt-2" :messages="$errors->get('payment_method_number')" />
                                    </div>
                                </div>
                            </div>

                            {{-- terakhir diupdate --}}
                            <p class="text-xs italic text-black dark:text-white">Terakhir diupdate: {{ auth()->user()->updated_at->translatedFormat('d F Y H:i') }} WIB</p>


                        </div>
                    </div>
                    <div class="flex items-center gap-4 mt-6">
                        <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                    </div>
                </div>
            </form>
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-full">
                    <section class="space-y-6">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Hapus Format Invoice') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Setelah format invoice terhapus, semua invoice yang menggunakan format ini beserta item-item didalam invoice akan dihapus secara permanen. Sebelum menghapus format invoice, harap unduh data invoice yang menggunakan format invoice ini.') }}
                            </p>
                        </header>

                        <x-danger-button
                            x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-delete-invoice-formats')"
                        >{{ __('Hapus format Invoice') }}</x-danger-button>

                        <x-modal name="confirm-delete-invoice-formats" focusable>
                            <form method="post" action="{{ route('formats.destroy', $format->slug) }}" class="p-6">
                                @csrf
                                @method('delete')

                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Apakah anda yakin akan menghapus format invoice ini?') }}
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
</x-app-layout>
