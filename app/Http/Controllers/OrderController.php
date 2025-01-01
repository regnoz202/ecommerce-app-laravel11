<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        // Menampilkan semua pesanan
        $orders = DB::table('orders')->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        // Validasi input status
        $validated = $request->validate([
            'status' => 'required|string|in:Pending,Packing,Shipped',
        ]);

        // Update status pesanan
        DB::table('orders')->where('id', $id)->update([
            'status' => $validated['status'],
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Status pesanan berhasil diperbarui!');
    }

    public function destroy($id)
{
    // Ambil data pesanan berdasarkan ID
    $order = DB::table('orders')->where('id', $id)->first();

    // Periksa jika status adalah "Shipped"
    if ($order->status === 'Shipped') {
        DB::table('orders')->where('id', $id)->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil dihapus!');
    }

    return redirect()->route('admin.orders.index')->withErrors('Hanya pesanan dengan status "Shipped" yang dapat dihapus!');
}
}
