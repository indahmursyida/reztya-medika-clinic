@extends('layout/main')

@section('title', 'Active Order')

@section('container')
@php
use Carbon\Carbon;
@endphp
@if(!$orders->isEmpty())
    <!-- @if(count($errors) > 0)
    <script>

        $("#uploadTransferPopup").modal('show');
    </script>
    @endif -->
    <div class="border outline-reztya rounded-4 p-5 font-futura-reztya">
        <h2 class="my-3 text-center font-alander-reztya unselectable">Pesanan Aktif</h2>
        @foreach($orders as $order)
            <div class="d-flex justify-content-between">
                <div class="d-flex">
                    <h4 class="align-items-center">{{ Carbon::parse($order->order_date)->translatedFormat('d F Y') }}</h4>
                    <p class="rounded-2 ps-2 pe-2 mt-2 mb-2 ms-3 d-flex align-items-center" style="border: 2px solid #00A54F; color: #00A54F;">
                        {{ $order->status }}
                    </p>
                </div>
                @php
                    $totalPrice = 0;
                    foreach($order->orderDetail as $order_detail)
                    {
                        if($order_detail->service_id)
                            $totalPrice += $order_detail->service->price;
                        else
                            $totalPrice += $order_detail->product->price * $order_detail->quantity;
                    }
                @endphp
                <div class="d-flex">
                    Total Harga:
                    <h4>Rp{{ number_format($totalPrice, 2) }}</h4>
                </div>
            </div>
            @if(Auth::user()->user_role_id == 1)
                <div class="d-flex flex-column ms-5">
                    <div>
                        Nama Pelanggan:
                        <b>{{ $order->user->name }}</b>
                    </div>
                    <div>
                        No. HP Pelanggan:
                        <b>{{ $order->user->phone }}</b>
                    </div>
                    <div>
                        Alamat Pelanggan:
                        <b>{{ $order->user->address }}</b>
                    </div>
                </div>
            @endif
            <div class="d-flex flex-column ms-3">
                <table class="table">
                    <tbody>
                        @foreach($order->orderDetail as $order_detail)
                            @if($printOnce == false)
                                @php
                                    $printOnce = true;
                                @endphp
                                @if($order_detail->service_id)
                                    <tr>
                                        <h5>Perawatan</h5>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img src="{{ asset('storage/' . $order_detail->service->image_path) }}" alt="" width="120px" height="120px">
                                        </td>
                                        <td>
                                            {{ $order_detail->service->name }}
                                        </td>
                                        <td>
                                            Rp{{ number_format($order_detail->service->price, 2) }}
                                        </td>
                                    </tr>
                                @elseif($order_detail->product_id)
                                    <tr>
                                        <td>
                                            <img src="{{ asset('storage/' . $order_detail->product->image_path)}}" alt="" width="200px" height="200px">
                                        </td>
                                        <td>
                                            <b>{{ $order_detail->product->name }}</b>
                                            <div>
                                            {{ $order_detail->quantity }} barang x Rp{{ number_format($order_detail->product->price, 2) }}
                                            </div>
                                        </td>
                                        <td>Rp {{ number_format($order_detail->product->price * $order_detail->quantity, 2) }}</td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                    </tbody>
                </table>
                <div>
                    @php
                        $totalItem = count($order->orderDetail);
                    @endphp
                    <p>+{{$totalItem - 1}} pesanan lainnya</p>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <a href="/order-detail/{{$order->order_id}}" class="btn button-outline-reztya" type="button">Lihat Detail Pesanan</a>
            </div>
        @endforeach
    </div>
@else
    Tidak ada pesanan yang sedang aktif
@endif
@endsection
