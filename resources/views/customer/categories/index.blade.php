@extends('layouts.customer')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Daftar Kategori</h2>
    <div class="row">
        @foreach($categories as $category)
        <div class="mb-4 col-md-4">
            <div class="card">
                <div class="text-center card-body">
                    <h5 class="card-title">{{ $category->name }}</h5>
                    <a href="{{ route('customer.categories.show', $category->id) }}" class="btn btn-primary">Lihat Produk</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
