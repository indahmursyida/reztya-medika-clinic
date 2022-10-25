@extends('layout/main')

@section('name', 'Active Order')

@section('container')
{{-- Member --}}
{{-- <div class="border outline-reztya rounded-4 p-5 font-futura-reztya">
    <h2 class="my-3 text-center font-alander-reztya">Active Order</h2>
    <div class="d-flex justify-content-between">
        <h4>Order Date</h4>
        <h4>Total Cost</h4>
    </div>
    <div class="d-flex flex-column ms-5">
        <h4>Perawatan</h4>
        <table class="table">
            <tbody>
                <tr>
                    <td class="col"><img src="storage/reztya_logo.png" alt="" width="200px" height="200px"></td>
                    <td class="col">
                        <p>Nama Perawatan</p>
                        <div class="d-flex justify-content-around">
                            <p>Schedule</p>
                            <button class="btn button-outline-reztya btn-sm" type="button">Atur Ulang Jadwal</button>
                        </div>
                    </td>
                    <td class="col">Quantity</td>
                    <td class="col">Price</td>
                    <td class="col">
                        <button class="btn btn-danger">
                            Remove
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="d-flex flex-column ms-5">
        <h4>Produk</h4>
        <table class="table">
            <tbody>
                <tr>
                    <td class="col"><img src="storage/reztya_logo.png" alt="" width="200px" height="200px"></td>
                    <td class="col">Product Name</td>
                    <td class="col">Quantity</td>
                    <td class="col">Price</td>
                    <td class="col">
                        <button class="btn btn-danger">
                            Remove
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <h5 class="d-flex justify-content-end">Total Price</h5>
    <div class="d-flex justify-content-center">
        <button class="btn button-outline-reztya" type="button">Batalkan Pesanan</button>
    </div>
</div> --}}
<div class="border outline-reztya rounded-4 p-5 font-futura-reztya">
    <h2 class="my-3 text-center font-alander-reztya">Active Order</h2>
    <div class="d-flex justify-content-between">
        <h4>Order Date</h4>
        <h4>Total Cost</h4>
    </div>
    <div class="d-flex flex-column ms-5">
        <p>Customer Name</p>
        <p>Customer Phone No</p>
        <p>Customer Address</p>
    </div>
    <div class="d-flex flex-column ms-5">
        <h4>Perawatan</h4>
        <table class="table">
            <tbody>
                <tr>
                    <td class="col"><img src="storage/reztya_logo.png" alt="" width="200px" height="200px"></td>
                    <td class="col">
                        <p>Nama Perawatan</p>
                        <div class="d-flex justify-content-around">
                            <p>Schedule</p>
                            <button class="btn button-outline-reztya btn-sm" type="button">Atur Ulang Jadwal</button>
                        </div>
                    </td>
                    <td class="col">Quantity</td>
                    <td class="col">Price</td>
                    <td class="col">
                        <button class="btn btn-danger">
                            Remove
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="d-flex flex-column ms-5">
        <h4>Produk</h4>
        <table class="table">
            <tbody>
                <tr>
                    <td class="col"><img src="storage/reztya_logo.png" alt="" width="200px" height="200px"></td>
                    <td class="col">Product Name</td>
                    <td class="col">Quantity</td>
                    <td class="col">Price</td>
                    <td class="col">
                        <button class="btn btn-danger">
                            Remove
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <h5 class="d-flex justify-content-end">Total Price</h5>
    <div class="d-flex justify-content-center">
        <button class="btn button-outline-reztya" type="button">Batalkan Pesanan</button>
    </div>
</div>
@endsection