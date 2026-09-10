<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class ProductosController extends Controller
{
    public function index()
    {
        $response = Http::get('http://127.0.0.1:8001/api/productos');

        if ($response->successful()) {

            $json = $response->object();

            if ($json->resultado) {

                $productos = $json->datos;

                return view('menu.cafe', compact('productos'));

            } else {

                return redirect()->back()->with(
                    'error',
                    $json->error ?? 'La API no devolvió resultados'
                );
            }
        }

        // IMPORTANTE: mostrar el error de la API
        return response()->json([
            'status' => $response->status(),
            'body' => $response->body()
        ]);
    }

    public function show($id_producto)
    {
        $response = Http::get(
            "http://127.0.0.1:8001/api/productos/$id_producto"
        );

        if ($response->successful()) {

            $productos = $response->object()->datos;

            return view('menu.detalle', compact('productos'));
        }

        return redirect()->back()->with(
            'error',
            'Producto no encontrado'
        );
    }
}