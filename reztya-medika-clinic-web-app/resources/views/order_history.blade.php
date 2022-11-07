@extends('layout/main')

@section('name', 'Order History')

@section('container')
{{-- MEMBER --}}
{{-- @if($order)
    <div class="border outline-reztya rounded-4 p-5 font-futura-reztya">
        <h2 class="my-3 text-center font-alander-reztya">Riwayat Pesanan</h2>
            <div class="d-flex justify-content-between">
                <h4>{{ date('l, d M Y', strtotime($order->order_date)) }}</h4>
                <h4>Rp{{ number_format($totalPrice, 2) }}</h4>
            </div>
            <div class="d-flex flex-column ms-3">
                    <table class="table">
                        <tbody>
                            @foreach($order->orderDetail as $x)
                                @if($x->service_id)
                                    @if($printServiceOnce == false)
                                        <h5>Perawatan</h5>
                                        @php
                                            $printServiceOnce = true;
                                        @endphp
                                    @endif
                                    <tr>
                                        <td>
                                            <img src="{{ asset("storage/" . $x->service->image_path) }}" alt="" width="200px" height="200px">
                                        </td>
                                        <td>
                                            <div>
                                                {{ $x->service->name}}
                                                <div>
                                                    <div>
                                                        Tanggal Perawatan: {{ date('l, d M Y', strtotime(old('start_time', $x->schedule->start_time))) }}
                                                    </div>
                                                    <div>
                                                        Waktu Mulai: {{ date('H:i:s', strtotime($x->schedule->start_time)) }}
                                                    </div>
                                                    <div>
                                                        Waktu Berakhir: {{ date('H:i:s', strtotime($x->schedule->end_time)) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $x->quantity }}</td>
                                        <td>Rp{{ number_format($x->service->price * $x->quantity, 2) }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
            </div>
            <div class="d-flex flex-column ms-3">
                <table class="table">
                    <tbody>
                        @foreach ($order->orderDetail as $x)
                            @if($x->product_id)
                                @if($printProductOnce == false)
                                    <h5>Produk</h5>
                                    @php
                                        $printProductOnce = true;
                                    @endphp
                                @endif
                                <tr>
                                    <td>
                                        <img src="{{ asset("storage/" . $x->product->image_path)}}" alt="" width="200px" height="200px">
                                    </td>
                                    <td>{{ $x->product->name}}</td>
                                    <td>{{ $x->quantity }}</td>
                                    <td>Rp{{ number_format($x->product->price * $x->quantity, 2) }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
    </div>
@else
    Tidak ada transaksi apapun.
@endif --}}

{{-- ADMIN --}}
@if($order)
    <div class="border outline-reztya rounded-4 p-5 font-futura-reztya">
        <h2 class="my-3 text-center font-alander-reztya">Riwayat Pesanan</h2>
        @foreach($order as $y)
            <div class="d-flex justify-content-between">
                <h4>{{ date('l, d M Y', strtotime($y->order_date)) }}</h4>
                <h4>Rp{{ number_format($totalPrice, 2) }}</h4>
            </div>
            <div class="d-flex flex-column ms-5">
                <div>
                    Nama Pelanggan:  
                    <b>{{ $y->user->name }}</b>
                </div>
                <div>
                    No. HP Pelanggan: 
                    <b>{{ $y->user->phone }}</b>
                </div>
                <div>
                    Alamat Pelanggan: 
                    <b>{{ $y->user->address }}</b>
                </div>
            </div>
            <div class="d-flex flex-column ms-3">
                {{-- @if($order[$i]->order_details->service_id) --}}
                    <table class="table">
                        <tbody>
                            @foreach($y->orderDetail as $x)
                                @if($x->service_id)
                                    @if($printServiceOnce == false)
                                        <h5>Perawatan</h5>
                                        @php
                                            $printServiceOnce = true;
                                        @endphp
                                    @endif
                                    <tr>
                                        <td>
                                            <img src="{{ asset("storage/" . $x->service->image_path) }}" alt="" width="200px" height="200px">
                                        </td>
                                        <td>
                                            <div>
                                                {{ $x->service->name}}
                                                <div>
                                                    <div>
                                                        Tanggal Perawatan: 
                                                        {{ date('l, d M Y', strtotime(old('start_time', $x->schedule->start_time))) }}
                                                        {{-- {{ old('start_time', $x->schedule->start_time) }}  --}}
                                                    </div>
                                                    <div>
                                                        Waktu Mulai: {{ date('H:i:s', strtotime($x->schedule->start_time)) }}
                                                    </div>
                                                    <div>
                                                        Waktu Berakhir: {{ date('H:i:s', strtotime($x->schedule->end_time)) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $x->quantity }}</td>
                                        <td>Rp{{ number_format($x->service->price * $x->quantity, 2) }}</td>
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
                        @foreach ($y->orderDetail as $x)
                            @if($x->product_id)
                                @if($printProductOnce == false)
                                    <h5>Produk</h5>
                                    @php
                                        $printProductOnce = true;
                                    @endphp
                                @endif
                                <tr>
                                    <td>
                                        <img src="{{ asset("storage/" . $x->product->image_path)}}" alt="" width="200px" height="200px">
                                    </td>
                                    <td>{{ $x->product->name}}</td>
                                    <td>{{ $x->quantity }}</td>
                                    <td>Rp{{ number_format($x->product->price * $x->quantity, 2) }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
@else
    Tidak ada transaksi apapun.
@endif
@endsection