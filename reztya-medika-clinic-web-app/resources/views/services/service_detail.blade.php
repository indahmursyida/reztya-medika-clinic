@extends('layout/main')

@section('title', 'Detail Perawatan')

@section('container')

<div class="container-product border outline-reztya rounded-4 font-futura-reztya py-5">
    <div class="pt-4">
        <div class="py-3 d-flex justify-content-center">
            <p class="h5 fw-bold unselectable font-alander-reztya">Detail Perawatan</p>
        </div>
    </div>
	<form method="post" action="/book-service" enctype="multipart/form-data" novalidate>
		@method('post') @csrf
		<input type="hidden" value="{{ $service->service_id }}" name="service_id" id="service_id">
		<div class="row py-6">
			<div class="col-sm-6 pe-5">
				<img src="{{ asset('storage/' . $service->image_path) }}" class="img-fluid img-thumbnail">
			</div>

			<div class="col-sm-6">
				<div class="btn btn-outline-secondary rounded-pill">{{$service->category->category_name}}</div>
				<h3 class="text-reztya my-3">{{ $service->name }}</h3>
				<p>Durasi: {{ $service->duration }} menit</p>
				<h5>Rp{{ number_format($service->price, 2) }}</h5>
				<div class="my-5">
					<p>{{ $service->description }}</p>
				</div>
                <label class="form-label" for="schedule_id" class="my-2">Pilih jadwal: </label>
				@if(!$schedules->isEmpty())
                    <div>
                        <select class="form-select @error('schedule_id') is-invalid @enderror" id="schedule_id" name="schedule_id">
                            @foreach($schedules as $schedule) @if(old('schedule_id') == $schedule->schedule_id)
                                <option value="{{ $schedule->schedule_id }}" selected>
                                    {{date('l, d F Y H:i', strtotime( $schedule->start_time ))}}
                                </option>
                            @else
                                <option value="{{ $schedule->schedule_id }}">
                                    {{date('l, d F Y H:i', strtotime( $schedule->start_time ))}}
                                </option>
                            @endif @endforeach
                        </select>
                        @error('schedule_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <label for="home_service" class="my-2">Pilih tempat: </label>
                    <div>
                        @if(Auth::user()->city_id == 350)
                            <select class="form-select @error('home_service') is-invalid @enderror" id="home_service" name="home_service">
                                @if(old('home_service'))
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
                        @else
                            <select class="form-select @error('home_service') is-invalid @enderror" id="home_service" name="home_service">
                                <option value="0" selected>
                                    Klinik Reztya Medika
                                </option>
                                <option value="1" disabled>
                                    Rumah di luar jangkauan
                                </option>
                            </select>
                        @endif
                        @error('home_service')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                @else
                    <div>
                        <select disabled class="form-select" id="schedule_id" name="schedule_id">
                            <option selected>Tidak ada jadwal yang tersedia</option>
                        </select>
                    </div>

                    <label for="home_service" class="my-2">Pilih tempat: </label>
                    <div>
                        <select disabled class="form-select" id="home_service" name="home_service">
                            <option selected>Tidak ada jadwal yang tersedia</option>
                        </select>
                    </div>
                @endif
			</div>
            @if(!$schedules->isEmpty())
                <div class="d-flex justify-content-center pb-5 my-5">
                    <button class="btn btn-success" type="submit"><i class="fa-solid fa-cart-shopping"></i> Tambahkan ke keranjang</button>
                </div>
            @else
                <div class="d-flex justify-content-center pb-5 my-5">
                    <button class="btn btn-dark disabled"><i class="fa-solid fa-cart-shopping"></i> Jadwal tidak tersedia</button>
                </div>
            @endif
		</div>
	</form>
</div>
@endsection
