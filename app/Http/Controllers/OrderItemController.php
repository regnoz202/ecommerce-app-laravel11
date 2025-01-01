<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderItemController extends Controller
{
    public function checkoutForm()
    {
        // Menampilkan form checkout
        $cartItems = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->select('carts.*', 'products.name', 'products.price')
            ->get();

        return view('customer.checkout.form', compact('cartItems'));
    }

    public function processCheckout(Request $request)
    {
        // Validasi data checkout
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'address' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            // Simpan data order
            $orderId = DB::table('orders')->insertGetId([
                'customer_name' => $validated['customer_name'],
                'address' => $validated['address'],
                'payment_method' => $validated['payment_method'],
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Pindahkan item dari keranjang ke order_items dan kurangi stok produk
            $cartItems = DB::table('carts')->get();

            foreach ($cartItems as $item) {
                // Simpan ke order_items
                DB::table('order_items')->insert([
                    'order_id' => $orderId,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Kurangi stok produk
                DB::table('products')->where('id', $item->product_id)->decrement('stock', $item->quantity);
            }

            // Hapus semua item dari keranjang
            DB::table('carts')->delete();

            DB::commit();

            return redirect()->route('customer.products.index')->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Terjadi kesalahan saat memproses checkout!');
        }
    }
}
