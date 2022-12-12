@extends('layout/main')

@section('title', 'Payment Receipt Form')

@section('container')
@php
use Carbon\Carbon;
@endphp
<h2 class="my-3 text-center unselectable font-alander-reztya">Konfirmasi Pembayaran</h2>
<div class="unselectable d-flex justify-content-center mt-3 mb-5">
    <div class="card card-sign bg-white outline-reztya">
        <div class="card-body">
            <form action="/add-payment-receipt/{{$order->order_id}}" method="POST" enctype="multipart/form-data" class="needs-validation">
                @method('post')
                @csrf

                @if($order->status == 'WAITING')
                <div class="d-flex justify-content-center my-4">
                    <img class="img-preview img-fluid img-responsive img-thumbnail" width="300" height="300">
                </div>

                <div class="form-floating mb-2">
                    <input placeholder="order_date" disabled id="floating_order_date" class="shadow-none form-control" type="date" name="order_date" value="{{ old('order_date', $order->order_date)}}">
                    <label for="floating_order_date" class="font-futura-reztya">Tanggal Pesanan (Bulan/Tanggal/Tahun)</label>
                </div>

                <div class="form-floating mb-2" autofocus>
                    <input placeholder="Customer Name" disabled id="floating_customer_name" class="shadow-none form-control" type="text" name="customer_name" value="{{old('customer_name', $order->user->name)}}" >
                    <label for="floating_customer_name" class="font-futura-reztya">Nama Pelanggan</label>
                </div>

                <div class="form-floating mb-2">
                    <input disabled class="shadow-none form-control" type="text" name="payment_method" value="{{ old('payment_method', $payment_receipt->payment_method)}}">
                    <label for="floating_select">Metode Pembayaran</label>
                </div>

                <div class="form-floating mb-2">
                    <input disabled id="floating_payment_date" class="shadow-none form-control" type="date" name="payment_date" value="{{ old('payment_date', $payment_receipt->payment_date) }}">
                    <label for="floating_payment_date" class="font-futura-reztya">Tanggal Transfer (Bulan/Tanggal/Tahun)</label>
                </div>

                <div class="form-floating mb-2">
                    <input disabled id="floating_account_number" class="shadow-none form-control" type="text" name="account_number" value="{{ old('account_number', $payment_receipt->account_number)}}">
                    <label for="floating_account_number" class="font-futura-reztya">Nomor Akun Bank</label>
                </div>

                <div class="form-floating mb-2">
                    <input disabled id="floating_account_name" class="shadow-none form-control" type="text" name="account_name" value="{{ old('account_name', $payment_receipt->account_name)}}">
                    <label for="floating_account_name" class="font-futura-reztya">Nama Akun Bank</label>
                </div>

                <div class="form-floating mb-2">
                    <input disabled id="floating_payment_amount" class="shadow-none form-control" type="text" name="payment_amount" value="Rp{{ old('payment_amount', number_format($payment_receipt->payment_amount, 2))}}">
                    <label for="payment_amount" class="font-futura-reztya">Total Transfer</label>
                </div>

                @elseif($order->status == 'ON GOING')
                <div class="form-floating mb-2">
                    <input placeholder="order_date" disabled id="floating_order_date" class="shadow-none form-control" type="date" name="order_date" value="{{ old('order_date', $order->order_date)}}">
                    <label for="floating_order_date" class="font-futura-reztya">Tanggal Pesanan (Bulan/Tanggal/Tahun)</label>
                </div>
                <div class="form-floating mb-2" autofocus>
                    <input placeholder="Customer Name" disabled id="floating_customer_name" class="shadow-none form-control" type="text" name="customer_name" value="{{old('customer_name', $order->user->name)}}" >
                    <label for="floating_customer_name" class="font-futura-reztya">Nama Pelanggan</label>
                </div>
                <div class="form-floating mb-2">
                    <input disabled class="shadow-none form-control" type="text" name="payment_method" value="Cash">
                    {{-- <select class="form-select align-items-middle @error('payment_method') is-invalid @enderror" id="floating_select" onchange="payment_method_select_handler(this)" name="payment_method">
                        <option>-- Pilih satu --</option>
                        <option class="align-middle" value="Cash">Cash</option>
                        <option class="align-middle" value="Transfer">Transfer</option>
                    </select> --}}
                    <label for="floating_select">Metode Pembayaran</label>
                    {{-- <div class="mb-1 radio">
                        <label><input type="radio" class="ms-3" name="payment_method" value="Cash">Cash</label>
                        <label><input type="radio" class="ms-2" name="payment_method" value="Transfer">Transfer</label>
                    </div> --}}
                </div>
                <div class="form-floating mb-2">
                    <input placeholder="Payment Date" disabled id="floating_payment_date" class="shadow-none form-control" type="date" name="payment_date" value="{{ date("Y-m-d", strtotime("now")) }}">
                    <label for="floating_payment_date" class="font-futura-reztya">Tanggal Pembayaran (Bulan/Tanggal/Tahun)</label>
                </div>

                <div class="form-floating mb-2">
                    <input id="floating_payment_amount" disabled class="shadow-none form-control" type="text" name="payment_amount" value="Rp{{ old('payment_amount', number_format($totalPrice, 2))}}">
                    <label for="payment_amount" class="font-futura-reztya">Total Pembayaran</label>
                </div>
                @endif

                <div class="d-flex justify-content-center">
                    Verifikasi Admin
                </div>
                <div class="form-floating mb-2">
                    <input placeholder="Username Admin" id="floating_confirmed_by" class="shadow-none form-control" type="text" name="confirmed_by" value="{{old('username', Auth::user()->username)}}">
                    <label for="floating_confirmed_by" class="font-futura-reztya">Username Admin</label>
                    @error('confirmed_by')
                    <div class="invalid-feedback">
                        Username Admin wajib diisi
                    </div>
                    @enderror
                </div>
                <div class="form-floating mb-2">
                    <input placeholder="Password Admin" id="floating_admin_password" class="shadow-none form-control @error('admin_password') is-invalid @enderror" type="password" name="admin_password" value="{{old('password')}}">
                    <label for="floating_admin_password" class="font-futura-reztya">Kata Sandi</label>
                    @error('admin_password')
                    <div class="invalid-feedback">
                        Kata Sandi wajib diisi
                    </div>
                    @enderror
                </div>
                <div class="d-grid gap-2">
                    <button class="btn button-outline-reztya font-futura-reztya" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    // var selected;
    // function payment_method_select_handler(select)
    // {
    //     var e = document.getElementById("account_number");
    //     if(select.value == "Transfer")
    //     {
    //         e.style.display = 'block';
    //     }
    //     else if(select.value == "Cash")
    //     {
    //         e.style.display = 'none';
    //     }
    //     selected = select.value;
    //     console.log(selected);
    // }
</script>
@endsection
