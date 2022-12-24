@extends('layout/main')

@section('title', 'Cart')

@section('container')
<!-- @if (session('success'))
<div class="alert alert-success" id="success-alert">
    <strong> {{session()->get('message')}} </strong>
</div>
@endif -->
@php
use Carbon\Carbon;
@endphp
@if($cart != null)
<div class="border outline-reztya rounded-4 p-5 font-futura-reztya">
    <h2 class="my-3 text-center font-alander-reztya unselectable">Cart</h2>
        @if(!$cart->isEmpty())
        <div class="d-flex flex-column">
            <div class="container">
                <div>
                    @foreach($cart as $item)
                        @if($item->service_id)
                            @if($printServiceOnce == false)
                                <h5 class="mb-0">Perawatan</h5>
                                @php
                                    $printServiceOnce = true;
                                @endphp
                            @endif
                            <div class="row">
                                <div class="col">
                                    <img src="{{ asset('storage/' . $item->service->image_path) }}" alt="" width="100px" height="100px">
                                </div>
                                <div class="col">
                                    <b>{{ $item->service->name }}</b>
                                    @if($item->home_service == 1)
                                    <div>
                                        Tempat Perawatan: Rumah ({{ Auth::user()->address }})
                                    </div>
                                    @else
                                    <div>
                                        Tempat Perawatan: Klinik Reztya Medika
                                    </div>
                                    @endif
                                    <div>
                                        Tanggal Perawatan: {{ Carbon::parse($item->schedule->start_time)->translatedFormat('l, d F Y') }}
                                    </div>
                                    <div>
                                        Waktu Mulai: {{ Carbon::parse($item->schedule->start_time)->translatedFormat('H.i') }}
                                    </div>
                                    <div>
                                        Waktu Berakhir: {{ Carbon::parse($item->schedule->end_time)->translatedFormat('H.i') }}
                                    </div>
                                </div>
                                <div class="col"></div>
                                <div class="col">Rp{{ number_format($item->service->price, 2) }}</div>
                                <div class="col">
                                    <button data-toggle="modal" data-target="#editSchedulePopup-{{$item->cart_id}}" class="btn button-color rounded-2 btn-sm me-3 btn-edit" title="Edit Perawatan">
                                        <i class="fa-regular fa-pen-to-square pt-1"></i>
                                    </button>
                                    <a href="/remove-cart/{{ $item->cart_id }}" class="btn btn-danger rounded-2 btn-sm btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus perawatan {{ $item->service->name }}?')" title="Hapus Perawatan">
                                        <i class="fa-solid fa-trash pt-1"></i>
                                    </a>
                                    <div class="modal fade" id="editSchedulePopup-{{$item->cart_id}}" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="editScheduleTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                {{-- Form --}}
                                                <form action="/update-schedule/{{ $item->cart_id }}" method="POST" enctype="multipart/form-data">
                                                    @method('put')
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editSchedulePopupLongTitle">{{ $item->service->name }}</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-2">
                                                            Pilih Jadwal yang Tersedia
                                                        </div>
                                                        <input type="hidden" id="cart_id" name="cart_id" value="{{ $item->cart_id }}">
                                                        <input type="hidden" id="old_schedule" name="old_schedule" value="{{ $item->schedule->start_time }}">
                                                        <input type="hidden" id="old_schedule_id" name="old_schedule_id" value="{{ $item->schedule_id }}">
                                                        <input type="hidden" id="service_name" name="service_name" value="{{ $item->service->name }}">
                                                        <input type="hidden" id="order_id" name="order_id" value="{{ $item->order_id }}">
                                                        <div>
                                                            <div>
                                                                <select class="form-select" name="schedule_id" id="schedule_id">
                                                                    @foreach($schedules as $schedule)
                                                                        @if($schedule->schedule_id == $item->schedule_id || $schedule->status == 'Available')
                                                                            <option value="{{ $schedule->schedule_id }}" {{ $schedule->schedule_id == $item->schedule_id ? 'selected' : '' }}> {{ Carbon::parse($schedule->start_time)->translatedFormat('l, d F Y') }} | {{ Carbon::parse($schedule->start_time)->translatedFormat('H.i') }} - {{ Carbon::parse($schedule->end_time)->translatedFormat('H.i') }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <label for="home_service" class="my-2">Pilih Tempat Layanan</label>
                                                            <div>
                                                                <select class="form-select" id="home_service" name="home_service">
                                                                    @if($item->home_service == 1)
                                                                    <option value="1" selected>
                                                                        Rumah ({{ Auth::user()->address }})
                                                                    </option>
                                                                    <option value="0">
                                                                        Klinik Reztya Medika
                                                                    </option>
                                                                    @else
                                                                    <option value="1">
                                                                        Rumah ({{ Auth::user()->address }})
                                                                    </option>
                                                                    <option value="0" selected>
                                                                        Klinik Reztya Medika
                                                                    </option>
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-danger me-3" data-dismiss="modal">Batal</button>
                                                        <button type="submit" id="update_schedule" class="btn btn-success">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                            @php
                                $totalPrice += $item->service->price;
                            @endphp
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex flex-column">
            <table class="table">
                <tbody>
                    @foreach ($cart as $item)
                        @if($item->product_id)
                            @if($printProductOnce == false)
                                <h5>Produk</h5>
                                @php
                                    $printProductOnce = true;
                                @endphp
                            @endif
                            <tr>
                                <td>
                                    <img src="{{ asset('storage/' . $item->product->image_path)}}" width="100px" height="100px">
                                </td>
                                <td>
                                    <b>{{ $item->product->name }}</b>
                                    <div>
                                    Rp{{ number_format($item->product->price, 2) }}
                                    </div>
                                </td>
                                <td>
                                    Kuantitas: {{ $item->quantity }}
                                </td>
                                <td>Rp{{ number_format($item->product->price * $item->quantity, 2) }}</td>
                                <td>
                                    <button type="button" data-toggle="modal" data-target="#editQuantityPopup-{{$item->cart_id}}" class="btn button-color rounded-2 btn-sm me-3 btn-edit" title="Edit Produk">
                                        <i class="fa-regular fa-pen-to-square pt-1"></i>
                                    </button>
                                    <a href="/remove-cart/{{ $item->cart_id }}" class="btn btn-danger rounded-2 btn-sm btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus produk {{ $item->product->name }}?')" title="Hapus Produk">
                                        <i class="fa-solid fa-trash pt-1"></i>
                                    </a>
                                    <div class="modal fade" id="editQuantityPopup-{{$item->cart_id}}" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="editQuantityTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                {{-- Form --}}
                                                <form action="/update-quantity/{{ $item->cart_id }}" method="POST" enctype="multipart/form-data">
                                                    @method('put')
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editQuantityPopupLongTitle">{{ $item->product->name }}</h5>
                                                    </div>
                                                    <div class="modal-body container d-flex align-items-center">
                                                        <div class="me-5">
                                                            Kuantitas
                                                        </div>
                                                        <div>
                                                            <!-- <input type="hidden" id="cart_id" name="cart_id" value={{ $item->order_detail_id }}> -->
                                                            <div>
                                                                <input type="number" class="@error('p_quantity') is-invalid @enderror form-control form-quantity" id="quantity" name="quantity" value="{{ old('quantity', $item->quantity) }}" min="1" max="{{ $item->product->stock }}">
                                                            </div>
                                                            @error('quantity')
                                                            <div class="invalid-feedback">
                                                                Kuantitas harus diisi dengan angka
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-danger me-3" data-dismiss="modal">Batal</button>
                                                        <button type="submit" id="update_quantity" class="btn btn-success">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @php
                                $totalPrice += $item->product->price * $item->quantity;
                            @endphp
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex mt-2">
            <div class="d-flex justify-content-between">
                <h5 style="margin-right: 70vh">Total Harga</h5>
                <h5 style="margin-right: 100px">Rp{{ number_format($totalPrice, 2) }}</h5>
            </div>
            <a href="/create-order" class="btn button-outline-reztya">Buat Pesanan</a>
        </div>
        
        {{-- <div class="d-flex justify-content-center">
            <!-- <form action="/create-order/{{Auth::user()->user_id}}" method="post">
                @csrf
                <button class="btn button-outline-reztya" type="submit">Buat Pesanan</button>
            </form> -->
        </div> --}}
    @else
        Keranjang Anda masih kosong.
    @endif
@else
    Tidak bisa
@endif
</div>
<script>
    $('#update_schedule').on('change', function(){
        window.location.reload();
    });
    $('#update_quantity').on('change', function(){
        window.location.reload();
    });
</script>
@endsection
