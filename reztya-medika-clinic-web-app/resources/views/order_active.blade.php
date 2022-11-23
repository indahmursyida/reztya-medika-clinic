@extends('layout/main')

@section('name', 'Active Order')

@section('container')
@if(!$order->isEmpty())
    <!-- @if(count($errors) > 0)
    <script>

        $("#uploadTransferPopup").modal('show');
    </script>
    @endif -->
    <div class="border outline-reztya rounded-4 p-5 font-futura-reztya">
        <h2 class="my-3 text-center font-alander-reztya unselectable">Pesanan Aktif</h2>
        @foreach($order as $y)
            <div class="d-flex justify-content-between">
                <div class="d-flex">
                    <h4>{{ date('d M Y', strtotime($y->order_date)) }}</h4>
                    <p class="rounded-2 ps-2 pe-2 ms-3" style="border: 2px solid #00A54F; color: #00A54F;">
                        {{ $y->status }}
                    </p>
                </div>
                @php
                    $totalPrice = 0;
                    foreach($y->orderDetail as $p)
                    {
                        if($p->service_id)
                            $totalPrice += $p->service->price;
                        else
                            $totalPrice += $p->product->price * $p->quantity;
                    }
                @endphp
                <div>
                    Total Harga: 
                    <h4>Rp{{ number_format($totalPrice, 2) }}</h4>
                </div>
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
                            @if($printOnce == false)
                                @php
                                    $printOnce = true;
                                @endphp
                                @if($x->service_id)
                                    <tr>
                                        <h5>Perawatan</h5>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img src="{{ asset('storage/' . $x->service->image_path) }}" alt="" width="120px" height="120px">
                                        </td>
                                        <td>
                                            {{ $x->service->name }}
                                        </td>
                                        <td>
                                            Rp{{ number_format($x->service->price, 2) }}
                                        </td>
                                        <td>
                                            @php
                                                $totalItem = count($y->orderDetail);
                                            @endphp
                                            <p>+{{$totalItem - 1}} pesanan lainnya</p>
                                        </td>
                                    </tr>
                                @elseif($x->product_id)
                                    <tr>
                                        <td>
                                            <img src="{{ asset('storage/' . $x->product->image_path)}}" alt="" width="200px" height="200px">
                                        </td>
                                        <td>
                                            <b>{{ $x->product->name }}</b>
                                            <div>
                                            {{ $x->quantity }} barang x Rp{{ number_format($x->product->price, 2) }}
                                            </div>
                                        </td>
                                        <td>Rp {{ number_format($x->product->price * $x->quantity, 2) }}</td>
                                        <td>
                                            @php
                                                $totalItem = count($y->orderDetail);
                                            @endphp
                                            <p>+{{$totalItem - 1}} pesanan lainnya</p>
                                        </td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                <button class="btn button-outline-reztya" type="button">Lihat Detail Pesanan</button>
            </div>
        @endforeach
    </div>
@else
    Tidak ada pesanan yang sedang aktif
@endif
@endsection
