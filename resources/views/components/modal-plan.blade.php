<style>
    /* Modal básico */
    .modal {
        position: fixed; /* Posición fija */
        top: 0;
        left: 0;
        width: 100%;
        height: 90%;
        background-color: rgba(0, 0, 0, 0.5); /* Fondo oscuro */
        z-index: 9999; /* Asegura que esté encima de todo */
        opacity: 0; /* Comienza invisible */
        visibility: hidden; /* Oculta el modal inicialmente */
        pointer-events: none; /* Desactiva la interacción mientras no está visible */
        transition: opacity 0.2s ease-in-out, visibility 0s 0.2s; /* Transición de opacidad */
    }

    /* Modal cuando está visible */
    .modal.show {
        opacity: 1; /* Muestra el modal */
        visibility: visible; /* Hace visible el modal */
        pointer-events: auto; /* Permite la interacción */
        transition: opacity 0.2s ease-in-out, visibility 0.1s 0.1s; /* No hay retraso en la visibilidad */
    }

    /* Modal contenido */
    .modal-content-plan {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%); /* Centrado */
        background-color: #fff;
        padding: 30px;
        border-radius: 8px;
        width: 100%;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        text-align: center;
        max-width: 90%;
    }

    /* Botón cerrar */
    .close {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 25px;
        font-weight: bold;
        color: #333;
        background: none;
        border: none;
        cursor: pointer;
    }

    /* Botón de cierre hover */
    .close:hover {
        color: red;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.querySelector('.modal');
        const closeBtn = document.querySelector('.close');

        // Función para cerrar el modal con animación
        function closeModal() {
            // Inicia la animación de desvanecimiento
            modal.style.transition = 'opacity 1s ease-in-out'; // Establece la transición de opacidad
            modal.classList.remove('show'); // Elimina la clase 'show' para iniciar la animación de desvanecimiento

            // Escucha el evento de finalización de la transición
            modal.addEventListener('transitionend', function () {
                modal.style.visibility = 'hidden'; // Cambia la visibilidad a oculto después de la animación
                modal.style.transition = ''; // Reseteamos la transición para otros usos
            }, { once: true }); // Se ejecuta solo una vez
        }

        // Función para abrir el modal con animación
        function openModal() {
            modal.classList.add('show'); // Añade la clase 'show' para hacer visible el modal
            modal.style.visibility = 'visible'; // Asegura que el modal sea visible al iniciar la animación
        }

        // Cerrar el modal al hacer clic en el botón de cierre
        closeBtn.addEventListener('click', closeModal);

        // Cerrar el modal al hacer clic fuera del contenido del modal
        window.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeModal();
            }
        });

        // Abre el modal (puedes usar esto cuando lo desees)
        // openModal(); // Llama esta función cuando necesites mostrar el modal
    });
</script>

<!-- Componente toasts.blade.php -->
<div id="closeModal" class="modal {{ $showModalPlan ? 'show' : '' }}">
    <div class="modal-content-plan">
        <button class="close">&times;</button>

        <div class="bg-white rounded-md" style="font-family: Arial, sans-serif; padding: 10px; max-width: 1200px; margin: auto;">
            <!-- TÍTULO Y DESCRIPCIÓN -->
            <div style="text-align: center; margin-bottom: 40px;">
                <!-- TÍTULO -->
                <h2 style="font-size: 2.5rem; color: #333; margin-bottom: 10px;">Nuestros Planes</h2>
                <!-- DESCRIPCIÓN -->
                <p style="font-size: 1.1rem; color: #666; line-height: 1.5;">
                    Escoge el plan que se ajuste a tus necesidades. Desde opciones gratuitas hasta funciones avanzadas para
                    llevar tu experiencia al siguiente nivel.
                </p>
            </div>

            <!-- PLANES: FREE - PRO - PRO MAX -->
            <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
                <!-- PLAN FREE -->
                <div
                    style="flex: 1; max-width: 300px; border: 1px solid #ddd; border-radius: 8px; padding: 20px; text-align: center; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <h3 style="font-size: 1.8rem; color: #2ECC71;">Lite</h3>
                    <p style="color: #555; font-size: 1rem; margin-bottom: 20px;">
                        Ideal para comenzar, con características básicas para explorar nuestra plataforma.
                    </p>
                    <ul style="list-style: none; padding: 0; color: #444; text-align: left; margin-bottom: 20px;">
                        <li>✔ Acceso limitado</li>
                        <li>✔ Soporte básico</li>
                        <li>✔ Hasta 1 Diario</li>
                        <li>✔ Hasta 3 veces de Scrapeo</li>
                    </ul>
                    <p style="font-size: 1.5rem; font-weight: bold; color: #2ECC71;">S/0.00/mes</p>
                    <button wire:click="iniciarPago('Lite', 0)"
                        style="padding: 10px 20px; background-color: #2ECC71; color: #fff; border: none; border-radius: 5px; cursor: pointer;">
                        Empezar Gratis
                    </button>
                </div>

                <!-- PLAN PRO -->
                <div
                    style="flex: 1; max-width: 300px; border: 1px solid #ddd; border-radius: 8px; padding: 20px; text-align: center; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <h3 style="font-size: 1.8rem; color: #3498DB;">Standard</h3>
                    <p style="color: #555; font-size: 1rem; margin-bottom: 20px;">
                        Perfecto para usuarios avanzados que buscan herramientas adicionales y mayor flexibilidad.
                    </p>
                    <ul style="list-style: none; padding: 0; color: #444; text-align: left; margin-bottom: 20px;">
                        <li>✔ Acceso completo</li>
                        <li>✔ Soporte prioritario</li>
                        <li>✔ Hasta 2 Diarios</li>
                        <li>✔ Hasta 10 veces de Scrapeo</li>
                    </ul>
                    <p style="font-size: 1.5rem; font-weight: bold; color: #3498DB;">S/15.00/mes</p>
                    <button wire:click="iniciarPago('Standard', 15)"
                        style="padding: 10px 20px; background-color: #3498DB; color: #fff; border: none; border-radius: 5px; cursor: pointer;">
                        Suscribirse
                    </button>
                </div>

                <!-- PLAN PRO MAX -->
                <div
                    style="flex: 1; max-width: 300px; border: 1px solid #ddd; border-radius: 8px; padding: 20px; text-align: center; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <h3 style="font-size: 1.8rem; color: #E74C3C;">Ultra</h3>
                    <p style="color: #555; font-size: 1rem; margin-bottom: 20px;">
                        Diseñado para equipos o usuarios con necesidades avanzadas. ¡Lleva tu proyecto al siguiente nivel!
                    </p>
                    <ul style="list-style: none; padding: 0; color: #444; text-align: left; margin-bottom: 20px;">
                        <li>✔ Acceso total</li>
                        <li>✔ Soporte 24/7</li>
                        <li>✔ Hasta 5 Diarios</li>
                        <li>✔ Hasta 20 veces de Scrapeo</li>
                    </ul>
                    <p style="font-size: 1.5rem; font-weight: bold; color: #E74C3C;">S/30.00/mes</p>
                    <button wire:click="iniciarPago('Ultra', 30)"
                        style="padding: 10px 20px; background-color: #E74C3C; color: #fff; border: none; border-radius: 5px; cursor: pointer;">
                        Unirse Ahora
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

