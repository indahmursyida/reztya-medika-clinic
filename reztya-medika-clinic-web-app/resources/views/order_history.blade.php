@extends('layout/main')

@section('title', 'Order History')

@section('container')
@php
use Carbon\Carbon;
@endphp
@if(!$orders->isEmpty())
<div class="d-flex justify-content-center">
    <div class="border outline-reztya rounded-4 p-5 font-futura-reztya" style="margin-bottom:100px; width:90%;">
        <h3 class="my-3 text-center font-alander-reztya unselectable fw-bold">Riwayat Pesanan</h3>
        <div class="dropdown">
            <button class="btn button-outline-reztya dropdown-toggle mt-4 mb-2" type="button" data-toggle="dropdown" aria-expanded="false">
                Status
            </button>
            <ul class="dropdown-menu">
                <li><a href="/history-order/finished" class="button-outline-reztya dropdown-item">FINISHED</a></li>
                <li><a href="/history-order/canceled" class="button-outline-reztya dropdown-item">CANCELED</a></li>
            </ul>
        </div>
        @foreach($orders as $order)
            <div class="d-flex justify-content-between">
                <div class="container">
                    @if ($order->status =="FINISHED")
                        <h4 class="col-md-4">{{ Carbon::parse($order->paymentReceipt->payment_date)->translatedFormat('d F Y') }}</h4>
                    @else
                        <h4 class="col-md-4">{{ Carbon::parse($order->order_date)->translatedFormat('d F Y') }}</h4>
                    @endif
                    @if ($order->status == "FINISHED")
                    <p class="rounded-2 ps-2 pe-2 ms-3 col" style="border: 2px solid #00A54F; color: #00A54F; cursor: default;">
                    @else
                    <p class="btn rounded-2 ps-2 pe-2 ms-3 col" style="border: 2px solid red; color: red; cursor: default;">
                    @endif
                    {{ $order->status }}
                    </p>
                </div>
                <div class="d-flex">
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
                    Total Harga:
                    <h4>Rp{{ number_format($totalPrice, 2) }}</h4>
                    @if(Auth::user()->user_role_id == 2)
                        <a href="/repeat-order/{{ $order->order_id }}" class="btn btn-success ms-5">Pesan Lagi</a>
                    @endif
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
                            @if($order_detail->service_id)
                                @if($printServiceOnce == false)
                                    <h5>Perawatan</h5>
                                    @php
                                        $printServiceOnce = true;
                                    @endphp
                                @endif
                                <tr>
                                    <td>
                                        <img src="{{ asset("storage/" . $order_detail->service->image_path) }}" alt="" width="200px" height="200px">
                                    </td>
                                    <td>
                                        <div>
                                            <b>{{ $order_detail->service->name}}</b>
                                            <div>
                                                <div>
                                                    Tanggal Perawatan:
                                                    {{ Carbon::parse( $order_detail->schedule->start_time)->translatedFormat('l, d F Y') }}
                                                </div>
                                                <div>
                                                    Waktu Mulai: 
                                                    {{ Carbon::parse( $order_detail->schedule->start_time)->translatedFormat('H.i') }}
                                                </div>
                                                <div>
                                                    Waktu Berakhir: 
                                                    {{ Carbon::parse( $order_detail->schedule->end_time)->translatedFormat('H.i') }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Rp{{ number_format($order_detail->service->price, 2) }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                {{-- @endif --}}
            </div>
            <div class="d-flex flex-column ms-3">
                <table class="table">
                    <tbody>
                        @foreach ($order->orderDetail as $order_detail)
                            @if($order_detail->product_id)
                                @if($printProductOnce == false)
                                    <h5>Produk</h5>
                                    @php
                                        $printProductOnce = true;
                                    @endphp
                                @endif
                                <tr>
                                    <td>
                                        <img src="{{ asset("storage/" . $order_detail->product->image_path)}}" alt="" width="200px" height="200px">
                                    </td>
                                    <td><b>{{ $order_detail->product->name}}</b></td>
                                    <td> Kuantitas: {{ $order_detail->quantity }}</td>
                                    <td>Rp{{ number_format($order_detail->product->price * $order_detail->quantity, 2) }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
</div>
@else
    Tidak ada histori transaksi apapun.
@endif
@endsection
