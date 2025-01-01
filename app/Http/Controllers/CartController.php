<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        // Menampilkan semua item di keranjang
        $cartItems = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->select('carts.*', 'products.name', 'products.price', 'products.image_url')
            ->get();

        return view('customer.cart.index', compact('cartItems'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Periksa apakah produk sudah ada di keranjang
        $existingCart = DB::table('carts')->where('product_id', $validated['product_id'])->first();

        if ($existingCart) {
            // Jika ada, tambahkan jumlahnya
            DB::table('carts')->where('product_id', $validated['product_id'])->update([
                'quantity' => $existingCart->quantity + $validated['quantity'],
            ]);
        } else {
            // Jika belum ada, tambahkan produk ke keranjang
            DB::table('carts')->insert([
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('customer.cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function destroy($id)
    {
        // Menghapus item dari keranjang
        DB::table('carts')->where('id', $id)->delete();

        return redirect()->route('customer.cart.index')->with('success', 'Produk berhasil dihapus dari keranjang!');
    }
}
