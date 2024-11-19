
<div class="relative w-full pb-5 flex flex-col justify-center p-4">
    <header class="flex justify-around items-center gap-2 py-5 bg-gray-700 px-4 mb-4 rounded-xl">

        <a href="/">
            <div class="flex lg:justify-center lg:col-start-2 gap-5 items-center">

                <span class="text-3xl text-white">Scrapeo de noticias</span>
            </div>
        </a>

        @if (Route::has('login'))
            <nav class=" flex flex-1 justify-end gap-3 items-center">
                <a href="#">
                    <span class="text-md"></span>
                </a>
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="rounded-lg px-4 py-2 text-white font-semibold transition duration-300 ease-in-out transform bg-gradient-to-r from-[#FF2D20] to-[#FF6A3D] shadow-lg hover:shadow-xl hover:from-[#FF6A3D] hover:to-[#FF2D20] focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#FF2D20]">
                        Sistema
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="rounded-lg px-4 py-2 bg-[#b6beb8] text-white font-semibold shadow-md transition duration-300 ease-in-out transform hover:bg-[#e6221d] hover:-translate-y-1 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#FF2D20] focus:ring-opacity-50">
                        Iniciar Sesion
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="rounded-lg px-4 py-2 bg-[#b6beb8] text-white font-semibold shadow-md transition duration-300 ease-in-out transform hover:bg-[#e6221d] hover:-translate-y-1 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#FF2D20] focus:ring-opacity-50">
                            Registrarse
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <div class="py-10 bg-gray-100">
        <div class="w-full lg:w-2/5 mx-auto text-center">
            <div class="flex justify-between items-center mb-6">
                <div class="flex flex-col items-center">
                    <div class="h-8 w-8 bg-indigo-600 text-white rounded-full flex items-center justify-center shadow">
                        <i class="fas fa-check"></i>
                    </div>
                    <p class="text-sm mt-2">Paso 1</p>
                </div>
                <div class="flex-1 h-1 bg-indigo-300 mx-2"></div>
                <div class="flex flex-col items-center">
                    <div class="h-8 w-8 bg-indigo-600 text-white rounded-full flex items-center justify-center shadow">
                        <i class="fas fa-check"></i>
                    </div>
                    <p class="text-sm mt-2">Paso 2</p>
                </div>
                <div class="flex-1 h-1 bg-indigo-300 mx-2"></div>
                <div class="flex flex-col items-center">
                    <div class="h-8 w-8 bg-indigo-600 text-white rounded-full flex items-center justify-center shadow">
                        <i class="fas fa-check"></i>
                    </div>
                    <p class="text-sm mt-2">Paso 3</p>
                </div>
            </div>
        </div>
    
        <div class="bg-white shadow-md rounded-lg p-6 mx-auto lg:w-2/5 text-center">
            @if (session('statusMessage'))
                @php
                    $statusTypeClass = session('statusType') === 'success' ? 'text-green-600' : 'text-red-600';
                    $iconClass = session('statusType') === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
                @endphp
                <div class="mb-4">
                    <i class="fas {{ $iconClass }} fa-3x {{ $statusTypeClass }}"></i>
                </div>
                <h1 class="text-lg font-semibold {{ $statusTypeClass }}">
                    {{ session('statusType') === 'success' ? '¡Pago exitoso!' : 'Hubo un error con tu compra' }}
                </h1>
                <p class="mt-2 text-gray-600">
                    {{ session('statusType') === 'success' ? 'Pronto recibirás tu comprobante.' : 'Por favor, intenta nuevamente.' }}
                </p>
                <div class="mt-6">
                    <a href="/" class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700">Volver al inicio</a>
                </div>
            @else
                <p class="text-gray-600">No hay mensajes para mostrar.</p>
            @endif
        </div>
    </div>
    
</div>

