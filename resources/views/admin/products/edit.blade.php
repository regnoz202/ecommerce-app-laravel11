@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h2>Edit Produk</h2>
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nama Produk</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
        </div>
        <div class="form-group">
            <label for="description">Deskripsi Produk</label>
            <textarea class="form-control" id="description" name="description">{{ $product->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="price">Harga Produk</label>
            <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}" required>
        </div>
        <div class="form-group">
            <label for="stock">Stok Produk</label>
            <input type="number" class="form-control" id="stock" name="stock" value="{{ $product->stock }}" required>
        </div>
        <div class="form-group">
            <label for="category_id">Kategori</label>
            <select class="form-control" id="category_id" name="category_id" required>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" @if($category->id == $product->category_id) selected @endif>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="image">Gambar Produk</label>
            <input type="file" class="form-control" id="image" name="image">
            @if($product->image_url)
            <p>Gambar saat ini:</p>
            <img src="{{ asset('storage/' . $product->image_url) }}" alt="Gambar Produk" width="150">
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
