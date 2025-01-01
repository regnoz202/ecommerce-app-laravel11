@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <!-- Form untuk menambahkan kategori -->
    <h3>Tambah Kategori</h3>
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nama Kategori</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="mt-3 btn btn-primary">Simpan</button>
        <a type="" href="{{ route('admin.products.index') }}" class="mt-3 btn btn-primary">Kembali Ke Produk</a>
    </form>

    <hr>

    <!-- Menampilkan daftar kategori -->
    <h2>Daftar Kategori</h2>
    <table class="table mt-3 table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $category->name }}</td>
                <td>
                    <!-- Form untuk menghapus kategori -->
                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus kategori ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
