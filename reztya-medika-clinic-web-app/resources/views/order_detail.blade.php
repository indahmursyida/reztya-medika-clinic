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
                <div class="d-flex justify-content-between my-2">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0">{{ Carbon::parse($order->order_date)->translatedFormat('d F Y') }}</h5>
                        @if ($order->status == "finished")
                        <p class="rounded-2 mb-0 ms-4" style="background-color: #00A54F;">
                            <span class="badge">SELESAI</span>
                        </p>
                        @elseif($order->status == "ongoing")
                        <p class="rounded-2 mb-0 ms-4" style="background-color: orange;">
                            <span class="badge">SEDANG BERJALAN</span>
                        </p>
                        @elseif($order->status == "waiting")
                        <p class="rounded-2 mb-0 ms-4" style="background-color: #7DC241;">
                            <span class="badge">MENUNGGU KONFIRMASI PEMBAYARAN</span>
                        </p>
                        @elseif($order->status == "canceled")
                        <p class="rounded-2 mb-0 ms-4" style="background-color: red;">
                            <span class="badge">DIBATALKAN</span>
                        </p>
                        @endif
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        @if($order->status == 'ongoing')
                        <div>
                            <a href="/cancel-order/{{ $order->order_id }}" class="btn btn-outline-danger me-3" type="button" onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan?')">Batalkan Pesanan</a>
                        </div>
                        @endif
                        @if(Auth::user()->user_role_id == 1)
                            @if ($order->status == 'waiting' || $order->status == 'ongoing')
                            <div>
                                <a href="/confirm-payment/{{ $order->order_id }}" class="btn button-outline-reztya" type="button">Konfirmasi Pembayaran</a>
                            </div>
                            @endif
                        @else
                        @if($order->status == 'ongoing')
                        <div>
                            <button class="btn button-outline-reztya" id="button_modal" data-toggle="modal" data-target="#uploadTransferPopup" type="button">Bayar Pesanan</a>
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
                                                    <input class="form-control shadow-none @error('image_path') is-invalid @enderror" type="file" id="image_path" name="image_path" value="{{ old('image_path') }}">
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
                                                <input class="shadow-none form-control @error('account_number') is-invalid @enderror" type="text" name="account_number" value="{{ old('account_number') }}">
                                                @error('account_number')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            <div>
                                                <label class="font-futura-reztya">Nama Akun Bank</label>
                                                <input class="shadow-none form-control @error('account_name') is-invalid @enderror" type="text" name="account_name" value="{{ old('account_name') }}">
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
                        @elseif($order->status == 'canceled' || $order->status == 'finished')
                        <div class="d-flex justify-content-center">
                            <a href="/repeat-order/{{ $order->order_id }}" class="btn button-outline-reztya ms-5">Pesan Lagi</a>
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
            <div class="d-flex flex-column mb-3">
                <div class="container">
                    <div class="row">
                        <div class="col-2">
                            Nama Pemesan
                        </div>
                        <div class="col-7 fw-bold">
                            {{ $order->user->name }}
                        </div>
                        <div class="col">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            No. HP Pemesan
                        </div>
                        <div class="col-7 fw-bold">
                            {{ $order->user->phone }}
                        </div>
                        <div class="col">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            Alamat Pemesan
                        </div>
                        <div class="col-7 fw-bold">
                            {{ $order->user->address }}
                        </div>
                        <div class="col">
                        </div>
                    </div>
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
                                <div class="col-3">
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
                                        @if($order->status == 'ongoing')
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
                                                                                <option hidden selected value="{{ $order_detail->schedule_id }}">{{ Carbon::parse($schedule->start_time)->translatedFormat('l, d F Y') }} | {{ Carbon::parse($schedule->start_time)->translatedFormat('H.i') }} - {{ Carbon::parse($schedule->end_time)->translatedFormat('H.i') }}</option>
                                                                            @elseif($schedule->status == 'available')
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
                                                                        <option value="1" hidden selected>
                                                                            Rumah ({{ Auth::user()->address }})
                                                                        </option>
                                                                        <option value="0">
                                                                            Klinik Reztya Medika
                                                                        </option>
                                                                        @else
                                                                        <option value="1">
                                                                            Rumah ({{ Auth::user()->address }})
                                                                        </option>
                                                                        <option value="0" hidden selected>
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
                                <div class="col-3">
                                    Rp{{ number_format($order_detail->service->price, 2) }}
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="d-flex flex-column mt-2">
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
                                    <div class="col-3">
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
                                    <p class="fw-bolder m-0">{{ $order_detail->product->name }} {{ $order_detail->product->size }}</p> 
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
                                <div class="col-3">Rp{{ number_format($order_detail->product->price * $order_detail->quantity, 2) }}</div>
                            </div>
                        @endif
                    @endforeach
                </div>
                @if($order->delivery_service == 1)
                <div class="container">
                    <div class="row mt-2">
                        <div class="col">
                        </div>
                        <div class="col-7">
                            <div>
                                <p class="mb-0 fw-bold">Ongkos Pengiriman</p>
                                <p class="mb-0">JNE {{$order->delivery_name}} ({{$order->delivery_duration}} hari), berat {{$order->weight}} kg</p>
                                <div class="d-flex">
                                    <p class="mb-0 me-1">Dikirim ke</p>
                                    <p class="fw-bold">{{$order->delivery_destination}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            Rp{{ number_format($order->delivery_fee, 2) }}
                        </div>
                    </div>
                </div>
                @endif
                <hr style="margin-right: 3%; margin-left: 3%;"/> 
                <div class="container">
                    <div class="row mt-2">
                        <div class="col d-flex justify-content-center">
                            <h5 class="mb-0">Total Harga</h5>
                        </div>
                        <div class="col-7">
                        </div>
                        <div class="col-3 d-flex align-items-center">
                            <h5 class="mb-0">Rp{{ number_format($totalPrice + $order->delivery_fee, 2) }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <p class="my-3">Pesanan tidak ditemukan.</p>
        @endif
    </div>
</div>

<script>
    $('#service_quantity').on('change', function() {
        window.location.reload();
    });
    $(document).ready(
        function()
        {
            document.getElementById("button_modal").click();
    })
</script>
@endsection