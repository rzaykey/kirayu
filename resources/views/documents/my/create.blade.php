@extends('superadmin.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom">
        <h1 class="">Tambah File</h1>
        <!-- Breadcrumb -->
        <nav class="d-flex">
            <h6 class="mb-0">
                <a href="/document/my" class="text-reset">File</a>
                <span>/</span>
                <a href="/document/my/create" class="text-reset"><u>Tambah File</u></a>
            </h6>
        </nav>
        <!-- Breadcrumb -->
    </div>
    <div class="container py-5 h-50">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-9 mb-4 mb-lg-0">
                <div class="card shadow mb-9">
                    <div class="d-flex justify-content-center mb-1 mt-4">
                        <h2>Tambah File</h2>
                    </div>
                    <hr>
                    <div class="row d-flex  justify-content-center h-100 d-flex align-items-center"
                        style="align-content: center">
                        <div class="col col-lg-9 mb-4 mb-lg-0">
                            <div class="mb-2">
                                <form method="POST" action="/document/my/" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="mb-3">
                                            <div class="mb-3">
                                                <label for="keterangan" class="form-label">Keterangan</label>
                                                <input type="text"
                                                    class="form-control @error('keterangan') is-invalid @enderror"
                                                    id="keterangan" name="keterangan" required
                                                    value="{{ old('keterangan') }}">
                                                @error('keterangan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <label for="location_id" class="form-label">Location</label>
                                                    <select class="form-select @error('location_id') is-invalid @enderror"
                                                        name="location_id" value="{{ old('location_id') }}">
                                                        @foreach ($units as $units)
                                                            <option value="{{ $units->id }}">{{ $units->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('units_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
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
                                                        <input
                                                            class="mb-3 form-control @error('images') is-invalid @enderror"
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
    </div>
@endsection
