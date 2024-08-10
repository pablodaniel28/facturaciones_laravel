<?php

namespace App\Http\Controllers;

use App\Imports\Productoimport;
use App\Models\producto;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $productos = producto::all();
        return view('producto.index', compact('productos'));
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

    public function import(Request $request)
    {
        $file = $request->file('documento');
        Excel::import(new Productoimport, $file);
        return back()->with('status', 'Productos importados con éxito');
    }

    public function store(Request $request)
    {
        // Validar la solicitud
        $validatedData = $request->validate([
            'codigo' => 'required|string|max:155',
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'cantidad' => 'required|integer|min:0',
            'estado' => 'required|in:activado,desactivado',
            'multimedia' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048', // Validar el archivo multimedia
        ]);

        // Inicializar una variable para la ruta de la imagen
        $imagePath = 'default.png'; // Valor predeterminado en caso de que no se cargue una imagen

        // Verificar si se ha subido un archivo
        if ($request->hasFile('multimedia')) {
            $file = $request->file('multimedia');
            $allowedExtensions = ['jpeg', 'jpg', 'png', 'gif'];

            // Validar la extensión del archivo
            if (!in_array($file->getClientOriginalExtension(), $allowedExtensions)) {
                return back()->withErrors(['multimedia' => 'Solo se permiten archivos JPG, JPEG, PNG y GIF.']);
            }

            // Guardar el archivo en el directorio 'public/multimedia'
            $imagePath = $file->store('public/multimedia');
        }

        // Crear un nuevo producto con los datos validados
        $producto = new Producto([
            'codigo' => $validatedData['codigo'],
            'nombre' => $validatedData['nombre'],
            'precio' => $validatedData['precio'],
            'cantidad' => $validatedData['cantidad'],
            'estado' => $validatedData['estado'],
            'img' => basename($imagePath), // Usar el nombre del archivo guardado
        ]);

        // Guardar el producto en la base de datos
        $producto->save();

        // Redirigir con un mensaje de éxito
        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }








    /**
     * Display the specified resource.
     */
    public function show(producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, producto $producto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(producto $producto)
    {
        //
    }
}
