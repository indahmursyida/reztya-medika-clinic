@extends('layout/main')

@section('name', 'Active Order')

@section('container')
{{-- @if(Auth::user()->user_role_id == 2) MEMBER --}}
    {{-- @if($order)
        <div class="border outline-reztya rounded-4 p-5 font-futura-reztya">
            <h2 class="my-3 text-center font-alander-reztya">Pesanan Saya</h2>
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
                                                            Tanggal Perawatan: {{ old('start_time', $x->schedule->start_time) }} 
                                                            {{-- {{ date('l, d M Y', strtotime(old('start_time', $x->schedule->start_time))) }} --}}
                                                        {{-- </div>
                                                        <div>
                                                            Waktu Mulai: {{ date('H:i:s', strtotime($x->schedule->start_time)) }}
                                                        </div>
                                                        <div>
                                                            Waktu Berakhir: {{ date('H:i:s', strtotime($x->schedule->end_time)) }}
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-sm button-outline-reztya" type="button" data-toggle="modal" data-target="#reschedulePopup">Jadwal Ulang</button>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="reschedulePopup" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="reschedulePopupTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                {{-- Form --}}
                                                                {{-- <form action="/reschedule/{{ $x->order_detail_id }}" name="order_schedule" id="order_schedule" method="POST" enctype="multipart/form-data">
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
                                                </div>
                                            </td>
                                            <td>{{ $x->quantity }}</td>
                                            <td>Rp{{ number_format($x->service->price * $x->quantity, 2) }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                </div> --}}
                {{-- <div class="d-flex flex-column ms-3">
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
                <div class="d-flex justify-content-center">
                    <a href="/cancel-order/{{ $order->order_id }}" class="btn btn-outline-danger" type="button" onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan?')">Batalkan Pesanan</a>
                </div>
        </div>
    @else
        Belum ada pesanan apapun
    @endif
    @else ADMIN  --}}
    @if($order)
        <div class="border outline-reztya rounded-4 p-5 font-futura-reztya">
            <h2 class="my-3 text-center font-alander-reztya">Pesanan Aktif</h2>
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
                                                        Tanggal Perawatan: {{ date('l, d M Y', strtotime(old('start_time', $x->schedule->start_time))) }}
                                                    </div>
                                                    <div>
                                                        Waktu Mulai: {{ date('H:i:s', strtotime($x->schedule->start_time)) }}
                                                    </div>
                                                    <div>
                                                        Waktu Berakhir: {{ date('H:i:s', strtotime($x->schedule->end_time)) }}
                                                    </div>
                                                </div>
                                                <button class="btn btn-sm button-outline-reztya" type="button" data-toggle="modal" data-target="#reschedulePopup">Jadwal Ulang</button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="reschedulePopup" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="reschedulePopupTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            {{-- Form --}}
                                                            <form action="/reschedule/{{ $x->order_detail_id }}" name="order_schedule" id="order_schedule" method="POST" enctype="multipart/form-data">
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
                                                                        <div>
                                                                            <select class="form-select" name="schedule_id" id="schedule_id">
                                                                                @foreach($schedules as $schedule)
                                                                                {{-- @if(old('schedule_id', $x->schedule_id) == $schedule->schedule_id)
                                                                                    <option value="{{ $category->category_id }}" selected>{{ $category->category_name }}</option>
                                                                                @else
                                                                                    <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                                                                                @endif --}}
                                                                                    <option value="{{ $schedule->schedule_id }}" {{ $schedule->schedule_id == $x->schedule_id ? 'selected' : '' }}> {{ date('l, d M Y', strtotime($schedule->start_time)) }} | {{ date('H:i:s', strtotime($schedule->start_time)) }} - {{ date('H:i:s', strtotime($schedule->end_time)) }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Batal</button>
                                                                    {{-- <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Batal</button> --}}
                                                                    {{-- data-dismiss="modal" --}}
                                                                    <button type="submit" class="btn btn-success">Simpan</button>
                                                                </div>
                                                            </form>
                                                        </div>
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
                <div class="d-flex justify-content-center">
                    <a href="/finish-order/{{ $y->order_id }}" class="btn btn-success" type="button" onclick="return confirm('Apakah Anda yakin ingin menyelesaikan pesanan?')">Selesaikan Pesanan</a>
                </div>
            @endforeach
        </div>
    @else
        Tidak ada pesanan yang sedang aktif
    @endif
{{-- @endif --}}
<script>
    $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus');
    });

    
    $('#myModal').on('hidden.bs.modal', function () {
        window.location.reload();
    });
</script>
@endsection