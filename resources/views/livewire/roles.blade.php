<div>

    @include('livewire.modal.assign-permission-role')
    @include('livewire.modal.role')

    <div class="flex flex-col gap-4 max-w-7xl mx-auto sm:px-6 lg:px-8 py-10">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-l p-3 h-max">
            <div class="relative w-full h-full text-gray-700 ">
                <div class="flex flex-col justify-between gap-4 sm:flex-row items-center">
                    <div class="text-center sm:text-left">
                        <h5 class="block text-lg font-semibold">
                            Lista de roles
                        </h5>
                        <p class="block text-sm">
                            Ver información sobre todos los roles
                        </p>
                    </div>
                    @can('admin.roles.create')
                        <x-button class="flex items-center gap-2" wire:click="create()">
                            <i class="fa-solid fa-plus"></i>
                            <span class="">Nuevo</span>
                        </x-button>
                    @endcan
                </div>
            </div>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mb-4">
            @foreach ($roles as $index => $role)
                <div class="hover:scale-[1.04] duration-300 bg-white overflow-hidden shadow-xl sm:rounded-lg p-3 h-max">
                    <div class="flex justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">{{ $role->name }}</h2>
                            <div class="text-xs font-semibold text-gray-500 uppercase mb-3">
                                este rol tiene
                            </div>
                            <div class="flex">
                                <div class="text-3xl font-bold text-gray-800 mr-2">
                                    {{ $role->permissions()->count() }}
                                </div>
                                <span class="text-xs">
                                    permisos <br> en total
                                </span>
                            </div>
                        </div>

                        <div class="flex flex-col justify-between items-end">
                            <div
                                class="text-white px-5 py-4 bg-gradient-to-bl to-indigo-700 from-indigo-500 rounded-lg h-max">
                                <i class="fa-solid fa-key fa-xl fa-fw"></i>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-2 mt-2">
                        @can('roles.assign-permission')
                            <x-button class="w-full flex items-center justify-center gap-1" wire:click="showPermissions({{ $role }})">
                                {{ $role->permissions()->count() > 0 ? 'Editar permisos' : 'Asignar permisos' }}
                                <i class="fa-solid fa-unlock-keyhole fa-fw"></i>
                            </x-button>
                        @endcan
                        @can('roles.edit')
                            <x-button class="w-max flex items-center justify-center gap-1 bg-green-600" wire:click="edit({{ $role }})">
                                Editar
                                <i class="fa-solid fa-pen fa-fw"></i>
                            </x-button>
                        @endcan
                    </div>
                </div>
            @endforeach

        </div>
    </div>

</div>
