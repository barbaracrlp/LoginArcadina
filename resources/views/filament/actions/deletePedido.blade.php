{{-- <div style="align-items: center;align-self:center">
    <div class="">
        <div class="rounded-full fi-color-dangers bg-custom-100 dark:bg-custom-500/20 fi-color-danger p-2"
            style="--c-100:var(--primary-100);--c-400:var(--primary-400);--c-500:var(--primary-500);--c-600:var(--primary-600);">
            <svg class="fi-modal-icon h-6 w-6 text-danger-600 dark:text-custom-400" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                data-slot="icon">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0">
                </path>
            </svg>
        </div>
    </div>
    <h2 class="fi-modal-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
        Eliminar Pedido número: {{$record->numero}}
    </h2>
    <p class="fi-modal-description text-sm text-gray-500 dark:text-gray-400 mt-2">
        Eliminar el pedido implica eliminar todos los datos relacionados.
    </p>
</div> --}}
{{--
Este es el copiado tal cual --}}

{{-- 
        <div class="absolute end-4 top-4">
                <svg class="fi-icon-btn-icon h-6 w-6" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 352 512">
                    <!-- Font Awesome Free 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) -->
                    <path
                        d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z">
                    </path>
                </svg>

            </button>
        </div> --}}
    

        <div class="mb-5 flex items-center justify-center">
            <div class="rounded-full fi-color-custom bg-custom-100 dark:bg-custom-500/20 fi-color-danger p-3"
                style="--c-100:var(--danger-100);--c-400:var(--danger-400);--c-500:var(--danger-500);--c-600:var(--danger-600);">
                <svg class="fi-modal-icon h-6 w-6 text-custom-600 dark:text-custom-400" fill="currentColor"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                    <!--! Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2023 Fonticons, Inc. -->
                    <path
                        d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z">
                    </path>
                </svg>
            </div>
        </div>
        <!--[if ENDBLOCK]><![endif]-->

        <div class="text-center">
            <h2 class="fi-modal-heading text-base font-bold leading-6 text-gray-950 ">
                Eliminar Pedido {{$record->numero}}
            </h2>
         
          
            <!--[if BLOCK]><![endif]-->
            <p class="fi-modal-description text-sm  font-semibold text-gray-500">
                Eliminar el pedido {{$record->numero}} implica eliminar todos los datos relacionados.
            </p>
            <p class="fi-modal-description text-sm text-gray-500">
                 Por Favor Escriba el siguiente número para confirmar la eliminación:
            </p>
 
