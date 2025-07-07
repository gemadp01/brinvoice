<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="max-w-full m-6">
                    @if( session('status') )
                        <p class="text-gray-800 dark:text-gray-200 text-center">
                            {{ session('status') }}
                        </p>
                    @endif
                    @if( auth()->user()->brand_logo_path != '' )
                        <div class="mb-4">
                            <img src="{{ asset('storage/' . auth()->user()->brand_logo_path) }}" alt="{{ auth()->user()->brand_name }}" class="h-16 object-cover rounded-sm">
                        </div>
                    @endif
                    <form action="{{ route('brand.update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                            <div class="mb-4">
                                <x-input-label for="brand_logo_path" :value="__('Logo Brand')" />
                                <x-text-input id="brand_logo_path" name="brand_logo_path" type="file" class="mt-1 block w-full" autofocus autocomplete="brand_logo_path" />
                                <x-input-error class="mt-2" :messages="$errors->get('brand_logo_path')"/>
                            </div>
                            <div class="mb-4">
                                <x-input-label for="brand_name" :value="__('Nama Usaha / Brand *')" />
                                <x-text-input id="brand_name" name="brand_name" type="text" class="mt-1 block w-full" :value="old('brand_name', auth()->user()->brand_name)" required autofocus autocomplete="brand_name" placeholder="Isi nama usaha / brand" />
                                <x-input-error class="mt-2" :messages="$errors->get('brand_name')" />
                            </div>
                            <div class="mb-4">
                                <x-input-label for="phone_number" :value="__('Nomor WhatsApp Usaha / Brand')" />
                                <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full" :value="old('phone_number', auth()->user()->phone_number)" required autofocus autocomplete="phone_number" placeholder="Isi nomor whatsapp usaha / brand" />
                                <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
                            </div>
                            <div class="mb-4">
                                <x-input-label for="address" :value="__('Alamat Usaha / Brand')" />
                                <x-textarea id="address" name="address" type="text" class="mt-1 block w-full" autofocus autocomplete="address" :value="old('address',auth()->user()->address)" placeholder="Isi alamat usaha / brand" />
                                <x-input-error class="mt-2" :messages="$errors->get('address')" />
                            </div>
                            <div class="mb-4">
                                <x-input-label for="city" :value="__('Kota')" />
                                <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', auth()->user()->city)" autofocus autocomplete="city" placeholder="Isi kota usaha / brand" />
                                <x-input-error class="mt-2" :messages="$errors->get('city')" />
                            </div>
                            <div class="mb-4">
                                <x-input-label for="province" :value="__('Provinsi')" />
                                <x-text-input id="province" name="province" type="text" class="mt-1 block w-full" :value="old('province', auth()->user()->province)" autofocus autocomplete="province" placeholder="Isi provinsi usaha / brand" />
                                <x-input-error class="mt-2" :messages="$errors->get('province')" />
                            </div>
                            <div class="mb-4">
                                <x-input-label for="postal_code" :value="__('Kode POS')" />
                                <x-text-input id="postal_code" name="postal_code" type="number" class="mt-1 block w-full" :value="old('postal_code', auth()->user()->postal_code)" autofocus autocomplete="postal_code" placeholder="Isi kode pos usaha / brand" />
                                <x-input-error class="mt-2" :messages="$errors->get('postal_code')" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Simpan') }}</x-primary-button>

                                @if (session('status') === 'brand-updated')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600 dark:text-gray-400"
                                    >{{ __('Tersimpan.') }}</p>
                                @endif
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
