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
                    <div class="form-floating mb-2">
                        <input placeholder="order_date" id="floating_order_date" class="shadow-none form-control @error('order_date') is-invalid @enderror" type="date" name="order_date" value="{{old('order_date')}}">
                        <label for="floating_order_date" class="font-futura-reztya">Tanggal Pesan</label>
                        @error('order_date')
                        <div class="invalid-feedback">
                            Tanggal pesan wajib diisi
                        </div>
                        @enderror
                    </div>
                    <div class="form-floating mb-2" autofocus>
                        <input placeholder="Customer Name" id="floating_customer_name" class="shadow-none form-control @error('customer_name') is-invalid @enderror" type="text" name="customer_name" value="{{old('customer_name')}}" autofocus>
                        <label for="floating_customer_name" class="font-futura-reztya">Customer Name</label>
                        @error('customer_name')
                        <div class="invalid-feedback">
                            Nama customer wajib diisi
                        </div>
                        @enderror
                    </div>
                    <div class="form-floating mb-2">
                        <input placeholder="Account Number" id="floating_account_number" class="shadow-none form-control @error('account_number') is-invalid @enderror" type="text" name="account_number" value="{{old('account_number')}}">
                        <label for="floating_account_number" class="font-futura-reztya">Account Number</label>
                        @error('account_number')
                        <div class="invalid-feedback">
                            Nomor rekening wajib diisi
                        </div>
                        @enderror
                    </div>
                    <div class="form-floating mb-2">
                        <input placeholder="Payment Date" id="floating_payment_date" class="shadow-none form-control @error('payment_date') is-invalid @enderror" type="date" name="payment_date" value="{{old('payment_date')}}">
                        <label for="floating_payment_date" class="font-futura-reztya">Tanggal Pembayaran</label>
                        @error('payment_date')
                        <div class="invalid-feedback">
                            Tanggal pembayaran wajib diisi
                        </div>
                        @enderror
                    </div>
                    <div class="form-floating mb-2">
                        <input placeholder="Jumlah Pembayaran" id="floating_payment_amount" class="shadow-none form-control @error('payment_amount') is-invalid @enderror" type="number" name="payment_amount" value="{{old('payment_amount')}}">
                        <label for="payment_amount" class="font-futura-reztya">Nomor Telepon</label>
                        @error('payment_amount')
                        <div class="invalid-feedback">
                            Jumlah pembayaran wajib diisi
                        </div>
                        @enderror
                    </div>
                    <div class="form-floating mb-2">
                        <input type="radio" id="cash" name="payment_method" value="Cash">
                        <label for="cash">Cash</label><br>
                        <input type="radio" id="transfer" name="payment_method" value="Transfer">
                        <label for="transfer">Transfer</label> <br>
                        @error('payment_method')
                        <div class="invalid-feedback">
                            Metode pembayaran wajib diisi
                        </div>
                        @enderror
                    </div>
                    <div class="form-floating mb-2">
                        <input placeholder="Email" id="floatingEmail" class="shadow-none form-control @error('email') is-invalid @enderror" type="text" name="email" value="{{old('email')}}">
                        <label for="floatingEmail" class="font-futura-reztya">Email</label>
                        @error('email')
                        <div class="invalid-feedback">
                            Email wajib diisi
                        </div>
                        @enderror
                    </div>
                    <div class="form-floating mb-2">
                        <input placeholder="Password" id="floatingPassword" class="shadow-none form-control @error('password') is-invalid @enderror" type="password" name="password" value="{{old('password')}}">
                        <label for="floatingPassword" class="font-futura-reztya">Kata Sandi</label>
                        @error('password')
                        <div class="invalid-feedback">
                            Kata sandi wajib diisi
                        </div>
                        @enderror
                    </div>
                    <div class="form-floating mb-2">
                        <input placeholder="Confirm Password" id="floatingConfirmPassword" class="shadow-none form-control @error('confirm_password') is-invalid @enderror" type="password" name="confirm_password" value="{{old('confirm_password')}}">
                        <label for="floatingConfirmPassword" class="font-futura-reztya">Konfirmasi Kata Sandi</label>
                        @error('confirm_password')
                        <div class="invalid-feedback">
                            Konfirmasi kata sandi wajib diisi / Konfirmasi kata sandi tidak sesuai dengan kata sandi.
                        </div>
                        @enderror
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn button-outline-reztya font-futura-reztya" type="submit">Daftar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <h5 class="d-flex justify-content-end">Total Price</h5>
    <div class="d-flex justify-content-center">
        <button class="btn button-outline-reztya" type="button">Pesan</button>
    </div>
</div>
@endsection