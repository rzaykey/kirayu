@extends('superadmin.main')

@section('container')
    <div class="container py-5 h-50">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-9 mb-4 mb-lg-0">
                <div class="card shadow mb-9" style="border-radius: .15rem;">
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show col-lg-3" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="col">
                        <div class="mb-2">
                            <div class="card-body text-center">
                                @if ($user[0]->image)
                                    <img src=" {{ asset('storage/' . $user[0]->image) }}" alt="avatar"
                                        class="rounded-circle img-fluid" style="height:200px;width: 200px;">
                                @else
                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp"
                                        alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                                @endif
                                <h5 class="my-3">{{ $user[0]->name }}</h5>
                                <p class="text-muted mb-3">{{ $user[0]->username }}</p>
                                <p class="text-muted mb-3">{{ $user[0]->role->role_name }} | {{ $user[0]->unit->name }}</p>
                                <div class="d-flex justify-content-center mb-2">
                                    <a href="/profile/{{ $user[0]->id }}/edit/" type="button" class="btn btn-warning">
                                        <span data-feather="edit"></span> Edit</a>
                                </div>
                                @if (session()->has('success'))
                                    <div class="alert alert-success alert-dismissible fade show col-lg-3" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
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
                                            <p class="text-muted mb-0">{{ $user[0]->name }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Email</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{ $user[0]->email }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Role</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{ $user[0]->role->role_name }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Tanggal Pembuatan</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{ $user[0]->created_at }}</p>
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
