<?php

namespace App\Http\Controllers;

use App\Exports\Productoexport;
use App\Imports\Productoimport;
use App\Models\producto;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

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
    public function base64EncodeImage($path)
    {
        $imgData = file_get_contents(public_path($path));
        return 'data:image/jpeg;base64,' . base64_encode($imgData);
    }

    // En el controlador
    public function exportPdf()
    {
        // Obtener todos los productos
        $productos = Producto::all();

        // Pasar la función para convertir imágenes a Base64 a la vista
        $pdf = Pdf::loadView('producto.pdf', [
            'productos' => $productos,
            'base64EncodeImage' => function ($path) {
                $imgData = file_get_contents(public_path($path));
                return 'data:image/jpeg;base64,' . base64_encode($imgData);
            }
        ]);

        // Mostrar el PDF en el navegador
        return $pdf->stream('productos.pdf');
    }



    public function import(Request $request)
    {
        $file = $request->file('documento');
        Excel::import(new Productoimport, $file);
        return back()->with('status', 'Productos importados con éxito');
    }
    public function export()
    {
        return Excel::download(new Productoexport(), 'productos.xlsx');
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
    public function edit(Producto $producto)
    {
        // Pasar el producto a la vista
        return view('producto.editar', ['producto' => $producto]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        // Validar la entrada del formulario
        $validated = $request->validate([
            'codigo' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'cantidad' => 'required|integer',
            'estado' => 'required|in:activo,desactivado',
            'multimedia' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación de la imagen
        ]);

        // Actualizar los datos del producto
        $producto->update([
            'codigo' => $validated['codigo'],
            'nombre' => $validated['nombre'],
            'precio' => $validated['precio'],
            'cantidad' => $validated['cantidad'],
            'estado' => $validated['estado'],
        ]);

        // Verificar si se ha subido un archivo
        if ($request->hasFile('multimedia')) {
            // Eliminar la imagen anterior si existe
            if ($producto->img) {
                Storage::delete('public/multimedia/' . $producto->img);
            }

            // Guardar la nueva imagen
            $file = $request->file('multimedia');
            $imagePath = $file->store('public/multimedia');

            // Extraer el nombre del archivo
            $fileName = basename($imagePath);

            // Actualizar el path de la imagen en el producto
            $producto->update(['img' => $fileName]);
        }

        // Redirigir a la lista de productos con un mensaje de éxito
        return redirect()->route('productos.index')->with('success', 'Producto actualizado con éxito.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        // Verificar si existe una imagen asociada
        if ($producto->img) {
            // Eliminar la imagen del almacenamiento
            Storage::delete('public/multimedia/' . $producto->img);
        }

        // Eliminar el producto de la base de datos
        $producto->delete();

        // Redirigir a la lista de productos con un mensaje de éxito
        return redirect()->route('productos.index')->with('success', 'Producto eliminado con éxito.');
    }

}
