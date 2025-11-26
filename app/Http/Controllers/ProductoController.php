<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    // Respuesta en JSON
    public function index()
    {
        $productos = Producto::where('estado', 'A')
            ->whereHas('categoria', function ($query) {
                $query->where('estado', 'A');
            })
            ->with('categoria:id,nombre,estado')
            ->get();

        return response()->json($productos, 200);
    }

    // CRUD 
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'categoria_id' => 'required|exists:categorias,id',
            'stock' => 'required|integer|min:0',
            'precio' => 'required|numeric|min:0',
            'estado' => 'required|in:A,I'
        ]);

        $producto = Producto::create($request->all());
        return response()->json($producto, 201);
    }

    public function show($id)
    {
        $producto = Producto::with('categoria')->findOrFail($id);
        return response()->json($producto);
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        $producto->update($request->all());
        return response()->json($producto);
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();
        return response()->json(['message' => 'Producto eliminado correctamente']);
    }

    public function paginarPorCantidad(Request $request)
    {
        $cantidad = $request->query('cantidad', 5);

        $productos = Producto::where('estado', 'A')
            ->whereHas('categoria', function ($query) {
                $query->where('estado', 'A');
            })
            ->with('categoria:id,nombre,estado')
            ->paginate($cantidad);

        return response()->json($productos, 200);
    }

    public function paginarPorCantidadYPagina(Request $request)
    {
        $cantidad = $request->query('cantidad', 5);
        $pagina = $request->query('pagina', 1);

        $productos = Producto::where('estado', 'A')
            ->whereHas('categoria', function ($query) {
                $query->where('estado', 'A');
            })
            ->with('categoria:id,nombre,estado')
            ->paginate($cantidad, ['*'], 'page', $pagina);

        return response()->json($productos, 200);
    }

    public function actualizarStock(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $request->validate([
            'cantidad' => 'required|integer|min:0'
        ]);

        $cantidad = $request->cantidad;

        if ($cantidad < $producto->stock) {
            $producto->stock -= $cantidad; // Resta
        } else {
            $producto->stock += $cantidad; // Suma
        }

        $producto->save();

        return response()->json([
            'message' => 'Stock actualizado correctamente',
            'nuevo_stock' => $producto->stock
        ], 200);
    }

    public function buscar(Request $request)
    {
        $nombre = $request->query('nombre', '');

        $productos = Producto::where('estado', 'A')
            ->where('nombre', 'LIKE', "%$nombre%")
            ->whereHas('categoria', function ($query) {
                $query->where('estado', 'A');
            })
            ->with('categoria:id,nombre,estado')
            ->get();

        return response()->json($productos, 200);
    }


}
