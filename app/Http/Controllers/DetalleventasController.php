<?php

namespace App\Http\Controllers;

use App\Models\Detalleventas;
use App\Models\ventas;
use App\Models\producto;
use App\Models\cliente;
use Illuminate\Http\Request;

class DetalleventasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = producto::all();
        $detalleventas = Detalleventas::all();
        return view('detalleventas.index', compact('productos', 'detalleventas'));
    }
    public function index2($id)
    {
        $productos = producto::all();
        $detalleventas = Detalleventas::where('venta_id', $id)->get(); // Filtra detalles por ID de venta
        $venta = ventas::find($id); // Obtiene la venta actual por ID
        return view('detalleventas.index', compact('productos', 'detalleventas', 'venta'));
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

    }

    public function store2(Request $request)
    {
        $validated = $request->validate([
            'cliente' => 'required|string|max:255',
            'metodo' => 'required|string|max:50',
            'celular' => 'required|numeric',
            'descuento' => 'nullable|numeric|min:0',
            'cantidad' => 'required|integer|min:1',
            'producto_id' => 'required|exists:productos,id',
            'venta_id' => 'required|exists:ventas,id',
        ]);

        // Obtener el producto
        $producto = producto::find($validated['producto_id']);

        // Calcular el total
        $totalProducto = $producto->precio * $validated['cantidad'];
        $totalConDescuento = $totalProducto - ($validated['descuento'] ?? 0);

        // Crear un detalle de la venta
        Detalleventas::create([
            'venta_id' => $validated['venta_id'],
            'producto_id' => $validated['producto_id'],
            'monto' => $totalConDescuento,
            'cantidad' => $validated['cantidad'],
            'descuento' => $validated['descuento'] ?? 0,
        ]);

        // Obtener la venta
        $venta = ventas::find($validated['venta_id']);

        // Calcular el total acumulado
        $totalVenta = $venta->detalles->sum('monto');

        // Actualizar el total de la venta
        $venta->update(['total' => $totalVenta]);

        // Redirigir con un mensaje de éxito
        return redirect()->route('detalleventas.index2', ['id' => $validated['venta_id']])->with('success', 'Detalle de venta añadido con éxito.');
    }



    /**
     * Display the specified resource.
     */
    public function show(Detalleventas $detalleventas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Detalleventas $detalleventas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Detalleventas $detalleventas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Detalleventas $detalleventas)
    {
        //
    }
}
