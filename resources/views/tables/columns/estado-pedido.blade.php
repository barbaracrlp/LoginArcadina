{{-- @php
$estado = $getState();
$label = $estado->getLabel();
$color = $estado->getColor();
@endphp
<style>
    .cirulo {
        background-color: {
                {
                $color
            }
        }

        ;

    }
</style>
<div class="flex items-center space-x-2">
    <div class="relative">
        <input type="radio" checked disabled class="form-radio h-5 w-5 opacity-0" />
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="h-5 w-5 rounded-full circulo"></div>
        </div>
    </div>

</div> --}}

@php
$estado = $getState();
$label = $estado->getLabel();
$color = $estado->getColor();
$nuevoColor;
switch ($color){
case 'danger':
# code...
$nuevoColor="#EF4444";
break;
case 'info':
# code...
$nuevoColor="#21ABE3";
break;
case 'success':
# code...
$nuevoColor="#10B981";
break;
case 'warning':
# code...
$nuevoColor="#F97316";
break;
case 'sin':
$nuevoColor='#71717a';
# code...
break;
case 'pendiente':
$nuevoColor='#a855f7';
# code...
break;
case 'enviado':
$nuevoColor='#22c55e';
# code...
break;
case 'neutral':
$nuevoColor="#6B7280";
            # code...
            break;

}
@endphp

<div class="flex items-center">
    <div class="h-5 w-5 rounded-full" style="background-color: {{ $nuevoColor }};"></div>
    <p style="color:{{$nuevoColor}}"> {{$label}}</p>
</div>
{{-- <span>{{ $label }}</span>
<span>{{ $customLabel ?? '' }}</span> --}}
</div>

