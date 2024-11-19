<div>
    <x-dialog-modal-pagoyape wire:model="isOpen" maxWidth="4xl">
        <x-slot name="title">
            @if ($ruteCreate)
                <h3 class="text-center">Registrar nuevo Yape</h3>
            @else
                <h3 class="text-center">Verificar el Pago Yape</h3>
            @endif
        </x-slot>
        <x-slot name="content">
            <div class="shadow-lg border-b border-gray-200 rounded-lg overflow-auto">
                <table class="w-full table-auto">
                    <tbody class="divide-y divide-gray-300 bg-white">
                        <tr
                            class="grid sm:grid-cols-2 justify-center gap-2 text-sm font-medium text-gray-900 hover:bg-gray-100 overflow-y-scroll h-64">
                            <td class="px-6 py-4 text-start">
                                <style>
                                    .content_dates {
                                        display: flex;
                                        align-items: center;
                                        gap: 0.5rem;
                                    }

                                    .content_dates_title {
                                        font-weight: 800;
                                        color: black;
                                        text-transform: uppercase;
                                        max-width: max-content;
                                        width: 170px;
                                    }

                                    @media (min-width: 880px) {
                                        .content_dates_title {
                                            width: 170px;
                                            max-width: none;
                                        }
                                    }
                                </style>
                                <div class="content_dates">
                                    <div class="content_dates_title">Tipo de Voucher : </div>
                                    <div class="flex justify-start items-start">{{ $yape['voucher']['tipo'] }}</div>
                                </div>
                                <div class="content_dates">
                                    <div class="content_dates_title">Numero de Voucher : </div>
                                    <div class="flex justify-start items-start">{{ $yape['voucher']['numero'] }}
                                    </div>
                                </div>
                                <div class="content_dates">
                                    <div class="content_dates_title">Fecha de Compra : </div>
                                    <div class="flex justify-start items-start">{{ $yape['voucher']['fecha'] }}
                                    </div>
                                </div>
                                <div class="content_dates">
                                    <div class="content_dates_title">Estado de Compra : </div>

                                    <div class="flex justify-start items-start">
                                        @if ($yape['voucher']['status'] == 'RE')
                                            <span
                                                class="italic text-white bg-gradient-to-r from-orange-600 to-amber-600 rounded-xl px-3 py-1 shadow-md text-sm">
                                                En Revisión
                                            </span>
                                        @else
                                            <span
                                                class="italic text-white bg-gradient-to-r from-green-600 to-green-400 rounded-xl px-3 py-1 shadow-md text-sm">
                                                Pagado
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="content_dates">
                                    <div class="content_dates_title">Tipo de Pago : </div>
                                    <div class="flex justify-start items-start">
                                        {{ $yape['voucher']['metodo_pago'] }}</div>
                                </div>
                                <div class="content_dates">
                                    <div class="content_dates_title">Cliente : </div>
                                    <div class="flex justify-start items-start">
                                        {{ $yape['name'] }}
                                    </div>
                                </div>
                                <div class="content_dates">
                                    <div class="content_dates_title">Total : </div>
                                    <div class="flex justify-start items-start">S/.
                                        {{ $yape['voucher']['total'] }}.00</div>
                                </div>
                            </td>
                            @if ($yape)
                                <td class="px-6 py-4 text-left">
                                    <div class="font-extrabold uppercase text-black">Comprobante de Pago: </div>
                                    <div class="flex justify-center">
                                        @if ($yape['imageyape'])
                                            <img class="w-auto h-auto object-cover rounded-lg"
                                                src="{{ Storage::url($yape['imageyape']['url']) }}"
                                                alt="{{ $yape['name'] }}">
                                        @else
                                            <img class="max-w-[450px] min-w-[420px]  object-cover rounded-lg"
                                                src="{{ asset('../img/default.jpg') }}" alt="No Image">
                                        @endif
                                    </div>
                                </td>
                            @endif
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="shadow-lg border-b border-gray-200 rounded-lg overflow-auto my-5">
                <table class="w-full table-auto">
                    <tbody class="divide-y divide-gray-300 bg-white">
                        <tr
                            class="flex justify-between overflow-hidden text-sm font-medium text-gray-900 hover:bg-gray-100">

                            <td class="grid px-6 py-4">
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <div class="flex w-32">
                                    <div class="font-extrabold uppercase text-black">Validar Yape
                                    </div>
                                </div>
                                <form autocomplete="off">
                                    <input type="hidden" wire:model="yape.id">
                                    <div class="form-group">
                                        <x-label value="Estado del Voucher:" class="font-bold" />
                                        <x-select wire:model="yape.status">
                                            <x-slot name="options">
                                                @if ($ruteCreate)
                                                    <option value="" selected>Seleccione...</option>
                                                    <option value="RE">Revisión</option>
                                                    <option value="PA">Pagado</option>
                                                @else
                                                    {{-- @dd($yape['voucher']['client']['name']); --}}
                                                    @if ($yape['voucher']['status'] == 'RE')
                                                        <option value="{{ $yape['voucher']['status'] }}" selected>
                                                            Revisión</option>
                                                        <option value="PA">Pagado</option>
                                                    @else
                                                        <option value="{{ $yape['voucher']['status'] }}" selected>
                                                            Pagado</option>
                                                        <option value="RE">Revisión</option>
                                                    @endif
                                                @endif
                                            </x-slot>
                                        </x-select>
                                    </div>
                                </form>
                            </td>
                            <td class="px-6 pr-0 my-[-1rem] flex flex-wrap h-2">
                                <div class="bg-white border border-gray-200 rounded-lg shadow-lg 2xl:col-span-2">
                                    <img class="rounded-lg w-auto h-auto object-cover"
                                        src="https://tubolsillo.pe/wp-content/uploads/2023/08/como-activar-sonido-de-yape-en-mi-celular-notificacion.jpg"
                                        alt="">
                                </div>

                                <div class="bg-white border border-gray-200 rounded-lg shadow-lg 2xl:col-span-2">
                                    <img class="rounded-lg w-auto h-auto object-cover"
                                        src="https://www.tarjetasdecredito.vip/wp-content/uploads/2022/11/Yape-del-BCP-como-funciona.webp"
                                        alt="">
                                </div>
                            </td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-danger-button wire:click="$set('isOpen',false)">Cancelar</x-danger-button>
            <x-success-button wire:click.prevent="store()" wire:loading.attr="disabled" wire:target="store, images"
                class="disabled:opacity-25">
                @if ($ruteCreate)
                    Registrar
                @else
                    Actualizar
                @endif
            </x-success-button>
        </x-slot>
    </x-dialog-modal-pagoyape>
</div>
