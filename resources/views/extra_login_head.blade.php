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

<style>
    /*esta es teoria la clase que controla el calendario*/
    .fi-fo-date-time-picker-panel:hover{
    background-color: red/* Your desired color for selected elements */;
    border-radius:1px /* Your desired border-radius */;
}
</style>


