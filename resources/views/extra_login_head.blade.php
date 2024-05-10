{{-- antes del body, crear una division que divida el body en dos --}}
<style>
    body
    {
        display: flex;
        background-color:white !important;
    }

    .imagen-fondo
    {
        background-image: url('/images/fotoLogin.jpg');
        background-repeat: no-repeat;
        height: 100%;
    
    }

    /*dividir el divgeneral en dos mitades iguales flex:1 que ocupen el mismo espacio*/
    .left-side,.right-side
    {
        flex:1;
        box-sizing: border-box;
    }

    .right-side
    {
        background-image: url('/images/fotoLogin.jpg');
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