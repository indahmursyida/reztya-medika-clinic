@extends('layout/main')

@section('name', 'Payment Receipt Form')

@section('container')
<div class="border outline-reztya rounded-4 p-5 font-futura-reztya">
    <h2 class="my-3 text-center unselectable font-alander-reztya">Payment Receipt Form</h2>
    <div class="unselectable d-flex justify-content-center mt-2">
        <div class="card card-sign bg-white outline-reztya">
            <div class="card-body">
                <form action="/signup" method="POST">
                    @csrf
                    <div class="d-flex justify-content-center">
                        Resi Pembayaran
                    </div>
                    <div class="form-floating mb-2">
                        <input placeholder="order_date" id="floating_order_date" class="shadow-none form-control @error('order_date') is-invalid @enderror" type="date" name="order_date" value="{{old('order_date')}}">
                        <label for="floating_order_date" class="font-futura-reztya">Tanggal Pesanan</label>
                        @error('order_date')
                        <div class="invalid-feedback">
                            Tanggal Pesanan wajib diisi
                        </div>
                        @enderror
                    </div>
                    <div class="form-floating mb-2" autofocus>
                        <input placeholder="Customer Name" id="floating_customer_name" class="shadow-none form-control @error('customer_name') is-invalid @enderror" type="text" name="customer_name" value="{{old('customer_name')}}" autofocus>
                        <label for="floating_customer_name" class="font-futura-reztya">Nama Pelanggan</label>
                        @error('customer_name')
                        <div class="invalid-feedback">
                            Nama Pelanggan wajib diisi
                        </div>
                        @enderror
                    </div>
                    <div class="form-floating mb-2">
                        <input placeholder="Account Number" id="floating_account_number" class="shadow-none form-control @error('account_number') is-invalid @enderror" type="text" name="account_number" value="{{old('account_number')}}">
                        <label for="floating_account_number" class="font-futura-reztya">Nomor Akun Bank</label>
                        @error('account_number')
                        <div class="invalid-feedback">
                            Nomor Akun Bank wajib diisi
                        </div>
                        @enderror
                    </div>
                    <div class="form-floating mb-2">
                        <input placeholder="Payment Date" id="floating_payment_date" class="shadow-none form-control @error('payment_date') is-invalid @enderror" type="date" name="payment_date" value="{{old('payment_date')}}">
                        <label for="floating_payment_date" class="font-futura-reztya">Tanggal Pembayaran</label>
                        @error('payment_date')
                        <div class="invalid-feedback">
                            Tanggal Pembayaran wajib diisi
                        </div>
                        @enderror
                    </div>
                    
                    <div class="form-floating mb-2">
                        <input placeholder="Jumlah Pembayaran" id="floating_payment_amount" class="shadow-none form-control @error('payment_amount') is-invalid @enderror" type="number" name="payment_amount" value="{{ old('payment_amount')}}">
                        <label for="payment_amount" class="font-futura-reztya">Jumlah Pembayaran (Rp)</label>
                        @error('payment_amount')
                        <div class="invalid-feedback">
                            Jumlah Pembayaran wajib diisi
                        </div>
                        @enderror
                    </div>
                    <div class="form-floating mb-2 border rounded-2">
                        <p class="mb-1 mt-2 ms-3" style="color: grey; font-size: 14px;">Metode Pembayaran</p>
                        <div class="mb-1">
                            <input type="radio" id="cash" class="ms-3" name="payment_method" value="Cash">
                            <label for="cash">Cash</label>
                            <input type="radio" id="transfer" class="ms-2" name="payment_method" value="Transfer">
                            <label for="transfer">Transfer</label>
                        </div>
                        @error('payment_method')
                        <div class="invalid-feedback">
                            Metode Pembayaran wajib diisi
                        </div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-center">
                        Verifikasi Admin
                    </div>
                    <div class="form-floating mb-2">
                        <input placeholder="Nama Admin" id="floating_admin_name" class="shadow-none form-control @error('admin_name') is-invalid @enderror" type="text" name="admin_name" value="{{old('admin_name')}}">
                        <label for="floating_admin_name" class="font-futura-reztya">Nama Admin</label>
                        @error('admin_name')
                        <div class="invalid-feedback">
                            Nama Admin wajib diisi
                        </div>
                        @enderror
                    </div>
                    <div class="form-floating mb-2">
                        <input placeholder="Password Admin" id="floating_password" class="shadow-none form-control @error('password') is-invalid @enderror" type="password" name="password" value="{{old('password')}}">
                        <label for="floating_password" class="font-futura-reztya">Kata Sandi</label>
                        @error('password')
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
</div>
@endsection