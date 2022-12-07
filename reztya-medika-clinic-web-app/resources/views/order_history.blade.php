@extends('layout/main')

@section('title', 'Order History')

@section('container')
@if(!$order->isEmpty())
    <div class="border outline-reztya rounded-4 p-5 font-futura-reztya">
        <h2 class="my-3 text-center font-alander-reztya unselectable">Riwayat Pesanan</h2>
        <div class="dropdown">
            <button class="btn button-outline-reztya dropdown-toggle mt-4 mb-2" type="button" data-toggle="dropdown" aria-expanded="false">
                Status
            </button>
            <ul class="dropdown-menu">
                @foreach($order as $x)
                    <form action="/history-order/filter/status/{{$x->status}}" method="GET" enctype="multipart/form-data">
                        {{-- <input hidden type="hidden" name="category_id" value="{{$x->order_id}}"> --}}
                        <li><button type="submit" class="button-outline-reztya dropdown-item">{{$x->status}}</button></li>
                    </form>
                @endforeach
            </ul>
        </div>
        @foreach($order as $y)

            <div class="d-flex justify-content-between">
                <div class="d-flex">
                    @if ($y->status =="FINISHED")
                        <h4>{{ date('l, d M Y', strtotime($y->payment_receipt->payment_date)) }}</h4>
                    @else
                        <h4>{{ date('l, d M Y', strtotime($y->order_date)) }}</h4>
                    @endif
                    @if ($y->status == "FINISH")
                    <p class="rounded-2 ps-2 pe-2 ms-3" style="border: 2px solid #00A54F; color: #00A54F;">
                    @else
                    <p class="rounded-2 ps-2 pe-2 ms-3" style="border: 2px solid red; color: red;">
                    @endif
                    {{ $y->status }}
                    </p>
                </div>
                <h4>Rp{{ number_format($totalPrice, 2) }}</h4>
            </div>
            @if(Auth::user()->user_role_id == 1)
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
            @endif
            <div class="d-flex flex-column ms-3">
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
    Tidak ada histori transaksi apapun.
@endif
@endsection
