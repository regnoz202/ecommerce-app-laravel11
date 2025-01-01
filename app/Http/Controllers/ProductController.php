<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = DB::table('products')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->select('products.*', 'categories.name as category_name')
        ->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validasi data request (jika diperlukan)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Proses upload gambar
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // Menyimpan data produk langsung ke database menggunakan DB facade
        DB::table('products')->insert([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'category_id' => $validated['category_id'],
            'image_url' => $imagePath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Redirect ke halaman daftar produk setelah berhasil menyimpan
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

     // Menampilkan form edit produk
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Menyimpan perubahan produk menggunakan DB
    public function update(Request $request, $id)
    {
        // Validasi data request (jika diperlukan)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $product = DB::table('products')->where('id', $id)->first();

        if (!$product) {
            abort(404, 'Produk tidak ditemukan');
        }

         // Proses upload gambar baru jika ada
         $imagePath = $product->image_url;
         if ($request->hasFile('image')) {
             // Hapus gambar lama jika ada
             if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                 Storage::disk('public')->delete($imagePath);
             }
 
             $imagePath = $request->file('image')->store('products', 'public');
         }

        // Update data produk menggunakan DB facade
        DB::table('products')->where('id', $id)->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'category_id' => $validated['category_id'],
            'image_url' => $imagePath,
            'updated_at' => now(),
        ]);

        // Redirect ke halaman daftar produk setelah berhasil mengupdate
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }
        // Menghapus produk menggunakan DB
        public function destroy($id)
        {

            $product = DB::table('products')->where('id', $id)->first();

            if (!$product) {
                abort(404, 'Produk tidak ditemukan');
            }

            // Hapus gambar jika ada
            if ($product->image_url && Storage::disk('public')->exists($product->image_url)) {
                Storage::disk('public')->delete($product->image_url);
            }

            // Menghapus data produk menggunakan DB facade
            DB::table('products')->where('id', $id)->delete();
    
            // Redirect ke halaman daftar produk setelah berhasil menghapus
            return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
        }    
}
