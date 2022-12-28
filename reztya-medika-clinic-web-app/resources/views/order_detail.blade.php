@extends('layout/main')

@section('title', 'Order')

@section('container')
@if (session('success'))
<div class="alert alert-success" id="success-alert">
    <strong> {{session()->get('success')}} </strong>
</div>
@endif
@php
use Carbon\Carbon;
@endphp
<div class="d-flex justify-content-center">
    <div class="border outline-reztya rounded-4 p-5 font-futura-reztya" style="margin-bottom:100px; width:90%;">
        <h5 class="my-3 text-center font-alander-reztya unselectable fw-bold">Order</h5>
        @if($order)
            <div class="container">
                <div class="d-flex justify-content-between my-2 px-3">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 me-3">{{ Carbon::parse($order->order_date)->translatedFormat('d F Y') }}</h5>
                        @if ($order->status == "FINISHED")
                        <p class="rounded-2 mb-0" style="background-color: #00A54F; ">
                            <span class="badge" style="color:black">{{ $order->status }}</span>
                        </p>
                        @elseif($order->status == "ON GOING")
                        <p class="rounded-2 mb-0" style="background-color: orange;">
                            <span class="badge" style="color:black">{{ $order->status }}</span>
                        </p>
                        @else
                        <p class="rounded-2 mb-0" style="background-color: red;">
                            <span class="badge" style="color:black">{{ $order->status }}</span>
                        </p>
                        @endif
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        @if($order->status == 'ON GOING')
                        <div>
                            <a href="/cancel-order/{{ $order->order_id }}" class="btn btn-outline-danger me-3" type="button" onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan?')">Batal</a>
                        </div>
                        @endif
                        @if(Auth::user()->user_role_id == 1)
                        <div>
                            <a href="/confirm-payment/{{ $order->order_id }}" class="btn btn-success" type="button">Konfirmasi Pembayaran</a>
                        </div>
                        @else
                        @if($order->status == 'ON GOING')
                        <div>
                            <button class="btn button-color" data-toggle="modal" data-target="#uploadTransferPopup" type="button">Bayar Pesanan</a>
                        </div>
                        <div class="modal fade" id="uploadTransferPopup" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="uploadTransferPopupPopupTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    {{-- Form --}}
                                    <form action="/upload-transfer-receipt/{{ $order->order_id }}" method="POST" enctype="multipart/form-data">
                                        @method('put')
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Bayar Pesanan</h5>
                                        </div>
                                        <div class="modal-body container">
                                            <p>Anda dapat membayar langsung secara <b>cash</b> ke pihak klinik atau <b>transfer</b> ke nomor rekening <b>53489239 a/n Reztya Medika Clinic</b>.</p>
                                            <p>Silahkan lengkapi form berikut jika sudah membayar via transfer.</p>
                                            <div>
                                                <div>
                                                    Foto Bukti Transfer
                                                </div>
                                                <div>
                                                    <input class="form-control shadow-none @error('image_path') is-invalid @enderror" type="file" id="image_path" name="image_path">
                                                    @error('image_path')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                    </select>
                                                </div>
                                            </div>
                                            <div>
                                                <label class="font-futura-reztya">Nomor Akun Bank</label>
                                                <input class="shadow-none form-control @error('account_number') is-invalid @enderror" type="text" name="account_number">
                                                @error('account_number')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            <div>
                                                <label class="font-futura-reztya">Nama Akun Bank</label>
                                                <input class="shadow-none form-control @error('account_name') is-invalid @enderror" type="text" name="account_name">
                                                @error('account_name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success">OK</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @elseif($order->status == 'WAITING')
                        <div class="lead">
                            Mohon menunggu konfirmasi pembayaran transfer oleh Admin Klinik Reztya Medika
                        </div>
                        @elseif($order->status == 'CANCELED' || $order->status == 'FINISHED')
                        <div class="d-flex justify-content-center">
                            <a href="/repeat-order/{{ $order->order_id }}" class="btn btn-success ms-5">Pesan Lagi</a>
                        </div>
                        @endif
                        @endif
                    </div>
                </div>
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
        <div class="d-flex flex-column">
            <div class="container">
                @foreach($order->orderDetail as $order_detail)
                    @if($order_detail->service_id)
                        @if($printServiceOnce == false)
                        <div class="row">
                            <div class="col d-flex justify-content-center">
                                <h5 class="mb-0">Perawatan</h5>
                            </div>
                            <div class="col-7">
                            </div>
                            <div class="col">
                            </div>
                        </div>
                        @php
                        $printServiceOnce = true;
                        @endphp
                        @endif
                        <div class="row my-2">
                            <div class="col d-flex justify-content-center align-items-center">
                                <img src="{{ url('storage' . $order_detail->service->image_path) }}" alt="" width="100px" height="100px">
                            </div>
                            <div class="col-7 d-flex flex-column justify-content-center">
                                <p class="fw-bold m-0">{{ $order_detail->service->name }}</p>
                                <div style="color: #00A54F;">
                                    Tempat Perawatan
                                </div>
                                @if($order_detail->home_service == 1)
                                <div class="">
                                    Rumah | {{ Auth::user()->address }}
                                </div>
                                @else
                                <div class="">
                                    Klinik Reztya Medika
                                </div>
                                @endif
                                <div style="color: #00A54F;">
                                    Jadwal Perawatan
                                </div>
                                <div class="">
                                    {{ Carbon::parse($order_detail->schedule->start_time)->translatedFormat('l, d F Y') }} | {{ Carbon::parse($order_detail->schedule->start_time)->translatedFormat('H.i') }} - {{ Carbon::parse($order_detail->schedule->end_time)->translatedFormat('H.i') }}
                                </div>
                                <div>
                                    @if($order->status == 'ON GOING')
                                    <button data-toggle="modal" data-target="#reschedulePopup-{{$order_detail->order_detail_id}}" class="btn button-color rounded-2 btn-sm mt-1 pt-1 btn-edit">
                                        <i class="fa-regular fa-pen-to-square pt-1 me-1"></i>Jadwal Ulang
                                    </button>
                                    {{-- <button class="btn btn-sm button-outline-reztya mb-4 mt-2" data-toggle="modal" data-target="#reschedulePopup-{{$order_detail->order_detail_id}}">Ubah Jadwal</button> --}}
                                    <!-- Modal -->
                                    <div class="modal fade" id="reschedulePopup-{{$order_detail->order_detail_id}}" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="reschedulePopupTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                {{-- Form --}}
                                                <form action="/reschedule/{{ $order_detail->order_detail_id }}" method="POST" enctype="multipart/form-data">
                                                    @method('put')
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="reschedulePopupLongTitle">{{ $order_detail->service->name }}</h5>
                                                    </div>
                                                    <div class="modal-body container">
                                                        <input type="hidden" id="cart_id" name="cart_id" value="{{ $order_detail->cart_id }}">
                                                        <input type="hidden" id="old_schedule" name="old_schedule" value="{{ $order_detail->schedule->start_time }}">
                                                        <input type="hidden" id="old_schedule_id" name="old_schedule_id" value="{{ $order_detail->schedule_id }}">
                                                        <input type="hidden" id="service_name" name="service_name" value="{{ $order_detail->service->name }}">
                                                        <input type="hidden" id="order_id" name="order_id" value="{{ $order_detail->order_id }}">
                                                        
                                                        <div>
                                                            <div class="mb-2 text-start">
                                                                Pilih Jadwal yang Tersedia
                                                            </div>
                                                            <div class="mb-3">
                                                                <select class="form-select shadow-none" name="schedule_id" id="schedule_id">
                                                                    @foreach($schedules as $schedule)
                                                                        @if($schedule->schedule_id == $order_detail->schedule_id)
                                                                            <option disabled selected value="{{ $order_detail->schedule_id }}">{{ Carbon::parse($schedule->start_time)->translatedFormat('l, d F Y') }} | {{ Carbon::parse($schedule->start_time)->translatedFormat('H.i') }} - {{ Carbon::parse($schedule->end_time)->translatedFormat('H.i') }}</option>
                                                                        @elseif($schedule->status == 'Available')
                                                                            <option value="{{ $schedule->schedule_id }}"> {{ Carbon::parse($schedule->start_time)->translatedFormat('l, d F Y') }} | {{ Carbon::parse($schedule->start_time)->translatedFormat('H.i') }} - {{ Carbon::parse($schedule->end_time)->translatedFormat('H.i') }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="mb-2 text-start">
                                                                Pilih Tempat Layanan
                                                            </div>
                                                            <div>
                                                                <select class="form-select" id="home_service" name="home_service">
                                                                    @if($order_detail->home_service == 1)
                                                                    <option value="1" disabled>
                                                                        Rumah ({{ Auth::user()->address }})
                                                                    </option>
                                                                    <option value="0">
                                                                        Klinik Reztya Medika
                                                                    </option>
                                                                    @else
                                                                    <option value="1">
                                                                        Rumah ({{ Auth::user()->address }})
                                                                    </option>
                                                                    <option value="0" disabled>
                                                                        Klinik Reztya Medika
                                                                    </option>
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-success">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col">Rp{{ number_format($order_detail->service->price, 2) }}</div>
                        </div>
                    @endif
                @endforeach
                </div>
            </div>
            <div class="d-flex flex-column">
                <div class="container">
                    @foreach ($order->orderDetail as $order_detail)
                        @if($order_detail->product_id)
                            @if($printProductOnce == false)
                                <div class="row">
                                    <div class="col d-flex justify-content-center">
                                        <h5 class="mb-0" style="padding-right: 15%">Produk</h5>
                                    </div>
                                    <div class="col-7">
                                    </div>
                                    <div class="col">
                                    </div>
                                </div>
                                @php
                                $printProductOnce = true;
                                @endphp
                            @endif
                            <div class="row my-2">
                                <div class="col d-flex justify-content-center align-items-center">
                                    <img src="{{ asset("storage/" . $order_detail->product->image_path)}}" alt="" width="100px" height="100px">
                                </div>
                                <div class="col-7 d-flex flex-column justify-content-center">
                                    <p class="fw-bolder m-0">{{ $order_detail->product->name }}</p> 
                                    <div style="color: #00A54F;">
                                        Harga Satuan
                                    </div>
                                    <div>
                                        Rp{{ number_format($order_detail->product->price, 2) }}
                                    </div>
                                    <div style="color: #00A54F;">
                                        Kuantitas
                                    </div>
                                    <div>
                                        {{ $order_detail->quantity }}
                                    </div>
                                </div>
                                <div class="col">Rp{{ number_format($order_detail->product->price * $order_detail->quantity, 2) }}</div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <hr style="width: 90%; margin-right: 5%; margin-left: 5%;"/> 
                <div class="container">
                    <div class="row mt-2">
                        <div class="col d-flex justify-content-center">
                            <h5 class="mb-0">Total Harga</h5>
                        </div>
                        <div class="col-7">
                        </div>
                        <div class="col d-flex align-items-center">
                            <h5 class="mb-0" id="totalPriceText">Rp{{ number_format($totalPrice, 2) }}</h5>
                            <input type="hidden" value="{{$totalPrice}}" id="totalPrice">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        Tidak ada pesanan yang sedang berjalan.
        @endif
    </div>
</div>

<script>
    $('#service_quantity').on('change', function() {
        window.location.reload();
    });

    function includeFee() {
        var total = parseInt(document.getElementById('totalPrice').value);
        total += parseInt(document.getElementById('origin').value);
        document.getElementById('totalPriceText').innerHTML = "Rp" + total.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",") + ".00";
    }
</script>
@endsection