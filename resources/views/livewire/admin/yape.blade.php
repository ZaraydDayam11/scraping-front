<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col sm:flex-row sm:justify-between text-center gap-2 mb-4">
            <div class="flex-1">
                <div class="relative flex items-center text-gray-400 focus-within:text-green-500">
                    <span class="absolute left-4 h-6 flex items-center pr-3 border-r border-gray-300">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="search" wire:model="search" placeholder="Buscar por nombre..."
                        class="w-full pl-14 pr-4 py-2.5 rounded-lg text-sm text-gray-600 outline-none border border-gray-300 focus:border-green-500 focus:ring-green-500 shadow-lg">
                </div>
            </div>
            <div class="flex justify-center gap-2" align="right">
                <a href="{{ URL::to('/pagos-yape/csv') }}"
                    class="px-4 py-2 flex gap-1 items-center rounded-lg bg-gradient-to-r from-emerald-700 to-green-600 focus:from-emerald-700 focus:to-green-600 active:from-green-600 active:to-green-600 text-sm text-white font-semibold tracking-wide cursor-pointer shadow-lg">
                    <i class="fa-regular fa-file-excel"></i> csv
                </a>
                <a href="{{ URL::to('/pagos-yape/pdf') }}" target="_blank"
                    class="px-4 py-2 flex gap-1 items-center rounded-lg bg-gradient-to-r from-sky-900 to-blue-700 focus:from-sky-900 focus:to-blue-700 active:from-sky-700 active:to-blue-600 text-sm text-white font-semibold tracking-wide cursor-pointer shadow-lg">
                    <i class="fa-regular fa-file-lines"></i> pdf
                </a>

                <button
                    class="px-4 py-2 flex gap-1 items-center rounded-lg bg-gradient-to-r from-amber-700 to-yellow-600 focus:from-amber-700 focus:to-yellow-600 active:from-amber-600 active:to-yellow-600 text-sm text-white font-semibold tracking-wide cursor-not-allowed shadow-lg opacity-60"
                    disabled>
                    <i class="fa-solid fa-plus"></i> Nuevo
                </button>

                @if ($isOpen)
                    <div x-data="{ isOpen: @entangle('isOpen') }">
                        <!-- Overlay -->
                        <div x-show="isOpen" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black bg-opacity-50 z-40"
                            @click="isOpen = false">
                        </div>

                        <!-- Modal -->
                        <div x-show="isOpen" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                            class="fixed inset-0 flex items-center justify-center z-50">
                            <div class="bg-white rounded-lg shadow-xl w-full max-w-[50rem] p-6">
                                <!-- Título del Modal -->
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-xl font-semibold text-gray-700">
                                        @if ($ruteCreate)
                                            <h3 class="text-center">Registrar nuevo Yape</h3>
                                        @else
                                            <h3 class="text-center">Verificar el Pago Yape</h3>
                                        @endif
                                    </h2>
                                    <button @click="isOpen = false" class="text-gray-500 hover:text-gray-700">
                                        <i class="fa-solid fa-times"></i>
                                    </button>
                                </div>

                                <!-- Contenido del Modal -->
                                <div class="text-gray-600">
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
                                                            <div class="flex justify-start items-start">
                                                                {{ $yape['voucher']['tipo'] }}</div>
                                                        </div>
                                                        <div class="content_dates">
                                                            <div class="content_dates_title">Numero de Voucher : </div>
                                                            <div class="flex justify-start items-start">
                                                                {{ $yape['voucher']['numero'] }}
                                                            </div>
                                                        </div>
                                                        <div class="content_dates">
                                                            <div class="content_dates_title">Fecha de Compra : </div>
                                                            <div class="flex justify-start items-start">
                                                                {{ $yape['voucher']['fecha'] }}
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
                                                            <div class="font-extrabold uppercase text-black">Comprobante
                                                                de Pago: </div>
                                                            <div class="flex justify-center">
                                                                @if ($yape['imageyape'])
                                                                    <img class="w-auto h-auto object-cover rounded-lg"
                                                                        src="{{ Storage::url($yape['imageyape']['url']) }}"
                                                                        alt="{{ $yape['name'] }}">
                                                                @else
                                                                    <img class="max-w-[450px] min-w-[420px]  object-cover rounded-lg"
                                                                        src="{{ asset('../img/default.jpg') }}"
                                                                        alt="No Image">
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
                                                            <div class="font-extrabold uppercase text-black">Validar
                                                                Yape
                                                            </div>
                                                        </div>
                                                        <form autocomplete="off">
                                                            <input type="hidden" wire:model="yape.id">
                                                            <div class="form-group">
                                                                <x-label value="Estado del Voucher:"
                                                                    class="font-bold" />
                                                                <x-select wire:model="yape.status">
                                                                    <x-slot name="options">
                                                                        @if ($ruteCreate)
                                                                            <option value="" selected>
                                                                                Seleccione...</option>
                                                                            <option value="RE">Revisión</option>
                                                                            <option value="PA">Pagado</option>
                                                                        @else
                                                                            {{-- @dd($yape['voucher']['client']['name']); --}}
                                                                            @if ($yape['voucher']['status'] == 'RE')
                                                                                <option
                                                                                    value="{{ $yape['voucher']['status'] }}"
                                                                                    selected>
                                                                                    Revisión</option>
                                                                                <option value="PA">Pagado</option>
                                                                            @else
                                                                                <option
                                                                                    value="{{ $yape['voucher']['status'] }}"
                                                                                    selected>
                                                                                    Pagado</option>
                                                                                <option value="RE">Revisión
                                                                                </option>
                                                                            @endif
                                                                        @endif
                                                                    </x-slot>
                                                                </x-select>
                                                            </div>
                                                        </form>
                                                    </td>
                                                    <td class="px-6 pr-0 my-[-1rem] flex flex-wrap h-2">
                                                        <div
                                                            class="bg-white border border-gray-200 rounded-lg shadow-lg 2xl:col-span-2">
                                                            <img class="rounded-lg w-auto h-auto object-cover"
                                                                src="https://tubolsillo.pe/wp-content/uploads/2023/08/como-activar-sonido-de-yape-en-mi-celular-notificacion.jpg"
                                                                alt="">
                                                        </div>

                                                        <div
                                                            class="bg-white border border-gray-200 rounded-lg shadow-lg 2xl:col-span-2">
                                                            <img class="rounded-lg w-auto h-auto object-cover"
                                                                src="https://www.tarjetasdecredito.vip/wp-content/uploads/2022/11/Yape-del-BCP-como-funciona.webp"
                                                                alt="">
                                                        </div>
                                                    </td>

                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Footer del Modal -->
                                <div class="mt-6 flex justify-end space-x-2">
                                    <x-danger-button wire:click="$set('isOpen',false)">Cancelar</x-danger-button>
                                    <x-success-button wire:click.prevent="store()" wire:loading.attr="disabled"
                                        wire:target="store, images" class="disabled:opacity-25">
                                        @if ($ruteCreate)
                                            Registrar
                                        @else
                                            Actualizar
                                        @endif
                                    </x-success-button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="shadow-lg border-b border-gray-200 rounded-lg overflow-auto">
            <table class="w-full table-auto">
                <thead class="bg-indigo-700 text-white">
                    <tr class="text-center text-xs font-bold uppercase">
                        <td scope="col" class="px-6 py-3 text-center">ID</td>
                        <td scope="col" class="px-6 py-3 text-center">CODIGO</td>
                        <td scope="col" class="px-6 py-3 text-center">YAPERO</td>
                        <td scope="col" class="px-6 py-3 text-center">FECHA</td>
                        <td scope="col" class="px-6 py-3 text-center">VOUCHER(NUMERO)</td>
                        <td scope="col" class="px-6 py-3 text-center">MONTO</td>
                        <td scope="col" class="px-6 py-3 text-center">ESTADO</td>
                        <td scope="col" class="px-6 py-3 text-center">COMPROBANTE</td>
                        <td scope="col" class="px-6 py-3 text-center">CREADO</td>
                        <td scope="col" class="px-6 py-3 text-center">ACTUALIZADO</td>
                        <th scope="col" class="px-4 py-3">ACCIONES</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-300 bg-white">
                    @foreach ($yapes as $index => $item)
                        <tr class="text-sm font-medium text-gray-900 hover:bg-gray-100">
                            <td class="p-4 text-center">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-700 text-white">
                                    {{ $index + 1 }}
                                </span>
                            </td>
                            <td class="p-4 text-center">{{ $item->codigo }}</td>
                            <td class="p-4 text-center">{{ $item->name }}</td>
                            <td class="p-4 text-center">{{ $item->fecha }}</td>
                            <td class="p-4 text-center">{{ $item->voucher->numero }}</td>
                            <td class="p-4 text-center">S/. {{ $item->voucher->total }}.00</td>
                            <td class="p-4">
                                <div class="flex justify-center items-center">
                                    @if ($item->voucher->status == 'RE' || $item->voucher->status == 'PE')
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
                            </td>
                            <td class="p-2 text-center">
                                <div class="flex justify-center">
                                    @if ($item->imageyape)
                                        <img class="w-52 h-20 object-cover rounded-lg"
                                            src="{{ Storage::url($item->imageyape->url) }}"
                                            alt="{{ $item->name }}">
                                    @else
                                        <img class="w-52 h-20 object-cover rounded-lg"
                                            src="{{ asset('../img/default.jpg') }}" alt="No Image">
                                    @endif
                                </div>
                            </td>
                            <td class="p-4 text-center">{{ $item->created_at }}</td>
                            <td class="p-4 text-center">{{ $item->updated_at }}</td>
                            <td class="p-2 w-10 acciones">
                                @php
                                    $user = Auth::user();
                                    $userRoleName = $user->roles->first()->name;
                                @endphp
                                @if ($userRoleName === 'Administrador')
                                    <x-button wire:click="edit({{ $item }})" class="rounded-md mb-2 gap-2">
                                        <h1>Validar</h1>
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </x-button>
                                @else
                                    <a href="#"
                                        class="flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-medium text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 transition ease-in-out duration-150">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if (!$yapes->count())
            <div class="flex h-auto items-center justify-center p-5 bg-white w-full rounded-lg shadow-lg">
                <div class="text-center">
                    <div class="inline-flex rounded-full bg-yellow-100 p-4">
                        <div class="rounded-full text-yellow-600 bg-yellow-200 p-4 text-6xl">
                            <i class="fa-solid fa-circle-exclamation"></i>
                        </div>
                    </div>
                    <h1 class="mt-5 text-2xl font-bold text-slate-800">Ups... algo salio mal</h1>
                    <p class="text-slate-600 mt-2 text-base">No existe ningun registro coincidente con la búsqueda</p>
                    <span class="text-slate-600 mt-2 text-base">Por favor ingrese el texto correctamente</span>
                </div>
            </div>
        @endif
        @if ($yapes->hasPages())
            <div class="px-6 py-3">
                {{ $yapes->links() }}
            </div>
        @endif
    </div>

    <!--Scripts - Sweetalert   -->
    @push('js')
        <script>
            Livewire.on('deleteItema', id => {
                Swal.fire({
                    title: '¿Estas seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, bórralo!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        //alert("del");
                        Livewire.emitTo('sis-crud-yape-page', 'delete', id);
                        Swal.fire(
                            '¡Eliminado!',
                            'Su archivo ha sido eliminado.',
                            'success'
                        )

                    }
                })
            });
        </script>
    @endpush
</div>
