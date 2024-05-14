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
   /*a partir de aqui voy a intentar cambiar los colores del calendario
   este cambia el color de fondo y de delante del numero seleccionado*/
   /* .fi-fo-date-time-picker-panel .bg-gray-50{
    background-color: #1A9DD5;
    color: white;
   } */


   /*intento de cambiar ahora el hover*/
  
   /* .fi-fo-date-time-picker-panel .bg-gray-50:hover{
    background-color: yellow;
    color: white;
   } */

   /*cambiar el hover solo a partir de la claase de los normales
   no seleccionados ni el dia de hoy*/
   /* .fi-fo-date-time-picker-panel .pointer-events-none .bg-gray-50{
    background-color: #1A9DD5;
    color:white;
   } */
   /*cambiar el texto de los días de la semana */
   .fi-fo-date-time-picker-panel .text-gray-500{
    color: black;
    font-weight: bold;
   }

     /*cambiar el dia seleccionado */
    .fi-fo-date-time-picker-panel .text-primary-600.pointer-events-none {
    color: white;
    background-color:  #1A9DD5;
    border-radius:20%;
   }
 
 
 

    /* cambiar el dia actual
    .fi-fo-date-time-picker-panel .cursor-pointer.text-primary-600 {
    border: 1px solid #1A9DD5;
    color: white;
    background-color:  #d54f1a;
    border-radius:20%;
   }

     /*cambiar el dia actual 
     .fi-fo-date-time-picker-panel .text-primary-600 {
    border: 1px solid #1A9DD5;
    border-radius:20%;
   } */


   .fi-fo-date-time-picker-panel .text-primary-600 {
    border: 1px solid #1A9DD5;
    border-radius: 20%;
}

.fi-fo-date-time-picker-panel .cursor-pointer.text-primary-600 {
    color: white;
    background-color: #d54f1a;
}

    /*cambiar el hover de todos los dias */
    .fi-fo-date-time-picker-panel .bg-gray-50:hover {
    background-color:#E1F5FB;
    color: black;
    border-radius:20%;
   }



   /*ahora a ver si se puede hacer el cambio de los periodos*/










</style>


