<div>
    <x-dialog-modal wire:model="isOpen" maxWidth="lg">
        <x-slot name="title">
            @if ($ruteCreate)
                <h3 class="text-center">Registrar nuevo yape</h3>
            @else
                <h3 class="text-center">Actualizar yape</h3>
            @endif
        </x-slot>
        <x-slot name="content">
            <form autocomplete="off">
                <input type="hidden" wire:model="yapepage.id">
                <div class="flex flex-col gap-2.5 w-full px-2">
                    <div class="mb-1">
                        <x-label value="Nombre del Titular" class="font-bold" />
                        <x-input type="text" wire:model="yapepage.name" />
                        @unless (!empty($yapepage['name']))
                            <x-input-error for="yapepage.name" />
                        @endunless
                    </div>
                    <div class="mb-1">
                        <x-label value="Numero(Telefono) de yape del Titular" class="font-bold" />
                        <x-input type="text" wire:model="yapepage.telefono" />
                        @unless (!empty($yapepage['telefono']))
                            <x-input-error for="yapepage.telefono" />
                        @endunless
                    </div>
                    <div class="w-full">
                        <x-label value="Imagen" class="font-bold" />
                        <div>
                            <div class="border border-gray-300 rounded-lg">
                                <label
                                    class="text-white text-sm rounded-t-lg bg-gray-600 focus:bg-gray-600 active:bg-gray-700 inline-flex items-center justify-center w-full px-4 py-2 cursor-pointer">
                                    <i class="fa-solid fa-upload mr-1"></i>Cargar Imagen(es)
                                    <input wire:model="image" type="file" hidden />
                                </label>

                                <div wire:loading wire:target="image" class="w-full">
                                    <div id="alert-4" class="flex p-3 mb-4 text-yellow-800 rounded-lg bg-yellow-50"
                                        role="alert">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <div class="ml-2 text-sm font-medium">
                                            Espere un momento por favor, la imagen se esta procesando
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2 py-4">
                                    @if ($ruteCreate)
                                        @if ($image)
                                            <img class="mx-auto w-[40rem] sm:h-40 object-cover rounded-md"
                                                src="{{ $image->temporaryUrl() }}" alt="">
                                        @else
                                            <li id="empty"
                                                class="h-full w-full text-center flex flex-col items-center justify-center">
                                                <img class="mx-auto w-32"
                                                    src="https://user-images.githubusercontent.com/507615/54591670-ac0a0180-4a65-11e9-846c-e55ffce0fe7b.png"
                                                    alt="no data" />
                                                <span class="text-small text-gray-500">
                                                    Ningún archivo seleccionado</span>
                                            </li>
                                        @endif
                                    @else
                                        @if ($image)
                                            <img class="mx-auto w-[40rem] sm:h-40 object-cover rounded-md"
                                                src="{{ $image->temporaryUrl() }}" alt="">
                                        @else
                                            <img class="mx-auto w-[40rem] sm:h-40 object-cover rounded-md"
                                                src="{{ $this->yapepage['image'] ? Storage::url($this->yapepage['image']['url']) : '/img/default.jpg' }}"
                                                alt="">
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </x-slot>
        <x-slot name="footer">
            <x-danger-button wire:click="$set('isOpen',false)">Cancelar</x-danger-button>
            <x-success-button wire:click.prevent="store()" wire:loading.attr="disabled" wire:target="store, image"
                class="disabled:opacity-25">
                @if ($ruteCreate)
                    Registrar
                @else
                    Actualizar
                @endif
            </x-success-button>
        </x-slot>

    </x-dialog-modal>
</div>
