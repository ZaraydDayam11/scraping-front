<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-[1366px] mx-auto py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-l p-3 h-max">
                    <div class="grow flex flex-col justify-center">
                        <header class="pb-3 border-b border-gray-200 ">
                            <h2 class="font-semibold text-gray-800">Total de Scrapeo</h2>
                        </header>
                        <div wire:ignore class="mt-3">
                            <canvas id="polarArea"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-span-2 space-y-4">
                    <div class="grid grid-cols-4 gap-4">
                        <div class="w-52 bg-white overflow-hidden shadow-xl sm:rounded-lg p-3 h-max">
                            <canvas id="chart1"></canvas>
                        </div>
                        {{-- <div class="w-52 bg-white overflow-hidden shadow-xl sm:rounded-lg p-3 h-max">
                            <canvas id="chart2"></canvas>
                        </div> --}}
                        <div class="w-52 bg-white overflow-hidden shadow-xl sm:rounded-lg p-3 h-max">
                            <canvas id="chart3"></canvas>
                        </div>
                        <div class="w-52 bg-white overflow-hidden shadow-xl sm:rounded-lg p-3 h-max">
                            <canvas id="chart4"></canvas>
                        </div>
                        <div class="w-52 bg-white overflow-hidden shadow-xl sm:rounded-lg p-3 h-max">
                            <canvas id="chart5"></canvas>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-3 h-max">
                        <header class="pb-3 border-b border-gray-200 ">
                            <h2 class="font-semibold text-gray-800">Actividad Reciente</h2>
                        </header>
                        <div class="mt-3 flex gap-3">
                            <div class="flex-none">
                                <header
                                    class="text-xs uppercase text-gray-400 bg-gray-100 rounded-sm font-semibold p-2 text-center">
                                    Diario</header>
                                <ul class="my-1">
                                    <!-- Item -->
                                    <div class="px-2">
                                        <div class="border-b border-gray-200  text-sm py-2 text-center">
                                            <b>Sin Fronteras</b>
                                        </div>
                                    </div>
                                    <!-- Item -->
                                    <div class="px-2">
                                        <div class="border-b border-gray-200 text-sm py-2 text-center">
                                            <b>Los Andes</b>
                                        </div>
                                    </div>
                                    <!-- Item -->
                                    <div class="px-2">
                                        <div class="border-b border-gray-200 text-sm py-2 text-center">
                                            <b>La República</b>
                                        </div>
                                    </div>
                                    <!-- Item -->
                                    <div class="px-2">
                                        <div class="border-b border-gray-200 text-sm py-2 text-center">
                                            <b>Exitosa Noticias</b>
                                        </div>
                                    </div>
                                </ul>
                            </div>

                            <div class="w-full">
                                <header
                                    class="text-xs uppercase text-gray-400 bg-gray-100 rounded-sm font-semibold p-2 text-center">
                                    Hoy</header>
                                <div class="my-1">
                                    <!-- Item -->
                                    <div class="px-2">
                                        <div class="border-b border-gray-200 text-sm py-2 text-center">
                                            Se escrapeo
                                            {{ $art1Today }}
                                            noticias en total
                                        </div>
                                    </div>
                                    <!-- Item -->
                                    <div class="px-2">
                                        <div class="border-b border-gray-200 text-sm py-2 text-center">
                                            Se escrapeo
                                            {{ $art3Today }}
                                            noticias en total
                                        </div>
                                    </div>
                                    <!-- Item -->
                                    <div class="px-2">
                                        <div class="border-b border-gray-200 text-sm py-2 text-center">
                                            Se escrapeo
                                            {{ $art4Today }}
                                            noticias en total
                                        </div>
                                    </div>
                                    <!-- Item -->
                                    <div class="px-2">
                                        <div class="border-b border-gray-200 text-sm py-2 text-center">
                                            Se escrapeo
                                            {{ $art5Today }}
                                            noticias en total
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="w-full">
                                <header
                                    class="text-xs uppercase text-gray-400 bg-gray-100 rounded-sm font-semibold p-2 text-center">
                                    Ayer</header>
                                <div class="my-1">
                                    <!-- Item -->
                                    <div class="px-2">
                                        <div class="border-b border-gray-200  text-sm py-2 text-center">
                                            Se escrapeo
                                            {{ $art1Yesterday }}
                                            noticias en total
                                        </div>
                                    </div>
                                    <!-- Item -->
                                    <div class="px-2">
                                        <div class="border-b border-gray-200 text-sm py-2 text-center">
                                            Se escrapeo
                                            {{ $art3Yesterday }}
                                            noticias en total
                                        </div>
                                    </div>
                                    <!-- Item -->
                                    <div class="px-2">
                                        <div class="border-b border-gray-200 text-sm py-2 text-center">
                                            Se escrapeo
                                            {{ $art4Yesterday }}
                                            noticias en total
                                        </div>
                                    </div>
                                    <!-- Item -->
                                    <div class="px-2">
                                        <div class="border-b border-gray-200 text-sm py-2 text-center">
                                            Se escrapeo
                                            {{ $art5Yesterday }}
                                            noticias en total
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script type="module">
            const polarAreadata = {
                labels: ["Sin Fronteras", "Expreso", "Los Andes", "La República", "La Exitosa"],
                datasets: [{
                    label: 'Total de Noticias',
                    data: [{{ $articles1->count() }}, {{ $articles2->count() }}, {{ $articles3->count() }},
                        {{ $articles4->count() }}, {{ $articles5->count() }}
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(25, 362, 235, 0.5)',
                        'rgba(255, 15, 310, 0.5)',
                        'rgba(125, 99, 235, 0.5)',
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(25, 362, 235)',
                        'rgb(255, 15, 310)',
                        'rgb(125, 99, 235)',
                    ],
                    borderWidth: 1
                }]
            };

            const configpolarArea = {
                type: 'pie',
                data: polarAreadata,
                options: {},
            };

            var polarArea = new Chart(
                document.getElementById("polarArea"),
                configpolarArea
            );
        </script>

        <script>
            // Configuración del gráfico con porcentaje y texto en el centro
            const config = (percent, labelText) => ({
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [percent, 100 - percent],
                        backgroundColor: ['#FF6384', '#D3D3D3'],
                        hoverBackgroundColor: ['#FF6384', '#D3D3D3']
                    }]
                },
                options: {
                    responsive: true,
                    cutout: '70%',
                    plugins: {
                        tooltip: {
                            enabled: true
                        },
                        legend: {
                            display: true
                        }
                    }
                },
                plugins: [{
                    // Plugin para mostrar el porcentaje y texto debajo
                    id: 'centerText',
                    beforeDraw: (chart) => {
                        const {
                            ctx,
                            chartArea: {
                                width,
                                height
                            }
                        } = chart;
                        ctx.save();

                        // Mostrar el porcentaje en el centro
                        ctx.font = 'bold 30px sans-serif';
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'middle';
                        ctx.fillStyle = '#000';
                        ctx.fillText(percent + '%', width / 2, height / 2);

                        // Mostrar el texto debajo del porcentaje
                        ctx.font = '12px sans-serif';
                        ctx.fillText(labelText, width / 2, height / 2 +
                            25); // Ajusta la posición si es necesario
                        ctx.restore();
                    }
                }]
            });

            // Crear gráficos con porcentaje y texto personalizado
            new Chart(document.getElementById('chart1'), config({{ $porc1 }}, 'Sin Fronteras'));
            new Chart(document.getElementById('chart2'), config({{ $porc2 }}, 'Expreso'));
            new Chart(document.getElementById('chart3'), config({{ $porc3 }}, 'Los Andes'));
            new Chart(document.getElementById('chart4'), config({{ $porc4 }}, 'La República'));
            new Chart(document.getElementById('chart5'), config({{ $porc5 }}, 'Exitosa Noticias'));
        </script>
    </div>
</div>
