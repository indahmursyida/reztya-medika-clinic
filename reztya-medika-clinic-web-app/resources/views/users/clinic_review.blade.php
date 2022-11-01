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
        <div class="pt-3">
            <div class="d-flex justify-content-center">
                <p class="h5 fw-bold unselectable font-alander-reztya">Tambah Tinjauan Klinik</p>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-2">
            <div class="card bg-white outline-reztya card-sign">
                <div class="card-body">
                    <div class="card-title font-futura-reztya">
                        Order No: 01
                    </div>
                    <hr>
                    <form action="/signin" method="POST">
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
        var heightLimit = 400; /* Maximum height: 200px */

        textarea.oninput = function() {
            textarea.style.height = ""; /* Reset the height*/
            textarea.style.height = Math.min(textarea.scrollHeight, heightLimit) + "px";
        };
    </script>
@endsection
