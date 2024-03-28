@extends('superadmin.main')

@section('container')
    <div class="container py-5 h-50">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-9 mb-4 mb-lg-0">
                <div class="card mb-9" bo>
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
                                <p class="text-muted mb-3">{{ $user->role->role_name }}</p>
                                <div class="d-flex justify-content-center mb-2">
                                    <a href="/users/{{ $user->id }}/edit/" type="button" class="btn btn-warning ms-1">
                                        <span data-feather="edit"></span> Edit</a>
                                    <form action="/users/{{ $user->id }}" method="post">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger ms-1"
                                            onclick="return confirm('Apakah yakin ingin menghapus ?')"><span
                                                data-feather="x-circle"></span> Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row d-flex  justify-content-center h-100 d-flex align-items-center"
                        style="align-content: center">
                        <div class="col col-lg-9 mb-4 mb-lg-0">
                            <div class=" mb-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Full Name</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{ $user->name }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Username</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{ $user->username }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Email</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Tanggal Pembuatan</p>
                                        </div>
                                        <div class="col-sm">
                                            <p class="text-muted mb-0">{{ $user->created_at }}</p>
                                        </div>
                                        <div class="col-sm-3">
                                            <p class="mb-0">Terakhir update</p>
                                        </div>
                                        <div class="col-sm">
                                            <p class="text-muted mb-0">{{ $user->created_at }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
