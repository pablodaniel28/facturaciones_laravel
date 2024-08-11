<?php

namespace App\Http\Controllers;


use App\Models\Detalleventas;
use App\Models\ventas;
use App\Models\producto;
use App\Models\cliente;

use Illuminate\Http\Request;

class VentasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = producto::all();
        $ventas = Ventas::all();
        $detalleventas = Detalleventas::all();
        return view('ventas.index', compact('productos', 'ventas', 'detalleventas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente' => 'required|string|max:255',
            'metodo' => 'required|string|max:50',
            'celular' => 'required|numeric',
            'descuento' => 'nullable|numeric|min:0',
            'cantidad' => 'required|integer|min:1',
            'producto_id' => 'required|exists:productos,id',
        ]);
        $cliente = cliente::where('celular', $validated['celular'])->first();

        if (!$cliente) {
            // Si el cliente no existe, crearlo
            $cliente = cliente::create([
                'nombre' => $validated['cliente'],
                'celular' => $validated['celular'],
            ]);
        }

        $venta = ventas::create([
            'fecha' => now(), // O la fecha actual, o una proporcionada en el formulario
            'metodo' => $validated['metodo'],
            'total' => 0, // Inicializar el total, este será calculado posteriormente
            'cliente_id' => $cliente->id, // Usar el ID del cliente creado o existente
        ]);

        // Obtener el producto
        $producto = producto::find($validated['producto_id']);

        // Calcular el total
        $totalProducto = $producto->precio * $validated['cantidad'];
        $totalConDescuento = $totalProducto - ($validated['descuento'] ?? 0);

        // Crear un detalle de la venta
        Detalleventas::create([
            'venta_id' => $venta->id,
            'producto_id' => $validated['producto_id'],
            'monto' => $totalConDescuento,
            'cantidad' => $validated['cantidad'],
            'descuento' => $validated['descuento'] ?? 0,
        ]);

        // Actualizar el total de la venta
        $venta->update(['total' => $totalConDescuento]);

        // Redirigir con un mensaje de éxito
        return redirect()->route('detalleventas.index2', ['id' => $venta->id])->with('success', 'Venta realizada con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ventas $ventas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ventas $ventas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ventas $ventas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ventas $ventas)
    {
        //
    }
}
