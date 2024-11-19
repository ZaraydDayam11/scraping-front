<style>
    /* Modal básico */
    .modal {
        position: fixed; /* Posición fija */
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
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
    .modal-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%); /* Centrado */
        background-color: #fff;
        padding: 30px;
        border-radius: 8px;
        width: 400px;
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
<div id="closeModal" class="modal {{ $showModal ? 'show' : '' }}">
    <div class="modal-content">
        <button class="close">&times;</button>

        <!-- Imagen centrada -->
        <div style="display: flex; justify-content: center; align-items: center ;text-align: center; margin-bottom: 20px;">
            <img src="https://static.vecteezy.com/system/resources/thumbnails/013/939/288/small_2x/online-account-registration-and-login-concept-woman-who-registers-or-logs-in-to-an-online-account-with-a-user-interface-secure-login-and-password-flat-illustration-vector.jpg" alt="Imagen central" style="max-width: 21rem; border-radius: 5%;">
        </div>

        <!-- Texto de invitación -->
        <p style="text-align: center; font-size: 18px; color: #333; margin-bottom: 20px;">
            Para disfrutar de más beneficios, <strong>Regístrate</strong> o <strong>Inicia Sesión</strong>
        </p>

        <div style="display: flex; justify-content: center; gap: 15px; padding: 20px;">
            <a href="/login" style="
                padding: 14px 28px;
                background-color: #ff6b6b;
                color: #fff;
                border-radius: 10px;
                text-decoration: none;
                font-weight: bold;
                transition: transform 0.3ms ease, box-shadow 0.3ms ease;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            " onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0 8px 16px rgba(0, 0, 0, 0.2)';"
               onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.15)';">
                Log In
            </a>
            <a href="/register" style="
                padding: 14px 28px;
                background-color: #6bc3ff;
                color: #fff;
                border-radius: 10px;
                text-decoration: none;
                font-weight: bold;
                transition: transform 0.3ms ease, box-shadow 0.3ms ease;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            " onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0 8px 16px rgba(0, 0, 0, 0.2)';"
               onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.15)';">
                Register
            </a>
        </div>
    </div>
</div>

