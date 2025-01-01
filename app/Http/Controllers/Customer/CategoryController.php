<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    // Menampilkan daftar kategori
    public function index()
    {
        $categories = DB::table('categories')->get();

        return view('customer.categories.index', compact('categories'));
    }

    // Menampilkan produk berdasarkan kategori
    public function show($id)
    {
        $category = DB::table('categories')->where('id', $id)->first();

        if (!$category) {
            abort(404, 'Kategori tidak ditemukan');
        }

        $products = DB::table('products')
            ->where('category_id', $id)
            ->get();

        return view('customer.categories.show', compact('category', 'products'));
    }
}
