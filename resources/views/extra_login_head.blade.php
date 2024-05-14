{{-- antes del body, crear una division que divida el body en dos --}}
@if(request()->routeIs('filament.gestion.auth.login'))
{{-- No tocar esto, sino toda la pagina del login cambia --}}
<style>
    body {
        display: flex;
        background-color: white !important;
    }

    /*dividir el divgeneral en dos mitades iguales flex:1 que ocupen el mismo espacio*/
    .left-side,
    .right-side {
        flex: 1;
        box-sizing: border-box;
    }

    .right-side {
        background-image: url('/images/fotoLogin.jpg'), linear-gradient(#3AB7E6, #0F79AE);
        background-size: cover;
        background-position: center;

    }

    @media screen and (max-width:800px) {
        .right-side {
            display: none;
        }
    }

    .fi-simple-main {
        border-bottom-left-radius: 0%;
        border-bottom-right-radius: 0%;
        border-top-left-radius: 0%;
        border-top-right-radius: 0%;
        border: none;
        box-shadow: none;
        outline: none;
        background-color: transparent;
    }
</style>
{{-- ahora creo la primera division para meter todo lo de filament en un lado
en la otra pagina cierror este div y añado el lado derecho --}}

<div class="left-side">
@endif

{{-- override de estilos más facil que con un tema que hay que cambiar más cosas
asi puedo aplicar las clases que yo quiero solo
se podria probar con un tema,pero de momento funciona bien  --}}
<style>
    /* Cambiar el texto de los días de la semana */
    .fi-fo-date-time-picker-panel .text-gray-500 {
       color: black;
       font-weight: bold;
    }
 
    /* Cambiar el día seleccionado */
    .fi-fo-date-time-picker-panel .text-primary-600.pointer-events-none {
       color: white;
       background-color: #1A9DD5;
       border-radius: 20%;
    }
 
    /* Cambiar el color de fondo del día actual */
    .fi-fo-date-time-picker-panel .text-primary-600 {
       border: 1px solid #1A9DD5;
       border-radius: 20%;
    }
 
    /* Cambiar el estilo del día actual */
    .fi-fo-date-time-picker-panel .text-primary-600 {
       border: 1px solid #1A9DD5;
       border-radius: 20%;
    }
 
    /* Cambiar el color de fondo del día seleccionado */
    .fi-fo-date-time-picker-panel .text-primary-600.bg-gray-50 {
       /* border: 1px solid #1A9DD5; */
       border-radius: 20%;
       background-color: #1A9DD5;
       color: white;
    }
 
    /* Cambiar el hover de los días no seleccionados ni el día actual */
    .fi-fo-date-time-picker-panel .bg-gray-50:hover:not(.text-primary-600) {
       background-color: #E1F5FB;
       color: black;
       border-radius: 20%;
    }
 </style>
