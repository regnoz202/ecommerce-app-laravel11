@extends('layouts.customer')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Produk pada Kategori: {{ $category->name }}</h2>
    <div class="row">
        @forelse($products as $product)
        <div class="mb-4 col-md-4">
            <div class="card">
                <img src="{{ asset('storage/' . $product->image_url) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ Str::limit($product->description, 50) }}</p>
                    <p class="card-text text-success">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                    <a href="{{ route('customer.products.show', $product->id) }}" class="btn btn-primary">Detail</a>
                </div>
            </div>
        </div>
        @empty
        <p>Tidak ada produk dalam kategori ini.</p>
        @endforelse
    </div>
</div>
@endsection
