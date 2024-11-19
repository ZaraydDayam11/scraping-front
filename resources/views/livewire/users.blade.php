<div>

    @include('livewire.modal.user')

    @include('livewire.modal.assign-role-user')

    @include('livewire.modal.delete')

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-10">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-l p-3 h-max">
            <div class="relative flex flex-col w-full h-full text-gray-700">
                <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center mb-3">
                    <div class="w-full md:w-72">
                        <x-input-label wire:model.live="search" search label="Buscar" />
                    </div>

                    <div class="flex gap-2 justify-center">
                        @can('users.create')
                            <x-button-gradient class="flex items-center gap-2" wire:click="create()">
                                <i class="fa-solid fa-plus"></i>
                                <span class="hidden sm:block">Nuevo</span>
                            </x-button-gradient>
                        @endcan
                    </div>

                </div>
                <x-table-container>
                    <div wire:loading wire:target="userState, userRol, search"
                        class="absolute w-full h-full z-10 pt-10">
                        <div class="relative h-full w-full">
                            <div class="absolute inset-0 bg-white bg-opacity-50 backdrop-blur-[2px]"></div>
                            <div class="absolute inset-0 flex justify-center items-center bg-opacity-0">
                                <div>
                                    <i class="fa fa-spinner fa-spin"></i> Cargando...
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="w-full text-left table-auto min-w-max">
                        <x-table-thead>
                            <tr>
                                <th class="p-3 font-normal text-center">Usuario</th>
                                <th class="p-3 font-normal text-center">DNI</th>
                                <th class="p-3 font-normal">Correo electronico</th>
                                <th class="p-3 font-normal">Roles</th>
                                <th class="p-3 font-normal">Actualizado</th>
                                <th class="p-3 font-normal text-center">Acciones</th>
                            </tr>
                        </x-table-thead>
                        <tbody class="text-sm divide-y divide-gray-300">
                            @foreach ($users as $user)
                                <tr class="hover:bg-gray-100 ">
                                    <td class="p-3">
                                        {{ $user->name }}
                                    </td>
                                    <td class="p-3">
                                        {{ $user->dni }}
                                    </td>
                                    <td class="p-3">{{ $user->email }}</td>
                                    <td class="p-3">
                                        @if (optional($user->roles->first())->name)
                                            <div class="inline-flex gap-1">
                                                <x-tag class="w-max" role="{{ $user->roles->first()->id }}">
                                                    {{ $user->roles->first()->name }}
                                                </x-tag>
                                                @if ($user->roles()->count() !== 1)
                                                    <x-tag class="w-max" role="{{ $user->roles->first()->id }}">
                                                        {{ '+' . $user->roles()->count() - 1 }}
                                                    </x-tag>
                                                @endif
                                            </div>
                                        @else
                                            <x-tag class="w-max" role="null">No asignado</x-tag>
                                        @endif
                                    </td>
                                    <td class="p-3">
                                        <div>
                                            <i class="fa-regular fa-calendar fa-fw"></i>
                                            {{ \Carbon\Carbon::parse($user->updated_at)->format('d-m-Y') }}
                                        </div>
                                        <div>
                                            <i class="fa-regular fa-clock fa-fw"></i>
                                            {{ \Carbon\Carbon::parse($user->updated_at)->format('H:i:s') }}
                                        </div>
                                    </td>
                                    <td class="p-3 w-10">
                                        <div class="flex justify-center relative">
                                            @can('users.assign-role')
                                                <x-button-tooltip hover="gray"
                                                    content="{{ $user->roles()->count() > 0 ? 'Editar Rol' : 'Asignar Rol' }}"
                                                    wire:click="showRoles({{ $user }})">
                                                    <i class="fa-solid fa-user-lock fa-fw"></i>
                                                </x-button-tooltip>
                                            @endcan
                                            @can('users.edit')
                                                <x-button-tooltip hover="green" content="Editar"
                                                    wire:click="edit({{ $user }})">
                                                    <i class="fa-solid fa-pen fa-fw"></i>
                                                </x-button-tooltip>
                                            @endcan
                                            @can('users.delete')
                                                <x-button-tooltip hover="red" content="Eliminar"
                                                    wire:click="deleteItem({{ $user->id }})">
                                                    <i class="fa-solid fa-trash-can fa-fw"></i>
                                                </x-button-tooltip>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @if (!$users->count())
                                <tr>
                                    <td colspan="7" class="p-3 text-center text-sm">
                                        No existe ningún registro coincidente con la búsqueda.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </x-table-container>
                @if ($users->count())
                    {{ $users->links() }}
                @endif
            </div>
        </div>
    </div>
</div>
