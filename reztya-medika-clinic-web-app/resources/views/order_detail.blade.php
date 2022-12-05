@extends('layout/main')

@section('title', 'Order')

@section('container')
@if (session('success'))
<div class="alert alert-success" id="success-alert">
    <strong> {{session()->get('success')}} </strong>
</div>
@endif
@if($order)
    <!-- @if(count($errors) > 0)
    <script>
        
        $("#uploadTransferPopup").modal('show');
    </script>
    @endif -->
    <div class="border outline-reztya rounded-4 p-5 font-futura-reztya">
        <h2 class="my-3 text-center font-alander-reztya unselectable">Order</h2>
        <div class="d-flex justify-content-between">
            <div class="d-flex mb-2">
                <h4 class="d-flex align-items-center mb-0">{{ date('d M Y', strtotime($order->order_date)) }}</h4>
                @if ($order->status == "FINISHED")
                    <p class="rounded-2 ms-3 mb-0" style="border: 2px solid #00A54F;">
                        <span class="badge" style="color: #00A54F; background-color: blue;">{{ $order->status }}</span>
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
                foreach($order->orderDetail as $p)
                {
                    if($p->service_id)
                        $totalPrice += $p->service->price;
                    else
                        $totalPrice += $p->product->price * $p->quantity;
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
                                    <img src="{{ asset("storage/" . $x->service->image_path) }}" alt="" width="100px" height="100px">
                                </td>
                                <td>
                                    <div>
                                        <b>{{ $x->service->name}}</b>
                                        <div>
                                            <div>
                                                Tanggal Perawatan: {{ date('l, d M Y', strtotime(old('start_time', $x->schedule->start_time))) }}
                                            </div>
                                            <div>
                                                Waktu Mulai: {{ date('H.i', strtotime($x->schedule->start_time)) }}
                                            </div>
                                            <div>
                                                Waktu Berakhir: {{ date('H.i', strtotime($x->schedule->end_time)) }}
                                            </div>
                                        </div>
                                        @if($order->status == 'ON GOING')
                                        <button class="btn btn-sm button-outline-reztya" data-toggle="modal" data-target="#reschedulePopup-{{$x->order_detail_id}}">Jadwal Ulang</button>
                                        <!-- Modal --> 
                                        <div class="modal fade" id="reschedulePopup-{{$x->order_detail_id}}" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="reschedulePopupTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    {{-- Form --}}
                                                    <form action="/reschedule/{{ $x->order_detail_id }}" method="POST" enctype="multipart/form-data">
                                                            @method('put')
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="reschedulePopupLongTitle">Jadwal Ulang</h5>
                                                            </div>
                                                            <div class="modal-body container">
                                                                <div>
                                                                    <div>
                                                                        Jadwal Perawatan
                                                                    </div>
                                                                    <input type="hidden" id="order_detail_id" name="order_detail_id" value={{ $x->order_detail_id }}>
                                                                    <div>
                                                                        <select class="form-select" name="schedule_id" id="schedule_id">
                                                                            @foreach($schedules as $schedule)
                                                                                <option value="{{ $schedule->schedule_id }}" {{ $schedule->schedule_id == $x->schedule_id ? 'selected' : '' }}> {{ date('l, d M Y', strtotime($schedule->start_time)) }} | {{ date('H:i:s', strtotime($schedule->start_time)) }} - {{ date('H:i:s', strtotime($schedule->end_time)) }}</option>
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
                                <td>Rp{{ number_format($x->service->price, 2) }}</td>
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
                                    <img src="{{ asset("storage/" . $x->product->image_path)}}" alt="" width="100px" height="100px">
                                </td>
                                <td>
                                    <b>{{ $x->product->name }}</b>
                                    <div>
                                    Rp{{ number_format($x->product->price, 2) }}
                                    </div>
                                    
                                </td>
                                <td>
                                    <div>
                                        Kuantitas: {{ $x->quantity }}
                                    </div>
                                </td>
                                <td>Rp{{ number_format($x->product->price * $x->quantity, 2) }}</td>
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
            <div class="d-flex justify-content-center">
                <a href="/confirm-payment/{{ $y->order_id }}" class="btn btn-success" type="button">Konfirmasi Pembayaran</a>
            </div>
        @else
            @if($order->status == 'ON GOING')
                <div class="d-flex justify-content-center">
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
    $('#service_quantity').on('change', function(){
            window.location.reload();
        });
</script>
@endsection
