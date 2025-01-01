@extends('layouts.customer')

@section('content')
<div class="container mt-5">
    <h2>Checkout</h2>

    <form action="{{ route('customer.checkout.process') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="customer_name">Nama Lengkap</label>
            <input type="text" class="form-control" id="customer_name" name="customer_name" required>
        </div>

        <div class="form-group">
            <label for="address">Alamat</label>
            <textarea class="form-control" id="address" name="address" required></textarea>
        </div>

        <div class="form-group">
            <label for="payment_method">Metode Pembayaran</label>
            <select class="form-control" id="payment_method" name="payment_method" required>
                <option value="Bank Transfer">Bank Transfer</option>
                <option value="Cash On Delivery">Cash On Delivery</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Checkout</button>
    </form>

    <h3 class="mt-4">Item yang Anda beli:</h3>
    <ul>
        @foreach($cartItems as $item)
            <li>{{ $item->name }} ({{ $item->quantity }})</li>
        @endforeach
    </ul>
</div>
@endsection
