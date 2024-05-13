{{-- antes del body, crear una division que divida el body en dos --}}
<style>
    /* body
    {
        display: flex;
        background-color:white !important;
    } */
    /*dividir el divgeneral en dos mitades iguales flex:1 que ocupen el mismo espacio*/
    /* body, html {
            margin: 0;
            padding: 0;
            height: 100%;
        } */
    /* body{
        display: flex;
    } */
 
     
    /* .fi-simple-layout{
        width: 100%;
       height: 100%;
     
    } */

    .fi-simple-page{
        width: 100% !important;
       height: 100% !important;
       max-width: 100%;
       max-height: 100% !important;
       display: flex;
    }


    .fi-simple-main{
    width: 100% !important;
       height: 100% !important; 
       background-color: red !important;
       margin: 0%;
       min-width: 100%;
       min-height: 100% !important ;
      
    } 
    
     section
    {
        flex:1;
        flex-direction: column-reverse;
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

    /* main{
       width: 100% !important;
       height: 100%;
       max-width: 100%;
       max-height: 100% !important ;
    }  */
  
    </style>
{{-- <section class="left-side"> --}}

    