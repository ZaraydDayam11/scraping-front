<x-dialog-modal wire:model="isOpen" maxWidth="lg">
    <x-slot name="title">
        <i class="fa-solid fa-{{ $showUser ? 'address-card fa-lg' : ($itemId ? 'user-pen' : 'user-plus') }} mr-2"></i>
        {{ $showUser ? 'Detalle del usuario' : ($itemId ? 'Actualizar usuario' : 'Registrar nuevo usuario') }}
    </x-slot>
    <x-slot name="content">
        <form autocomplete="off">
            <div class="flex flex-col gap-3">
                <div class="grid {{ $itemId ? 'grid-cols-3' : 'grid-cols-1' }} gap-3">
                    @if ($itemId && $user)
                        <div class="w-36 h-36">
                            <img class="w-full h-full mx-auto border-2 rounded-xl object-cover"
                                src="{{ $user->profile_photo_path ? Storage::url($user->profile_photo_path) : $user->profile_photo_url }}"
                                alt="{{ $user->name }}">
                        </div>
                    @endif
                    <div class="col-span-2 flex flex-col gap-3">
                        <x-input-label for="form.name" label="Nombre completo" wire:model.live="form.name" type="text"
                            disabled="{{ $showUser }}" />
                        <x-input-label for="form.dni" label="Documento de Identidad" wire:model.live="form.dni"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '');" type="text" maxlength="8"
                            disabled="{{ $showUser }}" />
                        <x-input-label for="form.email" label="Correo electrónico" wire:model.live="form.email"
                            type="email" disabled="{{ $showUser }}" />
                    </div>
                </div>
                @if (!$showUser && !$itemId)
                    <div class="grid sm:grid-cols-2 gap-3">
                        <x-input-label for="form.password" label="Contraseña" eye wire:model="form.password"
                            type="password" />
                        <x-input-label for="form.password_confirmation" label="Confirmar contraseña"
                            wire:model.live="form.password_confirmation" type="password" />
                    </div>
                @endif
            </div>
        </form>
    </x-slot>
    <x-slot name="footer">
        <button data-ripple-dark="true" x-on:click="show = false" wire:click="closeModals"
            class="px-4 py-2.5 mr-1 font-sans text-xs font-bold text-red-500 uppercase transition-all rounded-lg middle none center hover:bg-red-500/10 active:bg-red-500/30 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
            Cancelar
        </button>

        @if (!$showUser)
            <x-button-gradient color="green" wire:click="store()" wire:loading.attr="disabled" wire:target="store">
                <span wire:loading wire:target="store" class="mr-2">
                    <i class="fa fa-spinner fa-spin"></i>
                </span>
                {{ $itemId ? 'Actualizar' : 'Registrar' }}
            </x-button-gradient>
        @endif
    </x-slot>
</x-dialog-modal>
