@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h2>Daftar Produk</h2>
    <a href="{{ route('admin.products.create') }}" class="mb-3 btn btn-success">Tambah Produk</a>
    <a type="" href="{{ route('admin.categories.index') }}" class="mb-3 btn btn-primary">Tambah Category</a>
    <a type="" href="{{ route('customer.products.index') }}" class="mb-3 btn btn-primary">Ke Halaman Utama Produk</a>
    <a type="" href="{{ route('admin.orders.index') }}" class="mb-3 btn btn-primary">Cek Status Order</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Kategori</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->category_name }}</td>
                <td>
                    @if($product->image_url)
                    <img src="{{ asset('storage/' . $product->image_url) }}" alt="Gambar Produk" width="100">
                    @else
                    Tidak ada gambar
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus produk ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
