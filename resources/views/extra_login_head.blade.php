{{-- antes del body, crear una division que divida el body en dos --}}
@if(request()->routeIs('filament.gestion.auth.login'))
<style>
    body
    {
        display: flex;
        background-color:white !important;
    }

    /*dividir el divgeneral en dos mitades iguales flex:1 que ocupen el mismo espacio*/
    .left-side,.right-side
    {
        flex:1;
        box-sizing: border-box;
    }

    .right-side
    {
        background-image: url('/images/fotoLogin.jpg'),linear-gradient(#3AB7E6,#0F79AE);
        background-size: cover;
        background-position: center;
       
    }

    @media screen and (max-width:800px){
        .right-side{
            display:none;
        }
    }

    .fi-simple-main{
        border: 0ch;
    }
    </style>

<div class="left-side">
@endif