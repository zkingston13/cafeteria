@extends('layout.app')

@section('app', 'Cafe')

@section('contenido')

<h1 class="text-4xl text-center font-bold text-amber-900 mb-4">
    {{ $productos->nombre }}
</h1>

<hr class="border-2 border-amber-900 mb-8 w-24 mx-auto">

<!-- IMAGENES -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">

    @if(isset($productos->img))
        <img src="http://127.0.0.1:8001/{{ $productos->img }}"
        class="rounded-lg shadow w-full">
    @endif

    @if(isset($productos->img2))
        <img src="http://127.0.0.1:8001/{{ $productos->img2 }}"
        class="rounded-lg shadow w-full">
    @endif

    @if(isset($productos->img3))
        <img src="http://127.0.0.1:8001/{{ $productos->img3 }}"
        class="rounded-lg shadow w-full">
    @endif

</div>

<!-- DETALLES -->
<div class="max-w-2xl mx-auto mt-8 p-6 bg-white rounded-lg shadow-md">

<h1 class="font-bold text-amber-700 text-lg">Descripción:</h1>
<p class="font-bold text-lg">{{$productos->descripcion}}</p>
<br>

<h1 class="font-bold text-amber-700 text-lg">Precio:</h1>
<p class="font-bold text-lg">$ {{$productos->precio}}</p>
<br>

<h1 class="font-bold text-amber-700 text-lg">Existencia:</h1>
<p class="font-bold text-lg">
@if($productos->disponible == 1)
<span class="text-green-600 font-semibold">Disponible</span>
@else
<span class="text-red-600 font-semibold">Agotado</span>
@endif
</p>


<form action="{{ route('carrito.agregar') }}" method="POST" class="mt-6">
@csrf

<input type="hidden" name="producto[id_producto]" value="{{ $productos->id_producto }}">
<input type="hidden" name="producto[nombre]" value="{{ $productos->nombre }}">
<input type="hidden" name="producto[precio]" value="{{ $productos->precio }}">
<input type="hidden" name="producto[img]" value="{{ $productos->img }}">

<button type="submit"
class="flex items-center justify-center gap-2 w-full bg-amber-700 hover:bg-amber-800 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-300"
@if($productos->disponible == 0) disabled @endif>

🛒 {{ $productos->disponible == 1 ? 'Agregar al carrito' : 'Producto agotado' }}

</button>

</form>

</div>

@endsection