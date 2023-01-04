@extends('layout/main')

@section('title', 'Cart')

@section('container')

<div class="d-flex justify-content-center">
    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show font-futura-reztya" style="width:90%;" role="alert">
        {{$errors->first()}}
        <button type="button" class="btn btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show font-futura-reztya" style="width:90%; role=" alert">
        {{session('success')}}
        <button type="button" class="btn btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
</div>
@php
use Carbon\Carbon;
@endphp
@if($cart != null)
<div class="d-flex justify-content-center">
    <div class="border outline-reztya rounded-4 p-5 font-futura-reztya" style="margin-bottom:100px; width:90%;">
        <div class="pt-4">
            <div class="py-3 d-flex justify-content-center">
                <p class="h5 fw-bold unselectable font-alander-reztya">Keranjang</p>
            </div>
        </div>
        @if(!$cart->isEmpty())
        <div class="d-flex flex-column">
            <div class="container">
                @foreach($cart as $item)
                @if($item->service_id)
                @if($printServiceOnce == false)
                <div class="row">
                    <div class="col d-flex justify-content-center">
                        <h5 class="mb-0">Perawatan</h5>
                    </div>
                    <div class="col-5">
                    </div>
                    <div class="col">
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
                        <img src="{{ asset('storage/' . $item->service->image_path) }}" alt="" width="100px" height="100px">
                    </div>
                    <div class="col-5 d-flex flex-column justify-content-center">
                        <p class="fw-bold m-0">{{ $item->service->name }}</p>
                        <div style="color: #00A54F;">
                            Tempat Perawatan
                        </div>
                        @if($item->home_service == 1)
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
                            {{ Carbon::parse($item->schedule->start_time)->translatedFormat('l, d F Y') }} | {{ Carbon::parse($item->schedule->start_time)->translatedFormat('H.i') }} - {{ Carbon::parse($item->schedule->end_time)->translatedFormat('H.i') }}
                        </div>
                    </div>
                    <div class="col">Rp{{ number_format($item->service->price, 2) }}</div>
                    <div class="col text-center">
                        <button data-toggle="modal" data-target="#editSchedulePopup-{{$item->cart_id}}" class="btn button-outline-reztya rounded-2 btn-sm me-3 btn-edit" title="Edit Perawatan">
                            <i class="fa-regular fa-pen-to-square pt-1"></i>
                        </button>
                        <a href="/remove-cart/{{ $item->cart_id }}" class="btn btn-outline-danger rounded-2 btn-sm btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus perawatan {{ $item->service->name }}?')" title="Hapus Perawatan">
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
                                            <input type="hidden" id="cart_id" name="cart_id" value="{{ $item->cart_id }}">
                                            <input type="hidden" id="old_schedule" name="old_schedule" value="{{ $item->schedule->start_time }}">
                                            <input type="hidden" id="old_schedule_id" name="old_schedule_id" value="{{ $item->schedule_id }}">
                                            <input type="hidden" id="service_name" name="service_name" value="{{ $item->service->name }}">
                                            <input type="hidden" id="order_id" name="order_id" value="{{ $item->order_id }}">

                                            <div>
                                                <div class="mb-2 text-start">
                                                    Pilih Jadwal yang Tersedia
                                                </div>
                                                <div class="mb-3">
                                                    <select class="form-select shadow-none" name="schedule_id" id="schedule_id">
                                                        @foreach($schedules as $schedule)
                                                        @if($schedule->schedule_id == $item->schedule_id)
                                                        <option hidden selected value="{{$item->schedule_id}}">{{ Carbon::parse($schedule->start_time)->translatedFormat('l, d F Y') }} | {{ Carbon::parse($schedule->start_time)->translatedFormat('H.i') }} - {{ Carbon::parse($schedule->end_time)->translatedFormat('H.i') }}</option>
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
                                                    <select class="form-select shadow-none" id="home_service" name="home_service">
                                                        @if($item->home_service == 1)
                                                        <option value="1" selected hidden>
                                                            Rumah ({{ Auth::user()->address }})
                                                        </option>
                                                        <option value="0">
                                                            Klinik Reztya Medika
                                                        </option>
                                                        @else
                                                        <option value="1">
                                                            Rumah ({{ Auth::user()->address }})
                                                        </option>
                                                        <option value="0" selected hidden>
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
                </div>
                @php
                $totalPrice += $item->service->price;
                @endphp
                @endif
                @endforeach
            </div>
        </div>
        @php
        $product_exist = 0
        @endphp
        <div class="d-flex flex-column">
            <div class="container">
                @foreach ($cart as $item)
                @if($item->product_id)
                @php
                $product_exist = 1
                @endphp
                @if($printProductOnce == false)
                <div class="row">
                    <div class="col d-flex justify-content-center">
                        <h5 class="mb-0" style="padding-right: 17%">Produk</h5>
                    </div>
                    <div class="col-5">
                    </div>
                    <div class="col">
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
                        <img src="{{ asset('storage/' . $item->product->image_path)}}" width="100px" height="100px">
                    </div>
                    <div class="col-5 d-flex flex-column justify-content-center">
                        <div class="d-flex">
                            <p class="fw-bold m-0">{{ $item->product->name }} {{ $item->product->size }}</p>
                        </div>
                        <div style="color: #00A54F;">
                            Harga Satuan
                        </div>
                        <div>
                            Rp{{ number_format($item->product->price, 2) }}
                        </div>
                        <div style="color: #00A54F;">
                            Kuantitas
                        </div>
                        <div>
                            {{ $item->quantity }}
                        </div>
                    </div>
                    <div class="col">Rp{{ number_format($item->product->price * $item->quantity, 2) }}</div>
                    <div class="col text-center">
                        <button type="button" data-toggle="modal" data-target="#editQuantityPopup-{{$item->cart_id}}" class="btn button-outline-reztya rounded-2 btn-sm me-3 btn-edit" title="Edit Produk">
                            <i class="fa-regular fa-pen-to-square pt-1"></i>
                        </button>
                        <a href="/remove-cart/{{ $item->cart_id }}" id="delete-button" class="btn btn-outline-danger rounded-2 btn-sm btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus produk {{ $item->product->name }}?')" title="Hapus Produk">
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
                                                    <input type="number" class="@error('p_quantity') is-invalid @enderror form-control shadow-none form-quantity" id="quantity" name="quantity" value="{{ old('quantity', $item->quantity) }}" min="1" max="{{ $item->product->stock }}">
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
                    </div>
                </div>
                @php
                $totalPrice += $item->product->price * $item->quantity;
                @endphp
                @endif
                @endforeach
            </div>
        </div>
        @if ($product_exist == 1)
        <form action="/create-order" method="post" enctype="multipart/form-data">
            @csrf
            <div class="container">
                <div class="row mt-2">
                    <div class="col">
                    </div>
                    <div class="col-5">
                        <p class="mb-2 fw-bold">Opsi Pengiriman</p>
                        <select class="form-select shadow-none w-75 @error('delivery_service') is-invalid @enderror" id="delivery_service" name="delivery_service">
                            @if (old('delivery_service'))
                            @if(old('delivery_service') == 1)
                            <option value="1" selected>
                                Delivery
                            </option>
                            <option value="0">
                                Self-Pickup
                            </option>
                            @elseif(old('delivery_service') == 0)
                            <option value="1">
                                Delivery
                            </option>
                            <option value="0" selected>
                                Self-Pickup
                            </option>
                            @endif
                            @else
                            <option value="" selected hidden>Pilih Tipe Pengiriman</option>
                            <option value="1">
                                Delivery
                            </option>
                            <option value="0">
                                Self-Pickup
                            </option>
                            @endif
                        </select>
                        @error('delivery_service')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                        <div id="delivery_choice" style="{{old('delivery_service') == 1 ? 'display: block;' : 'display: none;'}}">
                            <div class="d-flex mt-2">
                                <p class="m-0 me-1">Tujuan ke</p>
                                <p class="mb-0 fw-bold">{{$origin[1]}}, {{$origin[0]}}</p>
                                <input type="hidden" name="origin" value="{{$origin[1]}}, {{$origin[0]}}">
                            </div>
                            <div class="d-flex">
                                <p class="mb-0 me-1">Total berat</p>
                                @if ($weight / 1000 != ceil($weight / 1000))
                                <p class="mb-0 fw-bold">{{$weight / 1000}}kg ≈ {{ceil($weight / 1000)}}kg</p>
                                @else
                                <p class="mb-0 fw-bold">{{$weight / 1000}}kg</p>
                                @endif
                                <input type="hidden" name="weight" value="{{ceil($weight / 1000)}}">
                            </div>
                            <div class="mt-1 mb-2">
                                <select onchange="includeFee(this.value)" id="cost" name="cost" class="form-select shadow-none w-75  @error('cost') is-invalid @enderror">

                                    @foreach($costs as $cost)
                                    <option value="" disabled selected hidden>Pilih Jasa Pengiriman</option>
                                    <option value="{{ json_encode($cost) }} ">JNE {{$cost->service}} ({{$cost->cost[0]->etd}} hari)</option>
                                    @endforeach
                                </select>
                                @error('cost')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col" id="deliveryFeeText">
                    </div>
                    <div class="col">
                    </div>
                </div>
            </div>
            <hr style="width: 92%; margin-right: 4%; margin-left: 4%;" />
            <div class="container">
                <div class="row mt-2">
                    <div class="col d-flex justify-content-center">
                        <h5 class="mb-0">Total Harga</h5>
                    </div>
                    <div class="col-5">
                    </div>
                    <div class="col d-flex align-items-center">
                        <input type="hidden" value="{{$totalPrice}}" id="totalPrice">
                        <h5 class="mb-0" id="totalPriceText">Rp{{ number_format($totalPrice, 2) }}</h5>
                    </div>
                    <div class="col d-flex justify-content-center align-items-center">
                        <button type="submit" class="btn button-outline-reztya">Buat Pesanan</button>
                    </div>
                </div>
            </div>
        </form>
        @else
        <hr style="width: 92%; margin-right: 4%; margin-left: 4%;" />
        <div class="container">
            <div class="row mt-2">
                <div class="col d-flex justify-content-center">
                    <h5 class="mb-0">Total Harga</h5>
                </div>
                <div class="col-5">
                </div>
                <div class="col d-flex align-items-center">
                    <input type="hidden" value="{{$totalPrice}}" id="totalPrice">
                    <h5 class="mb-0" id="totalPriceText">Rp{{ number_format($totalPrice, 2) }}</h5>
                </div>
                <div class="col d-flex justify-content-center align-items-center">
                    <a href="/create-order" class="btn button-outline-reztya">Buat Pesanan</a>
                </div>
            </div>
        </div>
        @endif
        @else
        Keranjang Anda masih kosong.
        @endif
    </div>
</div>
@else
Tidak dapat mengakses halaman ini.
@endif
<script>
    $(document).ready(function() {

        // $("#delivery_service").change(
        //     function () {
        //         alert("Textbox value is changed");
        //     }
        // );

        // $('#update_schedule').on('change', function(){
        //     window.location.reload();
        // });
        // $('#update_quantity').on('change', function(){
        //     window.location.reload();
        // });
        $('#delivery_service').change(
            function() {
                if (this.value == 1) {
                    $('#delivery_choice').show();
                    document.getElementById('cost').value = "";
                } else {
                    $('#delivery_choice').hide();
                    var total = parseInt(document.getElementById('totalPrice').value);
                    document.getElementById('totalPriceText').innerHTML = "Rp" + total.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",") + ".00";
                    document.getElementById('deliveryFeeText').innerHTML = "";
                }
            }
        );
    });

    function includeFee(json_string) {
        let json = JSON.parse(json_string);
        let weight = {
            !!json_encode(ceil($weight / 1000)) !!
        };
        let delivery_fee = json.cost[0].value * parseInt(weight);

        var total = parseInt(document.getElementById('totalPrice').value);
        total += delivery_fee;
        document.getElementById('totalPriceText').innerHTML = "Rp" + total.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",") + ".00";
        document.getElementById('deliveryFeeText').innerHTML = "Rp" + delivery_fee.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",") + ".00";
    }

    // document.getElementById('delete-button').addEventListener('click', function(e) {
    //     e.preventDefault();

    //     axios.delete('/remove-cart/' + this.dataset.id)
    //         .then(response => {

    //         });
    //     });
</script>
@endsection