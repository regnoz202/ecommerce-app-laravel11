<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = DB::table('categories')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validasi data kategori
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Menyimpan kategori ke database menggunakan DB facade
        DB::table('categories')->insert([
            'name' => $validated['name'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Redirect ke halaman daftar kategori
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        // Menghapus kategori dari database menggunakan DB facade
        DB::table('categories')->where('id', $id)->delete();

        // Redirect ke halaman daftar kategori
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
