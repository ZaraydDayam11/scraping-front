@section('title', 'Configurar cuenta - Yape')
@section('header', 'Configurar cuenta')
@section('section', 'Yape')

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 xl:grid-cols-3 xl:gap-4">

        <div class="col-span-2">

            <div class="relative p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-lg 2xl:col-span-2">
                <h3 class="mb-4 text-xl font-semibold">Información General</h3>
                <button wire:click="create()"
                    class="absolute top-2 right-2 px-4 py-2 rounded-lg bg-gradient-to-r from-amber-700 to-yellow-600 focus:from-amber-700 focus:to-yellow-600 active:from-amber-600 active:to-yellow-600 text-sm text-white font-semibold tracking-wide cursor-pointer shadow-lg">
                    <i class="fa-solid fa-plus"></i> Nuevo
                </button>
                @if ($isOpen)
                    @include('livewire.admin.modals.setting-yape')
                @endif
                @foreach ($yapepages as $index => $item)
                    <div x-data="{ photoName: null, photoPreview: null }" class="mb-4 items-center flex gap-4 justify-center">
                        <div class="flex justify-center">
                            @if ($item->image)
                                <img class="w-52 h-auto object-cover rounded-lg"
                                    src="{{ Storage::url($item->image->url) }}" alt="{{ $item->name }}">
                            @else
                                <img class="w-52 h-20 object-cover rounded-lg" src="{{ asset('../img/default.jpg') }}"
                                    alt="No Image">
                            @endif
                        </div>

                        <div>
                            <h3 class="mb-1 text-xl font-bold text-gray-900">
                                Imagen de QR</h3>
                            <div class="mb-4 text-sm text-gray-500">
                                JPG, JPEG o PNG. Tamaño máximo de 1MB
                            </div>
                            <div class="flex items-center space-x-4">
                                <x-button type="button" disabled x-on:click.prevent="$refs.photo.click()"
                                    class="inline-flex items-center">
                                    <svg class="w-4 h-4 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z">
                                        </path>
                                        <path d="M9 13h2v5a1 1 0 11-2 0v-5z"></path>
                                    </svg>
                                    Imagen Subido
                                </x-button>

                                <x-input-error for="photo" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-6 gap-4">
                        <div class="col-span-6 sm:col-span-3">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nombre del
                                titular</label>
                            <input type="text" disabled id="name" autocomplete="off"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                                placeholder="Green" value="{{ $item->name }}">
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="telefono" class="block mb-2 text-sm font-medium text-gray-900">Número de
                                celular</label>
                            <input type="tel" disabled id="telefono"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                                placeholder="Green" value="{{ $item->telefono }}">
                        </div>
                    </div>
                    <div class="flex items-center justify-around mt-6 text-end">
                        <x-button wire:click="edit({{ $item }})">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </x-button>
                        <x-danger-button wire:click="$emit('deleteItema',{{ $item->id }})">
                            <i class="fa-regular fa-trash-can"></i>
                        </x-danger-button>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-span-full xl:col-auto">
            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-lg 2xl:col-span-2">
                <img class="rounded-lg w-full h-40 object-cover"
                    src="https://tubolsillo.pe/wp-content/uploads/2023/08/como-activar-sonido-de-yape-en-mi-celular-notificacion.jpg"
                    alt="">
            </div>

            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-lg 2xl:col-span-2">
                <img class="rounded-lg w-full h-28 object-cover"
                    src="https://www.tarjetasdecredito.vip/wp-content/uploads/2022/11/Yape-del-BCP-como-funciona.webp"
                    alt="">
            </div>
        </div>
    </div>
</div>
