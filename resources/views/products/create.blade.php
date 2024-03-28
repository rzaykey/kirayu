@extends('superadmin.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom">
        <h1 class="">Tambah Barang</h1>
        <!-- Breadcrumb -->
        <nav class="d-flex">
            <h6 class="mb-0">
                <a href="/products" class="text-reset">Barang</a>
                <span>/</span>
                <a href="/products/create" class="text-reset"><u>Tambah Barang</u></a>
            </h6>
        </nav>
        <!-- Breadcrumb -->
    </div>
    <div class="container py-5 h-50">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="card shadow mb-9">
                <div class="d-flex justify-content-center mb-1 mt-4">
                    <h2>Tambah Barang</h2>
                </div>
                <hr>
                <div class="row d-flex  justify-content-center h-100 d-flex align-items-center"
                    style="align-content: center">
                    <div class="col col-lg-9 mb-4 mb-lg-1">
                        <div class="mb-2">
                            <form method="POST" action="/products" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="mb-3">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nama</label>
                                            <input class="mb-3 form-control @error('name') is-invalid @enderror"
                                                type="text" id="name" name="name">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-0">
                                                    <label for="qty" class="form-label">Jumlah</label>
                                                    <input class="mb-3 form-control @error('qty') is-invalid @enderror"
                                                        type="text" id="qty" name="qty">
                                                    @error('qty')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-0">
                                                    <label for="price" class="form-label">Harga</label>
                                                    <input type="text"
                                                        class="form-control @error('price') is-invalid @enderror"
                                                        id="price" name="price">
                                                    @error('price')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Keterangan</label>
                                            <input type="text"
                                                class="form-control @error('description') is-invalid @enderror"
                                                id="description" name="description" required
                                                value="{{ old('description') }}">
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="categories" class="form-label">Kategori</label>
                                                <select class="form-select @error('categories_id') is-invalid @enderror"
                                                    name="categories_id" value="{{ old('categories_id') }}">
                                                    @foreach ($categories as $categories)
                                                        <option value="{{ $categories->id }}">
                                                            {{ $categories->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('role_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-0">
                                                    <label for="images" class="form-label">Document</label>
                                                    <input class="mb-3 form-control @error('images') is-invalid @enderror"
                                                        type="file" id="images" name="images">
                                                    @error('images')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-0">
                                                    <label for="created_by" class="form-label">Author</label>
                                                    <input type="hidden" class="form-control" id="created_by"
                                                        name="created_by" value="{{ auth()->user()->name }}">
                                                    <input type="text" class="form-control"
                                                        value="{{ auth()->user()->name }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center mb-3">
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
@endsection
