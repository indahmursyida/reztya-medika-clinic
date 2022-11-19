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
        <h2 class="my-3 text-center font-alander-reztya unselectable">Order</h2>
            <div class="d-flex flex-column">
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
                                    <td>
                                        <b>{{ $x->service->name }}</b>
                                        <div>
                                            Tanggal Perawatan: {{ date('l, d M Y', strtotime(old('start_time', $x->schedule->start_time))) }}
                                        </div>
                                        <div>
                                            Waktu Mulai: {{ date('H:i:s', strtotime($x->schedule->start_time)) }}
                                        </div>
                                        <div>
                                            Waktu Berakhir: {{ date('H:i:s', strtotime($x->schedule->end_time)) }}
                                        </div>
                                    </td>
                                    <td>Rp{{ number_format($x->service->price, 2) }}</td>
                                    <td>
                                        <a href="/delete-order-item/{{ $x->order_detail_id }}" class="btn btn-danger rounded-2 btn-sm btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus perawatan {{ $x->service->name }}?')" title="Hapus Perawatan">
                                            <img src="storage/delete.png" class="align-middle" height="15px" width="15px">
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
            </div>
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
                                    <td>
                                        <b>{{ $x->product->name}}</b>
                                    </td>
                                    <td>
                                        Kuantitas: {{ $x->quantity}}
                                    </td>
                                    <td>Rp{{ number_format($x->product->price, 2) }}</td>
                                    <td>
                                        <button data-toggle="modal" data-target="#editOrderItemPopup" class="btn button-color rounded-2 btn-sm me-3 btn-edit" title="Edit Produk">
                                            <img src="storage/edit.png" class="align-middle" height="15px" width="15px">
                                        </button>
                                        <a href="/delete-order-item/{{ $x->order_detail_id }}" class="btn btn-danger rounded-2 btn-sm btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus produk {{ $x->product->name }}?')" title="Hapus Produk">
                                            <img src="storage/delete.png" class="align-middle" height="15px" width="15px">
                                        </a>
                                        <div class="modal fade" id="editOrderItemPopup" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="editOrderItemTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    {{-- Form --}}
                                                    <td>
                                                        <form action="/update-order-item/{{ $x->order_detail_id }}" method="POST" enctype="multipart/form-data">
                                                            @method('put')
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editOrderItemPopupLongTitle">{{ $x->product->name }}</h5>
                                                            </div>
                                                            <div class="modal-body container d-flex align-items-center">
                                                                <div class="me-5">
                                                                    Kuantitas
                                                                </div> 
                                                                <div>
                                                                    <input type="hidden" id="order_detail_id" name="order_detail_id" value={{ $x->order_detail_id }}>
                                                                    <div>
                                                                        <input type="number" class="@error('p_quantity') is-invalid @enderror form-control form-quantity" id="quantity" name="quantity" value="{{ old('quantity', $x->quantity) }}" min="1" max="{{ $x->product->stock }}">
                                                                    </div>
                                                                    @error('quantity')
                                                                    <div class="invalid-feedback">
                                                                        Kuantitas harus diisi dengan angka
                                                                    </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-success">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </td>
                                                </div>
                                            </div>
                                        </div>
                                        
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
                <form action="/update_order_status_on_going/{{$order->order_id}}" method="post">
                    @csrf
                    <button class="btn button-outline-reztya" type="submit">Buat Pesanan</button>
                </form>
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