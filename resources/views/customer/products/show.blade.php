@extends('layouts.customer')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ asset('storage/' . $product->image_url) }}" class="img-fluid" alt="{{ $product->name }}">
        </div>
        <div class="col-md-6">
            <h2>{{ $product->name }}</h2>
            <p>Kategori: <strong>{{ $product->category_name }}</strong></p>
            <p>{{ $product->description }}</p>
            <h4 class="text-success">Rp{{ number_format($product->price, 0, ',', '.') }}</h4>
            <p>Stok: {{ $product->stock }}</p>

            {{-- Form untuk menambah ke keranjang --}}
            <form action="{{ route('customer.cart.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="form-group">
                    <label for="quantity">Jumlah</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" max="{{ $product->stock }}" required>
                </div>
                <button type="submit" class="mt-3 btn btn-success">Tambah ke Keranjang</button>
            </form>
        </div>
    </div>
</div>
@endsection
