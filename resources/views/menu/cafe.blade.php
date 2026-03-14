@extends('layout.app')

@section('app', 'Cafe')

@section('contenido')
<h1 class="text-4xl text-center font-bold text-amber-900 mb-4">Café la roma</h1>
    <hr class="border-2 border-amber-900 mb-8 w-24 mx-auto">



<div class="grid grid-cols-4 gap-4">
@foreach ($productos as $producto)
<!-- PRODUCTO -->

    

        <div class="bg-white rounded-lg shadow-lg p-4">
            <h3 class="font-bold text-lg">{{$producto->nombre}}</h3>
            <img src="http://127.0.0.1:8001/{{ $producto->img }}" class="w-70 h-75" alt="">
             <h3 class="font-bold text-lg">{{$producto->descripcion}}</h3>
             <h3 class="font-bold text-lg text-amber-700">Categoria: </h3>
             <h3 class="font-bold text-lg"> {{$producto->categorias->nombre}}</h3>
            <p class="text-amber-700 font-bold text-lg">${{$producto->precio}}</p>
            <a  class="text-blue-700 font-bold text-lg" href="/detalle/{{ $producto->id_producto }}">
    Ver detalle
</a>
            <button onclick="agregarAlPedido(1,'Café Americano',45)" class="mt-2 w-full text-amber-700 py-2 rounded" style="background-color: var(--color-taupe-700);">
            Agregar al pedido
            </button>
        </div>

       @endforeach
   
</div>
<br>
<div class="lg:col-span-1">

        <div class="bg-white rounded-lg shadow-lg p-6 sticky top-24">

            <h2 class="text-2xl font-bold text-amber-900 mb-4">Tu Pedido</h2>

                <!-- MESA -->
                <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Número de mesa</label>
                <select id="mesa" class="w-full border rounded px-3 py-2">
                <option value="">Seleccionar mesa</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>Para llevar</option>
                </select>
                </div>

                <!-- PRODUCTOS -->
                <div class="mb-4">

                <h3 class="font-semibold mb-2">Productos agregados</h3>

                <div id="carrito-items"></div>

                <p id="carrito-vacio" class="text-gray-500 text-center">
                No hay productos en el pedido
                </p>

                </div>

                <!-- TOTALES -->
                <div class="border-t pt-4 mb-4">

                <div class="flex justify-between">
                <span>Subtotal</span>
                <span id="subtotal">$0.00</span>
                </div>

                <div class="flex justify-between">
                <span>IVA 16%</span>
                <span id="iva">$0.00</span>
                </div>

                <div class="flex justify-between text-lg font-bold">
                <span>Total</span>
                <span id="total" class="text-amber-700">$0.00</span>
                </div>

                </div>

                <!-- BOTONES -->
                <div class="space-y-2">

                <button onclick="confirmarPedido()" class="w-full bg-amber-700 text-white py-3 rounded">
                Confirmar pedido
                </button>

                <button onclick="limpiarPedido()" class="w-full border border-amber-700 text-amber-700 py-2 rounded">
                Limpiar pedido
                </button>

                </div>
        </div>
    </div>

<script>

let carrito = [];
const iva = 0.16;

function eliminarProducto(id){

carrito = carrito.filter(p=>p.id!=id);

renderCarrito();

}

function cambiarCantidad(id,input){

let producto = carrito.find(p=>p.id==id);

producto.cantidad = parseInt(input.value);

if(producto.cantidad<=0){
eliminarProducto(id);
}

renderCarrito();

}

function renderCarrito(){

const contenedor = document.getElementById("carrito-items");
const vacio = document.getElementById("carrito-vacio");

contenedor.innerHTML="";

if(carrito.length==0){

vacio.style.display="block";

}else{

vacio.style.display="none";

carrito.forEach(producto=>{

contenedor.innerHTML+=`

<div class="grid grid-cols-4 gap-2 mb-2 bg-gray-50 p-2 rounded">

<input type="text" value="${producto.nombre}" readonly class="border rounded px-1 py-1 text-xs">

<input type="text" value="$${producto.precio}" readonly class="border rounded px-1 py-1 text-xs">

<input type="number" min="1" value="${producto.cantidad}" 
onchange="cambiarCantidad(${producto.id},this)"
class="border rounded px-1 py-1 text-xs">

<button onclick="eliminarProducto(${producto.id})"
class="text-red-500 font-bold">X</button>

</div>

`;

});

}

calcularTotales();

}

function calcularTotales(){

let subtotal = 0;

carrito.forEach(p=>{
subtotal += p.precio * p.cantidad;
});

let impuesto = subtotal * iva;
let total = subtotal + impuesto;

document.getElementById("subtotal").innerText = "$"+subtotal.toFixed(2);
document.getElementById("iva").innerText = "$"+impuesto.toFixed(2);
document.getElementById("total").innerText = "$"+total.toFixed(2);

}

function limpiarPedido(){

carrito=[];
renderCarrito();

}

function confirmarPedido(){

if(carrito.length==0){
alert("No hay productos en el pedido");
return;
}

let mesa = document.getElementById("mesa").value;

if(!mesa){
alert("Selecciona una mesa");
return;
}

let pedido = {
mesa:mesa,
productos:carrito
};

console.log(pedido);

alert("Pedido confirmado");

}

</script>
        
        <!-- Footer -->
        <div class="mt-12 pt-6 border-t border-gray-200 text-center text-gray-500 text-sm">
            <p>Cafeteria &copy; 2026 - App web para cafeteria</p>
        </div>
  </main>
    <script src="../js/app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

</div>

<script>
    function agregarAlPedido(id,nombre,precio){

let producto = carrito.find(p=>p.id==id);

if(producto){
producto.cantidad++;
}else{

carrito.push({
id:id,
nombre:nombre,
precio:precio,
cantidad:1
});

}

renderCarrito();

}
</script>

@endsection