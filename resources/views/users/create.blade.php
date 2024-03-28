@extends('superadmin.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom">
        <h1 class="">Manajemen User</h1>
        <!-- Breadcrumb -->
        <nav class="d-flex">
            <h6 class="mb-0">
                <a href="/" class="text-reset">Manajemen User</a>
                <span>/</span>
                <a href="/users" class="text-reset">User</a>
                <span>/</span>
                <a href="/users/create" class="text-reset"><u>Tambah User</u></a>
            </h6>
        </nav>
        <!-- Breadcrumb -->
    </div>
    <div class="container py-5 h-50">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-9 mb-4 mb-lg-0">
                <div class="card shadow mb-9">
                    <div class="col">
                        <div class="mb-5">
                            <div class="card-body text-center">
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp"
                                    alt="avatar" class="rounded-circle img-fluid mb-3" style="width: 150px;">
                            </div>
                        </div>
                    </div>
                    <div class="row d-flex  justify-content-center h-100 d-flex align-items-center"
                        style="align-content: center">
                        <div class="col col-lg-9 mb-2 mb-lg-0">
                            <div class="mb-2">
                                <form method="POST" action="/users" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="mb-3">
                                            <div class="mb-3">
                                                <input type="hidden" name="remember_token" id="remember_token"
                                                    value="{{ csrf_token() }}" />
                                                <label for="name" class="form-label">Nama</label>
                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                                    name="name" required value="{{ old('name') }}">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="username" class="form-label">Username</label>
                                                <input type="text"
                                                    class="form-control @error('username') is-invalid @enderror"
                                                    id="username" name="username" required value="{{ old('username') }}">
                                                @error('username')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                id="exampleInputEmail1" aria-describedby="emailHelp" name="email" required
                                                value="{{ old('email') }}">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">Password</label>
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                id="exampleInputPassword1" name="password" required
                                                value="{{ old('password') }}">
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-auto">
                                            <label for="role" class="form-label">Jabatan</label>
                                            <select class="form-select @error('role_id') is-invalid @enderror"
                                                name="role_id" required value="{{ old('role_id') }}">
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->role_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('role_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-auto">
                                            <label for="unit" class="form-label">Unit</label>
                                            <select class="form-select @error('unit_id') is-invalid @enderror"
                                                name="unit_id" required value="{{ old('unit_id') }}">
                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit->id }}">{{ $unit->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('unit_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col">
                                            <label for="image" class="form-label">Photo</label>
                                            <input class="mb-3 form-control @error('image') is-invalid @enderror"
                                                type="file" id="image" name="image" onchange="previewImage()">
                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="col d-blok card-body text-center">
                                                <img src="" class="img-preview img-fluid mb-3 col-sm-5"
                                                    id="frame"
                                                    style="max-height: 300px; overflow:hidden; width: 300px;">
                                                <img class="img-preview img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center mb-4">
                                        <button type="submit" class="btn btn-info">
                                            <span data-feather="save"></span> Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
