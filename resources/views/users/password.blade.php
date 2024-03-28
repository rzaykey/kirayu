@extends('superadmin.main')

@section('container')
    <div class="container py-5 h-50">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-9 mb-4 mb-lg-0">
                <div class="card shadow mb-9" style="border-radius: .15rem;">
                    <form method="post" action="/ubah/password/{{ $user[0]->id }}">
                        @method('put')
                        @csrf
                        <div class="col">
                            <div class="mb-2 mt-3">
                                <div class="text-center">
                                    @if ($user[0]->image)
                                        <img src=" {{ asset('storage/' . $user[0]->image) }}" alt="avatar"
                                            class="rounded-circle img-fluid" style="height:200px;width: 200px;">
                                    @else
                                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp"
                                            alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                                    @endif
                                    <h5 class="my-3">Ubah Password</h5>
                                    <p class="text-muted mb-3">{{ $user[0]->name }}</p>
                                    <input type="hidden" id="id" name="id">
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex  justify-content-center h-100 d-flex align-items-center"
                            style="align-content: center">
                            <div class="col col-lg-9 mb-4 mb-lg-0">
                                <div class="mb-4">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Password Sekarang</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <input id="current_password" type="password"
                                                    class="form-control @error('current_password') is-invalid @enderror"
                                                    name="current_password" required autocomplete="current_password">

                                                @error('current_password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Password Baru</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <input id="password" type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password" required autocomplete="new-password">

                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Confirm Password</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <input id="password-confirm" type="password" class="form-control"
                                                    name="password_confirmation" required autocomplete="new-password">
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center mb-2">
                                            <button type="submit" class="btn btn-info">
                                                <span data-feather="save"></span> Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function previewImage() {

            frame.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
@endsection
