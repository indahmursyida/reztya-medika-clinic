@extends('layout/main')
@section('title', 'Tinjauan Klinik')

@section('container')
    <div class="unselectable container bg-white">
        @if(session('')))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{session('')}}
                <button type="button" class="btn btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="pt-2">
            <div class="d-flex justify-content-center">
                <p class="h5 fw-bold unselectable font-alander-reztya">Tambah Tinjauan Klinik</p>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-2 mb-5">
            <div class="card bg-white outline-reztya card-sign">
                <div class="card-body">
                    <div class="row card-title font-futura-reztya">
                        <div class="col-7">
                            Order No: 01
                        </div>
                        <div class="col-5">
                            <div class="float-end">
                                Tanggal: 01-01-2001
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row card-title font-futura-reztya">
                        <div class="col-7">
                            <p>Products:</p>
                            @if(count($orderDetail->product_id) < 1)
                                <p>Empty</p>
                            @else
                                @foreach($orderDetail as $product)
                                    <p>{{$product->product_id}}</p> x<p>{{$product->quantity}}</p>
                                @endforeach
                            @endif
                        </div>
                        <div class="col-5">
                            <div class="float-end">
                                <p>Services:</p>
                                @if(count($orderDetail->service_id) < 1)
                                    <p>Empty</p>
                                @else
                                    @foreach($orderDetail as $service)
                                        <p>{{$service->service_id}}</p>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>
                    <form action="/order-detail/1/add-clinic-review" method="POST">
                        @csrf
                        <div class="form-floating mb-3">
                            <textarea autofocus placeholder="Tinjauan Klinik" id="floatingReview" class="shadow-none form-control @error('review') is-invalid @enderror" name="review">{{old('review')}}</textarea>
                            <label for="floatingReview" class="font-futura-reztya">Tinjauan Klinik</label>
                            @error('review')
                            <div class="invalid-feedback">
                                Tinjauan klinik wajib diisi
                            </div>
                            @enderror
                        </div>
                        <input hidden type="hidden" value="">
                        <input hidden type="hidden" value="">
                        <div class="d-grid">
                            <button class="btn button-outline-reztya font-futura-reztya" type="submit">Kirim Tinjauan Klinik</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        var textarea = document.getElementById("floatingReview");
        var heightLimit = 800;

        textarea.oninput = function() {
            textarea.style.height = "";
            textarea.style.height = Math.min(textarea.scrollHeight, heightLimit) + "px";
        };
    </script>
@endsection
