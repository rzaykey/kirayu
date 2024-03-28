@extends('superadmin.main')

@section('container')
    <div class="container py-5 h-50">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-9 mb-4 mb-lg-0">
                <div class="card shadow mb-9" style="border-radius: .15rem;">
                    <form method="post" action="/users/{{ $user->id }}" enctype="multipart/form-data"
                        enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <div class="col">
                            <div class="mb-2">
                                <div class="card-body text-center">
                                    @if ($user->image)
                                        <img src=" {{ asset('storage/' . $user->image) }}" alt="avatar"
                                            class="rounded-circle img-fluid" style="height:200px;width: 200px;">
                                    @else
                                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp"
                                            alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                                    @endif
                                    <h5 class="my-3">{{ $user->name }}</h5>
                                    <div class="d-flex justify-content-center mb-2">
                                        <button type="submit" class="btn btn-info">
                                            <span data-feather="save"></span> Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex  justify-content-center h-100 d-flex align-items-center"
                            style="align-content: center">
                            <div class="col col-lg-9 mb-4 mb-lg-0">
                                <div class="mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Full Name</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                                    name="name" required value="{{ old('name', $user->name) }}">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Username</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text"
                                                    class="form-control @error('username') is-invalid @enderror"
                                                    id="username" name="username" required
                                                    value="{{ old('username', $user->username) }}">
                                                @error('username')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Email</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text"
                                                    class="form-control @error('email') is-invalid @enderror" id="email"
                                                    name="email" required value="{{ old('email', $user->email) }}">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <hr>
                                        @if ($user->id !== auth()->user()->id)
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <p class="mb-0">Jabatan</p>
                                                </div>
                                                <div class="col-sm-9">
                                                    <select class="form-select" name="role_id">
                                                        @foreach ($roles as $role)
                                                            @if (old('role_id', $user->role_id) == $role->id)
                                                                <option value="{{ $role->id }}" selected>
                                                                    {{ $role->role_name }}
                                                                </option>
                                                            @else
                                                                <option value="{{ $role->id }}">{{ $role->role_name }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    @error('role_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <hr>
                                        @else
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <p class="mb-0">Jabatan</p>
                                                </div>
                                                <div class="col-sm-9">
                                                    <select class="form-select" name="role_id" disabled>
                                                        @foreach ($roles as $role)
                                                            @if (old('role_id', $user->role_id) == $role->id)
                                                                <option value="{{ $role->id }}" selected>
                                                                    {{ $role->role_name }}
                                                                </option>
                                                            @else
                                                                <option value="{{ $role->id }}">{{ $role->role_name }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    @error('role_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <hr>
                                        @endif
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Unit</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <select class="form-select" name="unit_id">
                                                    @foreach ($units as $unit)
                                                        @if (old('unit_id', $user->unit_id) == $unit->id)
                                                            <option value="{{ $unit->id }}" selected>
                                                                {{ $unit->name }}
                                                            </option>
                                                        @else
                                                            <option value="{{ $unit->id }}">{{ $unit->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('unit_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <input type="hidden" name="oldImage" value="{{ $user->image }}">
                                                <label for="image" class="form-label">Photo</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input class="form-control @error('image') is-invalid @enderror"
                                                    type="file" id="image" name="image" onchange="previewImage()">
                                                @error('image')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div class="col card-body d-blok text-center">
                                                    <img src="" class="img-preview img-fluid col-sm-5"
                                                        id="frame"
                                                        style="max-height: 500px; overflow:hidden; width: 300px;">
                                                    <img class="img-preview img-fluid">
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
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
