@extends('superadmin.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="">Kategori</h1>
        <!-- Breadcrumb -->
        <nav class="d-flex">
            <h6 class="mb-0">
                <a href="/dashboard" class="text-reset">Home</a>
                <span>/</span>
                <a href="/categories" class="text-reset">Kategori</a>
                <span>/</span>
                <a href="" class="text-reset"><u>Ubah Kategori</u></a>
            </h6>
        </nav>
        <!-- Breadcrumb -->
    </div>
    <div class="container py-5 h-50">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-9 mb-4 mb-lg-0">
                <div class="card shadow mb-9 mt-3" style="border-radius: .15rem;">
                    <form method="post" action="/categories/{{ $categories->id }}" enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <div class="col">
                            <div class="row d-flex  justify-content-center h-100 d-flex align-items-center"
                                style="align-content: center">
                                <div class="col col-lg-9 mb-4 mb-lg-0">
                                    <div class="d-flex justify-content-center mb-3 mt-3">
                                        <h2>Edit Kategori</h2>
                                    </div>
                                    <hr>
                                    <div class="mb-4">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <p class="mb-0">Nama Kategori</p>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="text"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        id="name" name="name" required
                                                        value="{{ old('name', $categories->name) }}">
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="d-flex justify-content-center mb-2">
                                            <button type="submit" class="btn btn-info">
                                                <span data-feather="save"></span> Simpan</button>
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
    @endsection
