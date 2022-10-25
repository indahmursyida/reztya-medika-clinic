@extends('layout/main')

@section('name', 'Order')

@section('container')
<div class="border outline-reztya rounded-4 p-5 font-futura-reztya">
    <h2 class="my-3 text-center font-alander-reztya">Order</h2>
    <div class="d-flex flex-column">
        <h4>Services</h4>
        <table class="table">
            <tbody>
                <tr>
                    <td><img src="storage/reztya_logo.png" alt="" width="200px" height="200px"></td>
                    <td>Nama Perawatan</td>
                    <td>Quantity</td>
                    <td>Price</td>
                    <td>
                        <button class="btn btn-danger">
                            Remove
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="d-flex flex-column">
        <h4>Products</h4>
        <table class="table">
            <tbody>
                <tr>
                    <td><img src="storage/reztya_logo.png" alt="" width="200px" height="200px"></td>
                    <td>Product Name</td>
                    <td>Quantity</td>
                    <td>Price</td>
                    <td>
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
        <button class="btn button-outline-reztya" type="button">Pesan</button>
    </div>
</div>
@endsection