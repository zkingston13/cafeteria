<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PedidoController extends Controller
{
    private $apiUrl = 'http://127.0.0.1:8001/api';

    public function procesar(Request $request)
    {
        $request->validate([
            'id_mesa' => 'nullable|integer'
        ]);

        // Obtener cliente y token de la sesión
        $cliente = session('cliente');
        $token = session('token');

        // Verificar sesión
        if (!$cliente || !$token) {
            return redirect('/login')
                ->with('error', 'Debes iniciar sesión para realizar un pedido');
        }

        // Obtener carrito
        $carrito = session()->get('carrito', []);

        if (empty($carrito)) {
            return redirect()->back()
                ->with('error', 'El carrito está vacío');
        }

        // Calcular total y preparar detalles
        $total = 0;
        $detalles = [];

        foreach ($carrito as $id_producto => $producto) {

            $subtotal = $producto['precio'] * $producto['cantidad'];

            $total += $subtotal;

            $detalles[] = [
                'id_producto' => $id_producto,
                'cantidad' => $producto['cantidad'],
                'precio_unitario' => $producto['precio'],
                'subtotal' => $subtotal
            ];
        }

        // Datos del pedido
        $pedidoData = [
            'id_cliente' => $cliente['id_cliente'],
            'id_mesa' => $request->id_mesa ?: null,
            'total' => $total,
            'detalles' => $detalles
        ];

        try {

            // Enviar pedido a la API
            $response = Http::withToken($token)
                ->acceptJson()
                ->post($this->apiUrl . '/pedidos', $pedidoData);

            // Si la API devuelve error
            if (!$response->successful()) {

                return redirect()->back()->with(
                    'error',
                    'API ERROR [' . $response->status() . ']: ' . $response->body()
                );
            }

            // Pedido creado correctamente
            // Vaciar carrito
            session()->forget('carrito');

            // Regresar al inicio
            return redirect('/')
                ->with('success', '¡Pedido realizado correctamente!');

        } catch (\Exception $e) {

            return redirect()->back()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function misPedidos()
    {
        $cliente = session('cliente');
        $token = session('token');

        if (!$cliente || !$token) {
            return redirect()->route('login')
                ->with('error', 'Inicia sesión para ver tus pedidos');
        }

        try {

            $response = Http::withToken($token)
                ->get(
                    $this->apiUrl .
                    '/pedidos/cliente/' .
                    $cliente['id_cliente']
                );

            if ($response->successful()) {

                $data = $response->json();

                $pedidos = $data['pedidos'] ?? [];

                return view('pedidos.index', compact('pedidos'));
            }

        } catch (\Exception $e) {
            // Manejar error
        }

        return view('pedidos.index', [
            'pedidos' => []
        ]);
    }
    public function index() {
 $response = Http::get('http://127.0.0.1:8001/api/pedidos');
       $pedidos =[];
       
        if($response->successful()){
            $json = $response->object(); 
           if($json->success){
              $pedidos = $json->pedidos ?? [];
             
           }else{
            return redirect()->back()->with('error', $response->json('error'));
           }
            return view('pedidos')->with('pedidos', $pedidos);

        }
        }
}

