@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h2>Daftar Pesanan</h2>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Alamat</th>
                <th>Metode Pembayaran</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ $order->address }}</td>
                    <td>{{ $order->payment_method }}</td>
                    <td>{{ $order->status }}</td>
                    <td>
                        {{-- Tombol Ubah Status --}}
                        @if ($order->status !== 'Shipped')
                            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="Shipped">
                                <button class="btn btn-primary btn-sm">Ubah ke Shipped</button>
                            </form>
                        @endif

                        {{-- Tombol Hapus --}}
                        @if ($order->status === 'Shipped')
                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
