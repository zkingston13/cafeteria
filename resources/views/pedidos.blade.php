@extends('layout.app')

@section('app', 'pedidos')
@section('contenido')
<div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default p-5">
    <table class="w-auto text-sm text-left rtl:text-right text-body">
        <thead class="text-sm text-bold text-blue-800 bg-neutral-secondary-soft border-b rounded-base border-default">
            <tr>
                <th scope="col" class="px-6 py-3 font-medium">
                    Pedido
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Id_cliente
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Fecha
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Estado
                </th>
                 <th scope="col" class="px-6 py-3 font-medium">
                    Total
                </th>
                 <th scope="col" class="px-6 py-3 font-medium">
                    Mesa
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Editar
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Eliminar
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pedidos as $pedido)
            <tr class="bg-neutral-primary border-b border-default">
                <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                    {{ $pedido->id_pedido }}
                </th>
                <td class="px-6 py-4">
                    {{$pedido->id_cliente}}  
                </td>
                <td class="px-6 py-4">
                    {{$pedido->fecha}}
                </td>
                <td class="px-6 py-4">
                    {{$pedido->estado}}  
                </td>
                 <td class="px-6 py-4">
                    {{$pedido->total}}
                </td>
                 <td class="px-6 py-4">
                    {{$pedido->id_mesa}}  
                </td>
       
              {{--
              @if($asignacion?->id_asignacion)
                 <td class="px-6 py-4">
                    <a href="/admin/asignacion/{{ $asignacion->id_asignacion }}/editar">
                    Editar</a>
                </td>
                  <td class="px-6 py-4">
        <form action="{{ route('asignacion.eliminar', $asignacion->id_asignacion) }}" method="POST"
        onsubmit="return confirm('¿Seguro que deseas eliminar esta asignacion?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-600 hover:text-red-800">
            Eliminar
        </button>
        </form>        
        @else
            <span class="text-gray-400">Sin ID</span>
        @endif   
              --}}  
        </td>
        </tr>
    @endforeach
        </tbody>
    </table>
</div>

@endsection