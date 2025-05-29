<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller
{
    // Menampilkan semua kategori
    public function index(): JsonResponse
    {
        $categories = Category::with('product')->get();
        return response()->json($categories, 200);
    }

    // Menampilkan satu kategori berdasarkan ID
    public function show($id): JsonResponse
    {
        try {
            $category = Category::with('product')->findOrFail($id);
            return response()->json($category, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Kategori tidak ditemukan.'], 404);
        }
    }

    // Menambahkan kategori baru
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $category = Category::create($request->only(['product_id', 'name', 'description']));

        return response()->json([
            'message' => 'Kategori berhasil ditambahkan.',
            'data' => $category
        ], 201);
    }

    // Mengupdate kategori
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $category = Category::findOrFail($id);

            $request->validate([
                'product_id' => 'sometimes|exists:products,id',
                'name' => 'sometimes|string|max:255',
                'description' => 'sometimes|string',
            ]);

            $category->update($request->only(['product_id', 'name', 'description']));

            return response()->json([
                'message' => $category->wasChanged()
                    ? 'Kategori berhasil diperbarui.'
                    : 'Tidak ada perubahan.',
                'data' => $category
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Kategori tidak ditemukan.'], 404);
        }
    }

    // Menghapus kategori
    public function destroy($id): JsonResponse
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();

            return response()->json(['message' => 'Kategori berhasil dihapus.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Kategori tidak ditemukan.'], 404);
        }
    }
}
