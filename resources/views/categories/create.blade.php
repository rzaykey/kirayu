@extends('superadmin.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom">
        <h1 class="">Manajemen Kategori</h1>
        <!-- Breadcrumb -->
        <nav class="d-flex">
            <h6 class="mb-0">
                <a href="/dashboard" class="text-reset">Manajemen Kategori</a>
                <span>/</span>
                <a href="/categories" class="text-reset">Kategori</a>
                <span>/</span>
                <a href="/categories/create" class="text-reset"><u>Tambah Kategori</u></a>
            </h6>
        </nav>
        <!-- Breadcrumb -->
    </div>
    <div class="container py-5 h-50">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-9 mb-4 mb-lg-0">
                <div class="card shadow mb-9">
                    <div class="row d-flex  justify-content-center h-100 d-flex align-items-center"
                        style="align-content: center">
                        <div class="col col-lg-9 mb-4 mb-lg-0">
                            <div class="d-flex justify-content-center mb-3 mt-3">
                                <h2>Tambah Kategori</h2>
                            </div>
                            <hr>
                            <div class=" mb-4">
                                <form method="POST" action="/categories">
                                    <div class="card-body">
                                        @csrf
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Nama Kategori</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                                    name="name" required value="{{ old('name') }}">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center mb-2">
                                            <button type="submit" class="btn btn-info">
                                                <span data-feather="save"></span> Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
