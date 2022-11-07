@extends('layout/main')

@section('name', 'Order')

@section('container')
@if (session('success'))
<div class="alert alert-success" id="success-alert">
    <strong> {{session()->get('message')}} </strong>
</div>
@endif
@if($order)
    <div class="border outline-reztya rounded-4 p-5 font-futura-reztya">
        <h2 class="my-3 text-center font-alander-reztya">Order</h2>
        {{-- @foreach($order as $y) --}}
            <div class="d-flex flex-column">
                {{-- @if($order[$i]->order_details->service_id) --}}
                    <table class="table">
                        <tbody>
                            @foreach($order->orderDetail as $x)
                                @if($x->service_id)
                                    @if($printServiceOnce == false)
                                        <h4>Perawatan</h4>
                                        @php
                                            $printServiceOnce = true;
                                        @endphp
                                    @endif
                                    <tr>
                                        <td>
                                            <img src="{{ asset("storage/" . $x->service->image_path) }}" alt="" width="200px" height="200px">
                                        </td>
                                        <td>{{ $x->service->name }}</td>
                                        <td>
                                            {{ $x->quantity }}
                                            {{-- @if (old('quantity') == $x->quantity)
                                                <input type="number" class="form-control form-control-sm form-quantity" onchange="window.location.reload()" value="{{ old('quantity', $x->quantity) }}" min="1" max="100">
                                            @else
                                            <input type="number" class="form-control form-control-sm form-quantity" onchange="window.location.reload()" min="1" max="100">
                                            @endif --}}
                                            
                                        </td>
                                        <td>Rp{{ number_format($x->service->price, 2) }}</td>
                                        <td>
                                            <a href="/delete-order-item/{{ $x->order_detail_id }}" title="Hapus Perawatan" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus {{ $x->service->name }} dari pesanan?')">
                                                Hapus
                                            </a>
                                        </td>
                                    </tr>
                                    @php
                                        $totalPrice += $x->service->price * $x->quantity;
                                    @endphp
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                {{-- @endif --}}
            </div>
        {{-- @endforeach --}}
            <div class="d-flex flex-column">
                <table class="table">
                    <tbody>
                        @foreach ($order->orderDetail as $x)
                            @if($x->product_id)
                                @if($printProductOnce == false)
                                    <h4>Produk</h4>
                                    @php
                                        $printProductOnce = true;
                                    @endphp
                                @endif
                                <tr>
                                    <td>
                                        <img src="{{ asset("storage/" . $x->product->image_path)}}" width="200px" height="200px">
                                    </td>
                                    <td>{{ $x->product->name}}</td>
                                    <td>{{ $x->quantity}}</td>
                                    {{-- <td>
                                        <input type="number" class="form-control form-control-sm form-quantity" onchange="window.location.reload()" value="{{ old('quantity', $x->quantity) }}" min="1" max="100">
                                    </td> --}}
                                    <td>Rp{{ number_format($x->product->price, 2) }}</td>
                                    <td>
                                        <a href="/delete-order-item/{{ $x->order_detail_id }}" class="btn btn-danger" type="button" title="Hapus Produk" onclick="return confirm('Apakah Anda yakin ingin menghapus {{ $x->product->name }} dari pesanan?')">
                                            Hapus
                                        </a>
                                    </td>
                                </tr>
                                @php
                                    $totalPrice += $x->product->price * $x->quantity;
                                @endphp
                            @endif
                        @endforeach
                    </tbody>
                </table>

            </div>
            <h5 class="d-flex justify-content-end">Total Price = Rp{{ number_format($totalPrice, 2) }}</h5>
            <div class="d-flex justify-content-center">
                <a href="/active-order" class="btn button-outline-reztya" type="button">Buat Pesanan</a>
            </div>
    </div>
@else
    Anda belum membuat pesanan apapun
@endif

<script>
    $('#service_quantity').on('change', function(){
            window.location.reload();
        });
</script>
@endsection