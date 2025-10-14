<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    // Listar categorías 
    public function index()
    {
        return response()->json(Categoria::all(), 200);
    }

    // Crear nueva categoría
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'estado' => 'required|in:A,I',
        ]);

        $categoria = Categoria::create($request->all());
        return response()->json($categoria, 201);
    }

    // Mostrar categoría por ID
    public function show($id)
    {
        $categoria = Categoria::findOrFail($id);
        return response()->json($categoria, 200);
    }

    // Actualizar categoría
    public function update(Request $request, $id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->update($request->all());
        return response()->json($categoria, 200);
    }

    // Eliminar categoría
    public function destroy($id)
    {
        Categoria::destroy($id);
        return response()->json(['message' => 'Categoría eliminada'], 200);
    }
}