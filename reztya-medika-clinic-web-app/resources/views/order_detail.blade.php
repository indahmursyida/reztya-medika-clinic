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
@if($order)
<div class="border outline-reztya rounded-4 p-5 font-futura-reztya">
    <h2 class="my-3 text-center font-alander-reztya unselectable">Order</h2>
    <div class="d-flex justify-content-between">
        <div class="d-flex mb-2">
            <h5 class="d-flex align-items-center mb-0">{{ Carbon::parse($order->order_date)->translatedFormat('d F Y') }}</h5>
            @if ($order->status == "FINISHED")
            <p class="rounded-2 ms-3 mb-0" style="border: 2px solid #00A54F;">
                <span class="badge" style="color: #00A54F;">{{ $order->status }}</span>
            </p>
            @elseif($order->status == "ON GOING")
            <p class="rounded-2 ms-3 mb-0" style="border: 2px solid orange;">
                <span class="badge" style="color: orange;">{{ $order->status }}</span>
            </p>
            @else
            <p class="rounded-2 ms-3 mb-0" style="border: 2px solid red;">
                <span class="badge" style="color: red;">{{ $order->status }}</span>
            </p>
            @endif
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
        <div class="d-flex align-items-center">
            <p class="mb-0 me-3">Total Harga:</p>
            <h5 class="d-flex justify-content-end mb-0 pe-5">Rp{{ number_format($totalPrice, 2) }}</h5>
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
                        <img src="{{ url('storage' . $order_detail->service->image_path) }}" alt="" width="100px" height="100px">
                    </td>
                    <td>
                        <div>
                            <b>{{ $order_detail->service->name}}</b>
                            <div>
                                @if($order_detail->home_service == 1)
                                    <div>
                                        Tempat Perawatan: Rumah ({{ Auth::user()->address }})
                                    </div>
                                @else
                                    <div>
                                        Tempat Perawatan: Klinik Reztya Medika
                                    </div>
                                @endif
                                <div>
                                    Tanggal Perawatan: {{ Carbon::parse($order_detail->schedule->start_time)->translatedFormat('l, d F Y') }}
                                </div>
                                <div>
                                    Waktu Mulai: {{ Carbon::parse($order_detail->schedule->start_time)->translatedFormat('H.i') }}
                                </div>
                                <div>
                                    Waktu Berakhir: {{ Carbon::parse($order_detail->schedule->end_time)->translatedFormat('H.i') }}
                                </div>
                            </div>
                            @if($order->status == 'ON GOING')
                            <button data-toggle="modal" data-target="#reschedulePopup-{{$order_detail->order_detail_id}}" class="btn button-color rounded-2 btn-sm me-3 btn-edit" title="Ubah Jadwal">
                                <i class="fa-solid fa-regular fa-pen-to-square"></i>
                            </button>
                            <button class="btn btn-sm button-outline-reztya mb-4 mt-2" data-toggle="modal" data-target="#reschedulePopup-{{$order_detail->order_detail_id}}">Ubah Jadwal</button>
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
                                                <div>
                                                    <div>
                                                        Jadwal Perawatan
                                                    </div>
                                                    <input type="hidden" id="order_detail_id" name="order_detail_id" value="{{ $order_detail->order_detail_id }}">
                                                    <input type="hidden" id="old_schedule" name="old_schedule" value="{{ $order_detail->schedule->start_time }}">
                                                    <input type="hidden" id="old_schedule_id" name="old_schedule_id" value="{{ $order_detail->schedule_id }}">
                                                    <input type="hidden" id="service_name" name="service_name" value="{{ $order_detail->service->name }}">
                                                    <input type="hidden" id="order_id" name="order_id" value="{{ $order_detail->order_id }}">
                                                    <div>
                                                        <select class="form-select" name="schedule_id" id="schedule_id">
                                                            @foreach($schedules as $schedule)
                                                                @if($schedule->schedule_id == $order_detail->schedule_id || $schedule->status == 'Available')
                                                                    <option value="{{ $schedule->schedule_id }}" {{ $schedule->schedule_id == $order_detail->schedule_id ? 'selected' : '' }}> {{ Carbon::parse($schedule->start_time)->translatedFormat('l, d M Y') }} | {{ Carbon::parse($schedule->start_time)->translatedFormat('H.i') }} - {{ Carbon::parse($schedule->end_time)->translatedFormat('H.i') }}</option>
                                                                @endif
                                                            @endforeach
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
                    </td>
                    <td>Rp{{ number_format($order_detail->service->price, 2) }}</td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
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
                                <img src="{{ asset("storage/" . $order_detail->product->image_path)}}" alt="" width="100px" height="100px">
                            </td>
                            <td>
                                <b>{{ $order_detail->product->name }}</b>
                                <div>
                                    Rp{{ number_format($order_detail->product->price, 2) }}
                                </div>

                            </td>
                            <td>
                                <div>
                                    Kuantitas: {{ $order_detail->quantity }}
                                </div>
                            </td>
                            <td>Rp{{ number_format($order_detail->product->price * $order_detail->quantity, 2) }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        <!-- <div class="d-flex justify-content-end">
                <p>Total Harga:</p>
                <h4 class="d-flex justify-content-end me-5">Rp{{ number_format($totalPrice, 2) }}</h4>
            </div> -->
    </div>
    @if(Auth::user()->user_role_id == 1)
    <div class="d-flex justify-content-center mb-2">
        <a href="/confirm-payment/{{ $order->order_id }}" class="btn btn-success" type="button">Konfirmasi Pembayaran</a>
    </div>
    @else
    @if($order->status == 'ON GOING')
    <div class="d-flex justify-content-center mb-2">
        <button class="btn button-outline-reztya" data-toggle="modal" data-target="#uploadTransferPopup" type="button">Bayar Pesanan</a>
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
                        <p>Anda dapat membayar langsung secara <b>cash</b> ke pihak klinik atau <b>transfer</b> ke nomor rekening <b>53489239 a/n Reztya Medika Clinic</b></p>
                        <p>Silahkan lengkapi form berikut jika sudah membayar via transfer.</p>
                        <div>
                            <div>
                                Foto Bukti Transfer
                            </div>
                            <div>
                                <input class="form-control @error('image_path') is-invalid @enderror" type="file" id="image_path" name="image_path">
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
        Mohon menunggu konfirmasi pembayaran transfer oleh Admin Reztya Medika Clinic
    </div>
    @elseif($order->status == 'CANCELED' || $order->status == 'FINISHED')
    <div class="d-flex justify-content-center">
        <a href="/repeat-order/{{ $order->order_id }}" class="btn btn-success ms-5">Pesan Lagi</a>
    </div>
    @endif
    @endif
    @if($order->status == 'ON GOING')
    <div class="d-flex justify-content-center">
        <a href="/cancel-order/{{ $order->order_id }}" class="btn btn-outline-danger" type="button" onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan?')">Batalkan Pesanan</a>
    </div>
    @endif
</div>
@else
Tidak ada pesanan yang sedang aktif
@endif

<script>
    $('#service_quantity').on('change', function() {
        window.location.reload();
    });
</script>
@endsection