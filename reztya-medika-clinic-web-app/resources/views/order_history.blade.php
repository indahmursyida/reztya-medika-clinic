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
        <h2 class="my-3 text-center font-alander-reztya unselectable">Riwayat Pesanan</h2>
        @foreach($order as $y)
            <div class="d-flex">
                @if ($y->status == "FINISH")
                <p class="rounded-2 ps-2 pe-2" style="border: 2px solid #00A54F; color: #00A54F;">
                @else
                <p class="rounded-2 ps-2 pe-2" style="border: 2px solid red; color: red;">
                @endif
                {{ $y->status }}
                </p>
            </div>
            <div class="dropdown">
                <button class="btn button-outline-reztya dropdown-toggle mt-4 mb-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Status
                </button>
                <ul class="dropdown-menu">
                    <li><a href="/history-order/filter/status/finished" class="button-outline-reztya dropdown-item">Finished</a></li>
                    <li><a href="/history-order/filter/status/canceled" class="button-outline-reztya dropdown-item">Canceled</a></li>
                    {{-- @foreach($order as $x) --}}
                        <form action="/history-order/filter/order/{{$y->status}}" method="GET" enctype="multipart/form-data">
                            <input hidden type="hidden" name="category_id" value="{{$y->status}}">
                            <li><button type="submit" class="button-outline-reztya dropdown-item">{{$y->status}}</button></li>
                        </form>
                    {{-- @endforeach --}}
                </ul>
            </div>
            <div class="d-flex justify-content-between">
                @if ($y->status =="FINISHED")
                    <h4>{{ date('l, d M Y', strtotime($y->payment_receipt->payment_date)) }}</h4>
                @else
                <h4>{{ date('l, d M Y', strtotime($y->order_date)) }}</h4>
                @endif
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
                                                <b>{{ $x->service->name}}</b>
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
                                    <td><b>{{ $x->product->name}}</b></td>
                                    <td> Kuantitas: {{ $x->quantity }}</td>
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